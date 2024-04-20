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

use app\api\middleware\ApiCheckToken;
use app\api\middleware\ApiLog;
use think\facade\Route;


/**
 * 自定义页面
 */
Route::group('diy', function() {

    // 自定义页面信息
    Route::get('diy', 'diy.Diy/info');

    Route::get('tabbar', 'diy.Diy/tabbar');

    Route::get('share', 'diy.Diy/share');

})->middleware(ApiLog::class)
    ->middleware(ApiCheckToken::class, false);