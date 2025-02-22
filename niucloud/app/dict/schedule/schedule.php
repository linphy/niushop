<?php

return [
    [
        'key' => 'order_close',
        'name' => '未支付订单自动关闭',
        'desc' => '',
        'time' => [
            'type' => 'min',
            'min' => 1
        ],
        'class' => '',
        'function' => ''
    ],
    [
        'key' => 'transfer_check_finish',
        'name' => '检验在线转账是否处理完毕',
        'desc' => '',
        'time' => [
            'type' => 'min',
            'min' => 5
        ],
        'class' => 'app\job\transfer\schedule\CheckFinish',
        'function' => ''
    ]
];
