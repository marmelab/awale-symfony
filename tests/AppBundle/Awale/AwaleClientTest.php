<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class AwaleClientTest extends WebTestCase
{
    public function testNewGameShouldReturn200()
    {
        $client = new Client([
            'base_uri' => 'go:8080'
        ]);
        $response = $client->request('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
