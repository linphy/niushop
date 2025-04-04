<?php
declare (strict_types = 1);

namespace addon\shop\app\listener\notice_template;

use addon\shop\app\service\core\refund\CoreRefundService;
use app\listener\notice_template\BaseNoticeTemplate;

/**
 * 退款申请通过通知
 */
class RefundAgree extends BaseNoticeTemplate
{
    private $key = 'shop_refund_agree';

    public function handle(array $params)
    {
        if ($this->key == $params['key']) {
            $refund = (new CoreRefundService())->getInfo($params['data']['order_refund_no']);
            if (!empty($refund)) {
                return $this->toReturn(
                    [
                        'order_refund_no' => $refund['order_refund_no'],
                        'order_no' => $refund['order_main']['order_no'],
                        'refund_money' => $refund['apply_money'],
                        'result' => '已通过申请'
                    ],
                    [
                        'member_id' => $refund['member_id']
                    ]
                );
            }
        }
    }
}
