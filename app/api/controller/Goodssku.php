<?php
/**
 * Goodssku.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */

namespace app\api\controller;

use app\model\goods\Goods;
use app\model\goods\GoodsCategory as GoodsCategoryModel;
use app\model\goods\GoodsCommunityQrCode;
use app\model\goods\GoodsService;
use app\model\goods\GoodsBrowse as GoodsBrowse;
use addon\coupon\model\CouponType;
use app\model\web\Config as ConfigModel;

/**
 * 商品sku
 * @author Administrator
 *
 */
class Goodssku extends BaseApi
{

    /**
     * 基础信息
     */
    public function info()
    {
        $sku_id = isset($this->params['sku_id']) ? $this->params['sku_id'] : 0;
        if (empty($sku_id)) {
            return $this->response($this->error('', 'REQUEST_SKU_ID'));
        }

        $goods = new Goods();
        $info = $goods->getGoodsSkuDetail($sku_id, $this->site_id);
        $token = $this->checkToken();
        if ($token['code'] >= 0) {
            // 是否参与会员等级折扣
            $goods_member_price = $goods->getGoodsPrice($sku_id, $this->member_id);
            $goods_member_price = $goods_member_price['data'];
            if (!empty($goods_member_price['member_price'])) {
                $info['data']['member_price'] = $goods_member_price['member_price'];
            }
            if ($info['data']['is_limit'] && $info['data']['limit_type'] == 2 && $info['data']['max_buy'] > 0) $res['goods_sku_detail']['purchased_num'] = $goods->getGoodsPurchasedNum($info['data']['goods_id'], $this->member_id);
        }
        // 查询当前商品参与的营销活动信息
        $goods_promotion = event('GoodsPromotion', ['goods_id' => $info['data']['goods_id'], 'sku_id' => $info['data']['sku_id']]);
        $info['data']['goods_promotion'] = $goods_promotion;

        //判断是否参与预售
        $is_join_presale = event('IsJoinPresale',['sku_id' => $sku_id],true);
        if (!empty($is_join_presale) && $is_join_presale['code'] == 0) {
            $info['data'] = array_merge($info['data'], $is_join_presale['data']);
        }

        return $this->response($info);
    }

    /**
     * 详情信息
     */
    public function detail()
    {
        $sku_id = isset($this->params['sku_id']) ? $this->params['sku_id'] : 0;
        if (empty($sku_id)) {
            return $this->response($this->error('', 'REQUEST_SKU_ID'));
        }

        $res = [];
        $goods = new Goods();
        $goods_sku_detail = $goods->getGoodsSkuDetail($sku_id, $this->site_id);
        $goods_sku_detail = $goods_sku_detail['data'];
        $res['goods_sku_detail'] = $goods_sku_detail;

        if (empty($goods_sku_detail)) return $this->response($this->error($res));

        $res['goods_sku_detail']['purchased_num'] = 0; // 该商品已购数量

        $token = $this->checkToken();
        if ($token['code'] >= 0) {
            // 是否参与会员等级折扣
            $goods_member_price = $goods->getGoodsPrice($sku_id, $this->member_id);
            $goods_member_price = $goods_member_price['data'];
            if (!empty($goods_member_price['member_price'])) {
                $res['goods_sku_detail']['member_price'] = $goods_member_price['member_price'];
            }
            if ($goods_sku_detail['is_limit'] && $goods_sku_detail['limit_type'] == 2 && $goods_sku_detail['max_buy'] > 0) $res['goods_sku_detail']['purchased_num'] = $goods->getGoodsPurchasedNum($goods_sku_detail['goods_id'], $this->member_id);
        }

        // 商品服务
        $goods_service = new GoodsService();
        $goods_service_list = $goods_service->getServiceList([['site_id', '=', $this->site_id], ['id', 'in', $res['goods_sku_detail']['goods_service_ids']]], 'service_name,desc');
        $res['goods_sku_detail']['goods_service'] = $goods_service_list['data'];

        // 查询当前商品参与的营销活动信息
        $goods_promotion = event('GoodsPromotion', ['goods_id' => $goods_sku_detail['goods_id'], 'sku_id' => $goods_sku_detail['sku_id']]);
        $res['goods_sku_detail']['goods_promotion'] = $goods_promotion;

        //判断是否参与预售
        $is_join_presale = event('IsJoinPresale',['sku_id' => $sku_id],true);
        //获取社群信息
        $goods_community_model = new GoodsCommunityQrCode();
        $qr_data = $goods_community_model->getQrInfo($goods_sku_detail['qr_id'],$this->site_id);
        $res['goods_sku_detail']['qr_data'] = $qr_data['data'];
        if (!empty($is_join_presale) && $is_join_presale['code'] == 0) {
            $res['goods_sku_detail'] = array_merge($res['goods_sku_detail'], $is_join_presale['data']);
        }

        return $this->response($this->success($res));
    }

