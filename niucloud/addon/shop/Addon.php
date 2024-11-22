<?php

namespace addon\shop;


use addon\shop\app\model\goods\Label;
use addon\shop\app\model\goods\LabelGroup;
use addon\shop\app\service\core\delivery\CoreCompanyService;
use addon\shop\app\service\core\delivery\CoreElectronicSheetService;
use app\service\admin\diy\DiyService;
use app\service\core\diy\CoreDiyService;
use app\service\core\poster\CorePosterService;
use app\model\sys\SysAttachment;
use app\model\sys\SysAttachmentCategory;

/**
 * 插件安装之后单独的插件方法
 */
class Addon
{
    /**
     * 插件安装执行
     */
    public function install()
    {

        // 创建默认商品海报
        $poster = new CorePosterService();
        $template = $poster->getTemplateList('shop', 'shop_goods')[ 0 ];
        $poster->add('shop', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);

        // 创建默认积分商品海报
        $poster = new CorePosterService();
        $template = $poster->getTemplateList('shop', 'shop_point_goods')[ 0 ];
        $poster->add('shop', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);

        $diy_service = new DiyService();

        // 设置 首页 默认模板
        $diy_service->setDiyData([
            'key' => 'DIY_INDEX',
            'type' => 'index',
            'addon' => 'shop',
            'is_start' => 1
        ]);

        // 设置 个人中心 默认模板
        $diy_service->setDiyData([
            'key' => 'DIY_MEMBER_INDEX',
            'type' => 'member_index',
            'addon' => 'shop',
            'is_start' => 1
        ]);

        // 创建 积分商城 微页面
        $addon_flag = 'DIY_SHOP_POINT_INDEX';
        $addon_index_template = $diy_service->getFirstPageData($addon_flag, 'shop');
        $diy_service->add([
            'page_title' => $addon_index_template[ 'title' ],
            "title" => $addon_index_template[ 'title' ],
            "name" => $addon_flag,
            "type" => $addon_flag,
            "template" => $addon_index_template[ 'template' ],
            "mode" => $addon_index_template[ 'mode' ],
            "value" => json_encode($addon_index_template[ 'data' ]),
            "is_default" => 1,
            "is_change" => 0
        ]);

        // 创建物流公司
        $company_service = new CoreCompanyService();

        $company_list = [
            [
                'create_time' => time(),
                'company_name' => '邮政EMS',
                'logo' => 'addon/shop/express/ems.jpg',
                'url' => 'https://www.ems.com.cn',
                'express_no' => 'EMS',
                'express_no_electronic_sheet' => 'EMS',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 76*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '一联130新 76*130',
                        'template_size' => '1301',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '180',
                    ],
                    [
                        'template_name' => '二联180新 100*180',
                        'template_size' => '1801',
                    ],
                    [
                        'template_name' => '二联150 100*150',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '二联150新 100*150',
                        'template_size' => '1501',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '特快专递',
                        'value' => 1
                    ],
                    [
                        'text' => '代收到付',
                        'value' => 8
                    ],
                    [
                        'text' => '快递包裹',
                        'value' => 9
                    ],
                    [
                        'text' => '电商标快',
                        'value' => 10
                    ],
                    [
                        'text' => '国内标快',
                        'value' => 11
                    ]
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '邮政快递包裹',
                'logo' => 'addon/shop/express/youzhengkd.png',
                'url' => 'https://www.ems.com.cn',
                'express_no' => 'YZPY',
                'express_no_electronic_sheet' => 'YZPY',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 76*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '一联130新 76*130',
                        'template_size' => '1301',
                    ],
                    [
                        'template_name' => '二联1801 100*180',
                        'template_size' => '1801',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '二联180新 100*180',
                        'template_size' => '180',
                    ],
                    [
                        'template_name' => '二联150 100*150',
                        'template_size' => '150',
                    ],
                    [
                        'template_name' => '二联150新 100*150',
                        'template_size' => '1501',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '标准快递',
                        'value' => 1
                    ]
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '顺丰速运',
                'logo' => 'addon/shop/express/shunfeng.png',
                'url' => 'https://www.sf-express.com/chn/sc',
                'express_no' => 'SF',
                'express_no_electronic_sheet' => 'SF',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130新 76*130',
                        'template_size' => '1301',
                    ],
                    [
                        'template_name' => '二联150新 100*150',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '二联180新 100*180',
                        'template_size' => '180',
                    ],
                    [
                        'template_name' => '三联210新 100*210',
                        'template_size' => '210',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '顺丰特快',
                        'value' => 1
                    ],
                    [
                        'text' => '顺丰标快',
                        'value' => 2
                    ],
                    [
                        'text' => '顺丰即日',
                        'value' => 6
                    ],
                    [
                        'text' => '冷运标快',
                        'value' => 201
                    ],
                    [
                        'text' => '顺丰微小件',
                        'value' => 202
                    ]
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '中通快递',
                'logo' => 'addon/shop/express/zhongtong.png',
                'url' => 'https://www.zto.com',
                'express_no' => 'ZTO',
                'express_no_electronic_sheet' => 'ZTO',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 76*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '二联180新 100*180',
                        'template_size' => '180',
                    ]
                ],
                'exp_type' => []
            ],
            [
                'create_time' => time(),
                'company_name' => '圆通速递',
                'logo' => 'addon/shop/express/yuantong.png',
                'url' => 'https://www.yto.net.cn',
                'express_no' => 'YTO',
                'express_no_electronic_sheet' => 'YTO',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 76*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '一联130新 76*130',
                        'template_size' => '1301',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '三联180 100*180',
                        'template_size' => '180',
                    ],
                    [
                        'template_name' => '二联180新 100*180',
                        'template_size' => '1801',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '标准快递',
                        'value' => 1
                    ],
                    [
                        'text' => '圆准达',
                        'value' => 2
                    ]
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '申通快递',
                'logo' => 'addon/shop/express/shentong.png',
                'url' => 'https://www.sto.cn/pc',
                'express_no' => 'STO',
                'express_no_electronic_sheet' => 'STO',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 76*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '一联130新 76*130',
                        'template_size' => '1301',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '二联180新 100*180',
                        'template_size' => '180',
                    ],
                    [
                        'template_name' => '三联180新 100*180',
                        'template_size' => '1803',
                    ],
                    [
                        'template_name' => '二联150 100*150',
                        'template_size' => '150',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '标准快递',
                        'value' => 1
                    ],
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '韵达速递',
                'logo' => 'addon/shop/express/yunda.png',
                'url' => 'http://www.yundaex.com/cn',
                'express_no' => 'YD',
                'express_no_electronic_sheet' => 'YD',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 100*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '180',
                    ],
                    [
                        'template_name' => '二联203 100*203',
                        'template_size' => '0',
                    ]
                ],
                'exp_type' => []
            ],
            [
                'create_time' => time(),
                'company_name' => '极兔速递',
                'logo' => 'addon/shop/express/jitu.png',
                'url' => 'https://www.jtexpress.cn',
                'express_no' => 'JTSD',
                'express_no_electronic_sheet' => 'JTSD',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 100*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '二联180 100*180',
                        'template_size' => '0',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '标准快递',
                        'value' => 1
                    ],
                    [
                        'text' => '兔优达',
                        'value' => 2
                    ]
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '菜鸟速递',
                'logo' => 'addon/shop/express/cainiao.jpg',
                'url' => 'https://express.cainiao.com/',
                'express_no' => 'CNSD',
                'express_no_electronic_sheet' => 'CNSD',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130 100*130',
                        'template_size' => '0',
                    ]
                ],
                'exp_type' => [
                    [
                        'text' => '当日达',
                        'value' => 1
                    ],
                    [
                        'text' => '次日达',
                        'value' => 2
                    ],
                    [
                        'text' => '预约配送',
                        'value' => 3
                    ],
                    [
                        'text' => '当日下午达',
                        'value' => 4
                    ],
                    [
                        'text' => '当日夜间达',
                        'value' => 5
                    ],
                    [
                        'text' => '次日上午达',
                        'value' => 6
                    ]
                ]
            ],
            [
                'create_time' => time(),
                'company_name' => '京东快递',
                'logo' => 'addon/shop/express/jingdong.jpg',
                'url' => 'https://www.jdl.com',
                'express_no' => 'JD',
                'express_no_electronic_sheet' => 'JD',
                'electronic_sheet_switch' => 1,
                'print_style' => [
                    [
                        'template_name' => '一联130新 76*130',
                        'template_size' => '130',
                    ],
                    [
                        'template_name' => '二联110 100*110',
                        'template_size' => '0',
                    ],
                    [
                        'template_name' => '二联110新 100*110',
                        'template_size' => '110',
                    ]
                ],
                'exp_type' => []
            ]
        ];
        $company_service->addAll($company_list);

        $company_list_for_print = $company_service->getList([
            [ 'express_no_electronic_sheet', 'in', [ 'EMS', 'YZPY', 'SF' ] ],
            [ 'electronic_sheet_switch', '=', 1 ],
        ], 'company_id,company_name,express_no_electronic_sheet,print_style,exp_type');

        $electronic_sheet_list = [];
        foreach ($company_list_for_print as $k => $v) {
            $electronic_sheet_list[] = [
                'template_name' => $v[ 'company_name' ] . ' ' . $v[ 'print_style' ][ 0 ][ 'template_name' ],
                'express_company_id' => $v[ 'company_id' ],
                'customer_name' => '电子面单账号',
                'customer_pwd' => '电子面单密码',
                'send_site' => '',
                'send_staff' => '',
                'month_code' => '',
                'pay_type' => 1,
                'is_notice' => 0,
                'status' => 1,
                'exp_type' => $v[ 'exp_type' ][ 0 ][ 'value' ],
                'print_style' => $v[ 'print_style' ][ 0 ][ 'template_size' ],
                'is_default' => $k == 0 ? 1 : 0,
                'create_time' => time()
            ];
        }

        $electronic_sheet_service = new CoreElectronicSheetService();
        $electronic_sheet_service->addAll($electronic_sheet_list);

        // 添加商品标签分组
        $label_group_model = new LabelGroup();
        $label_model = new Label();

        // 添加默认商品标签分组
        $label_group_res = $label_group_model->create([
            'group_name' => '默认',
            'create_time' => time(),
        ]);

        // 添加商品标签
        $label_list = [
            [
                'label_name' => '热卖',
                'group_id' => $label_group_res->group_id,
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
                'group_id' => $label_group_res->group_id,
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
                'group_id' => $label_group_res->group_id,
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
                'group_id' => $label_group_res->group_id,
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
                'group_id' => $label_group_res->group_id,
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
                'group_id' => $label_group_res->group_id,
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
        $label_model->insertAll($label_list);

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
        $attachment_model->insertAll($attachment_list);

        return true;
    }

    /**
     * 插件卸载执行
     */
    public function uninstall()
    {
        // 删除自定义海报
        $poster = new CorePosterService();
        $poster->del([
            [ 'type', 'in', [ 'shop_goods', 'shop_point_goods' ] ]
        ]);

        // 删除微页面
        $diy_service = new CoreDiyService();
        $diy_service->del([
            [ 'name', 'in', [ 'DIY_SHOP_INDEX', 'DIY_SHOP_MEMBER_INDEX', 'DIY_SHOP_POINT_INDEX' ] ]
        ]);

        // 删除商城素材
        $category_model = new SysAttachmentCategory();
        $category_model->where([
            [ 'name', '=', '商城素材' ]
        ])->delete();

        $attachment_model = new SysAttachment();
        $path_arr = [
            'addon/shop/attachment/banner1.jpg',
            'shop/attachment/banner2.png',
            'addon/shop/attachment/banner3.png',
            'addon/shop/attachment/logo.png',
            'addon/shop/attachment/nav_coupon.png',
            'addon/shop/attachment/nav_discount.png',
            'addon/shop/attachment/nav_fenxiao.png',
            'addon/shop/attachment/nav_fenxiao_zone.png',
            'addon/shop/attachment/nav_giftcard.png',
            'addon/shop/attachment/nav_my_address.png',
            'addon/shop/attachment/nav_my_newcomer.png',
            'addon/shop/attachment/nav_news_info.png',
            'addon/shop/attachment/nav_point_index.png',
            'addon/shop/attachment/nav_sign_in.png',
            'addon/shop/attachment/notice.png',
            'addon/shop/attachment/picture_show_head_text2.png',
            'addon/shop/attachment/picture_show_head_text3.png',
            'addon/shop/attachment/single_recommend_banner1.png',
            'addon/shop/attachment/single_recommend_banner2.png',
            'addon/shop/attachment/single_recommend_text1.png',
            'addon/shop/attachment/my_cart.png',
            'addon/shop/attachment/home_delivery.png',
            'addon/shop/attachment/nav_all_class.png',
            'addon/shop/attachment/nav_balance.png',
            'addon/shop/attachment/nav_collect.png',
            'addon/shop/attachment/nav_coupon_01.png',
            'addon/shop/attachment/nav_leaderboard.png',
            'addon/shop/attachment/nav_member.png',
            'addon/shop/attachment/nav_point.png',
            'addon/shop/attachment/nav_shop.png',
            'addon/shop/attachment/nav_travel.png',
            'addon/shop/attachment/nva_group_booking.png',
            'addon/shop/attachment/head_01.png',
            'addon/shop/attachment/head_02.png',
            'addon/shop/attachment/head_03.png',
            'addon/shop/attachment/image_ads_01.png',
            'addon/shop/attachment/active_cube_01.png',
            'addon/shop/attachment/active_cube_02.png',
            'addon/shop/attachment/active_cube_03.png',
            'addon/shop/attachment/active_cube_04.png',
            'addon/shop/attachment/active_cube_05.png',
            'addon/shop/attachment/active_cube_06.png',
            'addon/shop/attachment/active_cube_07.png',
            'addon/shop/attachment/active_cube_08.png'
        ];
        $attachment_model->where([
            [ 'path', 'in', $path_arr ]
        ])->delete();

        return true;
    }

    /**
     * 插件升级执行
     */
    public function upgrade()
    {
        return true;
    }
}
