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

namespace app\service\core\niucloud;

use core\util\niucloud\BaseNiucloudClient;
use core\util\niucloud\http\Response;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * 官网授权管理服务层
 */
class CoreAuthService extends BaseNiucloudClient
{

    /**
     * @return array|Response|object|ResponseInterface
     * @throws GuzzleException
     */
    public function getAuthInfo()
    {
        $auth_info = $this->httpGet('authinfo', ['code' => $this->code, 'secret' => $this->secret, 'product_key' => self::PRODUCT ]);
        if(!empty($auth_info['data'])){
            $auth_info['data']['address_type'] = true;
            if($auth_info['data']['site_address'] != $_SERVER['HTTP_HOST']) $auth_info['data']['address_type'] = false;
        }
        return $auth_info;
    }


}
