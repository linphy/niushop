<?php

/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\model\verify;

use app\model\BaseModel;

/**
 * 核销编码管理
 */
class Verify extends BaseModel
{

    public $verifyFrom = [
        'shop' => '商家后台',
        'store' => '门店后台',
        'mobile' => '手机端',
    ];

    /**
     * 获取核销类型
     */
    public function getVerifyType()
    {
        $verify_type = event("VerifyType", []);
        $type = [
            'pickup' => [
                'name' => '订单自提',
            ],
            'virtualgoods' => [
                'name' => '虚拟商品',
            ]
        ];
        foreach ($verify_type as $k => $v) {
            $type = array_merge($type, $v);
        }
        return $type;
    }

    /**
     * 添加待核销记录
     * @param unknown $data
     */
    public function addVerify($type, $site_id, $site_name, $content_array, $expire_time = 0, $verify_total_count = 1)
    {
        $code = $this->getCode();
        $type_array = $this->getVerifyType();
        $data = [
            'site_id' => $site_id,
            'site_name' => $site_name,
            'verify_code' => $code,
            'verify_type' => $type,
            'verify_type_name' => $type_array[ $type ][ 'name' ],
            'verify_content_json' => json_encode($content_array, JSON_UNESCAPED_UNICODE),
            'create_time' => time(),
            'expire_time' => $expire_time,
            'verify_total_count' => $verify_total_count
        ];

        $res = model("verify")->add($data);
        return $this->success([ 'verify_code' => $code ]);
    }


    /**
     * 编辑待核销记录
     * @param $data
     * @param $condition
     * @return array
     */
    public function editVerify($data, $condition)
    {

        $res = model("verify")->update($data, $condition);
        return $this->success($res);
    }

    /**
     * 获取code值
     */
    public function getCode()
    {
        return random_keys(12);
    }

    /**
     * 执行核销
     * @param $verifier_info
     * @param $code
     */
    public function verify($verifier_info, $code)
    {
        model('verify')->startTrans();
        try {
            $verify_info = model("verify")->getInfo([ [ 'verify_code', '=', $code ] ], 'id, site_id, verify_code, verify_type, verify_type_name, verify_content_json, verifier_id, verifier_name, is_verify, expire_time, verify_total_count, verify_use_num');
            if (empty($verifier_info)) {
                return $this->error();
            }
            if ($verify_info[ 'is_verify' ] == 0) {
                if ($verify_info[ 'expire_time' ] > 0 && $verify_info[ 'expire_time' ] < time()) {
                    return $this->error('', '核销码已过期');
                }
                $verify_total_count = $verify_info[ 'verify_total_count' ];
                $verify_use_num = $verify_info[ 'verify_use_num' ];
                $now_verify_use_num = $verify_use_num + 1;

                //开始核销
                $data_verify = [
                    'verifier_id' => $verifier_info[ "verifier_id" ],
                    'verifier_name' => $verifier_info[ 'verifier_name' ],
                    'verify_from' => isset($verifier_info[ 'verify_from' ]) ? $verifier_info[ 'verify_from' ] : '',
                    'verify_remark' => isset($verifier_info[ 'verify_remark' ]) ? $verifier_info[ 'verify_remark' ] : '',
//                    'is_verify'     => 1,

                    'verify_use_num' => $now_verify_use_num
                ];
                if ($now_verify_use_num >= $verify_total_count) {
                    $data_verify[ 'is_verify' ] = 1;
                    $data_verify[ 'verify_time' ] = time();
                }

                $res = model("verify")->update($data_verify, [ [ 'id', '=', $verify_info[ 'id' ] ] ]);
                $result = event("Verify", [ 'verify_type' => $verify_info[ 'verify_type' ], 'verify_code' => $code ], true);
                $site_id = $verify_info[ 'site_id' ];
                $verify_record_model = new VerifyRecord();
                $verify_record_data = [
                    'site_id' => $site_id,
                    'verify_code' => $code,
                    'verifier_id' => $verifier_info[ "verifier_id" ],
                    'verifier_name' => $verifier_info[ 'verifier_name' ],
                    'verify_time' => time(),
                    'verify_from' => $verifier_info[ 'verify_from' ] ?? '',
                    'verify_remark' => $verifier_info[ 'verify_remark' ] ?? '',
                ];
                $verify_record_model->addVerifyRecord($verify_record_data);
                if (!empty($result) && $result[ 'code' ] < 0) {
                    model('verify')->rollback();
                    return $result;
                }
            } else {
                model('verify')->rollback();
                return $this->error('', "IS_VERIFYED");
            }

            model('verify')->commit();
            return $this->success();
        } catch (\Exception $e) {
            model('verify')->rollback();
            return $this->error('', $e->getMessage());
        }
    }

    /**
     * 获取核销信息
     * @param array $condition
     * @param string $field
     */
    public function getVerifyInfo($condition, $field = '*')
    {
        $res = model('verify')->getInfo($condition, $field);
        //验证是否存在
        if (!empty($res)) {

            if ($res[ 'is_verify' ] == 2) {
                return $this->error([], "订单已退款!");
            }

            $json_array = json_decode($res[ "verify_content_json" ], true); //格式化存储数据

            $res[ "data" ] = $json_array;
            return $this->success($res);
        } else {
            return $this->error([], "找不到核销码信息!");
        }
    }

