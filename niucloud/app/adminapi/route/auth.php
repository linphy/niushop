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

use app\adminapi\middleware\AdminCheckRole;
use app\adminapi\middleware\AdminCheckToken;
use app\adminapi\middleware\AdminLog;
use think\facade\Route;


/**
 * 路由
 */
Route::group('auth', function () {
    /***************************************************** 授权信息 ****************************************************/
    Route::put('logout', 'login.Login/logout');
    /***************************************************** 授权信息 ****************************************************/
    //授权用户站点菜单
    Route::get('authmenu', 'auth.Auth/authMenuList');
    //授权用户信息
    Route::get('get', 'auth.Auth/get');
    //授权用户信息
    Route::put('edit', 'auth.Auth/edit');
    //授权用户信息
    Route::put('modify/:field', 'auth.Auth/modify');
})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);
