<?php

namespace addon\shop\app\upgrade\v630;

use app\model\sys\Poster;
use app\service\core\poster\CorePosterService;

class Upgrade
{

    public function handle()
    {
        $this->handleData();
    }

    /**
     * 处理商品数据
     */
    private function handleData()
    {

        $poster = new CorePosterService();
        $poster_model = new Poster();

        // 删除旧模板
        $poster_model->where([ [ 'addon', '=', 'shop' ] ])->delete();

        // 创建默认商品海报
        $template = $poster->getTemplateList('shop', 'shop_goods')[ 0 ];
        $poster->add('shop', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);

        // 创建默认积分商品海报
        $template = $poster->getTemplateList('shop', 'shop_point_goods')[ 0 ];
        $poster->add('shop', [
            'name' => $template[ 'name' ],
            'type' => $template[ 'type' ],
            'value' => $template[ 'data' ],
            'status' => 1,
            'is_default' => 1
        ]);

    }

}