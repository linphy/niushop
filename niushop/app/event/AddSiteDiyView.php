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


/**
 * 增加默认自定义数据：网站主页、商品分类、底部导航
 */
class AddSiteDiyView
{

    public function handle($param)
    {
        if (!empty($param[ 'site_id' ])) {

            $name = 'official_default_round'; // 官方模板一
            $res = event('UseDiyTemplate', [ 'site_id' => $param[ 'site_id' ], 'name' => $name ], true);
            return $res;
        }
    }

}