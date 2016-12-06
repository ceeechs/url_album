<?php

/**
 * Webhookモジュール
 */
namespace Webhook;

class Controller_Github extends \Controller_Rest
{

    const SECRET_KEY = 'sl2kjae1oir1adfjld4sjfwh9ea4o3efdjlajsdfa0ew6hof';

    /*
    * githubにpushしたら、自動的にリモートでpullします。
    */
    public function action_index()
    {
        $payload = \Input::json();
        if ($payload['ref'] === 'refs/heads/master') {
            $cmd = " cd /var/www/html/url_album 2>&1; sudo git reset HEAD --hard 2>&1; sudo git pull origin master 2>&1";
            exec($cmd, $result);
            \Log::info(date("[Y-m-d H:i:s]")." ".$_SERVER['REMOTE_ADDR']." git pulled: ".$payload['head_commit']['message']."\n".print_r($result,true));
        }
    }

}