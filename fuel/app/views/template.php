<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<?php echo Asset::css(array("main.css","bootstrap.css")); ?>
	<?php echo Asset::js("jquery-3.1.1.min.js"); ?>
	<?php echo Asset::js("jquery.lazyload.min.js"); ?>
	<?php echo Asset::js("bootstrap.min.js"); ?>
	<?php echo Asset::js("main.js"); ?>
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
