<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\model\order;

use app\model\BaseModel;
use app\model\goods\Goods;
use app\model\goods\GoodsStock;
use think\facade\Cache;

/**
 * 商品库存
 */
class OrderStock extends BaseModel
{

    /**
     * 设置库存原子
     * @param $sku_id
     * @return array
     */
    public function setGoodsSkuStock($sku_id)
    {
        $goods_model = new Goods();
        $goods_sku_condition = array(
            ['sku_id', '=', $sku_id]
        );
        $goods_sku_info = $goods_model->getGoodsSkuInfo($goods_sku_condition, 'stock')['data'] ?? [];

        $stock = $goods_sku_info['stock'];
        //设定商品数量
        $key = "goods_sku_stock".$sku_id;
        //创建连接redis对象
        $redis = Cache::store('redis')->handler();
        $surplus_stock = $redis->llen($key);
        $count = $stock - $surplus_stock;
        for ($i = 1; $i <= $count; $i++) {
            //将商品id push到列表中
            $redis->rPush($key, 1);
        }
        Cache::set('order_goods_sku_stock'.$sku_id, 1);
        return $this->success();

    }

    /**
     * 检测库存原子
     * @param $params
     * @return array
     */
    public function checkOrderSkuStock($params){
        $sku_id = $params['sku_id'];
        $goods_stock_cache = Cache::get('order_goods_sku_stock'.$sku_id);

        if(empty($goods_stock_cache)){
            $this->setGoodsSkuStock($sku_id);
        }
        return $this->success();
    }

    /**
     * 扣除订单库存
     * @param $sku_id
     * @param $num
     * @return array
     */
    public function decOrderStock($sku_id, $num){
        $cache_driver = config('cache')['default'];
        if($cache_driver == 'redis'){//todo  应该会有特定的开关
            $this->checkOrderSkuStock(['sku_id' => $sku_id]);
            $redis = Cache::store('redis')->handler();
            $key = 'goods_sku_stock'.$sku_id;
            $start_num = 0;
            while($start_num < $num){
                $start_num++;
                $item = $redis->lPop($key);
                if (!$item) {
                    return $this->error();
                }
            }
        }

        //扣除库存
        $goods_stock_model = new GoodsStock();
        $stock_result = $goods_stock_model->decStock(['sku_id' => $sku_id, 'num' => $num]);
        if ($stock_result['code'] < 0) {
            return $stock_result;
        }
        return $this->success();

    }

    /**
     * 阻塞式锁
     */
    public function lock()
    {

        $redis = Cache::store('redis')->handler();
        $store = 1000;//库存()
//        $redis = new \Redis();
//        $result = $redis->connect('127.0.0.1', 6379);
        $res = $redis->llen('goods_store');
        echo $res;
        $count = $store - $res;
        for ($i = 0; $i < $count; $i++) {
            $redis->lpush('goods_store', 1);
        }
        echo $redis->llen('goods_store');
    }

}