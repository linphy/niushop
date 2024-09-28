<?php

namespace addon\shop\app\upgrade\v631;

use app\model\diy\Diy;
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
        $diy_model = new Diy();
        $where = [
            [ 'value', '<>', '' ]
        ];
        $field = 'id,name,title,template,value';
        $list = $diy_model->where($where)->field($field)->select()->toArray();

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $diy_data = json_decode($v[ 'value' ], true);

                foreach ($diy_data[ 'value' ] as $ck => $cv) {
                    if ($cv[ 'componentName' ] == 'ShopMemberInfo') {
                        if (!isset($diy_data[ 'value' ][ $ck ][ 'isShowAccount' ])) {
                            $diy_data[ 'value' ][ $ck ][ 'isShowAccount' ] = true;
                        }

                    }
                }

                $diy_data = json_encode($diy_data);
                $diy_model->where([ [ 'id', '=', $v[ 'id' ] ] ])->update([ 'value' => $diy_data ]);
            }
        }

    }

}