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

namespace app\service\core\addon;

use app\model\addon\Addon;
use app\service\core\niucloud\CoreModuleService;
use core\exception\AddonException;
use GuzzleHttp\Exception\GuzzleException;
use ZipArchive;

/**
 * 安装服务层
 * Class CoreInstallService
 * @package app\service\core\install
 */
class CoreAddonDownloadService extends CoreAddonBaseService
{

    protected $addon_download_path;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Addon();
        $this->addon_download_path = 'upload/download/';
    }

    /**
     * 下载文件
     * @param $app_key
     * @return true
     * @throws GuzzleException
     * @throws GuzzleException
     */
    public function download($app_key, $version)
    {
        if (!extension_loaded('zip')) throw new AddonException('ZIP_ARCHIVE_NOT_INSTALL');
        $app_path = $this->addon_path . $app_key . DIRECTORY_SEPARATOR;
        //先判断当前的应用在本地是否存在
//        if(is_dir($app_path)) throw new NiucloudException();
        //下载文件到本地
        $zip_file = (new CoreAddonCloudService())->downloadAddon($app_key, $version);
        //解压到应用addon下
        //删除旧版本文件
        del_target_dir($app_path, true);
        //解压文件
        $this->unzip($zip_file, $this->addon_path);
        //删除压缩包
        @del_target_dir(dirname($zip_file), true);
        return true;
    }

    /**
     * 解压压缩包
     * @param $file
     * @param $dir
     * @return mixed|string
     */
    public function unzip($file, $dir)
    {
        if (!file_exists($file)) throw new AddonException('ZIP_FILE_NOT_FOUND');
        $zip = new ZipArchive();
        if ($zip->open($file) === TRUE) {
            // 对Zip文件进行解压缩操作
            $zip->extractTo($dir);
            $zip->close();
        } else {
            throw new AddonException('ZIP_FILE_NOT_FOUND');
        }
        return $dir;
    }

    public function update()
    {

    }
}
