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
    'template' => [
//		[
//			'name' => 'DIY_VIEW_INDEX',
//			'title' => '网站主页',
//			'value' => '',
//			'type' => 'SHOP',
//			'icon' => ''
//		],
    ],
    'util' => [
        [
            'name' => 'Text', // 组件控制器名称
            'title' => '标题',
            'type' => 'SYSTEM', // 组件类型，SYSTEM 基础组件，PROMOTION 营销组件
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "title" : "『文本』", "textColor" : "#333333", "defaultTextColor": "#333333", "alignStyle": "center", "subTitle" : "副标题", "marginTop": 0, "padding": 0, "backgroundColor" : "", "link" : {"name":""}, "fontSize" : 16, "fontSizeSub" : 14, "colorSub": "#999", "defaultColorSub": "#999", "style": 1, "sub": 0, "styleName": "模板一", "isShowMore": 0, "fontWeight": 600, "moreText": "查看更多", "moreLink" : {}, "btnColor": "#999", "defaultBtnColor": "#999" }',
            'value' => '{"style":"style-1","styleName":"风格1","text":"标题栏","link":{"name":""},"fontSize":16,"fontWeight":500,"subTitle":{"text":"副标题","color":"#999999","fontSize":14,"isElementShow":false,"bgColor":"","icon":"","fontWeight":"500"},"more":{"text":"查看更多","link":{"name":""},"isElementShow":false,"isShow":false,"color":"#999999"}}',
            'sort' => '10000',
            'support_diy_view' => '', // 支持的自定义页面（为空表示公共组件都支持）
            'max_count' => 0, // 限制添加次数
            'is_delete' => 0, // 组件是否可以删除，0 允许，1 禁用
            'icon' => 'iconbiaoti', // 组件字体图标
        ],
        [
            'name' => 'Notice',
            'title' => '公告',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "sources": "default","backgroundColor": "", "marginTop": 0, "style": 1, "isEdit": 1, "styleName": "风格一", "textColor": "#333333", "defaultTextColor": "#333333", "fontSize": 14,"list": [{"title": "公告","link": {}}], "noticeIds": []}',
            'value' => '{"list":[{"title":"公告","link":{"name":""}}],"sources":"initial","iconSources":"initial","noticeIds":[],"iconType":"img","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"imageUrl":""}',
            'sort' => '10002',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'icongonggao1',
        ],
        [
            'name' => 'GraphicNav',
            'title' => '图文导航',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "textColor": "#666666","defaultTextColor": "#666666", "navRadius": "fillet", "backgroundColor": "","selectedTemplate": "imageNavigation", "showType": 4, "scrollSetting": "fixed", "padding" : 20, "marginTop": 0, "list": [{"imageUrl": "","title": "","link": { "name" : "" }, "imgWidth": 0, "imgHeight": 0},{"imageUrl": "","title": "","link": { "name" : "" }, "imgWidth": 0, "imgHeight": 0},{"imageUrl": "","title": "","link": { "name" : "" }, "imgWidth": 0, "imgHeight": 0},{"imageUrl": "","title": "","link": { "name" : "" }, "imgWidth": 0, "imgHeight": 0}]}',
            'value' => '{"mode":"graphic","type":"img","showStyle":"fixed","ornament":{"type":"default","color":"#EDEDED"},"rowCount":4,"pageCount":2,"carousel":{"type":"circle","color":"#FFFFFF"},"imageSize":40,"aroundRadius":25,"font":{"size":14,"weight":500,"color":"#303133"},"list":[{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""},{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""},{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""},{"title":"","imageUrl":"","iconType":"icon","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"link":{"name":""},"label":{"control":false,"text":"热门","textColor":"#FFFFFF","bgColorStart":"#F83287","bgColorEnd":"#FE3423"},"icon":""}]}',
            'sort' => '10003',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'icontuwendaohang2',
        ],
        [
            'name' => 'ImageAds',
            'title' => '图片广告',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "selectedTemplate" : "single-graph", "imageClearance" : 0, "imageRadius": "right-angle", "carouselChangeStyle": "circle", "marginTop": 0, "padding" : 0, "height" : 0, "list" : [ { "imageUrl" : "", "title" : "", "link" : { "name" : "" }, "imgWidth": 0, "imgHeight": 0} ] }',
            'value' => '{"indicatorColor":"#ffffff","carouselStyle":"circle","indicatorLocation":"center","list":[{"imageUrl":"","link":{"name":""},"imgWidth":0,"imgHeight":0}]}',
            'sort' => '10004',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'icontupianguanggao1',
        ],
        [
            'name' => 'Search',
            'title' => '搜索框',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "title" : "搜索", "textColor": "#999999", "textAlign" : "left", "backgroundColor" : "#ffffff", "bgColor": "#e8e8e8", "defaultTextColor": "#999999", "borderType": 2 ,"searchType":1,"searchImg":"","searchStyle":1}',
            'value' => '{"searchStyle":1,"title":"搜索","textAlign":"left","borderType":2,"iconType":"img","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0},"imageUrl":""}',
            'sort' => '10005',
            'support_diy_view' => '',
            'max_count' => 1,
            'icon' => 'iconsousuokuang',
        ],
        [
            'name' => 'RichText',
            'title' => '富文本',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "backgroundColor": "","padding": 10,"html" : "", "marginTop": 0}',
            'value' => '{"html":""}',
            'sort' => '10007',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfuwenben1',
        ],
        [
            'name' => 'RubikCube',
            'title' => '魔方',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "selectedTemplate": "row1-of2","backgroundColor": "","list": [{ "imageUrl" : "", "link" : { "name" : "" } },{ "imageUrl" : "", "link" : { "name" : "" } }], "selectedRubikCubeArray" : [] ,"diyHtml": "","customRubikCube": 4,"heightArray": ["74.25px","59px","48.83px","41.56px"],"imageGap": 0, "marginTop": 0}',
            'value' => '{"mode":"row1-of2","imageGap":0,"list":[{"imageUrl":"","imgWidth":0,"imgHeight":0,"previewWidth":0,"previewHeight":0,"link":{"name":""}},{"imageUrl":"","imgWidth":0,"imgHeight":0,"previewWidth":0,"previewHeight":0,"link":{"name":""}}]}',
            'sort' => '10008',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconmofang1'
        ],
        [
            'name' => 'HorzLine',
            'title' => '辅助线',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "color" : "#000000", "defaultColor" : "#000000", "margin" : 0, "borderStyle": "solid", "padding": 0 }',
            'value' => '{"color":"#303133","borderStyle":"solid"}',
            'sort' => '10011',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfuzhuxian1'
        ],
        [
            'name' => 'HorzBlank',
            'title' => '辅助空白',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ height : 10, backgroundColor : "", "marginLeftRight": 0 }',
            'value' => '{"height":10}',
            'sort' => '10012',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconfuzhukongbai1'
        ],
        [
            'name' => 'Video',
            'title' => '视频',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "textColor": "#ffffff", "backgroundColor": "",baseBtnBottom:0,"btnBottom":"0","bottomPosition": "4", subTitle : "", "list" : [{ "imageUrl" : "", "videoUrl": "", "is_play": "0","is_mute": "0" }]}',
            'value' => '{"imageUrl":"","videoUrl":"","type":"upload"}',
            'sort' => '10013',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconshipin1'
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
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "sources" : "default", "categoryId" : 0, "categoryName": "请选择", "goodsCount" : "6", "goodsId": [], "groupTitle": "", "style": 1, "backgroundColor": "", "marginTop": 0, "paddingLeftRight": 0, "isShowCart": 0, "cartStyle": 1, "isShowGoodName": 1, "isShowMarketPrice": 1, "isShowGoodSaleNum": 1, "isShowGoodSubTitle": 0, "goodsTag": "default", "tagImg": {"imageUrl": ""}}',
//        cartEvent：购物车事件（detail：跳转商品详情、cart：弹框加购物车）
            'value' => '{"ornament":{"type":"default","color":"#EDEDED"},"template":"row1-of2","goodsMarginType": "default","goodsMarginNum": 10,"style":"style-1","sources":"initial","count":6,"goodsId":[],"categoryId":0,"categoryName":"请选择","sortWay":"default","nameLineMode":"single","imgAroundRadius":0,"slideMode":"scroll","theme":"default","btnStyle":{"text":"购买","textColor":"#FFFFFF","theme":"default","aroundRadius":25,"control":false,"support":false,"bgColor":"#FF6A00","style":"button","iconDiy":{"iconType":"icon","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0}}},"tag":{"text":"隐藏","value":"hidden"},"cartEvent":"detail","goodsNameStyle":{"color":"#303133","control":true,"fontWeight":false},"saleStyle":{"color":"#999CA7","control":true,"support":true},"priceStyle":{"mainColor":"#FF6A00","mainControl":true,"lineColor":"#999CA7","lineControl":true,"lineSupport":true}}',
            'sort' => '10016',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconshangpinliebiao1'
        ],
        [
            'name' => 'ManyGoodsList',
            'title' => '多商品组',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "title": "", "selectColor": "#FF4544","nsSelectColor": "#303133", list: [{"goodsStyle": 1, title: "热卖", desc: "热卖推荐", link: {}, "sources" : "category", "categoryId" : 0, "categoryName": "请选择", "goodsId": []}], "goodsCount" : "6", "style": 1, "backgroundColor": "", "marginTop": 0 }',
            'value' => '{"ornament":{"type":"default","color":"#EDEDED"},"template":"row1-of2","goodsMarginType": "default","goodsMarginNum": 10,"style":"style-1","count":6,"sortWay":"default","nameLineMode":"single","imgAroundRadius":0,"slideMode":"scroll","theme":"default","btnStyle":{"text":"购买","textColor":"#FFFFFF","theme":"default","aroundRadius":25,"control":false,"support":false,"bgColor":"#FF6A00","style":"button","iconDiy":{"iconType":"icon","icon":"","style":{"fontSize":"60","iconBgColor":[],"iconBgColorDeg":0,"iconBgImg":"","bgRadius":0,"iconColor":["#000000"],"iconColorDeg":0}}},"tag":{"text":"隐藏","value":"hidden"},"cartEvent":"detail","goodsNameStyle":{"color":"#303133","control":true,"fontWeight":false},"saleStyle":{"color":"#999CA7","control":true,"support":true},"priceStyle":{"mainColor":"#FF6A00","mainControl":true,"lineColor":"#999CA7","lineControl":true,"lineSupport":true},"list":[{"title":"热卖","desc":"热卖推荐","sources":"category","categoryId":0,"categoryName":"请选择","goodsId":[]}]}',
            'sort' => '10017',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconduoshangpinzu',
        ],
        [
            'name' => 'GoodsRecommend',
            'title' => '商品推荐',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "title": "", "selectColor": "#FF4544","nsSelectColor": "#303133", list: [{"goodsStyle": 1, title: "热卖", desc: "热卖推荐", link: {}, "sources" : "category", "categoryId" : 0, "categoryName": "请选择", "goodsId": []}], "goodsCount" : "6", "style": 1, "backgroundColor": "", "marginTop": 0 }',
            'value' => '{"style":"style-1","count":6,"nameLineMode":"single","sortWay":"default","ornament":{"type":"default","color":"#EDEDED"},"imgAroundRadius":10,"goodsNameStyle":{"color":"#303133","control":true,"fontWeight":false},"saleStyle":{"color":"#999CA7","control":true,"support":true},"theme":"default","priceStyle":{"mainColor":"#FF1544","mainControl":true,"lineColor":"#999CA7","lineControl":false,"lineSupport":false},"sources":"initial","goodsId":[],"categoryId":0,"categoryName":"请选择","topStyle":{"title":"今日推荐","subTitle":"大家都在买","icon":{"value":"icon-system-tuijian","color":"#FF3D3D","bgColor":""},"color":"#303133","subColor":"#999CA7"},"bgUrl":"","styleName":"风格1"}',
            'sort' => '10018',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'icontuijianshangpin',
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
            'icon' => 'iconshangpinfenlei1'
        ],
        [
            'name' => 'GoodsBrand',
            'title' => '商品品牌',
            'type' => 'SYSTEM',
            'value' => '{"style":"style-1","sources":"initial","brandIds":[],"title":"品牌展示","fontWeight":false,"previewList":{},"count":8,"ornament":{"type":"default","color":"#EDEDED"}}',
            'sort' => '10020',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconshangpinpinpai'
        ],
        [
            'name' => 'TopCategory',
            'title' => '分类导航',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{"title":"首页","selectColor":"#FF4544","nsSelectColor":"#333333",backgroundColor : "",styleType:"line"}',
            'value' => '{"title":"首页","selectColor":"#FF4544","noColor":"#333333","styleType":"line"}',
            'sort' => '10022',
            'support_diy_view' => '',
            'max_count' => 1,
            'icon' => 'icondaohang',
        ],
        [
            'name' => 'FloatBtn',
            'title' => '浮动按钮',
            'type' => 'SYSTEM',
            // 旧数据结构不要删除，后续写升级函数作参考
//            'value' => '{ "textColor": "#ffffff", "backgroundColor": "","baseBtnBottom":0,"btnBottom":"0","bottomPosition": "4", "subTitle" : "", "list": [{"imageUrl": "", "link": {}}]}',
            'value' => '{"btnBottom":"0","bottomPosition":"4","list":[{"imageUrl":"","link":{"name":""},"iconType":"img","icon":"","style": {"fontSize": "60", "iconBgColor": [], "iconBgColorDeg": 0,"iconBgImg": "",bgRadius: 0,iconColor: ["#000000"],iconColorDeg: 0} }]}',
            'sort' => '10023',
            'support_diy_view' => '',
            'max_count' => 1,
            'icon' => 'iconfudonganniu1',
        ],
        [
            'name' => 'Article',
            'title' => '文章',
            'type' => 'SYSTEM',
            'value' => '{"style":"style-1","sources":"initial","previewList":{},"count":8,"ornament":{"type":"default","color":"#EDEDED"},"articleIds":[]}',
            'sort' => '10024',
            'support_diy_view' => '',
            'max_count' => 0,
            'icon' => 'iconwenzhang',
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
            'name' => 'GAME',
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