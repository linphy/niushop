<?php

return [
    'DIY_SHOP_INDEX' => [
        'shop_index_style1' => [ // 页面标识
            "title" => "商城首页（风格一）", // 页面名称
            'cover' => 'addon/shop/diy/template/shop_index_one_cover.png', // 页面封面图
            'preview' => '', // 页面预览图
            'desc' => '', // 页面描述
            'mode' => 'diy', // 页面模式：diy：自定义，fixed：固定
            // 页面数据源
            "data" => [
                "global" => [
                    "title" => "首页",
                    'pageStartBgColor' => 'rgba(246, 246, 246, 1)',
                    'pageEndBgColor' => '',
                    'pageGradientAngle' => 'to bottom',
                    "bgUrl" => "",
                    'bgHeightScale' => 0,
                    "imgWidth" => "",
                    "imgHeight" => "",
                    "topStatusBar" => [
                        "bgColor" => "#ffffff",
                        "isTransparent" => false,
                        "isShow" => true,
                        "style" => "style-1",
                        "textColor" => "#333333",
                        "textAlign" => "center"
                    ],
                    "bottomTabBarSwitch" => true,
                    "popWindow" => [
                        "imgUrl" => "",
                        "imgWidth" => "",
                        "imgHeight" => "",
                        "count" => -1,
                        "show" => 0,
                        "link" => [
                            "name" => ""
                        ]
                    ],
                    "template" => [
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 0
                        ]
                    ]
                ],
                "value" => [
                    [
                        "path" => "edit-carousel-search",
                        "uses" => 1,
                        "position" => "top_fixed",
                        "id" => "5wyf9s0k8jw0",
                        "componentName" => "CarouselSearch",
                        "componentTitle" => "轮播搜索",
                        "ignore" => [
                            "marginTop",
                            "marginBottom"
                        ],
                        "positionWay" => "fixed",
                        "fixedBgColor" => "",
                        'bgGradient' => true,
                        "search" => [
                            "logo" => "addon/shop/diy/index/style2/logo.png",
                            "text" => "请输入搜索关键词",
                            "link" => [
                                'name' => 'SHOP_GOODS_SEARCH',
                                'title' => '商品搜索',
                                'url' => '/addon/shop/pages/goods/search',
                                'is_share' => 1,
                                'action' => ''
                            ],
                            'hotWord' => [
                                "interval" => 3,
                                'list' => [
                                    [
                                        'text' => '新品推荐'
                                    ],
                                    [
                                        'text' => '爆款'
                                    ]
                                ]
                            ]
                        ],
                        "tab" => [
                            "control" => true,
                            "noColor" => "rgba(255, 255, 255, 1)",
                            "selectColor" => "rgba(255, 255, 255, 1)",
                            "fixedNoColor" => "rgba(255, 255, 255, 1)",
                            "fixedSelectColor" => "rgba(255, 255, 255, 1)",
                            "list" => [
                                [
                                    "text" => "精选",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => "",
                                    "id" => "4tbvliuezhq0"
                                ],
                                [
                                    "text" => "猜你喜欢",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => "",
                                    "id" => "1rpxkuehd03k"
                                ],
                                [
                                    "text" => "蔬菜",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => "",
                                    "id" => "6d0zybcxzvc0"
                                ],
                                [
                                    "text" => "水果",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => "",
                                    "id" => "17r58ld9i8xs"
                                ],
                                [
                                    "id" => "5acf7ab4f040",
                                    "text" => "海鲜",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => ""
                                ],
                                [
                                    "id" => "37a9vwqt1r20",
                                    "text" => "熟食",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => ""
                                ],
                                [
                                    "id" => "1en9w5jstvs0",
                                    "text" => "米面",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => ""
                                ],
                                [
                                    "id" => "3ae14irgqoa0",
                                    "text" => "粮油",
                                    "source" => "diy_page",
                                    "diy_id" => 0,
                                    "diy_title" => " "
                                ]
                            ]
                        ],
                        "swiper" => [
                            "control" => true,
                            "interval" => 5,
                            "indicatorColor" => "rgba(0, 0, 0, 0.3)",
                            "indicatorActiveColor" => "#FF0E0E",
                            'indicatorStyle' => 'style-1',
                            'indicatorAlign' => 'center',
                            'swiperStyle' => 'style-1',
                            "imageHeight" => 164,
                            "topRounded" => 10,
                            "bottomRounded" => 10,
                            "list" => [
                                [
                                    "imageUrl" => "addon/shop/diy/index/style2/banner1.png",
                                    "imgWidth" => 630,
                                    "imgHeight" => 300,
                                    "link" => [
                                        "name" => ""
                                    ],
                                    "id" => "2ywogh006ai0",
                                    "width" => 345,
                                    "height" => 164.28571428571428
                                ],
                                [
                                    "id" => "3p7wiewe0o00",
                                    "imageUrl" => "addon/shop/diy/index/style2/banner2.png",
                                    "imgWidth" => 630,
                                    "imgHeight" => 300,
                                    "link" => [
                                        "name" => ""
                                    ]
                                ],
                                [
                                    "imageUrl" => "addon/shop/diy/index/style2/banner1.png",
                                    "imgWidth" => 630,
                                    "imgHeight" => 300,
                                    "link" => [
                                        "name" => ""
                                    ],
                                    "id" => "5yeoqr006ai0"
                                ]
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 0
                        ]
                    ],
                    [
                        "path" => "edit-graphic-nav",
                        "uses" => 0,
                        "id" => "6lvx8ztvquc0",
                        "componentName" => "GraphicNav",
                        "componentTitle" => "图文导航",
                        "ignore" => [],
                        "layout" => "horizontal",
                        "mode" => "graphic",
                        "showStyle" => "fixed",
                        "rowCount" => 5,
                        "pageCount" => 2,
                        "carousel" => [
                            "type" => "circle",
                            "color" => "#FFFFFF"
                        ],
                        "imageSize" => 40,
                        "aroundRadius" => 25,
                        "font" => [
                            "size" => 12,
                            "weight" => "normal",
                            "color" => "#303133"
                        ],
                        "list" => [
                            [
                                "title" => "商品分类",
                                "link" => [
                                    "name" => "SHOP_GOODS_CATEGORY",
                                    "parent" => "SHOP_LINK",
                                    "title" => "商品分类",
                                    "url" => "/addon/shop/pages/goods/category",
                                    "action" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/index/style2/nav_goods_category.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "1evjnc3zeb5s",
                                "imgWidth" => 180,
                                "imgHeight" => 180
                            ],
                            [
                                "title" => "分销管理",
                                "link" => [
                                    "name" => "SHOP_FENXIAO_INDEX",
                                    "parent" => "SHOP_FENXIAO_LINK",
                                    "title" => "分销中心",
                                    "url" => "/addon/shop_fenxiao/pages/index",
                                    "action" => "decorate"
                                ],
                                "imageUrl" => "addon/shop/diy/index/style2/nav_fenxiao.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "2ktzer8wrnc0",
                                "imgWidth" => 180,
                                "imgHeight" => 180
                            ],
                            [
                                "title" => "领券中心",
                                "link" => [
                                    "name" => "SHOP_COUPON_LIST",
                                    "parent" => "SHOP_LINK",
                                    "title" => "优惠券列表",
                                    "url" => "/addon/shop/pages/coupon/list",
                                    "action" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/index/style2/nav_coupon.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "3bmtyrslxxy0",
                                "imgWidth" => 180,
                                "imgHeight" => 180
                            ],
                            [
                                "title" => "会员中心",
                                "link" => [
                                    "name" => "SHOP_MEMBER_INDEX",
                                    "parent" => "SHOP_LINK",
                                    "title" => "商城个人中心",
                                    "url" => "/addon/shop/pages/member/index",
                                    "action" => "decorate"
                                ],
                                "imageUrl" => "addon/shop/diy/index/style2/nav_member_index.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "4aixr8qu5ek0",
                                "imgWidth" => 180,
                                "imgHeight" => 180
                            ],
                            [
                                "id" => "6iux9g1aojo0",
                                "title" => "新闻资讯",
                                "imageUrl" => "addon/shop/diy/index/style2/nav_news_info.png",
                                "imgWidth" => 180,
                                "imgHeight" => 180,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "7jggy5euv3w0",
                                "title" => "购物车",
                                "imageUrl" => "addon/shop/diy/index/style2/nav_cart.png",
                                "imgWidth" => 180,
                                "imgHeight" => 180,
                                "link" => [
                                    "name" => "SHOP_GOODS_CART",
                                    "parent" => "SHOP_LINK",
                                    "title" => "购物车",
                                    "url" => "/addon/shop/pages/goods/cart",
                                    "action" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "7bqpc6bjha80",
                                "title" => "我的订单",
                                "imageUrl" => "addon/shop/diy/index/style2/nav_my_order.png",
                                "imgWidth" => 180,
                                "imgHeight" => 180,
                                "link" => [
                                    "name" => "SHOP_ORDER_LIST",
                                    "parent" => "SHOP_LINK",
                                    "title" => "订单列表",
                                    "url" => "/addon/shop/pages/order/list",
                                    "action" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "tgo5qmjawnk",
                                "title" => "我的积分",
                                "imageUrl" => "addon/shop/diy/index/style2/nav_my_point.png",
                                "imgWidth" => 180,
                                "imgHeight" => 180,
                                "link" => [
                                    "name" => "MEMBER_POINT",
                                    "parent" => "MEMBER_LINK",
                                    "title" => "我的积分",
                                    "url" => "/app/pages/member/point",
                                    "action" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "1fprven2cqrk",
                                "title" => "我的余额",
                                "imageUrl" => "addon/shop/diy/index/style2/nav_my_balance.png",
                                "imgWidth" => 180,
                                "imgHeight" => 180,
                                "link" => [
                                    "name" => "MEMBER_BALANCE",
                                    "parent" => "MEMBER_LINK",
                                    "title" => "我的余额",
                                    "url" => "/app/pages/member/balance",
                                    "action" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "2wggehpnako0",
                                "title" => "地址管理",
                                "imageUrl" => "addon/shop/diy/index/style2/nav_my_address.png",
                                "imgWidth" => 180,
                                "imgHeight" => 180,
                                "link" => [
                                    "name" => "MEMBER_ADDRESS",
                                    "parent" => "MEMBER_LINK",
                                    "title" => "收货地址",
                                    "url" => "/app/pages/member/address",
                                    "action" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 8,
                        "bottomRounded" => 8,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-notice",
                        "uses" => 0,
                        "id" => "4m9g2ylz1di0",
                        "componentName" => "Notice",
                        "componentTitle" => "公告",
                        "ignore" => [],
                        "noticeType" => "img",
                        "imgType" => "system",
                        "systemUrl" => "style_2",
                        "imageUrl" => "",
                        "showType" => "popup",
                        "scrollWay" => "upDown",
                        "fontSize" => 12,
                        "fontWeight" => "normal",
                        "noticeTitle" => "公告",
                        "list" => [
                            [
                                "text" => "最新公告：欢迎来到小店参观！",
                                "link" => [
                                    "name" => ""
                                ],
                                "id" => "1rz6s4buaxc0"
                            ],
                            [
                                "id" => "2wksdax75fc0",
                                "text" => "最新公告：欢迎来到小店参观！",
                                "link" => [
                                    "name" => ""
                                ]
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 6,
                        "bottomRounded" => 6,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-goods-coupon",
                        "uses" => 0,
                        "id" => "52ldidxgpcg0",
                        "componentName" => "GoodsCoupon",
                        "componentTitle" => "优惠券",
                        "ignore" => [
                            "componentBgColor",
                            "componentBgUrl"
                        ],
                        "style" => "style-1",
                        "styleName" => "风格一",
                        "source" => "all",
                        "num" => 6,
                        "couponIds" => [],
                        "btnText" => "立即领取",
                        "couponTitle" => "先领券 再购物",
                        "couponSubTitle" => "领券下单 享购物优惠",
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-active-cube",
                        "uses" => 0,
                        "id" => "717m86hlcho0",
                        "componentName" => "ActiveCube",
                        "componentTitle" => "活动魔方",
                        "ignore" => [],
                        "titleStyle" => [
                            "title" => "风格1",
                            "value" => "style-1"
                        ],
                        "text" => "超值爆款",
                        "textLink" => [
                            "name" => ""
                        ],
                        "titleColor" => "#F91700",
                        "subTitle" => [
                            "text" => "为您精选爆款",
                            "textColor" => "#FFFFFF",
                            "startColor" => "#FB792F",
                            "endColor" => "#F91700",
                            "link" => [
                                "name" => ""
                            ],
                        ],
                        "blockStyle" => [
                            "title" => "风格4",
                            "value" => "style-4",
                            'fontWeight' => 'bold'
                        ],
                        "list" => [
                            [
                                "title" => [
                                    "text" => "今日推荐",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "诚意推荐",
                                    "textColor" => "rgba(237, 110, 0, 1)",
                                    "startColor" => "rgba(243, 218, 197, 1)",
                                    "endColor" => "rgba(255, 228, 217, 1)"
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#FEA715",
                                    "endColor" => "#FE1E00",
                                ],
                                "listFrame" => [
                                    "startColor" => "rgba(255, 173, 77, 1)",
                                    "endColor" => "rgba(249, 61, 2, 1)"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods1.png",
                                "id" => "bvn98cr8j1s"
                            ],
                            [
                                "title" => [
                                    "text" => "优惠好物",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "领券优惠",
                                    "textColor" => "rgba(46, 89, 233, 1)",
                                    "startColor" => "rgba(205, 217, 248, 1)",
                                    "endColor" => "rgba(205, 217, 248, 1)"
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#FFBF50",
                                    "endColor" => "#FF9E03"
                                ],
                                "listFrame" => [
                                    "startColor" => "rgba(124, 167, 244, 1)",
                                    "endColor" => "rgba(43, 86, 233, 1)"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods2.png",
                                "id" => "6u24tqbyc780"
                            ],
                            [
                                "title" => [
                                    "text" => "热销推荐",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "热销商品",
                                    "textColor" => "rgba(246, 47, 85, 1)",
                                    "startColor" => "rgba(252, 216, 219, 1)",
                                    "endColor" => "rgba(252, 216, 219, 1)"
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#A2E792",
                                    "endColor" => "#49CD2D"
                                ],
                                "listFrame" => [
                                    "startColor" => "rgba(255, 127, 72, 1)",
                                    "endColor" => "rgba(238, 51, 91, 1)"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods3.png",
                                "id" => "6dn1yt1j0as0"
                            ],
                            [
                                "title" => [
                                    "text" => "书桌好物",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "好物推荐",
                                    "textColor" => "rgba(19, 155, 60, 1)",
                                    "startColor" => "rgba(211, 241, 218, 1)",
                                    "endColor" => "rgba(211, 241, 218, 1)"
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#4AC1FF",
                                    "endColor" => "#1D7CFF",
                                ],
                                "listFrame" => [
                                    "startColor" => "rgba(144, 212, 140, 1)",
                                    "endColor" => "rgba(41, 159, 79, 1)"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods4.png",
                                "id" => "4q9zphidqtm0"
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "#ffffff",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 6,
                        "bottomRounded" => 6,
                        "elementBgColor" => "#FFFAF5",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-active-cube",
                        "uses" => 0,
                        "id" => "3keeqqrkpxk0",
                        "componentName" => "ActiveCube",
                        "componentTitle" => "活动魔方",
                        "ignore" => [],
                        "titleStyle" => [
                            "title" => "风格4",
                            "value" => "style-4"
                        ],
                        "text" => "数码产品",
                        "textLink" => [
                            "name" => ""
                        ],
                        "titleColor" => "rgba(255, 255, 255, 1)",
                        "subTitle" => [
                            "text" => "去逛逛",
                            "textColor" => "#303133",
                            "startColor" => "rgba(255, 255, 255, 1)",
                            "endColor" => "rgba(255, 255, 255, 1)",
                            "link" => [
                                "name" => ""
                            ],
                        ],
                        "blockStyle" => [
                            "title" => "风格3",
                            "value" => "style-3",
                            'fontWeight' => 'normal'
                        ],
                        "list" => [
                            [
                                "title" => [
                                    "text" => "蓝牙耳机",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "诚意推荐",
                                    "textColor" => "#999999",
                                    "startColor" => "",
                                    "endColor" => ""
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#FEA715",
                                    "endColor" => "#FE1E00"
                                ],
                                "listFrame" => [
                                    "startColor" => "#FEA715",
                                    "endColor" => "#FE1E00"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods5.png",
                                "id" => "5am2l07pkr00"
                            ],
                            [
                                "title" => [
                                    "text" => "医用雾化",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "领券更优惠",
                                    "textColor" => "#999999",
                                    "startColor" => "",
                                    "endColor" => ""
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#FFBF50",
                                    "endColor" => "#FF9E03"
                                ],
                                "listFrame" => [
                                    "startColor" => "#FFBF50",
                                    "endColor" => "#FF9E03"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods6.png",
                                "id" => "2v4zusih9u80"
                            ],
                            [
                                "title" => [
                                    "text" => "智能手表",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "本周热销商品",
                                    "textColor" => "#999999",
                                    "startColor" => "",
                                    "endColor" => ""
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#A2E792",
                                    "endColor" => "#49CD2D"
                                ],
                                "listFrame" => [
                                    "startColor" => "#A2E792",
                                    "endColor" => "#49CD2D"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods7.png",
                                "id" => "va5dyomnq68"
                            ],
                            [
                                "title" => [
                                    "text" => "甜心咖啡",
                                    "textColor" => "#303133"
                                ],
                                "subTitle" => [
                                    "text" => "办公好物推荐",
                                    "textColor" => "#999999",
                                    "startColor" => "",
                                    "endColor" => ""
                                ],
                                "moreTitle" => [
                                    "text" => "去看看",
                                    "startColor" => "#4AC1FF",
                                    "endColor" => "#1D7CFF"
                                ],
                                "listFrame" => [
                                    "startColor" => "#4AC1FF",
                                    "endColor" => "#1D7CFF"
                                ],
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "static/resource/images/diy/active_cube/active_cube_goods8.png",
                                "id" => "4h16lw3ntsw0"
                            ]
                        ],
                        "textColor" => "#303133",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "static/resource/images/diy/active_cube/active_cube_bg.png",
                        "componentBgAlpha" => 7,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 6,
                        "bottomRounded" => 6,
                        "elementBgColor" => "#FFFAF5",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-horz-blank",
                        "uses" => 0,
                        "id" => "6nc7hkh3g100",
                        "componentName" => "HorzBlank",
                        "componentTitle" => "辅助空白",
                        "ignore" => [
                            "pageBgColor",
                            "componentBgUrl"
                        ],
                        "textColor" => "#303133",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentStartBgColor" => "rgba(251, 148, 62, 1)",
                        "componentEndBgColor" => "rgba(252, 49, 49, 1)",
                        "componentGradientAngle" => "to right",
                        "topRounded" => 6,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 0,
                            "both" => 10
                        ],
                        "height" => 10
                    ],
                    [
                        "path" => "edit-text",
                        "uses" => 0,
                        "position" => "",
                        "id" => "7f1nc9pkntw0",
                        "componentName" => "Text",
                        "componentTitle" => "标题",
                        "ignore" => [],
                        "style" => "style-2",
                        "styleName" => "风格2",
                        "text" => "新人尝鲜价",
                        "link" => [
                            "name" => ""
                        ],
                        "textColor" => "#FFFFFF",
                        "fontSize" => 16,
                        "fontWeight" => "normal",
                        "textAlign" => "center",
                        "subTitle" => [
                            "text" => "数量有限 抢完为止",
                            "color" => "#FFFFFF",
                            "fontSize" => 14,
                            "control" => true,
                            "fontWeight" => "normal"
                        ],
                        "more" => [
                            "text" => "查看更多",
                            "control" => true,
                            "isShow" => false,
                            "link" => [
                                "name" => ""
                            ],
                            "color" => "#999999"
                        ],
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(251, 148, 62, 1)",
                        "componentEndBgColor" => "rgba(252, 49, 49, 1)",
                        "componentGradientAngle" => "to right",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-horz-blank",
                        "uses" => 0,
                        "id" => "1o6ptkjsnabk",
                        "componentName" => "HorzBlank",
                        "componentTitle" => "辅助空白",
                        "ignore" => [
                            "pageBgColor",
                            "componentBgUrl"
                        ],
                        "textColor" => "#303133",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentStartBgColor" => "rgba(251, 148, 62, 1)",
                        "componentEndBgColor" => "rgba(252, 49, 49, 1)",
                        "componentGradientAngle" => "to right",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 10
                        ],
                        "height" => 10
                    ],
                    [
                        "path" => "edit-goods-list",
                        "uses" => 0,
                        "id" => "17uao387qdds",
                        "componentName" => "GoodsList",
                        "componentTitle" => "商品列表",
                        "ignore" => [],
                        "style" => "style-3",
                        "source" => "all",
                        "num" => 10,
                        "goods_category" => "",
                        "goods_category_name" => "请选择",
                        "goods_ids" => [],
                        "sortWay" => "default",
                        "goodsNameStyle" => [
                            "color" => "#303133",
                            "control" => true,
                            "fontWeight" => "normal"
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
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(251, 148, 62, 1)",
                        "componentEndBgColor" => "rgba(252, 49, 49, 1)",
                        "componentGradientAngle" => "to right",
                        "topRounded" => 0,
                        "bottomRounded" => 6,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-horz-blank",
                        "uses" => 0,
                        "id" => "4z9jltfk8jc0",
                        "componentName" => "HorzBlank",
                        "componentTitle" => "辅助空白",
                        "ignore" => [
                            "pageBgColor",
                            "componentBgUrl"
                        ],
                        "textColor" => "#303133",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentStartBgColor" => "rgba(252, 52, 49, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 6,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 0,
                            "both" => 10
                        ],
                        "height" => 10
                    ],
                    [
                        "path" => "edit-text",
                        "uses" => 0,
                        "position" => "",
                        "id" => "65qaokgbzg80",
                        "componentName" => "Text",
                        "componentTitle" => "标题",
                        "ignore" => [],
                        "style" => "style-2",
                        "styleName" => "风格2",
                        "text" => "今日疯抢",
                        "link" => [
                            "name" => ""
                        ],
                        "textColor" => "#FFFFFF",
                        "fontSize" => 16,
                        "fontWeight" => "normal",
                        "textAlign" => "center",
                        "subTitle" => [
                            "text" => "数量有限 抢完为止",
                            "color" => "#FFFFFF",
                            "fontSize" => 14,
                            "control" => true,
                            "fontWeight" => "normal"
                        ],
                        "more" => [
                            "text" => "查看更多",
                            "control" => true,
                            "isShow" => false,
                            "link" => [
                                "name" => ""
                            ],
                            "color" => "#999999"
                        ],
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(252, 52, 49, 1)",
                        "componentEndBgColor" => null,
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-goods-list",
                        "uses" => 0,
                        "id" => "2u96wyrm79u0",
                        "componentName" => "GoodsList",
                        "componentTitle" => "商品列表",
                        "ignore" => [],
                        "style" => "style-1",
                        "source" => "all",
                        "num" => 10,
                        "goods_category" => "",
                        "goods_category_name" => "请选择",
                        "goods_ids" => [],
                        "sortWay" => "default",
                        "goodsNameStyle" => [
                            "color" => "#303133",
                            "control" => true,
                            "fontWeight" => "normal"
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
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(252, 52, 49, 1)",
                        "componentEndBgColor" => "rgba(251, 127, 59, 1)",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 6,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-text",
                        "uses" => 0,
                        "position" => "",
                        "id" => "5izyn9jcz3k0",
                        "componentName" => "Text",
                        "componentTitle" => "标题",
                        "ignore" => [],
                        "style" => "style-1",
                        "styleName" => "风格1",
                        "text" => "精选推荐",
                        "link" => [
                            "name" => ""
                        ],
                        "textColor" => "#303133",
                        "fontSize" => 16,
                        "fontWeight" => "bold",
                        "textAlign" => "center",
                        "subTitle" => [
                            "text" => "副标题",
                            "color" => "#999999",
                            "fontSize" => 14,
                            "control" => false,
                            "fontWeight" => "normal"
                        ],
                        "more" => [
                            "text" => "查看更多",
                            "control" => false,
                            "isShow" => true,
                            "link" => [
                                "name" => ""
                            ],
                            "color" => "#999999"
                        ],
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 0
                        ]
                    ],
                    [
                        "path" => "edit-goods-list",
                        "uses" => 0,
                        "id" => "4y7mw7j2uko0",
                        "componentName" => "GoodsList",
                        "componentTitle" => "商品列表",
                        "ignore" => [],
                        "style" => "style-2",
                        "source" => "all",
                        "num" => 10,
                        "goods_category" => "",
                        "goods_category_name" => "请选择",
                        "goods_ids" => [],
                        "sortWay" => "default",
                        "goodsNameStyle" => [
                            "color" => "#303133",
                            "control" => true,
                            "fontWeight" => "normal"
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
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 8,
                        "bottomRounded" => 8,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 10
                        ]
                    ],
                    [
                        "path" => "edit-many-goods-list",
                        "uses" => 0,
                        "id" => "65lv65b38ig0",
                        "componentName" => "ManyGoodsList",
                        "componentTitle" => "多商品组",
                        "ignore" => [],
                        "style" => "style-2",
                        "num" => 6,
                        "sortWay" => "default",
                        "headStyle" => "style-2",
                        "aroundRadius" => 25,
                        "source" => "custom",
                        "goodsNameStyle" => [
                            "color" => "#303133",
                            "control" => true,
                            "fontWeight" => "normal"
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
                                "goods_category" => "",
                                "goods_category_name" => "请选择",
                                "goods_ids" => [],
                                "id" => "2iljdx2ajqg0"
                            ],
                            [
                                "id" => "3a1x4kgbre40",
                                "title" => "衣鞋包饰",
                                "desc" => "分类描述",
                                "source" => "all",
                                "goods_category" => "",
                                "goods_category_name" => "请选择",
                                "goods_ids" => []
                            ],
                            [
                                "id" => "12ozjal2rfe8",
                                "title" => "居家百货",
                                "desc" => "分类描述",
                                "source" => "all",
                                "goods_category" => "",
                                "goods_category_name" => "请选择",
                                "goods_ids" => []
                            ],
                            [
                                "id" => "71kwrfxeoxw0",
                                "title" => "热卖好物",
                                "desc" => "分类描述",
                                "source" => "all",
                                "goods_category" => "",
                                "goods_category_name" => "请选择",
                                "goods_ids" => []
                            ],
                            [
                                "id" => "5tktk8897ag0",
                                "title" => "优品精选",
                                "desc" => "分类描述",
                                "source" => "all",
                                "goods_category" => "",
                                "goods_category_name" => "请选择",
                                "goods_ids" => []
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 4,
                        "bottomRounded" => 4,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 10,
                            "bottom" => 10,
                            "both" => 10
                        ]
                    ]
                ]
            ]
        ]
    ],
    'DIY_SHOP_MEMBER_INDEX' => [
        'shop_member_index_style1' => [
            "title" => "商城个人中心（风格一）", // 页面名称
            'cover' => 'addon/shop/diy/template/member_index_cover.png', // 页面封面图
            'preview' => '', // 页面预览图
            'desc' => '个人中心', // 页面描述
            'mode' => 'diy', // 页面模式：diy：自定义，fixed：固定
            'data' => [
                "global" => [
                    "title" => "个人中心",
                    "bgUrl" => "",
                    "imgWidth" => "",
                    "imgHeight" => "",
                    "bottomTabBarSwitch" => true,
                    "template" => [
                        "textColor" => "#303133",
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 0
                        ],
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentGradientAngle" => "to bottom"
                    ],
                    "topStatusBar" => [
                        "bgColor" => "#ffffff",
                        "isTransparent" => false,
                        "isShow" => true,
                        "style" => "style-1",
                        "textColor" => "#333333",
                        "textAlign" => "center"
                    ],
                    "popWindow" => [
                        "imgUrl" => "",
                        "imgWidth" => "",
                        "imgHeight" => "",
                        "count" => -1,
                        "show" => 0,
                        "link" => [
                            "name" => ""
                        ]
                    ],
                    "pageStartBgColor" => "rgba(246, 246, 246, 1)",
                    "pageEndBgColor" => "",
                    "pageGradientAngle" => "to bottom",
                    "bgHeightScale" => 100
                ],
                "value" => [
                    [
                        "path" => "edit-shop-member-info",
                        "id" => "3pt9pn9bvn20",
                        "componentName" => "ShopMemberInfo",
                        "componentTitle" => "会员信息",
                        "uses" => 1,
                        "ignore" => [
                            "componentBgUrl"
                        ],
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 5,
                            "both" => 0
                        ],
                        "textColor" => "#FFFFFF",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentGradientAngle" => "to bottom",
                        "style" => "style-1",
                        "styleName" => "风格1",
                        "bgUrl" => "addon/shop/diy/member/style1/member_info_bg.png"
                    ],
                    [
                        "path" => "edit-image-ads",
                        "uses" => 0,
                        "id" => "3odoachos9s0",
                        "componentName" => "ImageAds",
                        "componentTitle" => "图片广告",
                        "ignore" => [],
                        "textColor" => "#303133",
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "topRounded" => 6,
                        "bottomRounded" => 6,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 5,
                            "both" => 15
                        ],
                        "list" => [
                            [
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/style1/banner.png",
                                "id" => "3nrdo9chhp",
                                "imgWidth" => 690,
                                "imgHeight" => 180,
                                "width" => 345,
                                "height" => 90
                            ]
                        ],
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentGradientAngle" => "to bottom",
                        "imageHeight" => 90
                    ],
                    [
                        "path" => "edit-text",
                        "uses" => 0,
                        "id" => "68gnubbygqg0",
                        "componentName" => "Text",
                        "componentTitle" => "标题",
                        "ignore" => [],
                        "textColor" => "#303133",
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "topRounded" => 8,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 5,
                            "bottom" => 0,
                            "both" => 15
                        ],
                        "fontSize" => 16,
                        "fontWeight" => "normal",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentGradientAngle" => "to bottom",
                        "position" => "",
                        "style" => "style-1",
                        "styleName" => "风格1",
                        "text" => "其他功能",
                        "link" => [
                            "name" => ""
                        ],
                        "textAlign" => "left",
                        "subTitle" => [
                            "text" => "副标题",
                            "color" => "#999999",
                            "fontSize" => 14,
                            "control" => false,
                            "fontWeight" => "normal"
                        ],
                        "more" => [
                            "text" => "查看更多",
                            "control" => false,
                            "isShow" => true,
                            "link" => [
                                "name" => ""
                            ],
                            "color" => "#999999"
                        ]
                    ],
                    [
                        "path" => "edit-graphic-nav",
                        "uses" => 0,
                        "id" => "5myxk1opz0c0",
                        "componentName" => "GraphicNav",
                        "componentTitle" => "图文导航",
                        "ignore" => [],
                        "textColor" => "#303133",
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "topRounded" => 0,
                        "bottomRounded" => 8,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 15
                        ],
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentGradientAngle" => "to bottom",
                        "layout" => "horizontal",
                        "mode" => "graphic",
                        "showStyle" => "fixed",
                        "rowCount" => 4,
                        "pageCount" => 2,
                        "carousel" => [
                            "type" => "circle",
                            "color" => "#FFFFFF"
                        ],
                        "imageSize" => 20,
                        "aroundRadius" => 0,
                        "font" => [
                            "size" => 12,
                            "weight" => "normal",
                            "color" => "#303133"
                        ],
                        "list" => [
                            [
                                "title" => "我的余额",
                                "link" => [
                                    "parent" => "MEMBER_LINK",
                                    "name" => "MEMBER_BALANCE",
                                    "title" => "我的余额",
                                    "url" => "/app/pages/member/balance",
                                    "action" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/style1/nav_balance.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "2aqy33banse8",
                                "imgWidth" => 88,
                                "imgHeight" => 88
                            ],
                            [
                                "title" => "积分兑换",
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/style1/nav_point_change.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "692put4jerg0",
                                "imgWidth" => 88,
                                "imgHeight" => 88
                            ],
                            [
                                "title" => "优惠券",
                                "link" => [
                                    "parent" => "SHOP_LINK",
                                    "name" => "SHOP_MY_COUPON",
                                    "title" => "我的优惠券",
                                    "url" => "/addon/shop/pages/member/my_coupon",
                                    "action" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/style1/nav_coupon.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "34t5xg9ik0i0",
                                "imgWidth" => 88,
                                "imgHeight" => 88
                            ],
                            [
                                "title" => "地址管理",
                                "link" => [
                                    "parent" => "MEMBER_LINK",
                                    "name" => "MEMBER_ADDRESS",
                                    "title" => "收货地址",
                                    "url" => "/app/pages/member/address",
                                    "action" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/style1/nav_address.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "hdk4145zk40",
                                "imgWidth" => 80,
                                "imgHeight" => 88
                            ],
                            [
                                "id" => "4o2q7yss59m0",
                                "title" => "我的等级",
                                "imageUrl" => "addon/shop/diy/member/style1/nav_my_level.png",
                                "imgWidth" => 88,
                                "imgHeight" => 90,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "7dpefp0s9ew0",
                                "title" => "我的推广",
                                "imageUrl" => "addon/shop/diy/member/style1/nav_promote.png",
                                "imgWidth" => 88,
                                "imgHeight" => 88,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "78fnsh8cx5k0",
                                "title" => "我的收藏",
                                "imageUrl" => "addon/shop/diy/member/style1/nav_collect.png",
                                "imgWidth" => 88,
                                "imgHeight" => 88,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "27kxbgr5ljbw",
                                "title" => "联系客服",
                                "imageUrl" => "addon/shop/diy/member/style1/nav_service.png",
                                "imgWidth" => 88,
                                "imgHeight" => 88,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'shop_member_index' => [
            "title" => "商城个人中心（风格二）", // 页面名称
            'cover' => 'addon/shop/diy/template/member_index_cover.png', // 页面封面图
            'preview' => '', // 页面预览图
            'desc' => '个人中心', // 页面描述
            'mode' => 'diy', // 页面模式：diy：自定义，fixed：固定
            'data' => [
                "global" => [
                    "title" => "个人中心",
                    'pageStartBgColor' => 'rgba(246, 247, 252, 1)',
                    'pageEndBgColor' => '',
                    'pageGradientAngle' => 'to bottom',
                    "bgUrl" => "",
                    'bgHeightScale' => 0,
                    "imgWidth" => "",
                    "imgHeight" => "",
                    "bottomTabBarSwitch" => true,
                    "template" => [
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 12
                        ]
                    ],
                    "topStatusBar" => [
                        "bgColor" => "#ffffff",
                        "isTransparent" => false,
                        "isShow" => true,
                        "style" => "style-1",
                        "textColor" => "#333333",
                        "textAlign" => "center"
                    ],
                    "popWindow" => [
                        "imgUrl" => "",
                        "imgWidth" => "",
                        "imgHeight" => "",
                        "count" => -1,
                        "show" => 0,
                        "link" => [
                            "name" => ""
                        ]
                    ]
                ],
                "value" => [
                    [
                        "path" => "edit-member-info",
                        "id" => "40w5ay4dep00",
                        "componentName" => "MemberInfo",
                        "componentTitle" => "会员信息",
                        "uses" => 1,
                        "ignore" => [],
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 0
                        ],
                        "textColor" => "#303133",
                        "style" => "style-1",
                        "styleName" => "风格1",
                        "bgUrl" => "",
                        "bgColorStart" => "",
                        "bgColorEnd" => ""
                    ],
                    [
                        "path" => "edit-horz-blank",
                        "uses" => 0,
                        "id" => "2da0xqyo8zms",
                        "componentName" => "HorzBlank",
                        "componentTitle" => "辅助空白",
                        "ignore" => [
                            "pageBgColor",
                            "componentBgUrl"
                        ],
                        "height" => 10,
                        "textColor" => "#303133",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 9,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 16
                        ]
                    ],
                    [
                        "path" => "edit-text",
                        "uses" => 0,
                        "position" => "",
                        "id" => "1puhgfus8www",
                        "componentName" => "Text",
                        "componentTitle" => "标题",
                        "ignore" => [],
                        "style" => "style-2",
                        "styleName" => "风格2",
                        "text" => "我的订单",
                        "link" => [
                            "name" => "SHOP_ORDER_LIST",
                            "parent" => "SHOP_LINK",
                            "title" => "订单列表",
                            "url" => "/addon/shop/pages/order/list",
                            "action" => ""
                        ],
                        "textColor" => "#303133",
                        "fontSize" => 16,
                        "fontWeight" => "normal",
                        "textAlign" => "center",
                        "subTitle" => [
                            "text" => "",
                            "color" => "#999999",
                            "fontSize" => 14,
                            "control" => true,
                            "fontWeight" => "normal"
                        ],
                        "more" => [
                            "text" => "全部",
                            "control" => true,
                            "isShow" => true,
                            "link" => [
                                "name" => ""
                            ],
                            "color" => "#999999"
                        ],
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 16
                        ]
                    ],
                    [
                        "path" => "edit-graphic-nav",
                        "uses" => 0,
                        "id" => "42bjn10l0ak0",
                        "componentName" => "GraphicNav",
                        "componentTitle" => "图文导航",
                        "ignore" => [],
                        "list" => [
                            [
                                "link" => [
                                    "parent" => "DIY_LINK",
                                    "title" => "待付款",
                                    "url" => "/addon/shop/pages/order/list?status=1",
                                    "name" => "DIY_LINK"
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_wait_pay_order.png",
                                "imgWidth" => 40,
                                "imgHeight" => 40,
                                "id" => "ogkw2mqwvow",
                                "title" => "待付款",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "title" => "待发货",
                                "link" => [
                                    "parent" => "DIY_LINK",
                                    "title" => "待发货",
                                    "url" => "/addon/shop/pages/order/list?status=2",
                                    "name" => "DIY_LINK"
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_wait_delivery_order.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "37hnqfvx5va0",
                                "imgWidth" => 40,
                                "imgHeight" => 40
                            ],
                            [
                                "title" => "待收货",
                                "link" => [
                                    "parent" => "DIY_LINK",
                                    "title" => "待收货",
                                    "url" => "/addon/shop/pages/order/list?status=3",
                                    "name" => "DIY_LINK"
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_wait_take_order.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "63n62guoiug0",
                                "imgWidth" => 40,
                                "imgHeight" => 40
                            ],
                            [
                                "title" => "待评价",
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_wait_evaluate_order.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "id" => "4wblhzd14uw0",
                                "imgWidth" => 40,
                                "imgHeight" => 40
                            ],
                            [
                                "id" => "fl2bqfimnuo",
                                "title" => "售后退款",
                                "imageUrl" => "addon/shop/diy/member/nav_refund_order.png",
                                "imgWidth" => 40,
                                "imgHeight" => 40,
                                "link" => [
                                    "parent" => "SHOP_LINK",
                                    "title" => "退款列表",
                                    "url" => "/addon/shop/pages/refund/list",
                                    "name" => "SHOP_REFUND_LIST"
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 9,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 12,
                            "both" => 16
                        ],
                        "layout" => "horizontal",
                        "mode" => "graphic",
                        "showStyle" => "fixed",
                        "rowCount" => 5,
                        "pageCount" => 2,
                        "carousel" => [
                            "type" => "circle",
                            "color" => "#FFFFFF"
                        ],
                        "imageSize" => 20,
                        "aroundRadius" => 0,
                        "font" => [
                            "size" => 14,
                            "weight" => "normal",
                            "color" => "rgba(32, 15, 51, 1)"
                        ]
                    ],
                    [
                        "path" => "edit-horz-blank",
                        "uses" => 0,
                        "id" => "5fo173bx5840",
                        "componentName" => "HorzBlank",
                        "componentTitle" => "辅助空白",
                        "ignore" => [
                            "pageBgColor",
                            "componentBgUrl"
                        ],
                        "height" => 10,
                        "textColor" => "#303133",
                        "pageStartBgColor" => "",
                        "pageEndBgColor" => "",
                        "pageGradientAngle" => "to bottom",
                        "componentBgUrl" => "",
                        "componentBgAlpha" => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 9,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 16
                        ]
                    ],
                    [
                        "path" => "edit-text",
                        "uses" => 0,
                        "position" => "",
                        "id" => "629cgb1ygcw0",
                        "componentName" => "Text",
                        "componentTitle" => "标题",
                        "ignore" => [],
                        "style" => "style-1",
                        "styleName" => "风格1",
                        "text" => "常用工具",
                        "link" => [
                            "name" => ""
                        ],
                        "textColor" => "#303133",
                        "fontSize" => 16,
                        "fontWeight" => "normal",
                        "textAlign" => "left",
                        "subTitle" => [
                            "text" => "",
                            "color" => "#999999",
                            "fontSize" => 14,
                            "control" => false,
                            "fontWeight" => "normal"
                        ],
                        "more" => [
                            "text" => "查看更多",
                            "control" => false,
                            "isShow" => false,
                            "link" => [
                                "name" => ""
                            ],
                            "color" => "#999999"
                        ],
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 0,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 16
                        ]
                    ],
                    [
                        "path" => "edit-graphic-nav",
                        "uses" => 0,
                        "id" => "1swylyl5fvb4",
                        "componentName" => "GraphicNav",
                        "componentTitle" => "图文导航",
                        "ignore" => [],
                        "list" => [
                            [
                                "title" => "签到",
                                "link" => [
                                    "name" => ""
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_signin.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "imgWidth" => 58,
                                "imgHeight" => 58
                            ],
                            [
                                "title" => "个人资料",
                                "link" => [
                                    "parent" => "MEMBER_LINK",
                                    "title" => "个人资料",
                                    "url" => "/app/pages/member/personal",
                                    "name" => "MEMBER_PERSONAL"
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_info.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "imgWidth" => 58,
                                "imgHeight" => 58
                            ],
                            [
                                "title" => "收货地址",
                                "link" => [
                                    "parent" => "MEMBER_LINK",
                                    "title" => "收货地址",
                                    "url" => "/app/pages/member/address",
                                    "name" => "MEMBER_ADDRESS"
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_address.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "imgWidth" => 58,
                                "imgHeight" => 58
                            ],
                            [
                                "title" => "优惠券",
                                "link" => [
                                    "parent" => "SHOP_LINK",
                                    "title" => "我的优惠券",
                                    "url" => "/addon/shop/pages/member/my_coupon",
                                    "name" => "SHOP_MY_COUPON"
                                ],
                                "imageUrl" => "addon/shop/diy/member/nav_coupon.png",
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ],
                                "imgWidth" => 58,
                                "imgHeight" => 58
                            ],
                            [
                                "id" => "su0vf82y200",
                                "title" => "我的拼单",
                                "imageUrl" => "addon/shop/diy/member/nav_my_pintuan.png",
                                "imgWidth" => 58,
                                "imgHeight" => 58,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "2b0att2b3pq8",
                                "title" => "我的礼物",
                                "imageUrl" => "addon/shop/diy/member/nav_gift.png",
                                "imgWidth" => 58,
                                "imgHeight" => 58,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "z8x7ci5wik0",
                                "title" => "我的足迹",
                                "imageUrl" => "addon/shop/diy/member/nav_footmark.png",
                                "imgWidth" => 58,
                                "imgHeight" => 58,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ],
                            [
                                "id" => "1sejr0g3h4zk",
                                "title" => "积分兑换",
                                "imageUrl" => "addon/shop/diy/member/nav_point_change.png",
                                "imgWidth" => 58,
                                "imgHeight" => 58,
                                "link" => [
                                    "name" => ""
                                ],
                                "label" => [
                                    "control" => false,
                                    "text" => "热门",
                                    "textColor" => "#FFFFFF",
                                    "bgColorStart" => "#F83287",
                                    "bgColorEnd" => "#FE3423"
                                ]
                            ]
                        ],
                        "textColor" => "#303133",
                        'pageStartBgColor' => '',
                        'pageEndBgColor' => '',
                        'pageGradientAngle' => 'to bottom',
                        'componentBgUrl' => '',
                        'componentBgAlpha' => 2,
                        "componentStartBgColor" => "rgba(255, 255, 255, 1)",
                        "componentEndBgColor" => "",
                        "componentGradientAngle" => "to bottom",
                        "topRounded" => 0,
                        "bottomRounded" => 9,
                        "elementBgColor" => "",
                        "topElementRounded" => 0,
                        "bottomElementRounded" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 16
                        ],
                        "layout" => "horizontal",
                        "mode" => "graphic",
                        "showStyle" => "fixed",
                        "rowCount" => 4,
                        "pageCount" => 2,
                        "carousel" => [
                            "type" => "circle",
                            "color" => "#FFFFFF"
                        ],
                        "imageSize" => 29,
                        "aroundRadius" => 0,
                        "font" => [
                            "size" => 14,
                            "weight" => "normal",
                            "color" => "#303133"
                        ]
                    ]
                ]
            ]
        ]
    ]
];
