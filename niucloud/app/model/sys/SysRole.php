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

namespace app\model\sys;

use app\dict\sys\RoleStatusDict;
use core\base\BaseModel;

/**
 * 系统角色模型
 * Class SysRole
 * @package app\model\sys
 */
class SysRole extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'role_id';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'sys_role';
    // 设置json类型字段
    protected $json = [ 'rules', 'addon_keys' ];
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    public function getStatusNameAttr($value, $data)
    {
        return RoleStatusDict::getStatus()[ $data[ 'status' ] ] ?? '';
    }

}
