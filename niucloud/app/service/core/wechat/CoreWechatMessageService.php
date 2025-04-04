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

namespace app\service\core\wechat;

use app\dict\channel\WechatDict;
use app\service\core\scan\CoreScanService;
use core\base\BaseCoreService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Lang;

/**
 * 微信事件中间件类(用于中间件注册)
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class CoreWechatMessageService extends BaseCoreService
{

    /**
     * 通过注入来分配消息事件类型
     * @param $message
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function message($message)
    {
        switch ($message['MsgType']) {
            case WechatDict::MESSAGE_TYPE_EVENT:
                return $this->event($message);
//                return '收到事件消息';
                break;
            case WechatDict::MESSAGE_TYPE_TEXT:
                //调用文本回复
                return $this->text($message);
//                return '收到文字消息';
                break;
            case WechatDict::MESSAGE_TYPE_IMAGE:
                return '收到图片消息';
                break;
            case WechatDict::MESSAGE_TYPE_VOICE:
                return '收到语音消息';
                break;
            case WechatDict::MESSAGE_TYPE_VIDEO:
                return '收到视频消息';
                break;
            case WechatDict::MESSAGE_TYPE_LOCATION:
                return '收到坐标消息';
                break;
            case WechatDict::MESSAGE_TYPE_LINK:
                return '收到链接消息';
                break;
            case WechatDict::MESSAGE_TYPE_FILE:
                return '收到文件消息';
            // ... 其它消息
            default:
                return '收到其它消息';
                break;
        }
    }

    /**
     * 事件分流
     * @return void
     */
    public function event($message)
    {
        switch ($message['Event'] ) {
            case WechatDict::EVENT_SUBSCRIBE:
                return $this->subscribe($message);
                break;
            case WechatDict::EVENT_SCAN:
                return $this->scan($message);
                break;
        }

    }

    /**
     * 扫码事件
     * @param $message
     * @return Lang
     */
    public function scan($message){
        $key = str_replace('qrscene_', '', $message['EventKey']);
        $core_scan_service = new CoreScanService();
        $core_scan_service->actionByScan($key, ['openid' => $message['FromUserName']]);
        return get_lang('SCAN_SUCCESS');
    }

    /**
     * 关注事件
     * @param $message
     * @return News|Text|false
     */
    public function subscribe($message){
        //todo 新增粉丝或将原有的粉丝改为关注状态
        // 因为时间的原因,这里可能需要将实践放在消息队列里面
        $core_wechat_fans_service = new CoreWechatFansService();
        $core_wechat_fans_service->subscribe($message['ToUserName'], $message['FromUserName']);
        //扫码事件
        if(!empty($message['EventKey'])){
            $this->scan($message);
        }
        //如果配置了关注回复,返回关注消息
        $core_wechat_reply_service = new CoreWechatReplyService();
        return $core_wechat_reply_service->reply(WechatDict::REPLY_SUBSCRIBE, openid: $message['FromUserName']) ?? false;
    }


    /**
     * 取消关注事件
     * @param $message
     * @return true
     */
    public function unsubscribe($message){
        $core_wechat_fans_service = new CoreWechatFansService();
        $core_wechat_fans_service->unsubscribe($message['FromUserName']);
        return true;
    }

    /**
     * 文本回复事件
     * @param $message
     * @return News|Text|false
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    function text($message)
    {
        $core_wechat_reply_service = new CoreWechatReplyService();
        return $core_wechat_reply_service->reply(WechatDict::REPLY_KEYWORD, $message['Content'], openid: $message['FromUserName']) ?? false;
    }
}
