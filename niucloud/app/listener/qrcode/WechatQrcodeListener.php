<?php

namespace app\listener\qrcode;

use app\listener\notice_template\BaseNoticeTemplate;
use app\service\core\weapp\CoreWeappService;

/**
 * 生成小程序二维码
 */
class WechatQrcodeListener extends BaseNoticeTemplate
{

    public function handle(array $params)
    {
        if ('wechat' == $params['channel'] || $params['channel'] == 'h5') {
            $page = $params['page'];
            $url = $params['url'];
            $data = $params['data'];
            $path = $params['filepath'];
            //生成二维码
            $url = $url.'/'.$page;
            if(!empty($data)){
                $scene = [];
                foreach($data as $v){
                    $scene[] = $v['key'].'='.$v['value'];
                }
                $url .= '?'.implode('&', $scene);
            }
            \core\util\QRcode::png($url, $path, QR_ECLEVEL_L, 4, 1);
            return $path;
        }
    }

}