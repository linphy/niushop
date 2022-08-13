<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\model\goods;

use app\model\BaseModel;

/**
 * 社群二维码
 */
class GoodsCommunityQrCode extends BaseModel
{
    /**
     * 添加商品社群二维码
     * @param array $data
     */
    public function addQrCode($data)
    {
        if (!empty($data[ 'qr_id' ])) {
            $qr_id = model('goods_community_qrcode')->update($data, [ [ 'qr_id', '=', $data[ 'qr_id' ] ], [ 'site_id', '=', $data[ 'site_id' ] ] ]);
        } else {
            $qr_id = model('goods_community_qrcode')->add($data);
        }
        return $this->success($qr_id);

    }

    /**
     * 删除社群二维码记录
     * @param int $id
     * @param int $member_id
     */
    public function deleteQrCode($qr_id, $site_id)
    {
        $res = model('goods_community_qrcode')->delete([ [ 'qr_id', '=', $qr_id ], [ 'site_id', '=', $site_id ] ]);
        return $this->success($res);
    }

    /**
     * 获取社群二维码信息
     * @param int $id
     * @param int $member_id
     */
    public function getQrInfo($qr_id, $site_id)
    {
        $res = model('goods_community_qrcode')->getInfo([ [ 'qr_id', '=', $qr_id ], [ 'site_id', '=', $site_id ] ]);
        return $this->success($res);
    }


    /**
     * 获取社群二维码分页列表
     * @param array $condition
     * @param number $page
     * @param string $page_size
     * @param string $order
     * @param string $field
     */
    public function getQrPageList($condition = [], $page = 1, $page_size = PAGE_LIST_ROWS, $order = 'create_time desc', $field = '*', $alias = 'a', $join = [])
    {
        $list = model('goods_community_qrcode')->pageList($condition, $field, $order, $page, $page_size, $alias, $join);
        return $this->success($list);
    }

    /**
     * 获取社群二维码列表
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param null $limit
     * @return array
     */
    public function getQrList($condition = [], $field = '*', $order = 'qr_id asc', $limit = null)
    {
        $list = model('goods_community_qrcode')->getList($condition, $field, $order, '', '', '', $limit);
        return $this->success($list);
    }
}