<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Basic -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Site Icons -->

	<?php wp_head(); ?>
</head>
<body>

<!-- Page navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" data-spy="affix" data-offset-top="0">
	<div class="container">
		<a class="navbar-brand" href="#"><?php the_custom_logo(); ?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
		        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<?php
			$args = array(
				'container'      => false,
				'theme_location' => 'primary',
				'depth'          => 1,
				'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
				'menu_class'     => 'navbar-nav ml-auto align-items-center',
				'add_li_class'   => 'nav-item',
				'add_a_class'    => 'nav-link',
			);
			wp_nav_menu( $args );

			?>
		</div>
	</div>
</nav>
<!-- End of page navibation -->