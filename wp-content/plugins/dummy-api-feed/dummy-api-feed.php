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
require_once __DIR__ . '/inc/class-dummy-feed-client.php';
require_once __DIR__ . '/inc/shortcode-random-post-by-app-id.php';

new \Plugin\DummyApiFeed\DummyApiTypeRegister();

