<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noimageindex">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array("main.css", "comment.css", "bootstrap.css", "zoom.css")); ?>
	<?php echo Asset::js(array("jquery-3.1.1.min.js", "jquery.lazyload.min.js", "bootstrap.min.js", "main.js", "zoom.js")); ?>
	<style>@import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);</style>
</head>
<body>
	<div class="container">
		<div class="row headder">
			<div class="col-sm-12">
				<!-- <button type="button" class="btn btn-default">Default</button> -->
				<p>hedder-menu</p>
			</div>
		</div>
	</div>
	<?php echo $content; ?>
</body>
</html>
