<?php
return [
    'pages' => <<<EOT
        // PAGE_BEGIN
				// *********************************** 商城 ***********************************
				{
					"path": "shop/pages/index",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
                        "navigationBarTitleText": "%shop.pages.index%"
					}
				},
				{
					"path": "shop/pages/coupon/list",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.coupon.list%"
					}
				},
				{
					"path": "shop/pages/coupon/detail",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.coupon.detail%"
					}
				},
				{
					"path": "shop/pages/discount/list",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.discount.list%"
					}
				},
				{
					"path": "shop/pages/evaluate/list",
					"style": {
						"navigationBarTitleText": "%shop.pages.evaluate.list%"
					}
				},
				{
					"path": "shop/pages/evaluate/order_evaluate",
					"style": {
						"navigationBarTitleText": "%shop.pages.evaluate.order_evaluate%"
					}
				},
				{
					"path": "shop/pages/evaluate/order_evaluate_view",
					"style": {
						"navigationBarTitleText": "%shop.pages.evaluate.order_evaluate_view%"
					}
				},
				{
					"path": "shop/pages/member/my_coupon",
					"style": {
						"navigationBarTitleText": "%shop.pages.member.my_coupon%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/member/index",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
                        "navigationBarTitleText": "%shop.pages.member.index%"
					}
				},
				{
					"path": "shop/pages/goods/search",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.search%"
					}
				},
				{
					"path": "shop/pages/goods/list",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.list%"
					}
				},
				{
					"path": "shop/pages/goods/rank",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.goods.rank%"
					}
				},
				{
					"path": "shop/pages/newcomer/list",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.newcomer.list%"
					}
				},
				{
					"path": "shop/pages/goods/detail",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.detail%",
						"navigationStyle": "custom"
					}
				},
				{
					"path": "shop/pages/goods/cart",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.cart%"
					}
				},
				{
					"path": "shop/pages/goods/collect",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.collect%"
					}
				},
				{
					"path": "shop/pages/goods/browse",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.browse%"
					}
				},
				{
					"path": "shop/pages/goods/category",
					"style": {
						"navigationBarTitleText": "%shop.pages.goods.category%"
					}
				},
				{
					"path": "shop/pages/order/detail",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.order.detail%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/order/list",
					"style": {
						"navigationBarTitleText": "%shop.pages.order.list%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/order/payment",
					"style": {
						"navigationBarTitleText": "%shop.pages.order.payment%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/refund/apply",
					"style": {
						"navigationBarTitleText": "%shop.pages.refund.apply%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/refund/edit_apply",
					"style": {
						"navigationBarTitleText": "%shop.pages.refund.edit_apply%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/refund/list",
					"style": {
						"navigationBarTitleText": "%shop.pages.refund.list%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/refund/detail",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.refund.detail%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/refund/log",
					"style": {
						"navigationBarTitleText": "%shop.pages.refund.log%"
					},
					"needLogin": true
				},
				{
					"path": "shop/pages/point/index",
					"style": {
						// #ifndef H5
						"navigationStyle": "custom",
						// #endif
						"navigationBarTitleText": "%shop.pages.point.index%"
					}
				},
				{
					"path": "shop/pages/point/list",
					"style": {
						"navigationBarTitleText": "%shop.pages.point.list%"
					}
				},
				{
					"path": "shop/pages/point/detail",
					"style": {
						"navigationStyle": "custom",
						"navigationBarTitleText": "%shop.pages.point.detail%"
					}
				},
				{
					"path": "shop/pages/point/payment",
					"style": {
						"navigationBarTitleText": "%shop.pages.point.payment%"
					}
				},
				{
					"path": "shop/pages/point/order_list",
					"style": {
						"navigationBarTitleText": "%shop.pages.point.order_list%"
					}
				},
				// PAGE_END
EOT
];