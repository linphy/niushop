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

namespace app\adminapi\controller\sys;

use app\service\admin\schedule\ScheduleLogService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 计划任务执行记录
 */
class ScheduleLog extends BaseAdminController
{
    /**
     * 任务执行记录列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ['schedule_id', ''],
            ['key', ''],
            ['status', 'all'],
            ['execute_time', []]
        ]);
        return success(data: (new ScheduleLogService())->getPage($data));

    }

}
