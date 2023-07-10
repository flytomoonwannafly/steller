<section class="bg-gray p-0 section">
	<div class="container">
		<div class="card bg-primary">
			<div class="card-body text-light">
				<div class="row align-items-center">
					<div class="col-sm-9 text-center text-sm-left">
						<h5 class="mt-3"><?php echo get_field('title')?></h5>
						<p class="mb-3"><?php echo get_field('description')?></p>
					</div>
					<div class="col-sm-3 text-center text-sm-right">
						<a href="<?php echo get_field('button_link')?>"><button class="btn btn-light rounded"><?php echo get_field('button_text')?></button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>