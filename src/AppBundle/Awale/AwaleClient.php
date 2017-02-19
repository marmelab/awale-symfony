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

  public function movePosition($board, $position)
  {
      return $this->client->request('POST', '/move', [
          'json' => [
              'Position' => $position,
              'Board' => $board
          ],
      ]);
  }
}