    /**
     * 商品详情，商品分类用
     * @return false|string
     */
    public function getInfoForCategory()
    {

        $sku_id = isset($this->params['sku_id']) ? $this->params['sku_id'] : 0;
        if (empty($sku_id)) {
            return $this->response($this->error('', 'REQUEST_SKU_ID'));
        }

        $goods = new Goods();
        $field = 'gs.goods_id,gs.sku_id,gs.goods_name,gs.is_limit,gs.limit_type,gs.sku_name,gs.sku_spec_format,gs.price,gs.discount_price,gs.promotion_type,gs.stock,gs.sku_image,gs.goods_spec_format,gs.unit,gs.is_virtual,gs.max_buy,gs.min_buy,g.goods_image';
        $goods_sku_detail = $goods->getGoodsSkuDetail($sku_id, $this->site_id, $field);

        $token = $this->checkToken();
        if ($token['code'] >= 0) {
            // 是否参与会员等级折扣
            $goods_member_price = $goods->getGoodsPrice($sku_id, $this->member_id);
            $goods_member_price = $goods_member_price['data'];
            if (!empty($goods_member_price['member_price'])) {
                $goods_sku_detail['data']['member_price'] = $goods_member_price['member_price'];
            }
            if ($goods_sku_detail['data']['max_buy'] > 0) $goods_sku_detail['data']['purchased_num'] = $goods->getGoodsPurchasedNum($goods_sku_detail['data']['goods_id'], $this->member_id);
        }
        return $this->response($goods_sku_detail);
    }

