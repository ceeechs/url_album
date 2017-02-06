console.log("Hello World");

// 遅延読み込み 参考=>https://syncer.jp/how-to-setting-lazy-load-images
// Lazy Loadを起動する
$( function(){
	$( 'img.lazy' ).lazyload({
			threshold: 200 ,		// 何pxまで近づいたら読み込むか
			effect: "fadeIn" ,		// じわじわっと表示させる
			effect_speed: 1500 ,	// ミリ秒
		});
});

$(document).ready(function () {
	$(".navbar-nav li a").click(function(event) {
		$(".navbar-collapse").collapse('hide');
	});
});
