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

namespace addon\shop\app\listener\order;

/**
 * 订单项导出数据类型查询
 * Class MemberExportTypeListener
 * @package app\listener\member
 */
class ShopOrderGoodsExportTypeListener
{

    public function handle()
    {
        return [
            'shop_order_goods' => [
                'name' => '订单项列表',
                'column' => [
                    'goods_name' => [ 'name' => '商品名称'],
                    'sku_name' => [ 'name' => '商品规格名称'],
                    'price' => [ 'name' => '商品单价'],
                    'num' => [ 'name' => '购买数量'],
                    'goods_money' => [ 'name' => '商品总价'],
                    'goods_type_name' => [ 'name' => '商品类型'],
                    'delivery_status_name' => [ 'name' => '配送状态'],
                    'express_number' => [ 'name' => '物流单号'],
                    'company_name' => [ 'name' => '物流公司'],
                    'discount_money' => [ 'name' => '优惠金额'],
                    'status_name' => [ 'name' => '状态'],
                    'order_refund_no' => [ 'name' => '退款单号'],
                    'order_goods_money' => [ 'name' => '订单项实付金额'],
                ],
            ]
        ];
    }
}
