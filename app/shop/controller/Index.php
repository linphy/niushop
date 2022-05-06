<?php

/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\shop\controller;

use addon\fenxiao\model\FenxiaoApply;
use addon\fenxiao\model\FenxiaoWithdraw;
use app\model\goods\Goods as GoodsModel;
use app\model\member\Member as MemberModel;
use app\model\order\OrderCommon;
use app\model\system\Promotion as PrmotionModel;
use app\model\system\Stat;
use Carbon\Carbon;
use app\model\order\OrderRefund as OrderRefundModel;
use think\facade\Cache;

class Index extends BaseShop
{
    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        Cache::tag("cache_tablestat_shop")->clear();
        Cache::tag("cache_tablemember")->clear();
        Cache::tag("cache_tablegoods")->clear();
        Cache::tag("cache_tableorder")->clear();
        Cache::tag("cache_tablefenxiao_apply")->clear();
        Cache::tag("cache_tablefenxiao_withdraw")->clear();
        $shop_info = $this->shop_info;
        $time = time();
        $this->assign('shop_status', 1);
        
        //营销活动
        $promotion_model = new PrmotionModel();
        $promotions = $promotion_model->getSitePromotions($this->site_id);
        $toolcount = 0;
        $shopcount = 0;
        //营销插件数量
        foreach ($promotions as $k => $v) {
            if ($v["show_type"] == 'tool') {
                $toolcount += 1;
            }
            if ($v["show_type"] == 'member' || $v["show_type"] == 'shop') {
                $shopcount += 1;
            }
        }
        $count = [
            'toolcount' => $toolcount,
            'shopcount' => $shopcount
        ];

        $this->assign("promotion", $promotions);
        $this->assign("count", $count);
        //分销插件是否存在
        $is_fenxiao = addon_is_exit('fenxiao', $this->site_id);
        $this->assign('is_fenxiao', $is_fenxiao);

