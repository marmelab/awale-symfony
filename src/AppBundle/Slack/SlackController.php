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
 * @Route(service='app.slack.controller')
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
     * @Route('/webhook', name='webhook')
     */
     public function webhookAction(Request $request)
     {
       $channelId = $request->request->get('channel_id');
       $textCommand = $request->request->get('text');

       if($textCommand === 'new') {
           $response = $this->awaleClient->getNewGame();
       } else {
           $response = $this->awaleClient->movePosition($textCommand);
       }

       $content = json_decode($response->getBody()->getContents(), true);

       $message = [
          'text' =>  implode('|', $content['Board']),
          'channel' => $channelId,
          'attachments' => [
              [
                  'image_url' => 'http://www.espritjeu.com/upload/image/awale-p-image-47814-grande.jpg',
              ],
          ],
      ];

       $this->slackClient->sendMessage($message);

       return new Response();
     }
}
