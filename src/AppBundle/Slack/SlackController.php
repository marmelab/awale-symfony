<?php

namespace AppBundle\Slack;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Slack\SlackClient;
use AppBundle\Awale\AwaleClient;

use GuzzleHttp\Client;

/**
 * @Route(service="app.slack.controller")
 */
class SlackController extends Controller
{
    private $slackClient;
    private $awaleClient;

    public function __construct(SlackClient $slackClient, AwaleClient $awaleClient)
    {
        $this->slackClient = $slackClient;
        $this->awaleClient = $awaleClient;
    }

    /**
     * @Route("/webhook", name="webhook")
     */
     public function webhookAction(Request $request)
     {
       $channel_id = $request->request->get('channel_id');

       $content = $this->awaleClient->getNewGame();

       $message = array(
          "text" => implode("|", $content["Board"]),
          "channel" => $channel_id,
       );

       $this->slackClient->sendMessage($message);

       return new Response("");
     }
}
