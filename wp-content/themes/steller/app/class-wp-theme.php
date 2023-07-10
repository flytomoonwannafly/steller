<?php

namespace Theme\Steller;

class WP_Theme {

	const THEME_VERSION = '1.0.1';

	const TEXT_DOMAIN = 'steller';

	/**
	 * WP_Theme constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	public function init_hooks() {
		add_action( 'after_setup_theme', [ $this, 'steller_setup' ] );
		add_filter( 'nav_menu_css_class', [ $this, 'add_additional_class_on_li' ], 10, 4 );
		add_filter( 'nav_menu_link_attributes', [ $this, 'steller_nav_link_filter' ], 10, 4 );
		add_filter( 'upload_mimes', [ $this, 'allow_svg_upload' ], 10, 4 );
	}

	public static function get_directory_uri() {
		return get_template_directory_uri( __FILE__ );
	}

	public static function get_directory() {
		return get_template_directory( __FILE__ );
	}


	/**
	 * Implements hook: init().
	 *
	 * Registers locations to nav menus.
	 */
	public function steller_setup() {

		add_theme_support( 'custom-logo', array(
			'height'      => 48,
			'width'       => 75,
			'flex-height' => true,
		) );
		load_theme_textdomain( 'steller' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menu( 'primary', 'Primary menu' );
	}

	function add_additional_class_on_li( $classes, $item, $args ) {
		if ( isset( $args->add_li_class ) ) {
			$classes[] = $args->add_li_class;
		}

		return $classes;
	}

	public function steller_nav_link_filter( $atts, $item, $args ) {
		if ( isset( $args->add_a_class ) ) {
			$atts['class'] = $args->add_a_class;
		}

		return $atts;
	}

	function allow_svg_upload( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

}