<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
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
class OrderStat extends BaseModel
{
    /**
     * 用于订单(同与订单支付后调用)
     * @param $params
     */
    public function addOrderStat($params){
        $order_id = $params['order_id'];
        $site_id = $params['site_id'] ?? 0;
        $order_condition = array(
            ['order_id', '=', $order_id],
            ['site_id', '=', $site_id]
        );
        $order_info = model('order')->getInfo($order_condition);
        if(empty($order_info))
            return $this->error();

        $order_money = $order_info['order_money'];
        $pay_money = $order_info['pay_money'];
        $member_id = $order_info['member_id'];
        $delivery_money = $order_info['delivery_money'];
        $goods_num = $order_info['goods_num'];
        //如果是第一笔订单才能累加下单会员数
        $time_region = getDayStartAndEndTime();
        $today_start_time = $time_region['start_time'];
        $today_end_time = $time_region['end_time'];

        $today_order_condition = array(
            ['member_id', '=', $member_id],
            ['pay_time', 'between', [$today_start_time, $today_end_time]],
            ['order_id', '<>', $order_id]
        );
        $stat_data = array(
            'site_id' => $site_id,
            'order_pay_count' => 1,
            'order_total' => $order_money,
            'shipping_total' => $delivery_money,
            'goods_pay_count' => $goods_num,
            'order_pay_money' => $pay_money
        );
        $count = model('order')->getCount($today_order_condition);
        if($count == 0){
            $stat_data['order_member_count'] = 1;
        }
        //销售量  order_num

        //销售额  order_money
        $stat_model = new Stat();

        $result = $stat_model->addShopStat($stat_data);
        return $result;
    }

    /**
     * 退款维权统计
     * @param $params
     */
    public function addOrderRefundStat($params){
        $order_goods_id = $params['order_goods_id'];
        $site_id = $params['site_id'];
        $order_goods_condition = array(
            ['site_id', '=', $site_id],
            ['order_goods_id', '=', $order_goods_id],
        );
        $order_goods_info = model('order_goods')->getInfo($order_goods_condition);
        if(empty($order_goods_info))
            return $this->error();

        $stat_data = array(
            'site_id' => $site_id,
            'order_refund_count' => 1
        );
        //todo  统计的时候用的是真实退款还是总退款(包含抵扣项)
        $refund_money = $params['refund_pay_money'];
        $stat_data['refund_total'] = $refund_money;
        $stat_model = new Stat();

        $result = $stat_model->addShopStat($stat_data);
        return $result;
    }
}