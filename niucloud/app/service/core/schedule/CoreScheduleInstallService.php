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

namespace app\service\core\schedule;

use app\dict\schedule\ScheduleDict;
use app\model\sys\SysSchedule;
use core\base\BaseCoreService;

/**
 * 计划任务服务层
 */
class CoreScheduleInstallService extends BaseCoreService
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new SysSchedule();
    }

    /**
     * 安装系统内置计划任务
     * @return true
     */
    public function installSystemSchedule(){
        //安装系统计划任务
        $list = (new CoreScheduleService())->getTemplateList('system');
        $this->install($list);
        return true;
    }

    /**
     * 安装插件计划任务
     * @param string $addon
     * @return true
     */
    public function installAddonSchedule(string $addon){
        //安装系统计划任务
        $list = (new CoreScheduleService())->getTemplateList($addon);
        $this->install($list, $addon);
        return true;
    }

    /**
     * 卸载插件的计划任务
     * @param string $addon
     * @return true
     */
    public function uninstallAddonSchedule(string $addon){
        //安装系统计划任务
        $this->model->where([['addon', '=', $addon]])->delete();
        return true;
    }

    /**
     * 安装计划任务
     * @param array $data
     * @param string $addon
     * @return true
     */
    public function install(array $data, string $addon = ''){
        $schedule_list = [];
        foreach($data as $v){
            $isExist = $this->model->where([["key", "=", $v['key']], ['addon', '=', $addon]])->count();
            if (!$isExist) {
                $schedule_list[] = array(
                    'key' => $v['key'],
                    'status' => ScheduleDict::ON,
                    'time' => $v['time'],
                    'addon' => $addon
                );
            }
        }
        if (!empty($schedule_list)) $this->model->replace()->insertAll($schedule_list);
        return true;
    }


}
