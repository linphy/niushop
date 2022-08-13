<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\model\web;

use app\model\BaseModel;
use app\model\system\Config as ConfigModel;
use think\facade\Cache;

/**
 * 自定义模板
 */
class DiyView extends BaseModel
{

    // 系统自定义页面
    private $page = [ 'DIY_VIEW_INDEX', 'DIY_VIEW_GOODS_CATEGORY', 'DIY_STORE', 'DIY_FENXIAO_MARKET' ];

    // 图标分类，（后续可以扩展分类：建筑、家具、母婴、动物、医疗）
    private $icon_type = [
        'icon-system' => '系统', // （媒体、菜单导航、物流、办公、文件、手机）
        'icon-emoji' => '表情',
        'icon-food' => '美食', // （例如：水果，蔬菜，零食）
        'icon-clothes' => '服装', // （例如：男装，女装，鞋子，生活用品）
        'icon-beauty' => '美妆', // （例如：化妆品，护肤）
        'icon-weather' => '天气',
        'icon-edu' => '教育',
        'icon-sport' => '体育',
        'icon-tourism' => '旅游',
    ];

    // 获取系统自定义页面
    public function getPage()
    {
        return $this->page;
    }

    /**
     * 获取图标分类
     * @return array
     */
    public function getIconType()
    {
        return $this->icon_type;
    }

    /**
     * 获取自定义模板组件集合
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param string $limit
     * @return array
     */
    public function getDiyViewUtilList($condition = [], $field = 'id,name,title,type,value,addon_name,support_diy_view,max_count,is_delete,icon', $order = 'sort asc', $limit = null)
    {
        $res = model('diy_view_util')->getList($condition, $field, $order, '', '', '', $limit);
        return $this->success($res);
    }

    /**
     * 添加自定义模板
     * @param $data
     * @return array
     */
    public function addSiteDiyView($data)
    {
        // 将同类页面的默认值改为0，默认页面只有一个
        if (!empty($data[ 'is_default' ])) {
            model("site_diy_view")->update([ 'is_default' => 0 ], [ [ 'site_id', '=', $data[ 'site_id' ] ], [ 'name', '=', $data[ 'name' ] ], [ 'type', '=', $data[ 'type' ] ] ]);
        }
        $data[ 'create_time' ] = time();
        $res = model('site_diy_view')->add($data);
        if ($res) {
            Cache::tag("site_diy_view")->clear();
            return $this->success($res);
        } else {
            return $this->error($res);
        }
    }

    /**
     * 添加多条自定义模板数据
     * @param $data
     * @return array
     */
    public function addSiteDiyViewList($data)
    {
        $res = model('site_diy_view')->addList($data);
        if ($res) {
            Cache::tag("site_diy_view")->clear();
            return $this->success($res);
        } else {
            return $this->error($res);
        }
    }

    /**
     * 修改自定义模板
     * @param array $data
     * @param array $condition
     * @return array
     */
    public function editSiteDiyView($data, $condition)
    {
        // 将同类页面的默认值改为0，默认页面只有一个
        if (!empty($data[ 'is_default' ])) {
            model("site_diy_view")->update([ 'is_default' => 0 ], [ [ 'site_id', '=', $data[ 'site_id' ] ], [ 'name', '=', $data[ 'name' ] ], [ 'type', '=', $data[ 'type' ] ] ]);
        }
        $data[ 'modify_time' ] = time();
        $res = model('site_diy_view')->update($data, $condition);
        if ($res) {
            Cache::tag("site_diy_view")->clear();
            return $this->success($res);
        } else {
            return $this->error($res);
        }
    }

    /**
     * 删除站点微页面
     * @param array $condition
     * @return array
     */
    public function deleteSiteDiyView($condition = [])
    {
        $res = model('site_diy_view')->delete($condition);
        if ($res) {
            Cache::tag("site_diy_view")->clear();
            return $this->success($res);
        } else {
            return $this->error($res);
        }
    }

