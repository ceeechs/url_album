<?php

$convert_album_url = function()
    {
        $album_id = 0;
        $request = null;
        // 短縮URL対応
        $album_url = Request::forge()->uri->get();
        // DBに存在するか確認
        $album = \Model_Albums::find_one_by('album_url', $album_url);
        if(!empty($album)){
            $album_id = $album['album_id'];
            $request = $album_url;
        }

        return array($request, $album_id);
    };

list($request, $album_id) = $convert_album_url();

return array(
    '_root_'  => 'sample/welcome/index',  // The default route
    '_404_'   => 'sample/welcome/404',    // The main 404 route

    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    $request => 'album/top/index/'.$album_id,

);