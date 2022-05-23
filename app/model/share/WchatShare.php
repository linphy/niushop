<?php

/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\model\share;

use app\model\goods\Goods as GoodsModel;
use app\model\system\Site as SiteModel;
use app\model\system\Config as ConfigModel;

/**
 * 分享
 */
class WchatShare extends WchatShareBase
{
    protected $config = [
        [
            'title' => '商城首页',
            'config_key' => 'WCHAT_SHARE_CONFIG_INDEX',
            'path' => ['/','/pages/index/index/index'],
            'method_prefix' => 'index',
        ],
        [
            'title' => '商品详情页',
            'config_key' => 'WCHAT_SHARE_CONFIG_GOODS_DETAIL',
            'path' => ['/pages/goods/detail/detail'],
            'method_prefix' => 'goodsDetail',
        ],
        [
            'title' => '商品列表页',
            'config_key' => 'WCHAT_SHARE_CONFIG_GOODS_LIST',
            'path' => ['/pages/goods/list/list'],
            'method_prefix' => 'goodsList',
        ],
    ];

    protected $sort = 1;

    /**
     * 首页分享数据
     * @param $param
     * @return array
     */
    protected function indexShareData($param)
    {
        $site_id = $param['site_id'] ?? 0;

        //站点设置
        $site_model = new SiteModel();
        $site_info = $site_model->getSiteInfo([['site_id', '=', $site_id]])['data'];

        //跳转路径
        $link = $this->getShareLink($param);

        //获取和替换配置数据
        $config_method = preg_replace('/Data$/', 'Config',__FUNCTION__);
        $config_data = $this->$config_method($param);
        $title = str_replace('{site_name}', $site_info['site_name'], $config_data['value']['title']);
        $desc = str_replace('{site_name}', $site_info['site_name'], $config_data['value']['desc']);
        $image_url = $config_data['value']['imgUrl'] ? $config_data['value']['imgUrl'] : $site_info['logo'];
        //如果都没有设置 则取默认分享图标
        if(empty($image_url)){
            $image_url = $this->getDefaultShareIcon();
        }

        $data = [
            'title' => $title,
            'desc' => $desc,
            'link' => $link,
            'imgUrl' => $image_url,
        ];
        return [
            'permission' => [
                'hideOptionMenu' => false,
                'hideMenuItems' => [],
            ],
            'data' => $data,//分享内容
        ];
    }

    /**
     * 首页分享配置
     * @param $param
     * @return array
     */
    protected function indexShareConfig($param)
    {
        $site_id = $param['site_id'];
        $config = $param['config'];

        $config_model = new ConfigModel();
        $data = $config_model->getConfig([
            ['site_id', '=', $site_id],
            ['app_module', '=', 'shop'],
            ['config_key', '=', $config['config_key']],
        ])['data'];
        if (empty($data['value'])) {
            $data['value'] = [
                'title' => '{site_name}',
                'desc' => '用心精选，常来逛逛',
                'imgUrl' => '',
            ];
        }
        $variable = [
            ['title' => '店铺名称', 'name' => '{site_name}'],
        ];

        return [
            'value' => $data['value'],
            'variable' => $variable,
        ];
    }

    /**
     * 商品详情分享数据
     * @param $param
     */
    protected function goodsDetailShareData($param)
    {
        $site_id = $param['site_id'] ?? 0;
        $url = $param['url'];

        $parse_res = parse_url($url);
        parse_str($parse_res['query'] ?? '', $query);

        if(isset($query['sku_id'])){
            $sku_id = $query['sku_id'];
            $goods = new GoodsModel();
            $sku_info = $goods->getGoodsSkuDetail($sku_id, $site_id)['data'];
            if(!empty($sku_info)){
                $config_method = preg_replace('/Data$/', 'Config',__FUNCTION__);
                $config_data = $this->$config_method($param);

                $title = str_replace('{goods_name}', $sku_info['sku_name'], $config_data['value']['title']);
                $desc = str_replace('{price}', $sku_info['discount_price'], $config_data['value']['desc']);
                $desc = str_replace('\n', '\r\n', $desc);
                $link = $this->getShareLink($param);

                $data = [
                    'title' => $title,
                    'desc' => $desc,
                    'link' => $link,
                    'imgUrl' => $sku_info['sku_image'],
                ];
                return [
                    'permission' => [
                        'hideOptionMenu' => false,
                        'hideMenuItems' => [],
                    ],
                    'data' => $data,//分享内容
                ];
            }
        }
    }

    /**
     * 商品详情分享配置
     * @param $param
     * @return array
     */
    public function goodsDetailShareConfig($param)
    {
        $site_id = $param['site_id'];
        $config = $param['config'];
        $config['config_key'] = 'WCHAT_SHARE_CONFIG_GOODS_DETAIL';

        $config_model = new ConfigModel();
        $data = $config_model->getConfig([['site_id', '=', $site_id], ['app_module', '=', 'shop'], ['config_key', '=', $config['config_key']]])['data'];
        if (empty($data['value'])) {
            $data['value'] = [
                'title' => "{goods_name}",
                'desc' => "优惠价：￥{price}\n全场正品\n收藏热度：★★★★★",
            ];
        }
        $variable = [
            ['title' => '商品名称', 'name' => '{goods_name}'],
            ['title' => '价格', 'name' => '{price}'],
        ];

        return [
            'value' => $data['value'],
            'variable' => $variable,
        ];
    }

    /**
     * 商品列表分享数据
     * @param $param
     * @return array
     */
    protected function goodsListShareData($param)
    {
        $site_id = $param['site_id'] ?? 0;

        //站点设置
        $site_model = new SiteModel();
        $site_info = $site_model->getSiteInfo([['site_id', '=', $site_id]])['data'];

        //跳转路径
        $link = $this->getShareLink($param);

        //获取和替换配置数据
        $config_method = preg_replace('/Data$/', 'Config',__FUNCTION__);
        $config_data = $this->$config_method($param);
        $title = $config_data['value']['title'];
        $desc = $config_data['value']['desc'];
        $image_url = $config_data['value']['imgUrl'] ? $config_data['value']['imgUrl'] : $site_info['logo'];

        $data = [
            'title' => $title,
            'desc' => $desc,
            'link' => $link,
            'imgUrl' => $image_url,
        ];
        return [
            'permission' => [
                'hideOptionMenu' => false,
                'hideMenuItems' => [],
            ],
            'data' => $data,//分享内容
        ];
    }

    /**
     * 商品列表分享配置
     * @param $param
     * @return array
     */
    protected function goodsListShareConfig($param)
    {
        $site_id = $param['site_id'];
        $config = $param['config'];

        $config_model = new ConfigModel();
        $data = $config_model->getConfig([
            ['site_id', '=', $site_id],
            ['app_module', '=', 'shop'],
            ['config_key', '=', $config['config_key']],
        ])['data'];
        if (empty($data['value'])) {
            $data['value'] = [
                'title' => '来看看有哪些好物吧',
                'desc' => "用心精选\n常来逛逛",
                'imgUrl' => '',
            ];
        }
        $variable = [

        ];

        return [
            'value' => $data['value'],
            'variable' => $variable,
        ];
    }
}
