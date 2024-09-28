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

namespace addon\shop\app\listener\marketing;

use addon\shop\app\dict\active\ActiveDict;
use addon\shop\app\dict\order\OrderDiscountDict;
use addon\shop\app\model\active\ActiveGoods;

/**
 * 限时折扣
 * Class CouponReceiveListener
 * @package addon\shop\app\listener
 */
class ShopDiscountCalculate
{
    public function handle(array $params)
    {
        $sku_info = $params[ 'sku_info' ] ?? [];
        $order_obj = $params[ 'order_obj' ];
        if (empty($order_obj->extend_data) && $sku_info && $sku_info[ 'goods' ][ 'is_discount' ]) {

            $discount_goods_info = ( new ActiveGoods() )->where([ [ 'active_goods.goods_id', '=', $sku_info[ 'goods_id' ] ] ])->withJoin([ 'active' => function($query) {
                $query->where('active_status', '=', ActiveDict::ACTIVE);
            } ])->findOrEmpty()->toArray();

            if ($discount_goods_info && $discount_goods_info[ 'active' ][ 'active_status' ] == ActiveDict::ACTIVE) {
                $order_obj->discount[ 'discount' ] = $order_obj->discountFormat(
                    [ $sku_info[ 'sku_id' ] ],
                    OrderDiscountDict::DISCOUNT,
                    1,
                    number_format($sku_info[ 'price' ] - $sku_info[ 'sale_price' ], '2', '.'),
                    ActiveDict::DISCOUNT,
                    $discount_goods_info[ 'active_id' ],
                    '限时折扣',
                    $discount_goods_info[ 'active' ][ 'active_desc' ] ?? ''
                );
                if ($sku_info[ 'sale_price' ] != $sku_info[ 'original_price' ]) {//不等于原价才使用活动价
                    $sku_info[ 'price' ] = $sku_info[ 'sale_price' ];
                }
                $sku_info[ 'goods_money' ] = $sku_info[ 'price' ] * $sku_info[ 'num' ];//小计
                return [
                    'sku_info' => $sku_info
                ];
            }

        }
    }
}
