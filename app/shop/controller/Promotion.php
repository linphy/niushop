<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com

 * =========================================================
 */

namespace app\shop\controller;

use app\model\system\AddonQuick;
use app\model\system\Promotion as PrmotionModel;

/**
 * 营销
 * Class Promotion
 * @package app\shop\controller
 */
class Promotion extends BaseShop
{
    protected $addon_arr = [];

    public function __construct()
    {
        //执行父类构造函数
        parent::__construct();
        $this->addon_arr = array_unique(array_column($this->menus, 'addon'));
    }

    /**
     * 营销中心
     * @return mixed
     */
    public function index()
    {
        $promotion_model = new PrmotionModel();
        $promotions = $promotion_model->getSitePromotions($this->site_id);
        $promotions = $this->filterAddon($promotions);
        $this->assign("promotion", $promotions);
        $user_info = $this->user_info;
        $this->assign('user_info',$user_info);
        $addon_quick_model = new AddonQuick();
        //店铺促销
        $shop_addon = $addon_quick_model->getAddonQuickByAddonType($promotions, 'shop');
        $this->assign('shop_addon', $shop_addon);
        //会员互动
        $member_addon = $addon_quick_model->getAddonQuickByAddonType($promotions, 'member');
        $this->assign('member_addon', $member_addon);
        $tool_addon = $addon_quick_model->getAddonQuickByAddonType($promotions, 'tool');
        $this->assign('tool_addon', $tool_addon);
        return $this->fetch("promotion/index");
    }


    /**
     * 会员营销
     * @return mixed
     */
    public function member()
    {
        $promotion_model = new PrmotionModel();
        $promotions = $promotion_model->getSitePromotions($this->site_id);
        $addon_quick_model = new AddonQuick();
        $addon = $addon_quick_model->getAddonQuickByAddonType($promotions, 'member');
        $this->assign('tool_addon', $addon);
        $user_info = $this->user_info;
        $this->assign('user_info',$user_info);
        $this->assign("promotion", $promotions);
        return $this->fetch("promotion/member");
    }

    /**
     * 营销工具
     * @return mixed
     */
    public function tool()
    {
        $promotion_model = new PrmotionModel();
        $promotions = $promotion_model->getPromotions();
        $this->assign("promotion", $promotions[ 'shop' ]);

        $addon_quick_model = new AddonQuick();
        $addon = $addon_quick_model->getAddonQuickByAddonType($promotions[ 'shop' ], 'tool');
        $this->assign('tool_addon', $addon);
        $user_info = $this->user_info;
        $this->assign('user_info',$user_info);
        return $this->fetch("promotion/tool");
    }

    /**
     * @param $data
     */
    protected function filterAddon($data)
    {
        $res = [];
        foreach($data as $key=>$val){
            if(in_array($val['name'], $this->addon_arr)){
                $res[] = $val;
            }
        }
        return $res;
    }
}