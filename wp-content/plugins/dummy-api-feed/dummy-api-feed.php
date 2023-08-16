<?php

/**
 * Plugin Name: Dummy api feed
 * Plugin URI: https://dummyapi.io/explorer
 * Description: This plugin created for handle dummy api
 * Version: 1.0.0
 * Author: Volodimyr
 * Author URI: http://volodimyr
 */

require_once __DIR__ . '/inc/class-dummy-api-type-register.php';
require_once __DIR__ . '/inc/class-dummy-feed-type-register.php';
require_once __DIR__ . '/inc/class-dummy-feed-client.php';
require_once __DIR__ . '/inc/shortcode-random-post-by-app-id.php';

new \Plugin\DummyApiFeed\DummyApiTypeRegister();
new \Plugin\DummyApiFeed\DummyFeedTypeRegister();


add_action('admin_enqueue_scripts', 'dummy_feed_enqueue_media');
function dummy_feed_enqueue_media() {
	wp_enqueue_media();
	wp_register_script('dummy-feed-media', plugin_dir_url(__FILE__) . 'assets/dummy-feed-media.js', array('jquery'), '1.0', true);
	wp_enqueue_script('dummy-feed-media');
}

function register_cron_intervals( $schedules ) {
	$schedules['ten_minutes'] = array(
		'interval' => 10 * 60,
		'display'  => __( 'Once every ten minutes' )
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'register_cron_intervals' );