    /**
     * 获取核销列表
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param string $limit
     */
    public function getVerifyList($condition = [], $field = '*', $order = '', $limit = null)
    {

        $list = model('verify')->getList($condition, $field, $order, '', '', '', $limit);
        return $this->success($list);
    }

    /**
     * 获取核销分页列表
     * @param array $condition
     * @param number $page
     * @param string $page_size
     * @param string $order
     * @param string $field
     */
    public function getVerifyPageList($condition = [], $page = 1, $page_size = PAGE_LIST_ROWS, $order = '', $field = '*')
    {
        $list = model('verify')->pageList($condition, $field, $order, $page, $page_size);
        foreach ($list[ "list" ] as $k => $v) {
            $temp = json_decode($v[ 'verify_content_json' ], true);
            $list[ "list" ][ $k ][ "item_array" ] = $temp[ "item_array" ];
            $list[ "list" ][ $k ][ "remark_array" ] = $temp[ "remark_array" ];
            $list[ "list" ][ $k ][ 'order_no' ] = $temp[ 'remark_array' ][ 1 ][ 'value' ];
            $order_info = model('order')->getInfo([ [ 'order_no', '=', $temp[ 'remark_array' ][ 1 ][ 'value' ] ] ], 'order_id,member_id,name,order_name');
            $list[ 'list' ][ $k ][ 'order_info' ] = $order_info;
            $list[ 'list' ][ $k ][ 'name' ] = model('member')->getValue([ [ 'member_id', '=', $list[ 'list' ][ $k ][ 'order_info' ][ 'member_id' ] ] ], 'username');
            $list[ 'list' ][ $k ][ 'sku_image' ] = "";
            if ($v[ 'verify_type' ] == "virtualgoods") {
                $order_goods_info = model("order_goods")->getInfo([ [ 'order_id', '=', $order_info[ 'order_id' ] ] ], "sku_image");
                $list[ 'list' ][ $k ][ 'sku_image' ] = $order_goods_info[ 'sku_image' ];
            }
            unset($list[ "list" ][ $k ][ "verify_content_json" ]);
            $list[ 'list' ][ $k ][ 'verifyFrom' ] = $this->verifyFrom[ $v[ 'verify_from' ] ?? '' ] ?? '';
        }

        return $this->success($list);
    }

    /**
     * 验证数据详情
     * @param $item_array
     * @param $remark_array
     */
    public function getVerifyJson($item_array, $remark_array)
    {
        $json_array = array (
            "item_array" => $item_array,
            "remark_array" => $remark_array,
        );
        return $json_array;
    }

    /**
     * 检测会员是否具备当前核销码的核销权限
     * @param $member_id
     * @param $verify_code
     */
    public function checkMemberVerify($member_id, $verify_code)
    {
        $verify_info = model("verify")->getInfo([ [ "verify_code", "=", $verify_code ] ]);
        if (empty($verify_info))
            return $this->error([], "当前核销码不存在!");

        $site_id = $verify_info[ "site_id" ];
        //验证核销员身份
        $condition = array (
            [ "member_id", "=", $member_id ],
            [ "site_id", "=", $site_id ]
        );
        $verifier_info = model("verifier")->getInfo($condition, "verifier_id,verifier_name,store_id,verifier_type");
        if (empty($verifier_info))
            return $this->error([], "没有店铺" . $verify_info[ "site_name" ] . "的核销权限!");

        //权限验证
        switch ( $verify_info[ 'verify_type' ] ) {
            case 'virtualgoods':
                //虚拟订单权限
                if ($verifier_info[ 'verifier_type' ] != 0) {
                    return $this->error([], "没有该订单的核销权限!");
                }
                break;
            case 'pickup':
                //门店自提权限
                if ($verifier_info[ 'verifier_type' ] != 0) {
                    $condition = array (
                        [ 'delivery_store_id', '=', $verifier_info[ 'store_id' ] ],
                        [ 'delivery_code', '=', $verify_code ],
                        [ 'site_id', '=', $site_id ]
                    );
                    $order_count = model("order")->getCount($condition, "order_id");
                    if (empty($order_count)) return $this->error([], "没有该门店的核销权限!");
                }
                break;
        }

        $temp = json_decode($verify_info[ 'verify_content_json' ], true);
        $verify_info[ "item_array" ] = $temp[ "item_array" ];
        $verify_info[ "remark_array" ] = $temp[ "remark_array" ];
        unset($verify_info[ "verify_content_json" ]);

        $data = array (
            "verify" => $verify_info,
            "verifier" => $verifier_info,
        );
        return $this->success($data);

    }

    /**
     * 生成核销码二维码
     * @param $code
     * @param $type
     */
    public function qrcode($code, $app_type, $verify_type, $site_id, $type = 'create')
    {
        $data = [
            'site_id' => $site_id,
            'app_type' => $app_type, // all为全部
            'type' => $type, // 类型 create创建 get获取
            'data' => [
                "code" => $code
            ],
            'page' => '/pages_tool/verification/detail',
            'qrcode_path' => 'upload/qrcode/' . $verify_type,
            'qrcode_name' => $verify_type . '_' . $code . '_' . $site_id,
        ];
        $res = event('Qrcode', $data, true);
        return $res;
    }

    /**
     * 获取核销码数量
     * @param array $condition
     * @param string $field
     */
    public function getVerifySum($condition, $field)
    {
        $res = model('verify')->getSum($condition, $field);
        return $this->success($res);

    }
}