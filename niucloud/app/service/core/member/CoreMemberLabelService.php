<?php
// +----------------------------------------------------------------------
// | Niucloud-admin 企业快速开发的saas管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud-admin.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace app\service\core\member;

use app\model\member\MemberLabel;
use core\base\BaseCoreService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Cache;

/**
 * 会员标签服务层
 * Class CoreMemberAccountService
 * @package app\service\core\member
 */
class CoreMemberLabelService extends BaseCoreService
{
    protected static $cache_tag_name = 'member_label_cache';
    public function __construct()
    {
        parent::__construct();
        $this->model = new MemberLabel();
    }

    /**
     * 通过标签id获取标签列表
     * @param array $label_ids
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getMemberLabelListByLabelIds(array $label_ids){
        sort($label_ids);
        $cache_name = __METHOD__ . md5(implode("_", $label_ids));
        return cache_remember(
            $cache_name,
            function () use ($label_ids) {
                return array_keys_search($this->getAll(), $label_ids, 'label_id');
            },
            self::$cache_tag_name
        );
    }

    /**
     * 获取全部会员标签

     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAll(){
        $cache_name = __METHOD__ ;
        return cache_remember(
            $cache_name,
            function () {
                $field = 'label_id, label_name';
                return $this->model->field($field)->select()->toArray();

            },
            self::$cache_tag_name
        );
    }

    /**
     * 清理站点会员标签缓存
     * @return true
     */
    public function clearCache(){
        Cache::tag(self::$cache_tag_name)->clear();
        return true;
    }
}
