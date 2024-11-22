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
use think\facade\Log;

/**
 * 限时折扣
 * Class CouponReceiveListener
 * @package addon\shop\app\listener
 */
class ShopDiscountCalculate
{
    public function handle(array $params)
    {
        Log::write('参与限时折扣活动，ShopDiscountCalculate:' . json_encode($params));
        $sku_info = $params[ 'sku_info' ] ?? [];
        $order_obj = $params[ 'order_obj' ];

        if (!empty($order_obj->extend_data) && $sku_info && $sku_info[ 'goods' ][ 'is_discount' ] && $order_obj->extend_data[ 'activity_type' ] == ActiveDict::DISCOUNT) {

            $discount_goods_info = ( new ActiveGoods() )->where([ [ 'active_goods.goods_id', '=', $sku_info[ 'goods_id' ] ], [ 'active_goods.active_class', '=', ActiveDict::DISCOUNT ] ])->withJoin([ 'active' => function($query) {
                $query->where([
                    [ 'active_status', '=', ActiveDict::ACTIVE ],
                    [ 'active.active_class', '=', ActiveDict::DISCOUNT ]
                ]);
            } ])->findOrEmpty()->toArray();

            if ($discount_goods_info && $discount_goods_info[ 'active' ][ 'active_status' ] == ActiveDict::ACTIVE) {

                $order_obj->discount[ ActiveDict::DISCOUNT ] = $order_obj->discountFormat(
                    [ $sku_info[ 'sku_id' ] ],
                    OrderDiscountDict::DISCOUNT,
                    $sku_info[ 'num' ],
                    number_format($sku_info[ 'price' ] - $sku_info[ 'sale_price' ], '2', '.'),
                    ActiveDict::DISCOUNT,
                    $discount_goods_info[ 'active_id' ],
                    '限时折扣',
                    $discount_goods_info[ 'active' ][ 'active_desc' ] ?? ''
                );
                $sku_info[ 'price' ] = $sku_info[ 'sale_price' ];
                $sku_info[ 'goods_money' ] = $sku_info[ 'price' ] * $sku_info[ 'num' ];//小计

                return [
                    'sku_info' => $sku_info,
                    'relate_id' => $discount_goods_info[ 'active_id' ],
                    'activity_type' => ActiveDict::DISCOUNT
                ];
            }

        }
    }
}
