<header class="header" id="home">
	<div class="container">
		<div class="infos">
			<h6 class="subtitle"><?php echo get_field('subtitle')?></h6>
			<h6 class="title"><?php echo get_field('title')?></h6>
			<p><?php echo get_field('paragraph')?></p>

			<div class="buttons pt-3">
				<a href="<?php echo get_field('button_left_link')?>"><button class="btn btn-primary rounded"><?php echo get_field('button_left_text')?></button></a>
				<a href="<?php echo get_field('button_right_link')?>"><button class="btn btn-dark rounded"><?php echo get_field('button_right_text')?></button></a>
			</div>

			<div class="socials mt-4">
				<a class="social-item" href="<?php echo get_theme_mod('facebook_link_setting')?>"><i class="<?php echo get_theme_mod('facebook_class_icon_setting')?>"></i></a>
				<a class="social-item" href="<?php echo get_theme_mod('google_link_setting')?>"><i class="<?php echo get_theme_mod('google_class_icon_setting')?>"></i></a>
				<a class="social-item" href="<?php echo get_theme_mod('github_link_setting')?>"><i class="<?php echo get_theme_mod('github_class_icon_setting')?>"></i></a>
				<a class="social-item" href="<?php echo get_theme_mod('twitter_link_setting')?>"><i class="<?php echo get_theme_mod('twitter_class_icon_setting')?>"></i></a>
			</div>
		</div>
		<div class="img-holder">
			<img src="<?php echo get_field('image')?>" alt="">
		</div>
	</div>

	<!-- Header-widget -->
	<div class="widget">
		<?php foreach (get_field('widget_header') as $card): ?>
		<div class="widget-item">
			<h2><?php echo $card['number_of_count']?></h2>
			<p><?php echo $card['object_of_count']?></p>
		</div>
		<?php endforeach;?>
	</div>
</header>