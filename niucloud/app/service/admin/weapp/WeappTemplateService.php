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

namespace app\service\admin\weapp;

use app\dict\notice\NoticeTypeDict;
use app\service\admin\notice\NoticeService;
use app\service\core\notice\CoreNoticeService;
use core\base\BaseAdminService;
use core\exception\NoticeException;
use core\template\TemplateLoader;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * easywechat主体提供
 * Class WeappTemplateService
 * @package app\service\core\weapp
 */
class WeappTemplateService extends BaseAdminService
{

    /**
     * 获取订阅消息
     * @return array
     */
    public function getList()
    {
        $core_notice_service = new CoreNoticeService();
        $addon_list = $core_notice_service->getAddonList();

        foreach ($addon_list as &$addon) {
            foreach ($addon['notice'] as $k => $v) {
                if (!in_array(NoticeTypeDict::WEAPP, $v[ 'support_type' ])) {
                    unset($addon['notice'][$k]);
                }
            }
            $addon['notice'] = array_values($addon['notice']);
        }
        return $addon_list;
    }

    /**
     * 同步微信公众号消息模板
     * @param array $keys
     * @return true
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function syncAll(array $keys = []){
        $core_notice_service = new CoreNoticeService();
        $list = $core_notice_service->getList($keys);
        if(empty($list)) throw new NoticeException('NOTICE_TEMPLATE_NOT_EXIST');

        foreach($list as $v){
            $this->syncItem($v);
        }
        return true;
    }

    /**
     * @param $item
     * @return true
     */
    public function syncItem($item){
        $key = $item['key'] ?? '';
        $weapp = $item['weapp'] ?? [];
        $tid = $weapp['tid'] ?? '';
        if(empty($tid)) $error = 'WECHAT_TEMPLATE_NEED_NO';
        $weapp_template_id = $item['weapp_template_id'];
        //删除原来的消息模板
        $template_loader = (new TemplateLoader(NoticeTypeDict::WEAPP));
        $template_loader->delete(['template_id' => $weapp_template_id ]);
//        (new CoreWeappTemplateService())->deleteTemplate($weapp_template_id);
        //新的消息模板

        $kid_list = $weapp['kid_list'] ?? [];
        $scene_desc = $weapp['scene_desc'] ?? '';
//        $res = (new CoreWeappTemplateService())->addTemplate($tid, $kid_list, $scene_desc);
        $res = $template_loader->addTemplate(['tid' => $tid, 'kid_list' => $kid_list, 'scene_desc' => $scene_desc ]);
        $notice_service = new NoticeService();
        if (isset($res[ 'errcode' ]) && in_array($res[ 'errcode' ], [0, 200022])) {
            //修改
            $notice_service->modify($key, 'weapp_template_id', $res[ 'priTmplId' ]);
        } else {
            throw new NoticeException($res[ 'errmsg' ]);
        }
        return true;
    }

}
