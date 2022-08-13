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

use app\model\message\Message;

/**
 * 核销码过期提醒
 */
class CronVerifyCodeExpire
{
    // 行为扩展的执行入口必须是run
    public function handle($data)
    {
        // 商品表
        $goods_virtual_info = model('goods_virtual')->getInfo([ [ "order_id", "=", $data[ "relate_id" ] ], [ 'expire_time', '<=', time() ], [ 'is_veirfy', '=', 0 ] ]);
        if (!empty($goods_virtual_info)) {
            ( new Message() )->sendMessage([ 'keywords' => 'VERIFY_CODE_EXPIRE', 'relate_id' => $data[ 'relate_id' ], 'site_id' => $goods_virtual_info[ 'site_id' ] ]);
        }
        return success();
    }
}