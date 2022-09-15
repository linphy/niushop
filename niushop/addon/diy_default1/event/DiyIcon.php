<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace addon\diy_default1\event;

/**
 * 扩展自定义图标库
 */
class DiyIcon
{
    /**
     * 行为扩展的执行入口必须是run
     * @param $data
     * @return mixed
     */
    public function handle($data)
    {
        return [

            // 组件图标文件路径
            'comp' => [
                'name' => 'icon-comp-diy-default', // 字体名称
                'path' => 'addon/diy_default1/shop/view/public/css/comp_iconfont.css'
            ],

            // 自定义图标库文件路径
            'icon' => [
                'name' => 'icondiy-my-template', // 字体名称
                'path' => 'addon/diy_default1/shop/view/public/css/diy_iconfont.css'
            ],

            // 图标类型
            'type' => [
                'icon-building' => '建筑',
                'icon-furniture' => '家具',
                'icon-animal' => '动物',
            ]
        ];
    }

}