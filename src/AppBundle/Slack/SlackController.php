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

       if($textCommand === "new") {
           $game = $this->awaleClient->getNewGame();
           $message = $this->gameSlackFormatter->getMessageForNewGame($channelId, $game);
           $this->slackClient->sendMessage($message);

           $this->gameRepository->addNewGame($userId, $game['Board'], $game['Score']);
           $this->gameRepository->flush();

           return new Response();
       }

       $currentBoard = $this->gameRepository->findBoardByUserId($userId);

       $game = $this->awaleClient->movePosition($currentBoard, $textCommand);
       $message = $this->gameSlackFormatter->getMessageForPosition($channelId, $game);
       $this->slackClient->sendMessage($message);

       $this->gameRepository->updateGameByUserId($userId, $game['IA']['Board'], $game['IA']['Score']);
       $this->gameRepository->flush();

       return new Response();
     }
}
