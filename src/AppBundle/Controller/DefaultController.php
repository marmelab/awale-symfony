<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use GuzzleHttp\Client;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/hello", name="hello")
     */
     public function helloAction(Request $request)
     {

       $slack_webhook_url = "https://hooks.slack.com/services/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";
       //
       $token = $request->request->get('token');
       $command = $request->request->get('command');
       $text = $request->request->get('text');
       $channel_id = $request->request->get('channel_id');
       $response_url = $request->request->get('response_url');

       $client = new Client([
            'base_uri' => 'go:8080'
        ]);
        $response = $client->request('GET', '/');
        $contents = (string) $response->getBody();

        $message = array(
          "text" => $contents,
          "channel" => $channel_id,
        );

        $c = curl_init($slack_webhook_url);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($message));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $result = curl_exec($c);
        curl_close($c);

        return new Response(json_decode($result));
     }
}
