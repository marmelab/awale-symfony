<?php

namespace AppBundle\Slack;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Slack\SlackClient;
use AppBundle\Awale\AwaleClient;
use AppBundle\Entity\GameRepository;
use AppBundle\Awale\GameSlackFormatter;

use GuzzleHttp\Client;

/**
 * @Route(service="app.slack.controller")
 */
class SlackController extends Controller
{
    private $slackClient;
    private $awaleClient;
    private $gameSlackFormatter;
    private $gameRepository;

    public function __construct(SlackClient $slackClient, AwaleClient $awaleClient, GameSlackFormatter $gameSlackFormatter, GameRepository $gameRepository)
    {
        $this->slackClient = $slackClient;
        $this->awaleClient = $awaleClient;
        $this->gameSlackFormatter = $gameSlackFormatter;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route("/webhook", name="webhook")
     */
     public function webhookAction(Request $request)
     {
       $userId= $request->request->get('user_id');
       $channelId = $request->request->get('channel_id');
       $textCommand = $request->request->get('text');

       $gameEntity = $this->gameRepository->findGameByUserId($userId);

       if($textCommand === "new") {
           if($gameEntity !== null) {
               return new Response("You already have a current game, you have /awale restart to restart a game");
           }

           $game = $this->SendMessageForNewGame($channelId);

           $this->gameRepository->addNewGame($userId, $game['Board'], $game['Score']);
           $this->gameRepository->flush();

           return new Response();

       } else if($textCommand === "restart") {
           if($gameEntity === null) {
               return new Response("You must run a /awale new");
           }

           $game = $this->SendMessageForNewGame($channelId);

           $gameEntity->setBoard($game['Board']);
           $gameEntity->setScore($game['Score']);
           $this->gameRepository->flush();

           return new Response();
       }

       if($gameEntity === null) {
           return new Response("You must run a /awale new");
       }

       $game = $this->awaleClient->movePosition($gameEntity->getBoard(), $textCommand);
       $message = $this->gameSlackFormatter->getMessageForPosition($channelId, $game);
       $this->slackClient->sendMessage($message);

       $gameEntity->setBoard($game['IA']['Board']);
       $gameEntity->setScore($game['IA']['Score']);
       $this->gameRepository->flush();

       return new Response();
     }

     private function SendMessageForNewGame($channelId)
     {
         $game = $this->awaleClient->getNewGame();
         $message = $this->gameSlackFormatter->getMessageForNewGame($channelId, $game);
         $this->slackClient->sendMessage($message);

         return $game;
     }
}
