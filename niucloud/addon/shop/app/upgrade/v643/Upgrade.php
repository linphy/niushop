<?php

namespace addon\shop\app\upgrade\v643;

use app\model\sys\SysAttachment;
use app\model\sys\SysAttachmentCategory;

class Upgrade
{

    public function handle()
    {
        $this->handleData();
    }

    /**
     * 处理商品数据
     */
    private function handleData()
    {
        // 创建素材
        $category_model = new SysAttachmentCategory();
        $category_info = $category_model->where([
            [ 'name', '=', '商城素材' ]
        ])->field('id')->findOrEmpty()->toArray();

        if (!empty($category_info)) {
            $category_id = $category_info[ 'id' ];
        } else {
            $attachment_category = $category_model->create([
                'pid' => 0,
                'type' => 'image',
                'name' => '商城素材',
                'sort' => 1
            ]);
            $category_id = $attachment_category->id;
        }

        $attachment_model = new SysAttachment();

        $attachment_list = [
            'name' => time() . $category_id . 'nav_sow_community.png', // 附件名称
            'real_name' => '种草社区', // 原始文件名
            'path' => 'addon/shop/attachment/nav_sow_community.png', // 完整地址
            'url' => 'addon/shop/attachment/nav_sow_community.png', // 网络地址
            'dir' => 'addon/shop/attachment', // 附件路径
            'att_size' => '24576', // 附件大小
            'att_type' => 'image', // 附件类型image,video
            'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
            'cate_id' => $category_id, // 素材分类id
            'create_time' => time()
        ];
        $exist_attachment_list = $attachment_model->where([
            [ 'path', '=', 'addon/shop/attachment/nav_sow_community.png' ]
        ])->field('path')->findOrEmpty()->toArray();

        if (empty($exist_attachment_list)) {
            $attachment_model->create($attachment_list);
        }

    }

}
