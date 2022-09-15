<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址=> https=>//www.niushop.com
 * =========================================================
 */


namespace addon\diy_default1\event;

use app\model\web\DiyView as DiyViewModel;

/**
 * 使用自定义模板
 */
class UseTemplate
{
    /**
     * 模板数据
     * @param $params
     * @return array
     */
    public function handle($params)
    {
        if ($params[ 'name' ] == 'official_default_round') {
            $diy_view = new DiyViewModel();

            // 添加模板页面
            $res = $diy_view->addTemplatePage([
                'site_id' => $params[ 'site_id' ],
                'name' => $params[ 'name' ],
                'page' => [ $this->index_page, $this->goods_category_page, $this->member_index_page ], // 自定义页面集合
            ]);

            return $res;
        }
    }

    // 【首页】自定义页面数据
    private $index_page = [
        'title' => '官方模板一',
        'name' => "DIY_VIEW_INDEX",
        'type' => "shop",
        'value' => [
            "global" => [
                "title" => "官方模板一",
                "pageBgColor" => "#F6F9FF",
                "topNavColor" => "#FFFFFF",
                "topNavBg" => false,
                "navBarSwitch" => true,
                "textNavColor" => "#333333",
                "topNavImg" => "",
                "moreLink" => [
                    "name" => ""
                ],
                "openBottomNav" => true,
                "navStyle" => 1,
                "textImgPosLink" => "center",
                "mpCollect" => false,
                "popWindow" => [
                    "imageUrl" => "",
                    "count" => -1,
                    "show" => 0,
                    "link" => [
                        "name" => ""
                    ],
                    "imgWidth" => "",
                    "imgHeight" => ""
                ],
                "bgUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/bg.png',
                "imgWidth" => "2250",
                "imgHeight" => "1110",
                "template" => [
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "elementBgColor" => "",
                    "elementAngle" => "round",
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 12
                    ]
                ],
            ],
            "value" => [
                [
                    "id" => "5wtw72w1wj80",
                    "componentName" => "Search",
                    "componentTitle" => "搜索框",
                    "isDelete" => 0,
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 10,
                        "bottom" => 10,
                        "both" => 12
                    ],
                    "title" => "请输入搜索关键词",
                    "textAlign" => "left",
                    "borderType" => 2,
                    "searchImg" => "",
                    "searchStyle" => 1,
                    "pageBgColor" => "#FFFFFF",
                    "textColor" => "#303133",
                    "componentBgColor" => "",
                    "elementBgColor" => "#F6F9FF",
                    "iconType" => "img",
                    "icon" => "",
                    "style" => [
                        "fontSize" => "60",
                        "iconBgColor" => [],
                        "iconBgColorDeg" => 0,
                        "iconBgImg" => "",
                        "bgRadius" => 0,
                        "iconColor" => [
                            "#000000"
                        ],
                        "iconColorDeg" => 0
                    ],
                    "imageUrl" => ""
                ],
                [
                    "id" => "2o7za2qmi900",
                    "list" => [
                        [
                            "link" => [
                                "name" => ""
                            ],
                            "imageUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/banner.png',
                            "imgWidth" => "750",
                            "imgHeight" => "320",
                            "id" => "1iy3xvq2ngf40"
                        ],
                        [
                            "link" => [
                                "name" => ""
                            ],
                            "imageUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/banner2.png',
                            "imgWidth" => "750",
                            "imgHeight" => "320",
                            "id" => "zcrfm65uiu8"
                        ]
                    ],
                    "indicatorColor" => "#ffffff",
                    "carouselStyle" => "circle",
                    "indicatorLocation" => "center",
                    "componentName" => "ImageAds",
                    "componentTitle" => "图片广告",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 10,
                    "bottomAroundRadius" => 10,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 12,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "113ohzka4n40",
                    "mode" => "graphic",
                    "type" => "img",
                    "showStyle" => "fixed",
                    "ornament" => [
                        "type" => "default",
                        "color" => "#EDEDED"
                    ],
                    "rowCount" => 5,
                    "pageCount" => 2,
                    "carousel" => [
                        "type" => "circle",
                        "color" => "#FFFFFF"
                    ],
                    "imageSize" => 40,
                    "aroundRadius" => 25,
                    "font" => [
                        "size" => 14,
                        "weight" => 'normal',
                        "color" => "#303133"
                    ],
                    "list" => [
                        [
                            "title" => "团购",
                            "icon" => "icondiy icon-system-groupbuy-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#FF9F3E",
                                    "#FF4116"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "GROUPBUY_PREFECTURE",
                                "title" => "团购专区",
                                "wap_url" => "/pages_promotion/groupbuy/list",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "ycafod7gfgg0"
                        ],
                        [
                            "title" => "拼团",
                            "icon" => "icondiy icon-system-pintuan-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#58BCFF",
                                    "#1379FF"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "PINTUAN_PREFECTURE",
                                "title" => "拼团专区",
                                "wap_url" => "/pages_promotion/pintuan/list",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "wnlf5ak6u8g0"
                        ],
                        [
                            "title" => "秒杀",
                            "icon" => "icondiy icon-system-seckill-time",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#FFCC26",
                                    "#FF9F29"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "SECKILL_PREFECTURE",
                                "title" => "秒杀专区",
                                "wap_url" => "/pages_promotion/seckill/list",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => true,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83288",
                                "bgColorEnd" => "#FE3523"
                            ],
                            "id" => "lpg2grtvmxo0"
                        ],
                        [
                            "title" => " 积分",
                            "icon" => "icondiy icon-system-point-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#02CC96",
                                    "#43EEC9"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "INTEGRAL_STORE",
                                "title" => "积分商城",
                                "wap_url" => "/pages_promotion/point/list",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "1jfs721gome8"
                        ],
                        [
                            "title" => "专题活动",
                            "icon" => "icondiy icon-system-topic-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#BE79FF",
                                    "#7B00FF"
                                ],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "THEMATIC_ACTIVITIES_LIST",
                                "title" => "专题活动列表",
                                "wap_url" => "/pages_promotion/topics/list",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "1grejh3c8fwg0"
                        ],
                        [
                            "title" => "砍价",
                            "icon" => "icondiy icon-system-bargain-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#5BBDFF",
                                    "#2E87FD"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "BARGAIN_PREFECTURE",
                                "title" => "砍价专区",
                                "wap_url" => "/pages_promotion/bargain/list",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "ycpsnfbaf800"
                        ],
                        [
                            "title" => "领券",
                            "icon" => "icondiy icon-system-get-coupon",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#BE79FF",
                                    "#7B00FF"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "COUPON_PREFECTURE",
                                "title" => "优惠券专区",
                                "wap_url" => "/pages_tool/goods/coupon",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "17dcs7xstz400"
                        ],
                        [
                            "title" => "文章",
                            "icon" => "icondiy icon-system-article-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#FF8052",
                                    "#FF4830"
                                ],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "SHOPPING_ARTICLE",
                                "title" => "文章",
                                "wap_url" => "/pages_tool/article/list",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "hg8450mb0hc0"
                        ],
                        [
                            "title" => "公告",
                            "icon" => "icondiy icon-system-notice-nav",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#FFCC26",
                                    "#FF9F29"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "SHOPPING_NOTICE",
                                "title" => "公告",
                                "wap_url" => "/pages_tool/notice/list",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "1cg964qu9f9c0"
                        ],
                        [
                            "title" => "帮助",
                            "icon" => "icondiy icon-system-help",
                            "imageUrl" => "",
                            "iconType" => "icon",
                            "style" => [
                                "fontSize" => 50,
                                "iconBgColor" => [
                                    "#02CC96",
                                    "#43EEC9"
                                ],
                                "iconBgColorDeg" => 90,
                                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                                "bgRadius" => 50,
                                "iconColor" => [
                                    "#FFFFFF"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "SHOPPING_HELP",
                                "title" => "帮助",
                                "wap_url" => "/pages_tool/help/list",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "id" => "1v4budp7jav40"
                        ]
                    ],
                    "componentName" => "GraphicNav",
                    "componentTitle" => "图文导航",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 10,
                    "bottomAroundRadius" => 10,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 12,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "3tegcfvyijk0",
                    "list" => [
                        [
                            "link" => [
                                "name" => ""
                            ],
                            "imageUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/mf_left.png',
                            "imgWidth" => "338",
                            "imgHeight" => "450",
                            "previewWidth" => 187.5,
                            "previewHeight" => "249.63px"
                        ],
                        [
                            "imageUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/mf_right1.png',
                            "link" => [
                                "name" => ""
                            ],
                            "imgWidth" => "354",
                            "imgHeight" => "220",
                            "previewWidth" => 187.5,
                            "previewHeight" => "124.82px",
                        ],
                        [
                            "imageUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/mf_right2.png',
                            "imgWidth" => "354",
                            "imgHeight" => "220",
                            "previewWidth" => 187.5,
                            "previewHeight" => "124.82px",
                            "link" => [
                                "name" => ""
                            ]
                        ]
                    ],
                    "mode" => "row1-lt-of2-rt",
                    "imageGap" => 10,
                    "componentName" => "RubikCube",
                    "componentTitle" => "魔方",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 10,
                    "bottomAroundRadius" => 10,
                    "elementAngle" => "round",
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 12,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "3acr0xjm1c80",
                    "style" => "style-16",
                    "subTitle" => [
                        "fontSize" => 14,
                        "text" => "超级优惠",
                        "isElementShow" => true,
                        "color" => "#FFFFFF",
                        "bgColor" => "#FF9F29",
                        "icon" => "icondiy icon-system-coupon",
                        "fontWeight" => 'bold'
                    ],
                    "link" => [
                        "name" => "COUPON_PREFECTURE",
                        "title" => "优惠券专区",
                        "wap_url" => "/pages_tool/goods/coupon",
                        "parent" => "MARKETING_LINK"
                    ],
                    "fontSize" => 16,
                    "styleName" => "风格16",
                    "fontWeight" => 'bold',
                    "more" => [
                        "text" => "",
                        "link" => [
                            "name" => "COUPON_PREFECTURE",
                            "title" => "优惠券专区",
                            "wap_url" => "/pages_tool/goods/coupon",
                            "parent" => "MARKETING_LINK"
                        ],
                        "isShow" => true,
                        "isElementShow" => true,
                        "color" => "#999999"
                    ],
                    "text" => "优惠专区",
                    "componentName" => "Text",
                    "componentTitle" => "标题",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 10,
                    "bottomAroundRadius" => 0,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "2parw5r2qq00",
                    "style" => "6",
                    "sources" => "initial",
                    "styleName" => "风格六",
                    "couponIds" => [],
                    "count" => 6,
                    "previewList" => [],
                    "nameColor" => "#303133",
                    "moneyColor" => "#FF0000",
                    "limitColor" => "#303133",
                    "btnStyle" => [
                        "textColor" => "#FFFFFF",
                        "bgColor" => "#303133",
                        "text" => "领取",
                        "aroundRadius" => 20,
                        "isBgColor" => true,
                        "isAroundRadius" => true
                    ],
                    "bgColor" => "",
                    "isName" => true,
                    "couponBgColor" => "#FFFFFF",
                    "couponBgUrl" => "",
                    "couponType" => "color",
                    "ifNeedBg" => true,
                    "componentName" => "Coupon",
                    "componentTitle" => "优惠券",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "elementBgColor" => "",
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "68p4o1plca80",
                    "height" => 10,
                    "componentName" => "HorzBlank",
                    "componentTitle" => "辅助空白",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 10,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "29fhippqsrgg",
                    "list" => [
                        [
                            "link" => [
                                "name" => ""
                            ],
                            "imageUrl" => __ROOT__ . '/addon/diy_default1/shop/view/public/img/gg.png',
                            "imgWidth" => "702",
                            "imgHeight" => "252",
                            "id" => "1z94aaav9klc0"
                        ]
                    ],
                    "indicatorColor" => "#ffffff",
                    "carouselStyle" => "circle",
                    "indicatorLocation" => "center",
                    "componentName" => "ImageAds",
                    "componentTitle" => "图片广告",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 10,
                    "bottomAroundRadius" => 10,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 12,
                        "both" => 12
                    ]
                ],
                [
                    "id" => "i4xirbfy0m8",
                    "style" => "style-3",
                    "sources" => "initial",
                    "count" => 6,
                    "goodsId" => [],
                    "ornament" => [
                        "type" => "default",
                        "color" => "#EDEDED"
                    ],
                    "nameLineMode" => "multiple",
                    "template" => "row1-of2",
                    "goodsMarginType" => "default",
                    "goodsMarginNum" => 6,
                    "btnStyle" => [
                        "text" => "购买",
                        "textColor" => "#FFFFFF",
                        "theme" => "default",
                        "aroundRadius" => 25,
                        "control" => false,
                        "support" => false,
                        "bgColor" => "#FF6A00",
                        "style" => "button",
                        "iconDiy" => [
                            "iconType" => "icon",
                            "icon" => "",
                            "style" => [
                                "fontSize" => "60",
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "bgRadius" => 0,
                                "iconColor" => [
                                    "#000000"
                                ],
                                "iconColorDeg" => 0
                            ]
                        ]
                    ],
                    "categoryId" => 0,
                    "categoryName" => "请选择",
                    "sortWay" => "default",
                    "tag" => [
                        "text" => "隐藏",
                        "value" => "hidden"
                    ],
                    "cartEvent" => "detail",
                    "imgAroundRadius" => 0,
                    "slideMode" => "scroll",
                    "goodsNameStyle" => [
                        "color" => "#303133",
                        "control" => true,
                        "fontWeight" => false
                    ],
                    "saleStyle" => [
                        "color" => "#999CA7",
                        "control" => true,
                        "support" => true
                    ],
                    "theme" => "default",
                    "priceStyle" => [
                        "mainColor" => "#FF6A00",
                        "mainControl" => true,
                        "lineColor" => "#999CA7",
                        "lineControl" => false,
                        "lineSupport" => false
                    ],
                    "componentName" => "GoodsList",
                    "componentTitle" => "商品列表",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "elementBgColor" => "#FFFFFF",
                    "elementAngle" => "round",
                    "topElementAroundRadius" => 10,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 10,
                        "both" => 12
                    ]
                ]
            ]
        ]
    ];

    // 获取首页数据
    public function getIndexPage()
    {
        return $this->index_page;
    }

    // 【商品分类】自定义页面数据
    private $goods_category_page = [
        'title' => '商品分类',
        'name' => "DIY_VIEW_GOODS_CATEGORY",
        'type' => "shop",
        'value' =>
            [
                "global" => [
                    "title" => "商品分类",
                    "pageBgColor" => "#FFFFFF",
                    "topNavColor" => "#FFFFFF",
                    "topNavBg" => false,
                    "navBarSwitch" => true,
                    "textNavColor" => "#333333",
                    "topNavImg" => "",
                    "moreLink" => [
                        "name" => ""
                    ],
                    "openBottomNav" => true,
                    "navStyle" => 1,
                    "textImgPosLink" => "left",
                    "mpCollect" => false,
                    "popWindow" => [
                        "imageUrl" => "",
                        "count" => -1,
                        "show" => 0,
                        "link" => [
                            "name" => ""
                        ],
                        "imgWidth" => "",
                        "imgHeight" => ""
                    ],
                    "bgUrl" => "",
                    "imgWidth" => "",
                    "imgHeight" => "",
                    "template" => [
                        "pageBgColor" => "",
                        "textColor" => "#303133",
                        "componentBgColor" => "",
                        "componentAngle" => "round",
                        "topAroundRadius" => 0,
                        "bottomAroundRadius" => 0,
                        "elementBgColor" => "",
                        "elementAngle" => "round",
                        "topElementAroundRadius" => 0,
                        "bottomElementAroundRadius" => 0,
                        "margin" => [
                            "top" => 0,
                            "bottom" => 0,
                            "both" => 0
                        ]
                    ]
                ],
                "value" => [
                    [
                        "level" => "2",
                        "template" => "2",
                        "quickBuy" => 1,
                        "search" => 1,
                        "componentName" => "GoodsCategory",
                        "componentTitle" => "商品分类",
                        "isDelete" => 1,
                        "topAroundRadius" => 0,
                        "bottomAroundRadius" => 0,
                        "topElementAroundRadius" => 0,
                        "bottomElementAroundRadius" => 0,
                        "margin" => [],
                        "goodsLevel" => 1,
                        "loadType" => "part"
                    ]
                ]
            ]
    ];

    // 【会员中心】自定义页面数据
    private $member_index_page = [
        'title' => '会员中心',
        'name' => "DIY_VIEW_MEMBER_INDEX",
        'type' => "shop",
        'value' => [
            "global" => [
                "title" => "会员中心",
                "pageBgColor" => "#F8F8F8",
                "topNavColor" => "#FFFFFF",
                "topNavBg" => true,
                "navBarSwitch" => false,
                "textNavColor" => "#333333",
                "topNavImg" => "",
                "moreLink" => [
                    "name" => ""
                ],
                "openBottomNav" => true,
                "navStyle" => 1,
                "textImgPosLink" => "center",
                "mpCollect" => false,
                "popWindow" => [
                    "imageUrl" => "",
                    "count" => -1,
                    "show" => 0,
                    "link" => [
                        "name" => ""
                    ],
                    "imgWidth" => "",
                    "imgHeight" => ""
                ],
                "bgUrl" => "",
                "imgWidth" => "",
                "imgHeight" => "",
                "template" => [
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "elementBgColor" => "",
                    "elementAngle" => "round",
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 0
                    ]
                ]
            ],
            "value" => [
                [
                    "style" => 2,
                    "theme" => "default",
                    "bgColorStart" => "#FF7230",
                    "bgColorEnd" => "#FF1544",
                    "gradientAngle" => "129",
                    "infoMargin" => 15,
                    "id" => "1tkaoxbhavj4",
                    "componentName" => "MemberInfo",
                    "componentTitle" => "会员信息",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "elementBgColor" => "",
                    "elementAngle" => "round",
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 0
                    ]
                ],
                [
                    "style" => "style-12",
                    "styleName" => "风格12",
                    "text" => "我的订单",
                    "link" => [
                        "name" => ""
                    ],
                    "fontSize" => 17,
                    "fontWeight" => 'bold',
                    "subTitle" => [
                        "fontSize" => 14,
                        "text" => "",
                        "isElementShow" => true,
                        "color" => "#999999",
                        "bgColor" => "#303133"
                    ],
                    "more" => [
                        "text" => "全部订单",
                        "link" => [
                            "name" => "ALL_ORDER",
                            "title" => "全部订单",
                            "wap_url" => "/pages/order/list",
                            "parent" => "MALL_LINK"
                        ],
                        "isShow" => true,
                        "isElementShow" => true,
                        "color" => "#999999"
                    ],
                    "id" => "2txcvx3d5u6",
                    "componentName" => "Text",
                    "componentTitle" => "标题",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 9,
                    "bottomAroundRadius" => 0,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 15,
                        "bottom" => 0,
                        "both" => 15
                    ]
                ],
                [
                    "color" => "#EEEEEE",
                    "borderStyle" => "solid",
                    "id" => "3hsh2st470e0",
                    "componentName" => "HorzLine",
                    "componentTitle" => "辅助线",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 0,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 20
                    ]
                ],
                [
                    "icon" => [
                        "waitPay" => [
                            "title" => "待付款",
                            "icon" => "icondiy icon-system-daifukuan2",
                            "style" => [
                                "bgRadius" => 0,
                                "fontSize" => 65,
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "iconColor" => [
                                    "#ffa3a3",
                                    "#FF4646"
                                ],
                                "iconColorDeg" => 0
                            ]
                        ],
                        "waitSend" => [
                            "title" => "待发货",
                            "icon" => "icondiy icon-system-daifahuo2",
                            "style" => [
                                "bgRadius" => 0,
                                "fontSize" => 65,
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "iconColor" => [
                                    "#ffa3a3",
                                    "#FF4646"
                                ],
                                "iconColorDeg" => 0
                            ]
                        ],
                        "waitConfirm" => [
                            "title" => "待收货",
                            "icon" => "icondiy icon-system-daishouhuo2",
                            "style" => [
                                "bgRadius" => 0,
                                "fontSize" => 65,
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "iconColor" => [
                                    "#ffa3a3",
                                    "#FF4646"
                                ],
                                "iconColorDeg" => 0
                            ]
                        ],
                        "waitRate" => [
                            "title" => "待评价",
                            "icon" => "icondiy icon-system-daipingjie2",
                            "style" => [
                                "bgRadius" => 0,
                                "fontSize" => 65,
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "iconColor" => [
                                    "#ffa3a3",
                                    "#FF4646"
                                ],
                                "iconColorDeg" => 0
                            ]
                        ],
                        "refunding" => [
                            "title" => "售后",
                            "icon" => "icondiy icon-system-shuhou2",
                            "style" => [
                                "bgRadius" => 0,
                                "fontSize" => 65,
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "iconColor" => [
                                    "#ffa3a3",
                                    "#FF4646"
                                ],
                                "iconColorDeg" => 0
                            ]
                        ]
                    ],
                    "style" => 1,
                    "id" => "51h05xpcanw0",
                    "componentName" => "MemberMyOrder",
                    "componentTitle" => "我的订单",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 9,
                    "elementBgColor" => "",
                    "elementAngle" => "round",
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 15
                    ]
                ],
                [
                    "style" => "style-12",
                    "styleName" => "风格12",
                    "text" => "常用工具",
                    "link" => [
                        "name" => ""
                    ],
                    "fontSize" => 17,
                    "fontWeight" => 'bold',
                    "subTitle" => [
                        "fontSize" => 14,
                        "text" => "",
                        "isElementShow" => true,
                        "color" => "#999999",
                        "bgColor" => "#303133"
                    ],
                    "more" => [
                        "text" => "",
                        "link" => [
                            "name" => ""
                        ],
                        "isShow" => 0,
                        "isElementShow" => true,
                        "color" => "#999999"
                    ],
                    "id" => "405rb6vv3rq0",
                    "componentName" => "Text",
                    "componentTitle" => "标题",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "textColor" => "#303133",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 9,
                    "bottomAroundRadius" => 0,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 15,
                        "bottom" => 0,
                        "both" => 15
                    ]
                ],
                [
                    "mode" => "graphic",
                    "type" => "img",
                    "showStyle" => "fixed",
                    "ornament" => [
                        "type" => "default",
                        "color" => "#EDEDED"
                    ],
                    "rowCount" => 4,
                    "pageCount" => 2,
                    "carousel" => [
                        "type" => "circle",
                        "color" => "#FFFFFF"
                    ],
                    "imageSize" => 30,
                    "aroundRadius" => 0,
                    "font" => [
                        "size" => 13,
                        "weight" => 'normal',
                        "color" => "#303133"
                    ],
                    "list" => [
                        [
                            "title" => "个人资料",
                            "imageUrl" => "public/uniapp/member/index/menu/default_person.png",
                            "iconType" => "img",
                            "style" => [
                                "fontSize" => "60",
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "bgRadius" => 0,
                                "iconColor" => [
                                    "#000000"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "MEMBER_INFO",
                                "title" => "个人资料",
                                "wap_url" => "/pages_tool/member/info",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "icon" => "",
                            "id" => "10rhv0x6phhc0"
                        ],
                        [
                            "title" => "收货地址",
                            "imageUrl" => "public/uniapp/member/index/menu/default_address.png",
                            "iconType" => "img",
                            "style" => [
                                "fontSize" => "60",
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "bgRadius" => 0,
                                "iconColor" => [
                                    "#000000"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "SHIPPING_ADDRESS",
                                "title" => "收货地址",
                                "wap_url" => "/pages_tool/member/address",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "icon" => "",
                            "id" => "1n8gycn6xqe80"
                        ],
                        [
                            "title" => "我的关注",
                            "imageUrl" => "public/uniapp/member/index/menu/default_like.png",
                            "iconType" => "img",
                            "style" => [
                                "fontSize" => "60",
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "bgRadius" => 0,
                                "iconColor" => [
                                    "#000000"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "ATTENTION",
                                "title" => "我的关注",
                                "wap_url" => "/pages_tool/member/collection",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "icon" => "",
                            "id" => "cnamoch6cvk0"
                        ],
                        [
                            "title" => "我的足迹",
                            "imageUrl" => "public/uniapp/member/index/menu/default_toot.png",
                            "iconType" => "img",
                            "style" => [
                                "fontSize" => "60",
                                "iconBgColor" => [],
                                "iconBgColorDeg" => 0,
                                "iconBgImg" => "",
                                "bgRadius" => 0,
                                "iconColor" => [
                                    "#000000"
                                ],
                                "iconColorDeg" => 0
                            ],
                            "link" => [
                                "name" => "FOOTPRINT",
                                "title" => "我的足迹",
                                "wap_url" => "/pages_tool/member/footprint",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "icon" => "",
                            "id" => "drf3hi3slo00"
                        ],
                        [
                            "title" => "账户列表",
                            "imageUrl" => "public/uniapp/member/index/menu/default_cash.png",
                            "iconType" => "img",
                            "style" => "",
                            "link" => [
                                "name" => "ACCOUNT",
                                "title" => "账户列表",
                                "wap_url" => "/pages_tool/member/account",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "iconfont" => [
                                "value" => "",
                                "color" => ""
                            ],
                            "id" => "1l4axfhbayqo0"
                        ],
                        [
                            "title" => "优惠券",
                            "imageUrl" => "public/uniapp/member/index/menu/default_discount.png",
                            "iconType" => "img",
                            "style" => "",
                            "link" => [
                                "name" => "COUPON",
                                "title" => "优惠券",
                                "wap_url" => "/pages_tool/member/coupon",
                                "parent" => "MALL_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "iconfont" => [
                                "value" => "",
                                "color" => ""
                            ],
                            "id" => "1tnu0vihrnq80"
                        ],
                        [
                            "title" => "签到",
                            "imageUrl" => "public/uniapp/member/index/menu/default_sign.png",
                            "iconType" => "img",
                            "style" => "",
                            "link" => [
                                "name" => "SIGN_IN",
                                "title" => "签到",
                                "wap_url" => "/pages_tool/member/signin",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "iconfont" => [
                                "value" => "",
                                "color" => ""
                            ],
                            "id" => "hodjcxowf8g0"
                        ],
                        [
                            "title" => "核销台",
                            "imageUrl" => "public/uniapp/member/index/menu/default_verification.png",
                            "iconType" => "img",
                            "style" => "",
                            "link" => [
                                "name" => "VERIFICATION_PLATFORM",
                                "title" => "核销台",
                                "wap_url" => "/pages_tool/verification/index",
                                "parent" => "MARKETING_LINK"
                            ],
                            "label" => [
                                "control" => false,
                                "text" => "热门",
                                "textColor" => "#FFFFFF",
                                "bgColorStart" => "#F83287",
                                "bgColorEnd" => "#FE3423"
                            ],
                            "iconfont" => [
                                "value" => "",
                                "color" => ""
                            ],
                            "id" => "1covfhv2fxy80"
                        ]
                    ],
                    "id" => "5ywbzsnigpw0",
                    "componentName" => "GraphicNav",
                    "componentTitle" => "图文导航",
                    "isDelete" => 0,
                    "pageBgColor" => "",
                    "componentBgColor" => "#FFFFFF",
                    "componentAngle" => "round",
                    "topAroundRadius" => 0,
                    "bottomAroundRadius" => 9,
                    "topElementAroundRadius" => 0,
                    "bottomElementAroundRadius" => 0,
                    "margin" => [
                        "top" => 0,
                        "bottom" => 0,
                        "both" => 15
                    ]
                ]
            ]
        ]
    ];

    /**
     * 获取自定义会员中心数据
     * @return array
     */
    public function getMemberIndexPage()
    {
        return $this->member_index_page;
    }
}