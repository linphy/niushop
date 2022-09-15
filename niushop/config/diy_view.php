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
            'name' => 'Text', // 组件控制器名称
            'title' => '标题',
            'type' => 'SYSTEM', // 组件类型，SYSTEM：基础组件，PROMOTION：营销组件，EXTEND：扩展组件
            'value' => '{"style":"style-1","styleName":"风格1","text":"标题栏","link":{"name":""},"fontSize":16,"fontWeight":"normal","subTitle":{"text":"副标题","color":"#999999","fontSize":14,"isElementShow":false,"bgColor":"","icon":"","fontWeight":"normal"},"more":{"text":"查看更多","link":{"name":""},"isElementShow":false,"isShow":false,"color":"#999999"}}',
            'sort' => '10000',
            'support_diy_view' => '', // 支持的自定义页面（为空表示公共组件都支持）
            'max_count' => 0, // 限制添加次数，0表示可以无限添加该组件
            'is_delete' => 0, // 组件是否可以删除，0 允许，1 禁用
            'icon' => 'iconfont iconbiaoti', // 组件字体图标
        ],
        [
            'name' => 'Notice',
            'title' => '公告',
            'type' => 'SYSTEM',
            'value' => '{"contentStyle":"style-1","list":[{"title":"公告","link":{"name":""}}],"sources":"diy","iconSources":"initial","noticeIds":[],"iconType":"img","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"imageUrl":"","scrollWay":"upDown"}',
            'sort' => '10002',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont icongonggao1',
        ],
        [
            'name' => 'GraphicNav',
            'title' => '图文导航',
            'type' => 'SYSTEM',
            'value' => '{"mode":"graphic","type":"img","showStyle":"fixed","ornament":{"type":"default","color":"#EDEDED"},"rowCount":4,"pageCount":2,"carousel":{"type":"circle","color":"#FFFFFF"},"imageSize":40,"aroundRadius":25,"font":{"size":14,"weight":"normal","color":"#303133"},"list":[{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""},{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""},{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""},{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""}]}',
            'sort' => '10003',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont icontuwendaohang2',
        ],
        [
            'name' => 'ImageAds',
            'title' => '图片广告',
            'type' => 'SYSTEM',
            'value' => '{"indicatorColor":"#ffffff","carouselStyle":"circle","indicatorLocation":"center","list":[{"imageUrl":"","link":{"name":""},"imgWidth":0,"imgHeight":0}]}',
            'sort' => '10004',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont icontupianguanggao1',
        ],
        [
            'name' => 'Search',
            'title' => '搜索框',
            'type' => 'SYSTEM',
            'value' => '{"searchStyle":1,"title":"搜索","textAlign":"left","borderType":2,"iconType":"img","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"imageUrl":""}',
            'sort' => '10005',
            'support_diy_view' => '',
            'max_count' => 1,
            'icon' => 'iconfont iconsousuokuang',
        ],
        [
            'name' => 'RichText',
            'title' => '富文本',
            'type' => 'SYSTEM',
            'value' => '{"html":""}',
            'sort' => '10007',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconfuwenben1',
        ],
        [
            'name' => 'RubikCube',
            'title' => '魔方',
            'type' => 'SYSTEM',
            'value' => '{"mode":"row1-of2","imageGap":0,"list":[{"imageUrl":"","imgWidth":0,"imgHeight":0,"previewWidth":0,"previewHeight":0,"link":{"name":""}},{"imageUrl":"","imgWidth":0,"imgHeight":0,"previewWidth":0,"previewHeight":0,"link":{"name":""}}]}',
            'sort' => '10008',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconmofang1'
        ],
        [
            'name' => 'HorzLine',
            'title' => '辅助线',
            'type' => 'SYSTEM',
            'value' => '{"color":"#303133","borderStyle":"solid"}',
            'sort' => '10011',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconfuzhuxian1'
        ],
        [
            'name' => 'HorzBlank',
            'title' => '辅助空白',
            'type' => 'SYSTEM',
            'value' => '{"height":10}',
            'sort' => '10012',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconfuzhukongbai1'
        ],
        [
            'name' => 'Video',
            'title' => '视频',
            'type' => 'SYSTEM',
            'value' => '{"imageUrl":"","videoUrl":"","type":"upload"}',
            'sort' => '10013',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconshipin1'
        ],
