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

use app\model\sys\SysConfig;
use app\service\core\wechat\CoreWechatConfigService;
use core\base\BaseAdminService;
use think\Model;

/**
 * 微信配置模型
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class WechatConfigService extends BaseAdminService
{
    /**
     * 获取配置信息
     * @return array|null
     */
    public function getWechatConfig()
    {
        return (new CoreWechatConfigService())->getWechatConfig();
    }

    /**
     * 设置配置
     * @param array $data
     * @return SysConfig|bool|Model
     */
    public function setWechatConfig(array $data){
        return (new CoreWechatConfigService())->setWechatConfig($data);
    }

    /**
     *查询微信需要的静态信息
     * @return array
     */
    public function getWechatStaticInfo(){
        return (new CoreWechatConfigService())->getWechatStaticInfo();
    }
}
