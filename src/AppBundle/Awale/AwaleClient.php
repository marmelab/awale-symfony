<?php

namespace AppBundle\Awale;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

class AwaleClient
{
  private $client;

  public function __construct()
  {
    $this->client = new Client([
         'base_uri' => 'go:8080'
     ]);
  }

  public function getNewGame()
  {
     $response = $this->client->request('GET', '/new');
     return json_decode($response->getBody(), true);
  }

  public function getGame($position)
  {
      $response = $this->client->request('POST', '/move', [
          'headers' => ['Content-type' => 'application/json'],
          'json' => [
              'Position' => $position,
              'Board' => array(4,4,4,4,4,4,4,4,4,4,4,4),
              'Ia' => "0",
          ],
      ]);

      return json_decode($response->getBody()->getContents(), true);
  }
}
