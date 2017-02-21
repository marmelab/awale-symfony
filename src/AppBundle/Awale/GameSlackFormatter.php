<?php

namespace AppBundle\Awale;

use AppBundle\Awale\BoardImageConverter;

class GameSlackFormatter
{

    private $boardImage;

    public function __construct(BoardImageConverter $boardImage)
    {
        $this->boardImage = $boardImage;
    }

    public function getMessageForNewGame($channel_id, $game)
    {
        $url = $this->boardImage->pngGameBoard($game['Board']);

        $message = [
           'text' => 'Score: ' . $game['Score'][0] . ' - ' . $game['Score'][1],
           'channel' => $channel_id,
           'attachments' => [
               [
                   'image_url' => $url,
               ],
           ],
       ];

       return $message;
    }

    public function getMessageForPosition($channel_id, $game)
    {
        $gamePlayer = $game['Player'];
        $gameIA = $game['IA'];

        $urlBoardPlayer = $this->boardImage->pngGameBoard($gamePlayer['Board']);
        $urlBoardIA = $this->boardImage->pngGameBoard($gameIA['Board']);

        $message = [
           'text' => 'Score: ' . $gameIA['Score'][0] . ' - ' . $gameIA['Score'][1],
           'channel' => $channel_id,
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
