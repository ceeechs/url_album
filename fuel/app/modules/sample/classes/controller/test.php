<?php

use \Model\Task;

class Controller_Test extends Controller
{

    public function action_index()
    {
        echo "hello world\n\n";exit;

        //アクセストークン
        $accessToken = '';

        //ユーザーからのメッセージ取得
        $json_string = file_get_contents('php://input');
        $json_string =
            '
            {
              "events": [
                {
                  "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
                  "type": "message",
                  "timestamp": 1462629479859,
                  "source": {
                    "type": "user",
                    "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
                  },
                  "message": {
                    "id": "325708",
                    "type": "text",
                    "text": "Hello, world"
                  }
                }
              ]
            }
            ';
        Model_Task::getCallBackData( $accessToken, $json_string );
    }
}

?>
