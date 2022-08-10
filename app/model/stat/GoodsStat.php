<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\model\stat;

use app\model\BaseModel;
use app\model\system\Stat;

/**
 * 统计
 * @author Administrator
 *
 */
class GoodsStat extends BaseModel
{
    /**
     * 用于订单(同与订单支付后调用)
     * @param $params
     */
    public function addGoodsStat($params){

        $stat_model = new Stat();

        $result = $stat_model->addShopStat($params);
        return $result;
    }

    /**
     * 商品增加收藏量
     * @param $params
     */
    public function addGoodsCollectStat($params){
        $stat_model = new Stat();

        $result = $stat_model->addShopStat($params);
        return $result;
    }
}