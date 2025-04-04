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

namespace app\api\controller\agreement;

use app\service\api\agreement\AgreementService;
use core\base\BaseApiController;

/**
 * 协议控制器
 * Class Agreement
 * @package app\api\controller\agreement
 */
class Agreement extends BaseApiController
{
    public function info(string $key) {
        $res = (new AgreementService())->getAgreement($key);
        return success($res);
    }
}