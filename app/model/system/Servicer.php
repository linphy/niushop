<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 山西牛酷信息科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\model\system;


use app\model\BaseModel;
use app\model\system\Config as ConfigModel;

/**
 * 客服配置
 */
class Servicer extends BaseModel
{
    /**
     * 设置客服配置
     * @param $data
     * @return array
     */
    public function setServicerConfig($data)
    {
        $config_model = new ConfigModel();
        $res = $config_model->setConfig($data, '客服配置', 1, [['site_id', '=', 1], ['app_module', '=', 'shop'], ['config_key', '=', 'SRRVICER_ROOT_CONFIG']]);
        return $res;
    }

    /**
     * 获取客服配置
     */
    public function getServicerConfig()
    {
        $config_model = new ConfigModel();
        $res = $config_model->getConfig([['site_id', '=', 1], ['app_module', '=', 'shop'], ['config_key', '=', 'SRRVICER_ROOT_CONFIG']]);
        $socket_url           = (get_http_type() === 'http' ? str_replace('http', 'ws', __ROOT__) : str_replace('https', 'wss', __ROOT__)) . '/wss';
        if (empty($res['data']['value'])) {
            $res['data']['value'] = [
                'system'     => 0,
                'weapp'      => 0,
                'open'       => 0,
                'open_pc'    => 0,
                'open_url'   => '',
                'socket_url' => $socket_url,
            ];
        }
        // 判断pc配置
        if(empty($res['data']['value']['open_pc'])){
            $res['data']['value']['open_pc'] = 0;
        }
        // 判断socket配置
        if(empty($res['data']['value']['socket_url'])){
            $res['data']['value']['socket_url'] = $socket_url;
        }
        return $res;
    }
}
