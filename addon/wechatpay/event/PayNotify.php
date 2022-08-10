<?php
// +---------------------------------------------------------------------+
// | NiuCloud | [ WE CAN DO IT JUST NiuCloud ]                |
// +---------------------------------------------------------------------+
// | Copy right 2019-2029 www.niucloud.com                          |
// +---------------------------------------------------------------------+
// | Author | NiuCloud <niucloud@outlook.com>                       |
// +---------------------------------------------------------------------+
// | Repository | https://github.com/niucloud/framework.git          |
// +---------------------------------------------------------------------+

namespace addon\wechatpay\event;

use addon\wechatpay\model\Pay as PayModel;
use app\model\system\Pay as PayCommon;

/**
 * 支付回调
 */
class PayNotify
{
    /**
     * 支付方式及配置
     */
    public function handle($param)
    {
        $postStr = file_get_contents('php://input');

        if (!empty($postStr)) {
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $postObj = json_encode($postObj);
            $post_data = json_decode($postObj, true);
            if (isset($post_data['out_trade_no'])) {
                $pay      = new PayCommon();
                $pay_info = $pay->getPayInfo($post_data['out_trade_no']);
                if($post_data['total_fee'] != round($pay_info['data']['pay_money'] * 100)){
                    return;
                }
                $pay_info = $pay_info['data'];
                if (!empty($pay_info)) {
                    $config = model('config')->getInfo([
                        ['value', 'like', "%{$post_data['appid']}%"],
                        ['config_key', 'in', ['WECHAT_CONFIG', 'WEAPP_CONFIG']],
                        ['app_module', '=', 'shop'],
                        ['site_id', '=', $pay_info['site_id']]
                    ], 'config_key');
                    if (!empty($config)) {
                        $is_weapp  = $config['config_key'] == 'WEAPP_CONFIG' ? 1 : 0;
                        $pay_model = new PayModel($is_weapp, $pay_info['site_id']);
                        $pay_model->payNotify();
                    }
                }
            }
        }
    }
}