<?php

namespace Theme\Steller\GutenbergBlock;

use Theme\Steller\WP_Theme;

class GutenbergSkillsBlock extends GutenbergBlock
{
	const BLOCK_NAME = 'steller-skills';

	/**
	 * Registers a new Gutenberg block.
	 */
	public function register_block()
	{
		if (function_exists('acf_register_block')) {
			acf_register_block(array(
				'name' => self::BLOCK_NAME,
				'title' => __('Skills Section', WP_Theme::TEXT_DOMAIN),
				'description' => __('TODO://add description', WP_Theme::TEXT_DOMAIN), // TODO: add description
				'render_template' => WP_Theme::get_directory() . '/template-parts/gutenbergs-blocks/skills.php',
				'category' => 'steller-blocks',
				'icon' => 'tagcloud',
				'keywords' => array('skills', 'steller'),
				'supports' => array(
					'align' => array('full'),
					'mode' => true,
					'jsx' => true
				),
			));
		}
	}
}