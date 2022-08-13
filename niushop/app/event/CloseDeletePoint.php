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

use app\model\member\MemberAccount;

/**
 * 积分到时过期
 */
class CloseDeletePoint
{
    // 行为扩展的执行入口必须是runRT
    public function handle($data)
    {
        $member_account = new MemberAccount();
        $member_account->closeDeletePoint();
    }
}