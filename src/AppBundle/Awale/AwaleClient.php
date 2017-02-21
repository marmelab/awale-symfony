<?php

namespace AppBundle\Awale;

use GuzzleHttp\Client;

class AwaleClient
{
    private $client;
    private $urlServerAwale;

    public function __construct(Client $client, $urlServerAwale)
    {
        $this->client = $client;
        $this->urlServerAwale = $urlServerAwale;
    }

    public function getResponseNewGame()
    {
        return $this->client->request('GET', $this->urlServerAwale.'/new');
    }

    public function getNewGame()
    {
        return json_decode($this->getResponseNewGame()->getBody()->getContents(), true);
    }

    public function getResponseMovePosition($board, $position)
    {
        return $this->client->request('POST', $this->urlServerAwale.'/move', [
            'json' => [
                'Position' => $position,
                'Board' => $board,
            ],
        ]);
    }

    public function movePosition($board, $position)
    {
        return json_decode($this->getResponseNewGame($board, $position)->getBody()->getContents(), true);
    }
}
