<?php

namespace addon\shop;


use app\service\admin\diy\DiyService;

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
        $diy_service = new DiyService();

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
        return true;
    }

    /**
     * 插件卸载执行
     */
    public function uninstall()
    {
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
