<?php
// +----------------------------------------------------------------------
// | Niucloud-admin 企业快速开发的多应用管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------
namespace addon\shop\app\job\stat;

use addon\shop\app\model\order\Order;
use app\service\core\stat\CoreStatService;
use core\base\BaseJob;

/**
 * 订单自动关闭
 */
class ShopStatJob extends BaseJob
{
    /**
     * 消费
     * @return true
     */
    public function doJob($key, $addon)
    {
         if(method_exists($this,$key)) $this->$key($addon);
         return true;
    }

    /**
     * 订单统计
     * @param $addon
     * @return void
     */
    public function shopOrder($addon)
    {
//        ['addon' =>, 'date' => ['year' => , 'month'=> , 'day' => , 'hour' => ], 'data' => ['shop_order_money' => 12, 'member' => 12]]
        $orderModel = new Order();
        $order_money = $orderModel->where( [ ['status', '>', 0]] )->sum('order_money');
        $param = [
            'addon' => $addon,
            'date'  => [
                'year'  => date('Y'),
                'month' => date('m'),
                'day'   => date('d'),
                'hour'  => date('H'),
            ],
            'data'  => [
                'order_money' => $order_money
            ]
        ];
        (new CoreStatService())->add($param);

    }

    /**
     * @param $addon
     * @return void
     */
    public function shopRechargeOrder($addon)
    {

    }



}
