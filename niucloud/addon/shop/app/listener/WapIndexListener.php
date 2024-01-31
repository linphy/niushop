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

namespace addon\shop\app\listener;

use app\service\core\site\CoreSiteService;

/**
 * 手机端首页加载事件
 */
class WapIndexListener
{
    public function handle()
    {
        $site_addon = (new CoreSiteService())->getAddonKeysBySiteId(request()->siteId());
        if (!in_array('shop', $site_addon)) return;

        return [
            [
                'key' => 'shop',
                "title" => get_lang("dict_wap_index.shop"),
                'desc' => get_lang("dict_wap_index.shop_desc"),
                "url" => "/addon/shop/pages/index",
                'icon'=>'addon/shop/icon.png'
            ],
        ];
    }
}
