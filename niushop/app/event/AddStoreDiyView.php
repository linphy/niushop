<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\event;

use app\model\web\DiyView as DiyViewModel;


/**
 * 增加默认自定义数据：网站主页
 */
class AddStoreDiyView
{

    public function handle($param)
    {
        if (!empty($param[ 'site_id' ])) {

            $diy_view_model = new DiyViewModel();

            // 添加自定义主页装修
            $value = json_encode(
                [
                    "global" => [
                        "title" => "门店主页",
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
                            "componentName" => "StoreInfo",
                            "componentTitle" => "门店信息",
                            "isDelete" => 0,
                            "pageBgColor" => "",
                            "topAroundRadius" => 0,
                            "bottomAroundRadius" => 0,
                            "topElementAroundRadius" => 0,
                            "bottomElementAroundRadius" => 0,
                            "margin" => [
                                "top" => 0,
                                "bottom" => 0,
                                "both" => 0
                            ],
                            "elementBgColor" => ""
                        ]
                    ]
                ]
            );

            // 门店主页
            $data = [
                'site_id' => $param[ 'site_id' ],
                'title' => '门店主页',
                'name' => 'DIY_STORE_' . $param[ 'store_id' ],
                'type' => 'store',
                'is_default' => 1,
                'value' => $value
            ];
            $res = $diy_view_model->addSiteDiyView($data);

            return $res;

        }

    }

}