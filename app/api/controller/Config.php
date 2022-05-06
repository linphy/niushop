<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 * @author : niuteam
 */

namespace app\api\controller;

use app\model\goods\Cart as CartModel;
use app\model\system\Config as ConfigSystemModel;
use app\model\system\Servicer;
use app\model\web\Config as ConfigModel;
use app\model\web\DiyView as DiyViewModel;

class Config extends BaseApi
{

    /**
     * 详情信息
     */
    public function defaultimg()
    {
        $upload_config_model = new ConfigModel();
        $res = $upload_config_model->getDefaultImg($this->site_id, 'shop');
        if (!empty($res[ 'data' ][ 'value' ])) {
            return $this->response($this->success($res[ 'data' ][ 'value' ]));
        } else {
            return $this->response($this->error());
        }
    }

    /**
     * 版权信息
     */
    public function copyright()
    {
        $config_model = new ConfigModel();
        $res = $config_model->getCopyright($this->site_id, 'shop');
        return $this->response($this->success($res[ 'data' ][ 'value' ]));
    }

    /**
     * 获取当前时间戳
     * @return false|string
     */
    public function time()
    {
        $time = time();
        return $this->response($this->success($time));
    }

    /**
     * 获取验证码配置
     */
    public function getCaptchaConfig()
    {

        $config_model = new ConfigModel();
        $info = $config_model->getCaptchaConfig();
        return $this->response($this->success($info));
    }

    /**
     * 客服配置
     */
    public function servicer()
    {
        $servicer_model = new Servicer();
        $result = $servicer_model->getServicerConfig()[ 'data' ] ?? [];
        return $this->response($this->success($result[ 'value' ] ?? []));
    }

    public function init()
    {

        $cart_count = 0;
        $token = $this->checkToken();
        if ($token[ 'code' ] >= 0) {
            // 购物车数量
            $cart = new CartModel();
            $condition = [
                [ 'gc.member_id', '=', $token[ 'data' ][ 'member_id' ] ],
                [ 'gc.site_id', '=', $this->site_id ],
                [ 'gs.goods_state', '=', 1 ],
                [ 'gs.is_delete', '=', 0 ]
            ];
            $list = $cart->getCartList($condition, 'gc.num');
            $list = $list[ 'data' ];
            $count = 0;
            foreach ($list as $k => $v) {
                $count += $v[ 'num' ];
            }
        }

        // 商城风格
        $config_model = new ConfigSystemModel();
        $res = $config_model->getConfig([ [ 'site_id', '=', $this->site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'SHOP_STYLE_CONFIG' ] ]);
        $diy_style = empty($res[ 'data' ][ 'value' ]) ? [ 'style_theme' => 'default' ] : $res[ 'data' ][ 'value' ];

        // 底部导航
        $diy_view = new DiyViewModel();
        $diy_bottom_nav = $diy_view->getBottomNavConfig($this->site_id);
        $diy_bottom_nav = $diy_bottom_nav[ 'data' ];

        // 插件存在性
        $addon_api = new Addon();
        $addon_is_exit = json_decode($addon_api->addonisexit(), true);

        // 默认图
        $config_model = new ConfigModel();
        $default_img = $config_model->getDefaultImg($this->site_id, 'shop');

        // 版权信息
        $copyright = $config_model->getCopyright($this->site_id, 'shop');

        $res = [
            'cart_count' => $cart_count,
            'style_theme' => $diy_style[ 'style_theme' ],
            'diy_bottom_nav' => $diy_bottom_nav[ 'value' ] ? json_decode($diy_bottom_nav[ 'value' ], true) : [],
            'addon_is_exit' => $addon_is_exit[ 'data' ],
            'default_img' => $default_img[ 'data' ][ 'value' ],
            'copyright' => $copyright[ 'data' ][ 'value' ]
        ];

        return $this->response($this->success($res));
    }

    /**
     * 获取pc首页商品分类配置
     * @return false|string
     */
    public function categoryconfig(){
        $config_model = new ConfigModel();
        $config_info = $config_model->getCategoryConfig($this->site_id);
        return $this->response($this->success($config_info[ 'data' ][ 'value' ]));
    }
}