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

	<script>
		$(function(){
			$('#headr-menu').slicknav();
		});
	</script>
</head>
<body>
	<!-- ヘッダーメニュー -->
	<ul id="headr-menu">
		<li><a class="scroll" href="#">2015年</a></li>
		<li><a class="scroll" href="#">2016年</a></li>
		<li><a class="scroll" href="#">2017年</a></li>
	</ul>
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
