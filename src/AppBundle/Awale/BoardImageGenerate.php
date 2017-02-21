<?php

namespace AppBundle\Awale;

use Intervention\Image\ImageManagerStatic as Image;

class BoardImageGenerate
{
    private $assetsBaseUrl;
    private $assetsBasePathForSave;

    public function __construct($assetsBaseUrl, $assetsBasePathForSave)
    {
        $this->assetsBaseUrl = $assetsBaseUrl;
        $this->assetsBasePathForSave = $assetsBasePathForSave;
    }

    public function saveBoardAsPng($board)
    {
        $name = md5(implode("", $board)).'.png';
        $path = $this->assetsBasePathForSave . $name;

        if(!file_exists($path)) {
            $img = $this->generateBoardImage($board);
            $img->encode('png');
            $img->save($path);
        }

        return $this->assetsBaseUrl . $name;
    }

    private function generateBoardImage($board)
    {
        Image::configure(array('driver' => 'gd'));
        $img = Image::canvas(400, 370, '#0BAC9F');
        $img->rectangle(10, 100, 390, 270, function ($draw){
            $draw->background('#f39c12');
        });

        $arrtop = array_reverse(array_slice($board, 6, 11));
        foreach($arrtop as $key=>$row)
        {
            $width = $key * 60;
            $img->circle(50, 50 + $width, 150, function ($draw){
                $draw->background('#d35400');
            });

            $img->text(str_pad($row, 2, ' ', STR_PAD_LEFT), 35 + $width, 160, function($font){
                $font->size(30);
                $font->file(dirname(__FILE__) . '/../Resources/public/font/arial.ttf');
                $font->color('#f1c40f');
            });
        }

        $arrbottom = array_slice($board, 0, 6);
        foreach($arrbottom as $key=>$row)
        {
            $width = $key * 60;
            $img->circle(50, 50 + $width, 220, function ($draw){
                $draw->background('#d35400');
            });

            $img->text(str_pad($row, 2, ' ', STR_PAD_LEFT), 35 + $width, 230, function($font){
                $font->size(30);
                $font->file(dirname(__FILE__) . '/../Resources/public/font/arial.ttf');
                $font->color('#f1c40f');
            });
        }

        return $img;
    }

}
