<section id="service" class="section">
	<div class="container text-center">
		<h6 class="subtitle"><?php echo get_field('subtitle')?></h6>
		<h6 class="section-title mb-4"><?php echo get_field('title')?></h6>
		<p class="mb-5 pb-4"><?php echo get_field('description')?></p>

		<div class="row">
			<?php foreach (get_field('card_row') as $card): ?>
			<div class="col-sm-6 col-md-3 mb-4">
				<div class="custom-card card border">
					<div class="card-body">
						<i class="icon <?php echo $card['icon']?>"></i>
						<h5><?php echo $card['title_card']?></h5>
					</div>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</div>
</section>