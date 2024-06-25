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

namespace addon\shop\app\service\admin\goods;

use addon\shop\app\model\goods\Label;
use core\base\BaseAdminService;
use core\exception\AdminException;


/**
 * 商品标签服务层
 * Class LabelService
 * @package addon\shop\app\service\admin\goods
 */
class LabelService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Label();
    }

    /**
     * 获取商品标签列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'label_id,label_name,memo,sort,create_time,update_time';
        $order = 'label_id desc';
        if (!empty($where[ 'order' ])) {
            $order = $where[ 'order' ] . ' ' . $where[ 'sort' ];
        }

        $search_model = $this->model->where([ ['label_id', '>', 0] ])->withSearch([ "label_name" ], $where)->field($field)->order($order);
        $list = $this->pageQuery($search_model);
        return $list;
    }

    /**
     * 获取商品标签列表
     * @param array $where
     * @param string $field
     * @return array
     */
    public function getList(array $where = [], $field = 'label_id,label_name,memo,sort,create_time,update_time')
    {
        $order = 'sort asc';
        return $this->model->where([ ['label_id', '>', 0] ])->withSearch([ "label_name" ], $where)->field($field)->order($order)->select()->toArray();
    }

    /**
     * 获取商品标签信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'label_id,label_name,memo,sort,create_time,update_time';

        $info = $this->model->field($field)->where([ [ 'label_id', '=', $id ] ])->findOrEmpty()->toArray();
        return $info;
    }

    /**
     * 添加商品标签
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data[ 'create_time' ] = time();
        $brandInfo = $this->model->where([ [ 'label_name', '=', $data['label_name']] ])->findOrEmpty()->toArray();
        if($brandInfo)
        {
            throw new AdminException('标签已存在，请检查');
        }
        $res = $this->model->create($data);
        return $res->label_id;
    }

    /**
     * 商品标签编辑
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit(int $id, array $data)
    {
        $data[ 'update_time' ] = time();
        $labelInfo = $this->model->where([ [ 'label_name', '=', $data['label_name']] ])->findOrEmpty()->toArray();
        if($labelInfo && $labelInfo['label_id'] != $id )
        {
            throw new AdminException('标签已存在，请检查');
        }

        $this->model->where([ [ 'label_id', '=', $id ] ])->update($data);
        return true;
    }

    /**
     * 删除商品标签
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        $model = $this->model->where([ [ 'label_id', '=', $id ] ])->find();
        $res = $model->delete();
        return $res;
    }

    /**
     * 修改排序
     * @param $data
     * @return Label
     */
    public function modifySort($data)
    {
        return $this->model->where([
            [ 'label_id', '=', $data[ 'label_id' ] ],
        ])->update([ 'sort' => $data[ 'sort' ] ]);
    }

}
