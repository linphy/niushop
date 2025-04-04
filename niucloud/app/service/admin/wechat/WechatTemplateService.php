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

namespace app\service\admin\wechat;

use app\dict\notice\NoticeTypeDict;
use app\service\admin\notice\NoticeService;
use app\service\core\notice\CoreNoticeService;
use core\base\BaseAdminService;
use core\exception\NoticeException;
use core\template\TemplateLoader;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * easywechat主体提供
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class WechatTemplateService extends BaseAdminService
{


    /**
     * 同步微信公众号消息模板
     * @param array $keys
     * @return true
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function syncAll(array $keys = [])
    {
        $core_notice_service = new CoreNoticeService();
        $list = $core_notice_service->getList($keys);
        if (empty($list)) throw new NoticeException('NOTICE_TEMPLATE_NOT_EXIST');
        foreach ($list as $v) {
            $this->syncItem($v);
        }
        return true;
    }

    /**
     * @param $item
     * @return true
     */
    public function syncItem($item)
    {
        $key = $item[ 'key' ] ?? '';
        $wechat = $item[ 'wechat' ] ?? '';
        $temp_key = $wechat[ 'temp_key' ] ?? '';
        $keyword_name_list = $wechat[ 'keyword_name_list' ] ?? '';

        if (empty($temp_key)) $error = 'WECHAT_TEMPLATE_NEED_NO';
        $wechat_template_id = $item[ 'wechat_template_id' ];
        //删除原来的消息模板
//        (new CoreWechatTemplateService())->deletePrivateTemplate($wechat_template_id);
        $template_loader = new TemplateLoader('wechat');
        $template_loader->delete([ 'templateId' => $wechat_template_id ]);
        //新的消息模板
//        $res = (new CoreWechatTemplateService())->addTemplate($temp_key, $keyword_name_list);
        $res = $template_loader->addTemplate([ 'shortId' => $temp_key, 'keyword_name_list' => $keyword_name_list ]);
        $notice_service = new NoticeService();
        if (isset($res[ 'errcode' ]) && $res[ 'errcode' ] == 0) {
            //修改
            $notice_service->modify($key, 'wechat_template_id', $res[ 'template_id' ]);
        } else {
            throw new NoticeException($res[ 'errmsg' ]);
        }
        return true;
    }

    /**
     * 获取模板消息
     * @return array
     */
    public function getList()
    {
        $core_notice_service = new CoreNoticeService();
        $addon_list = $core_notice_service->getAddonList();

        foreach ($addon_list as &$addon) {
            foreach ($addon['notice'] as $k => $v) {
                if (!in_array(NoticeTypeDict::WECHAT, $v[ 'support_type' ])) {
                    unset($addon['notice'][$k]);
                }
            }
            $addon['notice'] = array_values($addon['notice']);
        }
        return $addon_list;
    }

}
