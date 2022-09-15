<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 杭州牛之云科技有限公司, 保留所有权利。
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

        // 如果查询的是首页，那么标题显示店铺名称， && $info[ 'data' ][ 'name' ] == 'DIY_VIEW_INDEX'
        if (!empty($info[ 'data' ])) {
//            $site_api = new Site();
//            $site_info = json_decode($site_api->info(), true)[ 'data' ];
//            $value = json_decode($info[ 'data' ][ 'value' ], true);
//            $value[ 'global' ][ 'title' ] = $site_info[ 'site_name' ];
//            $info[ 'data' ][ 'value' ] = json_encode($value);

            // 查询自定义扩展组件
            $info[ 'data' ][ 'comp_extend' ] = $diy_view->getDiyViewUtilList([ [ 'type', '=', 'EXTEND' ] ], 'name')[ 'data' ];
            if (!empty($info[ 'data' ][ 'comp_extend' ])) {
                $info[ 'data' ][ 'comp_extend' ] = array_column($info[ 'data' ][ 'comp_extend' ], 'name');
            }

        }

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

}