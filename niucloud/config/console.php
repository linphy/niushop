<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------
return [
    // 指令定义
    'commands' => [

        'addon:install' => 'app\command\Addon\Install',
        'addon:uninstall' => 'app\command\Addon\Uninstall',
        'menu:refresh' => 'app\command\Menu',
        //消息队列 自定义命令
        'queue:work' => 'app\command\queue\Queue',
        'queue:restart' => 'app\command\queue\Queue',
        'queue:listen' => 'app\command\queue\Queue',

        //计划任务 自定义命令
        'cron:run' => 'app\command\schedule\Run',
        'cron:schedule' => 'app\command\schedule\Schedule',
    ],
];
