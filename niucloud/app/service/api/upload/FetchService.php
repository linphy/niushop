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

namespace app\service\api\upload;

use app\service\core\upload\CoreFetchService;
use core\base\BaseApiService;
use Exception;

/**
 * 用户服务层
 * Class BaseService
 * @package app\service
 */
class FetchService extends BaseApiService
{
    private $root_path = 'file';


    /**
     * 远程拉取图片
     * @param string $url
     * @return array
     * @throws Exception
     */
    public function image(string $url){

        $dir = $this->root_path.'/image/'.date('Ym').'/'.date('d');
        $core_upload_service = new CoreFetchService();
        return $core_upload_service->image($url, $dir);
    }


}
