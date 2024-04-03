<?php
// +----------------------------------------------------------------------
// | Niucloud-admin 企业快速开发的多应用管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace app\model\sys;

use app\dict\sys\UserDict;
use core\base\BaseModel;
use think\model\concern\SoftDelete;
use think\model\relation\HasMany;

/**
 * 系统用户模型
 * Class SysUser
 * @package app\model\sys
 */
class SysUser extends BaseModel
{

    use SoftDelete;

    protected $type = [
        'last_time' => 'timestamp',
    ];
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'uid';

    /**
     * 模型名称
     * @var string
     */
    protected $name = 'sys_user';
    /**
     * 定义软删除标记字段
     * @var string
     */
    protected $deleteTime = 'delete_time';

    // 设置json类型字段
    protected $json = ['role_ids'];
    // 设置JSON数据返回数组
    protected $jsonAssoc = true;
    /**
     * 定义软删除字段的默认值
     * @var int
     */
    protected $defaultSoftDelete = 0;



    /**
     * 状态字段转化
     * @param $value
     * @param $data
     * @return mixed
     */
    public function getStatusNameAttr($value, $data)
    {
        if (empty($data['status'])) return '';
        return UserDict::getStatus()[$data['status']] ?? '';
    }

    public function getCreateTimeAttr($value, $data)
    {
        return $data['create_time'] ? get_date_by_time($data['create_time']) : '';
    }

    /**
     * 账号搜索器
     * @param $query
     * @param $value
     */
    public function searchUsernameAttr($query, $value)
    {
        if ($value) {
            $query->whereLike('username', '%' . $value . '%');
        }

    }

    /**
     * 用户实际姓名搜索器
     * @param $query
     * @param $value
     */
    public function searchRealnameAttr($query, $value)
    {
        if ($value) {
            $query->whereLike('real_name', '%' . $value . '%');
        }

    }

    /**
     * 角色组筛选
     * @param $query
     * @param $value
     * @return void
     */
    public function searchRoleIdsAttr($query, $value)
    {
        if ($value) {
            $query->whereLike('role_ids', '%' . $value . '%');
        }

    }

    /**
     * 是否删除搜索器
     * @param $query
     */
    public function searchIsDelAttr($query)
    {
        $query->where('is_del', 0);
    }

    /**
     * 状态搜索器
     * @param $query
     * @param $value
     */
    public function searchStatusAttr($query, $value)
    {
        $query->where('status', $value);
    }


    /**
     * 创建时间搜索器
     * @param $query
     * @param $value
     * @param $data
     */
    public function searchCreateTimeAttr($query, $value, $data)
    {
        $start_time = empty($value[0]) ? 0 : strtotime($value[0]);
        $end_time = empty($value[1]) ? 0 : strtotime($value[1]);
        if ($start_time > 0 && $end_time > 0) {
            $query->whereBetweenTime('sys_user.create_time', $start_time, $end_time);
        } else if ($start_time > 0 && $end_time == 0) {
            $query->where([['sys_user.create_time', '>=', $start_time]]);
        } else if ($start_time == 0 && $end_time > 0) {
            $query->where([['sys_user.create_time', '<=', $end_time]]);
        }
    }


}
