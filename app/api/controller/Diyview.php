<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\api\controller;

use app\model\web\DiyView as DiyViewModel;

/**
 * 自定义模板
 * @package app\api\controller
 */
class Diyview extends BaseApi
{

    /**
     * 基础信息
     */
    public function info()
    {
        $id = isset($this->params[ 'id' ]) ? $this->params[ 'id' ] : 0;
        $name = isset($this->params[ 'name' ]) ? $this->params[ 'name' ] : '';
        $is_default = isset($this->params[ 'is_default' ]) ? $this->params[ 'is_default' ] : ''; // 是否默认页面（针对自定义模板设置），1：是，0：否

        if (empty($id) && empty($name)) {
            return $this->response($this->error('', 'REQUEST_DIY_ID_NAME'));
        }
        $diy_view = new DiyViewModel();
        $condition = [
            [ 'site_id', '=', $this->site_id ]
        ];
        if ($is_default !== '') {
            $condition[] = [ 'is_default', '=', $is_default ];
        }
        if (!empty($id)) {
            $condition[] = [ 'id', '=', $id ];
            $diy_view->modifyClick([ [ 'id', '=', $id ], [ 'site_id', '=', $this->site_id ] ]);
        }
        if (!empty($name)) {
            $condition[] = [ 'name', '=', $name ];
            if ($is_default === '' && in_array($name, $diy_view->getPage()) !== false) {
                $is_default = 1;
                $condition[] = [ 'is_default', '=', 1 ];
            } else {
                $is_default = 0;
            }
            $diy_view->modifyClick([ [ 'name', '=', $name ], [ 'is_default', '=', $is_default ], [ 'site_id', '=', $this->site_id ] ]);
        }

        $info = $diy_view->getSiteDiyViewDetail($condition);
        return $this->response($info);
    }

    /**
     * 平台端底部导航
     * @return string
     */
    public function bottomNav()
    {
        $site_id = $this->site_id;
        if (empty($site_id)) {
            return $this->response($this->error('', 'REQUEST_SITE_ID'));
        }
        $diy_view = new DiyViewModel();
        $info = $diy_view->getBottomNavConfig($site_id);
        return $this->response($info);
    }

    /**
     * 风格
     */
    public function style()
    {
        $site_id = $this->site_id;
        if (empty($site_id)) {
            return $this->response($this->error('', 'REQUEST_SITE_ID'));
        }
        $diy_view = new DiyViewModel();
        $res = $diy_view->getStyleConfig($this->site_id);
        return $this->response($res);
    }

    /**
     * 自定义会员中心配置
     * @return string
     */
    public function memberIndex()
    {
        $site_id = $this->site_id;
        if (empty($site_id)) {
            return $this->response($this->error('', 'REQUEST_SITE_ID'));
        }
        $diy_view = new DiyViewModel();
        $info = $diy_view->getMemberIndexDiyConfig($site_id)[ 'data' ][ 'value' ];
        $info[ 'menu' ][ 'menus' ] = array_column($info[ 'menu' ][ 'menus' ], null, 'tag');
        $info[ 'system_color' ] = $diy_view->getStyleConfig($this->site_id)[ 'data' ][ 'value' ];
        return $this->response($this->success($info));
    }
}