<?php

namespace Theme\Steller;

class WP_Gravity {
    /**
     * WP_Theme constructor.
     */
    public function __construct() {
        $this->init_hooks();
    }

    public function init_hooks() {
        add_filter( 'gform_field_container', [ $this, 'customize_gravityforms_1_container' ], 10, 6 );
        add_filter( 'gform_submit_button', [ $this, 'customize_gravityforms_submit_button' ], 10, 6 );
        add_filter( 'pre_option_rg_gforms_disable_css', '__return_true');

    }

    /*
 * Change display gravity form contact
 */
    function customize_gravityforms_1_container($field_container, $field, $form, $css_class, $style, $field_content) {
        if ($field->id == 1) {
            // Додайте ваші власні стилі CSS тут
            $field_container = '<div class="form-group"><input type="email" name="input_1" id="input_1_1"  class="form-control"  aria-describedby="emailHelp" placeholder="Enter email" required=""></div>';
        }
        if ($field->id == 3) {
            // Додайте ваші власні стилі CSS тут
            $field_container = '<div class="form-group"><input type="password" class="form-control" name="input_3" id="input_1_3"  placeholder="Password" required=""></div>';
        }
        if ($field->id == 7) {
            // Додайте ваші власні стилі CSS тут
            $field_container = '<div class="form-group"><textarea  name="input_7" id="input_1_7"  cols="30" rows="5" class="form-control" placeholder="Message"></textarea></div>';
        }
        return $field_container;

    }
	function customize_gravityforms_submit_button($button, $form) {
		$button = preg_replace('/<input/', '<input class="btn btn-primary btn-block rounded w-lg"', $button);
		return $button;
	}

}