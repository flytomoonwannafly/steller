<section id="contact" class="position-relative section">
	<div class="container text-center">
		<h6 class="subtitle"><?php echo get_field('subtitle')?></h6>
		<h6 class="section-title mb-4"><?php echo get_field('title')?></h6>
		<p class="mb-5 pb-4"><?php echo get_field('description')?></p>

		<div class="contact text-left">
			<div class="form">
				<h6 class="subtitle">Available 24/7</h6>
				<h6 class="section-title mb-4">Get In Touch</h6>
				<?php gravity_form( get_field('gravity_form_id'), false, false, false, '', false );?>
			</div>
			<div class="contact-infos">
				<?php foreach (get_field('contact_info_items') as $item): ?>
				<div class="item">
					<i class="<?php echo $item['icon'];?>"></i>
					<div>
						<h5><?php echo $item['title_item'];?></h5>
						<p><?php echo $item['paragraph'];?></p>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
	<div id="map">
		<iframe src="<?php echo get_field('background_bottom_block')?>"></iframe>
	</div>
</section>