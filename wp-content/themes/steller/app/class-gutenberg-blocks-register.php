<?php

namespace Theme\Steller;


require_once __DIR__ . '/gutenberg-blocks/class-gutenberg-about-author-block.php';
require_once __DIR__ . '/gutenberg-blocks/class-gutenberg-service-block.php';
require_once __DIR__ . '/gutenberg-blocks/class-gutenberg-header-banner-block.php';
require_once __DIR__ . '/gutenberg-blocks/class-gutenberg-skills-block.php';
require_once __DIR__ . '/gutenberg-blocks/class-gutenberg-portfolio-block.php';

use Theme\Steller\GutenbergBlock\GutenbergAboutAuthorBlock;
use Theme\Steller\GutenbergBlock\GutenbergServiceBlock;
use Theme\Steller\GutenbergBlock\GutenbergHeaderBannerBlock;
use Theme\Steller\GutenbergBlock\GutenbergSkillsBlock;
use Theme\Steller\GutenbergBlock\GutenbergPortfolioBlock;


use Theme\Steller\WP_Theme;

/**
 * Class for registering custom Gutenberg blocks.
 *
 * Class GutenbergBlockRegister
 * @package Theme\Steller\GutenbergBlock
 */
class GutenbergBlockRegister {

	public function __construct() {
		add_filter( 'block_categories', [ $this, 'register_block_category' ], 10, 2 );
		add_action( 'enqueue_block_editor_assets', [ $this, 'register_block_editor_styles' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'register_block_editor_scripts' ] );
	}

	/**
	 * Register the custom Gutenberg blocks.
	 */
	static public function register_blocks() {
		add_action( 'acf/init', [ new GutenbergAboutAuthorBlock, 'register_block' ] );
		add_action( 'acf/init', [ new GutenbergServiceBlock, 'register_block' ] );
		add_action( 'acf/init', [ new GutenbergHeaderBannerBlock, 'register_block' ] );
		add_action( 'acf/init', [ new GutenbergSkillsBlock, 'register_block' ] );
		add_action( 'acf/init', [ new GutenbergPortfolioBlock, 'register_block' ] );

	}

	/**
	 * Register the custom Gutenberg block category.
	 *
	 * @param $categories
	 * @param $post
	 *
	 * @return array
	 */
	function register_block_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'steller-blocks',
					'title' => __( 'Steller blocks', WP_Theme::TEXT_DOMAIN ),
					'icon'  => 'wordpress',
				),
			)
		);
	}

	/**
	 * Implements hook: enqueue_block_editor_assets().
	 *
	 * Registers styles to the block editor.
	 */
	public function register_block_editor_styles() {
		$path = \Theme\Steller\WP_Theme::get_directory_uri() . '/assets/admin-dashboard/';

		wp_enqueue_style( 'steller-main-editor', $path . 'css/editor.css' );
	}

	/**
	 * Implements hook: enqueue_block_editor_assets().
	 *
	 * Registers scripts to the block editor.
	 */
	public function register_block_editor_scripts() {
		$path = \Theme\Steller\WP_Theme::get_directory_uri() . '/assets/admin-dashboard/';

		wp_enqueue_script( 'steller-main-editor--padding-bottom-controls', $path . 'js/gutenberg-editor/padding-bottom-controls.js' );
		wp_enqueue_script( 'steller-main-editor--otter-section', $path . 'js/gutenberg-editor/otter-section.js' );
		wp_enqueue_script( 'steller-main-editor--otter-section-column', $path . 'js/gutenberg-editor/otter-section-column.js' );
	}
}
