<?php

namespace Theme\Steller\GutenbergBlock;

use Theme\Steller\WP_Theme;

/**
 * Class GutenbergBlock
 * @package Theme\Steller\GutenbergBlock
 */
abstract class GutenbergBlock {

	abstract public function register_block();

	public function __construct() {
		$this->register_head_styles();
	}

	static public function get_block_classes( $block ) {
		$classes = [ 'steller-gutenberg-block' ];

		$classes[] = self::get_unique_block_class();

		if ( ! empty( $block['className'] ) ) {
			$classes[] = $block['className'];
		}

		if ( ! empty( $block['align'] ) ) {
			$classes[] = $block['align'];
		}

		return implode( ' ', $classes );
	}

	static protected function get_unique_block_class() {
		$file_name          = ( new \ReflectionClass( static::class ) )->getFileName();
		$file_name          = explode( '/', $file_name );
		$file_name          = end( $file_name );
		$file_name          = str_replace( '.php', '', $file_name );
		$unique_block_class = str_replace( 'class-', '', $file_name );

		return 'frank-' . $unique_block_class;
	}

	static public function get_block_data() {
		return [];
	}

	static protected function get_background_color() {
		if ( ! empty( get_field( 'background_color' ) ) ) {
			return get_field( 'background_color' );
		}

		return null;
	}

	/**
	 * @return string
	 */
	static public function get_block_css_styles(): string {
		$css_styles_array = [];

		if ( ! empty( self::get_background_color() ) ) {
			$css_styles_array['background-color'] = self::get_background_color();
		}

		if ( empty( $css_styles_array ) ) {
			return '';
		}

		$css_styles = implode(';', array_map(function ($v, $k) {
			return "$k: $v";
		}, $css_styles_array, array_keys($css_styles_array)));

		return "style=\"" . $css_styles . "\"";
	}

	/**
	 * Registers CSS styles for the current gutenberg block and places them in the <head> tag.
	 */
	protected function register_head_styles() {
		if ( count( $this->get_head_styles() ) == 0 ) {
			return;
		}

		if ( empty( static::BLOCK_NAME ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', function () {
			if ( ! has_block( 'acf/' . static::BLOCK_NAME ) ) {
				return;
			}

			foreach ( $this->get_head_styles() as $head_style_src ) {
				wp_enqueue_style( 'gutenberg-block-' . static::BLOCK_NAME . '-head', $head_style_src, [], WP_Theme::THEME_VERSION );
			}
		} );
	}

	protected function get_head_styles() : array {
		return [];
	}
}