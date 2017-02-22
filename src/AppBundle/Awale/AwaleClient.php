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

    public function getNewGame()
    {
        $response = $this->client->request('GET', $this->urlServerAwale.'/new');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function movePosition($board, $position)
    {
        $response = $this->client->request('POST', $this->urlServerAwale.'/move', [
            'json' => [
                'Position' => $position,
                'Board' => $board,
            ],
        ]);
        
        return json_decode($response->getBody()->getContents(), true);
    }
}
