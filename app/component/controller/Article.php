<?php

namespace app\component\controller;


/**
 * 文章·组件
 */
class Article extends BaseDiyView
{
    /**
     * 后台编辑界面
     */
    public function design()
    {
//        $site_id = request()->siteid();
//        $goods_category_model = new GoodsCategory();
//        $category_condition[] = [ 'site_id', '=', $site_id ];
//        $category_list = $goods_category_model->getCategoryTree($category_condition);
//        $category_list = $category_list[ 'data' ];
//        $this->assign("category_list", $category_list);

        return $this->fetch("article/design.html");
    }
}