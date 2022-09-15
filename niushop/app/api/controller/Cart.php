<?php

namespace app\api\controller;

use app\model\goods\Cart as CartModel;
use app\model\goods\Goods;

class Cart extends BaseApi
{
    /**
     * 添加信息
     */
    public function add()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $sku_id = isset($this->params[ 'sku_id' ]) ? $this->params[ 'sku_id' ] : 0;
        $num = isset($this->params[ 'num' ]) ? $this->params[ 'num' ] : 0;
        $form_data = $this->params[ 'form_data' ] ?? '';
        if (empty($sku_id)) {
            return $this->response($this->error('', 'REQUEST_SKU_ID'));
        }
        if (empty($num)) {
            return $this->response($this->error('', 'REQUEST_NUM'));
        }
        $cart = new CartModel();
        $data = [
            'site_id' => $this->site_id,
            'member_id' => $token[ 'data' ][ 'member_id' ],
            'sku_id' => $sku_id,
            'num' => $num,
            'form_data' => $form_data
        ];
        $res = $cart->addCart($data);
        return $this->response($res);
    }

    /**
     * 编辑信息
     */
    public function edit()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $cart_id = isset($this->params[ 'cart_id' ]) ? $this->params[ 'cart_id' ] : 0;
        $num = isset($this->params[ 'num' ]) ? $this->params[ 'num' ] : 0;
        $form_data = $this->params[ 'form_data' ] ?? '';
        if (empty($cart_id)) {
            return $this->response($this->error('', 'REQUEST_CART_ID'));
        }
        if (empty($num)) {
            return $this->response($this->error('', 'REQUEST_NUM'));
        }

        $cart = new CartModel();
        $data = [
            'cart_id' => $cart_id,
            'member_id' => $token[ 'data' ][ 'member_id' ],
            'num' => $num,
            'form_data' => $form_data
        ];
        $res = $cart->editCart($data);
        return $this->response($res);
    }

    /**
     * 删除信息
     */
    public function delete()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $cart_id = isset($this->params[ 'cart_id' ]) ? $this->params[ 'cart_id' ] : 0;
        if (empty($cart_id)) {
            return $this->response($this->error('', 'REQUEST_CART_ID'));
        }
        $cart = new CartModel();
        $data = [
            'cart_id' => $cart_id,
            'member_id' => $token[ 'data' ][ 'member_id' ]
        ];
        $res = $cart->deleteCart($data);
        return $this->response($res);
    }

    /**
     * 清空购物车
     */
    public function clear()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $cart = new CartModel();
        $data = [
            'member_id' => $token[ 'data' ][ 'member_id' ]
        ];
        $res = $cart->clearCart($data);
        return $this->response($res);
    }

    /**
     * 商品购物车列表
     */
    public function goodsLists()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);
        $cart = new CartModel();
        $list = $cart->getCart($token[ 'data' ][ 'member_id' ], $this->site_id);

        $goods = new Goods();
        if (!empty($list[ 'data' ])) {
            foreach ($list[ 'data' ] as $k => $v) {
                // 是否参与会员等级折扣
                $goods_member_price = $goods->getGoodsPrice($v[ 'sku_id' ], $this->member_id);
                $goods_member_price = $goods_member_price[ 'data' ];
                if (!empty($goods_member_price[ 'member_price' ])) {
                    $list[ 'data' ][ $k ][ 'member_price' ] = $goods_member_price[ 'price' ];
                }
            }
        }
        return $this->response($list);
    }

    /**
     * 获取购物车数量
     * @return string
     */
    public function count()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);
        $cart = new CartModel();
//        $list = $cart->getCartCount($token['data']['member_id']);
        $condition = [
            [ 'gc.member_id', '=', $token[ 'data' ][ 'member_id' ] ],
            [ 'gc.site_id', '=', $this->site_id ],
            [ 'gs.goods_state', '=', 1 ],
            [ 'gs.is_delete', '=', 0 ]
        ];
        $list = $cart->getCartList($condition, 'gc.num');
        $list = $list[ 'data' ];
        $count = 0;
        foreach ($list as $k => $v) {
            $count += $v[ 'num' ];
        }
        return $this->response($this->success($count));
    }

    /**
     * 购物车关联列表
     * @return false|string
     */
    public function lists()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);
        $cart = new CartModel();
        $condition = [
            [ 'gc.member_id', '=', $token[ 'data' ][ 'member_id' ] ],
            [ 'gc.site_id', '=', $this->site_id ],
            [ 'gs.goods_state', '=', 1],
            [ 'gs.is_delete', '=', 0 ]
        ];
        $list = $cart->getCartList($condition, 'gc.cart_id,gc.sku_id,gs.goods_id,gs.discount_price,gc.num');
        if (!empty($list[ 'data' ])) {
            $goods = new Goods();
            foreach ($list[ 'data' ] as $k => $v) {
                // 是否参与会员等级折扣
                $goods_member_price = $goods->getGoodsPrice($v[ 'sku_id' ], $this->member_id);
                $goods_member_price = $goods_member_price[ 'data' ];
                if (!empty($goods_member_price[ 'member_price' ]) && $goods_member_price[ 'member_price' ] < $v['discount_price']) {
                    $list[ 'data' ][ $k ][ 'discount_price' ] = $goods_member_price[ 'price' ];
                }
                $list[ 'data' ][ $k ]['total_money'] = $list[ 'data' ][ $k ][ 'discount_price' ] * $v['num'];
            }
        }
        return $this->response($list);
    }

    /**
     * 获取会员购物车中商品数量
     * @return false|string
     */
    public function goodsNum(){
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $goods_id = $this->params['goods_id'] ?? 0;

        $condition = [
            [ 'gc.member_id', '=', $this->member_id ],
            [ 'gc.site_id', '=', $this->site_id ],
            [ 'gs.goods_id', '=', $goods_id ]
        ];

        $join = [
            [
                'goods_sku gs',
                'gc.sku_id = gs.sku_id',
                'left'
            ]
        ];

        $cart = new CartModel();
        $data = $cart->getCartSum($condition, 'gc.num', 'gc', $join);
        return $this->response($data);
    }

    public function editCartSku()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $cart_id = $this->params[ 'cart_id' ] ?? 0;
        $num = $this->params[ 'num' ] ?? 0;
        $sku_id = $this->params[ 'sku_id' ] ?? 0;
        if (empty($cart_id)) return $this->response($this->error('', 'REQUEST_CART_ID'));
        if (empty($num)) return $this->response($this->error('', 'REQUEST_NUM'));
        if (empty($sku_id)) return $this->response($this->error('', 'REQUEST_SKU_ID'));

        $cart = new CartModel();
        $data = [
            'cart_id' => $cart_id,
            'site_id' => $this->site_id,
            'member_id' => $token[ 'data' ][ 'member_id' ],
            'num' => $num,
            'sku_id' => $sku_id
        ];
        $res = $cart->editCartSku($data);
        return $this->response($res);
    }
}