//		[
//			'name' => 'VOICE',
//			'title' => '语音',
//			'type' => 'SYSTEM',
//			'controller' => '',
//			'value' => '',
//			'sort' => '10014',
//			'support_diy_view' => '',
//			'max_count' => 0
//		],
        [
            'name' => 'GoodsList',
            'title' => '商品列表',
            'type' => 'SYSTEM',
//        cartEvent：购物车事件（detail：跳转商品详情、cart：弹框加购物车）
            'value' => '{"ornament":{"type":"default","color":"#EDEDED"},"template":"row1-of2","goodsMarginType": "default","goodsMarginNum": 10,"style":"style-1","sources":"initial","count":6,"goodsId":[],"categoryId":0,"categoryName":"请选择","sortWay":"default","nameLineMode":"single","imgAroundRadius":0,"slideMode":"scroll","theme":"default","btnStyle":{"text":"购买","textColor":"#FFFFFF","theme":"default","aroundRadius":25,"control":false,"support":false,"bgColor":"#FF6A00","style":"button","iconDiy":{"iconType":"icon","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0}}},"tag":{"text":"隐藏","value":"hidden"},"cartEvent":"detail","goodsNameStyle":{"color":"#303133","control":true,"fontWeight":false},"saleStyle":{"color":"#999CA7","control":true,"support":true},"priceStyle":{"mainColor":"#FF6A00","mainControl":true,"lineColor":"#999CA7","lineControl":true,"lineSupport":true}}',
            'sort' => '10016',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconshangpinliebiao1'
        ],
        [
            'name' => 'ManyGoodsList',
            'title' => '多商品组',
            'type' => 'SYSTEM',
            'value' => '{"ornament":{"type":"default","color":"#EDEDED"},"template":"row1-of2","goodsMarginType": "default","goodsMarginNum": 10,"style":"style-1","count":6,"sortWay":"default","nameLineMode":"single","imgAroundRadius":0,"slideMode":"scroll","theme":"default","btnStyle":{"text":"购买","textColor":"#FFFFFF","theme":"default","aroundRadius":25,"control":false,"support":false,"bgColor":"#FF6A00","style":"button","iconDiy":{"iconType":"icon","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0}}},"tag":{"text":"隐藏","value":"hidden"},"cartEvent":"detail","goodsNameStyle":{"color":"#303133","control":true,"fontWeight":false},"saleStyle":{"color":"#999CA7","control":true,"support":true},"priceStyle":{"mainColor":"#FF6A00","mainControl":true,"lineColor":"#999CA7","lineControl":true,"lineSupport":true},"list":[{"title":"热卖","desc":"热卖推荐","sources":"category","categoryId":0,"categoryName":"请选择","goodsId":[]}]}',
            'sort' => '10017',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconduoshangpinzu',
        ],
        [
            'name' => 'GoodsRecommend',
            'title' => '商品推荐',
            'type' => 'SYSTEM',
            'value' => '{"style":"style-1","count":6,"nameLineMode":"single","sortWay":"default","ornament":{"type":"default","color":"#EDEDED"},"imgAroundRadius":10,"goodsNameStyle":{"color":"#303133","control":true,"fontWeight":false},"saleStyle":{"color":"#999CA7","control":true,"support":true},"theme":"default","priceStyle":{"mainColor":"#FF1544","mainControl":true,"lineColor":"#999CA7","lineControl":false,"lineSupport":false},"sources":"initial","goodsId":[],"categoryId":0,"categoryName":"请选择","topStyle":{"title":"今日推荐","subTitle":"大家都在买","icon":{"value":"icondiy icon-system-tuijian","color":"#FF3D3D","bgColor":""},"color":"#303133","subColor":"#999CA7"},"bgUrl":"","styleName":"风格1"}',
            'sort' => '10018',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont icontuijianshangpin',
        ],
        [
            'name' => 'GoodsCategory',
            'title' => '商品分类',
            'type' => 'SYSTEM',
            'value' => '{"level":"2","template":"1", "quickBuy": 1, "search": 1, "goodsLevel" : 2, "loadType": "part" }',
            'sort' => '10019',
            'support_diy_view' => 'DIY_VIEW_GOODS_CATEGORY',
            'max_count' => 1,
            'is_delete' => 1,
            'icon' => 'iconfont iconshangpinfenlei1'
        ],
        [
            'name' => 'GoodsBrand',
            'title' => '商品品牌',
            'type' => 'SYSTEM',
            'value' => '{"style":"style-1","sources":"initial","brandIds":[],"title":"品牌展示","fontWeight":false,"previewList":{},"count":8,"ornament":{"type":"default","color":"#EDEDED"}}',
            'sort' => '10020',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconshangpinpinpai'
        ],
        [
            'name' => 'TopCategory',
            'title' => '分类导航',
            'type' => 'SYSTEM',
            'value' => '{"title":"首页","selectColor":"#FF4544","noColor":"#333333","styleType":"line"}',
            'sort' => '10022',
            'support_diy_view' => '',
            'max_count' => 1,
            'icon' => 'iconfont icondaohang',
        ],
        [
            'name' => 'FloatBtn',
            'title' => '浮动按钮',
            'type' => 'SYSTEM',
            'value' => '{"btnBottom":"0","bottomPosition":"4","list":[{"imageUrl":"","link":{"name":""},"iconType":"img","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0}}]}',
            'sort' => '10023',
            'support_diy_view' => '',
            'max_count' => 1,
            'icon' => 'iconfont iconfudonganniu1',
        ],
        [
            'name' => 'Article',
            'title' => '文章',
            'type' => 'SYSTEM',
            'value' => '{"style":"style-1","sources":"initial","previewList":{},"count":8,"ornament":{"type":"default","color":"#EDEDED"},"articleIds":[]}',
            'sort' => '10024',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfont iconwenzhang',
        ],
        [
            'name' => 'MemberInfo',
            'title' => '会员信息',
            'type' => 'SYSTEM',
            'value' => '{"style":2,"theme":"default","bgColorStart":"#FF7130","bgColorEnd":"#FF1542","gradientAngle":"129","infoMargin":15}',
            'sort' => '10025',
            'support_diy_view' => 'DIY_VIEW_MEMBER_INDEX',
            'max_count' => 1,
            'icon' => 'iconfont iconwenzhang',
        ],
        [
            'name' => 'MemberMyOrder',
            'title' => '我的订单',
            'type' => 'SYSTEM',
            'value' => '{"icon":{"waitPay":{"title":"待付款","icon":"icondiy icon-system-daifukuan2","style":{"bgRadius":0,"fontSize":65,"iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","iconColor":["#FF7B1D","#FF1544"],"iconColorDeg":111}},"waitSend":{"title":"待发货","icon":"icondiy icon-system-daifahuo2","style":{"bgRadius":0,"fontSize":65,"iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","iconColor":["#FF7B1D","#FF1544"],"iconColorDeg":111}},"waitConfirm":{"title":"待收货","icon":"icondiy icon-system-daishouhuo2","style":{"bgRadius":0,"fontSize":65,"iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","iconColor":["#FF7B1D","#FF1544"],"iconColorDeg":111}},"waitRate":{"title":"待评价","icon":"icondiy icon-system-daipingjie2","style":{"bgRadius":0,"fontSize":65,"iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","iconColor":["#FF7B1D","#FF1544"],"iconColorDeg":111}},"refunding":{"title":"售后","icon":"icondiy icon-system-shuhou2","style":{"bgRadius":0,"fontSize":65,"iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","iconColor":["#FF7B1D","#FF1544"],"iconColorDeg":111}}},"style":1}',
            'sort' => '10026',
            'support_diy_view' => 'DIY_VIEW_MEMBER_INDEX',
            'max_count' => 1,
            'icon' => 'iconfont iconwenzhang',
        ],
    ],
    'link' => [
        [
            'name' => 'MALL_PAGE',
            'title' => '商城页面',
            'parent' => '',
            'wap_url' => '',
            'web_url' => '',
            'sort' => 1,
            'child_list' => [
                [
                    'name' => 'MALL_LINK',
                    'title' => '商城链接',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 0,
                    'child_list' => [
                        [
                            'name' => 'BASICS_LINK',
                            'title' => '基础链接',
                            'parent' => '',
                            'wap_url' => '',
                            'web_url' => '',
                            'sort' => 0,
                            'child_list' => [
                                [
                                    'name' => 'INDEX',
                                    'title' => '主页',
                                    'parent' => '',
                                    'wap_url' => '/pages/index/index',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHOP_CATEGORY',
                                    'title' => '商品分类',
                                    'parent' => '',
                                    'wap_url' => '/pages/goods/category',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHOPPING_TROLLEY',
                                    'title' => '购物车',
                                    'parent' => '',
                                    'wap_url' => '/pages/goods/cart',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHOPPING_NOTICE',
                                    'title' => '公告',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/notice/list',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHOPPING_HELP',
                                    'title' => '帮助',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/help/list',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHOPPING_ARTICLE',
                                    'title' => '文章',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/article/list',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHOPPING_BRAND',
                                    'title' => '品牌专区',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/goods/brand',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
//                                [
//                                    'name' => 'CUSTOMER_SERVICE',
//                                    'title' => '客服',
//                                    'parent' => '',
//                                    'wap_url' => '',
//                                    'web_url' => '',
//                                    'sort' => 0
//                                ]
                            ]
                        ],
                        [
                            'name' => 'MEMBER',
                            'title' => '会员中心',
                            'parent' => '',
                            'wap_url' => '',
                            'web_url' => '',
                            'sort' => 1,
                            'child_list' => [
                                [
                                    'name' => 'MEMBER_CENTER',
                                    'title' => '会员中心',
                                    'parent' => '',
                                    'wap_url' => '/pages/member/index',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'ALL_ORDER',
                                    'title' => '全部订单',
                                    'parent' => '',
                                    'wap_url' => '/pages/order/list',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'OBLIGATION_ORDER',
                                    'title' => '待付款订单',
                                    'parent' => '',
                                    'wap_url' => '/pages/order/list?status=waitpay',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'DELIVER_ORDER',
                                    'title' => '待发货订单',
                                    'parent' => '',
                                    'wap_url' => '/pages/order/list?status=waitsend',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'TAKE_DELIVER_ORDER',
                                    'title' => '待收货订单',
                                    'parent' => '',
                                    'wap_url' => '/pages/order/list?status=waitconfirm',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'EVALUATE_ORDER',
                                    'title' => '待评价订单',
                                    'parent' => '',
                                    'wap_url' => '/pages/order/list?status=waitrate',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'REFUND_ORDER',
                                    'title' => '退款订单',
                                    'parent' => '',
                                    'wap_url' => '/pages/order/activist',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'MEMBER_INFO',
                                    'title' => '个人资料',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/info',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SHIPPING_ADDRESS',
                                    'title' => '收货地址',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/address',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'BALANCE',
                                    'title' => '我的余额',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/balance',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'MEMBER_INTEGRAL',
                                    'title' => '我的积分',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/point',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'SIGN_IN',
                                    'title' => '签到',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/signin',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'MEMBER_LEVEL',
                                    'title' => '会员等级',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/level',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'FOOTPRINT',
                                    'title' => '我的足迹',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/footprint',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'ATTENTION',
                                    'title' => '我的关注',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/collection',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'ACCOUNT',
                                    'title' => '账户列表',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/account',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'COUPON',
                                    'title' => '优惠券',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/member/coupon',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                                [
                                    'name' => 'VERIFICATION_PLATFORM',
                                    'title' => '核销台',
                                    'parent' => '',
                                    'wap_url' => '/pages_tool/verification/index',
                                    'web_url' => '',
                                    'sort' => 0
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'name' => 'MICRO_PAGE',
                    'title' => '微页面',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 1,
                    'child_list' => []
                ],
                [
                    'name' => 'MARKETING_LINK',
                    'title' => '营销链接',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 2,
                    'child_list' => []
                ],
                [
                    'name' => 'GOODS_CATEGORY',
                    'title' => '商品分类',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 3,
                    'child_list' => []
                ]
            ]
        ],
        [
            'name' => 'COMMODITY',
            'title' => '商品',
            'parent' => '',
            'wap_url' => '',
            'web_url' => '',
            'sort' => 2,
            'child_list' => [
                [
                    'name' => 'ALL_GOODS',
                    'title' => '全部商品',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'child_list' => [],
                    'sort' => 1,
                ]
            ]
        ],
        [
            'name' => 'INTERACTION_PROMOTION',
            'title' => '互动营销',
            'parent' => '',
            'wap_url' => '',
            'web_url' => '',
            'sort' => 3,
            'child_list' => []
        ],
        [
            'name' => 'OTHER',
            'title' => '其他',
            'parent' => '',
            'wap_url' => '',
            'web_url' => '',
            'sort' => 4,
            'child_list' => [
                [
                    'name' => 'CUSTOM_LINK',
                    'title' => '自定义链接',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 1,
                    'child_list' => []
                ],
                [
                    'name' => 'OTHER_APPLET',
                    'title' => '其他小程序',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 2,
                    'child_list' => []
                ],
                [
                    'name' => 'MOBILE',
                    'title' => '拨打电话',
                    'parent' => '',
                    'wap_url' => '',
                    'web_url' => '',
                    'sort' => 3,
                    'child_list' => []
                ]
            ]
        ]
    ]
];