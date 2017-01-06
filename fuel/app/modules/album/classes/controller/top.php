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

		$this->template->content = \View::forge('top', $data);

	}
}
