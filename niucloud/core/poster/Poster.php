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
namespace core\poster;

use Grafika\Color;
use Grafika\Grafika;


class Poster extends BasePoster
{

    /**
     * @param array $config
     * @return void
     */
    protected function initialize(array $config = [])
    {
        parent::initialize($config);
    }

    /**
     * 创建海报
     * @param array $poster_data
     * @param string $dir
     * @param string $file_path
     * @return mixed|string
     * @throws \Exception
     */
    public function createPoster(array $poster_data, string $dir, string $file_path)
    {
        $bg_type = $poster_data[ 'global' ][ 'bgType' ];
        $editor = Grafika::createEditor();
        if ($bg_type == 'url' && !empty($poster_data[ 'global' ][ 'bgUrl' ])) {
            $editor->open($bg_image, $poster_data[ 'global' ][ 'bgUrl' ]);
            $editor->resizeFill($bg_image, $poster_data[ 'global' ][ 'width' ], $poster_data[ 'global' ][ 'height' ]);
        } else {
            $bg_image = Grafika::createBlankImage($poster_data[ 'global' ][ 'width' ], $poster_data[ 'global' ][ 'height' ]);
            //填充背景色
            $editor->fill($bg_image, new Color($poster_data[ 'global' ][ 'bgColor' ]));
        }
        foreach ($poster_data[ 'value' ] as $k => $v) {
            $type = $v[ 'type' ];
            switch ($type) {
                case 'text':
                    $default_font = 'static' . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR . 'SourceHanSansCN-Regular.ttf';
                    $editor->text($bg_image, $v[ 'value' ], round($v[ 'fontSize' ]*(4/3)), round($v[ 'x' ] * 2), round($v[ 'y' ] * 2), new Color($v[ 'fontColor' ]), $v[ 'fontFamily' ] ? : $default_font, $v[ 'angle' ]);
                    break;
                case 'image':
                    $image_name = 'image' . $k;
                    $$image_name = null;
                    if (is_file($v[ 'value' ])) {
                        $editor->open($$image_name, $v[ 'value' ]);
                        $editor->resizeFill($$image_name, $v[ 'width' ] * 2, $v[ 'height' ] * 2);
                        $editor->blend($bg_image, $$image_name, 'normal', 0, 'top-left', $v[ 'x' ] * 2, $v[ 'y' ] * 2);
                    }
                    break;
                case 'draw':
                    $draw_name = 'draw' . $k;
                    $$draw_name = Grafika::createDrawingObject($v[ 'drawType' ], $v[ 'points' ], 1, NULL, new Color($v[ 'bgColor' ]));
                    // 在图像上绘制上面创建的绘制对象
                    $editor->draw($bg_image, $$draw_name);
                    break;
            }
        }
        $editor->save($bg_image, $dir . '/' . $file_path);
        return $dir . '/' . $file_path;
    }

}
