<?php

return [
    'SHOP_COMPONENT' => [
        'title' => get_lang('dict_diy.shop_component_type_basic'),
        'list' => [
            'GoodsList' => [
                'title' => '商品列表',
                'icon' => 'iconfont-iconshangpinliebiao',
                'path' => 'edit-goods-list',
                'support_page' => [],
                'uses' => 0,
                'sort' => 10011,
                'value' => [
                    'style' => 'style-1',
                    'source' => 'all',
                    'num' => 10,
                    'goods_category' => '',
                    "goods_category_name" => "请选择",
                    'goods_ids' => [],
                    "sortWay" => "default", // 排序方式，default：综合，sales：销量，price：价格
                    "goodsNameStyle" => [
                        "color" => "#303133",
                        "control" => true,
                        "fontWeight" => 'normal'
                    ],
                    "priceStyle" => [
                        "mainColor" => "#FF4142",
                        "mainControl" => true,
                        "lineColor" => "#999CA7",
                        "lineControl" => true
                    ],
                    "saleStyle" => [
                        "color" => "#999999",
                        "control" => true
                    ],
                ],
            ],
            'ShopSearch' => [
                'title' => '搜索',
                'icon' => 'iconfont-iconsousuo',
                'path' => 'edit-shop-search',
                'support_page' => [],
                'uses' => 1,
                'sort' => 10012,
                'value' => [
                    "searchStyle" => "style-1",
                    "searchLink" => [
                        "name" => ""
                    ],
                    "text" => "请输入搜索关键词",
                    "iconType" => "img",
                    "icon" => "",
                    "imageUrl" => ""
                ],
            ],
            'ManyGoodsList' => [
                'title' => '多商品组',
                'icon' => 'iconfont-iconduoshangpinzu',
                'path' => 'edit-many-goods-list',
                'support_page' => [],
                'uses' => 0,
                'sort' => 10013,
                'value' => [
                    'style' => 'style-2',
                    'num' => 6,
                    "sortWay" => "default", // 排序方式，default：综合，sales：销量，price：价格
                    "headStyle" => "style-1",
                    "aroundRadius" => 25,
                    "source" => "custom",
                    "goods_category" => '',
                    "goods_category_name" => '请选择',
                    "goodsNameStyle" => [
                        "color" => "#303133",
                        "control" => true,
                        "fontWeight" => 'normal'
                    ],
                    "priceStyle" => [
                        "mainColor" => "#FF4142",
                        "mainControl" => true,
                        "lineColor" => "#999CA7",
                        "lineControl" => true
                    ],
                    "saleStyle" => [
                        "color" => "#999999",
                        "control" => true
                    ],
                    "list" => [
                        [
                            "title" => "推荐",
                            "desc" => "猜你喜欢",
                            "source" => "all",
                            "goods_category" => '',
                            "goods_category_name" => '请选择',
                            "goods_ids" => [],
                            "imageUrl" => ''
                        ]
                    ]
                ],
            ],
            'GoodsCoupon' => [
                'title' => '优惠券',
                'icon' => 'iconfont-iconyouhuiquan1',
                'path' => 'edit-goods-coupon',
                'support_page' => [],
                'uses' => 0,
                'sort' => 10014,
                'value' => [
                    'style' => 'style-1',
                    "styleName" => "风格一",
                    'source' => 'all',
                    'num' => 6,
                    'couponIds' => [],
                    "btnText" => "立即领取",
                    'couponTitle' => '先领券 再购物',
                    'couponSubTitle' => '领券下单 享购物优惠'
                ],
            ],
            'ShopMemberInfo' => [
                'title' => '会员信息',
                'icon' => 'iconfont-iconhuiyuanzhongxin',
                'path' => 'edit-shop-member-info',
                'support_page' => [ 'DIY_SHOP_MEMBER_INDEX' ],
                'uses' => 1,
                'sort' => 10014,
                'value' => [
                    "style" => "style-1",
                    "styleName" => "风格1",
                    'bgUrl' => ''
                ],
            ],

        ]
    ],

];