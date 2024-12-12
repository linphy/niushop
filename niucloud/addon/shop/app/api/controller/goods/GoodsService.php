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

namespace addon\shop\app\api\controller\goods;

use addon\shop\app\service\api\goods\GoodsServiceService;
use core\base\BaseApiController;
use think\Response;

/**
 * 商品服务
 * Class GoodsService
 * @package addon\shop\app\api\controller\goods
 */
class GoodsService extends BaseApiController
{
    /**
     * 获取商品服务列表
     * @return Response
     */
    public function all()
    {
        $data = $this->request->params([
            [ 'limit', 0 ]
        ]);
        return success(( new GoodsServiceService() )->getAll($data));
    }

}
