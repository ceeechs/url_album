// ↓.hoge内のimgを隠す
// $(function(){
// 	$("#first_img").css("display","none");
// });

// //↓windowがロードされたらimgをフェードインさせる
// $(window).bind("load",function(){
// 	$("#first_img").fadeIn(3000);
// });

console.log("Hello World");

// ヘッダーメニュー
//$('#header-menu').slicknav({
	//label: '',
	//duration: 1000,
	//easingOpen: "easeOutBounce", //available with jQuery UI
	// prependTo:'#demo2'
//});

jQuery(function($){
  $('#menu').slicknav();
});

// 遅延読み込み 参考=>https://syncer.jp/how-to-setting-lazy-load-images
// Lazy Loadを起動する
$( function(){
	$( 'img.lazy' ).lazyload({
			threshold: 200 ,		// 何pxまで近づいたら読み込むか
			effect: "fadeIn" ,		// じわじわっと表示させる
			effect_speed: 1500 ,	// ミリ秒
		});
});
