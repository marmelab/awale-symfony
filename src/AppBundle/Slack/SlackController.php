<?php

namespace AppBundle\Slack;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Slack\SlackClient;
use AppBundle\Awale\AwaleClient;
use AppBundle\Awale\AwaleManager;

use GuzzleHttp\Client;

/**
 * @Route(service="app.slack.controller")
 */
class SlackController extends Controller
{
    private $slackClient;
    private $awaleClient;
    private $awaleManager;

    public function __construct(SlackClient $slackClient, AwaleClient $awaleClient, AwaleManager $awaleManager)
    {
        $this->slackClient = $slackClient;
        $this->awaleClient = $awaleClient;
        $this->awaleManager = $awaleManager;
    }

    /**
     * @Route("/webhook", name="webhook")
     */
     public function webhookAction(Request $request)
     {
       $user_id = $request->request->get('user_id');
       $channel_id = $request->request->get('channel_id');
       $textCommand = $request->request->get('text');

       if($textCommand === 'new') {
           $response = $this->awaleClient->getNewGame();
       } else {
           $response = $this->awaleClient->movePosition($textCommand);
       }

       $content = json_decode($response->getBody()->getContents(), true);

       $url = $this->awaleManager->pngGameBoard($content["Board"]);

       $message = [
          "text" =>  implode("|", $content["Board"]),
          "channel" => $channel_id,
          "attachments" => array(
              array(
                  "image_url" => $url,
              )
          )
      ];

       $this->slackClient->sendMessage($message);

       return new Response();
     }
}
