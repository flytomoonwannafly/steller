<?php

namespace Theme\Steller;

class WP_Frontend{

    /**
     * WP_Theme constructor.
     */
    public function __construct() {
        $this->init_hooks();
    }

    public function init_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_steller_scripts' ] );
    }
    function wp_steller_scripts(){
        wp_enqueue_style('style-css', get_stylesheet_uri());

        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap-affix', get_template_directory_uri(). '/assets/js/bootstrap.affix.js');
        wp_enqueue_script('bootstrap-bundle', get_template_directory_uri(). '/assets/js/bootstrap.bundle.js');
        wp_enqueue_script('steller', get_template_directory_uri(). '/assets/js/steller.js');

    }

}