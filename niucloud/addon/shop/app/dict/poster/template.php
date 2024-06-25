<?php
return [
    [
        "name" => "商品模板", // 海报模板名称
        'type' => 'shop_goods', // 海报类型
        "data" => [
            "global" => [
                "bgType" => "color",
                "bgColor" => "#ffffff",
                "bgUrl" => "",
                "imgWidth" => 1500,
                "imgHeight" => 2400,
                "width" => 720,
                "height" => 1280
            ],
            "value" => [
                [
                    "id" => "2v1nc497xhc0",
                    "componentName" => "GoodsImage",
                    "componentTitle" => "商品图片",
                    "type" => "image",
                    "path" => "goods-image",
                    "uses" => 1,
                    "relate" => "goods_img",
                    "value" => "",
                    "width" => 360,
                    "height" => 360,
                    "minWidth" => 30,
                    "minHeight" => 30,
                    "x" => 0,
                    "y" => 0,
                    "angle" => 0,
                    "zIndex" => 1
                ],
                [
                    "id" => "29f3czpuw134",
                    "componentName" => "GoodsName",
                    "componentTitle" => "商品名称",
                    "type" => "text",
                    "path" => "goods-name",
                    "uses" => 1,
                    "relate" => "goods_name",
                    "value" => "",
                    "width" => 80,
                    "height" => 30,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 20,
                    "y" => 380,
                    "angle" => 0,
                    "zIndex" => 2,
                    "fontFamily" => "",
                    "fontSize" => 22,
                    "fontColor" => "#303133"
                ],
                [
                    "id" => "2vmf9ovhene0",
                    "componentName" => "GoodsPrice",
                    "componentTitle" => "商品价格",
                    "type" => "text",
                    "path" => "goods-price",
                    "uses" => 1,
                    "relate" => "goods_price",
                    "value" => "",
                    "width" => 80,
                    "height" => 30,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 20,
                    "y" => 470,
                    "angle" => 0,
                    "zIndex" => 3,
                    "fontFamily" => "static/font/price.ttf",
                    "fontSize" => 22,
                    "fontColor" => "#E4163F"
                ],
                [
                    "id" => "2vef9ovhene9",
                    "componentName" => "GoodsMarketPrice",
                    "componentTitle" => "划线价",
                    "type" => "text",
                    'path' => "goods-market-price",
                    "uses" => 1,
                    'relate' => 'goods_market_price',
                    "value" => "",
                    "width" => 83,
                    "height" => 27,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 20,
                    "y" => 520,
                    "angle" => 0,
                    "zIndex" => 4,
                    "fontFamily" => "static/font/price.ttf",
                    "fontSize" => 18,
                    "fontColor" => "#999999"
                ],
                [
                    "id" => "2rlojy3o60i0",
                    "componentName" => "Qrcode",
                    "componentTitle" => "二维码",
                    "type" => "qrcode",
                    "path" => "qrcode",
                    "uses" => 1,
                    "relate" => "url",
                    "value" => "",
                    "width" => 100,
                    "height" => 100,
                    "minWidth" => 30,
                    "minHeight" => 30,
                    "x" => 240,
                    "y" => 470,
                    "angle" => 0,
                    "zIndex" => 5
                ],
                [
                    "id" => "7a18udv7t950",
                    "componentName" => "draw",
                    "componentTitle" => "绘画",
                    "type" => "draw",
                    "path" => "draw",
                    "uses" => 1,
                    "relate" => "draw",
                    "value" => "",
                    "width" => 360,
                    "height" => 35,
                    "minWidth" => 30,
                    "minHeight" => 30,
                    "x" => 0,
                    "y" => 603,
                    "angle" => 0,
                    "zIndex" => 6,
                    "drawType" => "Polygon",
                    "bgColor" => "#eeeeee",
                    "points" => [
                        [
                            0,
                            1206
                        ],
                        [
                            720,
                            1206
                        ],
                        [
                            720,
                            1280
                        ],
                        [
                            0,
                            1280
                        ]
                    ]
                ],
                [
                    "id" => "6hlj5l3as0w0",
                    "componentName" => "Text",
                    "componentTitle" => "文本",
                    "type" => "text",
                    "path" => "text",
                    "uses" => 0,
                    "relate" => "",
                    "value" => "长按识别图中的二维码查看商品详情",
                    "width" => 256,
                    "height" => 24,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 55,
                    "y" => 615,
                    "angle" => 0,
                    "zIndex" => 7,
                    "fontFamily" => "",
                    "fontSize" => 16,
                    "fontColor" => "#666666"
                ],
            ]
        ]
    ],
    [
        "name" => "积分商品模板", // 海报模板名称
        'type' => 'shop_point_goods', // 海报类型
        "data" => [
            "global" => [
                "bgType" => "color",
                "bgColor" => "#ffffff",
                "bgUrl" => "",
                "imgWidth" => 1500,
                "imgHeight" => 2400,
                "width" => 720,
                "height" => 1280
            ],
            "value" => [
                [
                    "id" => "2v1nc497xhc0",
                    "componentName" => "GoodsImage",
                    "componentTitle" => "商品图片",
                    "type" => "image",
                    "path" => "goods-image",
                    "uses" => 1,
                    "relate" => "goods_img",
                    "value" => "",
                    "width" => 360,
                    "height" => 360,
                    "minWidth" => 30,
                    "minHeight" => 30,
                    "x" => 0,
                    "y" => 0,
                    "angle" => 0,
                    "zIndex" => 1
                ],
                [
                    "id" => "29f3czpuw134",
                    "componentName" => "GoodsName",
                    "componentTitle" => "商品名称",
                    "type" => "text",
                    "path" => "goods-name",
                    "uses" => 1,
                    "relate" => "goods_name",
                    "value" => "",
                    "width" => 80,
                    "height" => 30,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 20,
                    "y" => 380,
                    "angle" => 0,
                    "zIndex" => 2,
                    "fontFamily" => "",
                    "fontSize" => 22,
                    "fontColor" => "#303133"
                ],
                [
                    "id" => "2vmf9ovhene0",
                    "componentName" => "GoodsPrice",
                    "componentTitle" => "商品价格",
                    "type" => "text",
                    "path" => "goods-price",
                    "uses" => 1,
                    "relate" => "goods_price",
                    "value" => "",
                    "width" => 81,
                    "height" => 30,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 20,
                    "y" => 470,
                    "angle" => 0,
                    "zIndex" => 3,
                    "fontFamily" => "",
                    "fontSize" => 20,
                    "fontColor" => "#E4163F"
                ],
                [
                    "id" => "2rlojy3o60i0",
                    "componentName" => "Qrcode",
                    "componentTitle" => "二维码",
                    "type" => "qrcode",
                    "path" => "qrcode",
                    "uses" => 1,
                    "relate" => "url",
                    "value" => "",
                    "width" => 100,
                    "height" => 100,
                    "minWidth" => 30,
                    "minHeight" => 30,
                    "x" => 240,
                    "y" => 470,
                    "angle" => 0,
                    "zIndex" => 5
                ],
                [
                    "id" => "7a18udv7t950",
                    "componentName" => "draw",
                    "componentTitle" => "绘画",
                    "type" => "draw",
                    "path" => "draw",
                    "uses" => 1,
                    "relate" => "draw",
                    "value" => "",
                    "width" => 360,
                    "height" => 35,
                    "minWidth" => 30,
                    "minHeight" => 30,
                    "x" => 0,
                    "y" => 603,
                    "angle" => 0,
                    "zIndex" => 6,
                    "drawType" => "Polygon",
                    "bgColor" => "#eeeeee",
                    "points" => [
                        [
                            0,
                            1206
                        ],
                        [
                            720,
                            1206
                        ],
                        [
                            720,
                            1280
                        ],
                        [
                            0,
                            1280
                        ]
                    ]
                ],
                [
                    "id" => "6hlj5l3as0w0",
                    "componentName" => "Text",
                    "componentTitle" => "文本",
                    "type" => "text",
                    "path" => "text",
                    "uses" => 0,
                    "relate" => "",
                    "value" => "长按识别图中的二维码查看商品详情",
                    "width" => 256,
                    "height" => 24,
                    "minWidth" => 60,
                    "minHeight" => 22,
                    "x" => 55,
                    "y" => 615,
                    "angle" => 0,
                    "zIndex" => 7,
                    "fontFamily" => "",
                    "fontSize" => 16,
                    "fontColor" => "#666666"
                ],
            ]
        ]
    ],
];