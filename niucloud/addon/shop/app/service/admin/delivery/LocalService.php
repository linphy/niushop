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

use addon\shop\app\model\delivery\Local;
use core\base\BaseAdminService;

/**
 * 同城配送服务层
 * Class LocalService
 * @package addon\shop\app\service\admin\delivery
 */
class LocalService extends BaseAdminService
{

    /**
     * 设置同城配送
     * @param array $data
     * @return void
     */
    public function setLocal(array $data)
    {
        ( new Local() )->delete();

        $create_res = ( new Local() )->create([
            'center' => $data[ 'center' ],
            'fee_type' => $data[ 'fee_type' ],
            'base_dist' => $data[ 'base_dist' ],
            'base_price' => $data[ 'base_price' ],
            'grad_dist' => $data[ 'grad_dist' ],
            'grad_price' => $data[ 'grad_price' ],
            'weight_start' => $data[ 'weight_start' ],
            'weight_unit' => $data[ 'weight_unit' ],
            'weight_price' => $data[ 'weight_price' ],
            'delivery_type' => $data[ 'delivery_type' ],
            'area' => $data[ 'area' ]
        ]);
        return $create_res->local_id;
    }

    /**
     * 获取同城配送设置
     * @return void
     */
    public function getLocal()
    {
        return ( new Local() )->findOrEmpty()->toArray();
    }
}
