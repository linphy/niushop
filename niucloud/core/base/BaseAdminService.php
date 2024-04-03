<?php
// +----------------------------------------------------------------------
// | Niucloud-admin 企业快速开发的saas管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud-admin.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace core\base;

/**
 * 后台基础服务层
 * Class BaseAdminService
 * @package app\service\admin
 */
class BaseAdminService extends BaseService
{

    protected $username;
    protected $uid;

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->request->username();
        $this->uid = $this->request->uid();
    }
}
