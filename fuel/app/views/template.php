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
		// $(function(){
		// 	$('#headr-menu').slicknav();
		// });
		$(function() {
		    $('#navToggle').click(function(){//headerに .openNav を付加・削除
		        $('header').toggleClass('openNav');
		    });
		});
	</script>
</head>
<body>
	<header>
	<h1><a href="index.html"><img src="img/header_logo.png"></a></h1>
	<div id="navToggle">
	  <div>
	   <span></span> <span></span> <span></span>
	  </div>
	</div><!--#navToggle END-->
	<nav>
	  <ul>
	   <li><a href="#">HOME</a></li>
	   <li><a href="#">MENU1</a></li>
	   <li><a href="#">MENU2</a></li>
	   <li><a href="#">MENU3</a></li>
	   <li><a href="#">MENU4</a></li>
	  </ul>
	</nav>
	</header>
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
