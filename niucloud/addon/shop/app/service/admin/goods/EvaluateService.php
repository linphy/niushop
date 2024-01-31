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

namespace addon\shop\app\service\admin\goods;

use addon\shop\app\dict\goods\EvaluateDict;
use addon\shop\app\model\goods\Evaluate;
use addon\shop\app\service\core\goods\CoreGoodsEvaluateService;
use core\base\BaseAdminService;
use think\db\Query;


/**
 * 商品评价服务层
 * Class EvaluateService
 * @package addon\shop\app\service\admin\goods
 */
class EvaluateService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Evaluate();
    }

    /**
     * 获取商品评价列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'evaluate_id,site_id,order_id,order_goods_id,goods_id,member_id,content,images,is_anonymous,scores,is_audit,explain_first,create_time,topping';
        $order = 'create_time desc';

        $goods_where = [];
        if($where[ 'goods_name' ]){
            $goods_where[] = ['goods.goods_name', 'like', '%' . $where[ 'goods_name' ] . '%'  ];
        }

        $search_model = $this->model
            // ->withSearch(["goods_name"], $where)
            ->where([ ['evaluate.site_id', '=', $this->site_id] ])
            ->field($field)
            ->withJoin([
                'goods' => function(Query $query) use($goods_where){
                    $query->where($goods_where);
                },
            ])
            ->order($order)->append(['audit_name', 'image_small']);
        $list = $this->pageQuery($search_model, function ($item, $key){
            $item_goods = $item['goods'];
            if(!empty($item_goods)){
                $item_goods->append(['goods_cover_thumb_small','goods_cover_thumb_mid']);
            }

        });
        return $list;
    }

    /**
     * 获取商品评价信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'evaluate_id,site_id,order_id,order_goods_id,goods_id,member_id,content,images,is_anonymous,scores,is_audit,explain_first,create_time';

        $info = $this->model->field($field)->where([['evaluate_id', '=', $id], ['site_id', '=', $this->site_id]])->findOrEmpty()->toArray();
        return $info;
    }

    /**
     * 添加商品评价
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data['is_audit'] = 2;
        $data['site_id'] = $this->site_id;
        return (new CoreGoodsEvaluateService)->addEvaluate($data);
    }

    /**
     * 删除商品评价
     * @param int $id
     * @return bool
     */
    public function del(int $evaluate_id)
    {
        $model = $this->model->where([['evaluate_id', '=', $evaluate_id], ['site_id', '=', $this->site_id]])->find();
        $res = $model->delete();
        return $res;
    }

    /**
     * 审核通过
     * @param $evaluate_id
     * @return bool
     */
    public function auditAdopt($evaluate_id)
    {
        $this->model->where([['evaluate_id', '=', $evaluate_id], ['site_id', '=', $this->site_id]])->update(['is_audit' => EvaluateDict::AUDIT_ADOPT]);
        return true;
    }

    /**
     * 审核拒绝
     * @param $evaluate_id
     * @return bool
     */
    public function auditRefuse($evaluate_id)
    {
        $this->model->where([['evaluate_id', '=', $evaluate_id], ['site_id', '=', $this->site_id]])->update(['is_audit' => EvaluateDict::AUDIT_REFUSE]);
        return true;
    }

    /**
     * 评价回复
     * @param $evaluate_id
     * @param $data
     * @return bool
     */
    public function reply($evaluate_id, $data)
    {
        $this->model->where([['evaluate_id', '=', $evaluate_id], ['site_id', '=', $this->site_id]])->update($data);
        return true;
    }

    /**
     * 置顶
     * @param $evaluate_id
     * @return bool
     */
    public function topping($evaluate_id)
    {
        $data = [
            'topping' => 1,
            'update_time' => time()
        ];
        $this->model->where([['evaluate_id', '=', $evaluate_id], ['site_id', '=', $this->site_id]])->update($data);
        return true;
    }

    /**
     * 取消置顶
     */
    public function cancelTopping($evaluate_id)
    {
        $data = [
            'topping' => 0,
            'update_time' => 0
        ];
        $this->model->where([['evaluate_id', '=', $evaluate_id], ['site_id', '=', $this->site_id]])->update($data);
        return true;
    }
}
