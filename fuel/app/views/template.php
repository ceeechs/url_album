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



	<!-- drawer.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.1.0/css/drawer.min.css">
	<!-- jquery & iScroll -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
	<!-- drawer.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.1.0/js/drawer.min.js"></script>




	<!-- フォント -->
	<style>@import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);</style>

	<script>
		$(document).ready(function() {
		$('.drawer').drawer();
		});
	</script>
</head>
<body class="drawer drawer--left">
	<header role="banner">
		<button type="button" class="drawer-toggle drawer-hamburger">
		<span class="sr-only">toggle navigation</span>
		<span class="drawer-hamburger-icon"></span>
		</button>
		<nav class="drawer-nav" role="navigation">
		<ul class="drawer-menu">
		<li><a class="drawer-brand" href="#">Brand</a></li>
		<li><a class="drawer-menu-item" href="http://git.blivesta.com/drawer/">Nav1</a></li>
		<li><a class="drawer-menu-item" href="#">Nav2</a></li>
		</ul>
		</nav>
	</header>
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
