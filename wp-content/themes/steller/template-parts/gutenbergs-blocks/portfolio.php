<section id="portfolio" class="section">
	<div class="container text-center">
		<h6 class="subtitle"><?php echo get_field( 'subtitle' ) ?></h6>
		<h6 class="section-title mb-4"><?php echo get_field( 'title' ) ?></h6>
		<p class="mb-5 pb-4"><?php echo get_field( 'description' ) ?></p>
		<?php $gallery = get_field( 'gallery' ); ?>
		<div class="row">
			<?php $counter = 0; ?>
			<?php foreach ( $gallery as $image ) : ?>
			<?php if ( $counter % 2 == 0 ) : ?>
			<?php if ( $counter > 0 ) : ?>
		</div>
	<?php endif; ?>
		<div class="col-sm-4">
			<?php endif; ?>
			<div class="img-wrapper">
				<img src="<?php echo $image; ?>" alt="">
				<div class="overlay">
					<div class="overlay-infos">
						<h5>Project Title</h5>
						<a href="javascript:void(0)"><i class="ti-zoom-in"></i></a>
						<a href="javascript:void(0)"><i class="ti-link"></i></a>
					</div>
				</div>
			</div>
			<?php $counter ++; ?>
			<?php endforeach; ?>
			<?php if ( $counter > 0 ) : ?>
		</div>
	<?php endif; ?>
	</div>
</section>