    /**
     * 添加自定义模板
     * @param $data
     * @return array
     */
    public function addSiteDiyViewByTemplate($data)
    {
        $diy_view_info = model('site_diy_view')->getInfo([ [ 'site_id', '=', $data[ 'site_id' ] ], [ 'name', '=', $data[ 'name' ] ] ], 'id');
        if (empty($diy_view_info)) {
            $res = model('site_diy_view')->add($data);
            if ($res) {
                Cache::tag("site_diy_view")->clear();
                return $this->success($res);
            } else {
                return $this->error($res);
            }
        } else {
            try {
                model('site_diy_view')->startTrans();
                model('site_diy_view')->update([ 'name' => 'DIY_VIEW_RANDOM_' . time(), 'create_time' => time() ], [ [ 'name', '=', 'DIY_VIEW_INDEX' ], [ 'site_id', '=', $data[ 'site_id' ] ] ]);
                model('site_diy_view')->add($data);
                Cache::tag("site_diy_view")->clear();
                model('site_diy_view')->commit();
                return $this->success();
            } catch (\Exception $e) {
                model('site_diy_view')->rollback();
                return $this->error($e->getMessage());
            }
        }
    }

    /**
     * 获取自定义模板数据集合
     * @param array $condition
     * @param string $order
     * @param string $field
     * @param string $alias
     * @param array $join
     * @return array
     */
    public function getSiteDiyViewList($condition = [], $order = '', $field = '*', $alias = '', $join = [])
    {
        $res = model('site_diy_view')->getList($condition, $field, $order, $alias, $join);
        return $this->success($res);
    }

    /**
     * 获取自定义模板分页数据集合
     * @param array $condition
     * @param int $page
     * @param int $page_size
     * @param string $order
     * @param string $field
     * @return array
     */
    public function getSiteDiyViewPageList($condition = [], $page = 1, $page_size = PAGE_LIST_ROWS, $order = '', $field = '*')
    {
        $res = model('site_diy_view')->rawPageList($condition, $field, $order, $page, $page_size);
        return $this->success($res);
    }

    /**
     * 获取自定义模板信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getSiteDiyViewInfo($condition = [], $field = 'id,site_id,name,title,value,type')
    {
        $data = json_encode($condition);
        $cache = Cache::get("site_diy_view_getSiteDiyViewInfo_" . $data);
        if (!empty($cache)) {
            return $this->success($cache);
        }

        $info = model('site_diy_view')->getInfo($condition, $field);

        Cache::tag("site_diy_view")->set("diy_view_getSiteDiyViewInfo_" . $data, $info);
        return $this->success($info);
    }

    /**
     * 获取自定义模板详细信息
     * @param array $condition
     * @return array
     */
    public function getSiteDiyViewDetail($condition = [])
    {
        $condition = array_column($condition, 2, 0);
        $site_id = $condition[ 'site_id' ];
        $data = json_encode($condition);
        $cache = Cache::get("diy_view_getSiteDiyViewDetail_" . $data);
        if (!empty($cache)) {
            return $this->success($cache);
        }
        $field = 'id,site_id,name,title,value,type,is_default';

        $info = model('site_diy_view')->getInfo($condition, $field);

        if (!empty($info) && !empty($info[ 'value' ])) {
            $json_data = json_decode($info[ 'value' ], true);
            foreach ($json_data[ 'value' ] as $k => $v) {
                if (!empty($v[ 'addon_name' ])) {
                    $is_exit = addon_is_exit($v[ 'addon_name' ], $site_id);
                    // 检查插件是否存在
                    if ($is_exit == 0) {
                        unset($json_data[ 'value' ][ $k ]);
                    }
                }
            }
            $json_data[ 'value' ] = array_values($json_data[ 'value' ]);
            $info[ 'value' ] = json_encode($json_data);
        }
        Cache::tag("site_diy_view")->set("diy_view_getSiteDiyViewDetail_" . $data, $info);
        return $this->success($info);
    }

    /**
     * 组件分类
     * @param $type
     * @return mixed
     */
    public function getTypeName($type)
    {
        $arr = [
            'SYSTEM' => '基础组件', // 排序：10000~11000
            'PROMOTION' => '营销组件', // 排序：12000~13000
        ];
        return $arr[ $type ];
    }

