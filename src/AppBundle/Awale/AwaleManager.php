<?php

namespace AppBundle\Awale;

use Intervention\Image\ImageManagerStatic as Image;

class AwaleManager
{

    private $urlImage;

    public function __construct($urlImage)
    {
        $this->urlImage = $urlImage;
    }

    public function getMessageForNewGame($channel_id, $game)
    {
        $url = $this->pngGameBoard($game["Board"]);

        $message = [
           "text" => 'Score: ' . $game["Score"][0] . ' - ' . $game["Score"][1],
           "channel" => $channel_id,
           "attachments" => array(
               array(
                   "image_url" => $url,
               )
           )
       ];

       return $message;
    }

    public function getMessageForPosition($channel_id, $game)
    {
        $gamePlayer = $game["Player"];
        $gameIA = $game["IA"];

        $urlBoardPlayer = $this->pngGameBoard($gamePlayer["Board"]);
        $urlBoardIA = $this->pngGameBoard($gameIA["Board"]);

        $message = [
           "text" => 'Score: ' . $gameIA["Score"][0] . ' - ' . $gameIA["Score"][1],
           "channel" => $channel_id,
           "attachments" => array(
               array(
                   "image_url" => $urlBoardPlayer,
               ),
               array(
                   "image_url" => $urlBoardIA,
               )
           )
       ];

       return $message;
    }

    private function pngGameBoard($board)
    {
        $name = uniqid() . '.png';
        $path = dirname(__FILE__) . '/../../../web/images/' . $name;

        $img = $this->buildBoardImage($board);
        $img->encode("png");
        $img->save($path);

        return $this->urlImage . $name;
    }

    private function buildBoardImage($board)
    {
        Image::configure(array('driver' => 'gd'));
        $img = Image::canvas(400, 370, '#0BAC9F');
        $img->rectangle(10, 100, 390, 270, function ($draw)
        {
            $draw->background('#f39c12');
        });

        $arrtop = array_reverse(array_slice($board, 6, 11));
        foreach($arrtop as $key=>$row)
        {
            $width = $key * 60;
            $img->circle(50, 50 + $width, 150, function ($draw)
            {
                $draw->background('#d35400');
            });

            $img->text(str_pad($row, 2, ' ', STR_PAD_LEFT), 35 + $width, 160, function($font)
            {
                $font->size(30);
                $font->file(dirname(__FILE__) . '/../Resources/public/font/arial.ttf');
                $font->color('#f1c40f');
            });
        }

        $arrbottom = array_slice($board, 0, 6);
        foreach($arrbottom as $key=>$row)
        {
            $width = $key * 60;
            $img->circle(50, 50 + $width, 220, function ($draw)
            {
                $draw->background('#d35400');
            });

            $img->text(str_pad($row, 2, ' ', STR_PAD_LEFT), 35 + $width, 230, function($font)
            {
                $font->size(30);
                $font->file(dirname(__FILE__) . '/../Resources/public/font/arial.ttf');
                $font->color('#f1c40f');
            });
        }

        return $img;
    }

}
