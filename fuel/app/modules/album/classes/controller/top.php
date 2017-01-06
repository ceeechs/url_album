<?php
namespace Album;

class Controller_Top extends \Controller_Template
{
	public function before()
	{
		parent::before();
		$this->template->title = 'URL-Album';
	}

	public function action_index( $album_id )
	{
		$resources = [];

		// TODO::コンテンツないい時の専用ページに飛ばしてもいいかも
		if ( empty($album_id) ) { \View::forge('test', $data); }

		// DBからデータ取得
		$data['contents'] = \Model_Contents::find_by( 'album_id', $album_id);
//echo"<pre>\n";print_r($album[0]);echo"<hr></pre>";exit;

		// Botインスタンス生成
		$bot = new \LINE\LINEBot(
			new \LINE\LINEBot\HTTPClient\CurlHTTPClient(\Def_Bot::ACCESS_TOKEN),
			['channelSecret' => \Def_Bot::CHANNEL_SECRET]
		);

		// リソースの取得(LINEサーバー)
		foreach ($data['contents'] as $key => $value) {
			$response = $bot->getMessageContent($value['content_url']);
			if ($response->isSucceeded()) {
				$base64 = base64_encode($response->getRawBody());
				$mime = 'image/jpg';
				$resources[] = 'data:'.$mime.';base64,'.$base64;
			} else {
				$result = json_decode($response->getRawBody(), true);
				// リソースが既にサーバーから削除されている場合
				if ($result['message'] == "Not found") {
					// 表示用dataから取り除く
					unset($data['contents'][$key]);
					// TODO:DBからも削除しちゃう？

				} else {
					// 謎のエラー->ログに出力
					\Log::error($response->getHTTPStatus() . ' ' . $response->getRawBody());
				}
			}
		}

		$this->template->content = \View::forge('top', $data);
		$this->template->content->set_safe('resources', $resources);
	}
}
