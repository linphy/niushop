<?php

namespace addon\shop;


use app\service\admin\diy\DiyService;
use app\service\core\diy\CoreDiyService;
use app\service\core\poster\CorePosterService;

/**
 * 插件安装之后单独的插件方法
 */
class Addon
{
    /**
     * 插件安装执行
     */
    public function install()
    {
        // 创建默认商品海报
        $poster = new CorePosterService();
        $template = $poster->getTemplateList('shop', 'shop_goods')[ 0 ];
        $poster->add('shop', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);

        // 创建默认积分商品海报
        $poster = new CorePosterService();
        $template = $poster->getTemplateList('shop', 'shop_point_goods')[ 0 ];
        $poster->add('shop', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);

        $diy_service = new DiyService();

        // 设置 首页 默认模板
        $diy_service->setDiyData([
            'key' => 'DIY_INDEX',
            'type' => 'index',
            'addon' => 'shop',
            'is_start' => 1
        ]);

        // 设置 个人中心 默认模板
        $diy_service->setDiyData([
            'key' => 'DIY_MEMBER_INDEX',
            'type' => 'member_index',
            'addon' => 'shop',
            'is_start' => 1
        ]);

        // 创建 积分商城 微页面
        $addon_flag = [ 'DIY_SHOP_POINT_INDEX' ];
        $addon_index_template = $diy_service->getFirstPageData($addon_flag, 'shop');
        $diy_service->add([
            'page_title' => $addon_index_template[ 'title' ],
            "title" => $addon_index_template[ 'title' ],
            "name" => $addon_flag,
            "type" => $addon_flag,
            "template" => $addon_index_template[ 'template' ],
            "mode" => $addon_index_template[ 'mode' ],
            "value" => json_encode($addon_index_template[ 'data' ]),
            "is_default" => 1,
            "is_change" => 0
        ]);
        return true;
    }

    /**
     * 插件卸载执行
     */
    public function uninstall()
    {
        // 删除自定义海报
        $poster = new CorePosterService();
        $poster->del([
            [ 'type', 'in', [ 'shop_goods', 'shop_point_goods' ] ]
        ]);

        // 删除微页面
        $diy_service = new CoreDiyService();
        $diy_service->del([
            [ 'name', 'in', [ 'DIY_SHOP_INDEX', 'DIY_SHOP_MEMBER_INDEX', 'DIY_SHOP_POINT_INDEX' ] ]
        ]);

        return true;
    }

    /**
     * 插件升级执行
     */
    public function upgrade()
    {
        return true;
    }
}
