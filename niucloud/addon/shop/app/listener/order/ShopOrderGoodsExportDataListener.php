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

use addon\shop\app\model\order\Order;
use addon\shop\app\model\order\OrderGoods;
use think\db\Query;

/**
 * 订单项导出数据源查询
 * Class MemberExportTypeListener
 * @package app\listener\member
 */
class ShopOrderGoodsExportDataListener
{

    public function handle($param)
    {
        $data = [];
        if ($param['type'] == 'shop_order_goods') {
            $model = new Order();
            $orderGoodsModel = new OrderGoods();
            $order = 'order.create_time desc';
            $pay_where = [];
            if($param['where'][ 'pay_type' ]){
                $pay_where[] = ['pay.type', '=',  $param['where'][ 'pay_type' ] ];
            }
            //查询导出订单项数据
            $order_ids = $model->withSearch([ 'search_type', 'order_from', 'join_status', 'create_time', 'join_pay_time' ], $param['where'])
                ->withJoin([
                    'pay' => function(Query $query) use($pay_where){
                        $query->where($pay_where);
                    }], 'left')
                ->field('order_id')->order($order)->column('order_id');

            $order_goods_field = 'delivery_id,goods_name,sku_name,price,num,goods_money,discount_money,order_goods_money,order_refund_no,goods_type,delivery_status,status';
            $search_model = $orderGoodsModel->where([ ['order_id', 'in', $order_ids]])
                ->with([
                    'order_delivery' => function($query) {
                        $query->field('id, express_company_id, express_number')->with('company');
                    }
                ])
                ->field($order_goods_field)->append(['status_name', 'delivery_status_name', 'goods_type_name']);
            if ($param['page']['page'] > 0 && $param['page']['limit'] > 0) {
                $data = $search_model->page($param['page']['page'], $param['page']['limit'])->select()->toArray();
            } else {
                $data = $search_model->select()->toArray();
            }
            foreach ($data as $key => $val) {
                $data[$key]['order_refund_no'] = $val['order_refund_no']."\t";
                $data[$key]['express_number'] = !empty($val['order_delivery']) ? $val['order_delivery']['express_number']."\t" : '';
                $data[$key]['company_name'] = !empty($val['order_delivery']) ? (!empty($val['order_delivery']['company']) ? $val['order_delivery']['company']['company_name'] : '') : '';
            }
        }
        return $data;
    }
}
