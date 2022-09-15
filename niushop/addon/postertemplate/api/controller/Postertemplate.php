<?php
/**
 * Niushop商城系统 - 团队十年电商经验汇集巨献!
 * =========================================================
 * Copy right 2019-2029 杭州牛之云科技有限公司, 保留所有权利。
 * ----------------------------------------------
 * 官方网址: https://www.niushop.com
 * =========================================================
 */

namespace addon\postertemplate\api\controller;

use addon\postertemplate\model\PosterTemplate as PosterTemplateModel;
use app\api\controller\BaseApi;

/**
 * 海报模板 控制器
 */
class Postertemplate extends BaseApi
{

    /**
     * 海报模板列表
     * @return mixed
     */
    public function lists()
    {
        $page_index = input('page', 1);
        $page_size = input('page_size', PAGE_LIST_ROWS);
        $poster_template_model = new PosterTemplateModel();
        $res = $poster_template_model->getPosterTemplatePageList([ [ 'site_id', '=', $this->site_id ] ], $page_index, $page_size);
        return $res;
    }

    /**
     * 添加海报模板
     * @return mixed
     */
    public function addPosterTemplate()
    {
        if (request()->isAjax()) {

            //数据
            $data = [
                'poster_name' => input('poster_name', ''),
                'background' => input('background', ''),
                'qrcode_width' => input('qrcode_width', ''),
                'qrcode_height' => input('qrcode_height', ''),
                'qrcode_top' => input('qrcode_top', ''),
                'qrcode_left' => input('qrcode_left', ''),
                'template_type' => input('template_type', ''),
                'create_time' => time(),
                'site_id' => $this->site_id
            ];
            $input = input('param.');
            foreach ($input AS $k => $v) {
                if (!empty($v) && isset($this->goods_template[ $k ])) {
                    $this->goods_template[ $k ] = $v;
                }
            }
            $data[ 'template_json' ] = json_encode($this->goods_template, true);
            $poster_template_model = new PosterTemplateModel();
            $poster_data = $poster_template_model->addPosterTemplate($data);
            return $poster_data;
        }
    }

    /**
     * 删除海报模板
     * @return mixed
     */
    public function delPosterTemplate()
    {
        if (request()->isAjax()) {
            $template_ids = input('template_ids', '');
            $condition = [
                [ 'template_id', 'in', $template_ids ],
                [ 'site_id', '=', $this->site_id ]
            ];
            $poster_template_model = new PosterTemplateModel();
            $res = $poster_template_model->deletePosterTemplate($condition);
            return $res;
        }
    }

    /**
     * 获取海报模板详情
     * @return mixed
     */
    public function posterTemplateDetail()
    {
        if (request()->isAjax()) {
            $template_id = input('template_id', '');
            $condition = [
                [ 'template_id', '=', $template_id ],
                [ 'site_id', '=', $this->site_id ]
            ];
            $poster_template_model = new PosterTemplateModel();
            $res = $poster_template_model->getPosterTemplateInfo($condition);
            return $res;
        }
    }

    /**
     * 编辑海报模板
     * @return mixed
     */
    public function editPosterTemplate()
    {
        if (request()->isAjax()) {
            $template_id = input('template_id', '');
            //数据
            $data = [
                'poster_name' => input('poster_name', ''),
                'background' => input('background', ''),
                'qrcode_width' => input('qrcode_width', ''),
                'qrcode_height' => input('qrcode_height', ''),
                'qrcode_top' => input('qrcode_top', ''),
                'qrcode_left' => input('qrcode_left', ''),
                'template_type' => input('template_type', ''),
                'create_time' => time(),
                'site_id' => $this->site_id
            ];
            $condition = [
                [ 'template_id', '=', $template_id ],
                [ 'site_id', '=', $this->site_id ]
            ];
            $input = input('param.');
            foreach ($input AS $k => $v) {
                if (!empty($v) && isset($this->goods_template[ $k ])) {
                    $this->goods_template[ $k ] = $v;
                }
            }
            $data[ 'template_json' ] = json_decode($this->goods_template, true);
            $poster_template_model = new PosterTemplateModel();
            $poster_data = $poster_template_model->editPosterTemplate($data, $condition);
            return $poster_data;
        }
    }

}