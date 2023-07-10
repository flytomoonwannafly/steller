<?php

namespace Theme\Steller;

use WP_Customize_Image_Control;

class WP_Customizer {

    /**
     * WP_Theme constructor.
     */
    public function __construct() {
        $this->init_hooks();
    }

    public function init_hooks() {
        add_action( 'customize_register', [ $this, 'steller_footer_items_customize_register' ] );
    }
	function steller_footer_items_customize_register($wp_customize) {
		$wp_customize->add_section('footer_items_section', array(
			'title' => 'Footer Section',
			'priority' => 30
		));
		$wp_customize->add_setting('facebook_link_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control('facebook_link_control', array(
			'label' => 'Facebook link',
			'section' => 'footer_items_section',
			'settings' => 'facebook_link_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('facebook_class_icon_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control('facebook_class_icon_control', array(
			'label' => 'Facebook class icon',
			'section' => 'footer_items_section',
			'settings' => 'facebook_class_icon_setting',
			'type' => 'text'
		));

		$wp_customize->add_setting('google_link_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control('google_link_control', array(
			'label' => 'Google link',
			'section' => 'footer_items_section',
			'settings' => 'google_link_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('google_class_icon_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control('google_class_icon_control', array(
			'label' => 'Google class icon',
			'section' => 'footer_items_section',
			'settings' => 'google_class_icon_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('github_link_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control('github_link_control', array(
			'label' => 'Github link',
			'section' => 'footer_items_section',
			'settings' => 'github_link_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('github_class_icon_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control('github_class_icon_control', array(
			'label' => 'Github class icon',
			'section' => 'footer_items_section',
			'settings' => 'github_class_icon_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('twitter_link_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));
		$wp_customize->add_control('twitter_link_control', array(
			'label' => 'Twitter link',
			'section' => 'footer_items_section',
			'settings' => 'twitter_link_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('twitter_class_icon_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control('twitter_class_icon_control', array(
			'label' => 'Twitter class icon',
			'section' => 'footer_items_section',
			'settings' => 'twitter_class_icon_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('text_copyright_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control('text_copyright_control', array(
			'label' => 'Text copyright',
			'section' => 'footer_items_section',
			'settings' => 'text_copyright_setting',
			'type' => 'text'
		));
		$wp_customize->add_setting('link_copyright_setting', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field'
		));

		$wp_customize->add_control('link_copyright_control', array(
			'label' => 'Link copyright',
			'section' => 'footer_items_section',
			'settings' => 'link_copyright_setting',
			'type' => 'text'
		));
	}
}