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
        $response = $client->request('GET', '/new');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testMovePostionShouldReturn200()
    {
        $client = new Client([
            'base_uri' => 'go:8080'
        ]);
        $response = $client->request('POST', '/move', [
            'json' => [
                'Position' => "1",
                'Board' => array(4,4,4,4,4,4,4,4,4,4,4,4),
                'Ia' => "0",
            ],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
