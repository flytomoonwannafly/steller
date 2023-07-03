<?php

function steller_setup(){

    load_theme_textdomain('steller');
    add_theme_support('post-thumbnails');
    register_nav_menu('primary', 'Primary menu');
}

add_action('after_setup_theme', 'steller_setup');