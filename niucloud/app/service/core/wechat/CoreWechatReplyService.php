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

namespace app\service\core\wechat;

use app\dict\channel\ReplyDict;
use app\dict\channel\WechatDict;
use app\model\wechat\WechatReply;
use core\base\BaseCoreService;
use core\exception\AdminException;
use EasyWeChat\Kernel\Messages\Text;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;


/**
 * 微信回复
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class CoreWechatReplyService extends BaseCoreService
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new WechatReply();
    }

    /**
     *关键字回复列表
     * @return array
     */
    public function getKeywordPage(array $data = [])
    {
        $where = [
            
            ['reply_type', '=', WechatDict::REPLY_KEYWORD]
        ];
        if (!empty($data['keyword'])) {
            $where[] = ['keyword', 'like', '%' . $data['keyword'] . '%'];
        }
        if (!empty($data['name'])) {
            $where[] = ['name', 'like', '%' . $data['name'] . '%'];
        }
        return $this->getPageList($this->model, $where, 'name,keyword,matching_type,content_type,status,sort,create_time', 'uid desc');
    }

    /**
     * 获取关键词回复信息
     * @param int $id
     * @return array
     */
    public function getKeywordInfo(int $id)
    {
        return $this->model->where([
                
                ['id', '=', $id],
                ['reply_type', '=', WechatDict::REPLY_KEYWORD]]
        )->findOrEmpty()->toArray();
    }

    /**
     * 通过关键词查询回复
     * @param string $keyword
     * @return void
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getKeywordInfoByKeyword(string $keyword)
    {
        $list = $this->model->where([
                
                ['keyword', 'like', '%' . $keyword . '%'],
                ['reply_type', '=', WechatDict::REPLY_KEYWORD]],
                ['status', '=', ReplyDict::STATUS_ON]
        )->order('sort asc')->select()->toArray();
        if (!empty($list)) {
            foreach ($list as $v) {
                $item_keyword = $v['keyword'];
                switch ($v['matching_type']) {
                    case ReplyDict::MATCHING_TYPE_FULL://全匹配
                        $item_keyword === $keyword && $reply_content = $item_keyword;
                        break;
                    case ReplyDict::MATCHING_TYPE_LIKE://模糊匹配
                        stripos($keyword, $item_keyword) !== false && $reply_content = $item_keyword;
                        break;
                }
                if (!empty($reply_content)) {
                    return $v;
                }
            }
        }
        return [];


    }

    /**
     * 新增关键词回复
     * @param string $data
     * @return true
     */
    public function addKeyword(string  $data)
    {
        $data['reply_type'] = WechatDict::REPLY_KEYWORD;
        $this->model->create($data);
        return true;
    }

    /**
     * 更新关键词回复
     * @param int $id
     * @param array $data
     * @return WechatReply
     */
    public function editKeyword(int $id, array $data)
    {
        $where = [
            
            ['id', '=', $id],
            ['reply_type', '=', WechatDict::REPLY_KEYWORD]
        ];
        return $this->model->where($where)->update($data);
    }

    /**
     * 删除关键词回复
     * @return void
     */
    public function delKeyword(int $id)
    {
        $where = array(
            
            ['id', '=', $id],
            ['reply_type', '=', WechatDict::REPLY_KEYWORD]
        );
        $reply = $this->find($where);
        if ($reply->isEmpty())
            throw new AdminException('KEYWORDS_NOT_EXIST');
        return $reply->delete();
    }

    /**
     *
     * @param array|string $where
     * @return WechatReply|array|mixed|Model
     */
    public function find(array|string $where)
    {
        return $this->model->where($where)->findOrEmpty();
    }


    /**
     * 获取默认回复
     * @return array
     */
    public function getDefault()
    {
        return $this->model->where([
                
                ['reply_type', '=', WechatDict::REPLY_DEFAULT]
            ]
        )->findOrEmpty()->toArray();
    }

    /**
     * 更新默认回复
     * @param array $data
     * @return void
     */
    public function editDefault(array $data)
    {
        $where = [
            
            ['reply_type', '=', WechatDict::REPLY_DEFAULT]
        ];
        $reply = $this->find($where);
        //如果不存在,则创建一条默认回复记录
        if ($reply->isEmpty()) {
            $data['reply_type'] = WechatDict::REPLY_DEFAULT;
            return $this->model->create($data);
        } else {
            return $reply->edit($data);
        }
    }


    /**
     * 获取关注回复
     * @return array
     */
    public function getSubscribe()
    {
        return $this->model->where([
                
                ['reply_type', '=', WechatDict::REPLY_DEFAULT]
            ]
        )->findOrEmpty()->toArray();
    }

    /**
     * 更新关注回复
     * @param array $data
     * @return void
     */
    public function editSubscribe(array $data)
    {
        $where = [
            
            ['reply_type', '=', WechatDict::REPLY_SUBSCRIBE]
        ];
        $reply = $this->find($where);
        //如果不存在,则创建一条关注回复记录
        if ($reply->isEmpty()) {
            $data['reply_type'] = WechatDict::REPLY_SUBSCRIBE;
            return $this->model->create($data);
        } else {
            return $reply->edit($data);
        }


    }

    /**
     * 回复
     * @param string $event
     * @param string $content
     * @return void
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function reply(string $event = '', string $content = '')
    {
        switch ($event) {
            case WechatDict::REPLY_SUBSCRIBE://关注回复
                $info = $this->getSubscribe();
                break;
            case WechatDict::REPLY_KEYWORD://关键词回复
                $info = $this->getKeywordInfoByKeyword($content);
                break;
        }
        //没有配置相关回复的话默认启用默认回复
        if(empty($info)){
            $info = $this->getDefault();
        }
        if(!empty($info)){
            //查询状态
            if ($info['status'] == ReplyDict::STATUS_ON) {
                switch($info['content_type']) {
                    case ReplyDict::CONTENT_TYPE_TEXT://文本
                        return CoreWechatService::text($info['content']);
                    case ReplyDict::CONTENT_TYPE_NEW://图文
                        //todo  转化为临时素材或永久素材
                        return CoreWechatService::news($info['content']);
                }
            }
        }
    }




}