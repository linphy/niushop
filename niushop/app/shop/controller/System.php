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

use addon\diy_default1\event\UseTemplate;
use app\model\system\Addon;
use app\model\system\Database;
use app\model\system\Menu;
use app\model\web\Config as ConfigModel;
use app\model\web\DiyView as DiyViewModel;
use extend\database\Database as dbdatabase;
use think\facade\Cache;


class System extends BaseShop
{
    /*********************************************************系统缓存与数据库管理***************************************************/
    /**
     * 缓存设置
     */
    public function cache()
    {
        if (request()->isAjax()) {
            $type = input("key", '');
            $type_list = explode(',', $type);
            $msg = '';
            foreach ($type_list as $k => $v) {
                switch ( $v ) {
                    case 'content':
                        Cache::clear();
                        $msg = '数据缓存清除成功';
                        break;
                    case 'data_table_cache':
                        // 数据表缓存清除
                        if (is_dir('runtime/schema')) {
                            rmdirs("schema");
                        }
                        $msg = '数据表缓存清除成功';
                        break;
                    case 'template_cache':
                        // 模板缓存清除
                        if (is_dir('runtime/temp')) {
                            rmdirs("temp");
                        }
                        $msg = '模板缓存清除成功';
                        break;
                    case 'addon_cache':
                        //刷新插件info
                        $addon_model = new Addon();
                        $addon_model->cacheAddon();
                        $msg = '刷新插件成功';
                        break;
                    case 'addon_menu_cache':
                        //刷新插件菜单
                        $addon_model = new Addon();
                        $addon_model->cacheAddonMenu();
                        $msg = '刷新插件菜单成功';
                        break;
                    case 'shop_menu_cache':
                        //刷新店铺端菜单
                        $menu = new Menu();
                        $menu->refreshMenu('shop', '');
                        $msg = '刷新店铺端菜单成功';
                        break;
                    case 'diy_view':
                        $this->refreshDiy();
                        $msg = '刷新自定义模板成功';
                        break;
                    case 'handle_version_data_temp':
                        $msg = $this->handleVersionDataTemp();// 处理升级版本数据遇到的数据问题（临时）
                        $this->refreshDiy();
                        Cache::clear();
                        break;
                    case 'all':
                        // 清除缓存
                        $msg = '一键刷新成功';
                        break;
                }
            }
            return success(0, $msg, '');
        } else {
            $config_model = new ConfigModel();
            $cache_list = $config_model->getCacheList();

            $this->assign("cache_list", $cache_list);
            return $this->fetch('system/cache');
        }
    }


    public function cach1e()
    {
        if (request()->isAjax()) {
            $type = input("key", '');
            $type_list = explode(',', $type);
            $msg = '';
            foreach ($type_list as $k => $v) {
                switch ( $v ) {
                    case 'all':
                        $msg = '一键刷新成功';
                        break;
                }
            }

            return success(0, $msg, '');
        } else {
            $config_model = new ConfigModel();
            $cache_list = $config_model->getCacheList();
            $this->assign("cache_list", $cache_list);
            return $this->fetch('system/cache');
        }
    }

    /**
     * 插件管理
     */
    public function addon()
    {
        $addon = new Addon();
        if (request()->isAjax()) {
            $addon_name = input("addon_name");
            $tag = input("tag", "install");
            if ($tag == 'install') {
                $res = $addon->install($addon_name);
                return $res;
            } else {
                $res = $addon->uninstall($addon_name);
                return $res;
            }
        }
        $addon = $addon->getAddonAllList();

        $this->assign("addons", $addon[ 'data' ][ 'install' ]);
        $this->assign("uninstall", $addon[ 'data' ][ 'uninstall' ]);
        return $this->fetch('system/addon');
    }

    /**
     * 数据库管理
     */
    public function database()
    {
        $database = new Database();
        $table = $database->getDatabaseList();
        $this->assign('list', $table);
        $this->forthMenu();
        return $this->fetch('system/database');
    }

