<?php
namespace AppBundle\Slack;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SlackClient
{
    private $client;
    private $key;

    public function __construct(Client $client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    public function sendMessage($message)
    {
        $message = is_string($message) ? ['text' => $message] : $message;
        $response = $this->client->request('POST', $this->key, [
            'json' => $message
        ]);
    }
}
