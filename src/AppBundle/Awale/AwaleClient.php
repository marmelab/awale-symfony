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
        return $this->client->request('GET', $this->urlServerAwale.'/new');
    }

    public function movePosition($position)
    {
        return $this->client->request('POST', $this->urlServerAwale.'/move', [
            'json' => [
                'Position' => $position,
                'Board' => array(4,4,4,4,4,4,4,4,4,4,4,4),
                'Ia' => "0",
            ],
        ]);
    }
}
