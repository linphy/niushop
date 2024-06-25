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

namespace app\service\core\diy;

use app\dict\sys\ConfigKeyDict;
use app\model\diy\Diy;
use app\model\sys\SysConfig;
use app\service\core\sys\CoreConfigService;
use core\base\BaseCoreService;
use think\Model;

/**
 * 自定义页面相关
 * Class CoreDiyService
 * @package app\service\core\diy
 */
class CoreDiyService extends BaseCoreService
{
    /**
     * 删除自定义页面
     * @param $condition
     * @return mixed
     */
    public function del($condition)
    {
        return ( new Diy() )->where($condition)->delete();
    }
}
