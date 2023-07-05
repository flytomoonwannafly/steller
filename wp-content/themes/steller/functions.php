<?php

require_once __DIR__ . '/app/class-wp-autoloader.php';
Theme\Steller\WP_Autoloader::init();

new Theme\Steller\WP_Theme();
new Theme\Steller\WP_Frontend();

