<?php

/**
 * Albumモジュール
 */
namespace Album;

class Controller_Resource extends \Controller_Rest
{
    public function action_index( $content_id )
    {
        // Botインスタンス生成
        $bot = new \LINE\LINEBot(
            new \LINE\LINEBot\HTTPClient\CurlHTTPClient(\Def_Bot::ACCESS_TOKEN),
            ['channelSecret' => \Def_Bot::CHANNEL_SECRET]
        );

        // リソースの取得(LINEサーバー)
        $response = $bot->getMessageContent($content_id);
        if ($response->isSucceeded()) {
            $resource = $response->getRawBody();
            header("Content-Type: image/jpeg");
            echo $resource;
        } else {
            $result = json_decode($response->getRawBody(), true);
            // リソースが既にサーバーから削除されている場合
            if ($result['message'] == "Not found") {
                // TODO:DBから削除しちゃう？
            } else {
                // 謎のエラー->ログに出力
                \Log::error($response->getHTTPStatus() . ' ' . $response->getRawBody());
            }
        }
    }
}