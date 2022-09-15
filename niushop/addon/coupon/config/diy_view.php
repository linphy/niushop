<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */
return [
    'util' => [
        [
            'name' => 'Coupon',
            'title' => '优惠券',
            'type' => 'PROMOTION',
            'value' => '{"style":1,"sources":"initial","styleName":"风格一","couponIds":[],"count":6,"previewList":[],"nameColor":"","moneyColor":"#FFFFFF","limitColor":"#FFFFFF","btnStyle":{"maxLen": 4,"textColor":"#FFFFFF","bgColor":"","text":"立即领取","aroundRadius":0,"isBgColor":false,"isAroundRadius":false},"isName":false,"couponBgColor":"","couponBgUrl":"","couponType":"img","ifNeedBg":true}',
            'sort' => '30000',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconyouhuiquan',
        ],
    ],
    'link' => [
        [
            'name' => 'COUPON_LIST',
            'title' => '优惠券',
            'parent' => 'MARKETING_LINK',
            'wap_url' => '',
            'web_url' => '',
            'sort' => 0,
            'child_list' => [
                [
                    'name' => 'COUPON_PREFECTURE',
                    'title' => '优惠券专区',
                    'parent' => '',
                    'wap_url' => '/pages_tool/goods/coupon',
                    'web_url' => '',
                    'sort' => 0
                ]
            ]
        ],
    ]
];