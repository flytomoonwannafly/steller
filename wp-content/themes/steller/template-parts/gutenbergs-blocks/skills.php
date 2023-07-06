<section class="section">
	<div class="container text-center">
		<h6 class="subtitle"><?php echo get_field('subtitle')?></h6>
		<h6 class="section-title mb-4"><?php echo get_field('title')?></h6>
		<p class="mb-5 pb-4"><?php echo get_field('description')?></p>

		<div class="row text-left">
			<?php foreach (get_field('skills_row') as $skills): ?>
			<div class="col-sm-6">
				<h6 class="mb-3"><?php echo $skills['skills_name']?></h6>
				<div class="progress">
					<div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $skills['percentage_of_progress']?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><span><?php echo $skills['percentage_of_progress']?>%</span></div>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</div>
</section>