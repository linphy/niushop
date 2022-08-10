<?php

namespace app\api\controller;

use app\model\goods\GoodsCategory as GoodsCategoryModel;

/**
 * 商品分类
 * Class Goodscategory
 * @package app\api\controller
 */
class Goodscategory extends BaseApi
{

    /**
     * 树状结构信息
     */
    public function tree()
    {
        $level = isset($this->params[ 'level' ]) ? $this->params[ 'level' ] : 3;// 分类等级 1 2 3
        $goods_category_model = new GoodsCategoryModel();
        $condition = [
            [ 'is_show', '=', 0 ],
            [ 'level', '<=', $level ],
            [ 'site_id', '=', $this->site_id ]
        ];

        $field = "category_id,category_name,short_name,pid,level,image,category_id_1,category_id_2,category_id_3,image_adv,link_url";
        $order = "sort asc,category_id desc";
        $list = $goods_category_model->getCategoryTree($condition, $field, $order);

        return $this->response($list);
    }

    public function info()
    {
        $category_id = $this->params['category_id'] ?? 0;
        $goods_category_model = new GoodsCategoryModel();
        $data = $goods_category_model->getCategoryInfo([ ['category_id', '=', $category_id], ['site_id', '=', $this->site_id] ]);
        if (!empty($data['data'])) {
            $child_list = $goods_category_model->getCategoryList([ ['pid', '=', $category_id], ['site_id', '=', $this->site_id], ['is_show', '=', 0] ], 'category_id,category_name,short_name,pid,level,is_show,sort,image,attr_class_id,attr_class_name,category_id_1,category_id_2,category_id_3,commission_rate,image_adv', 'sort asc,category_id desc');
            $data['data']['child_list'] = $child_list['data'];
        }
        return $this->response($data);
    }
}