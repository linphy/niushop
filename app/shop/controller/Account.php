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

use addon\fenxiao\model\FenxiaoOrder as FenxiaoOrderModel;
use app\model\web\Account as AccountModel;

use addon\fenxiao\model\FenxiaoData;
use app\model\order\Order as OrderModel;
use app\model\order\OrderCommon as OrderCommonModel;

class Account extends BaseShop
{

    public function dashboard()
    {
        $is_memberwithdraw  = addon_is_exit('memberwithdraw', $this->site_id);
        $this->assign('is_memberwithdraw', $is_memberwithdraw);

        //获取分销商账户统计
        $is_addon_fenxiao = addon_is_exit('fenxiao', $this->site_id);
        $this->assign('is_addon_fenxiao', $is_addon_fenxiao);
        return $this->fetch('account/dashboard');
    }

    /**
     * 订单概况
     *
     * @return void
     */
    public function orderSum()
    {
        if (request()->isAjax()) {
            $order_model = new OrderModel();
            //获取订单总额
            $order_total_money = $order_model->getOrderMoneySum(
                [
                    ['site_id', '=', $this->site_id],
                    ['order_status', '<>', 0],
                    ['pay_status', '=', 1],
                ],
                'order_money'
            );
            $res['order_total_money'] =  number_format($order_total_money['data'], 2, '.', '');
            //获取订单退款金额
            $refund_total_money = $order_model->getOrderMoneySum(
                [
                    ['site_id', '=', $this->site_id],
                    //				[ 'refund_status', '<>', 0 ],
                ],
                'refund_money'
            );
            $res['refund_total_money'] = number_format($refund_total_money['data'], 2, '.', '');

            $common_model = new OrderCommonModel();
            //获取订单总数
            $order_total_count = $common_model->getOrderCount(
                [
                    ['site_id', '=', $this->site_id],
                    ['order_status', '<>', 0],
                    ['pay_status', '=', 1],
                ]
            );
            $res['order_total_count'] = $order_total_count['data'];

            //获取退款订单总数
            $refund_total_count = $common_model->getOrderCount(
                [
                    ['site_id', '=', $this->site_id],
                    ['refund_money', '>', 0],
                ]
            );
            $res['refund_total_count'] = $refund_total_count['data'];
            return $res;
        }
    }

    /**
     * 分销概况
     *
     * @return void
     */
    public function fenXiaoSum()
    {
        if (request()->isAjax()) {
            //获取分销商账户统计
            $is_addon_fenxiao = addon_is_exit('fenxiao', $this->site_id);
            if ($is_addon_fenxiao == 1) {
                $fenxiao_data_model = new FenxiaoData();
                $account_data       = $fenxiao_data_model->getFenxiaoAccountData($this->site_id);

                $res['account_data'] = $account_data;
                //累计佣金
                //            $fenxiao_account = number_format($account_data['account'] + $account_data['account_withdraw'], 2, '.', '');
                //获取分销的总金额
                $order_model = new FenxiaoOrderModel();
                $commission = $order_model->getFenxiaoOrderInfo([['site_id', '=', $this->site_id]], 'sum(real_goods_money) as real_goods_money,sum(commission) as commission');
                if ($commission['data']['real_goods_money'] == null) {
                    $commission['data']['real_goods_money'] = '0.00';
                }
                if ($commission['data']['commission'] == null) {
                    $commission['data']['commission'] = '0.00';
                }
                $res['fenxiao_account'] = $commission['data']['commission'];
                //分销订单总金额
                $fenxiao_order_money = $fenxiao_data_model->getFenxiaoOrderSum($this->site_id);
                $res['fenxiao_order_money'] = $fenxiao_order_money;
            }
        }
        return $res;
    }

    /**
     * 会员概况
     *
     * @return void
     */
    public function memberSum()
    {
        if (request()->isAjax()) {
            $account_model = new AccountModel();
            //会员余额
            $member_balance_sum = $account_model->getMemberBalanceSum($this->site_id);
            $is_memberwithdraw  = addon_is_exit('memberwithdraw', $this->site_id);
            if ($is_memberwithdraw == 1) {
                $res['member_balance_sum'] =  $member_balance_sum['data'];
            } else {
                $member_balance = number_format($member_balance_sum['data']['balance'] + $member_balance_sum['data']['balance_money'], 2, '.', '');
                $res['member_balance'] = $member_balance;
            }
        }
        return $res;
    }
}
