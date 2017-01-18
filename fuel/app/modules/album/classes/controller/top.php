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
		$expired_date = date('Y-m-d H:i:s', strtotime('-2 week', time())); // 2週間前の日付

		// DBからデータ取得
		$condition = [
			'where' => [
				['album_id', '=', $album_id ],
			],
			'order_by' => [
				'created_at' => 'desc',
			]
		];

		$data['contents'] = \Model_Contents::find( $condition );

		// TODO::コンテンツないい時の専用ページに飛ばしてもいいかも
		if ( empty($data['contents'] ) ) return \View::forge('test', $data);

		foreach ($data['contents'] as $key => $value) {
			// もし2週間以上前のデータだったら
			if ($value['created_at'] < $expired_date) {
				// 表示対象から取り除く
				unset($data['contents'][$key]);
				// delフラグ立てる
				\Model_Contents::forge(array(
				    'content_id' => $value['content_id'],
				    'is_deleted' => 1
				    ))->is_new(false)->save();
			}
		}

		$this->template->content = \View::forge('top', $data);

	}
}
