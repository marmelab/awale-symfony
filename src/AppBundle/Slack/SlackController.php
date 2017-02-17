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
       $textCommand = $request->request->get('text');

       if($textCommand === "new")
       {
           $content = $this->awaleClient->getNewGame();
       }
       else {
           $content = $this->awaleClient->movePosition($textCommand);
       }

       $message = [
          "text" =>  implode("|", $content["Board"]),
          "channel" => $channel_id,
          "attachments" => array(
              array(
                  "image_url" => "http://www.espritjeu.com/upload/image/awale-p-image-47814-grande.jpg",
              )
          )
      ];

       $this->slackClient->sendMessage($message);

       return new Response("");
     }
}
