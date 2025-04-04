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

namespace app\dict\sys;

class RoleStatusDict
{

    const ON = 1;
    const OFF = 0;


    /**
     * 角色状态
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::ON => get_lang('dict_role.status_on'),//启用
            self::OFF => get_lang('dict_role.status_off'),//关闭
        ];
    }

}
