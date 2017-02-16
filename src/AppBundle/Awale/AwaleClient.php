<?php

namespace AppBundle\Awale;

use GuzzleHttp\Client;

class AwaleClient
{
  private $client;

  public function __construct()
  {
    $this->client = new Client([
         'base_uri' => 'go:8080'
     ]);
  }

  public function getHelloWorld()
  {
     $response = $this->client->request('GET', '/');
     return (string) $response->getBody();
  }

}
