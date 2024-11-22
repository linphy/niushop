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

namespace addon\shop\app\service\admin\goods;

use addon\shop\app\dict\goods\RankDict;
use addon\shop\app\dict\goods\StatisticsDict;
use addon\shop\app\model\goods\Stat;
use addon\shop\app\service\core\goods\CoreGoodsRankConfigService;
use core\base\BaseAdminService;
use core\exception\AdminException;
use DateTime;


/**
 * 商品统计服务层
 * Class RankService
 * @package addon\shop\app\service\admin\goods
 */
class StatisticsService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Stat();
    }

    /**
     * 获取商品统计基本信息
     * @param array $where
     * @return array
     */
    public function getBasic(array $data)
    {

        $date = [];
        if (isset($data['date']) && !empty($data['date'])){
            $date_arr = explode('-',$data['date']);
            $date = [strtotime($date_arr[0]) , strtotime($date_arr[1])];
        }
        $field = 'goods_id,sum(cart_num) as cart_num,sum(sale_num) as sale_num,sum(pay_num) as pay_num,sum(pay_money) as pay_money,sum(refund_num) as refund_num,sum(refund_money) as refund_money,sum(collect_num) as collect_num,sum(evaluate_num) as evaluate_num,sum(access_num) as access_num,sum(goods_visit_member_count) as goods_visit_member_count';
        $list = $this->model->where([ [ 'date_time', 'between', $date ]])
            ->field($field)
            ->group('goods_id')
            ->select()
            ->toArray();

        $data = [
            'access_good_num'=>0,//被访问商品数
            'sale_good_num'=>0,//动销商品数
            'cart_num'=>0,//加入购物车数量
            'sale_num'=>0,//商品销量（下单数）
            'pay_num'=>0,//支付件数
            'pay_money'=>0,//支付总金额
            'refund_num'=>0,//退款件数
            'refund_money'=>0,//退款总额
            'access_num'=>0,//访问次数（浏览量）
            'collect_num'=>0,//收藏数量
            'evaluate_num'=>0,//评论数量
            'goods_visit_member_count'=>0,//商品访客数
        ];
        foreach ($list as $value){
            if ($value['access_num'] >= 1){
                $data['access_good_num'] += 1;
            }
            if ($value['sale_num'] >= 1){
                $data['sale_good_num'] += 1;
            }
            $data['cart_num'] += $value['cart_num'];
            $data['sale_num'] += $value['sale_num'];
            $data['pay_num'] += $value['pay_num'];
            $data['pay_money'] += $value['pay_money'];
            $data['refund_num'] += $value['refund_num'];
            $data['refund_money'] += $value['refund_money'];
            $data['access_num'] += $value['access_num'];
            $data['collect_num'] += $value['collect_num'];
            $data['evaluate_num'] += $value['evaluate_num'];
            $data['goods_visit_member_count'] += $value['goods_visit_member_count'];
        }
        return $data;
    }


    /**
     * 获取商品统计图表信息
     * @param array $where
     * @return array
     */
    public function getTrend(array $data)
    {
        $where[] = [];
        $allDates = [];
        if (isset($data['date']) && !empty($data['date'])){
//            $date_type = 'day';
            $date_arr = explode('-',$data['date']);
            $allDates = $this->getDatesBetween($date_arr[0], $date_arr[1]);
//            if (count($allDates) > 60){
//                $date_type = 'month';
//                $allDates = $this->getMonthsBetween($date_arr[0], $date_arr[1]);
//            }
            $date = [strtotime($date_arr[0]) , strtotime($date_arr[1])];
            $where[] = [ 'date_time', 'between', $date ];
        }

        $field = 'goods_id,date,date_time,sum(cart_num) as cart_num,sum(sale_num) as sale_num,sum(pay_num) as pay_num,sum(pay_money) as pay_money,sum(refund_num) as refund_num,sum(refund_money) as refund_money,sum(collect_num) as collect_num,sum(evaluate_num) as evaluate_num,sum(access_num) as access_num,sum(goods_visit_member_count) as goods_visit_member_count';
        $list = $this->model
            ->alias('stat')
            ->where($where)
            ->field($field)
            ->group('date_time')
            ->order('date_time asc')
            ->select()
            ->toArray();
        $data = [];
        if (!empty($allDates)){
            foreach ($allDates as $key=>$value){
                $data['access_count'][$key] = "0";//浏览量
                $data['goods_visit_member_count'][$key] = "0";//访客数
                $data['pay_money'][$key] = "0";//支付金额
                $data['refund_money'][$key] = "0";//退款金额
                foreach ($list as $k=>$v){
                    if ($v['date'] == $value){
                        $data['access_count'][$key] = $v['access_num'];
                        $data['goods_visit_member_count'][$key] = $v['goods_visit_member_count'];
                        $data['pay_money'][$key] = $v['pay_money'];
                        $data['refund_money'][$key] = $v['refund_money'];
                    }
                }
            }
        }
        $data['xAxis'] = $allDates;
        return $data;
    }

    /**
     * 获取商品排行榜信息
     * @param array $where
     * @return array
     */
    public function getRank(array $data)
    {
        $category_ids = $data['category_ids'];
        $date = [];
        if (isset($data['date']) && !empty($data['date'])){
            $date_arr = explode('-',$data['date']);
            $date = [strtotime($date_arr[0]) , strtotime($date_arr[1])];
        }
        $where[] = [
            [ 'date_time', 'between', $date ],
        ];
        if (!empty($category_ids)){
            $category_arr = explode(',',$category_ids);
            $category_where = array_map(function($item) { return '%"' . $item . '"%'; }, $category_arr);
            $where[] = [ 'goods_category', 'like',$category_where,'or' ];
        }
        $field = 'stat.goods_id,sum(stat.cart_num) as cart_num,sum(stat.sale_num) as sale_num,sum(stat.pay_num) as pay_num,sum(stat.pay_money) as pay_money,sum(stat.refund_num) as refund_num,sum(stat.refund_money) as refund_money,sum(stat.collect_num) as collect_num,sum(stat.evaluate_num) as evaluate_num,sum(stat.access_num) as access_num,sum(goods_visit_member_count) as goods_visit_member_count,goods_name,goods_cover';
        //排序   access_num=访问次数（浏览量） cart_num=>加入购物车数量 sale_num=商品销量（下单数）pay_num=支付件数 collect_num=收藏数量 pay_money=支付总金额
        $order = $data['type'].' desc';
        $query = $this->model
            ->alias('stat')
            ->where($where)
            ->field($field)
            ->join('shop_goods goods','stat.goods_id=goods.goods_id','left')
            ->append([ 'goods_cover_thumb_small', 'goods_cover_thumb_mid'])
            ->group('stat.goods_id')
            ->order($order);
        $list = $this->pageQuery($query);
        return $list;
    }

    /**
     * 获取商品排行榜统计类型
     * @return array
     */
    public function getType()
    {
        $list = StatisticsDict::getType();

        return $list;
    }

    public function getDatesBetween($startDate, $endDate) {
        $dates = [];
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        // 确保开始日期小于或等于结束日期
        if ($start > $end) {
            return $dates; // 返回空数组
        }

        // 循环获取日期
        while ($start <= $end) {
            $dates[] = date('Y-m-d', $start); // 格式化为日期字符串
            $start = strtotime("+1 day", $start); // 增加一天
        }

        return $dates; // 返回日期数组
    }

    public function getMonthsBetween($startDate, $endDate) {
        $months = [];
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        // 确保开始日期小于等于结束日期
        if ($start > $end) {
            return $months; // 返回空数组
        }

        // 循环获取月份
        while ($start <= $end) {
            $months[] = $start->format('Y-m'); // 格式化为年月字符串
            $start->modify('first day of next month'); // 移动到下一个月的第一天
        }

        return $months; // 返回月份数组
    }







}
