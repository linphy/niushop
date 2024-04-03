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

namespace app\service\admin\sys;

use app\dict\sys\RoleStatusDict;
use app\model\sys\SysMenu;
use app\model\sys\SysRole;
use app\model\sys\SysUser;
use core\base\BaseAdminService;
use core\exception\AdminException;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Cache;

/**
 * admin授权服务层
 * Class BaseService
 * @package app\service
 */
class RoleService extends BaseAdminService
{
    public static $cache_tag_name = 'role_cache';
    public function __construct()
    {
        parent::__construct();
        $this->model = new SysRole();
    }

    /**
     * 管理端获取角色列表
     * @param array $data
     * @return array
     */
    public function getPage(array $data)
    {
        $where = [];
        if(!empty($data['role_name'])) {
            $where[] = ['role_name', 'like', "%".$data['role_name']."%"];
        }
        $field = 'role_id,role_name,status,create_time';
        $search_model = $this->model->where($where)->field($field)->order('create_time desc')->append(['status_name']);
        return $this->pageQuery($search_model);
    }
    /**
     * 获取权限信息
     * @param int $role_id
     * @return array
     */
    public function getInfo(int $role_id){
        $info = $this->model->append(['status_name'])->findOrEmpty($role_id)->toArray();
        if(!empty($info)){
            $list = [];
            $addon_keys = $info['addon_keys'];
            $addon_keys[] = 'system';
            $rules = $info['rules'];
            $menus_list = (new SysMenu())->where([['menu_key', 'in', $rules]])->select()->toArray();

            foreach($menus_list as $key => $v){
                $addon = $v['addon'] ?: 'system';
                if(in_array($addon, $addon_keys))
                {
                    $list[$addon][$key] = $v['menu_key'];
                }
            }

            $role_rules['system'] = $list['system'];

            unset($list['system']);
            foreach ($addon_keys as $value)
            {
                if(isset($list[$value]))
                {
                    $list[$value] = array_values($list[$value]);
                }
            }
            $role_rules['addon'] = $list;
            $info['rules'] = $role_rules;
        }
        return $info;
    }

    /**
     * 获取站点下的所有权限
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAll()
    {
        $where = array(
            ['status', '=', 1]
        );
        return $this->model->where($where)->field('role_id,role_name,status,create_time')->select()->toArray();
    }

    /**
     * 新增权限
     * @param array $data
     * @return true
     */
    public function add(array $data){
        $data['create_time'] = time();
        $rules = $data['rules'];
        if(!isset($rules['addon']))
        {
            $addon = [];
        }else{
            $addon = $rules['addon'];
        }
        $add_list = [];
        $addon_rules = [];
        foreach ($addon as $key => $value)
        {
            $add_list[] = $key;
            $addon_rules[] = $value;
        }
        $addon_rules = array_reduce($addon_rules,'array_merge',[]);
        $data['rules'] = array_merge($rules['system'],$addon_rules);
        $data['addon_keys'] = $add_list;
        $this->model->save($data);
        Cache::tag(self::$cache_tag_name)->clear();
        return true;
    }

    /**
     * 更新权限
     * @param int $role_id
     * @param array $data
     * @return true
     */
    public function edit(int $role_id, array $data){
        $where = array(
            ['role_id', '=', $role_id],
        );
        $rules = $data['rules'];
        if(!isset($rules['addon']))
        {
            $addon = [];
        }else{
            $addon = $rules['addon'];
        }
        $add_list = [];
        $addon_rules = [];
        foreach ($addon as $key => $value)
        {
            $add_list[] = $key;
            $addon_rules[] = $value;
        }
        $addon_rules = array_reduce($addon_rules,'array_merge',[]);
        $data['rules'] = array_merge($rules['system'],$addon_rules);
        $data['addon_keys'] = $add_list;
        $data['update_time'] = time();
        $this->model->update($data, $where);
        Cache::tag(self::$cache_tag_name)->clear();
        return true;

    }

    /**
     * 获取模型对象
     * @param int $role_id
     * @return mixed
     */
    public function find(int $role_id){
        $where = array(
            ['role_id', '=', $role_id],
        );
        $role = $this->model->where($where)->findOrEmpty();
        if ($role->isEmpty())
            throw new AdminException('USER_ROLE_NOT_EXIST');
        return $role;
    }

    /**
     * 删除权限(saas应该不允许删除)
     * @param int $role_id
     * @return mixed
     * @throws DbException
     */
    public function del(int $role_id){
        $role = $this->find($role_id);
        if(SysUser::where([['role_ids', 'like',['%"'.$role_id.'"%']]])->count() > 0)
            throw new AdminException('USER_ROLE_NOT_ALLOW_DELETE');
        $res = $role->delete();
        Cache::tag(self::$cache_tag_name)->clear();
        return $res;

    }

    /**
     * 获取角色id为健名,角色名为键值的数据
     * @return mixed|string
     */
    public function getColumn(){
        $cache_name = 'role_column';
        return cache_remember(
            $cache_name,
            function() {
                return $this->model->column('role_name', 'role_id');
            },
            [MenuService::$cache_tag_name, self::$cache_tag_name]
        );
    }

    /**
     * 通过权限组id获取菜单id
     * @param array $role_ids
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getMenuKeysByRoleIds(array $role_ids){
        sort($role_ids);
        $cache_name = 'user_role_menu_keys_'.md5(implode('_', $role_ids));
        return cache_remember(
            $cache_name,
            function() use($role_ids) {
                $rules = $this->model->where([['role_id', 'IN', $role_ids], ['status', '=', RoleStatusDict::ON]])->field('rules')->select()->toArray();
                if(!empty($rules)){
                    $temp = [];
                    foreach($rules as $v){
                        $temp = array_merge($temp, $v['rules']);
                    }
                    $temp = array_unique($temp);

                    if(empty($temp)) return [];
                    return $temp;
                }
                return [];
            },
            [MenuService::$cache_tag_name, self::$cache_tag_name]
        );

    }


    /**
     * 获取应用keys
     * @param array $role_ids
     * @return mixed|string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAddonKeysByRoleIds(array $role_ids){
        sort($role_ids);
        $cache_name = 'user_role_addon_keys_'.md5(implode('_', $role_ids));
        return cache_remember(
            $cache_name,
            function() use($role_ids) {
                $rules = $this->model->where([['role_id', 'IN', $role_ids], ['status', '=', RoleStatusDict::ON]])->field('addon_keys')->select()->toArray();
                if(!empty($rules)){
                    $temp = [];
                    foreach($rules as $v){
                        $temp = array_merge($temp, $v['addon_keys']);
                    }
                    $temp = array_unique($temp);

                    if(empty($temp)) return [];
                    return $temp;
                }
                return [];
            },
            [MenuService::$cache_tag_name, self::$cache_tag_name]
        );

    }

    /**
     * 角色状态修改
     */
    public function setStatus(int $id, int $status)
    {
        $this->model->where([['role_id', '=', $id]])->update(['status' => $status]);
        return true;
    }
}
