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

namespace app\service\admin\wechat;

use app\dict\channel\WechatDict;
use Closure;
use core\base\BaseAdminService;

/**
 * 微信事件中间件类(用于中间件注册)
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class WechatEventService extends BaseAdminService
{
    /**
     *
     * @return void
     */
    public function event($message, Closure $next){
        switch($message->MsgType){
            case WechatDict::EVENT_SUBSCRIBE :
                $message->FromUserName;
                break;
        }
    }
}
