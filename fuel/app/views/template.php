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

	<!-- フォント -->
	<style>@import url(http://fonts.googleapis.com/earlyaccess/notosansjapanese.css);</style>

	<script>
		// $(document).ready(function() {
		// $('.drawer').drawer();
		// });
	</script>
</head>
<body class="drawer">
	<nav class="navbar navbar-default">
	  <div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#gnavi">
	      <span class="sr-only">メニュー</span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	    </button>
	    <a href="#" class="navbar-brand">URL-Album</a>
	  </div>
	 
	  <div id="gnavi" class="collapse navbar-collapse">
	    <ul class="nav navbar-nav">
	      <li><a href="">Link1</a></li>
	      <li><a href="">Link2</a></li>
	      <li><a href="">Link3</a></li>
	    </ul>
	  </div>
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
