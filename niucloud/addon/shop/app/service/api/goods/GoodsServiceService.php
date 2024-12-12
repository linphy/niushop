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

namespace addon\shop\app\service\api\goods;

use addon\shop\app\model\goods\Service;
use core\base\BaseApiService;

/**
 *  商品服务服务层
 */
class GoodsServiceService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Service();
    }

    /**
     * 商品服务列表
     */
    public function getAll($data)
    {
        $limit = !empty($data[ 'limit' ]) ? $data[ 'limit' ] : 4;
        $field = 'service_id, service_name, image, desc';
        return $this->model->field($field)->order('create_time desc')->limit($limit)->select()->toArray();
    }

}
