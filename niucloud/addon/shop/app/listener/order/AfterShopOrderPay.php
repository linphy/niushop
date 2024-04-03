<?php
declare (strict_types=1);

namespace addon\shop\app\listener\order;

use addon\shop\app\dict\order\OrderDict;
use addon\shop\app\dict\order\OrderLogDict;
use addon\shop\app\service\core\CoreStatService;
use addon\shop\app\service\core\order\CoreInvoiceService;
use addon\shop\app\service\core\order\CoreOrderLogService;
use app\service\core\notice\NoticeService;
use think\facade\Log;

class AfterShopOrderPay
{
    public function handle($data)
    {
        Log::write('订单AfterShopOrderPay' . json_encode($data));
        try {
            $order_data = $data['order_data'];
            //活动或会员购买赠送.....
            //发票改变状态........
            (new CoreInvoiceService())->open($order_data['invoice_id']);
            //商城专用统计
            CoreStatService::addStat(['sale_money' => $order_data['order_money']]);
            //日志
            $main_type = $data['main_type'] ?? OrderLogDict::MEMBER;
            $main_id = $data['main_id'] ?? $order_data['member_id'];
            (new CoreOrderLogService())->add([
                'order_id' => $order_data['order_id'],
                'status' => OrderDict::WAIT_DELIVERY,
                'main_type' => $main_type,
                'main_id' => $main_id,
                'type' => OrderDict::ORDER_PAY_ACTION,
                'content' => ''
            ]);

            //消息发送
            (new NoticeService())->send('shop_order_pay', ['order_id' => $order_data['order_id']]);
        } catch ( \Exception $e ) {
            Log::write('订单AfterShopOrderPay失败' . $e->getMessage() . $e->getFile() . $e->getLine());
        }
    }
}
