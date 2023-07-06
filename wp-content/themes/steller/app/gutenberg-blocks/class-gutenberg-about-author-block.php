<?php

namespace Theme\Steller\GutenbergBlock;

use Theme\Steller\WP_Theme;

class GutenbergAboutAuthorBlock extends GutenbergBlock
{
	const BLOCK_NAME = 'steller-about_author';

	/**
	 * Registers a new Gutenberg block.
	 */
	public function register_block()
	{
		if (function_exists('acf_register_block')) {
			acf_register_block(array(
				'name' => self::BLOCK_NAME,
				'title' => __('About Author Section', WP_Theme::TEXT_DOMAIN),
				'description' => __('TODO://add description', WP_Theme::TEXT_DOMAIN), // TODO: add description
				'render_template' => WP_Theme::get_directory() . '/template-parts/gutenbergs-blocks/about-author.php',
				'category' => 'steller-blocks',
				'icon' => 'tagcloud',
				'keywords' => array('about-author', 'steller'),
				'supports' => array(
					'align' => array('full'),
					'mode' => true,
					'jsx' => true
				),
				'enqueue_assets' => function () {
					wp_enqueue_style('gutenberg-block-' . self::BLOCK_NAME, WP_Theme::get_directory_uri() . '/assets/css/gutenberg-blocks/gutenberg-about-author-block.css', [], WP_Theme::THEME_VERSION);
					wp_enqueue_script('gutenberg-block-' . self::BLOCK_NAME, WP_Theme::get_directory_uri() . '/assets/scripts/gutenberg-blocks/gutenberg-about-author-block.js', ['jquery'], WP_Theme::THEME_VERSION, true);
					wp_enqueue_script('youtube-video-modal', WP_Theme::get_directory_uri() . '/assets/scripts/youtube-video-modal.js', ['jquery'], WP_Theme::THEME_VERSION, true);
				},
			));
		}
	}
}