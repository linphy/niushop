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

namespace addon\shop\app\service\api\marketing;

use addon\shop\app\dict\active\ManjianDict;
use addon\shop\app\dict\coupon\CouponDict;
use addon\shop\app\dict\coupon\CouponMemberDict;
use addon\shop\app\model\coupon\Coupon;
use addon\shop\app\model\coupon\CouponMember;
use addon\shop\app\model\goods\GoodsSku;
use addon\shop\app\model\manjian\Manjian;
use addon\shop\app\model\manjian\ManjianGoods;
use addon\shop\app\service\core\marketing\CoreManjianService;
use core\base\BaseApiService;

/**
 * 满减送服务层
 * Class ManjianService
 * @package addon\shop\app\service\api\marketing
 */
class ManjianService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Manjian();
    }

    /**
     * 获取满减信息
     * @return array
     */
    public function getManjianInfo($data)
    {
        $goods_id = $data[ 'goods_id' ];
        $sku_id = $data[ 'sku_id' ];
        if (empty($sku_id) && !empty($goods_id)) {
            // 查询默认规格项
            $default_sku_info = ( new GoodsSku() )->where([ [ 'goods_id', '=', $goods_id ], [ 'is_default', '=', 1 ] ], 'sku_id')
                ->field('sku_id')->findOrEmpty()->toArray();
            if (!empty($default_sku_info)) {
                $sku_id = $default_sku_info[ 'sku_id' ];
            }
        }

        $manjian_info = [];
        $field = 'manjian_id,manjian_name,condition_type,rule_type,rule_json,join_member_type,level_ids,label_ids,start_time,end_time,remark';
        $common_where = [
            [ 'status', '=', ManjianDict::ACTIVE ],
            [ 'start_time', '<=', time() ],
            [ 'end_time', '>', time() ]
        ];
        $manjian_info_all_goods = $this->model->field($field)->where($common_where)->where([ [ 'goods_type', '=', ManjianDict::ALL_GOODS ] ])->findOrEmpty()->toArray();
        if (!empty($manjian_info_all_goods)) {//全部商品参与
            $manjian_info = $manjian_info_all_goods;
            $can_join = ( new CoreManjianService() )->canJoinManjian($manjian_info, $this->member_id);
            if ($can_join) {
                $rule_content = $this->getRuleContent($manjian_info);
                $manjian_info = $rule_content[ 'is_join' ] ? $rule_content : [];
            }
        } else {
            $manjian_info_selected_goods_not = $this->model->field($field)->where($common_where)->where([ [ 'goods_type', '=', ManjianDict::SELECTED_GOODS_NOT ] ])->findOrEmpty()->toArray();
            $manjian_goods_info = ( new ManjianGoods() )->field('manjian_id,goods_type')->where([
                [ 'goods_id', '=', $goods_id ],
                [ 'sku_id', '=', $sku_id ],
                [ 'status', '=', ManjianDict::ACTIVE ]
            ])->findOrEmpty()->toArray();
            if (!empty($manjian_info_selected_goods_not) && empty($manjian_goods_info)) {//指定商品不参与
                $manjian_info = $manjian_info_selected_goods_not;
                $can_join = ( new CoreManjianService() )->canJoinManjian($manjian_info, $this->member_id);
                if ($can_join) {
                    $rule_content = $this->getRuleContent($manjian_info);
                    $manjian_info = $rule_content[ 'is_join' ] ? $rule_content : [];
                }
            } else {//指定商品参与
                $manjian_info_selected_goods = $this->model->field($field)->where($common_where)->where([ [ 'goods_type', '=', ManjianDict::SELECTED_GOODS ] ])->select()->toArray();
                if (!empty($manjian_info_selected_goods) && !empty($manjian_goods_info) && $manjian_goods_info[ 'goods_type' ] == ManjianDict::SELECTED_GOODS) {
                    $manjian_info_selected_goods = array_column($manjian_info_selected_goods, null, 'manjian_id');
                    if (in_array($manjian_goods_info[ 'manjian_id' ], array_keys($manjian_info_selected_goods))) {
                        $manjian_info = $manjian_info_selected_goods[ $manjian_goods_info[ 'manjian_id' ] ];
                        $can_join = ( new CoreManjianService() )->canJoinManjian($manjian_info, $this->member_id);
                        if ($can_join) {
                            $rule_content = $this->getRuleContent($manjian_info);
                            $manjian_info = $rule_content[ 'is_join' ] ? $rule_content : [];
                        }
                    }
                }
            }
        }
        return $manjian_info;
    }

    /**
     * 获取满减规则内容
     * @param $manjian_info
     * @return array
     */
    public function getRuleContent($manjian_info)
    {
        if (!empty($manjian_info)) {
            $is_join = false;
            foreach ($manjian_info[ 'rule_json' ] as $key => $item) {
                if ($item[ 'is_discount' ]) {
                    $is_join = true;
                }
                if ($item[ 'is_free_shipping' ]) {
                    $is_join = true;
                }
                if ($item[ 'is_give_point' ]) {
                    $is_join = true;
                }
                if ($item[ 'is_give_balance' ]) {
                    $is_join = true;
                }
                if ($item[ 'is_give_coupon' ]) {
                    foreach ($item[ 'coupon' ] as $coupon_key => &$coupon) {
                        $coupon_info = ( new Coupon() )->field('remain_count,limit_count,price,min_condition_money')->where([
                            [ 'id', '=', $coupon[ 'coupon_id' ] ],
                            [ 'status', '=', CouponDict::NORMAL ],
                        ])->findOrEmpty()->toArray();
                        $coupon_member_count = ( new CouponMember() )->where([
                            [ 'coupon_id', '=', $coupon[ 'coupon_id' ] ],
                            [ 'member_id', '=', $this->member_id ],
                            [ 'status', '<>', CouponMemberDict::INVALID ]
                        ])->count();
                        if (!empty($coupon_info)) {
                            if ($coupon_info[ 'min_condition_money' ] == '0.00') {
                                $coupon_name = $coupon_info[ 'price' ] . "元无门槛券";
                            } else {
                                $coupon_name = "满" . $coupon_info[ 'min_condition_money' ] . "元减" . $coupon_info[ 'price' ] . "元券";
                            }
                            $coupon[ 'coupon_name' ] = $coupon_name;
                            if ($coupon_info[ 'remain_count' ] == 0 || $coupon_member_count >= $coupon_info[ 'limit_count' ]) {
                                unset($item[ 'coupon' ][ $coupon_key ]);
                            }
                        } else {
                            unset($item[ 'coupon' ][ $coupon_key ]);
                        }
                    }
                    $item[ 'coupon' ] = array_values($item[ 'coupon' ]);
                    if (!empty($item[ 'coupon' ])) {
                        $is_join = true;
                    }
                }
                if ($item[ 'is_give_goods' ]) {
                    foreach ($item[ 'goods' ] as $goods_key => &$goods) {
                        $sku_info = ( new GoodsSku() )->field('goods_id,sku_name,sku_image,price')->where([
                            [ 'goods_id', '=', $goods[ 'goods_id' ] ],
                            [ 'sku_id', '=', $goods[ 'sku_id' ] ],
                            [ 'stock', '>=', $goods[ 'num' ] ],
                        ])->with([ 'goods' ])->findOrEmpty()->toArray();
                        if (!empty($sku_info) && $sku_info[ 'goods' ][ 'status' ] == 1) {
                            $sku_info[ 'num' ] = $goods[ 'num' ];
                            $goods[ 'goods_name' ] = $sku_info[ 'goods' ][ 'goods_name' ];
                            $goods[ 'sku_name' ] = $sku_info[ 'sku_name' ];
                            $goods[ 'sku_image' ] = $sku_info[ 'sku_image' ];
                            $goods[ 'price' ] = $sku_info[ 'price' ];
                        } else {
                            unset($item[ 'goods' ][ $goods_key ]);
                        }
                    }
                    $item[ 'goods' ] = array_values($item[ 'goods' ]);
                    if (!empty($item[ 'goods' ])) {
                        $is_join = true;
                    }
                }
                $manjian_info[ 'rule_json' ][ $key ] = $item;
            }
            $manjian_info[ 'is_join' ] = $is_join;
        }
        return $manjian_info;
    }

}
