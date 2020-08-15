<?php
/**
 * Index.php
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2015-2025 上海牛之云网络科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: http://www.niushop.com.cn

 * =========================================================
 * @author : niuteam
 * @date : 2015.1.17
 * @version : v1.0.0.0
 */

namespace app\api\controller;

use app\model\member\MemberAccount as MemberAccountModel;
use app\model\member\Member as MemberModel;

class Memberaccount extends BaseApi
{

    /**
     * 基础信息
     */
    public function info()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);
        $account_type = isset($this->params[ 'account_type' ]) ? $this->params[ 'account_type' ] : 'balance,balance_money'; //账户类型 余额:balance，积分:point

        if (!in_array($account_type, [ 'point', 'balance', 'balance,balance_money' ])) return $this->response($this->error('', 'INVALID_PARAMETER'));

        $member_model = new MemberModel();
        $info = $member_model->getMemberInfo([ [ 'member_id', '=', $token[ 'data' ][ 'member_id' ] ] ], $account_type);
        return $this->response($info);
    }

    /**
     * 列表信息
     */
    public function page()
    {
        $token = $this->checkToken();
        if ($token[ 'code' ] < 0) return $this->response($token);

        $page = isset($this->params[ 'page' ]) ? $this->params[ 'page' ] : 1;
        $page_size = isset($this->params[ 'page_size' ]) ? $this->params[ 'page_size' ] : PAGE_LIST_ROWS;
        $account_type = isset($this->params[ 'account_type' ]) ? $this->params[ 'account_type' ] : 'balance,balance_money';//账户类型 余额:balance，积分:point

        if (!in_array($account_type, [ 'point', 'balance', 'balance,balance_money' ])) return $this->response($this->error('', 'INVALID_PARAMETER'));

        $member_account_model = new MemberAccountModel();
        $list = $member_account_model->getMemberAccountPageList([ [ 'account_type', 'in', $account_type ], [ 'member_id', '=', $token[ 'data' ][ 'member_id' ] ] ], $page, $page_size);
        return $this->response($list);
    }

}