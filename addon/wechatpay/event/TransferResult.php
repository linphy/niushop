<?php
namespace addon\wechatpay\event;

use addon\wechatpay\model\Pay;
use app\model\member\Withdraw;

class TransferResult
{
    public function handle(array $params)
    {
        $withdraw_info = (new Withdraw())->getMemberWithdrawInfo([ ['id','=', $params['relate_id']] ], 'id,site_id,applet_type,withdraw_no')['data'];
        if (!empty($withdraw_info)) {
            (new Pay($withdraw_info['applet_type'], $withdraw_info['site_id']))->getTransferResult($withdraw_info);
        }
    }
}