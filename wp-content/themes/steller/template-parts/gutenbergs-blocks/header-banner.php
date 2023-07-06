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
				<a class="social-item" href="javascript:void(0)"><i class="ti-facebook"></i></a>
				<a class="social-item" href="javascript:void(0)"><i class="ti-google"></i></a>
				<a class="social-item" href="javascript:void(0)"><i class="ti-github"></i></a>
				<a class="social-item" href="javascript:void(0)"><i class="ti-twitter"></i></a>
			</div>
		</div>
		<div class="img-holder">
			<img src="<?php echo get_field('image')?>" alt="">
		</div>
	</div>

	<!-- Header-widget -->
	<div class="widget">
		<div class="widget-item">
			<h2>124</h2>
			<p>Happy Clients</p>
		</div>
		<div class="widget-item">
			<h2>456</h2>
			<p>Project Completed</p>
		</div>
		<div class="widget-item">
			<h2>789</h2>
			<p>Awards Won</p>
		</div>
	</div>
</header>