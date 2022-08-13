<?php
// 事件定义文件
return [
    'bind' => [

    ],

    'listen' => [
        // 自定义模板信息
        'showDiyTemplate' => [
            'addon\diy_default2\event\TemplateInfo',
        ],
        // 使用自定义模板
        'useDiyTemplate' => [
            'addon\diy_default2\event\UseTemplate',
        ],
    ],

    'subscribe' => [
    ],
];
