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

namespace addon\shop\app\service\core\delivery;

use app\service\core\sys\CoreConfigService;
use core\base\BaseCoreService;


/**
 * 自提门店服务层
 * Class StoreService
 * @package addon\shop\app\service\admin\delivery
 */
class CoreDeliveryService extends BaseCoreService
{
    //系统配置文件
    public $core_config_service;

    public function __construct()
    {
        parent::__construct();
        $this->core_config_service = new CoreConfigService();
    }

    /**
     * 配置设置
     * @param array $params
     * @return array
     */

    public function setConfig(int $site_id, $key, $data)
    {
        $this->core_config_service->setConfig($site_id, $key, $data);
        return true;
    }


    /**
     * 物流
     */
    public function getExpressConfig(int $site_id)
    {
        $data = ( new CoreConfigService() )->getConfigValue($site_id, 'SHOP_DELIVERY_CONFIG');
        if (empty($data)) {
            $expressInfo = [
                'name' => '物流配送',
                'status' => '',
                'key' => 'express'
            ];
        } else {
            $expressInfo = $data[ array_search('express', array_column($data, 'key')) ];
        }
        return $expressInfo;
    }


    /**
     * 同城
     */
    public function getLocalDeliveryConfig(int $site_id)
    {
        $data = ( new CoreConfigService() )->getConfigValue($site_id, 'SHOP_DELIVERY_CONFIG');
        if (empty($data)) {
            $localDeliveryInfo = [
                'name' => '同城配送',
                'status' => '',
                'key' => 'local_delivery'
            ];
        } else {
            $localDeliveryInfo = $data[ array_search('local_delivery', array_column($data, 'key')) ];
        }
        return $localDeliveryInfo;
    }

    /**
     * 门店
     */
    public function getStoreConfig(int $site_id)
    {
        $data = ( new CoreConfigService() )->getConfigValue($site_id, 'SHOP_DELIVERY_CONFIG');
        if (empty($data)) {
            $storeInfo = [
                'name' => '门店配送',
                'status' => '',
                'key' => 'store'
            ];
        } else {
            $storeInfo = $data[ array_search('store', array_column($data, 'key')) ];
        }
        return $storeInfo;
    }


    /**
     * 查询物流配置
     * @return array
     */
    public function getDeliveryConfig(int $site_id)
    {
        $data = ( new CoreConfigService() )->getConfigValue($site_id,'SHOP_DELIVERY_CONFIG');
        if (empty($data)) {
            $list = [
                'express' => [
                    'name' => '物流配送',
                    'status' => 1,
                    'key' => 'express'
                ],
                'local_delivery' => [
                    'name' => '同城配送',
                    'status' => 1,
                    'key' => 'local_delivery'
                ],
                'store' => [
                    'name' => '门店自提',
                    'status' => 1,
                    'key' => 'store'
                ]
            ];
        } else {
            foreach ($data as $value) {
                $list[ $value[ 'key' ] ] = [
                    'name' => $value[ 'name' ],
                    'status' => $value[ 'status' ],
                    'key' => $value[ 'key' ]
                ];
            }
        }
        return $list;
    }

    /**
     * 查询物流配置
     * @return array
     */
    public function getDeliveryList(int $site_id)
    {
        $deliver = ( new CoreConfigService() )->getConfigValue($site_id, 'SHOP_DELIVERY_CONFIG');
        foreach ($deliver as $value) {
            $list[ $value[ 'key' ] ] = [
                'name' => $value[ 'name' ],
                'status' => $value[ 'status' ],
                'key' => $value[ 'key' ]
            ];
        }
        if (empty($deliver)) {
            $deliver = [
                [
                    'name' => '物流配送',
                    'status' => 1,
                    'key' => 'express'
                ],
                [
                    'name' => '同城配送',
                    'status' => 1,
                    'key' => 'local_delivery'
                ],
                [
                    'name' => '门店自提',
                    'status' => 1,
                    'key' => 'store'
                ],
            ];
        }
        return $deliver;
    }

}
