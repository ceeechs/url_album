<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noimageindex">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array("bootstrap.css", "main.css", "comment.css", "zoom.css")); ?>
	<!-- , "slicknav.css" -->
	<?php echo Asset::js(array("jquery-3.1.1.min.js", "bootstrap.min.js", "jquery.lazyload.min.js", "zoom.js", "main.js")); ?>
	<!-- ,"jquery-ui.min.js","jquery.slicknav.min.js"  -->

	<script>
		// $(document).ready(function() {
		// $('.drawer').drawer();
		// });
	</script>
</head>
<body>
    <nav class="navbar">
       <!--ウィンドウ幅に合わせて可変-->
      <div class="container-fluid">
        <div class="navbar-header">
          <!--スマホ用トグルボタンの設置-->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--ロゴ表示の指定-->
          <a class="navbar-brand" href="#">MK Coffee</a>
        </div>
          <!--スマホ用の画面幅が小さいときの表示を非表示にする-->
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Information</a></li>
            <li><a href="#">Menu</a></li>
            <li><a href="#">Map</a></li>
              <!--ドロップダウンメニューの作成-->
            <li class="dropdown">
              <a href="mizukazu.minibird.jp" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="divider"></li>
                <li class="dropdown-header">会社情報</li>
                <li><a href="#">企業理念</a></li>
                <li><a href="#">会社概要</a></li>

                <li class="divider"></li>
                <li class="dropdown-header">求人情報</li>
                <li><a href="#">正社員・アルバイト募集</a></li>
                <li><a href="#">スタッフより</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div><!--/.container-fluid -->
    </nav>
	<!-- http://www.webdesignleaves.com/wp/jquery/1384/ -->
	<div class="container">
		<div class="row header">
			<div class="col-sm-12">
				<!-- <button type="button" class="btn btn-default">Default</button> -->
				<p>URL-ALBUM</p>

			</div>
		</div>
	</div>
	<?php echo $content; ?>
</body>
</html>
