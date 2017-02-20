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
        if($response === null) {
            return null;
        }
        return json_decode($response->getBody(), true);
    }

    public function movePosition($position)
    {
        $response = $this->client->request('POST', $this->urlServerAwale.'/move', [
            'json' => [
                'Position' => $position,
                'Board' => array(4,4,4,4,4,4,4,4,4,4,4,4),
                'Ia' => "0",
            ],
        ]);
        if($response === null) {
            return null;
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}
