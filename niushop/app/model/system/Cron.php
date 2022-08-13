<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace app\model\system;

use app\model\BaseModel;
use think\facade\Log;
use think\facade\Queue;

/**
 * 计划任务管理
 * @author Administrator
 *
 */
class Cron extends BaseModel
{

    /**
     * 添加计划任务
     * @param int $type 任务类型  1.固定任务 2.循环任务
     * @param int $period 执行周期
     * @param string $name 任务名称
     * @param string $event 执行事件
     * @param int $execute_time 待执行时间
     * @param int $relate_id 关联id
     * @param int $period_type 周期类型
     */
    public function addCron($type, $period, $name, $event, $execute_time, $relate_id, $period_type = 0)
    {
        $data = [
            'type' => $type,
            'period' => $period,
            'period_type' => $period_type,
            'name' => $name,
            'event' => $event,
            'execute_time' => $execute_time,
            'relate_id' => $relate_id,
            'create_time' => time()
        ];
        $res = model('cron')->add($data);
        return $this->success($res);
    }

    /**
     * 删除计划任务
     * @param $condition
     * @return array
     */
    public function deleteCron($condition)
    {
        $res = model('cron')->delete($condition);
        return $this->success($res);
    }

    /**
     * 执行任务
     */
    public function execute()
    {

        $system_config_model = new SystemConfig();
        $config = $system_config_model->getSystemConfig()[ 'data' ] ?? [];
        $is_open_queue = $config[ 'is_open_queue' ] ?? 0;
        $query_execute_time = $is_open_queue == 1 ? time() + 60 : time();
        $list = model('cron')->getList([ [ 'execute_time', '<=', $query_execute_time ] ]);


        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $event_res = checkQueue($v, function($params) {
                    //加入消息队列
                    $job_handler_classname = 'Cronexecute';
                    try {
                        if ($params[ 'execute_time' ] <= time()) {
                            Queue::push($job_handler_classname, $params);
                        } else {
                            Queue::later($params[ 'execute_time' ] - time(), $job_handler_classname, $params);
                        }
                    } catch (\Exception $e) {
                        $res = $this->error($e->getMessage());
                    }
                    return $res ?? $this->success();
                }, function($params) {
                    try {
                        $res = event($params[ 'event' ], [ 'relate_id' => $params[ 'relate_id' ] ]);
                    } catch (\Exception $e) {
                        $res = $this->error($e->getMessage());
                    }
                    $data_log = [
                        'name' => $params[ 'name' ],
                        'event' => $params[ 'event' ],
                        'relate_id' => $params[ 'relate_id' ],
                        'message' => json_encode($res)
                    ];
                    $this->addCronLog($data_log);
                    return $res;
                });
                $event_code = $event_res[ 'code' ] ?? 0;
                if ($event_code < 0) {
                    Log::write('自动任务888');
                    Log::write($event_res);
                    continue;
                }

                //循环任务
                if ($v[ 'type' ] == 2) {
                    $period = $v[ 'period' ] == 0 ? 1 : $v[ 'period' ];
                    switch ( $v[ 'period_type' ] ) {
                        case 0://分

                            $execute_time = $v[ 'execute_time' ] + $period * 60;
                            break;
                        case 1://天

                            $execute_time = strtotime('+' . $period . 'day', $v[ 'execute_time' ]);
                            break;
                        case 2://周

                            $execute_time = strtotime('+' . $period . 'week', $v[ 'execute_time' ]);
                            break;
                        case 3://月

                            $execute_time = strtotime('+' . $period . 'month', $v[ 'execute_time' ]);
                            break;
                    }
                    model('cron')->update([ 'execute_time' => $execute_time ], [ [ 'id', '=', $v[ 'id' ] ] ]);

                } else {
                    model('cron')->delete([ [ 'id', '=', $v[ 'id' ] ] ]);
                }
            }
        }


//        $list = model('cron')->getList([['execute_time', '<=', time()]]);
//        if (!empty($list)) {
//            foreach ($list as $k => $v) {
//                try {
//                    $res = event($v['event'], ['relate_id' => $v['relate_id']]);
//                } catch (\Exception $e) {
//                    $res = $this->error($e->getMessage());
//                }
//
//                $data_log = [
//                    'name'         => $v['name'],
//                    'event'        => $v['event'],
//                    'execute_time' => time(),
//                    'relate_id'    => $v['relate_id'],
//                    'message'      => json_encode($res)
//                ];
//                //model('cron_log')->add($data_log);
//                //循环任务
//                if ($v['type'] == 2) {
//                    $period = $v['period'] == 0 ? 1 : $v['period'];
//                    switch ($v['period_type']) {
//                        case 0://分
//
//                            $execute_time = $v['execute_time'] + $period * 60;
//                            break;
//                        case 1://天
//
//                            $execute_time = strtotime('+' . $period . 'day', $v['execute_time']);
//                            break;
//                        case 2://周
//
//                            $execute_time = strtotime('+' . $period . 'week', $v['execute_time']);
//                            break;
//                        case 3://月
//
//                            $execute_time = strtotime('+' . $period . 'month', $v['execute_time']);
//                            break;
//                    }
//                    model('cron')->update(['execute_time' => $execute_time], [['id', '=', $v['id']]]);
//
//                } else {
//                    model('cron')->delete([['id', '=', $v['id']]]);
//                }
//            }
//        }

    }

    /**
     * 添加自动任务日志
     * @param $data
     * @return array
     */
    public function addCronLog($data)
    {
        $data[ 'execute_time' ] = time();

        model('cron_log')->add($data);
        return $this->success();
    }
}