<?php

class Controller_Top extends Controller_Template
{

	public function action_index()
	{
		/* 連携開始したらコメントアウト外す
		//アクセストークン
		$accessToken = '';

		//ユーザーからのメッセージ取得
		$json_string 	= file_get_contents('php://input');
		$jsonObj 		= json_decode($json_string);

		$type 		= $jsonObj->{"events"}[0]->{"message"}->{"type"};
		$text 		= $jsonObj->{"events"}[0]->{"message"}->{"text"};
		$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

		//ユーザーID指定
		$userID = $jsonObj->{"events"}[0]->{"source"}->{"userId"};
		*/

		$data['message'] = array(
				 '中華料理食べた~~~！'
				,'開発急がないと！'
			);

		$this->template->title = 'Top';
		$this->template->content = View::forge('top', $data);

		return \View::forge( 'top', $data );


	}

}
?>
