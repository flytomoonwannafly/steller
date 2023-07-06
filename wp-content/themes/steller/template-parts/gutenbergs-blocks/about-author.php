<section id="about" class="section mt-3">
	<div class="container mt-5">
		<div class="row text-center text-md-left">
			<div class="col-md-3">
				<img src="<?php echo get_field('image')?>" alt="" class="img-thumbnail mb-4">

			</div>
			<div class="pl-md-4 col-md-9">
				<h6 class="title"><?php echo get_field('title')?></h6>
				<p class="subtitle"><?php echo get_field('subtitle')?></p>
				<p><?php echo get_field('description')?></p>
				<a href="<?php echo get_field('button_link')?>"><button class="btn btn-primary rounded mt-3"><?php echo get_field('button_text')?></button></a>
			</div>
		</div>
	</div>
</section>