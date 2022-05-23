<?php
// +---------------------------------------------------------------------+
// | NiuCloud | [ WE CAN DO IT JUST NiuCloud ]                |
// +---------------------------------------------------------------------+
// | Copy right 2019-2029 www.niucloud.com                          |
// +---------------------------------------------------------------------+
// | Author | NiuCloud <niucloud@outlook.com>                       |
// +---------------------------------------------------------------------+
// | Repository | https://github.com/niucloud/framework.git          |
// +---------------------------------------------------------------------+

namespace app\event;
use app\model\message\Message;
use app\model\order\OrderCommon;

/**
 * 订单催付通知
 */
class CronOrderUrgePayment
{
    // 行为扩展的执行入口必须是run
    public function handle($params)
    {
        $order_info = (new OrderCommon())->getOrderInfo([ ['order_id', '=', $params['relate_id']], ['order_status', '=', OrderCommon::ORDER_CREATE] ], 'site_id')['data'];
        trace($order_info,'订单催付event');
        if (!empty($order_info)){
            (new Message())->sendMessage(['keywords' => 'ORDER_URGE_PAYMENT', 'order_id' => $params['relate_id'], 'site_id' => $order_info['site_id'] ]);
        }
        return success();
    }
}