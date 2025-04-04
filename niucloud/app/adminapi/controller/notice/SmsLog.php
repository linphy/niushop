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

namespace app\adminapi\controller\notice;

use app\service\admin\notice\NoticeSmsLogService;
use core\base\BaseAdminController;
use think\Response;

class SmsLog extends BaseAdminController
{

    /**
     * 短信发送记录列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ['mobile', ''],
            ['sms_type', ''],
            ['key', ''],
            ['create_time', []],
        ]);

        $res = (new NoticeSmsLogService())->getPage($data);
        return success($res);
    }

    public function info($id)
    {
        $res = (new NoticeSmsLogService())->getInfo($id);
        return success($res);
    }

}
