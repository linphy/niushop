<?php
// 事件定义文件
return [
    'bind' => [

    ],

    'listen' => [
        // 自定义模板信息
        'ShowDiyTemplate' => [
            'addon\diy_default1\event\TemplateInfo',
        ],
        // 使用自定义模板
        'UseDiyTemplate' => [
            'addon\diy_default1\event\UseTemplate',
        ],
        // 扩展自定义图标库
        'DiyIcon' => [
            'addon\diy_default1\event\DiyIcon',
        ],
    ],

    'subscribe' => [
    ],
];