    /**
     * 数据库还原页面展示
     */
    public function importlist()
    {
        $database = new Database();

        $path = $database->backup_path;
        if (!is_dir($path)) {
            $mode = intval('0777', 8);
            mkdir($path, $mode, true);
        }

        $flag = \FilesystemIterator::KEY_AS_FILENAME;
        $glob = new \FilesystemIterator($path, $flag);
        $list = array ();

        foreach ($glob as $name => $file) {

            if (preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)) {

                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[ 6 ];

                if (isset($list[ "{$date} {$time}" ])) {
                    $info = $list[ "{$date} {$time}" ];
                    $info[ 'part' ] = max($info[ 'part' ], $part);
                    $info[ 'size' ] = $info[ 'size' ] + $file->getSize();
                    $info[ 'size' ] = $database->format_bytes($info[ 'size' ]);
                } else {
                    $info[ 'part' ] = $part;
                    $info[ 'size' ] = $file->getSize();
                    $info[ 'size' ] = $database->format_bytes($info[ 'size' ]);
                }

                $info[ 'name' ] = date('Ymd-His', strtotime("{$date} {$time}"));;
                $extension = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info[ 'compress' ] = ( $extension === 'SQL' ) ? '-' : $extension;
                $info[ 'time' ] = strtotime("{$date} {$time}");

                $list[] = $info;
            }
        }

