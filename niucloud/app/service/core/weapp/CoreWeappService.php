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

namespace app\service\core\weapp;

use core\base\BaseCoreService;
use core\exception\CommonException;
use core\exception\WechatException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\MiniApp\Application;


/**
 * easywechat主体提供
 * Class CoreWeappService
 * @package app\service\core\wechat
 */
class CoreWeappService extends BaseCoreService
{
    /**
     * 获取小程序的handle
     * @return Application
     * @throws InvalidArgumentException
     */
    public static function app()
    {
        $core_weapp_service = new CoreWeappConfigService();
        $weapp_config = $core_weapp_service->getWeappConfig();
        if(empty($weapp_config['app_id']) || empty($weapp_config['app_secret']))
            throw new WechatException('WEAPP_NOT_EXIST');//公众号未配置
        $config = array(
            'app_id' => $weapp_config['app_id'],
            'secret' => $weapp_config['app_secret'],

            /**
             * 接口请求相关配置，超时时间等，具体可用参数请参考：
             * https://github.com/symfony/symfony/blob/5.3/src/Symfony/Contracts/HttpClient/HttpClientInterface.php
             */
            'http' => [
                'throw'  => true, // 状态码非 200、300 时是否抛出异常，默认为开启
                'timeout' => 5.0,
                // 'base_uri' => 'https://api.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri

                'retry' => true, // 使用默认重试配置
                //  'retry' => [
                //      // 仅以下状态码重试
                //      'status_codes' => [429, 500]
                //       // 最大重试次数
                //      'max_retries' => 3,
                //      // 请求间隔 (毫秒)
                //      'delay' => 1000,
                //      // 如果设置，每次重试的等待时间都会增加这个系数
                //      // (例如. 首次:1000ms; 第二次: 3 * 1000ms; etc.)
                //      'multiplier' => 3
                //  ],
            ],
        );
        return new Application($config);
    }


    /**
     * 微信小程序实例接口调用
     * @return \EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient
     * @throws InvalidArgumentException
     */
    public static function appApiClient()
    {
        return self::app()->getClient();
    }

    /**
     * 生成小程序码
     * @return void
     */
    public function qrcode($page, $data, $filepath, $width = 430){
        $scene = [];
        foreach($data as $v){
            $scene[] = $v['key'].'-'.$v['value'];
        }
        $response = self::appApiClient()->postJson('/wxa/getwxacodeunlimit', [
            'scene' => implode('&', $scene),
            'page' => $page,
            'width' => $width,
            'check_path' => false,
//            'env_version' => 'trial' // 要打开的小程序版本。正式版为"release"，体验版为"trial"，开发版为"develop"
        ]);
        if ($response->isFailed()) {
            // 出错了，处理异常
            throw new CommonException('WECHAT_MINI_PROGRAM_CODE_GENERATION_FAILED');
        }
        $response->saveAs($filepath);
        return $filepath;
    }

}