        //基础统计信息
        $today = Carbon::now();
        $this->assign("today", $today);
        return $this->fetch("index/index");
    }

    /**
     * 今日昨日统计
     *
     * @return void
     */
    public function dayCount()
    {
        if (request()->isAjax()) {
            //基础统计信息
            $stat_shop_model = new Stat();
            $today = Carbon::now();
            $yesterday = Carbon::yesterday();
            $stat_today = $stat_shop_model->getStatShop($this->site_id, $today->year, $today->month, $today->day);
            $stat_yesterday = $stat_shop_model->getStatShop($this->site_id, $yesterday->year, $yesterday->month, $yesterday->day);

            //获取总数
            $shop_stat_sum = $stat_shop_model->getShopStatSum($this->site_id);
            $goods_model = new GoodsModel();
            $goods_sum = $goods_model->getGoodsTotalCount([['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);
            $shop_stat_sum['data']['goods_count'] = $goods_sum['data'];

            //日同比
            $day_rate['order_pay_count'] = diff_rate($stat_today['data']['order_pay_count'], $stat_yesterday['data']['order_pay_count']);
            $day_rate['order_total'] = diff_rate($stat_today['data']['order_total'], $stat_yesterday['data']['order_total']);
            $day_rate['collect_goods'] = diff_rate($stat_today['data']['collect_goods'], $stat_yesterday['data']['collect_goods']);
            $day_rate['visit_count'] = diff_rate($stat_today['data']['visit_count'], $stat_yesterday['data']['visit_count']);
            $day_rate['member_count'] = diff_rate($stat_today['data']['member_count'], $stat_yesterday['data']['member_count']);

            //会员总数
            $member_model = new MemberModel();
            $member_count = $member_model->getMemberCount([['site_id', '=', $this->site_id]]);

            $res = [
                'stat_day' => $stat_today['data'],
                'stat_yesterday' => $stat_yesterday['data'],
                'today' => $today,
                'shop_stat_sum' => $shop_stat_sum['data'],
                'day_rate' => $day_rate,
                'member_count' =>   $member_count['data']
            ];
        }
        return $res;
    }

    /**
     * 综合统计
     *
     * @return void
     */
    public function sumCount()
    {
        if (request()->isAjax()) {
            $goods_model = new GoodsModel();
            $order = new OrderCommon();
            $waitpay = $order->getOrderCount([['order_status', '=', 0], ['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);
            $waitsend = $order->getOrderCount([['order_status', '=', 1], ['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);
            $order_refund_model = new OrderRefundModel();
            $refund_num = $order_refund_model->getRefundOrderGoodsCount([
                ["site_id", "=", $this->site_id],
                ["refund_status", "not in", [0, 3]]
            ]);
            $goods_stock_alarm = $goods_model->getGoodsStockAlarm($this->site_id);
            $goods_total = $goods_model->getGoodsTotalCount([['goods_state', '=', 1], ['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);
            $warehouse_goods = $goods_model->getGoodsTotalCount([['goods_state', '=', 0], ['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);

            $num_data = [
                'waitpay' => $waitpay['data'],
                'waitsend' => $waitsend['data'],
                'refund' => $refund_num['data'],
                'goods_stock_alarm' => count($goods_stock_alarm['data']),
                'goods_total' => $goods_total['data'],
                'warehouse_goods' => $warehouse_goods['data']
            ];

            //分销插件是否存在
            $is_fenxiao = addon_is_exit('fenxiao', $this->site_id);
            $this->assign('is_fenxiao', $is_fenxiao);
            if ($is_fenxiao) {
                //提现待审核
                $fenxiao_model = new FenxiaoWithdraw();
                $withdraw_count = $fenxiao_model->getFenxiaoWithdrawCount([['site_id', '=', $this->site_id], ['status', '=', 1]], 'id');
                $num_data['withdraw_count'] = $withdraw_count['data'];

                //分销商申请
                $fenxiao_apply_model = new FenxiaoApply();
                $fenxiao_count = $fenxiao_apply_model->getFenxiaoApplyCount([['site_id', '=', $this->site_id], ['status', '=', 1]], 'apply_id');
                $num_data['apply_count'] = $fenxiao_count['data'];
            } else {
                $waitconfirm = $order->getOrderCount([['order_status', "=", 3], ['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);
                $complete = $order->getOrderCount([['order_status', "=", 10], ['site_id', '=', $this->site_id], ['is_delete', '=', 0]]);
                $num_data['waitconfirm'] = $waitconfirm['data'];
                $num_data['complete'] = $complete['data'];
            }
        }
        return $num_data;
    }

    /**
     * 图形统计
     *
     * @return void
     */
    public function chartCount()
    {
        if (request()->isAjax()) {
            //近十天的订单数以及销售金额
            $stat_shop_model = new Stat();
            $date_day = getweeks();
            $order_total = '';
            $order_pay_count = '';
            foreach ($date_day as $k => $day) {
                $dayarr = explode('-', $day);
                $stat_day[$k] = $stat_shop_model->getStatShop($this->site_id, $dayarr[0], $dayarr[1], $dayarr[2]);
                $order_total .= $stat_day[$k]['data']['order_total'] . ',';
                $order_pay_count .= $stat_day[$k]['data']['order_pay_count'] . ',';
            }
            $ten_day['order_total'] = explode(',', substr($order_total, 0, strlen($order_total) - 1));
            $ten_day['order_pay_count'] = explode(',', substr($order_pay_count, 0, strlen($order_pay_count) - 1));
            return $ten_day;
        }
    }

    /**
     * 营销插件
     *
     * @return void
     */
    public function marketingPlug()
    {
        if (request()->isAjax()) {
            //营销活动
            $promotion_model = new PrmotionModel();
            $promotions = $promotion_model->getSitePromotions($this->site_id);
            $toolcount = 0;
            $shopcount = 0;
            //营销插件数量
            foreach ($promotions as $k => $v) {
                if ($v["show_type"] == 'tool') {
                    $toolcount += 1;
                }
                if ($v["show_type"] == 'member' || $v["show_type"] == 'shop') {
                    $shopcount += 1;
                }
            }
            $count = [
                'toolcount' => $toolcount,
                'shopcount' => $shopcount
            ];
            $res = [
                'count' => $count,
                'promotions' => $promotions
            ];
            return $res;
        }
    }
}
