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

namespace app\service\api\scan;

use app\service\core\scan\CoreScanService;
use core\base\BaseApiService;


/**
 * 登录服务层
 * Class BaseService
 * @package app\service
 */
class ScanService extends BaseApiService
{
    private $core_scan_service;

    public function __construct()
    {
        parent::__construct();
        $this->core_scan_service = new CoreScanService();
    }


    /**
     * 校验扫码信息
     * @param string $key
     * @return mixed
     */
    public function checkScan(string $key)
    {
        return $this->core_scan_service->checkScan($key);
    }

}