        if (!empty($list)) {
            $list = $database->my_array_multisort($list, "time");
        }
        $this->assign('list', $list);
        $this->forthMenu();
        return $this->fetch('system/importlist');

    }

    /**
     * 还原数据库
     */
    public function importData()
    {

        $time = request()->post('time', '');
        $part = request()->post('part', 0);
        $start = request()->post('start', 0);

        $database = new Database();
        if (is_numeric($time) && ( is_null($part) || empty($part) ) && ( is_null($start) || empty($start) )) { // 初始化
            // 获取备份文件信息
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = realpath($database->backup_path) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list = array ();
            foreach ($files as $name) {
                $basename = basename($name);
                $match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[ $match[ 6 ] ] = array (
                    $match[ 6 ],
                    $name,
                    $gz
                );
            }
            ksort($list);
            // 检测文件正确性
            $last = end($list);
            if (count($list) === $last[ 0 ]) {
                session('backup_list', $list); // 缓存备份列表
                $return_data = [
                    'code' => 1,
                    'message' => '初始化完成',
                    'data' => [ 'part' => 1, 'start' => 0 ]
                ];
                return $return_data;
            } else {
                $return_data = [
                    'code' => -1,
                    'message' => '备份文件可能已经损坏，请检查！',
                ];
                return $return_data;
            }
        } elseif (is_numeric($part) && is_numeric($start)) {
            $list = session('backup_list');
            $db = new dbdatabase($list[ $part ], array (
                'path' => realpath($database->backup_path) . DIRECTORY_SEPARATOR,
                'compress' => $list[ $part ][ 2 ]
            ));

            $start = $db->import($start);
            if ($start === false) {
                $return_data = [
                    'code' => -1,
                    'message' => '还原数据出错！',
                ];
                return $return_data;
            } elseif ($start === 0) { // 下一卷
                if (isset($list[ ++$part ])) {
                    $data = array (
                        'part' => $part,
                        'start' => 0
                    );
                    $return_data = [
                        'code' => -1,
                        'message' => "正在还原...#{$part}",
                        'data' => $data
                    ];
                    return $return_data;
                } else {
                    session('backup_list', null);
                    $return_data = [
                        'code' => -1,
                        'message' => "还原完成！",
                    ];
                    return $return_data;
                }
            } else {
                $data = array (
                    'part' => $part,
                    'start' => $start[ 0 ]
                );
                if ($start[ 1 ]) {
                    $rate = floor(100 * ( $start[ 0 ] / $start[ 1 ] ));

                    $return_data = [
                        'code' => 1,
                        'message' => "正在还原...#{$part} ({$rate}%)",
                    ];
                    return $return_data;
                } else {
                    $data[ 'gz' ] = 1;
                    $return_data = [
                        'code' => 1,
                        'message' => "正在还原...#{$part}",
                        'data' => $data
                    ];
                    return $return_data;
                }
            }
        } else {
            $return_data = [
                'code' => -1,
                'message' => "参数有误",
            ];
            return $return_data;
        }
    }

    /**
     * 数据表修复
     */
    public function tablerepair()
    {
        if (request()->isAjax()) {
            $table_str = input('tables', '');
            $database = new Database();
            $res = $database->repair($table_str);
            return $res;
        }
    }


    /**
     * 数据表备份
     */
    public function backup()
    {
        $database = new Database();
        $tables = input('tables', []);
        $id = input('id', '');
        $start = input('start', '');

        if (!empty($tables) && is_array($tables)) { // 初始化
            // 读取备份配置
            $config = array (
                'path' => $database->backup_path . DIRECTORY_SEPARATOR,
                'part' => 20971520,
                'compress' => 1,
                'level' => 9
            );
            // 检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if (is_file($lock)) {
                return error(-1, '检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                $mode = intval('0777', 8);
                if (!file_exists($config[ 'path' ]) || !is_dir($config[ 'path' ]))
                    mkdir($config[ 'path' ], $mode, true); // 创建锁文件

                file_put_contents($lock, date('Ymd-His', time()));
            }
            // 自动创建备份文件夹
            // 检查备份目录是否可写
            is_writeable($config[ 'path' ]) || exit('backup_not_exist_success');
            session('backup_config', $config);
            // 生成备份文件信息
            $file = array (
                'name' => date('Ymd-His', time()),
                'part' => 1
            );

            session('backup_file', $file);

            // 缓存要备份的表
            session('backup_tables', $tables);

            $dbdatabase = new dbdatabase($file, $config);
            if (false !== $dbdatabase->create()) {

                $data = array ();
                $data[ 'status' ] = 1;
                $data[ 'message' ] = '初始化成功';
                $data[ 'tables' ] = $tables;
                $data[ 'tab' ] = array (
                    'id' => 0,
                    'start' => 0
                );
                return $data;
            } else {
                return error(-1, '初始化失败，备份文件创建失败！');
            }
        } elseif (is_numeric($id) && is_numeric($start)) { // 备份数据
            $tables = session('backup_tables');
            // 备份指定表
            $dbdatabase = new dbdatabase(session('backup_file'), session('backup_config'));
            $start = $dbdatabase->backup($tables[ $id ], $start);
            if (false === $start) { // 出错
                return error(-1, '备份出错！');
            } elseif (0 === $start) { // 下一表
                if (isset($tables[ ++$id ])) {
                    $tab = array (
                        'id' => $id,
                        'table' => $tables[ $id ],
                        'start' => 0
                    );
                    $data = array ();
                    $data[ 'rate' ] = 100;
                    $data[ 'status' ] = 1;
                    $data[ 'message' ] = '备份完成！';
                    $data[ 'tab' ] = $tab;
                    return $data;
                } else { // 备份完成，清空缓存
                    unlink($database->backup_path . DIRECTORY_SEPARATOR . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    return success(1);
                }
            } else {
                $tab = array (
                    'id' => $id,
                    'table' => $tables[ $id ],
                    'start' => $start[ 0 ]
                );
                $rate = floor(100 * ( $start[ 0 ] / $start[ 1 ] ));
                $data = array ();
                $data[ 'status' ] = 1;
                $data[ 'rate' ] = $rate;
                $data[ 'message' ] = "正在备份...({$rate}%)";
                $data[ 'tab' ] = $tab;
                return $data;
            }
        } else { // 出错
            return error(-1, '参数有误!');
        }
    }

    /**
     * 删除备份文件
     */
    public function deleteData()
    {
        $name_time = input('time', '');
        if ($name_time) {
            $database = new Database();
            $name = date('Ymd-His', $name_time) . '-*.sql*';
            $path = realpath($database->backup_path) . DIRECTORY_SEPARATOR . $name;
            array_map("unlink", glob($path));
            if (count(glob($path))) {
                return error(-1, "备份文件删除失败，请检查权限！");
            } else {
                return success(1, "备份文件删除成功！");
            }
        } else {
            return error(-1, "参数有误！");
        }
    }

    /**
     * 刷新菜单 测试
     */
    public function refresh()
    {
        $menu = new Menu();
        $res = $menu->refreshAllMenu();
        var_dump($res);
    }

    /**
     * 刷新自定义组件
     */
    public function refreshDiy()
    {
        $addon = new Addon();
        $addon_list = $addon->getAddonList([], 'name')[ 'data' ];
        $addon->refreshDiyView('');
        foreach ($addon_list as $k => $v) {
            $res = $addon->refreshDiyView($v[ 'name' ]);
        }
    }

    /**
     * 处理升级版本数据遇到的数据问题（临时）
     */
    public function handleVersionDataTemp()
    {
        $msg = '处理成功';
        try {

            model('goods_service')->startTrans();

            // 处理商品服务图标问题
            $goods_service_list = model('goods_service')->getList([ [ 'icon', '<>', '' ] ], 'id,icon');
            if (!empty($goods_service_list)) {
                foreach ($goods_service_list as $k => $v) {
                    $v[ 'icon' ] = json_decode($v[ 'icon' ], true);
                    $icon = $v[ 'icon' ][ 'icon' ];
                    if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                        $v[ 'icon' ][ 'icon' ] = 'icondiy ' . $icon;
                        model('goods_service')->update([ 'icon' => json_encode($v[ 'icon' ]) ], [ [ 'id', '=', $v[ 'id' ] ] ]);
                    }
                }
            }

            // 处理底部导航图标问题
            $bottom_nav_config = model('config')->getInfo([ [ 'config_key', 'like', '%DIY_VIEW_SHOP_BOTTOM_NAV_CONFIG_SHOP_%' ] ], 'id,value');
            if (!empty($bottom_nav_config) && !empty($bottom_nav_config[ 'value' ])) {
                $value = json_decode($bottom_nav_config[ 'value' ], true);
                if (!empty($value[ 'list' ])) {
                    foreach ($value[ 'list' ] as $k => $v) {

                        $iconPath = $v[ 'iconPath' ];
                        if (!empty($iconPath) && strpos($iconPath, 'icondiy') === false) {
                            $value[ 'list' ][ $k ][ 'iconPath' ] = 'icondiy ' . $iconPath;
                        }

                        $selectedIconPath = $v[ 'selectedIconPath' ];
                        if (!empty($selectedIconPath) && strpos($selectedIconPath, 'icondiy') === false) {
                            $value[ 'list' ][ $k ][ 'selectedIconPath' ] = 'icondiy ' . $selectedIconPath;
                        }

                    }
                    model('config')->update([ 'value' => json_encode($value) ], [ [ 'id', '=', $bottom_nav_config[ 'id' ] ] ]);
                }

            }

            // 处理会员中心
            model('config')->delete([ [ 'config_key', 'like', '%DIY_MEMBER_INDEX_CONFIG_SHOP_%' ] ]);

            $diy_view = new DiyViewModel();

            $diy_view->deleteSiteDiyView([ [ 'name', '=', 'DIY_VIEW_MEMBER_INDEX' ] ]);

            $diy_default_template = new UseTemplate();
            $member_index_page = $diy_default_template->getMemberIndexPage();
            $member_index_page[ 'site_id' ] = $this->site_id;
            $member_index_page[ 'is_default' ] = 1;
            $member_index_page[ 'value' ] = json_encode($member_index_page[ 'value' ]);

            // 添加自定义会员中心页面
            $diy_view->addSiteDiyView($member_index_page);

            // 处理微页面数据、图标显示问题
            $page = model('site_diy_view')->getList([], 'id,value');
            foreach ($page as $k => $v) {
                if (!empty($v[ 'value' ])) {
                    $value = json_decode($v[ 'value' ], true);

                    // 导航栏显示隐藏开关，默认开启
                    if (!isset($value[ 'global' ][ 'navBarSwitch' ])) {
                        $value[ 'global' ][ 'navBarSwitch' ] = true;
                    }
                    foreach ($value[ 'value' ] as $ck => $cv) {

                        // 旧数据结构
                        if (!empty($cv[ 'controller' ])) {

                            if ($cv[ 'controller' ] == 'ImageAds') {
                                $value[ 'value' ][ $ck ][ 'componentName' ] = $cv[ 'controller' ];
                                $value[ 'value' ][ $ck ][ 'componentTitle' ] = $cv[ 'name' ];
                                $value[ 'value' ][ $ck ][ 'indicatorColor' ] = '#ffffff';
                                $value[ 'value' ][ $ck ][ 'carouselStyle' ] = 'circle';
                                $value[ 'value' ][ $ck ][ 'isDelete' ] = 0;
                                $value[ 'value' ][ $ck ][ 'pageBgColor' ] = '';
                                $value[ 'value' ][ $ck ][ 'componentBgColor' ] = '';
                                $value[ 'value' ][ $ck ][ 'componentAngle' ] = 'round';
                                $value[ 'value' ][ $ck ][ 'topAroundRadius' ] = 0;
                                $value[ 'value' ][ $ck ][ 'bottomAroundRadius' ] = 0;
                                $value[ 'value' ][ $ck ][ 'topElementAroundRadius' ] = 0;
                                $value[ 'value' ][ $ck ][ 'bottomElementAroundRadius' ] = 0;
                                $value[ 'value' ][ $ck ][ 'margin' ] = [
                                    "top" => 0,
                                    "bottom" => 0,
                                    "both" => 0
                                ];

                            }
                        }

                        if ($cv[ 'componentName' ] == 'Text') {
                            // 标题组件
                            if ($cv[ 'style' ] == 'style-16') {
                                $icon = $cv[ 'subTitle' ][ 'icon' ];
                                if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                                    $value[ 'value' ][ $ck ][ 'subTitle' ][ 'icon' ] = 'icondiy ' . $icon;
                                }
                            }
                        } elseif ($cv[ 'componentName' ] == 'Notice') {
                            // 公告组件
                            if (!isset($cv[ 'scrollWay' ])) {
                                $cv[ 'scrollWay' ] = 'horizontal'; // 滚动方式
                            }
                            if (!empty($cv[ 'iconType' ]) && $cv[ 'iconType' ] == 'icon') {
                                $icon = $cv[ 'icon' ];
                                if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                                    $value[ 'value' ][ $ck ][ 'icon' ] = 'icondiy ' . $icon;
                                }
                            }
                        } elseif ($cv[ 'componentName' ] == 'GraphicNav') {
                            // 图文导航组件
                            foreach ($cv[ 'list' ] as $gn_k => $gn_v) {
                                if (!empty($gn_v[ 'iconType' ]) && $gn_v[ 'iconType' ] == 'icon' && !empty($gn_v[ 'icon' ])) {
                                    $icon = $gn_v[ 'icon' ];
                                    if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                                        $value[ 'value' ][ $ck ][ 'list' ][ $gn_k ][ 'icon' ] = 'icondiy ' . $icon;
                                    }
                                }
                            }
                        } elseif ($cv[ 'componentName' ] == 'Search') {
                            // 搜索框组件
                            if (!empty($cv[ 'iconType' ]) && $cv[ 'iconType' ] == 'icon') {
                                $icon = $cv[ 'icon' ];
                                if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                                    $value[ 'value' ][ $ck ][ 'icon' ] = 'icondiy ' . $icon;
                                }
                            }
                        } elseif ($cv[ 'componentName' ] == 'GoodsList') {
                            // 商品列表组件
                            if ($cv[ 'btnStyle' ][ 'style' ] == 'icon-diy') {
                                $icon = $cv[ 'btnStyle' ][ 'iconDiy' ][ 'icon' ];
                                if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                                    $value[ 'value' ][ $ck ][ 'btnStyle' ] [ 'iconDiy' ][ 'icon' ] = 'icondiy ' . $icon;
                                }
                            }
                        } elseif ($cv[ 'componentName' ] == 'ManyGoodsList') {
                            // 多商品组组件
                            if ($cv[ 'btnStyle' ][ 'style' ] == 'icon-diy') {
                                $icon = $cv[ 'btnStyle' ][ 'iconDiy' ][ 'icon' ];
                                if (!empty($icon) && strpos($icon, 'icondiy') === false) {
                                    $value[ 'value' ][ $ck ][ 'btnStyle' ] [ 'iconDiy' ][ 'icon' ] = 'icondiy ' . $icon;
                                }
                            }
                        } elseif ($cv[ 'componentName' ] == 'GoodsRecommend') {
                            // 商品推荐组件
                            $icon = $cv[ 'topStyle' ][ 'icon' ][ 'value' ];
                            if (!empty($icon) && strpos($icon, 'icondiy') == false) {
                                $value[ 'value' ][ $ck ][ 'topStyle' ] [ 'icon' ][ 'value' ] = 'icondiy ' . $icon;
                            }
                        } elseif ($cv[ 'componentName' ] == 'Seckill') {
                            // 秒杀组件
                            if ($cv[ 'titleStyle' ][ 'style' ] == 'style-2') {
                                $icon = $cv[ 'titleStyle' ][ 'timeImageUrl' ];
                                if (!empty($icon) && strpos($icon, 'icondiy') == false) {
                                    $value[ 'value' ][ $ck ][ 'titleStyle' ] [ 'timeImageUrl' ] = 'icondiy ' . $icon;
                                }
                            }
                        }

                    }

                    model('site_diy_view')->update([ 'value' => json_encode($value) ], [ [ 'id', '=', $v[ 'id' ] ] ]);
                }
            }

            model('goods_service')->commit();
        } catch (\Exception $e) {
            model('goods_service')->rollback();
            $msg = 'File：' . $e->getFile() . '，Line：' . $e->getLine() . '，Message：' . $e->getMessage() . ',Code：' . $e->getCode();
        }
        return $msg;
    }


}