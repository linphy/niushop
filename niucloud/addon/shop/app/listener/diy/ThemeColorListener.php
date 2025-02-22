<?php
// +----------------------------------------------------------------------
// | Niucloud-admin 企业快速开发的多应用管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace addon\shop\app\listener\diy;

/**
 * 主题色
 * Class ThemeColorListener
 * @package addon\shop\app\listener\diy
 */
class ThemeColorListener
{

    public function handle($params)
    {
        if (!empty($params[ 'key' ]) && $params[ 'key' ] == 'shop') {
            return [
                'title' => '热情红',
                'name' => 'red',
                'theme' => [
                    '--primary-color' => '#FF4142', // 主色
                    '--primary-help-color' => '#FB7939', // 辅色
                    '--price-text-color' => '#FF4142',// 价格颜色
                    '--primary-color-dark' => '#F26F3E', // 灰色
                    '--primary-color-disabled' => '#FFB397', // 禁用色
                    '--primary-color-light' => '#FFEAEA', // 边框色（深）
                    '--primary-color-light2' => '#fff7f7', // 边框色（淡）
                    '--page-bg-color' => '#f6f6f6', // 页面背景色
                ],
            ];
        }
    }
}