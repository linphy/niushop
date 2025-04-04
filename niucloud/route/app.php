<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;
use think\facade\Request;

Route::domain('install.php', ':\app\install\controller');
// 访问首页自动跳转到admin
Route::rule('/', function () {
    if (Request::isMobile()) {
        return redirect('/wap');
    } else {
        return redirect('/admin');
    }
});
// 管理后台
Route::rule('admin', function () {
    return view(app()->getRootPath() . 'public/admin/index.html');
})->pattern(['any' => '\w+']);
// 站点管理端
Route::rule('home', function () {
    return view(app()->getRootPath() . 'public/admin/index.html');
})->pattern(['any' => '\w+']);
// 装修端
Route::rule('decorate/:any', function () {
    return view(app()->getRootPath() . 'public/admin/index.html');
})->pattern(['any' => '\w+']);
//用于公众号授权证书
Route::any('MP_verify_<name>.txt',  function ($name) {
    header('Content-Type:text/plain; charset=utf-8');
    echo $name;exit();
});
Route::any('wap/<id>/MP_verify_<name>.txt',  function ($name) {
    header('Content-Type:text/plain; charset=utf-8');
    echo $name;exit();
});
// 手机端
Route::rule('wap', function () {
    return view(app()->getRootPath() . 'public/wap/index.html');
})->pattern(['any' => '\w+']);
// 电脑端
Route::rule('web', function () {
    return view(app()->getRootPath() . 'public/web/index.html');
})->pattern(['any' => '\w+']);

// 加载插件的route
$addon_dir = root_path() . 'addon';
$addons = array_diff(scandir($addon_dir), ['.', '..']);
foreach ($addons as $addon) {
    $route = $addon_dir . DIRECTORY_SEPARATOR . $addon . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'route.php';
    if (file_exists($route)) {
        include $route;
    }
}
