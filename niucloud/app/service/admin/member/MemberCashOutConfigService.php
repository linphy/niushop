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

namespace app\service\admin\member;

use app\model\member\MemberCashOut;
use app\service\core\member\CoreMemberCashOutConfigService;
use core\base\BaseAdminService;

/**
 * 会员提现设置服务层
 */
class MemberCashOutConfigService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new MemberCashOut();
    }


    public function getConfig(){
        return (new CoreMemberCashOutConfigService())->getMemberCashOutConfig();
    }

    public function setConfig(array $data){
        (new CoreMemberCashOutConfigService())->setMemberCashOutConfig($data);
        return true;
    }
}
