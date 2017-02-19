<?php

namespace AppBundle\Slack;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Slack\SlackClient;
use AppBundle\Awale\AwaleClient;
use AppBundle\Awale\AwaleManager;
use Symfony\Component\HttpFoundation\Session\Session;

use GuzzleHttp\Client;

/**
 * @Route(service="app.slack.controller")
 */
class SlackController extends Controller
{
    private $slackClient;
    private $awaleClient;
    private $awaleManager;
    private $session;

    public function __construct(SlackClient $slackClient, AwaleClient $awaleClient, AwaleManager $awaleManager, Session $session)
    {
        $this->slackClient = $slackClient;
        $this->awaleClient = $awaleClient;
        $this->awaleManager = $awaleManager;
        $this->session = $session;
    }

    /**
     * @Route("/webhook", name="webhook")
     */
     public function webhookAction(Request $request)
     {
       $user_id = $request->request->get('user_id');
       $channel_id = $request->request->get('channel_id');
       $textCommand = $request->request->get('text');

       if($textCommand === "new")
       {
           $response = $this->awaleClient->getNewGame();
           $game = json_decode($response->getBody()->getContents(), true);
           $message = $this->awaleManager->getMessageForNewGame($channel_id, $game);
           $this->slackClient->sendMessage($message);

           $this->session->set($user_id, $game);
           return new Response("");
       }

       $currentBoard = $this->session->get($user_id)['Board'];

       $response = $this->awaleClient->movePosition($currentBoard, $textCommand);
       $game = json_decode($response->getBody()->getContents(), true);
       $message = $this->awaleManager->getMessageForPosition($channel_id, $game);
       $this->slackClient->sendMessage($message);

       return new Response();
     }
}
