<?php

namespace AppBundle\Awale;

use AppBundle\Awale\BoardImageGenerate;

class GameSlackFormatter
{
    private $imageGenerator;

    public function __construct(BoardImageGenerate $imageGenerator)
    {
        $this->imageGenerator = $imageGenerator;
    }

    public function getMessageForNewGame($channelId, $game)
    {
        $url = $this->imageGenerator->saveBoardAsPng($game['Board']);

        $message = [
           'text' => 'Score: ' . $game['Score'][0] . ' - ' . $game['Score'][1],
           'channel' => $channelId,
           'attachments' => [
               [
                   'image_url' => $url,
               ],
           ],
       ];

       return $message;
    }

    public function getMessageForPosition($channelId, $game)
    {
        $gamePlayer = $game['Player'];
        $gameIA = $game['IA'];

        $urlBoardPlayer = $this->imageGenerator->saveBoardAsPng($gamePlayer['Board']);
        $urlBoardIA = $this->imageGenerator->saveBoardAsPng($gameIA['Board']);

        $message = [
           'text' => 'Score: ' . $gameIA['Score'][0] . ' - ' . $gameIA['Score'][1],
           'channel' => $channelId,
           'attachments' => [
               [
                   'image_url' => $urlBoardPlayer,
               ],
               [
                   'image_url' => $urlBoardIA,
               ],
           ],
       ];

       return $message;
    }
}
