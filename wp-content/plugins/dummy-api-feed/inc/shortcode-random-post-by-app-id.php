<?php

function user_posts_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'user' => '',
	), $atts );

	$user_posts_class = new \Plugin\DummyApiFeed\DummyApiClient( $atts['user'], get_option( 'app_id_field' ) );

	$user_posts = $user_posts_class->get_posts_by_user();

	if ( is_array( $user_posts ) ) {
		$random_post = $user_posts[ array_rand( $user_posts ) ];
		$output      = '<div class="container"><div class="row">';
		$output      .= '<div class="col-md-3"><img class="img-thumbnail mb-4" src="' . $random_post['image'] . '" alt=""></div>';
		$output      .= '<div class="pl-md-4 col-md-9">';
		$output      .= '<h2>' . $random_post['id'] . '</h2>';
		$output      .= '<h2>' . $random_post['owner']['title'] . ' ' . $random_post['owner']['firstName'] . ' ' . $random_post['owner']['lastName'] . '</h2>';
		$output      .= '<h2>' . $random_post['text'] . '</h2>';
		$output      .= '<h2>likes ' . $random_post['likes'] . '</h2>';
		foreach ( $random_post['tags'] as $tag ) {
			$output .= '<h2>' . $tag . '</h2>';
		}
		$output .= '<h2>' . $random_post['publishDate'] . '</h2>';
		$output .= '</div>';

		$output .= '</div>';
	} else {
		$output = $user_posts;
	}

	return $output;
}

add_shortcode( 'user_posts', 'user_posts_shortcode' );