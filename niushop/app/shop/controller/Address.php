<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\shop\controller;

use app\model\system\Address as AddressModel;
use app\model\web\Config as ConfigModel;
use app\Controller;

/**
 * 地址控制器
 * Class Order
 * @package app\shop\controller
 */
class Address extends Controller
{
    /**
     * 通过ajax得到运费模板的地区数据
     */
    public function getAreaList()
    {
        $address_model = new AddressModel();
        $level         = input('level', 1);
        $pid           = input("pid", 0);
        $condition     = array(
            "level" => $level,
            "pid"   => $pid
        );
        $list          = $address_model->getAreaList($condition, "id, pid, name, level", "id asc");
        return $list;
    }

    /**
     * 获取地理位置id
     */
    public function getGeographicId()
    {
        $address_model = new AddressModel();
        $address       = request()->post("address", ",,");
        $address_array = explode(",", $address);
        $province      = $address_array[0];
        $city          = $address_array[1];
        $district      = $address_array[2];
        $subdistrict   = $address_array[3];
        $province_list = $address_model->getAreaList(["name" => $province, "level" => 1], "id", '');
        $province_id   = !empty($province_list["data"]) ? $province_list["data"][0]["id"] : 0;
        $city_list     = ($province_id > 0) && !empty($city) ? $address_model->getAreaList(["name" => $city, "level" => 2, "pid" => $province_id], "id", '') : [];
        $city_id       = !empty($city_list["data"]) ? $city_list["data"][0]["id"] : 0;
        $district_list = !empty($district) && $city_id > 0 && $province_id > 0 ? $address_model->getAreaList(["name" => $district, "level" => 3, "pid" => $city_id], "id", '') : [];
        $district_id   = !empty($district_list["data"]) ? $district_list["data"][0]["id"] : 0;

        $subdistrict_list = !empty($subdistrict) && $city_id > 0 && $province_id > 0 && $district_id > 0 ? $address_model->getAreaList(["name" => $subdistrict, "level" => 4, "pid" => $district_id], "id", '') : [];
        $subdistrict_id   = !empty($subdistrict_list["data"]) ? $subdistrict_list["data"][0]["id"] : 0;
        return ["province_id" => $province_id, "city_id" => $city_id, "district_id" => $district_id, "subdistrict_id" => $subdistrict_id];
    }

    public function getLocation(){
        $config_model = new ConfigModel();
        $mp_config = $config_model->getMapConfig(request()->siteid());
        $tencent_map_key = $mp_config['data']['value']['tencent_map_key'];

        $url = 'https://apis.map.qq.com/ws/location/v1/ip?key='.$tencent_map_key;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);

        return $data;
    }
}