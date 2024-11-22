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

namespace addon\shop\app\dict\goods;

class GoodsDict
{
    // 实物商品
    const REAL = 'real';

    // 虚拟商品
    const VIRTUAL = 'virtual';

    const SINGLE_TIME = 1;//单次限购
    const SINGLE_PERSON = 2;//单人限购

    //商品是否赠品(0:否 1:是)
    const IS_GIFT = 1;
    const NOT_IS_GIFT = 0;

    /**
     * 商品类型
     * @param $type
     * @return array|mixed|string
     */
    public static function getType($type = '')
    {
        $list = [
            self::REAL => [
                'type' => self::REAL,
                'name' => get_lang('dict_shop_goods.real'),
                'desc' => get_lang('dict_shop_goods.real_desc'),
                'path' => '/shop/goods/real_edit',
            ],
            self::VIRTUAL => [
                'type' => self::VIRTUAL,
                'name' => get_lang('dict_shop_goods.virtual'),
                'desc' => get_lang('dict_shop_goods.virtual_desc'),
                'path' => '/shop/goods/virtual_edit',
            ]
        ];
        if ($type == '') return $list;
        return $list[ $type ];
    }
}
