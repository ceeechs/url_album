<body>
	<?php $content_no = 0;?>
	<?php foreach ($contents as $tmpKey => $content) { ?>
		<?php
			$year_month = substr($content->created_at, 0, 7);
			$year = substr($content->created_at, 0, 4);
			$month = substr($content->created_at, 5, 2);
		?>

		<?php if( isset($pre_month) && $pre_month != $month ) : ?>
		<!-- htmlタグのインデントを基準に記載 -->
				</div>
			<!-- </div> -->
		<?php endif ;?>

		<?php if( empty( $pre_month ) || $pre_month != $month ) : ?>
				<div class="container-fluid month m_background_<?php echo $month;?>">
		<?php endif ;?>

		<?php if ( $content_no == 0 || $prev_year_month != $year_month ): ?>
				<script>
					$('#nav_ul').append('<li><a href="#<?php echo $year_month;?>"><?php echo $year.'年'.$month.'月';?></a></li>');

				</script>
				<div id="<?php echo $year_month; ?>" class="row date">
					<p class="">
						<?php echo $year.'年'.$month.'月'; ?>
					</p>
				</div>
		<?php endif; ?>
		<?php $comment_class_no = $content_no % \Def_App::COMMENT_CSS_NUM; ?>
		<?php $image_class_no = $content_no % \Def_App::IMAGE_CSS_NUM; ?>
				<div class="row content">
					<?php if (!empty($content->text)): ?>
					<div class="col-sm-12">
						<p class="comment_type_<?php echo $comment_class_no;?>"><?php echo $content->text;?></p>
					</div>
					<?php endif;?>
					<div>
						<?php if($content->content_type == 'image'): ?>
							<img class="image_common type<?php echo $image_class_no;?> lazy" data-action="zoom" src="https://www.starflyer.jp/10th_anniversary/campaign/img/socialin/loading.gif" data-original="https://www.url-album.xyz/assets/img/<?= $content->content_url; ?>" alt="">
						<?php elseif($content->content_type == 'video'): ?>
							<video class="video" width="600" height="1100" autoplay loop preload=auto poster="" controls>
								<source src="https://www.url-album.xyz/assets/img/<?= $content->content_url; ?>" >
							</video>
						<?php endif ; ?>
					</div>
				</div>
		<?php $prev_year_month = $year_month; $pre_month = $month ; $content_no++; ?>
	<?php } ?>
</body>
