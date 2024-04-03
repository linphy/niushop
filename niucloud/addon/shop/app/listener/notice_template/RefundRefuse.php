<?php
declare (strict_types = 1);

namespace addon\shop\app\listener\notice_template;

use addon\shop\app\service\core\refund\CoreRefundService;
use app\listener\notice_template\BaseNoticeTemplate;

/**
 * 退款申请拒绝通知
 */
class RefundRefuse extends BaseNoticeTemplate
{
    private $key = 'shop_refund_refuse';

    public function handle(array $params)
    {
        if ($this->key == $params['key']) {
            $refund = (new CoreRefundService())->getInfo($params['data']['order_refund_no']);
            if (!empty($refund)) {
                return $this->toReturn(
                    [
                        'order_refund_no' => $refund['order_refund_no'],
                        'apply_money' => $refund['apply_money']
                    ],
                    [
                        'member_id' => $refund['member_id']
                    ]
                );
            }
        }
    }
}
