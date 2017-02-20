<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use AppBundle\Slack\SlackClient;

class SlackClientTest extends WebTestCase
{
    public function testSendMessageReturn200()
    {
        $mockedClient = $this->prophesize(Client::class);
        $mockedClient
            ->request('POST', '', ["json" => ["text" => "hello"]])
            ->shouldBeCalled();

        $client = new SlackClient($mockedClient->reveal(), '');
        $message = $client->sendMessage('hello');
    }
}
