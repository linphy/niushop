<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\model\web;

use app\model\system\Config as ConfigModel;
use app\model\BaseModel;
use app\model\system\Upgrade;
use app\model\upload\Upload;

/**
 * 网站系统性设置
 */
class Config extends BaseModel
{
    //缓存类型
    private $cache_list = [
        [
            'name' => '数据缓存',
            'desc' => '数据缓存',
            'key' => 'content',
            'icon' => 'public/static/img/cache/data.png'
        ],
        [
            'name' => '数据表缓存',
            'desc' => '数据表缓存',
            'key' => 'data_table_cache',
            'icon' => 'public/static/img/cache/data_table.png'
        ],
        [
            'name' => '模板缓存',
            'desc' => '模板缓存',
            'key' => 'template_cache',
            'icon' => 'public/static/img/cache/template.png'
        ],
    ];

    /**
     * 验证码设置
     * array $data
     */
    public function setCaptchaConfig($data, $site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '验证码设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'CAPTCHA_CONFIG' ] ]);
        return $res;
    }

    /**
     * 查询验证码设置
     */
    public function getCaptchaConfig($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'CAPTCHA_CONFIG' ] ]);

        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'shop_login' => 1,
                'shop_reception_login' => 1
            ];
        } else {
            if (isset($res[ 'data' ][ 'value' ][ 'shop_reception_login' ]) === false) {
                $res[ 'data' ][ 'value' ][ 'shop_reception_login' ] = 1;
            }
        }
        return $res;
    }

    /**
     * 默认图上传配置
     * array $data
     */
    public function setDefaultImg($data, $site_id = 0, $app_module = 'shop')
    {
        $config_info = $this->getDefaultImg($site_id, $app_module);
        if(!empty($config_info[ 'data' ][ 'value' ])){
            if($data['default_goods_img'] && $config_info[ 'data' ][ 'value' ]['default_goods_img'] && $data['default_goods_img'] != $config_info[ 'data' ][ 'value' ]['default_goods_img']){
                $upload_model = new Upload();
                $upload_model->deletePic($config_info['data']['value']['default_goods_img'], $site_id);
            }
            if($data['default_headimg'] && $config_info[ 'data' ][ 'value' ]['default_headimg'] && $data['default_headimg'] != $config_info[ 'data' ][ 'value' ]['default_headimg']){
                $upload_model = new Upload();
                $upload_model->deletePic($config_info['data']['value']['default_headimg'], $site_id);
            }
            if($data['default_storeimg'] && $config_info[ 'data' ][ 'value' ]['default_storeimg'] && $data['default_goods_img'] != $config_info[ 'data' ][ 'value' ]['default_storeimg']){
                $upload_model = new Upload();
                $upload_model->deletePic($config_info['data']['value']['default_storeimg'], $site_id);
            }
        }

        $config = new ConfigModel();
        $res = $config->setConfig($data, '默认图设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'DEFAULT_IMAGE' ] ]);
        return $res;
    }

    /**
     * 默认图查询上传配置
     */
    public function getDefaultImg($site_id, $app_model = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_model ], [ 'config_key', '=', 'DEFAULT_IMAGE' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                "default_goods_img" => "upload/default/default_img/goods.png",
                "default_headimg" => "upload/default/default_img/head.png",
                "default_storeimg" => "upload/default/default_img/store.png"
            ];
        } else {
            if (!isset($res[ 'data' ][ 'value' ]['default_storeimg'])) $res[ 'data' ][ 'value' ]['default_storeimg'] = "upload/default/default_img/store.png";
        }
        return $res;
    }

    /**
     * 获取缓存类型
     */
    public function getCacheList()
    {
        return $this->cache_list;
    }

    public function setCopyright($data, $site_id = 1, $app_model = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '版权设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_model ], [ 'config_key', '=', 'COPYRIGHT' ] ]);
        return $res;
    }

    /**
     * 获取版权信息
     * @return array
     */
    public function getCopyright($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'COPYRIGHT' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'logo' => '',
                'company_name' => '',
                'copyright_link' => '',
                'copyright_desc' => '',
                'icp' => '',
                'gov_record' => '',
                'gov_url' => '',
                'market_supervision_url' => ''
            ];
        } else {
            $auth_info = cache("authinfo_copyright");
            if(empty($auth_info))
            {
                $upgrade_model = new Upgrade();
                $auth_info = $upgrade_model->authInfo();
                cache("authinfo_copyright", $auth_info, ['expire' => 604800]);
            }
            if (is_null($auth_info) || $auth_info[ 'code' ] != 0) {
                $res[ 'data' ][ 'value' ][ 'logo' ] = '';
                $res[ 'data' ][ 'value' ][ 'company_name' ] = '';
                $res[ 'data' ][ 'value' ][ 'copyright_link' ] = '';
                $res[ 'data' ][ 'value' ][ 'copyright_desc' ] = '';
            }
          
        }
        return $res;
    }

    /**
     * 授权设置
     * @param $data
     * @param int $site_id
     * @param string $app_model
     * @return array
     */
    public function setAuth($data, $site_id = 1, $app_model = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '授权设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_model ], [ 'config_key', '=', 'AUTH' ] ]);
        return $res;
    }

    /**
     * 获取授权设置
     * @return array
     */
    public function getAuth($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'AUTH' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'code' => '',
            ];
        }
        return $res;
    }

    /**
     * 地图设置
     * @param $data
     * @param int $site_id
     * @param string $app_model
     * @return array
     */
    public function setMapConfig($data, $site_id = 1, $app_model = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '地图设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_model ], [ 'config_key', '=', 'MAP_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取地图设置
     * @return array
     */
    public function getMapConfig($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'MAP_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'tencent_map_key' => '',
            ];
        }
        return $res;
    }

    /**
     * h5域名配置
     */
    public function seth5DomainName($data, $site_id = 1, $app_modle = 'shop')
    {

        $search = '/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/';
        if($data['deploy_way'] == 'indep'){
            if(!preg_match($search,$data['domain_name_h5'])){
                return $this->error('','请输入正确的域名地址');
            }
        }
        $config = new ConfigModel();
        $res = $config->setConfig($data, 'H5域名配置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_modle ], [ 'config_key', '=', 'H5_DOMAIN_NAME' ] ]);

        return $res;
    }

    /**
     * 获取h5域名配置
     */
    public function geth5DomainName($site_id = 1, $app_module = 'shop')
    {

        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'H5_DOMAIN_NAME' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'domain_name_h5' => __ROOT__ . '/h5',
                'deploy_way' => 'default'
            ];
        } else {
            if ($res[ 'data' ][ 'value' ][ 'domain_name_h5' ] == '' || empty($res[ 'data' ][ 'value' ]['deploy_way']) || $res[ 'data' ][ 'value' ]['deploy_way'] == 'default') {
                $res[ 'data' ][ 'value' ] = [
                    'domain_name_h5' => __ROOT__ . '/h5'
                ];
            }
            $res[ 'data' ][ 'value' ]['deploy_way'] = $res[ 'data' ][ 'value' ]['deploy_way'] ?? 'default';
        }
        return $res;
    }

    /**
     * 设置域名跳转配置
     * jump_type 1前台，2后台
     */
    public function setDomainJumpConfig($data, $site_id = 1, $app_modle = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '获取域名跳转配置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_modle ], [ 'config_key', '=', 'DOMAIN_JUMP_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取域名跳转配置
     * jump_type 1前台，2后台
     */
    public function getDomainJumpConfig($site_id = 1,$app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'DOMAIN_JUMP_CONFIG' ] ]);
        if(empty($res[ 'data' ][ 'value' ])){
            $res[ 'data' ][ 'value' ] = [
                'jump_type' => 2,
            ];
        }
        return $res;
    }

    /**
     * pc域名配置
     */
    public function setPcDomainName($data, $site_id = 1, $app_modle = 'shop')
    {
        $search = '/^([hH][tT]{2}[pP]:\/\/|[hH][tT]{2}[pP][sS]:\/\/)(([A-Za-z0-9-~]+)\.)+([A-Za-z0-9-~\/])+$/';
        if($data['deploy_way'] == 'indep'){
            if(!preg_match($search,$data['domain_name_pc'])){
                return $this->error('','请输入正确的域名地址');
            }
        }
        $config = new ConfigModel();
        $res = $config->setConfig($data, 'PC域名配置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_modle ], [ 'config_key', '=', 'PC_DOMAIN_NAME' ] ]);
        return $res;
    }

    /**
     * 获取pc域名配置
     */
    public function getPcDomainName($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'PC_DOMAIN_NAME' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'domain_name_pc' => __ROOT__ . '/web',
                'deploy_way' => 'default'
            ];
        } else {
            if ($res[ 'data' ][ 'value' ][ 'domain_name_pc' ] == ''|| empty($res[ 'data' ][ 'value' ]['deploy_way']) || $res[ 'data' ][ 'value' ]['deploy_way'] == 'default') {
                $res[ 'data' ][ 'value' ] = [
                    'domain_name_pc' => __ROOT__ . '/web'
                ];
            }
            $res[ 'data' ][ 'value' ]['deploy_way'] = $res[ 'data' ][ 'value' ]['deploy_way'] ?? 'default';
        }
        return $res;
    }

    /**
     * 设置热门搜索关键词
     * @param $data
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function setHotSearchWords($data, $site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '商品热门搜索关键词', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_HOT_SEARCH_WORDS_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取热门搜索关键词
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function getHotSearchWords($site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_HOT_SEARCH_WORDS_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'words' => ''
            ];
        }
        return $res;
    }

    /**
     * 设置猜你喜欢
     * @param $data
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function setGuessYouLike($data, $site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '商品猜你喜欢', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_GUESS_YOU_LIKE_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取商品猜你喜欢
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function getGuessYouLike($site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_GUESS_YOU_LIKE_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'is_show' => 0,
                'type_show' => 1,
                'goods_ids' => ''
            ];
        }
        return $res;
    }

    /**
     * 设置默认搜索关键词
     * @param $data
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function setDefaultSearchWords($data, $site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '默认搜索关键词', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_DEFAULT_SEARCH_WORDS_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取默认搜索关键词
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function getDefaultSearchWords($site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_DEFAULT_SEARCH_WORDS_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'words' => '搜索 商品'
            ];
        }
        return $res;
    }


    /**
     * 设置商品排序方式
     * @param $data
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function setGoodsSort($data, $site_id, $app_module)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '商品默认排序方式', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_SORT_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取商品排序方式
     * @param $site_id
     * @param $app_module
     * @return array
     */
    public function getGoodsSort($site_id, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'GOODS_SORT_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'type' => 'asc',
                'default_value' => 100
            ];
        }
        return $res;
    }

    /**
     * 导航风格设置
     * array $data
     */
    public function setStyle($data, $site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '验证码设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'STYLE_CONFIG' ] ]);
        return $res;
    }

    /**
     * 查询导航风格
     */
    public function getStyle($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'STYLE_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res = 'app/shop/view/base/style1.html';
        }else{
            $res = $res[ 'data' ][ 'value' ]['style'];
        }
        return $res;
    }

    /**
     * 设置pc
     * @param $data
     * @param int $site_id
     * @param string $app_module
     * @return array
     */
    public function setCategoryConfig($data, $site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, 'PC端首页分类设置', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'SHOP_CATEGORY_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取pc首页商品分类配置
     */
    public function getCategoryConfig($site_id = 1, $app_module = 'shop')
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', $app_module ], [ 'config_key', '=', 'SHOP_CATEGORY_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'category' => 1,
                'img' => 1
            ];
        }
        return $res;
    }

}