    /**
     * 列表信息
     */
    public function page()
    {
        $page = isset($this->params['page']) ? $this->params['page'] : 1;
        $page_size = isset($this->params['page_size']) ? $this->params['page_size'] : PAGE_LIST_ROWS;
        $goods_id_arr = isset($this->params['goods_id_arr']) ? $this->params['goods_id_arr'] : '';//goods_id数组
        $keyword = isset($this->params['keyword']) ? $this->params['keyword'] : '';//关键词
        $category_id = isset($this->params['category_id']) ? $this->params['category_id'] : 0;//分类
        $min_price = isset($this->params['min_price']) ? $this->params['min_price'] : 0;//价格区间，小
        $max_price = isset($this->params['max_price']) ? $this->params['max_price'] : 0;//价格区间，大
        $is_free_shipping = isset($this->params['is_free_shipping']) ? $this->params['is_free_shipping'] : 0;//是否免邮
        $order = isset($this->params['order']) ? $this->params['order'] : "";//排序（综合、销量、价格）
        $sort = isset($this->params['sort']) ? $this->params['sort'] : "";//升序、降序
        $coupon = isset($this->params['coupon']) ? $this->params['coupon'] : 0;//优惠券

        $condition = [];
        $condition[] = ['gs.site_id', '=', $this->site_id];

        if (!empty($goods_id_arr)) {
            $condition[] = ['gs.goods_id', 'in', $goods_id_arr];
        }

        if (!empty($keyword)) {
            $condition[] = ['g.goods_name|gs.sku_name|gs.keywords', 'like', '%' . $keyword . '%'];
        }

        if (!empty($category_id)) {
            $goods_category_model = new GoodsCategoryModel();

            // 查询当前
            $category_list = $goods_category_model->getCategoryList([['category_id', '=', $category_id], ['site_id', '=', $this->site_id]], 'category_id,pid,level');
            $category_list = $category_list['data'];

            // 查询子级
            $category_child_list = $goods_category_model->getCategoryList([['pid', '=', $category_id], ['site_id', '=', $this->site_id]], 'category_id,pid,level');
            $category_child_list = $category_child_list['data'];

            $temp_category_list = [];
            if (!empty($category_list)) {
                $temp_category_list = $category_list;
            } elseif (!empty($category_child_list)) {
                $temp_category_list = $category_child_list;
            }

            if (!empty($temp_category_list)) {
                $category_id_arr = [];
                foreach ($temp_category_list as $k => $v) {
                    // 三级分类，并且都能查询到
                    if ($v['level'] == 3 && !empty($category_list) && !empty($category_child_list)) {
                        array_push($category_id_arr, $v['pid']);
                    } else {
                        array_push($category_id_arr, $v['category_id']);
                    }
                }
                $category_id_arr = array_unique($category_id_arr);
                $temp_condition = [];
                foreach ($category_id_arr as $ck => $cv) {
                    $temp_condition[] = '%,' . $cv . ',%';
                }
                $category_condition = $temp_condition;
                $condition[] = ['g.category_id', 'like', $category_condition, 'or'];
            }
        }

        if ($min_price != "" && $max_price != "") {
            $condition[] = ['gs.discount_price', 'between', [$min_price, $max_price]];
        } elseif ($min_price != "") {
            $condition[] = ['gs.discount_price', '>=', $min_price];
        } elseif ($max_price != "") {
            $condition[] = ['gs.discount_price', '<=', $max_price];
        }

        if (!empty($is_free_shipping)) {
            $condition[] = ['gs.is_free_shipping', '=', $is_free_shipping];
        }

        // 非法参数进行过滤
        if ($sort != "desc" && $sort != "asc") {
            $sort = "";
        }

        // 非法参数进行过滤
        if ($order != '') {
            if ($order != "sale_num" && $order != "discount_price") {
                $order = 'gs.sort';
            } elseif ($order == "sale_num"){
                $order = 'sale_sort';
            } else {
                $order = 'gs.' . $order;
            }
            $order_by = $order . ' ' . $sort;
        } else {

            $config_model = new ConfigModel();
            $sort_config = $config_model->getGoodsSort($this->site_id);
            $sort_config = $sort_config['data']['value'];

            $order_by = 'g.sort ' . $sort_config['type'] . ',g.create_time desc';
        }

        // 优惠券
        if (!empty($coupon)) {
            $coupon_type = new CouponType();
            $coupon_type_info = $coupon_type->getInfo([
                ['coupon_type_id', '=', $coupon],
                ['site_id', '=', $this->site_id],
                ['goods_type', '=', 2]
            ], 'goods_ids');
            $coupon_type_info = $coupon_type_info['data'];
            if (isset($coupon_type_info['goods_ids']) && !empty($coupon_type_info['goods_ids'])) {
                $condition[] = ['g.goods_id', 'in', explode(',', trim($coupon_type_info['goods_ids'], ','))];
            }
        }

        $condition[] = ['g.goods_state', '=', 1];
        $condition[] = ['g.is_delete', '=', 0];
        $field = 'gs.goods_id,gs.sort,gs.sku_id,gs.sku_name,gs.price,gs.market_price,gs.discount_price,gs.stock,(g.sale_num + g.virtual_sale) as sale_num,(gs.sale_num + gs.virtual_sale) as sale_sort,gs.sku_image,gs.goods_name,gs.site_id,gs.is_free_shipping,gs.introduction,gs.promotion_type,g.goods_image,g.promotion_addon,gs.is_virtual,g.goods_spec_format,g.recommend_way,gs.max_buy,gs.min_buy,gs.unit,gs.is_limit,gs.limit_type,g.label_name';

        $alias = 'gs';
        $join = [
            ['goods g', 'gs.sku_id = g.sku_id', 'inner']
        ];

        $goods = new Goods();
        $list = $goods->getGoodsSkuPageList($condition, $page, $page_size, $order_by, $field, $alias, $join);

        $token = $this->checkToken();
        if ($token['code'] >= 0) {
            if (!empty($list['data']['list'])) {
                foreach ($list['data']['list'] as $k => $v) {

                    // 是否参与会员等级折扣
                    $goods_member_price = $goods->getGoodsPrice($v['sku_id'], $this->member_id);
                    $goods_member_price = $goods_member_price['data'];
                    if (!empty($goods_member_price['member_price'])) {
                        $list['data']['list'][$k]['member_price'] = $goods_member_price['member_price'];
                    }

                    $list['data']['list'][$k]['purchased_num'] = 0; // 该商品已购数量

                    if ($v['max_buy'] > 0) $list['data']['list'][$k]['purchased_num'] = $goods->getGoodsPurchasedNum($v['goods_id'], $this->member_id);
                }
            }
        }

        return $this->response($list);
    }

