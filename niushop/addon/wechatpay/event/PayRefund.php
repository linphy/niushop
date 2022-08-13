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
use addon\shopcomponent\model\Weapp;
/**
 * 原路退款
 */
class PayRefund
{
    /**
     * 原路退款
     */
    public function handle($params)
    {
        if ($params["pay_info"]["pay_type"] == "wechatpay") {

            if($params['is_video_number'] == 1){
                $weapp_model = new Weapp($params['site_id']);
                $refund_params = [
                    "out_aftersale_id" => $params['out_aftersale_id']
                ];
                $info = $weapp_model->getAftersale($refund_params);
                if($info['code'] == 0 && !empty($info['data'])){
                    $result = $weapp_model->orderRefund($refund_params);
                }else{
                    $pay_model = new PayModel(0, $params['site_id']);
                    $result    = $pay_model->refund($params);
                }
            }else{
                $pay_model = new PayModel(0, $params['site_id']);
                $result    = $pay_model->refund($params);
            }
            return $result;
        }
    }
}