<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\shop\controller;

use app\model\goods\Config as GoodsConfigModel;
use app\model\system\Pay;
use app\model\system\Servicer as ServicerModel;
use app\model\web\Config as ConfigModel;
use app\model\system\Api;
use extend\RSA;
use app\model\system\Upgrade;

/**
 * 设置 控制器
 */
class Config extends BaseShop
{
    /**
     * 支付管理
     */
    public function pay()
    {
        if (request()->isAjax()) {
            $pay_model = new Pay();
            $list = $pay_model->getPayType([]);
            return $list;
        } else {
            return $this->fetch('config/pay');
        }
    }

    /**
     * 默认图设置
     */
    public function defaultPicture()
    {
        $upload_config_model = new ConfigModel();
        if (request()->isAjax()) {
            $data = array (
                "default_goods_img" => input("default_goods_img", ""),
                "default_headimg" => input("default_headimg", ""),
                "default_storeimg" => input("default_storeimg", ""),
            );
            $this->addLog("修改默认图配置");
            $res = $upload_config_model->setDefaultImg($data, $this->site_id, $this->app_module);

            return $res;
        } else {
            $upload_config_result = $upload_config_model->getDefaultImg($this->site_id, $this->app_module);
            $this->assign("default_img", $upload_config_result[ 'data' ][ 'value' ]);
            return $this->fetch('config/default_picture');
        }
    }

    /*
     * 售后保障
     */
    public function aftersale()
    {
        $goods_config_model = new GoodsConfigModel();
        if (request()->isAjax()) {
            $content = input('content', '');//售后保障协议
            $is_display = input('is_display',1);//默认显
            return $goods_config_model->setAfterSaleConfig('售后保障', $content, $this->site_id, $is_display);
        } else {
            $this->forthMenu();
            $content = $goods_config_model->getAfterSaleConfig($this->site_id);
            $this->assign('content', $content['data']);
            return $this->fetch('config/aftersale');
        }
    }

    /**
     * 验证码设置
     */
    public function captcha()
    {
        $config_model = new ConfigModel();
        if (request()->isAjax()) {
            $data = [
                'shop_login' => input('shop_login', 0),//后台登陆验证码是否启用 1：启用 0：不启用
                'shop_reception_login' => input('shop_reception_login', 0),//前台登陆验证码是否启用 1：启用 0：不启用
            ];
            return $config_model->setCaptchaConfig($data);
        } else {
            $config_info = $config_model->getCaptchaConfig();
            $this->assign('config_info', $config_info[ 'data' ][ 'value' ]);
            return $this->fetch('config/captcha');
        }
    }

    /**
     * api安全
     */
    public function api()
    {
        $api_model = new Api();
        if (request()->isAjax()) {
            $is_use = input("is_use", 1);
            $public_key = input("public_key", "");
            $private_key = input("private_key", "");
            $long_time = input("long_time", "0");#限制时长 0位不限制  单位小时
            $data = array (
                "public_key" => $public_key,
                "private_key" => $private_key,
                "long_time" => $long_time
            );
            $result = $api_model->setApiConfig($data, $is_use);
            return $result;
        } else {
            $this->forthMenu();
            $config_result = $api_model->getApiConfig();
            $config = $config_result[ "data" ];
            $this->assign("config", $config);
            return $this->fetch('config/api');
        }
    }

    public function generateRSA()
    {
        if (request()->isAjax()) {
            return RSA::getSecretKey();
        }
    }

    /**
     * 地图配置
     * @return mixed
     */
    public function map()
    {
        $config_model = new ConfigModel();
        if (request()->isAjax()) {
            $tencent_map_key = input("tencent_map_key", "");
            $result = $config_model->setMapConfig([
                'tencent_map_key' => $tencent_map_key
            ]);
            return $result;
        }
        $config = $config_model->getMapConfig();
        $this->assign('info', $config[ 'data' ][ 'value' ]);
        return $this->fetch('config/map');
    }

    /**
     * 客服配置
     */
    public function servicer()
    {
        $servicer_model = new ServicerModel();
        if (request()->isAjax()) {
            $system     = input('system', 0);//是否启用Niushop客服
            $weapp      = input('weapp', 0);//是否启用小程序客服
            $open       = input('open', 0);//是否启用第三方客服H5
            $open_pc    = input('open_pc', 0);//是否启用第三方客服PC
            $open_url   = input('open_url', '');//第三方客服 链接
            $socket_url = input('socket_url', '');// websocket 链接

            $data = [
                'system'     => $system,
                'weapp'      => $weapp,
                'open'       => $open,
                'open_pc'    => $open_pc,
                'open_url'   => $open_url,
                'socket_url' => $socket_url,
            ];

            return $servicer_model->setServicerConfig($data);
        } else {
            // $this->forthMenu();
            $config = $servicer_model->getServicerConfig()['data'] ?? [];
            $this->assign('config', $config['value'] ?? []);
            $this->assign('pc_is_exit', addon_is_exit('pc', $this->site_id));
            return $this->fetch('config/servicer');
        }

    }

    /**
     * 域名跳转配置
     */
    public function domainJumpConfig()
    {
        $config_model = new ConfigModel();
        if(request()->isAjax()){
            $jump_type = input("jump_type", "1");
            $result = $config_model->setDomainJumpConfig([
                'jump_type' => $jump_type
            ]);
            return $result;
        }else{
            // $this->forthMenu();
            $config = $config_model->getDomainJumpConfig();
            $this->assign('config',$config['data']['value']);
            return $this->fetch('config/domain_jump_config');
        }
        
    }


    /**
     * 网站部署
     */
    public function siteDeploy()
    {
        //查询域名跳转
        $config_model = new ConfigModel();
        $jump_type = $config_model->getDomainJumpConfig();
        $this->assign('jump_type',$jump_type['data']['value']);

        //查询不同端部署数据
        $site_deploy_data = event('SiteDeployData');
        $site_deploy_data = array_column($site_deploy_data, null, 'type');
        $this->assign('site_deploy_data', $site_deploy_data ?? []);
        //查询客服设置
        $servicer_model = new ServicerModel();
        $servicer_config = $servicer_model->getServicerConfig()['data'] ?? [];
        $servicer_config['value']['pc_is_exit'] = addon_is_exit('pc', $this->site_id);
        $this->assign('servicer_config', $servicer_config['value'] ?? []);
		
		return $this->fetch('config/site_deploy');
    }
}