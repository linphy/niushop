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
namespace core\dict;

class DiyFormComponent extends BaseDict
{
    /**
     * 万能表单组件配置
     * @param array $data
     * @return array|mixed
     */
    public function load(array $data)
    {
        $addons = $this->getLocalAddons();
        $components_files = [];

        foreach ($addons as $v) {
            $components_path = $this->getAddonDictPath($v) . "diy_form" . DIRECTORY_SEPARATOR . "components.php";
            if (is_file($components_path)) {
                $components_files[] = $components_path;
            }
        }
        $components_files_data = $this->loadFiles($components_files);
        $components = $data;
        foreach ($components_files_data as $file_data) {
            $components = empty($components) ? $file_data : array_merge2($components, $file_data);
        }
        return $components;
    }
}
