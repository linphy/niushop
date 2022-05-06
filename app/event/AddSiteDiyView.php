<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\event;

use app\model\web\DiyView as DiyViewModel;


/**
 * 增加默认自定义数据：网站主页、商品分类、底部导航
 */
class AddSiteDiyView
{

    public function handle($param)
    {
        if (!empty($param[ 'site_id' ])) {

            $diy_view_model = new DiyViewModel();

            // 添加自定义主页装修
            $value = json_encode([
                "global" => [
                    "title" => "时尚简约商城",
                    "bgColor" => "#f8f8f8",
                    "topNavColor" => "#ffffff",
                    "topNavbg" => false,
                    "textNavColor" => "#333333",
                    "topNavImg" => "",
                    "moreLink" => [
                        "name" => ""
                    ],
                    "openBottomNav" => true,
                    "navStyle" => 1,
                    "textImgStyleLink" => "1",
                    "textImgPosLink" => "center",
                    "mpCollect" => false,
                    "popWindow" => [
                        "imageUrl" => "",
                        "count" => -1,
                        "link" => [
                            "name" => ""
                        ],
                        "imgWidth" => "",
                        "imgHeight" => ""
                    ],
                    "bgUrl" => ""
                ],
                "value" => [
                    [
                        "title" => "搜索",
                        "textColor" => "#909399",
                        "textAlign" => "left",
                        "backgroundColor" => "",
                        "bgColor" => "#ffffff",
                        "defaultTextColor" => "#999999",
                        "borderType" => 2,
                        "searchType" => 1,
                        "searchImg" => "",
                        "searchStyle" => 1,
                        "addon_name" => "",
                        "type" => "SEARCH",
                        "name" => "商品搜索",
                        "controller" => "Search",
                        "is_delete" => "0"
                    ],
                    [
                        "selectedTemplate" => "single-graph",
                        "imageClearance" => 0,
                        "imageRadius" => "right-angle",
                        "carouselChangeStyle" => "circle",
                        "marginTop" => 0,
                        "padding" => 0,
                        "height" => 0,
                        "list" => [
                            [
                                "imageUrl" => "public/diy_view/style2/img/banner.png",
                                "title" => "",
                                "link" => [
                                    "name" => ""
                                ],
                                "imgWidth" => "690",
                                "imgHeight" => "322"
                            ]
                        ],
                        "addon_name" => "",
                        "type" => "IMAGE_ADS",
                        "name" => "图片广告",
                        "controller" => "ImageAds",
                        "is_delete" => "0"
                    ],
                    [
                        "textColor" => "#303133",
                        "defaultTextColor" => "#666666",
                        "navRadius" => "fillet",
                        "backgroundColor" => "#ffffff",
                        "selectedTemplate" => "imageNavigation",
                        "showType" => "5",
                        "scrollSetting" => "fixed",
                        "padding" => 20,
                        "marginTop" => 10,
                        "list" => [
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon1.png",
                                "title" => "拼团",
                                "link" => [
                                    "name" => "PINTUAN_PREFECTURE",
                                    "id" => 3059,
                                    "addon_name" => "pintuan",
                                    "title" => "拼团专区",
                                    "parent" => "PINTUAN",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/promotionpages/pintuan/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "imgWidth" => "70",
                                "imgHeight" => "70",
                                "id" => "gw4ny4pcbrs"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon2.png",
                                "title" => "团购",
                                "link" => [
                                    "name" => "GROUPBUY_PREFECTURE",
                                    "id" => 3056,
                                    "addon_name" => "groupbuy",
                                    "title" => "团购专区",
                                    "parent" => "GROUPBUY",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/promotionpages/groupbuy/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "imgWidth" => "70",
                                "imgHeight" => "70",
                                "id" => "1wwihxr8rcbk0"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon3.png",
                                "title" => "秒杀",
                                "link" => [
                                    "name" => "SECKILL_PREFECTURE",
                                    "id" => 3063,
                                    "addon_name" => "seckill",
                                    "title" => "秒杀专区",
                                    "parent" => "SECKILL",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/promotionpages/seckill/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "imgWidth" => "70",
                                "imgHeight" => "70",
                                "id" => "194supgyhy740"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon4.png",
                                "title" => "积分商城",
                                "link" => [
                                    "name" => "INTEGRAL_STORE",
                                    "id" => 1206,
                                    "addon_name" => "pointexchange",
                                    "title" => "积分商城",
                                    "parent" => "INTEGRAL",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/promotionpages/point/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "imgWidth" => "70",
                                "imgHeight" => "70",
                                "id" => "1a3kbwaw17400"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon5.png",
                                "title" => "专题活动",
                                "link" => [
                                    "name" => "THEMATIC_ACTIVITIES_LIST",
                                    "id" => 1212,
                                    "addon_name" => "topic",
                                    "title" => "专题活动列表",
                                    "parent" => "THEMATIC_ACTIVITIES",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/promotionpages/topics/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "id" => "1j0nifvp2f280",
                                "imgWidth" => "70",
                                "imgHeight" => "70"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon6.png",
                                "title" => "品牌专区",
                                "link" => [
                                    "name" => ""
                                ],
                                "id" => "3amw44yw5u20",
                                "imgWidth" => "70",
                                "imgHeight" => "70"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon7.png",
                                "title" => "直播",
                                "link" => [
                                    "name" => "LIVE_LIST",
                                    "id" => 3076,
                                    "addon_name" => "live",
                                    "title" => "直播",
                                    "parent" => "LIVE",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/otherpages/live/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "id" => "f2godpj26rs0",
                                "imgWidth" => "70",
                                "imgHeight" => "70"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon8.png",
                                "title" => "领券",
                                "link" => [
                                    "name" => "COUPON_PREFECTURE",
                                    "id" => 3065,
                                    "addon_name" => "coupon",
                                    "title" => "优惠券专区",
                                    "parent" => "COUPON_LIST",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/otherpages/goods/coupon/coupon",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "parents" => "MARKETING_LINK"
                                ],
                                "id" => "1kthlnibosio0",
                                "imgWidth" => "70",
                                "imgHeight" => "70"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon9.png",
                                "title" => "公告",
                                "link" => [
                                    "name" => "SHOPPING_NOTICE",
                                    "id" => 3023,
                                    "addon_name" => "",
                                    "title" => "公告",
                                    "parent" => "BASICS_LINK",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/otherpages/notice/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "selected" => false,
                                    "parents" => "MALL_LINK"
                                ],
                                "id" => "5pxkfqsiyu80",
                                "imgWidth" => "70",
                                "imgHeight" => "70"
                            ],
                            [
                                "imageUrl" => "public/diy_view/style2/img/icon10.png",
                                "title" => "帮助",
                                "link" => [
                                    "name" => "SHOPPING_HELP",
                                    "id" => 3024,
                                    "addon_name" => "",
                                    "title" => "帮助",
                                    "parent" => "BASICS_LINK",
                                    "sort" => 0,
                                    "level" => 4,
                                    "web_url" => "",
                                    "wap_url" => "/otherpages/help/list/list",
                                    "icon" => "",
                                    "support_diy_view" => "",
                                    "selected" => false,
                                    "parents" => "MALL_LINK"
                                ],
                                "id" => "uctpam37l1s0",
                                "imgWidth" => "70",
                                "imgHeight" => "70"
                            ]
                        ],
                        "addon_name" => "",
                        "type" => "GRAPHIC_NAV",
                        "name" => "图文导航",
                        "controller" => "GraphicNav",
                        "is_delete" => "0"
                    ],
                    [
                        "sources" => "default",
                        "backgroundColor" => "#ffffff",
                        "marginTop" => 10,
                        "style" => "2",
                        "isEdit" => "2",
                        "styleName" => "风格二",
                        "textColor" => "#333333",
                        "defaultTextColor" => "#333333",
                        "fontSize" => 14,
                        "list" => [
                            [
                                "title" => "单商户V4新模板上线啦！",
                                "link" => [
                                    "name" => ""
                                ]
                            ]
                        ],
                        "noticeIds" => [],
                        "addon_name" => "",
                        "type" => "NOTICE",
                        "name" => "公告",
                        "controller" => "Notice",
                        "is_delete" => "0"
                    ],
                    [
                        "sources" => "default",
                        "style" => "4",
                        "couponCount" => "6",
                        "styleName" => "风格四",
                        "backgroundColor" => "",
                        "marginTop" => 10,
                        "status" => 1,
                        "couponIds" => [],
                        "addon_name" => "coupon",
                        "type" => "COUPON",
                        "name" => "优惠券",
                        "controller" => "Coupon",
                        "is_delete" => "0"
                    ],
                    [
                        "selectedTemplate" => "single-graph",
                        "imageClearance" => 0,
                        "imageRadius" => "right-angle",
                        "carouselChangeStyle" => "circle",
                        "marginTop" => 10,
                        "padding" => 0,
                        "height" => 0,
                        "list" => [
                            [
                                "imageUrl" => "public/diy_view/style2/img/adv4.png",
                                "title" => "",
                                "link" => [
                                    "name" => ""
                                ],
                                "imgWidth" => "690",
                                "imgHeight" => "360"
                            ]
                        ],
                        "addon_name" => "",
                        "type" => "IMAGE_ADS",
                        "name" => "图片广告",
                        "controller" => "ImageAds",
                        "is_delete" => "0"
                    ],
                    [
                        "style" => "3",
                        "backgroundColor" => "",
                        "marginTop" => 10,
                        "goodsCount" => "6",
                        "styleName" => "风格三",
                        "changeType" => 1,
                        "bgSelect" => "red",
                        "paddingLeftRight" => 0,
                        "isShowGoodsName" => 1,
                        "isShowGoodsDesc" => 0,
                        "isShowGoodsPrice" => 1,
                        "isShowGoodsPrimary" => 1,
                        "isShowGoodsStock" => 0,
                        "list" => [
                            [
                                "style" => 1,
                                "imageUrl" => "public/static/img/diy_view/seckill_style1_title.png",
                                "title" => "秒杀专区"
                            ],
                            [
                                "style" => 2,
                                "imageUrl" => "public/static/img/diy_view/seckill_style2_title.png"
                            ],
                            [
                                "style" => 3,
                                "imageUrl" => "public/static/img/diy_view/seckill_style3_title.png"
                            ]
                        ],
                        "listMore" => [
                            "imageUrl" => "",
                            "title" => "更多秒杀"
                        ],
                        "titleTextColor" => "#000",
                        "defaultTitleTextColor" => "#000",
                        "moreTextColor" => "#858585",
                        "defaultMoreTextColor" => "#858585",
                        "addon_name" => "seckill",
                        "type" => "SECKILL_LIST",
                        "name" => "秒杀",
                        "controller" => "Seckill",
                        "is_delete" => "0"
                    ],
                    [
                        "sources" => "default",
                        "categoryId" => 0,
                        "goodsCount" => "6",
                        "goodsId" => [],
                        "style" => "3",
                        "changeType" => 1,
                        "styleName" => "风格三",
                        "backgroundColor" => "",
                        "bgSelect" => "blue",
                        "marginTop" => 10,
                        "list" => [
                            [
                                "style" => 1,
                                "imageUrl" => "public/static/img/diy_view/pintuan_style1_title.png",
                                "title" => "拼团专区"
                            ],
                            [
                                "style" => 2,
                                "imageUrl" => "public/static/img/diy_view/pintuan_style2_title.png"
                            ],
                            [
                                "style" => 3,
                                "imageUrl" => "public/static/img/diy_view/pintuan_style3_title.png"
                            ]
                        ],
                        "listMore" => [
                            "imageUrl" => "",
                            "title" => "好友都在拼"
                        ],
                        "titleTextColor" => "#000",
                        "defaultTitleTextColor" => "#000",
                        "moreTextColor" => "#858585",
                        "defaultMoreTextColor" => "#858585",
                        "addon_name" => "pintuan",
                        "type" => "PINTUAN_LIST",
                        "name" => "拼团",
                        "controller" => "Pintuan",
                        "is_delete" => "0"
                    ],
                    [
                        "sources" => "default",
                        "categoryId" => 0,
                        "goodsCount" => "6",
                        "styleName" => "风格三",
                        "goodsId" => [],
                        "style" => "3",
                        "changeType" => 1,
                        "backgroundColor" => "",
                        "bgSelect" => "violet",
                        "marginTop" => 10,
                        "list" => [
                            [
                                "style" => 1,
                                "imageUrl" => "public/static/img/diy_view/bargain_style1_title.png",
                                "title" => "砍价专区"
                            ],
                            [
                                "style" => 2,
                                "imageUrl" => "public/static/img/diy_view/bargain_style2_title.png"
                            ],
                            [
                                "style" => 3,
                                "imageUrl" => "public/static/img/diy_view/bargain_style3_title.png"
                            ]
                        ],
                        "listMore" => [
                            "imageUrl" => "",
                            "title" => "更多"
                        ],
                        "titleTextColor" => "#000",
                        "defaultTitleTextColor" => "#000",
                        "moreTextColor" => "#858585",
                        "defaultMoreTextColor" => "#858585",
                        "addon_name" => "bargain",
                        "type" => "BARGAIN_LIST",
                        "name" => "砍价",
                        "controller" => "Bargain",
                        "is_delete" => "0"
                    ],
                    [
                        "sources" => "default",
                        "categoryId" => 0,
                        "goodsCount" => "6",
                        "goodsId" => [],
                        "style" => "3",
                        "styleName" => "风格三",
                        "changeType" => 1,
                        "backgroundColor" => "",
                        "bgSelect" => "yellow",
                        "marginTop" => 10,
                        "list" => [
                            [
                                "style" => 1,
                                "imageUrl" => "public/static/img/diy_view/groupbuy_style1_title.png",
                                "title" => "团购专区"
                            ],
                            [
                                "style" => 2,
                                "imageUrl" => "public/static/img/diy_view/groupbuy_style2_title.png"
                            ],
                            [
                                "style" => 3,
                                "imageUrl" => "public/static/img/diy_view/groupbuy_style3_title.png"
                            ]
                        ],
                        "listMore" => [
                            "imageUrl" => "",
                            "title" => "查看更多"
                        ],
                        "titleTextColor" => "#000",
                        "defaultTitleTextColor" => "#000",
                        "moreTextColor" => "#858585",
                        "defaultMoreTextColor" => "#858585",
                        "addon_name" => "groupbuy",
                        "type" => "GROUPBUY_LIST",
                        "name" => "团购",
                        "controller" => "Groupbuy",
                        "is_delete" => "0"
                    ],
                    [
                        "selectColor" => "#FF4544",
                        "nsSelectColor" => "#303133",
                        "title" => "多商品组1",
                        "list" => [
                            [
                                "goodsStyle" => 1,
                                "title" => "热卖",
                                "desc" => "热卖推荐",
                                "link" => [
                                    "name" => ""
                                ],
                                "sources" => "diy",
                                "categoryId" => 0,
                                "categoryName" => "请选择",
                                "goodsId" => []
                            ],
                            [
                                "goodsStyle" => 1,
                                "title" => "精品",
                                "desc" => "为你优选",
                                "link" => [
                                    "name" => ""
                                ],
                                "sources" => "diy",
                                "categoryId" => 0,
                                "categoryName" => "请选择",
                                "goodsId" => []
                            ],
                            [
                                "goodsStyle" => 1,
                                "title" => "特卖",
                                "desc" => "超值好货",
                                "link" => [
                                    "name" => ""
                                ],
                                "sources" => "diy",
                                "categoryId" => 0,
                                "categoryName" => "请选择",
                                "goodsId" => []
                            ],
                            [
                                "goodsStyle" => 1,
                                "title" => "爆款",
                                "desc" => "当季热销",
                                "link" => [
                                    "name" => ""
                                ],
                                "sources" => "diy",
                                "categoryId" => 0,
                                "categoryName" => "请选择",
                                "goodsId" => []
                            ]
                        ],
                        "goodsCount" => "6",
                        "style" => 1,
                        "backgroundColor" => "",
                        "marginTop" => 0,
                        "addon_name" => "",
                        "type" => "MANY_GOODS_LIST",
                        "name" => "多商品组",
                        "controller" => "ManyGoodsList",
                        "is_delete" => "0"
                    ],
                    [
                        "sources" => "group",
                        "categoryId" => 0,
                        "categoryName" => "请选择",
                        "goodsCount" => "6",
                        "goodsId" => [],
                        "groupTitle" => "多商品组1",
                        "style" => "4",
                        "backgroundColor" => "",
                        "marginTop" => 10,
                        "paddingLeftRight" => 0,
                        "isShowCart" => 0,
                        "cartStyle" => 1,
                        "isShowGoodName" => 1,
                        "isShowMarketPrice" => 1,
                        "isShowGoodSaleNum" => 1,
                        "isShowGoodSubTitle" => 0,
                        "goodsTag" => "default",
                        "tagImg" => [
                            "imageUrl" => ""
                        ],
                        "addon_name" => "",
                        "type" => "GOODS_LIST",
                        "name" => "商品列表",
                        "controller" => "GoodsList",
                        "is_delete" => "0"
                    ]
                ]
            ]);

            // 网站主页
            $data = [
                [
                    'site_id' => $param[ 'site_id' ],
                    'title' => '网站主页',
                    'name' => 'DIYVIEW_INDEX',
                    'type' => 'shop',
                    'value' => $value
                ],
                [
                    'site_id' => $param[ 'site_id' ],
                    'title' => '商品分类',
                    'name' => "DIYVIEW_GOODS_CATEGORY",
                    'type' => "shop",
                    'value' => json_encode([
                        "global" => [
                            "title" => "商品分类",
                            "openBottomNav" => false,
                            "bgColor" => "#ffffff",
                            "bgUrl" => ""
                        ],
                        "value" => [
                            [
                                "addon_name" => "",
                                "type" => "GOODS_CATEGORY",
                                "name" => "商品分类",
                                "controller" => "GoodsCategory",
                                "level" => 3,
                                "template" => 2
                            ]
                        ]
                    ])
                ]
            ];

            $res = $diy_view_model->addSiteDiyViewList($data);

            $diy_view_bottom_nav = [
                "type" => 1,
                "backgroundColor" => "#ffffff",
                "textColor" => "#333333",
                "textHoverColor" => "#ff0036",
                "bulge" => false,
                "list" => [
                    [
                        "iconPath" => "upload/default/diy_view/bottom/index.png",
                        "selectedIconPath" => "upload/default/diy_view/bottom/index_selected.png",
                        "text" => "首页",
                        "link" => [
                            "addon_name" => "",
                            "addon_title" => null,
                            "name" => "INDEX",
                            "title" => "主页",
                            "web_url" => "",
                            "wap_url" => "/pages/index/index/index",
                            "icon" => "",
                            "addon_icon" => null,
                            "selected" => false,
                            "type" => 0
                        ]
                    ],
                    [
                        "iconPath" => "upload/default/diy_view/bottom/category.png",
                        "selectedIconPath" => "upload/default/diy_view/bottom/category_selected.png",
                        "text" => "分类",
                        "link" => [
                            "addon_name" => "",
                            "addon_title" => null,
                            "name" => "GOODS_CATEGORY",
                            "title" => "商品分类",
                            "web_url" => "",
                            "wap_url" => "/pages/goods/category/category",
                            "icon" => "",
                            "addon_icon" => null,
                            "selected" => false
                        ]
                    ],
                    [
                        "iconPath" => "upload/default/diy_view/bottom/cart.png",
                        "selectedIconPath" => "upload/default/diy_view/bottom/cart_selected.png",
                        "text" => "购物车",
                        "link" => [
                            "addon_name" => "",
                            "addon_title" => null,
                            "name" => "GOODS_CART",
                            "title" => "购物车",
                            "web_url" => "",
                            "wap_url" => "/pages/goods/cart/cart",
                            "icon" => "",
                            "addon_icon" => null,
                            "selected" => false
                        ],
                    ],
                    [
                        "iconPath" => "upload/default/diy_view/bottom/member_index.png",
                        "selectedIconPath" => "upload/default/diy_view/bottom/member_index_selected.png",
                        "text" => "我的",
                        "link" => [
                            "addon_name" => "",
                            "addon_title" => null,
                            "name" => "MEMBER_INDEX",
                            "title" => "会员中心",
                            "web_url" => "",
                            "wap_url" => "/pages/member/index/index",
                            "icon" => "",
                            "addon_icon" => null,
                            "selected" => false
                        ]
                    ]
                ]

            ];

            // 底部导航
            $result = $diy_view_model->setBottomNavConfig(json_encode($diy_view_bottom_nav), $param[ 'site_id' ]);
            return $res;

        }

    }

}