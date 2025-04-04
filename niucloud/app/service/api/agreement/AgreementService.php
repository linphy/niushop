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

namespace app\service\api\agreement;


use app\service\core\sys\CoreAgreementService;
use core\base\BaseApiService;

/**
 * 协议服务类
 * Class AgreementService
 * @package app\service\admin\sys
 */
class AgreementService extends BaseApiService
{
    /**
     * 获取协议内容
     * @param string $key
     * @return array
     */
    public function getAgreement(string $key)
    {
        return ( new CoreAgreementService() )->getAgreement($key);
    }

}
