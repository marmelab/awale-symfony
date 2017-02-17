<?php
namespace AppBundle\Slack;

use GuzzleHttp\Client;

class SlackClient
{
    const ENDPOINT = "https://hooks.slack.com/services/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";

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendMessage($message)
    {
        $message = is_string($message) ? ['text' => $message] : $message;
        $response = $this->client->request('POST', self::ENDPOINT, [
            'json' => $message
        ]);
    }
}
