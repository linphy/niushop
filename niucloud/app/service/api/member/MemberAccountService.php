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

namespace app\service\api\member;

use app\dict\member\MemberAccountTypeDict;
use app\model\member\Member;
use app\model\member\MemberAccountLog;
use core\base\BaseApiService;
use think\db\exception\DbException;

/**
 * 会员账户流水服务层（会员个人账户通过会员服务层查询）
 * Class MemberAccountService
 * @package app\service\admin\member
 */
class MemberAccountService extends BaseApiService
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new MemberAccountLog();
    }

    /**
     * 会员账户流水列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $where['member_id'] = $this->member_id;
        $field = 'id, member_id, account_type, account_data, from_type, related_id, create_time, memo';
        $search_model = $this->model->where([['id', '>', 0]])->withSearch(['member_id','account_type', 'from_type', 'create_time','account_data_gt', 'account_data_lt'],$where)->field($field)->order('create_time desc')->append(['from_type_name', 'account_type_name']);
        return $this->pageQuery($search_model);
    }

    /**
     * 会员余额流水列表(新)
     * @param array $where
     * @return array
     */
    public function getPages(array $data = [])
    {

        switch ($data['from_type']){
            case 'income':
                $type_where = [
                    ['account_type', 'in', [MemberAccountTypeDict::BALANCE,MemberAccountTypeDict::MONEY]],
                    ['account_data', '>',  0 ],
                    ['from_type', '<>', 'cash_out']
                ];
                break;
            case 'disburse':
                $type_where = [
                    ['account_type', 'in', [MemberAccountTypeDict::BALANCE,MemberAccountTypeDict::MONEY]],
                    ['account_data', '<',  0 ],
                    ['from_type', '<>', 'cash_out']
                ];
                break;
            case 'cash_out':
                $type_where = [
                    ['account_type', '=', MemberAccountTypeDict::MONEY],
                    ['from_type', '=', $data['from_type']]
                ];
                break;

            default:
                $type_where = [
                    ['account_type', 'in', [MemberAccountTypeDict::BALANCE,MemberAccountTypeDict::MONEY]],
                ];
                break;
        }


        $where['member_id'] = $this->member_id;
        $field = 'id, member_id, account_type, account_data, account_sum, from_type, related_id, create_time, memo';
        $search_model = $this->model->where([['id', '>', 0]])->where($type_where)->withSearch(['member_id', 'create_time'],$where)->field($field)->order('create_time desc')->append(['from_type_name', 'account_type_name']);
        return $this->pageQuery($search_model);
    }

    /**
     * 账户流水详情
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'id, member_id, account_type, account_data, from_type, related_id, create_time, memo';
        return $this->model->where([['id', '=', $id], ['member_id', '=', $this->member_id]])->field($field)->append(['from_type_name', 'account_type_name'])->findOrEmpty()->toArray();
    }

    /**
     * 会员账户统计数量
     * @param array $where
     * @return int
     * @throws DbException
     */
    public function getCount(array $where = []){
        $where['member_id'] = $this->member_id;

        return $this->model->where([['member_id', '>', 0]])->withSearch(['member_id','account_type', 'from_type', 'create_time'],$where)->count();
    }

    /**
     * 会员积分统计数量
     * @param array $where
     * @return int
     * @throws DbException
     */
    public function getPointCount(){
        $data = [
            'point' => 0,
            'point_get' => 0,
            'use'=> 0,//使用
        ];
        $info =  (new Member())->where([['member_id', '=', $this->member_id]])->field('point,point_get')->findOrEmpty()->toArray();
        $data['point'] = $info['point'] ?? 0;
        $data['point_get'] = $info['point_get'] ?? 0;
        $data['use'] = abs($this->model->where([
            ['member_id', '=', $this->member_id],
            ['account_type', '=', MemberAccountTypeDict::POINT],
            ['account_data', '<', 0]
        ])->sum('account_data'));

        return $data;
    }

}
