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

namespace app\service\core\channel;

use app\dict\common\ChannelDict;
use app\service\core\sys\CoreConfigService;
use core\base\BaseCoreService;

/**
 * 素材管理服务层
 * Class CoreAttachmentService
 * @package app\service\core\sys
 */
class CorePcService extends BaseCoreService
{

    /**
     * 获取pc配置
     * @return array|mixed
     */
    public function getPc()
    {
        $info = (new CoreConfigService())->getConfig(ChannelDict::PC)['value'] ?? [];
        if(empty($info))
        {
            $info = [
                'is_open' => 1
            ];
        }
        return $info;
    }
}
