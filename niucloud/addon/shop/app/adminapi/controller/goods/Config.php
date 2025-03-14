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

namespace addon\shop\app\adminapi\controller\goods;
use addon\shop\app\service\admin\goods\ConfigService;
use core\base\BaseAdminController;

class Config extends BaseAdminController
{
    /**
     * 获取搜做配置
     * @return \think\Response
     */
    public function getSearchConfig()
    {

        return success((new ConfigService())->getSearchConfig());
    }

    /**
     * 设置搜索配置
     * @return \think\Response
     */
    public function setSearchConfig()
    {

        $data = $this->request->params([
            [ "default_word", "" ],
            [ "search_words", "" ]
        ]);
        (new ConfigService())->setSearchConfig($data);
        return success('SUCCESS');
    }

    /**
     * 获取商品唯一编码配置
     * @return \think\Response
     */
    public function getUniqueConfig()
    {

        return success((new ConfigService())->getUniqueConfig());
    }

    /**
     * 设置商品唯一编码配置
     * @return \think\Response
     */
    public function setUniqueConfig()
    {
        $data = $this->request->params([
            [ "is_enable", 0 ]
        ]);
        (new ConfigService())->setUniqueConfig($data);
        return success('SUCCESS');
    }
}