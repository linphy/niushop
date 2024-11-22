<?php

namespace addon\shop\app\upgrade\v640;

use addon\shop\app\model\goods\Label;
use addon\shop\app\model\goods\LabelGroup;
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

        $label_group_model = new LabelGroup();
        $label_model = new Label();

        // 添加默认商品标签分组
        $label_group_info = $label_group_model->where([
            [ 'group_name', '=', '默认' ]
        ])->field('group_id')->findOrEmpty()->toArray();

        if (!empty($label_group_info)) {
            $group_id = $label_group_info[ 'group_id' ];
        } else {
            $res = $label_group_model->create([
                'group_name' => '默认',
                'create_time' => time(),
            ]);
            $group_id = $res->group_id;
        }

        // 更新商品标签数据，标签分组id、效果设置、自定义颜色、图标、状态
        $label_model->where([ [ 'label_id', '>', 0 ] ])->update([
            'group_id' => $group_id,
            'status' => 1,
            'style_type' => 'diy',
            'color_json' => [
                'text_color' => 'rgba(255, 255, 255, 1)',
                'bg_color' => 'rgba(255, 65, 66, 1)',
                'border_color' => ''
            ]
        ]);

        $label_model = new Label();
        $label_list = $label_model->where([
            [ 'icon', 'in', [ 'addon/shop/goods/label/icon1.jpg', 'addon/shop/goods/label/icon2.jpg', 'addon/shop/goods/label/icon3.jpg' ] ]
        ])->field('label_id,icon')->select()->toArray();
        if(!empty($label_list)) {
            foreach ($label_list as $k => $v) {
                if ($v[ 'icon' ] == 'addon/shop/goods/label/icon1.jpg') {
                    $label_model->where([ [ 'label_id', '=', $v[ 'label_id' ] ] ])->update([
                        'icon' => 'addon/shop/goods/label/icon1.png'
                    ]);
                } else if ($v[ 'icon' ] == 'addon/shop/goods/label/icon2.jpg') {
                    $label_model->where([ [ 'label_id', '=', $v[ 'label_id' ] ] ])->update([
                        'icon' => 'addon/shop/goods/label/icon2.png'
                    ]);
                } else if ($v[ 'icon' ] == 'addon/shop/goods/label/icon3.jpg') {
                    $label_model->where([ [ 'label_id', '=', $v[ 'label_id' ] ] ])->update([
                        'icon' => 'addon/shop/goods/label/icon3.png'
                    ]);
                }
            }
        }else{
            // 添加商品标签
            $label_list = [
                [
                    'label_name' => '热卖',
                    'group_id' => $group_id,
                    'style_type' => 'diy',
                    'color_json' => [
                        'text_color' => 'rgba(255, 255, 255, 1)',
                        'bg_color' => 'rgba(250, 35, 28, 1)',
                        'border_color' => ''
                    ],
                    'icon' => '',
                    'status' => 1,
                    'sort' => 0,
                    'create_time' => time()
                ],
                [
                    'label_name' => '新品推荐',
                    'group_id' => $group_id,
                    'style_type' => 'diy',
                    'color_json' => [
                        'text_color' => 'rgba(255, 255, 255, 1)',
                        'bg_color' => 'rgba(250, 35, 28, 1)',
                        'border_color' => ''
                    ],
                    'icon' => '',
                    'status' => 1,
                    'sort' => 1,
                    'create_time' => time()
                ],
                [
                    'label_name' => '甄选优品',
                    'group_id' => $group_id,
                    'style_type' => 'diy',
                    'color_json' => [
                        'text_color' => 'rgba(255, 255, 255, 1)',
                        'bg_color' => 'rgba(250, 35, 28, 1)',
                        'border_color' => ''
                    ],
                    'icon' => '',
                    'status' => 1,
                    'sort' => 2,
                    'create_time' => time()
                ],
                [
                    'label_name' => '百亿补贴',
                    'group_id' => $group_id,
                    'style_type' => 'icon',
                    'color_json' => [
                        'text_color' => 'rgba(255, 255, 255, 1)',
                        'bg_color' => 'rgba(250, 35, 28, 1)',
                        'border_color' => ''
                    ],
                    'icon' => 'addon/shop/goods/label/icon1.png',
                    'status' => 1,
                    'sort' => 3,
                    'create_time' => time()
                ],
                [
                    'label_name' => '双11',
                    'group_id' => $group_id,
                    'style_type' => 'icon',
                    'color_json' => [
                        'text_color' => 'rgba(255, 255, 255, 1)',
                        'bg_color' => 'rgba(250, 35, 28, 1)',
                        'border_color' => ''
                    ],
                    'icon' => 'addon/shop/goods/label/icon2.png',
                    'status' => 1,
                    'sort' => 4,
                    'create_time' => time()
                ],
                [
                    'label_name' => '双12',
                    'group_id' => $group_id,
                    'style_type' => 'icon',
                    'color_json' => [
                        'text_color' => 'rgba(255, 255, 255, 1)',
                        'bg_color' => 'rgba(250, 35, 28, 1)',
                        'border_color' => ''
                    ],
                    'icon' => 'addon/shop/goods/label/icon3.png',
                    'status' => 1,
                    'sort' => 5,
                    'create_time' => time()
                ]
            ];
            $exist_label_list = $label_model->where([
                [ 'label_name', 'in', array_column($label_list, 'label_name', '') ]
            ])->field('label_name')->select()->toArray();

            if (!empty($exist_label_list)) {
                $label_name_list = array_column($exist_label_list, 'label_name', '');

                foreach ($label_list as $k => $v) {
                    if (in_array($v[ 'label_name' ], $label_name_list)) {
                        unset($label_list[ $k ]);
                    }
                }
                $label_list = array_values($label_list);
            }
            if (!empty($label_list)) {
                $label_model->insertAll($label_list);
            }
        }

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
            [
                'name' => time() . $category_id . 'banner1.jpg', // 附件名称
                'real_name' => '轮播素材01', // 原始文件名
                'path' => 'addon/shop/attachment/banner1.jpg', // 完整地址
                'url' => 'addon/shop/attachment/banner1.jpg', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '82918', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'banner2.png', // 附件名称
                'real_name' => '轮播素材02', // 原始文件名
                'path' => 'addon/shop/attachment/banner2.png', // 完整地址
                'url' => 'addon/shop/attachment/banner2.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '95324', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'banner3.png', // 附件名称
                'real_name' => '轮播素材03', // 原始文件名
                'path' => 'addon/shop/attachment/banner3.png', // 完整地址
                'url' => 'addon/shop/attachment/banner3.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '97570', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'logo.png', // 附件名称
                'real_name' => '生活圈', // 原始文件名
                'path' => 'addon/shop/attachment/logo.png', // 完整地址
                'url' => 'addon/shop/attachment/logo.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '1517', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_coupon.png', // 附件名称
                'real_name' => '优惠券', // 原始文件名
                'path' => 'addon/shop/attachment/nav_coupon.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_coupon.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '30937', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_discount.png', // 附件名称
                'real_name' => '限时折扣', // 原始文件名
                'path' => 'addon/shop/attachment/nav_discount.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_discount.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '33870', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_fenxiao.png', // 附件名称
                'real_name' => '分销管理', // 原始文件名
                'path' => 'addon/shop/attachment/nav_fenxiao.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_fenxiao.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '24026', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_fenxiao_zone.png', // 附件名称
                'real_name' => '分销专区', // 原始文件名
                'path' => 'addon/shop/attachment/nav_fenxiao_zone.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_fenxiao_zone.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '33429', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_giftcard.png', // 附件名称
                'real_name' => '礼品卡', // 原始文件名
                'path' => 'addon/shop/attachment/nav_giftcard.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_giftcard.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '29399', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_my_address.png', // 附件名称
                'real_name' => '收货地址', // 原始文件名
                'path' => 'addon/shop/attachment/nav_my_address.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_my_address.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '25280', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_my_newcomer.png', // 附件名称
                'real_name' => '新人专享', // 原始文件名
                'path' => 'addon/shop/attachment/nav_my_newcomer.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_my_newcomer.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '32123', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_news_info.png', // 附件名称
                'real_name' => '新闻资讯', // 原始文件名
                'path' => 'addon/shop/attachment/nav_news_info.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_news_info.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '27934', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_point_index.png', // 附件名称
                'real_name' => '积分商城', // 原始文件名
                'path' => 'addon/shop/attachment/nav_point_index.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_point_index.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '27946 ', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_sign_in.png', // 附件名称
                'real_name' => '签到', // 原始文件名
                'path' => 'addon/shop/attachment/nav_sign_in.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_sign_in.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '33576', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'notice.png', // 附件名称
                'real_name' => '新闻咨询', // 原始文件名
                'path' => 'addon/shop/attachment/notice.png', // 完整地址
                'url' => 'addon/shop/attachment/notice.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '3069', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'picture_show_head_text2.png', // 附件名称
                'real_name' => '品牌特卖', // 原始文件名
                'path' => 'addon/shop/attachment/picture_show_head_text2.png', // 完整地址
                'url' => 'addon/shop/attachment/picture_show_head_text2.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '2825', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'picture_show_head_text3.png', // 附件名称
                'real_name' => '官方补贴', // 原始文件名
                'path' => 'addon/shop/attachment/picture_show_head_text3.png', // 完整地址
                'url' => 'addon/shop/attachment/picture_show_head_text3.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '2549', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'single_recommend_banner1.png', // 附件名称
                'real_name' => '精选推荐01', // 原始文件名
                'path' => 'addon/shop/attachment/single_recommend_banner1.png', // 完整地址
                'url' => 'addon/shop/attachment/single_recommend_banner1.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '73548', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'single_recommend_banner2.png', // 附件名称
                'real_name' => '精选推荐02', // 原始文件名
                'path' => 'addon/shop/attachment/single_recommend_banner2.png', // 完整地址
                'url' => 'addon/shop/attachment/single_recommend_banner2.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '61033', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'single_recommend_text1.png', // 附件名称
                'real_name' => '精选推荐', // 原始文件名
                'path' => 'addon/shop/attachment/single_recommend_text1.png', // 完整地址
                'url' => 'addon/shop/attachment/single_recommend_text1.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '3664', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'my_cart.png', // 附件名称
                'real_name' => '购物车', // 原始文件名
                'path' => 'addon/shop/attachment/my_cart.png', // 完整地址
                'url' => 'addon/shop/attachment/my_cart.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '31921', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'home_delivery.png', // 附件名称
                'real_name' => '送货上门', // 原始文件名
                'path' => 'addon/shop/attachment/home_delivery.png', // 完整地址
                'url' => 'addon/shop/attachment/home_delivery.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '30811', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_all_class.png', // 附件名称
                'real_name' => '全部分类', // 原始文件名
                'path' => 'addon/shop/attachment/nav_all_class.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_all_class.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '25427', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_balance.png', // 附件名称
                'real_name' => '我的余额', // 原始文件名
                'path' => 'addon/shop/attachment/nav_balance.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_balance.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '31437', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_collect.png', // 附件名称
                'real_name' => '我的收藏', // 原始文件名
                'path' => 'addon/shop/attachment/nav_collect.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_collect.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '24533', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_coupon_01.png', // 附件名称
                'real_name' => '瓜分好券', // 原始文件名
                'path' => 'addon/shop/attachment/nav_coupon_01.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_coupon_01.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '27068', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_leaderboard.png', // 附件名称
                'real_name' => '排行榜', // 原始文件名
                'path' => 'addon/shop/attachment/nav_leaderboard.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_leaderboard.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '30098', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_member.png', // 附件名称
                'real_name' => '会员中心', // 原始文件名
                'path' => 'addon/shop/attachment/nav_member.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_member.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '30793', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_point.png', // 附件名称
                'real_name' => '我的积分', // 原始文件名
                'path' => 'addon/shop/attachment/nav_point.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_point.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '28112', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_shop.png', // 附件名称
                'real_name' => '线上商城', // 原始文件名
                'path' => 'addon/shop/attachment/nav_shop.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_shop.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '23057', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nav_travel.png', // 附件名称
                'real_name' => '旅游出行', // 原始文件名
                'path' => 'addon/shop/attachment/nav_travel.png', // 完整地址
                'url' => 'addon/shop/attachment/nav_travel.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '27429', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'nva_group_booking.png', // 附件名称
                'real_name' => '拼团返利', // 原始文件名
                'path' => 'addon/shop/attachment/nva_group_booking.png', // 完整地址
                'url' => 'addon/shop/attachment/nva_group_booking.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '30421', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'head_01.png', // 附件名称
                'real_name' => '超值爆款', // 原始文件名
                'path' => 'addon/shop/attachment/head_01.png', // 完整地址
                'url' => 'addon/shop/attachment/head_01.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '3958', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'head_02.png', // 附件名称
                'real_name' => '限时折扣', // 原始文件名
                'path' => 'addon/shop/attachment/head_02.png', // 完整地址
                'url' => 'addon/shop/attachment/head_02.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '2408', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'head_03.png', // 附件名称
                'real_name' => '商品榜单', // 原始文件名
                'path' => 'addon/shop/attachment/head_03.png', // 完整地址
                'url' => 'addon/shop/attachment/head_03.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '2621', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'image_ads_01.png', // 附件名称
                'real_name' => '商品低至五折', // 原始文件名
                'path' => 'addon/shop/attachment/image_ads_01.png', // 完整地址
                'url' => 'addon/shop/attachment/image_ads_01.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '44566', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_01.png', // 附件名称
                'real_name' => '魔方素材01', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_01.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_01.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '36850', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_02.png', // 附件名称
                'real_name' => '魔方素材02', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_02.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_02.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '26463', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_03.png', // 附件名称
                'real_name' => '魔方素材03', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_03.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_03.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '29142', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_04.png', // 附件名称
                'real_name' => '魔方素材04', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_04.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_04.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '26068', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_05.png', // 附件名称
                'real_name' => '魔方素材05', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_05.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_05.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '107422', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_06.png', // 附件名称
                'real_name' => '魔方素材06', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_06.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_06.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '130868', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_07.png', // 附件名称
                'real_name' => '魔方素材07', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_07.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_07.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '129386', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ],
            [
                'name' => time() . $category_id . 'active_cube_08.png', // 附件名称
                'real_name' => '魔方素材08', // 原始文件名
                'path' => 'addon/shop/attachment/active_cube_08.png', // 完整地址
                'url' => 'addon/shop/attachment/active_cube_08.png', // 网络地址
                'dir' => 'addon/shop/attachment', // 附件路径
                'att_size' => '81778', // 附件大小
                'att_type' => 'image', // 附件类型image,video
                'storage_type' => 'local', // 图片上传类型 local本地  aliyun  阿里云oss  qiniu  七牛 ....
                'cate_id' => $category_id, // 素材分类id
                'create_time' => time()
            ]
        ];
        $exist_attachment_list = $attachment_model->where([
            [ 'path', 'in', array_column($attachment_list, 'path', '') ]
        ])->field('path')->select()->toArray();

        if (!empty($exist_attachment_list)) {
            $attachment_path_list = array_column($exist_attachment_list, 'path', '');

            foreach ($attachment_list as $k => $v) {
                if (in_array($v[ 'path' ], $attachment_path_list)) {
                    unset($attachment_list[ $k ]);
                }
            }
            $attachment_list = array_values($attachment_list);
        }
        if (!empty($attachment_list)) {
            $attachment_model->insertAll($attachment_list);
        }

    }

}
