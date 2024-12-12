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

namespace addon\shop\app\service\api\order;

use addon\shop\app\dict\order\InvoiceDict;
use addon\shop\app\model\order\Invoice;
use core\base\BaseApiService;

/**
 * 发票
 * Class InvoiceService
 * @package app\service\admin
 */
class InvoiceService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Invoice();
    }

    public function getPage(array $where)
    {
        $order = 'id desc';
        $search_model = $this->model->withSearch(['is_invoice', 'header_type', 'header_name', 'create_time', 'invoice_time'], $where)
            ->with(['orderData'])
            ->where([ ['member_id', '=', $this->member_id], [ 'status', '=', InvoiceDict::OPEN ] ])->append([ 'header_type_name', 'type_name', 'is_invoice_name' ])->field('*')->order($order);
        return $this->pageQuery($search_model, function($item, $key) {
            $item_pay = $item['orderData']['pay'];
            if(!empty($item_pay)){
                $item_pay->append(['type_name']);
            }
        });
    }

    /**
     * 发票信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $search_model = $this->model->where([ [ 'id', '=', $id ], ['member_id', '=', $this->member_id], [ 'status', '=', InvoiceDict::OPEN ] ])->with(['orderData'])->field('*')->append([ 'header_type_name', 'type_name', 'is_invoice_name' ])->findOrEmpty();
        $item_pay = $search_model['orderData']['pay'];
        if(!empty($item_pay)){
            $item_pay->append(['type_name']);
        }
        return $search_model->toArray();
    }

}
