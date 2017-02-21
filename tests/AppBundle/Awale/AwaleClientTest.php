<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use AppBundle\Awale\AwaleClient;
use PHPUnit\Framework\TestCase;

class AwaleClientTest extends TestCase
{
    public function testNewGameShouldReturnExpectedBoardAndScore()
    {
        $mockedClient = $this->prophesize(Client::class);
        $mockedClient
            ->request('GET', 'http://awale.server.com/new')
            ->shouldBeCalled();

        $client = new AwaleClient($mockedClient->reveal(), 'http://awale.server.com');
        $client->getResponseNewGame();
    }

    public function testMovePostionShouldReturnExpectedBoard()
    {
        $message = [
            "json" => [
                "Position" => 1,
                "Board" => [4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4],
            ],
        ];

        $mockedClient = $this->prophesize(Client::class);
        $mockedClient
            ->request('POST', 'http://awale.server.com/move', $message)
            ->shouldBeCalled();

        $client = new AwaleClient($mockedClient->reveal(), 'http://awale.server.com');
        $client->getResponseMovePosition([4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4], 1);
    }
}
