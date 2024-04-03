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

namespace addon\shop\app\service\admin\delivery;

use addon\shop\app\model\delivery\Company;
use core\base\BaseAdminService;


/**
 * 物流公司服务层
 * Class CompanyService
 * @package addon\shop\app\service\admin\delivery
 */
class CompanyService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Company();
    }

    /**
     * 获取物流公司列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'company_id,company_name,logo,url,express_no,create_time';
        $order = '';

        $search_model = $this->model->withSearch(["company_name"], $where)->field($field)->order($order);
        $list = $this->pageQuery($search_model);
        return $list;
    }

    /**
     * 获取物流公司信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'company_id,company_name,logo,url,express_no,create_time';

        $info = $this->model->field($field)->where([['company_id', '=', $id] ])->findOrEmpty()->toArray();
        return $info;
    }

    /**
     * 添加物流公司
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data['create_time'] = time();
        $res = $this->model->create($data);
        return $res->company_id;
    }

    /**
     * 物流公司编辑
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit(int $id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where([['company_id', '=', $id] ])->update($data);
        return true;
    }

    /**
     * 删除物流公司
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        $res = $this->model->where([['company_id', '=', $id] ])->delete();
        return $res;
    }

}
