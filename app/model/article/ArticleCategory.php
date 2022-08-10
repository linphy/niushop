<?php
// +---------------------------------------------------------------------+
// | NiuCloud | [ WE CAN DO IT JUST NiuCloud ]                |
// +---------------------------------------------------------------------+
// | Copy right 2019-2029 www.niucloud.com                          |
// +---------------------------------------------------------------------+
// | Author | NiuCloud <niucloud@outlook.com>                       |
// +---------------------------------------------------------------------+
// | Repository | https://github.com/niucloud/framework.git          |
// +---------------------------------------------------------------------+

namespace app\model\article;

use app\model\BaseModel;

/**
 * 文章分类
 */
class ArticleCategory extends BaseModel
{
    /**
     * 添加文章分类
     * @param $data
     * @return array
     */
    public function addArticleCategory($data)
    {
        $data[ 'create_time' ] = time();
        $res = model('article_category')->add($data);
        return $this->success($res);
    }

    /**
     * 编辑文章分类
     * @param $condition
     * @param $data
     * @return array
     */
    public function editArticleCategory($condition, $data)
    {
        $data[ 'update_time' ] = time();

        $res = model('article_category')->update($data, $condition);
        return $this->success($res);
    }

    /**
     * 删除文章分类
     * @param $article_id
     * @param $site_id
     * @return array|\multitype
     */
    public function deleteArticleCategory($category_id, $site_id)
    {
        //文章数
        $article_count = model('article')->getCount([ [ 'category_id', '=', $category_id ], [ 'site_id', '=', $site_id ] ]);
        if ($article_count > 0) {
            return $this->error('', '该分类下存在文章，暂不能删除');
        } else {
            $res = model('article_category')->delete([ [ 'category_id', '=', $category_id ], [ 'site_id', '=', $site_id ] ]);
            return $this->success($res);
        }
    }

    /**
     * 获取文章分类信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getArticleCategoryInfo($condition = [], $field = '*')
    {
        $info = model('article_category')->getInfo($condition, $field);
        return $this->success($info);
    }

    /**
     * 获取文章分类列表
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param string $limit
     */
    public function getArticleCategoryList($condition = [], $field = '*', $order = '', $limit = null)
    {
        $list = model('article_category')->getList($condition, $field, $order, '', '', '', $limit);
        return $this->success($list);
    }

    /**
     * 获取文章分页列表
     * @param array $condition
     * @param int $page
     * @param int $page_size
     * @param string $order
     * @param string $field
     * @return array
     */
    public function getArticleCategoryPageList($condition = [], $page = 1, $page_size = PAGE_LIST_ROWS, $order = '', $field = '*')
    {
        $list = model('article_category')->pageList($condition, $field, $order, $page, $page_size);
        return $this->success($list);
    }

}