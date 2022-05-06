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

namespace app\event;

use app\model\message\Sms;
use app\model\member\Member;

/**
 * 核销商品临期提醒
 */
class VerifyOrderOutTime
{
    // 行为扩展的执行入口必须是run
    public function handle($data)
    {
        // 商品表
        $goods_virtual_info = model('goods_virtual')->getInfo([ ["order_id", "=", $data["relate_id"] ] ]);
        // 总核销次数
        $total_verify_num =model('goods_virtual')->getCount([ ["order_id", "=", $data["relate_id"] ] ]);
        // 已核销次数
        $verify_num = model('goods_virtual')->getCount([ ["order_id", "=", $data["relate_id"] ], ['is_veirfy', '=', 1] ]);
        // 剩余次数
        $residue = $total_verify_num - $verify_num;
        // 用户信息
        $member_model = new Member();
        $member_info_result = $member_model->getMemberInfo([["member_id", "=", $goods_virtual_info['member_id']]]);
        $member_info = $member_info_result["data"];
        // 手机号
        $phone = model('order')->getValue([["order_id", "=", $data["relate_id"]]],'mobile');
        if($residue > 0){
            //模板消息
            // $message = new Message;
            // $param = [
            //     'keyword1' => $member_info['username'],//用户名称
            //     'keyword2' => $goods_virtual_info['sku_name'],//商品名称
            //     'keyword3' => date('Y-m-d H:i:s',$goods_virtual_info['expire_time'])//到期时间
            // ];
            // $message->sendMessage($param);

            // 短信消息
            $sms = new Sms();

            $var_parse = [
                'username' => $member_info['username'],//用户名称
                'sku_name' => $goods_virtual_info['sku_name'],//商品名称
                'expire_time' => date('Y-m-d H:i:s',$goods_virtual_info['expire_time'])//到期时间
            ];
            $data["sms_account"] = $phone;//手机号
            $data["var_parse"] = $var_parse;
            $sms->sendMessage($data);

        }
    }
}