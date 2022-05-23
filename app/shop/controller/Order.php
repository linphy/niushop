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

use app\model\express\ExpressDeliver;
use app\model\order\Config as ConfigModel;
use app\model\order\Order as OrderModel;
use app\model\order\OrderCommon;
use app\model\order\OrderCommon as OrderCommonModel;
use app\model\order\OrderExport;
use phpoffice\phpexcel\Classes\PHPExcel;
use phpoffice\phpexcel\Classes\PHPExcel\Writer\Excel2007;
use think\facade\Config;
use app\model\system\Promotion as PromotionModel;

/**
 * 订单
 * Class Order
 * @package app\shop\controller
 */
class Order extends BaseShop
{

    public function __construct()
    {
        //执行父类构造函数
        parent::__construct();

    }

    /**
     * 快递订单列表
     */
    public function lists()
    {
        $order_label_list = array (
            "order_no" => "订单号",
            "out_trade_no" => "交易流水号",
            "name" => "收货人姓名",
            "order_name" => "商品名称",
            "mobile" => "收货人电话",
            "nick_name" => "会员昵称",
            'sku_no' => 'SKU编码'
        );
        $order_model = new OrderModel();
        $order_status_list = $order_model->delivery_order_status;
        $order_status = input("order_status", "");//订单状态
        $order_name = input("order_name", '');
        $pay_type = input("pay_type", '');
        $order_from = input("order_from", '');
        $start_time = input("start_time", '');
        $end_time = input("end_time", '');
        $delivery_start_time = input("delivery_start_time", '');
        $delivery_end_time = input("delivery_end_time", '');
        $order_label = !empty($order_label_list[ input("order_label") ]) ? input("order_label") : "";
        $search_text = input("search", '');
        $promotion_type = input("promotion_type", '');//订单类型
        $order_type = input("order_type", 'all');//营销类型
        $is_verify = input("is_verify", "all");
        $field = 'a.*';
        $order_common_model = new OrderCommonModel();
        if (request()->isAjax()) {
            $page_index = input('page', 1);
            $page_size = input('page_size', PAGE_LIST_ROWS);
            $alias = 'a';
            $join = null;
            $condition = [
//                ["order_type", "=", 1],
                [ "a.site_id", "=", $this->site_id ],
                [ 'a.is_delete', '=', 0 ]
            ];
            //订单状态
            if ($order_status != "") {
                if($order_status != 'refunding'){
                    $order_goods_list = $order_common_model->getOrderGoodsList([['refund_status', "not in", [0,3]]], 'order_id')['data'];
                    $order_id_arr = array_unique(array_column($order_goods_list, 'order_id'));
                    $condition[] = [ "a.order_id", "in", $order_id_arr ];
                }else{
                    $condition[] = [ "a.order_status", "=", $order_status ];
                }
            }

            $order = "a.create_time desc";

            if($is_verify != "all"){
                $join[] = [
                    'verify v',
                    'v.verify_code = a.virtual_code',
                    'left'
                ];
                $condition[] = [ "v.is_verify", "=", $is_verify ];
            }

            //订单内容 模糊查询
            if ($order_name != "") {
                $condition[] = [ "a.order_name", 'like', "%{$order_name}%" ];
            }
            //订单来源
            if ($order_from != "") {
                $condition[] = [ "a.order_from", "=", $order_from ];
            }
            //订单支付
            if ($pay_type != "") {
                $condition[] = [ "a.pay_type", "=", $pay_type ];
            }
            //订单类型
            if ($order_type != 'all') {
                $condition[] = [ "a.order_type", "=", $order_type ];
            }
            //营销类型
            if ($promotion_type != "") {
                if ($promotion_type == 'empty') {
                    $condition[] = [ "a.promotion_type", "=", '' ];
                } else {
                    $condition[] = [ "a.promotion_type", "=", $promotion_type ];
                }
            }
            if (!empty($start_time) && empty($end_time)) {
                $condition[] = [ "a.create_time", ">=", date_to_time($start_time) ];
            } elseif (empty($start_time) && !empty($end_time)) {
                $condition[] = [ "a.create_time", "<=", date_to_time($end_time) ];
            } elseif (!empty($start_time) && !empty($end_time)) {
                $condition[] = [ 'a.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
            }

            if (!empty($delivery_start_time) && empty($delivery_end_time)) {
                $condition[] = [ "a.buyer_ask_delivery_time", ">=", date_to_time($delivery_start_time) ];
            } elseif (empty($delivery_start_time) && !empty($delivery_end_time)) {
                $condition[] = [ "a.buyer_ask_delivery_time", "<=", date_to_time($delivery_end_time) ];
            } elseif (!empty($delivery_start_time) && !empty($delivery_end_time)) {
                $condition[] = [ 'a.buyer_ask_delivery_time', 'between', [ date_to_time($delivery_start_time), date_to_time($delivery_end_time) ] ];
            }
            
            if ($search_text != ""){
                switch($order_label){
                    case "nick_name":
                        $join[] = [
                            'member m',
                            'm.member_id = a.member_id',
                            'left'
                        ];
                        $condition[] = [ 'm.nickname', 'like', "%{$search_text}%" ];
                        break;
                    case "sku_no":
                        $order_goods_list = $order_common_model->getOrderGoodsList([['sku_no', "like", "%{$search_text}%"]], 'order_id')['data'];
                        $order_id_arr = array_unique(array_column($order_goods_list, 'order_id'));
                        $condition[] = [ "a.order_id", "in", $order_id_arr ];
                        break;
                    default:
                        $condition[] = [ 'a.'.$order_label, 'like', "%{$search_text}%" ];
                }
            }

            $list = $order_common_model->getOrderPageList($condition, $page_index, $page_size, $order, $field, $alias, $join);
            $list['data']['order_status'] = $order_status;
            return $list;
        } else {

            $order_type_list = $order_common_model->getOrderTypeStatusList();
            $this->assign("order_type_list", $order_type_list);
            $this->assign("order_label_list", $order_label_list);
            $order_model = new OrderModel();
            $order_status_list = $order_model->order_status;
            $this->assign("order_status_list", $order_type_list[1]['status']);//订单状态
            //订单来源 (支持端口)
            $order_from = Config::get("app_type");
            $this->assign('order_from_list', $order_from);

            $pay_type = $order_common_model->getPayType();
            $this->assign("pay_type_list", $pay_type);

            $this->assign("order_status", $order_status);

            //营销活动类型
            $order_promotion_type = event('OrderPromotionType');
            $this->assign("promotion_type", $order_promotion_type);
            $this->assign("http_type", get_http_type());

            return $this->fetch('order/lists');
        }

    }

    /**
     * 自提订单
     */
    public function pickUpOrder()
    {
        $order_label_list = array(
            "order_no" => "订单号",
            "out_trade_no" => "交易流水号",
            "name" => "收货人姓名",
            "order_name" => "商品名称",
            "mobile" => "收货人电话",
            "nick_name" => "会员昵称",
        );
        $order_model = new OrderModel();
        $order_status_list = $order_model->delivery_order_status;
        $order_status = input("order_status", "");//订单状态
        $order_name = input("order_name", '');
        $pay_type = input("pay_type", '');
        $order_from = input("order_from", '');
        $start_time = input("start_time", '');
        $end_time = input("end_time", '');
        $order_label = !empty($order_label_list[input("order_label")]) ? input("order_label") : "";
        $search_text = input("search", '');
        $promotion_type = input("promotion_type", '');//订单类型
//        $order_type = input("order_type", 'all');//营销类型
        $is_verify = input("is_verify", "all");
        $order_common_model = new OrderCommonModel();
        if (request()->isAjax()) {
            $page_index = input('page', 1);
            $page_size = input('page_size', PAGE_LIST_ROWS);
            $alias = 'a';
            $join = null;
            $condition = [
                ["a.order_type", "=", 2],
                ["a.site_id", "=", $this->site_id],
                ['a.is_delete', '=', 0]
            ];
            //订单状态
            if ($order_status != "") {
                if ($order_status != 'refunding') {
                    $condition[] = ["a.order_status", "=", $order_status];
                } else {
                    $join = [
                        [
                            'order_goods og',
                            'og.order_id = a.order_id',
                            'left'
                        ]
                    ];
                    $condition[] = ["og.refund_status", "not in", [0, 3]];
                }

            } else {
//                $condition[] = [ 'order_status', 'in', array_keys($order_status_list) ];
            }

            $order = "a.create_time desc";

            if ($is_verify != "all") {
                $join[] = [
                    'verify v',
                    'v.verify_code = a.virtual_code',
                    'right'
                ];
                $condition[] = ["v.is_verify", "=", $is_verify];
                $order = "a.create_time desc";
            }

            //订单内容 模糊查询
            if ($order_name != "") {
                $condition[] = ["a.order_name", 'like', "%$order_name%"];
            }
            //订单来源
            if ($order_from != "") {
                $condition[] = ["a.order_from", "=", $order_from];
            }
            //订单支付
            if ($pay_type != "") {
                $condition[] = ["a.pay_type", "=", $pay_type];
            }
            //营销类型
            if ($promotion_type != "") {
                if ($promotion_type == 'empty') {
                    $condition[] = ["a.promotion_type", "=", ''];
                } else {
                    $condition[] = ["a.promotion_type", "=", $promotion_type];
                }
            }
            if (!empty($start_time) && empty($end_time)) {
                $condition[] = ["a.create_time", ">=", date_to_time($start_time)];
            } elseif (empty($start_time) && !empty($end_time)) {
                $condition[] = ["a.create_time", "<=", date_to_time($end_time)];
            } elseif (!empty($start_time) && !empty($end_time)) {
                $condition[] = ['a.create_time', 'between', [date_to_time($start_time), date_to_time($end_time)]];
            }

            if ($order_label == "nick_name") {
                $join[] = [
                    'member m',
                    'm.member_id = a.member_id',
                    'right'
                ];
                $condition[] = ['m.nickname', 'like', "%$search_text%"];
            } else {
                if ($search_text != "") {
                    $condition[] = ['a.' . $order_label, 'like', "%$search_text%"];
                }
            }
            $join[] = [
                'store s',
                's.store_id = a.delivery_store_id',
                'inner'
            ];
            $list = $order_common_model->getOrderPageList($condition, $page_index, $page_size, $order, $field = 'a.*,s.address,s.full_address', $alias, $join);
            return $list;
        } else {

            $order_type_list = $order_common_model->getOrderTypeStatusList();
            $this->assign("order_type_list", $order_type_list);
            $this->assign("order_label_list", $order_label_list);
            $order_model = new OrderModel();
            $order_status_list = $order_model->order_status;
            $this->assign("order_status_list", $order_type_list[1]['status']);//订单状态

            //订单来源 (支持端口)
            $order_from = Config::get("app_type");
            $this->assign('order_from_list', $order_from);

            $pay_type = $order_common_model->getPayType();
            $this->assign("pay_type_list", $pay_type);

            //营销活动类型
            $order_promotion_type = event('OrderPromotionType');
            $this->assign("promotion_type", $order_promotion_type);
            $this->assign("http_type", get_http_type());

            return $this->fetch('order/pickuporder');
        }
    }

    /**
     * 自提订单导出（已订单为主）
     */
    public function exportPickUpOrder()
    {
        $order_label_list = array (
            "order_no" => "订单号",
            "out_trade_no" => "外部单号",
            "name" => "收货人姓名",
            "mobile" => "收货人手机号",
            "order_name" => "商品名称",
            "nick_name" => "会员昵称"
        );

        $order_status = input("order_status", "");//订单状态
        $order_name = input("order_name", '');
        $pay_type = input("pay_type", '');
        $order_from = input("order_from", '');
        $start_time = input("start_time", '');
        $end_time = input("end_time", '');
        $order_label = !empty($order_label_list[ input("order_label") ]) ? input("order_label") : "";
        $search_text = input("search", '');
        $promotion_type = input("promotion_type", '');
//        $order_type = input("order_type", 'all');
        $is_verify = input("is_verify", "all");
        $condition_desc = [];

        $order_common_model = new OrderCommon();
        $condition = [
            ["o.site_id", "=", $this->site_id],
            ["o.is_delete","=",0]
        ];
        //订单类型
//        $order_type_name = '全部';
//        if ($order_type != 'all') {
        $condition[] = [ "o.order_type", "=", 2 ];

        $order_type_list = $order_common_model->getOrderTypeStatusList();
        $order_type_list = array_column($order_type_list, 'name', 'type');
        $order_type_name = $order_type_list[ 2 ];
//        }
        $condition_desc[] = [ 'name' => '订单类型', 'value' => $order_type_name ];

        //订单状态
        $order_status_name = '全部';
        if ($order_status != "") {
            if($order_status != 'refunding'){
                $condition[] = [ "o.order_status", "=", $order_status ];
                $order_status_list = $order_common_model->order_status;
                $order_status_name = $order_status_list[ $order_status ][ 'name' ] ?? '';
            }else{
                $join = [
                    [
                        'order_goods og',
                        'og.order_id = o.order_id',
                        'left'
                    ]
                ];
                $condition[] = [ "og.refund_status", "not in", [0,3] ];
                $order_status_name = '维权中';
            }


        }
        $condition_desc[] = [ 'name' => '订单状态', 'value' => $order_status_name ];

        //订单内容 模糊查询
        if ($order_name != "") {
            $condition[] = [ "o.order_name", 'like', "%$order_name%" ];
        }

        if($is_verify != "all"){
            $condition[] = [ "v.is_verify", "=", $is_verify ];
        }

        //订单来源
        $order_from_name = '全部';
        if ($order_from != "") {
            $condition[] = [ "o.order_from", "=", $order_from ];
            //订单来源 (支持端口)
            $order_from_list = Config::get("app_type");
            $order_from_name = $order_from_list[ $order_from ][ 'name' ] ?? '';
        }
        $condition_desc[] = [ 'name' => '订单来源', 'value' => $order_from_name ];


        //订单支付
        $pay_type_name = '全部';
        if ($pay_type != "") {
            $condition[] = [ "o.pay_type", "=", $pay_type ];
            $pay_type_list = $order_common_model->getPayType();
            $pay_type_name = $pay_type_list[ $pay_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '支付方式', 'value' => $pay_type_name ];

        //营销类型
        $promotion_type_name = '全部';
        if ($promotion_type != "") {
            if ($promotion_type == 'empty') {
                $condition[] = [ "o.promotion_type", "=", '' ];
            } else {
                $condition[] = [ "o.promotion_type", "=", $promotion_type ];
            }
            //营销活动类型
            $promotion_model = new PromotionModel();
            $promotion_type_list = $promotion_model->getPromotionType();
            $promotion_type_list = array_column($promotion_type_list, 'name', 'type');
            $promotion_type_name = $promotion_type_list[ $promotion_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '营销活动', 'value' => $promotion_type_name ];
        $time_name = '';
        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
            $time_name = $start_time . '起';
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
            $time_name = '至' . $end_time;
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
            $time_name = $start_time . ' 至 ' . $end_time;
        }
        $condition_desc[] = [ 'name' => '下单时间', 'value' => $time_name ];

        if($order_label != "nick_name"){
            if ($search_text != "") {
                $condition[] = [ 'o.'.$order_label, 'like', "%$search_text%" ];
            }
            foreach ($order_label_list as $k => $v) {
                $order_label_name = $v;
                if ($k == $order_label) {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => $search_text ];
                } else {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => '' ];
                }
            }
        }else{
            $condition[] = [ 'm.nickname', 'like', "%$search_text%" ];
        }

        $order_export_model = new OrderExport();

        $result = $order_export_model->orderExport($condition, $condition_desc, $this->site_id, $join ?? null, $is_verify, $order_label);
        return $result;
    }

