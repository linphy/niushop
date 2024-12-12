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

namespace addon\shop\app\api\controller\order;

use addon\shop\app\service\api\order\InvoiceService;
use core\base\BaseApiController;
use think\Response;

class Invoice extends BaseApiController
{
    /**
     * 发票列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ['create_time', []],
            ['invoice_time', []],
            ['header_name', ''],
            ['header_type', 'all'],
            ['is_invoice', 'all'],
        ]);
        return success(( new InvoiceService() )->getPage($data));
    }

    /**
     * 发票详情
     * @param int $id
     * @return Response
     */
    public function info(int $id)
    {
        return success(( new InvoiceService() )->getInfo($id));
    }

}
