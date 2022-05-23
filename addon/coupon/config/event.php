<?php
// 事件定义文件
return [
    'bind' => [
    ],

    'listen' => [

        //展示活动
        'ShowPromotion'     => [
            'addon\coupon\event\ShowPromotion',
        ],
        //优惠券自动关闭
        'CronCouponEnd'     => [
            'addon\coupon\event\CronCouponEnd',
        ],
        // 优惠券活动定时结束
        'CronCouponTypeEnd' => [
            'addon\coupon\event\CronCouponTypeEnd',
        ],

        //微信分享数据
        'WchatShareData' => [
            'addon\coupon\event\WchatShareData',
        ],
        //微信分享配置
        'WchatShareConfig' => [
            'addon\coupon\event\WchatShareConfig',
        ],
        //小程序分享数据
        'WeappShareData' => [
            'addon\coupon\event\WeappShareData',
        ],
        //小程序分享配置
        'WeappShareConfig' => [
            'addon\coupon\event\WeappShareConfig',
        ],
    ],

    'subscribe' => [
    ],
];
