<section id="testmonial" class="section">
	<div class="container text-center">
		<h6 class="subtitle"><?php echo get_field('subtitle')?></h6>
		<h6 class="section-title mb-4"><?php echo get_field('title')?></h6>
		<p class="mb-5 pb-4"><?php echo get_field('description')?></p>

		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class=""></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
			</ol>

			<div class="carousel-inner">
				<?php $counter = 0;?>
				<?php foreach ( get_field( 'testmonial_card' ) as $card ): ?>
				<?php $counter++; ?>
				<?php $class = ($counter == 2) ? 'active' : ''; ?>
				<div class="carousel-item <?php echo $class ?>">
					<div class="card testmonial-card border">
						<div class="card-body">
							<img src="<?php echo $card['avatar_image'] ?>" alt="">
							<p><?php echo $card['testmonial_text'] ?></p>
							<h1 class="title"><?php echo $card['name_author'] ?></h1>
							<h1 class="subtitle"><?php echo $card['position_author'] ?></h1>
						</div>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</section>