    /**
     * 自提订单导出（已订单商品为主）
     */
    public function exportPickUpOrderGoods()
    {
        $order_label_list = array (
            "order_no" => "订单号",
            "out_trade_no" => "外部单号",
            "name" => "收货人姓名",
            "mobile" => "收货人手机号",
            "order_name" => "商品名称",
            "nick_name" => "会员昵称"
        );

        $order_status = input("order_status", "");//订单状态
        $order_name = input("order_name", '');
        $pay_type = input("pay_type", '');
        $order_from = input("order_from", '');
        $start_time = input("start_time", '');
        $end_time = input("end_time", '');

        $order_label = !empty($order_label_list[ input("order_label") ]) ? input("order_label") : "";

        $search_text = input("search", '');
        $promotion_type = input("promotion_type", '');
//        $order_type = input("order_type", 'all');
        $is_verify = input("is_verify", "all");
        $condition_desc = [];

        $order_common_model = new OrderCommon();
        $condition = [
            ["o.site_id", "=", $this->site_id],
            ["o.is_delete","=",0]
        ];
        //订单类型
//        $order_type_name = '全部';
//        if ($order_type != 'all') {
        $condition[] = [ "o.order_type", "=", 2 ];

        $order_type_list = $order_common_model->getOrderTypeStatusList();
        $order_type_list = array_column($order_type_list, 'name', 'type');
        $order_type_name = $order_type_list[ 2 ];
//        }
        $condition_desc[] = [ 'name' => '订单类型', 'value' => $order_type_name ];

        //订单状态
        $order_status_name = '全部';
        if ($order_status != "") {
            if($order_status != 'refunding'){
                $condition[] = [ "o.order_status", "=", $order_status ];
                $order_status_list = $order_common_model->order_status;
                $order_status_name = $order_status_list[ $order_status ][ 'name' ] ?? '';
            }else{
                $condition[] = [ "og.refund_status", "not in", [0,3] ];
                $order_status_name = '维权中';
            }


        }
        $condition_desc[] = [ 'name' => '订单状态', 'value' => $order_status_name ];

        //订单内容 模糊查询
        if ($order_name != "") {
            $condition[] = [ "o.order_name", 'like', "%$order_name%" ];
        }

        if($is_verify != "all"){
            $condition[] = [ "v.is_verify", "=", $is_verify ];
        }

        //订单来源
        $order_from_name = '全部';
        if ($order_from != "") {
            $condition[] = [ "o.order_from", "=", $order_from ];
            //订单来源 (支持端口)
            $order_from_list = Config::get("app_type");
            $order_from_name = $order_from_list[ $order_from ][ 'name' ] ?? '';
        }
        $condition_desc[] = [ 'name' => '订单来源', 'value' => $order_from_name ];


        //订单支付
        $pay_type_name = '全部';
        if ($pay_type != "") {
            $condition[] = [ "o.pay_type", "=", $pay_type ];
            $pay_type_list = $order_common_model->getPayType();
            $pay_type_name = $pay_type_list[ $pay_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '支付方式', 'value' => $pay_type_name ];

        //营销类型
        $promotion_type_name = '全部';
        if ($promotion_type != "") {
            if ($promotion_type == 'empty') {
                $condition[] = [ "o.promotion_type", "=", '' ];
            } else {
                $condition[] = [ "o.promotion_type", "=", $promotion_type ];
            }
            //营销活动类型
            $promotion_model = new PromotionModel();
            $promotion_type_list = $promotion_model->getPromotionType();
            $promotion_type_list = array_column($promotion_type_list, 'name', 'type');
            $promotion_type_name = $promotion_type_list[ $promotion_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '营销活动', 'value' => $promotion_type_name ];

        $time_name = '';
        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
            $time_name = $start_time . '起';
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
            $time_name = '至' . $end_time;
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
            $time_name = $start_time . ' 至 ' . $end_time;
        }
        $condition_desc[] = [ 'name' => '下单时间', 'value' => $time_name ];

        if($order_label != "nick_name"){
            if ($search_text != "") {
                $condition[] = [ 'o.' . $order_label, 'like', "%$search_text%" ];
            }
            foreach ($order_label_list as $k => $v) {
                $order_label_name = $v;
                if ($k == $order_label) {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => $search_text ];
                } else {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => '' ];
                }
            }
        }else{
            $condition[] = [ 'm.nickname', 'like', "%$search_text%" ];
        }