    /**
     * 查询商品列表供组件调用
     */
    public function pageComponents()
    {
        $token = $this->checkToken();

        $page = isset($this->params['page']) ? $this->params['page'] : 1;
        $page_size = isset($this->params['page_size']) ? $this->params['page_size'] : PAGE_LIST_ROWS;
        $goods_id_arr = isset($this->params['goods_id_arr']) ? $this->params['goods_id_arr'] : '';//goods_id数组
        $category_id = isset($this->params['category_id']) ? $this->params['category_id'] : 0;//分类

        $condition = [
            ['g.goods_state', '=', 1],
            ['g.is_delete', '=', 0],
            ['g.site_id', '=', $this->site_id ]
        ];
        if (!empty($category_id)) {
            $condition[] = ['category_id', 'like', '%,'. $category_id .',%'];
        }
        if (!empty($goods_id_arr)) {
            $condition[] = ['g.goods_id', 'in', $goods_id_arr];
        }

        $field = 'gs.goods_id,gs.sku_id,gs.price,gs.market_price,gs.discount_price,g.goods_stock,(g.sale_num + g.virtual_sale) as sale_num,g.goods_name,gs.site_id,gs.is_free_shipping,g.goods_image,gs.is_virtual,g.recommend_way,gs.unit,gs.promotion_type,g.label_name';
        if ($token[ 'code' ] >= 0) {
            $field .= ',gs.is_consume_discount,gs.discount_config,gs.member_price,gs.discount_method';
        }
        $alias = 'gs';
        $join = [
            ['goods g', 'gs.sku_id = g.sku_id', 'inner']
        ];
        $config_model = new ConfigModel();
        $sort_config = $config_model->getGoodsSort($this->site_id);
        $sort_config = $sort_config['data']['value'];

        $order_by = 'g.sort ' . $sort_config['type'] . ',g.create_time desc';

        $goods = new Goods();
        $list = $goods->getGoodsSkuPageList($condition, $page, $page_size, $order_by, $field, $alias, $join);

        if (!empty($list[ 'data' ][ 'list' ]) && $token[ 'code' ] >= 0) {
            $list[ 'data' ][ 'list' ] = $goods->getGoodsListMemberPirce($list[ 'data' ][ 'list' ], $this->member_id, $this->site_id);
        }

        return $this->response($list);
    }

