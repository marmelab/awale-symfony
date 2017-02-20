<?php
namespace AppBundle\Slack;

use GuzzleHttp\Client;

class SlackClient extends \GuzzleHttp\Client
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function sendMessage($message)
    {
        $message = is_string($message) ? ['text' => $message] : $message;
        $response = $this->request('POST', $this->key, [
            'json' => $message
        ]);
    }
}