        $order_export_model = new OrderExport();
        $result = $order_export_model->orderGoodsExport($condition, $condition_desc, $this->site_id, $is_verify, $order_label);
        return $result;
    }


    /**
     * 快递订单详情
     */
    public function detail()
    {
        $order_id = input("order_id", 0);
        $order_common_model = new OrderCommonModel();
        $order_detail_result = $order_common_model->getOrderDetail($order_id);
        $order_detail = $order_detail_result[ "data" ];
//        if(!empty($order_detail['package_list'])){
//            $order_detail['package_list'] = array_reverse($order_detail['package_list']);
//        }
        if (empty($order_detail)) return $this->error('未获取到订单数据', addon_url('shop/order/lists'));
        $this->assign("order_detail", $order_detail);
        switch ( $order_detail[ "order_type" ] ) {
            case 1 :
                $template = "order/detail";
                break;
            case 2 :
                $template = "storeorder/detail";
                break;
            case 3 :
                $template = "localorder/detail";
                break;
            case 4 :
                $template = "virtualorder/detail";
                break;
        }

        $this->assign("http_type", get_http_type());
        return $this->fetch($template);
    }

    /**
     * 订单设置
     */
    public function config()
    {
        $config_model = new ConfigModel();
        if (request()->isAjax()) {
            //订单事件时间设置数据
            $order_event_time_config_data = [
                'auto_close' => input('order_auto_close_time', 0),//订单未付款自动关闭时间 数字 单位(分钟)
                'auto_take_delivery' => input('order_auto_take_delivery_time', 0),//订单发货后自动收货时间 数字 单位(天)
                'auto_complete' => input('order_auto_complete_time', 0),//订单收货后自动完成时间 数字 单位(天)
                'after_sales_time' => input('after_sales_time', 0),//订单完成后可维权时间 数字 单位(天)
                'invoice_status' => input('invoice_status', 0),
                'invoice_rate' => input('invoice_rate', 0),
                'invoice_content' => implode(',', input('invoice_content', [])),
                'invoice_money' => input('invoice_money', 0),
                'invoice_type' => implode(',', input('invoice_type', [])),
                'change_price' => input('change_price', 1),//1 整单商品基础上改价 2 单个商品基础上改价
            ];
            //订单评价设置数据
            $order_evaluate_config_data = [
                'evaluate_status' => input('evaluate_status', 0),//订单评价状态（0关闭 1开启）
                'evaluate_show' => input('evaluate_show', 0),//显示评价（0关闭 1开启）
                'evaluate_audit' => input('evaluate_audit', 0),//评价审核状态（0关闭 1开启）
            ];

            //余额支付配置
            $balance_config_data = [
                'balance_show' => input('balance_show', 0),//余额支付配置（0关闭 1开启）
            ];

            $point_config_data = [
                "point_time_type" => input("point_time_type", 0),
                "point_time_one" => input("point_time_one", "") ? date_to_time(input("point_time_one")) : "",
//                "point_time_two" => input("point_time_two", 0)
            ];

            $res = $config_model->setOrderEventTimeConfig($order_event_time_config_data, $this->site_id, $this->app_module);
            $config_model->setOrderEvaluateConfig($order_evaluate_config_data, $this->site_id, $this->app_module);
            $config_model->setBalanceConfig($balance_config_data, $this->site_id, $this->app_module);
            $config_model->setPointTimeConfig($point_config_data, $this->site_id, $this->app_module);
            return $res;
        } else {
            $this->forthMenu();
            //订单事件时间设置
            $order_event_time_config = $config_model->getOrderEventTimeConfig($this->site_id, $this->app_module);
            $order_event_time_config[ 'data' ][ 'value' ]['invoice_content'] = explode(',', $order_event_time_config[ 'data' ][ 'value' ]['invoice_content']);
            $order_event_time_config[ 'data' ][ 'value' ]['invoice_type'] = explode(',', $order_event_time_config[ 'data' ][ 'value' ]['invoice_type']);
            //订单评价设置
            $order_evaluate_config = $config_model->getOrderEvaluateConfig($this->site_id, $this->app_module);


            //余额支付配置
            $balance_config = $config_model->getBalanceConfig($this->site_id, $this->app_module);
            $this->assign('balance_config', $balance_config[ 'data' ][ 'value' ]);
            $this->assign('order_event_time_config', $order_event_time_config[ 'data' ][ 'value' ]);
            $this->assign('order_evaluate_config', $order_evaluate_config[ 'data' ][ 'value' ]);

            $point_config = $config_model->getPointTimeConfig($this->site_id, $this->app_module);
            $this->assign('point_config', $point_config[ 'data' ][ 'value' ]);

            return $this->fetch('order/config');
        }
    }

    /**
     * 订单关闭
     * @return mixed
     */
    public function close()
    {
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $order_common_model = new OrderCommonModel();

            $log_data = [
                'uid'        => $this->user_info['uid'],
                'nick_name'  => $this->user_info['username'],
                'action_way' => 2
            ];

            $result = $order_common_model->orderClose($order_id,$log_data);
            return $result;
        }
    }

    /**
     * 订单调价
     * @return mixed
     */
    public function adjustPrice()
    {
        $config_model = new ConfigModel();
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $adjust_money = input("adjust_money", 0);
            $delivery_money = input("delivery_money", 0);
            $order_event_time_config = $config_model->getOrderEventTimeConfig($this->site_id, $this->app_module);
            $config = $order_event_time_config[ 'data' ][ 'value' ];
            $order_common_model = new OrderCommonModel();
            if($config['change_price'] == 1){ //按整单改价
                $result = $order_common_model->orderAdjustMoney($order_id, $adjust_money, $delivery_money);
            }else{ //按单个商品改价
                $result = $order_common_model->orderAdjustMoneyByGoods($order_id, $adjust_money, $delivery_money);
            }
            return $result;
        }
    }

    /**
     * 订单发货
     * @return mixed
     */
    public function delivery()
    {
        if (request()->isAjax()) {

            $order_model = new OrderModel();
            $data = array (
                "type" => input('type', 'manual'),//发货方式（手动发货、电子面单）
                "order_goods_ids" => input("order_goods_ids", ''),//商品id
                "express_company_id" => input("express_company_id", 0),//物流公司
                "delivery_no" => input("delivery_no", ''),//快递单号
                "order_id" => input("order_id", 0),//订单id
                "delivery_type" => input("delivery_type", 0),//是否需要物流
                "site_id" => $this->site_id,
                "template_id" => input('template_id', 0)//电子面单模板id
            );
            $log_data = [
                'uid'        => $this->user_info['uid'],
                'nick_name'  => $this->user_info['username'],
                'action'     => '商家对订单进行了发货',
                'action_way' => 2
            ];
            $result = $order_model->orderGoodsDelivery($data,1,$log_data);
            return $result;
        } else {
            $order_id = input("order_id", 0);
            $delivery_status = input("delivery_status", '');
            $order_common_model = new OrderCommonModel();
            $condition = array (
                [ "order_id", "=", $order_id ],
                [ "site_id", "=", $this->site_id ],
            );
            if ($delivery_status === '') {
                $condition[] = [ "delivery_status", "=", $delivery_status ];
            }
            $field = "order_goods_id, order_id, site_id, site_name, sku_name, sku_image, sku_no, is_virtual, price, cost_price, num, goods_money, cost_money, delivery_status, delivery_no, goods_id, delivery_status_name";
            $order_goods_list_result = $order_common_model->getOrderGoodsList($condition, $field, '', null, "delivery_no");
            $order_goods_list = $order_goods_list_result[ "data" ];
            $this->assign("order_goods_list", $order_goods_list);
            return $this->fetch("order/delivery");
        }
    }

    /**
     * 获取订单项列表
     */
    public function getOrderGoodsList()
    {
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $delivery_status = input("delivery_status", '');
            $order_common_model = new OrderCommonModel();
            $condition = array (
                [ "order_id", "=", $order_id ],
                [ "site_id", "=", $this->site_id ],
                [ "refund_status", "<>", 3 ],
            );
            if ($delivery_status != '') {
                $condition[] = [ "delivery_status", "=", $delivery_status ];
            }
            $field = "order_goods_id, order_id, site_id, sku_name, sku_image, sku_no, is_virtual, price, cost_price, num, goods_money, cost_money, delivery_status, delivery_no, goods_id, delivery_status_name";
            $result = $order_common_model->getOrderGoodsList($condition, $field, '', null, "");
            return $result;
        }
    }

    /**
     * 订单修改收货地址
     * @return mixed
     */
    public function editAddress()
    {
        $order_id = input("order_id", 0);
        if (request()->isAjax()) {
            $order_model = new OrderModel();
            $province_id = input("province_id");
            $city_id = input("city_id");
            $district_id = input("district_id");
            $community_id = input("community_id", 0);
            $address = input("address");
            $full_address = input("full_address");
            $longitude = input("longitude", 0);
            $latitude = input("latitude", 0);
            $mobile = input("mobile");
            $telephone = input("telephone");
            $name = input("name");
            $data = array (
                "province_id" => $province_id,
                "city_id" => $city_id,
                "district_id" => $district_id,
                "community_id" => $community_id,
                "address" => $address,
                "full_address" => $full_address,
                "longitude" => $longitude,
                "latitude" => $latitude,
                "mobile" => $mobile,
                "telephone" => $telephone,
                "name" => $name,
            );
            $condition = array (
                [ "order_id", "=", $order_id ],
                [ "site_id", "=", $this->site_id ]
            );
            $log_data = [
                'uid'        => $this->user_info['uid'],
                'nick_name'  => $this->user_info['username'],
                'action'     => '商家修改了收货地址',
                'action_way' => '2',
                'order_id'   => $order_id
            ];
            $result = $order_model->orderAddressUpdate($data, $condition, $log_data);
            return $result;
        }
    }

    /**
     * 获取订单信息
     */
    public function getOrderInfo()
    {
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $order_common_model = new OrderCommonModel();
            $condition = array (
                [ "order_id", "=", $order_id ],
                [ "site_id", "=", $this->site_id ],
            );
            $result = $order_common_model->getOrderInfo($condition);
            // 获取配送员信息
            $deliver_model = new ExpressDeliver();
            $deliver_list = $deliver_model->getDeliverLists([['site_id','=',$this->site_id]],'deliver_id,deliver_name,deliver_mobile');
            if(!empty($deliver_list['data'])){
                $result['data']['deliver_list'] = $deliver_list['data'];
            }
            return $result;
        }
    }

    /**
     * 获取订单 订单项内容
     */
    public function getOrderDetail()
    {
        $config_model = new ConfigModel();
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $order_common_model = new OrderCommonModel();
            $result = $order_common_model->getOrderDetail($order_id);

            //订单事件时间设置
            $order_event_time_config = $config_model->getOrderEventTimeConfig($this->site_id, $this->app_module);
            $result['data']['change_price'] = $order_event_time_config[ 'data' ][ 'value' ]['change_price']; //1在整单基础上改价 2在单个商品货款上改价
            return $result;
        }
    }

    /**
     * 卖家备注
     */
    public function orderRemark()
    {
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $remark = input("remark", 0);
            $order_common_model = new OrderCommonModel();
            $condition = array (
                [ "order_id", "=", $order_id ],
                [ "site_id", "=", $this->site_id ],
            );
            $data = array (
                "remark" => $remark
            );

            $log_data['action']     = '商家备注了订单，备注内容：'.$remark;
            $log_data['action_way'] = 2;
            $log_data['uid']        = $this->user_info['uid'];
            $log_data['nick_name']  = $this->user_info['username'];
            $log_data['order_id']   = $order_id;

            $result = $order_common_model->orderUpdate($data, $condition, $log_data);
            return $result;
        }
    }

    /**
     * 订单导出（已订单为主）
     */
    public function exportOrder()
    {
        $order_label_list = array (
            "order_no" => "订单号",
            "out_trade_no" => "外部单号",
            "name" => "收货人姓名",
            "mobile" => "收货人手机号",
            "order_name" => "商品名称",
            "nick_name" => "会员昵称"
        );

        $order_status = input("order_status", "");//订单状态
        $order_name = input("order_name", '');
        $pay_type = input("pay_type", '');
        $order_from = input("order_from", '');
        $start_time = input("start_time", '');
        $end_time = input("end_time", '');
        $order_label = !empty($order_label_list[ input("order_label") ]) ? input("order_label") : "";
        $search_text = input("search", '');
        $promotion_type = input("promotion_type", '');
        $order_type = input("order_type", 'all');
        $is_verify = input("is_verify", "all");
        $condition_desc = [];

        $order_common_model = new OrderCommon();
        $condition = [
            ["o.site_id", "=", $this->site_id],
            ["o.is_delete","=",0]
        ];
        //订单类型
        $order_type_name = '全部';
        if ($order_type != 'all') {
            $condition[] = [ "o.order_type", "=", $order_type ];

            $order_type_list = $order_common_model->getOrderTypeStatusList();
            $order_type_list = array_column($order_type_list, 'name', 'type');
            $order_type_name = $order_type_list[ $order_type ];
        }
        $condition_desc[] = [ 'name' => '订单类型', 'value' => $order_type_name ];

        //订单状态
        $order_status_name = '全部';
        if ($order_status != "") {
            if($order_status != 'refunding'){
                $condition[] = [ "o.order_status", "=", $order_status ];
                $order_status_list = $order_common_model->order_status;
                $order_status_name = $order_status_list[ $order_status ][ 'name' ] ?? '';
            }else{
                $join = [
                    [
                        'order_goods og',
                        'og.order_id = o.order_id',
                        'left'
                    ]
                ];
                $condition[] = [ "og.refund_status", "not in", [0,3] ];
                $order_status_name = '维权中';
            }


        }
        $condition_desc[] = [ 'name' => '订单状态', 'value' => $order_status_name ];

        //订单内容 模糊查询
        if ($order_name != "") {
            $condition[] = [ "o.order_name", 'like', "%$order_name%" ];
        }

        if($is_verify != "all"){
            $condition[] = [ "v.is_verify", "=", $is_verify ];
        }

        //订单来源
        $order_from_name = '全部';
        if ($order_from != "") {
            $condition[] = [ "o.order_from", "=", $order_from ];
            //订单来源 (支持端口)
            $order_from_list = Config::get("app_type");
            $order_from_name = $order_from_list[ $order_from ][ 'name' ] ?? '';
        }
        $condition_desc[] = [ 'name' => '订单来源', 'value' => $order_from_name ];


        //订单支付
        $pay_type_name = '全部';
        if ($pay_type != "") {
            $condition[] = [ "o.pay_type", "=", $pay_type ];
            $pay_type_list = $order_common_model->getPayType();
            $pay_type_name = $pay_type_list[ $pay_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '支付方式', 'value' => $pay_type_name ];

        //营销类型
        $promotion_type_name = '全部';
        if ($promotion_type != "") {
            if ($promotion_type == 'empty') {
                $condition[] = [ "o.promotion_type", "=", '' ];
            } else {
                $condition[] = [ "o.promotion_type", "=", $promotion_type ];
            }
            //营销活动类型
            $promotion_model = new PromotionModel();
            $promotion_type_list = $promotion_model->getPromotionType();
            $promotion_type_list = array_column($promotion_type_list, 'name', 'type');
            $promotion_type_name = $promotion_type_list[ $promotion_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '营销活动', 'value' => $promotion_type_name ];
        $time_name = '';
        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
            $time_name = $start_time . '起';
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
            $time_name = '至' . $end_time;
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
            $time_name = $start_time . ' 至 ' . $end_time;
        }
        $condition_desc[] = [ 'name' => '下单时间', 'value' => $time_name ];

        if($order_label != "nick_name"){
            if ($search_text != "") {
                $condition[] = [ 'o.'.$order_label, 'like', "%$search_text%" ];
            }
            foreach ($order_label_list as $k => $v) {
                $order_label_name = $v;
                if ($k == $order_label) {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => $search_text ];
                } else {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => '' ];
                }
            }
        }else{
            $condition[] = [ 'm.nickname', 'like', "%$search_text%" ];
        }

        $order_export_model = new OrderExport();

        $result = $order_export_model->orderExport($condition, $condition_desc, $this->site_id, $join ?? null, $is_verify, $order_label);
        return $result;
    }

    /**
     * 订单导出（已订单商品为主）
     */
    public function exportOrderGoods()
    {
        $order_label_list = array (
            "order_no" => "订单号",
            "out_trade_no" => "外部单号",
            "name" => "收货人姓名",
            "mobile" => "收货人手机号",
            "order_name" => "商品名称",
            "nick_name" => "会员昵称"
        );

        $order_status = input("order_status", "");//订单状态
        $order_name = input("order_name", '');
        $pay_type = input("pay_type", '');
        $order_from = input("order_from", '');
        $start_time = input("start_time", '');
        $end_time = input("end_time", '');

        $order_label = !empty($order_label_list[ input("order_label") ]) ? input("order_label") : "";

        $search_text = input("search", '');
        $promotion_type = input("promotion_type", '');
        $order_type = input("order_type", 'all');
        $is_verify = input("is_verify", "all");
        $condition_desc = [];

        $order_common_model = new OrderCommon();
        $condition = [
            ["o.site_id", "=", $this->site_id],
            ["o.is_delete","=",0]
        ];
        //订单类型
        $order_type_name = '全部';
        if ($order_type != 'all') {
            $condition[] = [ "o.order_type", "=", $order_type ];

            $order_type_list = $order_common_model->getOrderTypeStatusList();
            $order_type_list = array_column($order_type_list, 'name', 'type');
            $order_type_name = $order_type_list[ $order_type ];
        }
        $condition_desc[] = [ 'name' => '订单类型', 'value' => $order_type_name ];

        //订单状态
        $order_status_name = '全部';
        if ($order_status != "") {
            if($order_status != 'refunding'){
                $condition[] = [ "o.order_status", "=", $order_status ];
                $order_status_list = $order_common_model->order_status;
                $order_status_name = $order_status_list[ $order_status ][ 'name' ] ?? '';
            }else{
                $condition[] = [ "og.refund_status", "not in", [0,3] ];
                $order_status_name = '维权中';
            }


        }
        $condition_desc[] = [ 'name' => '订单状态', 'value' => $order_status_name ];

        //订单内容 模糊查询
        if ($order_name != "") {
            $condition[] = [ "o.order_name", 'like', "%$order_name%" ];
        }

        if($is_verify != "all"){
            $condition[] = [ "v.is_verify", "=", $is_verify ];
        }

        //订单来源
        $order_from_name = '全部';
        if ($order_from != "") {
            $condition[] = [ "o.order_from", "=", $order_from ];
            //订单来源 (支持端口)
            $order_from_list = Config::get("app_type");
            $order_from_name = $order_from_list[ $order_from ][ 'name' ] ?? '';
        }
        $condition_desc[] = [ 'name' => '订单来源', 'value' => $order_from_name ];


        //订单支付
        $pay_type_name = '全部';
        if ($pay_type != "") {
            $condition[] = [ "o.pay_type", "=", $pay_type ];
            $pay_type_list = $order_common_model->getPayType();
            $pay_type_name = $pay_type_list[ $pay_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '支付方式', 'value' => $pay_type_name ];

        //营销类型
        $promotion_type_name = '全部';
        if ($promotion_type != "") {
            if ($promotion_type == 'empty') {
                $condition[] = [ "o.promotion_type", "=", '' ];
            } else {
                $condition[] = [ "o.promotion_type", "=", $promotion_type ];
            }
            //营销活动类型
            $promotion_model = new PromotionModel();
            $promotion_type_list = $promotion_model->getPromotionType();
            $promotion_type_list = array_column($promotion_type_list, 'name', 'type');
            $promotion_type_name = $promotion_type_list[ $promotion_type ] ?? '';
        }
        $condition_desc[] = [ 'name' => '营销活动', 'value' => $promotion_type_name ];

        $time_name = '';
        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
            $time_name = $start_time . '起';
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
            $time_name = '至' . $end_time;
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
            $time_name = $start_time . ' 至 ' . $end_time;
        }
        $condition_desc[] = [ 'name' => '下单时间', 'value' => $time_name ];

        if($order_label != "nick_name"){
            if ($search_text != "") {
                $condition[] = [ 'o.' . $order_label, 'like', "%$search_text%" ];
            }
            foreach ($order_label_list as $k => $v) {
                $order_label_name = $v;
                if ($k == $order_label) {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => $search_text ];
                } else {
                    $condition_desc[] = [ 'name' => $order_label_name, 'value' => '' ];
                }
            }
        }else{
            $condition[] = [ 'm.nickname', 'like', "%$search_text%" ];
        }

        $order_export_model = new OrderExport();
        $result = $order_export_model->orderGoodsExport($condition, $condition_desc, $this->site_id, $is_verify, $order_label);
        return $result;
    }

    /**
     * 导出字段
     * @return array
     */
    public function getPrintingField()
    {
        $model = new OrderExport();
        $data = [
            'order_field' => $model->order_field,
            'order_goods_field' => $model->order_goods_field
        ];

        return success('1', '', $data);
    }

    public function printOrder()
    {
        $order_id = input('order_id', 0);
        $order_common_model = new OrderCommonModel();
        $order_detail_result = $order_common_model->getOrderDetail($order_id);
        $order_detail = $order_detail_result[ "data" ];
        $this->assign("order_detail", $order_detail);
        return $this->fetch('order/print_order');
    }

    /**
     * 交易记录
     */
    public function tradelist()
    {
        $order_common_model = new OrderCommonModel();
        if (request()->isAjax()) {
            $page = input('page', 1);
            $page_size = input('page_size', PAGE_LIST_ROWS);
            $member_id = input('member_id', 0);//会员id
            $search_text = input('search_text', 0);//h关键字查询
            $condition = array ();
            if ($member_id > 0) {
                $condition[] = [ "member_id", "=", $member_id ];
            }
            if (!empty($search_text)) {
                $condition[] = [ 'order_no|order_name', 'like', '%' . $search_text . '%' ];
            }

            return $order_common_model->getTradePageList($condition, $page, $page_size, "create_time desc");

        }
    }

    /**
     * 订单关闭
     * @return mixed
     */
    public function delete()
    {
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $order_common_model = new OrderCommonModel();
            $result = $order_common_model->orderDelete($order_id,$this->user_info);
            return $result;
        }
    }

    /**
     * 线下支付
     * @return array
     */
    public function offlinePay()
    {
        $log_data = [
            'uid'        => $this->user_info['uid'],
            'nick_name'  => $this->user_info['username'],
            'action_way' => 2
        ];
        if (request()->isAjax()) {
            $order_id = input("order_id", 0);
            $order_common_model = new OrderCommonModel();
            $result = $order_common_model->orderOfflinePay($order_id,$log_data);
            return $result;
        }
    }

    /**
     * 订单列表（发票）
     */
    public function invoiceOrderList()
    {
        if (request()->isAjax()) {
            $page_index = input('page', 1);
            $page_size = input('page_size', PAGE_LIST_ROWS);
            $invoice_status = input("invoice_status", '');
            $invoice_type = input('invoice_type','');
            $taxpayer_number = input('taxpayer_number','');
            $invoice_title = input('invoice_title','');
            $invoice_title_type = input('invoice_title_type','');
            $alias = 'o';
            $join = [];

            $condition = [
                [ "o.site_id", "=", $this->site_id ],
                [ 'o.is_delete', '=', 0 ],
                [ 'o.is_invoice', '=', 1 ]
            ];
            //发票状态
            if ($invoice_status != null){
                $condition[] = ['o.invoice_status', '=', $invoice_status];
            }
            //发票类型
            if (!empty($invoice_type)){
                $condition[] = ['o.invoice_type', '=', $invoice_type];
            }
            //纳税人识别号
            if (!empty($taxpayer_number)){
                $condition[] = ['o.taxpayer_number', 'like', '%'.$taxpayer_number.'%'];
                $condition[] = ['o.invoice_title_type', '=', 2];
            }
            //抬头类型
            if (!empty($invoice_title_type)){
                $condition[] = ['o.invoice_title_type', '=', $invoice_title_type];
            }
            //纳税人公司
            if (!empty($invoice_title)){
                $condition[] = ['o.invoice_title', 'like', '%'.$invoice_title.'%'];
            }
            //订单编号
            $order_no = input('order_no', '');
            if ($order_no) {
                $condition[] = [ "o.order_no", "like", "%" . $order_no . "%" ];
            }
            //订单状态
            $order_status = input('order_status', '');
            if ($order_status != "") {
                if($order_status != 'refunding'){
                    $condition[] = [ "o.order_status", "=", $order_status ];
                }else{
                    $join = [
                        [
                            'order_goods og',
                            'og.order_id = o.order_id',
                            'left'
                        ]
                    ];
                    $condition[] = [ "og.refund_status", "not in", [0,3] ];
                }
            }
            $order_type = input("order_type", 'all');//营销类型
            $start_time = input('start_time', '');
            $end_time = input('end_time', '');

            //订单类型
            if ($order_type != 'all') {
                $condition[] = [ "o.order_type", "=", $order_type ];
            }

            if (!empty($start_time) && empty($end_time)) {
                $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
            } elseif (empty($start_time) && !empty($end_time)) {
                $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
            } elseif (!empty($start_time) && !empty($end_time)) {
                $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
            }
            $order_common_model = new OrderCommonModel();
            $list = $order_common_model->getOrderPageList($condition, $page_index, $page_size, "o.create_time desc", 'o.*',$alias, $join);

            return $list;
        } else {
            $order_model = new OrderModel();
//            $order_status_list = $order_model->order_status;
            $order_common_model = new OrderCommonModel();
            $order_type_list = $order_common_model->getOrderTypeStatusList();
            $this->assign("order_status_list", $order_type_list[1]['status']);//订单状态
            $this->assign("order_type_list", $order_type_list);

            return $this->fetch('order/invoice_list');
        }
    }

    /**
     * 订单列表（发票编辑）
     */
    public function invoiceEdit()
    {
        if (request()->isAjax()) {
            //接收数据
            $order_id = input('order_id','');
            $invoice_status = input('invoice_status','');
            $invoice_code = input('invoice_code','');
            $invoice_remark = input('invoice_remark','');
            $condition = [
                 ["order_id", "=",  $order_id]
            ];

            $data['invoice_status'] = $invoice_status;
            $data['invoice_code'] = $invoice_code;
            $data['invoice_remark'] = $invoice_remark;
            $data['invoice_time'] = time();

            $order_common_model = new OrderCommonModel();
            $res = $order_common_model->orderUpdate($data,$condition);
            return $res;
        }else {
            $order_id = input('order_id','');
            $this->assign('order_id',$order_id);
            //订单详情
            $order_common_model = new OrderCommonModel();
            $order_detail = $order_common_model->getOrderDetail($order_id);
            if (empty($order_detail['data'])) return $this->error('未获取到订单数据', addon_url('shop/order/invoiceorderlist'));
            $this->assign('order_detail',$order_detail['data']);

            return $this->fetch('order/invoice_edit');
        }
    }
    /**
     * 发票导出
     */
    public function exportInvoice()
    {
        $page_index = input('page', 1);
        $page_size = 0;
        $condition = [
            [ "o.site_id", "=", $this->site_id ],
            [ 'o.is_delete', '=', 0 ],
            [ 'o.is_invoice', '=', 1 ]
        ];
        $alias = 'o';
        $join = null;
        //订单编号
        $order_no = input('order_no', '');
        if ($order_no) {
            $condition[] = [ "o.order_no", "like", "%" . $order_no . "%" ];
        }
        //订单状态
        $order_status = input('order_status', '');
        if ($order_status != "") {
            if($order_status != 'refunding'){
                $condition[] = [ "o.order_status", "=", $order_status ];
            }else{
                $join = [
                    [
                        'order_goods og',
                        'og.order_id = o.order_id',
                        'left'
                    ]
                ];
                $condition[] = [ "og.refund_status", "not in", [0,3] ];
            }
        }
        $order_type = input("order_type", 'all');//营销类型
        $start_time = input('start_time', '');
        $end_time = input('end_time', '');


        //订单类型
        if ($order_type != 'all') {
            $condition[] = [ "o.order_type", "=", $order_type ];
        }

        if (!empty($start_time) && empty($end_time)) {
            $condition[] = [ "o.create_time", ">=", date_to_time($start_time) ];
        } elseif (empty($start_time) && !empty($end_time)) {
            $condition[] = [ "o.create_time", "<=", date_to_time($end_time) ];
        } elseif (!empty($start_time) && !empty($end_time)) {
            $condition[] = [ 'o.create_time', 'between', [ date_to_time($start_time), date_to_time($end_time) ] ];
        }

        $order_common_model = new OrderCommonModel();
        $list_result = $order_common_model->getOrderPageList($condition, $page_index, $page_size, "o.create_time desc", 'o.*', $alias, $join);
        $list = $list_result[ 'data' ][ 'list' ];

        // 实例化excel
        $phpExcel = new \PHPExcel();

        $phpExcel->getProperties()->setTitle("退款维权订单");
        $phpExcel->getProperties()->setSubject("退款维权订单");
        //单独添加列名称
        $phpExcel->setActiveSheetIndex(0);

        $phpExcel->getActiveSheet()->setCellValue("A1", '订单编号');
        $phpExcel->getActiveSheet()->setCellValue("B1", '订单总额（元）');
        $phpExcel->getActiveSheet()->setCellValue("C1", '发票税费');
        $phpExcel->getActiveSheet()->setCellValue("D1", '发票邮寄费用');
        $phpExcel->getActiveSheet()->setCellValue("E1", '发票类型');
        $phpExcel->getActiveSheet()->setCellValue("F1", '发票抬头');
        $phpExcel->getActiveSheet()->setCellValue("G1", '抬头类型');
        $phpExcel->getActiveSheet()->setCellValue("H1", '纳税人识别号');
        $phpExcel->getActiveSheet()->setCellValue("I1", '发票内容');
        $phpExcel->getActiveSheet()->setCellValue("J1", '发票税率（%）');
        $phpExcel->getActiveSheet()->setCellValue("K1", '订单状态');
        $phpExcel->getActiveSheet()->setCellValue("L1", '下单时间');

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $start = $k + 2;
                $phpExcel->getActiveSheet()->setCellValue('A' . $start, $v[ 'order_no' ] . "\t");
                $phpExcel->getActiveSheet()->setCellValue('B' . $start, $v[ 'order_money' ] . "\t");
                $phpExcel->getActiveSheet()->setCellValue('C' . $start, $v[ 'invoice_money' ] . "\t");
                $phpExcel->getActiveSheet()->setCellValue('D' . $start, $v[ 'invoice_delivery_money' ] . "\t");

                $invoice_name = '';
                if ($v[ 'invoice_type' ] == 1) {
                    $invoice_name = '纸质';
                } else {
                    $invoice_name = '电子';
                }
                if ($v[ 'is_tax_invoice' ] == 1) {
                    $invoice_name .= '专用发票';
                } else {
                    $invoice_name .= '普通发票';
                }
                $phpExcel->getActiveSheet()->setCellValue('E' . $start, $invoice_name . "\t");
                $phpExcel->getActiveSheet()->setCellValue('F' . $start, $v[ 'invoice_title' ] . "\t");
                $invoice_title_type = $v[ 'invoice_title_type' ] == 1 ? '个人' : '企业';
                $phpExcel->getActiveSheet()->setCellValue('G' . $start, $invoice_title_type . "\t");
                $phpExcel->getActiveSheet()->setCellValue('H' . $start, $v[ 'taxpayer_number' ] . "\t");
                $phpExcel->getActiveSheet()->setCellValue('I' . $start, $v[ 'invoice_title_type' ] . "\t");
                $phpExcel->getActiveSheet()->setCellValue('J' . $start, $v[ 'invoice_rate' ] . "%\t");
                $phpExcel->getActiveSheet()->setCellValue('K' . $start, $v[ 'order_status_name' ] . "\t");
                $phpExcel->getActiveSheet()->setCellValue('L' . $start, time_to_date($v[ 'create_time' ]) . "\t");
            }
        }

        // 重命名工作sheet
        $phpExcel->getActiveSheet()->setTitle('发票列表');
        // 设置第一个sheet为工作的sheet
        $phpExcel->setActiveSheetIndex(0);
        // 保存Excel 2007格式文件，保存路径为当前路径，名字为export.xlsx
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $file = date('Y年m月d日-发票列表', time()) . '.xlsx';
        $objWriter->save($file);

        header("Content-type:application/octet-stream");

        $filename = basename($file);
        header("Content-Disposition:attachment;filename = " . $filename);
        header("Accept-ranges:bytes");
        header("Accept-length:" . filesize($file));
        readfile($file);
        unlink($file);
        exit;
    }

    /**
     * 确认收货
     */
    public function takeDelivery()
    {
        if (request()->isAjax()) {

            $order_id = input('order_id', '');
            $type = input('type', 0);

            $order_model = new OrderCommonModel();
            $log_data = [
                'uid'        => $this->user_info['uid'],
                'nick_name'  => $this->user_info['username'],
                'action_way' => 2
            ];
            if($type == 1){
                $error_num = 0;
                $success_num = 0;
                $order_arr = explode(",", $order_id);
                foreach ($order_arr as $key => $val){
                    $result = $order_model->orderCommonTakeDelivery($val,$log_data);
                    if($result['code'] >= 0){
                        $success_num += 1;
                    }else{
                        $error_num += 1;
                    }
                }
                return success(0, "成功".$success_num."条,失败".$error_num."条");

            }else{

                $result = $order_model->orderCommonTakeDelivery($order_id,$log_data);
                return $result;
            }
        }

    }

    /**
     * 订单导出记录
     * @return mixed
     */
    public function export()
    {
        if (request()->isAjax()) {
            $page_index = input('page', 1);
            $page_size = input('page_size', PAGE_LIST_ROWS);
            $export_model = new OrderExport();
            $condition = array (
                [ 'site_id', '=', $this->site_id ]
            );
            $result = $export_model->getExportPageList($condition, $page_index, $page_size, 'create_time desc', '*');
            return $result;
        } else {
            return $this->fetch("order/export");
        }
    }

    /**
     * 删除订单导出记录
     */
    public function deleteExport(){
        if (request()->isAjax()) {
            $export_ids = input('export_ids', '');

            $export_model = new OrderExport();
            $condition = array (
                [ 'site_id', '=', $this->site_id ],
                ['export_id', 'in', (string)$export_ids]
            );
            $result = $export_model->deleteExport($condition);
            return $result;
        }
    }
}
