<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

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