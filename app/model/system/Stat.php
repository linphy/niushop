<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\model\system;

use app\model\BaseModel;
use app\model\order\OrderCommon;
use app\model\order\OrderRefund;
use Carbon\Carbon;
use think\facade\Db;

/**
 * 统计
 * @author Administrator
 *
 */
class Stat extends BaseModel
{
    /**
     * 添加店铺统计(按照天统计)
     * @param array $data
     */
    public function addShopStat($data)
    {
        $carbon    = Carbon::now();
        $condition = [
            'site_id' => $data['site_id'],
            'year'    => $carbon->year,
            'month'   => $carbon->month,
            'day'     => $carbon->day
        ];
        $info      = model("stat_shop")->getInfo($condition, 'id');
        if (empty($info)) {
            $res = model("stat_shop")->add(
                [
                    'site_id'         => $data['site_id'],
                    'year'            => $carbon->year,
                    'month'           => $carbon->month,
                    'day'             => $carbon->day,
                    'day_time'        => Carbon::today()->timestamp,
                    "order_total"     => isset($data['order_total']) ? $data['order_total'] : 0,
                    "shipping_total"  => isset($data['shipping_total']) ? $data['shipping_total'] : 0,
                    "refund_total"    => isset($data['refund_total']) ? $data['refund_total'] : 0,
                    "order_pay_count" => isset($data['order_pay_count']) ? $data['order_pay_count'] : 0,
                    "goods_pay_count" => isset($data['goods_pay_count']) ? $data['goods_pay_count'] : 0,
                    "shop_money"      => isset($data['shop_money']) ? $data['shop_money'] : 0,
                    "platform_money"  => isset($data['platform_money']) ? $data['platform_money'] : 0,
                    "collect_shop"    => isset($data['collect_shop']) ? $data['collect_shop'] : 0,
                    "collect_goods"   => isset($data['collect_goods']) ? $data['collect_goods'] : 0,
                    "visit_count"     => isset($data['visit_count']) ? $data['visit_count'] : 0,
                    "order_count"     => isset($data['order_count']) ? $data['order_count'] : 0,
                    "goods_count"     => isset($data['goods_count']) ? $data['goods_count'] : 0,
                    "add_goods_count" => isset($data['add_goods_count']) ? $data['add_goods_count'] : 0,
                    "member_count"    => isset($data['member_count']) ? $data['member_count'] : 0,
                    'create_time'     => time()
                ]);

        } else {
            $res = Db::name('stat_shop')->where($condition)
                ->update(
                    [
                        "order_total"     => isset($data['order_total']) ? Db::raw('order_total+' . $data['order_total']) : Db::raw('order_total'),
                        "shipping_total"  => isset($data['shipping_total']) ? Db::raw('shipping_total+' . $data['shipping_total']) : Db::raw('shipping_total'),
                        "refund_total"    => isset($data['refund_total']) ? Db::raw('refund_total+' . $data['refund_total']) : Db::raw('refund_total'),
                        "order_pay_count" => isset($data['order_pay_count']) ? Db::raw('order_pay_count+' . $data['order_pay_count']) : Db::raw('order_pay_count'),
                        "goods_pay_count" => isset($data['goods_pay_count']) ? Db::raw('goods_pay_count+' . $data['goods_pay_count']) : Db::raw('goods_pay_count'),
                        "shop_money"      => isset($data['shop_money']) ? Db::raw('shop_money+' . $data['shop_money']) : Db::raw('shop_money'),
                        "platform_money"  => isset($data['platform_money']) ? Db::raw('platform_money+' . $data['platform_money']) : Db::raw('platform_money'),
                        "collect_shop"    => isset($data['collect_shop']) ? Db::raw('collect_shop+' . $data['collect_shop']) : Db::raw('collect_shop'),
                        "collect_goods"   => isset($data['collect_goods']) ? Db::raw('collect_goods+' . $data['collect_goods']) : Db::raw('collect_goods'),
                        "visit_count"     => isset($data['visit_count']) ? Db::raw('visit_count+' . $data['visit_count']) : Db::raw('visit_count'),
                        "order_count"     => isset($data['order_count']) ? Db::raw('order_count+' . $data['order_count']) : Db::raw('order_count'),
                        "goods_count"     => isset($data['goods_count']) ? Db::raw('goods_count+' . $data['goods_count']) : Db::raw('goods_count'),
                        "add_goods_count" => isset($data['add_goods_count']) ? Db::raw('add_goods_count+' . $data['add_goods_count']) : Db::raw('add_goods_count'),
                        "member_count"    => isset($data['member_count']) ? Db::raw('member_count+' . $data['member_count']) : Db::raw('member_count'),
                        'modify_time'     => time()
                    ]);
        }
        return $this->success($res);

    }

