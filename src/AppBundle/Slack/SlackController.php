<?php

namespace AppBundle\Slack;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Slack\SlackClient;
use AppBundle\Awale\AwaleClient;
use AppBundle\Awale\GameSlackFormatter;
use Symfony\Component\HttpFoundation\Session\Session;

use GuzzleHttp\Client;

/**
 * @Route(service="app.slack.controller")
 */
class SlackController extends Controller
{
    private $slackClient;
    private $awaleClient;
    private $gameSlackFormatter;

    public function __construct(SlackClient $slackClient, AwaleClient $awaleClient, GameSlackFormatter $gameSlackFormatter)
    {
        $this->slackClient = $slackClient;
        $this->awaleClient = $awaleClient;
        $this->gameSlackFormatter = $gameSlackFormatter;
    }

    /**
     * @Route("/webhook", name="webhook")
     */
     public function webhookAction(Request $request)
     {
       $userId= $request->request->get('user_id');
       $channelId = $request->request->get('channel_id');
       $textCommand = $request->request->get('text');

       $fileName = dirname(__FILE__) . '/../../../web/awale/' . $userId . '.json';

       if($textCommand === "new")
       {
           $game = $this->awaleClient->getNewGame();
           $message = $this->gameSlackFormatter->getMessageForNewGame($channelId, $game);
           $this->slackClient->sendMessage($message);

           file_put_contents($fileName, json_encode($game));
           return new Response();
       }

       $currentBoard = json_decode(file_get_contents($fileName), true)['Board'];

       $game = $this->awaleClient->movePosition($currentBoard, $textCommand);
       $message = $this->gameSlackFormatter->getMessageForPosition($channelId, $game);
       $this->slackClient->sendMessage($message);

       file_put_contents($fileName, json_encode($game['IA']));
       return new Response();
     }
}
