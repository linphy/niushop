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

namespace app\service\core\scan;

use app\dict\scan\ScanDict;
use core\base\BaseCoreService;
use core\exception\CommonException;
use think\facade\Cache;
use think\facade\Log;

/**
 * 登录服务层
 * Class BaseService
 * @package app\service
 */
class CoreScanService extends BaseCoreService
{
    public static $cache_name = 'scan';
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 扫码生成
     * @param string $action
     * @param array $data
     * @param int|null $expire
     * @return array|string|string[]
     */
    public function scan(string $action, array $data, int $expire = null){
        $key = str_replace('==','', md5(uniqid('', true)));
        $cache_name = self::$cache_name.$key;
        $data['status'] = ScanDict::WAIT;
        $data['is_scan'] =  false;//是否被扫描
        $data['action'] = $action;
        $data['expire'] = $expire ? time() + $expire : 0;
        Cache::set($cache_name, $data, $expire);
        return $key;
    }

    /**
     * 更新扫码信息
     * @param string $key
     * @param array $data
     * @return true
     */
    public function actionByScan(string $key, array $data){
        $cache_name = self::$cache_name.$key;
        $cache =  Cache::get($cache_name);
        Log::write('scan_log_'.$key);
        if(!empty($cache)){
            $cache['is_scan'] = true;
            Cache::set($cache_name, event('Scan', array_merge($cache, $data))[0]);
        }
        return true;
    }


    /**
     * 校验扫码状态
     * @param string $key
     * @return mixed
     */
    public function checkScan(string $key){
        $cache_name = self::$cache_name.$key;
        $cache =  Cache::get($cache_name);
        if(empty($cache)) throw new CommonException('QRCODE_EXPIRE');
        return $cache;
    }

}
