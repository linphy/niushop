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

use app\dict\sys\FileDict;
use app\dict\sys\StorageDict;
use app\service\core\upload\CoreUploadService;
use core\base\BaseApiService;
use core\exception\UploadFileException;
use Exception;

/**
 * 用户服务层
 * Class BaseService
 * @package app\service
 */
class UploadService extends BaseApiService
{
    private $root_path = 'file';
    private $cate_id = 0;

    /**
     * 附件库上传图片
     * @param $file
     * @return array
     * @throws Exception
     */
    public function image($file)
    {
        $dir = $this->root_path . '/' . 'image' . '/' . date('Ym') . '/' . date('d');
        $core_upload_service = new CoreUploadService();
        return $core_upload_service->image($file, $dir, $this->cate_id);
    }

    /**
     * 附件库上传视频
     * @param $file
     * @return array
     * @throws Exception
     */
    public function video($file)
    {
        $dir = $this->root_path . '/' . 'video' . '/' . date('Ym') . '/' . date('d');
        $core_upload_service = new CoreUploadService();
        return $core_upload_service->video($file, $dir, $this->cate_id);
    }

    /**
     * 文件上传
     * @param $file
     * @param string $type
     * @return array
     * @throws Exception
     */
    public function document($file, string $type = '')
    {
        if (!in_array($type, FileDict::getSceneType()))
            throw new UploadFileException('UPLOAD_TYPE_ERROR');
        $dir = $this->root_path . '/document/' . $type . '/' . date('Ym') . '/' . date('d');
        $core_upload_service = new CoreUploadService();
        return $core_upload_service->document($file, $type, $dir, StorageDict::LOCAL);
    }
}