    /**
     * 获取店铺统计（按照天查询）
     * @param unknown $site_id 0表示平台
     * @param unknown $year
     * @param unknown $month
     * @param unknown $day
     */
    public function getStatShop($site_id, $year, $month, $day)
    {
        $condition = [
            'site_id' => $site_id,
            'year'    => $year,
            'month'   => $month,
            'day'     => $day
        ];
        $info      = model("stat_shop")->getInfo($condition,
            'id, site_id, year, month, day, order_total, shipping_total, refund_total, order_pay_count, goods_pay_count, shop_money, platform_money, create_time, modify_time, collect_shop, collect_goods, visit_count, order_count, goods_count, add_goods_count, day_time, member_count');

        if (empty($info)) {
            $condition['day_time'] = strtotime("{$year}-{$month}-{$day}");
            model("stat_shop")->add($condition);
            $info = model("stat_shop")->getInfo($condition,
                'id, site_id, year, month, day, order_total, shipping_total, refund_total, order_pay_count, goods_pay_count, shop_money, platform_money, create_time, modify_time, collect_shop, collect_goods, visit_count, order_count, goods_count, add_goods_count, day_time, member_count');

        }
        return $this->success($info);
    }

    /**
     * 获取店铺统计信息
     * @param unknown $site_id
     * @param unknown $start_time
     */
    public function getShopStatSum($site_id, $start_time = 0,$end_time=0)
    {
        $condition = [
            ['site_id', '=', $site_id]
        ];
        if (!empty($start_time)) {
            $condition[] = ['day_time', '>=', $start_time];
        }
        if(!empty($end_time)){
            $condition[] = ['day_time', '<=', $end_time];
        }
        $info = model("stat_shop")->getInfo($condition,
            'SUM(order_total) as order_total,SUM(shipping_total) as shipping_total,SUM(refund_total) as refund_total,SUM(order_pay_count) as order_pay_count,SUM(goods_pay_count) as goods_pay_count,SUM(shop_money) as shop_money,SUM(platform_money) as platform_money,SUM(collect_shop) as collect_shop,SUM(collect_goods) as collect_goods,SUM(visit_count) as visit_count,SUM(order_count) as order_count,SUM(goods_count) as goods_count,SUM(add_goods_count) as add_goods_count,SUM(member_count) as member_count');
        if ($info['order_total'] == null) {
            $info = [
                "order_total"     => 0,
                "shipping_total"  => 0,
                "refund_total"    => 0,
                "order_pay_count" => 0,
                "goods_pay_count" => 0,
                "shop_money"      => 0,
                "platform_money"  => 0,
                "collect_shop"    => 0,
                "collect_goods"   => 0,
                "visit_count"     => 0,
                "order_count"     => 0,
                "goods_count"     => 0,
                "add_goods_count" => 0,
                "member_count"    => 0
            ];
        }
        return $this->success($info);
    }

    /**
     * 获取店铺统计列表
     * @param unknown $site_id
     * @param unknown $start_time
     */
    public function getShopStatList($site_id, $start_time,$end_time)
    {
        $condition = [
            ['site_id', '=', $site_id],
            ['day_time', '>=', $start_time],
            ['day_time', '<=', $end_time],
        ];
        $info      = model("stat_shop")->getList($condition,
            'id, site_id, year, month, day, order_total, shipping_total, refund_total, order_pay_count, goods_pay_count, shop_money, platform_money, create_time, modify_time, collect_shop, collect_goods, visit_count, order_count, goods_count, add_goods_count, day_time, member_count');
        return $this->success($info);
    }

    /**
     * 获取商品销量排行榜
     * @param $site_id
     * @param string $start_time
     * @param string $end_time
     */
    public function getGoodsSaleNumRankingList($site_id, $start_time = '', $end_time = '', $page_index, $page_size){
        $condition = [
            [ 'o.site_id', '=', $site_id ],
            [ 'o.pay_status', '=', 1 ],
            [ 'g.is_delete', '=', 0 ],
            [ 'o.order_status', '<>', OrderCommon::ORDER_CLOSE ],
            [ 'og.refund_status', '<>', OrderRefund::REFUND_COMPLETE]
        ];
        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
        }
        $join = [
            ['order o', 'og.order_id = o.order_id', 'left'],
            ['goods g', 'og.goods_id = g.goods_id', 'right']
        ];
        $list = model('order_goods')->pageList($condition, 'og.goods_id,g.goods_name,g.goods_state,SUM(og.num) AS sale_num', 'sale_num desc', $page_index, $page_size, 'og', $join, 'og.goods_id');
        return $this->success($list);
    }

    /**
     * 获取商品销量排行榜
     * @param $site_id
     * @param string $start_time
     * @param string $end_time
     * @param $page_index
     * @param $page_size
     * @return array
     */
    public function getGoodsSaleMoneyRankingList($site_id, $start_time = '', $end_time = '', $page_index, $page_size){
        $condition = [
            [ 'o.site_id', '=', $site_id ],
            [ 'o.pay_status', '=', 1 ],
            [ 'g.is_delete', '=', 0 ],
            [ 'o.order_status', '<>', OrderCommon::ORDER_CLOSE ],
            [ 'og.refund_status', '<>', OrderRefund::REFUND_COMPLETE]
        ];
        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
        }
        $join = [
            ['order o', 'og.order_id = o.order_id', 'left'],
            ['goods g', 'og.goods_id = g.goods_id', 'right']
        ];
        $list = model('order_goods')->pageList($condition, 'og.goods_id,g.goods_name,g.goods_state,SUM(o.order_money) AS order_money', 'order_money desc', $page_index, $page_size, 'og', $join, 'og.goods_id');
        return $this->success($list);
    }
}