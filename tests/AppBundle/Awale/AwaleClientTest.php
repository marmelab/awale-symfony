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
        $request = new Request('GET', 'http://awale.server.com/new');

        $mockedClient = $this->prophesize(Client::class);
        $mockedClient
            ->request('GET', 'http://awale.server.com/new')
            ->willReturn($request)
            ->shouldBeCalled();

        $client = new AwaleClient($mockedClient->reveal(), 'http://awale.server.com');
        $client->getNewGame();
    }

    public function testMovePostionShouldReturnExpectedBoard()
    {
        $request = new Request('POST', 'http://awale.server.com/move');

        $message = [
            "json" => [
                "Position" => 1,
                "Board" => [4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4],
            ],
        ];

        $mockedClient = $this->prophesize(Client::class);
        $mockedClient
            ->request('POST', 'http://awale.server.com/move', $message)
            ->willReturn($request)
            ->shouldBeCalled();

        $client = new AwaleClient($mockedClient->reveal(), 'http://awale.server.com');
        $client->movePosition([4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4], 1);
    }
}
