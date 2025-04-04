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

namespace app\listener\member;

/**
 * 会员登录事件
 * Class MemberLoginListener
 * @package app\listener\member
 */
class MemberLoginListener
{
    /**
     * 接收会员对象
     * @param object $member
     */
    public function handle(object $member)
    {
        // 新人专享活动
        event("MemberLoginAfter", [ 'member_id' => $member[ 'member_id' ] ]);
        return;

    }
}