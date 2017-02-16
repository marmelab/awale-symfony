<?php
namespace AppBundle\Slack;

class SlackClient
{

  const ENDPOINT = "https://hooks.slack.com/services/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";

  public function sendMessage($message)
  {
    $c = curl_init(self::ENDPOINT);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($message));
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    $result = curl_exec($c);
    curl_close($c);
    return $result;
  }
}
