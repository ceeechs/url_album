<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noimageindex">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array("bootstrap.css", "main.css", "comment.css", "zoom.css", "slicknav.css")); ?>
	<?php echo Asset::js(array("jquery-3.1.1.min.js","jquery-ui.min.js", "bootstrap.min.js", "jquery.lazyload.min.js", "zoom.js", "jquery.slicknav.min.js", "main.js")); ?>

	<!-- フォント -->
	<style>@import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);</style>
</head>
<body>
	<!-- ヘッダーメニュー -->
	<!-- http://www.webdesignleaves.com/wp/jquery/1384/ -->
	<div>
		<ul id="header-menu">
		    <li>Parent 1
		        <ul>
		            <li><a href="#">item 3</a></li>
		            <li>Parent 3
		                <ul>
		                    <li><a href="#">item 8</a></li>
		                    <li><a href="#">item 9</a></li>
		                    <li><a href="#">item 10</a></li>
		                </ul>
		            </li>
		            <li><a href="#">item 4</a></li>
		        </ul>
		    </li>
		    <li><a href="#">item 1</a></li>
		    <li>non-link item</li>
		    <li>Parent 2
		        <ul>
		            <li><a href="#">item 5</a></li>
		            <li><a href="#">item 6</a></li>
		            <li><a href="#">item 7</a></li>
		        </ul>
		    </li>
		</ul>
	</div>
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
