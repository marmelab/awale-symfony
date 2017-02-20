<?php
namespace AppBundle\Slack;

use GuzzleHttp\Client;

class SlackClient
{
    private $key;
    private $client;

    public function __construct(Client $client, $key)
    {
        $this->key = $key;
        $this->client = $client;
    }

    public function sendMessage($message)
    {
        $message = is_string($message) ? ['text' => $message] : $message;
        $response = $this->client->request('POST', $this->key, [
            'json' => $message
        ]);
    }
}
