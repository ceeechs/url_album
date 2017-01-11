<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noimageindex">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array("bootstrap.css", "main.css", "comment.css", "zoom.css")); ?>
	<?php echo Asset::js(array("jquery-3.1.1.min.js", "bootstrap.min.js", "jquery.lazyload.min.js", "zoom.js", "main.js")); ?>
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
