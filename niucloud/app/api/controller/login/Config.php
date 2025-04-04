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

namespace app\api\controller\login;

use app\service\api\member\MemberConfigService;
use core\base\BaseController;
use think\Response;

class Config extends BaseController
{
    /**
     * 获取登录注册设置
     * @return Response
     */
    public function getLoginConfig()
    {
        $data = $this->request->params([
            [ 'url', '' ],
        ]);
        return success(( new MemberConfigService() )->getLoginConfig($data[ 'url' ]));
    }

}