    /**
     * 商品推荐
     * @return string
     */
    public function recommend()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);
        $page = isset($this->params[ 'page' ]) ? $this->params[ 'page' ] : 1;
        $page_size = isset($this->params[ 'page_size' ]) ? $this->params[ 'page_size' ] : PAGE_LIST_ROWS;
        $condition[] = [ 'gs.goods_state', '=', 1 ];
        $condition[] = [ 'gs.is_delete', '=', 0 ];
        $condition[] = [ 'gs.site_id', '=', $this->site_id ];
        $goods = new Goods();
        $field = 'gs.goods_id,gs.sku_id,gs.sku_name,gs.price,gs.market_price,gs.discount_price,gs.stock,(g.sale_num + g.virtual_sale) as sale_num,gs.sku_image,gs.goods_name,gs.site_id,gs.is_free_shipping,gs.introduction,gs.promotion_type,g.goods_image,gs.unit,g.label_name';
        $alias = 'gs';

        $config_model = new ConfigModel();
        $order_by = '';
        // 根据后台设置推荐商品
        $guess_you_like = $config_model->getGuessYouLike($this->site_id, $this->app_module);
        $guess_you_like = $guess_you_like['data']['value'];
        if($guess_you_like['type_show']==2 && $guess_you_like['is_show']==1){
            $join = [
                [ 'goods g', 'gs.sku_id = g.sku_id', 'inner' ],
                [ 'goods_browse gb', 'gb.sku_id = gs.sku_id', 'inner' ]
            ];
        }else{
            $join = [
                [ 'goods g', 'gs.sku_id = g.sku_id', 'inner' ]
            ];
        }

        if($guess_you_like['is_show'] == 0){ //猜你喜欢没有开启
            $list = [];
        }else{//猜你喜欢开启
            if($guess_you_like['type_show']==1){
                $sort_config = $config_model->getGoodsSort($this->site_id);
                $sort_config = $sort_config['data']['value'];
                $order_by = 'gs.sort '.$sort_config['type'].',gs.create_time desc';
            }else if ($guess_you_like['type_show']==2){
                $condition[] = ['gb.member_id','=',$this->member_id];
                $condition[] = ['gb.site_id','=',$this->site_id];
                $order_by = 'browse_time desc';
            }else if($guess_you_like['type_show']==3){
                $order_by = 'sale_num desc';
            }else{
                $condition[] = ['gs.goods_id','in',$guess_you_like['goods_ids']];
            }

            $list = $goods->getGoodsSkuPageList($condition, $page, $page_size, $order_by, $field, $alias, $join);
        }
        if (!empty($list[ 'data' ][ 'list' ])) {
            foreach ($list[ 'data' ][ 'list' ] as $k => $v) {
                    // 是否参与会员等级折扣
                    $goods_member_price = $goods->getGoodsPrice($v[ 'sku_id' ], $this->member_id);
                    $goods_member_price = $goods_member_price[ 'data' ];
                    if (!empty($goods_member_price[ 'member_price' ])) {
                        $list[ 'data' ][ 'list' ][ $k ][ 'member_price' ] = $goods_member_price[ 'member_price' ];
                    }
            }
        }
        return $this->response($list);
    }

    /**
     * 商品二维码
     * return
     */
    public function goodsQrcode()
    {
        $sku_id = isset($this->params[ 'sku_id' ]) ? $this->params[ 'sku_id' ] : 0;
        if (empty($sku_id)) {
            return $this->response($this->error('', 'REQUEST_SKU_ID'));
        }
        $goods_model = new Goods();
        $goods_sku_info = $goods_model->getGoodsSkuInfo([ [ 'sku_id', '=', $sku_id ] ], 'sku_id,goods_name');
        $goods_sku_info = $goods_sku_info[ 'data' ];
        $res = $goods_model->qrcode($goods_sku_info[ 'sku_id' ], $goods_sku_info[ 'goods_name' ], $this->site_id);
        return $this->response($res);
    }
}