<?php

/**
 * Botモジュール
 */
namespace Bot;

use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Controller_Top extends \Controller_Rest
{
    const BASE_URL = "http://url-album.xyz/";

    /*
    * bot本体
    */
    public function action_index()
    {
        // Botインスタンス生成
        $bot = new \LINE\LINEBot(
            new \LINE\LINEBot\HTTPClient\CurlHTTPClient(\Def_Bot::ACCESS_TOKEN),
            ['channelSecret' => \Def_Bot::CHANNEL_SECRET]
        );

        // シグネチャー入手
        $signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

        // リクエストボディー入手
        $body = file_get_contents("php://input");
        $events = $bot->parseEventRequest($body, $signature);

        foreach ($events as $event) {

            // リクエストタイプの取得
            $request_type = $event->getType();

            // リクエストタイプで処理を分岐（メッセージ/ポストバック/入室?）
            switch ($request_type) {
                case 'message':
                    $this->process_message($bot, $event);
                    break;

                case 'postback':
                    $this->process_postback($bot, $event);
                    break;

                case 'join':
                    \Log::debug('joinしたよ');
                    $this->process_join($bot, $event);
                    break;
            }
        }
    }

    /*
    * messageイベントを受け取る処理
    */
    private function process_message($bot, $event)
    {
        // ユーザーID(グループID/ルームID含む)の取得
        $id = $event->getEventSourceId();

        // トークン取得
        $reply_token = $event->getReplyToken();

        // コンテンツタイプの収録
        $type = $event->getMessageType();

        // 作成中のアルバムIDを取得
        $album = \Model_Albums::find_one_by(array(
            'user_id' => $id,
            'is_finished' => 0
            ));

        // 送られてきたのがテキストだった場合のみ、アルバム新規作成の可能性がある
        if($type == 'text') {
            // 特殊なメッセージ(コマンド)が含まれているか調べる
            $result = $this->check_menu_command($event, $bot, $reply_token);
            if($result) return;
        }

        // アルバム作成中でなければ処理を終える
        if(empty($album)) return;
        $album_id = $album['album_id'];

        // コンテンツタイプで処理を分岐
        switch ($type) {
            // テキストメッセージの場合
            case 'text':
                // メッセージ取得
                $text = $event->getText();

                // コンテンツ情報が入っているか確認
                $album = \Model_Albums::find_by_pk($album_id);
                $prev_content_info = $album['content_info'];

                // 入っていなければ処理終了
                if (is_null($prev_content_info)) break;

                // IDとテキストをDBに登録
                $prev_content = json_decode($prev_content_info, true);
                \Model_Contents::forge(array(
                    'album_id' => $album_id,
                    'content_type' => $prev_content['type'],
                    'content_url' => $prev_content['content_id'],
                    'text' => $text
                ))->save();

                // コンテンツ情報を削除
                \Model_Albums::forge(array(
                    'album_id' => $album_id,
                    'content_info' => null
                    ))->is_new(false)->save();
                break;

            // 対象コンテンツの場合
            case 'image':
            case 'audio':
            case 'video':
                // アルバム作成中でなければ処理を終える
                if(empty($album)) return;
                $album_id = $album['album_id'];

                // コンテンツのIDを取得
                $content_id = $event->getMessageId();

                // コンテンツ情報を取得
                $album = \Model_Albums::find_by_pk($album_id);
                $prev_content_info = $album['content_info'];

                // 情報が入っていたら、DBに書き込む
                if(!is_null($prev_content_info)){
                    $prev_content = json_decode($prev_content_info, true);
                    \Model_Contents::forge(array(
                        'album_id' => $album_id,
                        'content_type' => $prev_content['type'],
                        'content_url' => $prev_content['content_id']
                    ))->save();
                }

                // コンテンツの情報を保存
                $content_info = json_encode(array(
                        'type' => $type,
                        'content_id' => $content_id
                    ));

                \Model_Albums::forge(array(
                    'album_id' => $album_id,
                    'content_info' => $content_info
                    ))->is_new(false)->save();
                break;

            // その他の場合は何もしない
            default:
                break;
        }
    }

    /*
    * 特殊なテキスト(コマンド)が送られてきたかチェック
    * 送られてきていれば、メニューボタンを返信します
    */
    private function check_menu_command($event ,$bot, $reply_token)
    {
        $id = $event->getEventSourceId();
        $text = $event->getText();

        // コマンドが含まれているか確認
        if(strpos($text,'でびる') === false && strpos($text,'デビル') === false) return false;

        // アルバム作成状況に応じて、メニューボタンを作る
        $result = \Model_Albums::find_one_by(array(
            'user_id' => $id,
            'is_finished' => 0
            ));
        if(empty($result)) {
            $status = "今はアルバムを作ってないデビよ";
            // 新規作成メニューを追加
            $menu[] = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("新規アルバムを作成デビ", 'confirm_create');
        } else {
            $status = self::BASE_URL.$result['album_url']."\n"."を作成中デビよー";
            // 作成完了メニューを追加
            $menu[] = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("アルバム作成を終えるデビ", 'confirm_finish');
        }
        // アルバム一覧表示は常に追加
        $menu[]= new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("アルバム一覧を表示デビ", 'url_list');

        // Buttonテンプレートを作る
        $button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder('デビルメニュー', $status."\n".'どうするデビかー？', null, $menu);
        // Buttonメッセージを作る
        $button_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("アルバムメニュー", $button);
        // メッセージを送信
        $message = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
        $message->add($button_message);
        // リプライTokenを付与して返信する
        $res = $bot->replyMessage($reply_token, $message);

        return true;
    }

    /*
    * postbackイベントを受け取る処理
    */
    private function process_postback($bot, $event)
    {
        // 返信データを取得
        $data = $event->getPostbackData($event);
        // トークン取得
        $reply_token = $event->getReplyToken();

        // 返信データに基いて処理を分岐
        switch ($data) {
            case 'not_create_album':
                $message = "また作りたくなったら教えるデビ";
                $bot->replyText($reply_token, $message);
                break;

            case 'create_album':
                // ユーザーID(グループID/ルームID含む)の取得
                $id = $event->getEventSourceId();
                // 作成中のアルバムが無いか確認
                $result = \Model_Albums::find_one_by(array(
                    'user_id' => $id,
                    'is_finished' => 0
                    ));
                if(!empty($result)) {
                    $message = "今はこのアルバムを作成中デビよ"."\n".self::BASE_URL.$result['album_url']."\n"."作成を終えるには「終了」って言ってデビ";
                    $bot->replyText($reply_token, $message);
                    break;
                }
                // 新しいアルバムを作成
                $url = $this->create_url();
                $result = \Model_Albums::forge(array(
                    'user_id' => $id,
                    'album_url' => $url
                ))->save();
                // レスポンス作成
                $message = "新しいアルバムを作成したよ！"."\n"."URLは"."\n".self::BASE_URL.$url."\n"."デビよ";
                $bot->replyText($reply_token, $message);
                break;

                case 'not_finish_album':
                    $message = "終えたくなったら教えるデビ";
                    $bot->replyText($reply_token, $message);
                    break;

            case 'finish_album':
                // ユーザーID(グループID/ルームID含む)の取得
                $id = $event->getEventSourceId();
                // 作成中のアルバムを取得
                $result = \Model_Albums::find_one_by(array(
                    'user_id' => $id,
                    'is_finished' => 0
                    ));
                if(empty($result)) {
                    $message = "今はアルバムを作ってないデビよ";
                } else {
                    $result->is_finished = 1;
                    $result->is_new(false)->save();
                    $message = "アルバムが完成したデビ！"."\n".self::BASE_URL.$result['album_url']."\n"."みんなで楽しむデビなー";
                }
                $bot->replyText($reply_token, $message);
                break;

            case 'url_list':
                // ユーザーID(グループID/ルームID含む)の取得
                $id = $event->getEventSourceId();
                // アルバム一覧を取得
                $result = \Model_Albums::find_by(array(
                    'user_id' => $id
                    ));
                if(empty($result)) {
                    $message = "まだ1つもアルバムを作ってないデビよ…";
                } else {
                    $count = count($result);
                    $message = "今までに作ったアルバムは".$count."個デビー";
                    foreach ($result as $album) {
                        $message .= "\n".self::BASE_URL.$album['album_url'];
                    }
                }
                $bot->replyText($reply_token, $message);
                break;

            case 'confirm_create':
                // アルバム作成確認用返信作成
                // 「はい」ボタン
                $yes_post = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("はい", 'create_album');
                // 「いいえ」ボタン
                $no_post = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("いいえ", 'not_create_album');
                // Confirmテンプレートを作る
                $confirm = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("新しいアルバムを作るデビか？", [$yes_post, $no_post]);
                // Confirmメッセージを作る
                $confirm_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("アルバム作成確認", $confirm);
                // メッセージを送信
                $message = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                $message->add($confirm_message);
                // リプライTokenを付与して返信する
                $res = $bot->replyMessage($reply_token, $message);
                break;

            case 'confirm_finish':
                // アルバム完成確認用返信作成
                // 「はい」ボタン
                $yes_post = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("はい", 'finish_album');
                // 「いいえ」ボタン
                $no_post = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("いいえ", 'not_finish_album');
                // Confirmテンプレートを作る
                $confirm = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("今のアルバムを作り終えるデビか？"."\n"."一度作成を終えたアルバムにはもう追加出来ないから気をつけるデビよー", [$yes_post, $no_post]);
                // Confirmメッセージを作る
                $confirm_message = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("アルバム完成確認", $confirm);
                // メッセージを送信
                $message = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                $message->add($confirm_message);
                // リプライTokenを付与して返信する
                $res = $bot->replyMessage($reply_token, $message);
                break;

        }
    }

    /*
    * joinイベントを受け取る処理
    */
    private function process_join($bot, $event)
    {
        $id = $event->getEventSourceId();
        $type = $event->getEventSourceType();

        // DBに登録
        \Model_Users::forge(array(
            'user_id' => $id,
            'group_type' => $type
        ))->is_new(true)->save();
        \Log::debug(print_r(\DB::last_query(),true));

        // 挨拶を送る
        $reply_token = $event->getReplyToken();
        $bot->replyText($reply_token, 'よろしくデビな〜♪');
    }

    /**
     * URL新規発行
     */
    private function create_url()
    {
        //パスワードの文字数設定
        $length = 8;
        //出現させる文字設定
        $passstr = "abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        //シリアルコード生成
        $str_re = str_repeat($passstr, $length);
        $url = (substr(str_shuffle($str_re), 0, $length));

        // 重複確認
        $result = \Model_Albums::find_one_by('album_url', $url);
        if(!empty($result)) {
            return $this->create_url();
        }

        return $url;
    }

}