    /**
     * 设置平台端的底部导航配置
     * @param $data
     * @param $site_id
     * @return array
     */
    public function setBottomNavConfig($data, $site_id)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '店铺端自定义底部导航', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'DIY_VIEW_SHOP_BOTTOM_NAV_CONFIG_SHOP_' . $site_id ] ]);
        return $res;
    }

    /**
     * 获取平台端的底部导航配置
     * @param $site_id
     * @return array
     */
    public function getBottomNavConfig($site_id)
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'DIY_VIEW_SHOP_BOTTOM_NAV_CONFIG_SHOP_' . $site_id ] ]);

        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                "type" => 1,
                "theme" => "default",
                "backgroundColor" => "#FFFFFF",
                "textColor" => "#333333",
                "textHoverColor" => "#FF4D4D",
                "bulge" => true,
                "list" => [
                    [
                        "iconPath" => "icon-system-shouyeweixuanzhongbeifen",
                        "selectedIconPath" => "icon-system-shouyexuanzhongbeifen2",
                        "text" => "主页",
                        "link" => [
                            "name" => "INDEX",
                            "title" => "主页",
                            "wap_url" => "/pages/index/index",
                            "parent" => "MALL_LINK"
                        ],
                        "id" => "h1lx8nhr2lc0",
                        "imgWidth" => "40",
                        "imgHeight" => "40",
                        "iconClass" => "icon-system-home",
                        "icon_type" => "icon",
                        "selected_icon_type" => "icon",
                        "style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#000000" ],
                            "iconColorDeg" => 0
                        ],
                        "selected_style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#FF4D4D" ],
                            "iconColorDeg" => 0
                        ]
                    ],
                    [
                        "iconPath" => "icon-system-fenleiweixuanzhongbeifen2",
                        "selectedIconPath" => "icon-system-fenleixuanzhongbeifen1",
                        "text" => "商品分类",
                        "link" => [
                            "name" => "SHOP_CATEGORY",
                            "title" => "商品分类",
                            "wap_url" => "/pages/goods/category",
                            "parent" => "MALL_LINK"
                        ],
                        "imgWidth" => "40",
                        "imgHeight" => "40",
                        "id" => "1dasmaqndsyo0",
                        "iconClass" => "icon-system-category",
                        "icon_type" => "icon",
                        "selected_icon_type" => "icon",
                        "style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#000000" ],
                            "iconColorDeg" => 0
                        ],
                        "selected_style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#FF4D4D" ],
                            "iconColorDeg" => 0
                        ]
                    ],
                    [
                        "iconPath" => "icon-system-cart",
                        "selectedIconPath" => "icon-system-cart-selected",
                        "text" => "购物车",
                        "link" => [
                            "name" => "SHOPPING_TROLLEY",
                            "title" => "购物车",
                            "wap_url" => "/pages/goods/cart",
                            "parent" => "MALL_LINK"
                        ],
                        "imgWidth" => "40",
                        "imgHeight" => "40",
                        "id" => "1p1pm6ebtvs00",
                        "iconClass" => "icon-system-cart",
                        "icon_type" => "icon",
                        "selected_icon_type" => "icon",
                        "style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#000000" ],
                            "iconColorDeg" => 0
                        ],
                        "selected_style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#FF4D4D" ],
                            "iconColorDeg" => 0
                        ]
                    ],
                    [
                        "iconPath" => "icon-system-my",
                        "selectedIconPath" => "icon-system-my-selected",
                        "text" => "我的",
                        "link" => [
                            "name" => "MEMBER_CENTER",
                            "title" => "会员中心",
                            "wap_url" => "/pages/member/index",
                            "parent" => "MALL_LINK"
                        ],
                        "imgWidth" => "40",
                        "imgHeight" => "40",
                        "id" => "1b2tc256egsg0",
                        "iconClass" => "icon-system-my",
                        "icon_type" => "icon",
                        "selected_icon_type" => "icon",
                        "style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#000000" ],
                            "iconColorDeg" => 0
                        ],
                        "selected_style" => [
                            "fontSize" => 100,
                            "iconBgColor" => [],
                            "iconBgColorDeg" => 0,
                            "iconBgImg" => "",
                            "bgRadius" => 0,
                            "iconColor" => [ "#FF4D4D" ],
                            "iconColorDeg" => 0
                        ]
                    ]
                ],
                "imgType" => 2,
                "iconColor" => "#333333",
                "iconHoverColor" => "#FF4D4D"
            ];
        }

        return $res;
    }

    /**
     * 设置店铺风格配置
     * @param $data
     * @param $site_id
     * @return array
     */
    public function setStyleConfig($data, $site_id)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '店铺风格设置', '1', [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'SHOP_STYLE_CONFIG' ] ]);
        return $res;
    }

    /**
     * 获取店铺风格配置
     * @param $site_id
     * @return array
     */
    public function getStyleConfig($site_id)
    {
        $config = new ConfigModel();
        $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'SHOP_STYLE_CONFIG' ] ]);
        if (empty($res[ 'data' ][ 'value' ])) {
            $res[ 'data' ][ 'value' ] = [
                'title' => '热情红',
                'name' => 'default',
                'main_color' => '#FA0032',
                'aux_color' => '#FF8D17'
            ];
        }
        return $res;
    }

    /**
     * 推广二维码
     * @param $condition
     * @param string $type
     * @return array
     */
    public function qrcode($params)
    {
        $site_id = isset($params[ 'site_id' ]) ? $params[ 'site_id' ] : 0;
        $condition = [
            [ 'site_id', '=', $params[ 'site_id' ] ],
        ];

        if (isset($params[ 'id' ])) {
            $condition[] = [ 'id', '=', $params[ 'id' ] ];
        }
        if (isset($params[ 'name' ])) {
            $condition[] = [ 'name', '=', $params[ 'name' ] ];
        }
        if (isset($params[ 'is_default' ])) {
            $condition[] = [ 'is_default', '=', $params[ 'is_default' ] ];
        }

        $diy_view_info = $this->getSiteDiyViewInfo($condition, 'site_id,name,is_default,template_key')[ 'data' ];
        if (empty($diy_view_info)) {
            return $this->success();
        }

        $page_path = ''; // '/pages/index/index';
        if ($diy_view_info[ 'name' ] == 'DIY_VIEW_GOODS_CATEGORY') {
            $page_path = '/pages/goods/category'; // 商品分类页面特殊处理
        }
        $data = [
            'app_type' => "all", // all为全部
            'type' => isset($params[ 'type' ]) ? $params[ 'type' ] : 'create', // 类型 create创建 get获取
            'site_id' => $site_id,
            'data' => [
                "name" => $diy_view_info[ 'name' ],
                'is_default' => $diy_view_info[ 'is_default' ]
            ],
            'page' => $page_path,
            'qrcode_path' => 'upload/qrcode/diy',
            'qrcode_name' => "diy_qrcode_" . $diy_view_info[ 'name' ] . '_' . $diy_view_info[ 'template_key' ] . '_' . $site_id,
        ];

        if (!empty($params[ 'store_id' ])) {
            $data[ 'data' ][ 'store_id' ] = $params[ 'store_id' ];
        }

        event('Qrcode', $data, true);
        $app_type_list = config('app_type');

        $path = [];
        $config = new ConfigModel();

        foreach ($app_type_list as $k => $v) {
            switch ( $k ) {
                case 'h5':
                    $h5_domain = getH5Domain();
                    $path[ $k ][ 'status' ] = 1;
                    if (!empty($params[ 'is_default' ]) && $diy_view_info[ 'name' ] == 'DIY_VIEW_INDEX') {
                        // 判断是否为首页
                        $path[ $k ][ 'url' ] = $h5_domain;
                    } elseif ($diy_view_info[ 'name' ] == 'DIY_VIEW_GOODS_CATEGORY') {
                        $path[ $k ][ 'url' ] = $h5_domain . $page_path;
                    } else {
                        $path[ $k ][ 'url' ] = $h5_domain . '?name=' . $diy_view_info[ 'name' ] . '&is_default=' . $diy_view_info[ 'is_default' ];
                    }

                    if (!empty($params[ 'store_id' ])) {
                        $path[ $k ][ 'url' ] .= '&store_id=' . $params[ 'store_id' ];
                    }
                    $path[ $k ][ 'img' ] = "upload/qrcode/diy/diy_qrcode_" . $diy_view_info[ 'name' ] . '_' . $diy_view_info[ 'template_key' ] . '_' . $site_id . "_" . $k . ".png?" . time();
                    break;
                case 'weapp':
                    $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'WEAPP_CONFIG' ] ]);
                    if (!empty($res[ 'data' ])) {
                        if (empty($res[ 'data' ][ 'value' ][ 'qrcode' ])) {
                            $path[ $k ][ 'status' ] = 2;
                            $path[ $k ][ 'message' ] = '未配置微信小程序';
                        } else {
                            $path[ $k ][ 'status' ] = 1;
                            $path[ $k ][ 'img' ] = $res[ 'data' ][ 'value' ][ 'qrcode' ];
                        }

                    } else {
                        $path[ $k ][ 'status' ] = 2;
                        $path[ $k ][ 'message' ] = '未配置微信小程序';
                    }
                    break;

                case 'wechat':
                    $res = $config->getConfig([ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'WECHAT_CONFIG' ] ]);
                    if (!empty($res[ 'data' ])) {
                        if (empty($res[ 'data' ][ 'value' ][ 'qrcode' ])) {
                            $path[ $k ][ 'status' ] = 2;
                            $path[ $k ][ 'message' ] = '未配置微信公众号';
                        } else {
                            $path[ $k ][ 'status' ] = 1;
                            $path[ $k ][ 'img' ] = $res[ 'data' ][ 'value' ][ 'qrcode' ];
                        }
                    } else {
                        $path[ $k ][ 'status' ] = 2;
                        $path[ $k ][ 'message' ] = '未配置微信公众号';
                    }
                    break;
            }

        }

        $return = [
            'path' => $path
        ];

        return $this->success($return);
    }

    /**
     * 获取列表
     */
    public function getTemplate()
    {
        $dirs = array_map('basename', glob('public/diy_view/*', GLOB_ONLYDIR));
        $list = [];
        foreach ($dirs as $key => $value) {
            $config_json = file_get_contents('public/diy_view/' . $value . '/config.json');
            $list[] = json_decode($config_json, true);

        }
        return $this->success($list);
    }

    /**
     * 设置为系统页面
     * @param $port
     * @param $type
     * @param $id
     * @param $site_id
     * @return array
     */
    public function setHome($id, $site_id)
    {
        model('site_diy_view')->startTrans();
        try {
            $name = 'DIY_VIEW_INDEX';
            model('site_diy_view')->update([ 'is_default' => 0 ], [ [ 'name', '=', $name ], [ 'site_id', '=', $site_id ] ]);
            model('site_diy_view')->update([ 'name' => $name, 'is_default' => 1 ], [ [ 'id', '=', $id ], [ 'site_id', '=', $site_id ] ]);
            Cache::tag("site_diy_view")->clear();
            model('site_diy_view')->commit();
            return $this->success();
        } catch (\Exception $e) {
            model('site_diy_view')->rollback();
            return $this->error($e->getMessage());
        }
    }

    public function getMemberIndexDiyConfig($site_id)
    {
        $res = ( new ConfigModel() )->getConfig([
            [ 'site_id', '=', $site_id ],
            [ 'app_module', '=', 'shop' ],
            [ 'config_key', '=', 'DIY_MEMBER_INDEX_CONFIG_SHOP_' . $site_id ]
        ]);
        if (!empty($res[ 'data' ][ 'value' ])) {
            $custom = array_column($res[ 'data' ][ 'value' ][ 'menu' ][ 'menus' ], null, 'tag');
            $res[ 'data' ][ 'value' ][ 'menu' ][ 'menus' ] = $this->getMemberMemus($site_id, $custom);
        } else {
            $res[ 'data' ][ 'value' ] = [
                'member_info' => [
                    'style' => 2,
                    'margin' => '15px',
                    'background_type' => 'system',
                    'background' => [ '129deg', '#FF7130', '#FF1542' ]
                ],
                'order' => [
                    'margin' => [ '15px', '15px', '0px', '15px' ],
                    'radius' => [ '9px', '9px' ],
                    'icon_style' => 0,
                    'icon' => [
                        'waitPay' => [
                            'title' => '待付款',
                            'icon' => 'icon-system-daifukuan2',
                            'style' => [
                                'bgRadius' => 0,
                                'fontSize' => 65,
                                'iconBgColor' => [],
                                'iconBgColorDeg' => 0,
                                'iconBgImg' => "",
                                'iconColor' => [ "#FF7B1D", "#FF1544" ],
                                'iconColorDeg' => 111,
                            ]
                        ],
                        'waitSend' => [
                            'title' => '待发货',
                            'icon' => 'icon-system-daifahuo2',
                            'style' => [
                                'bgRadius' => 0,
                                'fontSize' => 65,
                                'iconBgColor' => [],
                                'iconBgColorDeg' => 0,
                                'iconBgImg' => "",
                                'iconColor' => [ "#FF7B1D", "#FF1544" ],
                                'iconColorDeg' => 111,
                            ]
                        ],
                        'waitConfirm' => [
                            'title' => '待收货',
                            'icon' => 'icon-system-daishouhuo2',
                            'style' => [
                                'bgRadius' => 0,
                                'fontSize' => 65,
                                'iconBgColor' => [],
                                'iconBgColorDeg' => 0,
                                'iconBgImg' => "",
                                'iconColor' => [ "#FF7B1D", "#FF1544" ],
                                'iconColorDeg' => 111,
                            ]
                        ],
                        'waitRate' => [
                            'title' => '待评价',
                            'icon' => 'icon-system-daipingjie2',
                            'style' => [
                                'bgRadius' => 0,
                                'fontSize' => 65,
                                'iconBgColor' => [],
                                'iconBgColorDeg' => 0,
                                'iconBgImg' => "",
                                'iconColor' => [ "#FF7B1D", "#FF1544" ],
                                'iconColorDeg' => 111,
                            ]
                        ],
                        'refunding' => [
                            'title' => '售后',
                            'icon' => 'icon-system-shuhou2',
                            'style' => [
                                'bgRadius' => 0,
                                'fontSize' => 65,
                                'iconBgColor' => [],
                                'iconBgColorDeg' => 0,
                                'iconBgImg' => "",
                                'iconColor' => [ "#FF7B1D", "#FF1544" ],
                                'iconColorDeg' => 111,
                            ]
                        ]
                    ],
                ],
                'menu' => [
                    'style' => 'block',
                    'margin' => [ '15px', '15px', '15px', '15px' ],
                    'radius' => [ '9px', '9px' ],
                    'menus' => $this->getMemberMemus($site_id)
                ],
                'adv' => [
                    'margin' => [ '15px', '15px', '0px', '15px' ],
                    'radius' => [ '9px', '9px' ],
                    'list' => []
                ]
            ];
        }
        return $res;
    }

    /**
     * 获取菜单
     * @param $site_id
     * @return array
     */
    public function getMemberMemus($site_id, $custom = [])
    {
        $menus = [
            "userinfo" => [
                "tag" => "userinfo",
                "text" => "个人资料",
                "img" => "public/uniapp/member/index/menu/default_person.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "MEMBER_INFO",
                    "title" => "个人资料",
                    "wap_url" => "/pages_tool/member/info",
                    "parent" => "MALL_LINK"
                ],
                "icon" => "icon-system-idcard",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#44D7B7"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "address" => [
                "tag" => "address",
                "text" => "收货地址",
                "img" => "public/uniapp/member/index/menu/default_address.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "SHIPPING_ADDRESS",
                    "title" => "收货地址",
                    "wap_url" => "/pages_tool/member/address",
                    "parent" => "MALL_LINK"
                ],
                "icon" => "icon-system-delivery-address",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#fa6400"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "follow" => [
                "tag" => "follow",
                "text" => "我的关注",
                "img" => "public/uniapp/member/index/menu/default_like.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "ATTENTION",
                    "title" => "我的关注",
                    "wap_url" => "/pages_tool/member/collection",
                    "parent" => "MALL_LINK"
                ],
                "icon" => "icon-system-my-focus",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#6236ff"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "footprint" => [
                "tag" => "footprint",
                "text" => "我的足迹",
                "img" => "public/uniapp/member/index/menu/default_toot.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "FOOTPRINT",
                    "title" => "我的足迹",
                    "wap_url" => "/pages_tool/member/footprint",
                    "parent" => "MALL_LINK"
                ],
                "icon" => "icon-system-my-footprint",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#ff4d4d"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "memberwithdraw" => [
                "tag" => "memberwithdraw",
                "text" => "账户列表",
                "img" => "public/uniapp/member/index/menu/default_cash.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "ACCOUNT",
                    "title" => "账户列表",
                    "wap_url" => "/pages_tool/member/account",
                    "parent" => "MALL_LINK"
                ],
                "icon" => "icon-system-account-list",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#2e88fd"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "coupon" => [
                "tag" => "coupon",
                "text" => "优惠券",
                "img" => "public/uniapp/member/index/menu/default_discount.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "COUPON",
                    "title" => "优惠券",
                    "wap_url" => "/pages_tool/member/coupon",
                    "parent" => "MALL_LINK"
                ],
                "icon" => "icon-system-coupon",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#44D7B7"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "membersignin" => [
                "tag" => "membersignin",
                "text" => "签到",
                "img" => "public/uniapp/member/index/menu/default_sign.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "SIGN_IN",
                    "title" => "签到",
                    "wap_url" => "/pages_tool/member/signin",
                    "parent" => "MARKETING_LINK"
                ],
                "icon" => "icon-system-signin",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#ff4d4d"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1"
            ],
            "verifier" => [
                "tag" => "verifier",
                "text" => "核销台",
                "img" => "public/uniapp/member/index/menu/default_verification.png",
                "icon_type" => "icon",
                "link" => [
                    "name" => "VERIFICATION_PLATFORM",
                    "title" => "核销台",
                    "wap_url" => "/pages_tool/verification/index",
                    "parent" => "MARKETING_LINK"
                ],
                "icon" => "icon-system-check-station",
                "style" => [
                    "fontSize" => 50,
                    "iconBgColor" => [
                        "#23b5ee"
                    ],
                    "iconBgColorDeg" => 0,
                    "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                    "bgRadius" => 38,
                    "iconColor" => [
                        "#FFFFFF"
                    ],
                    "iconColorDeg" => 0
                ],
                "isShow" => "1",
                "isSystem" => "1",
                "remark" => "成为核销员时显示"
            ]
        ];
        // 判断与系统内置的菜单 差异部分
        if (!empty($custom)) {
            $diff = array_diff(array_keys($menus), array_keys($custom));
            if (!empty($diff)) {
                foreach ($diff as $key) {
                    $custom[ $key ] = $menus[ $key ];
                }
            }
            $menus = $custom;
        }
        $addons = model('addon')->getColumn([ [ 'status', '=', 1 ] ], 'name');
        foreach ($menus as $addon => $item) {
            if (in_array($addon, $addons)) $menus[ $addon ][ 'isShow' ] = $item[ 'isShow' ] && addon_is_exit($addon, $site_id) ? 1 : 0;
        }
        return array_values($menus);
    }

    /**
     * 设置自定义会员中心配置
     * @param $data
     * @param $site_id
     * @return array
     */
    public function setMemberIndexDiyConfig($data, $site_id)
    {
        $config = new ConfigModel();
        $res = $config->setConfig($data, '自定义会员中心', 1, [ [ 'site_id', '=', $site_id ], [ 'app_module', '=', 'shop' ], [ 'config_key', '=', 'DIY_MEMBER_INDEX_CONFIG_SHOP_' . $site_id ] ]);
        return $res;
    }

    /**
     * 修改微页面排序
     * @param $sort
     * @param $id
     * @return array
     */
    public function modifyDiyViewSort($sort, $id)
    {
        $res = model('site_diy_view')->update([ 'sort' => $sort ], [ [ 'id', '=', $id ] ]);
        Cache::tag("site_diy_view")->clear();
        return $this->success($res);
    }

    /**
     * 修改微页面点击量
     * @param $condition
     * @return array
     */
    public function modifyClick($condition)
    {
        model("site_diy_view")->setInc($condition, 'click_num', 1);
        return $this->success(1);
    }

    /**
     * 查询自定义模板列表
     * @param $params
     * @return array
     */
    public function getDiyTemplate($params)
    {
        $data = [
            'site_id' => $params[ 'site_id' ],
            'name' => $params[ 'name' ] ?? ''
        ];
        $template = event('showDiyTemplate', $data);
        // 如果只查询一项，则返回一个
        if (!empty($data[ 'name' ]) && !empty($template)) {
            $template = $template[ 0 ];
        }
        return $this->success($template);
    }

    /**
     * 添加模板页面
     * @param $params
     * @return array
     */
    public function addTemplatePage($params)
    {
        try {

            model('site_diy_view')->startTrans();

            if (!empty($params[ 'page' ])) {
                foreach ($params[ 'page' ] as $k => $v) {
                    $v[ 'site_id' ] = $params[ 'site_id' ];
                    $v[ 'template_key' ] = $params[ 'name' ];
                    $v[ 'is_default' ] = 1;
                    $v[ 'value' ] = json_encode($v[ 'value' ]);

                    // 检测模板页面是否存在，有则改，无则加
                    $site_diy_view_info = $this->getSiteDiyViewInfo([
                        [ 'name', '=', $v[ 'name' ] ],
                        [ 'site_id', '=', $v[ 'site_id' ] ],
                        [ 'template_key', '=', $v[ 'template_key' ] ],
                        [ 'type', '=', $v[ 'type' ] ]
                    ], 'id')[ 'data' ];

                    // 清除默认页面
                    $this->editSiteDiyView([ 'is_default' => 0 ], [
                        [ 'site_id', '=', $params[ 'site_id' ] ],
                        [ 'name', '=', $v[ 'name' ] ],
                        [ 'type', '=', $v[ 'type' ] ]
                    ]);

                    if (!empty($site_diy_view_info)) {
                        // 修改相同页面的默认标识
                        $v[ 'modify_time' ] = time();
                        $this->editSiteDiyView($v, [ [ 'id', '=', $site_diy_view_info[ 'id' ] ] ]);
                    } else {
                        $v[ 'create_time' ] = time();
                        $this->addSiteDiyView($v);
                    }

                }
            }
            model('site_diy_view')->commit();
            Cache::tag("site_diy_view")->clear();
            return $this->success();
        } catch (\Exception $e) {
            model('site_diy_view')->rollback();
            return $this->error('', $e->getMessage());
        }
    }

    /**
     * 图标风格
     * @return array
     */
    public function iconStyle()
    {
        return [
//            [
//                "fontSize" => 50,
//                "iconBgColor" => [
//                    "#7b00ff"
//                ],
//                "iconBgColorDeg" => 0,
//                "iconBgImg" => "",
//                "bgRadius" => 19,
//                "iconColor" => [
//                    "#fff"
//                ],
//                "iconColorDeg" => 0
//            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#0068ff"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "",
                "bgRadius" => 38,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#ff1c1c"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "",
                "bgRadius" => 50,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#fa6400"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_01.png",
                "bgRadius" => 19,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#b620e0"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_02.png",
                "bgRadius" => 19,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#ff3c5a"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_03.png",
                "bgRadius" => 19,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#ff9200"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_04.png",
                "bgRadius" => 19,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#44d7b6"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_05.png",
                "bgRadius" => 38,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 50,
                "iconBgColor" => [
                    "#ff5615"
                ],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "public/static/ext/diyview/img/icon_bg/bg_06.png",
                "bgRadius" => 50,
                "iconColor" => [
                    "#fff"
                ],
                "iconColorDeg" => 0
            ],
            [
                "fontSize" => 100,
                "iconBgColor" => [],
                "iconBgColorDeg" => 0,
                "iconBgImg" => "",
                "bgRadius" => 0,
                "iconColor" => [
                    "#be71ff",
                    "#8e00ff"
                ],
                "iconColorDeg" => 125
            ]
        ];
    }
}