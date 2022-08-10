<?php
/**
 * Index.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */

namespace app\api\controller;

use app\model\cart\CartCalculate as CartCalculateModel;
/**
 * 购物车计算
 * @author Administrator
 *
 */
class Cartcalculate extends BaseApi
{
    /**
     *购物车计算
     */
    public function calculate(){
        $token = $this->checkToken();
        if ($token['code'] < 0) return $this->response($token);
        $sku_ids = isset($this->params['sku_ids']) ? json_decode($this->params['sku_ids'], true) : [];
        $data         = [
            'sku_ids'          => $sku_ids,
            'site_id'         => $this->site_id,//站点id
            'member_id'       => $this->member_id,
            'order_from'      => $this->params['app_type'],
            'order_from_name' => $this->params['app_type_name'],
        ];

        $cart_calculate_model = new CartCalculateModel();
        $res = $cart_calculate_model->calculate($data);

        return $this->response($this->success($res));

    }





}