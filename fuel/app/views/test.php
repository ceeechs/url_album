<body>
	<div class="container">
		<div class="row">
			<p class="date">2016年8月</p>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p class="green_coment">この写真やばいね！</p>
			</div>
			<div>
				<!-- <img class="type1" src="https://scontent-nrt1-1.xx.fbcdn.net/v/t1.0-9/14264870_1110928905656138_2957300775777219316_n.jpg?oh=88448ed373914e6796461d1f5b846070&oe=58F80F11" alt=""> -->
				<img class="type1 lazy" src="http://techmemo.biz/wp-content/uploads/2015/06/loading.png" data-original="http://tabizine.jp/wp-content/uploads/2015/06/36138-01.jpg" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p class="balloon-4-bottom-right">何歳になっても可愛い...</p>
			</div>
			<div>
				<img class="type2 lazy" src="http://techmemo.biz/wp-content/uploads/2015/06/loading.png" data-original="http://playlistpoetry.com/wp-content/uploads/2015/09/QFAQHT6.jpg" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p>もはや神</p>
			</div>
			<div>
				<img class="type1 lazy" src="http://techmemo.biz/wp-content/uploads/2015/06/loading.png" data-original="http://pic.prepics-cdn.com/6f72fb1067862/39604599.jpeg" alt="">
			</div>
		</div>
		<!-- 月の変わり目 -->
		<div class="row">
			<p class="date">2016年7月</p>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p class="green_coment">急にディズニーきたwww</p>
			</div>
			<div>
				<img class="lazy" id="first_img"　src="http://techmemo.biz/wp-content/uploads/2015/06/loading.png" data-original="http://www.cinemacafe.net/imgs/thumb_h1/231803.jpg" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p class="balloon-4-bottom-right">覚せい剤やってたとしてもイケメン！</p>
			</div>
			<div>
				<img class="type2 lazy" src="http://techmemo.biz/wp-content/uploads/2015/06/loading.png" data-original="http://yononakanews.com/wp-content/uploads/2015/04/%E6%88%90%E5%AE%AE%E6%9C%80%E6%96%B0%E3%80%80%E5%B0%8F.jpg" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p>もはや神</p>
			</div>
			<div>
				<img class="type1 lazy" src="http://techmemo.biz/wp-content/uploads/2015/06/loading.png" data-original="https://scontent-nrt1-1.xx.fbcdn.net/v/t1.0-9/12795500_10205061980459750_6340718348457154581_n.jpg?oh=3d0853c0ff279ae606371c02f9c3713b&oe=58AEA831" data-original="http://pic.prepics-cdn.com/6f72fb1067862/39604599.jpeg" alt="">
			</div>
		</div>

		<!-- 動画 -->
		<div class="row">
			<div class="col-sm-12">
				<p>なつかしい〜〜〜〜！！</p>
			</div>
			<div>
				<?php //Asset::add_path('video/');  ?>
				<?php $video = Asset::get_file('takahara_hb.mp4', 'img');var_dump($video); ?>
				<!-- https://www.url-album.xyz/assets/img/takahara_hb.mp4 -->
				<video width="600" height="1100" autoplay loop muted preload=auto poster="" controls>
					<!-- <source src="http://bitcoin-with.com/codecamp/test-movie.mp4" > -->
					<!-- <source src="http://localhost/url_album/public/assets/img/takahara_hb.mp4" > -->
					<source src="<?php echo $video;?>" >
				</video>
				<!-- これで自動再生できるかも -->
				<!-- http://kimagureneet.hatenablog.com/entry/2016/05/13/112851 -->
				<!-- http://qiita.com/hadakadenkyu/items/75162099d0bf7cdcfdc7 -->

				<!-- <video src="https://youtu.be/oblJR1UoUjE">
					<p>このブラウザでは動画が再生できません</p>
				</video> -->
			</div>
		</div>
	</div>
</body>
