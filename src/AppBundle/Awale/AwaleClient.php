<?php

namespace AppBundle\Awale;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

class AwaleClient extends \GuzzleHttp\Client
{
  const baseUri = 'go:8080';

  public function getNewGame()
  {
     $response = $this->request('GET', self::baseUri . '/new');
     return json_decode($response->getBody(), true);
  }

  public function movePosition($position)
  {
      $response = $this->request('POST', self::baseUri . '/move', [
          'json' => [
              'Position' => $position,
              'Board' => array(4,4,4,4,4,4,4,4,4,4,4,4),
              'Ia' => "0",
          ],
      ]);

      return json_decode($response->getBody()->getContents(), true);
  }
}
