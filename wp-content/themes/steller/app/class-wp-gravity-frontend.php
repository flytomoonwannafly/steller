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
		add_filter( 'gform_field_input', [ $this, 'my_custom_field_input' ], 10, 5 );
		add_filter( 'gform_submit_button', [ $this, 'customize_gravityforms_submit_button' ], 10, 6 );


	}

	/*
 * Change display gravity form contact
 */

	function customize_gravityforms_submit_button( $button, $form ) {
		if ( $form['id'] === 1 ) {
			$button = preg_replace( '/<input/', '<input class="btn btn-primary btn-block rounded w-lg"', $button );

			return $button;
		}
	}

	function my_custom_field_input( $input, $field, $value, $lead_id, $form_id ) {
		if ( $form_id == 1 && $field->id == 1 ) {
			$input = '<input name="input_1" id="input_1_1" type="text" value="" class="large form-control" placeholder="Email" aria-invalid="false">';
		}
		if ( $form_id == 1 && $field->id == 3 ) {
			$input = '<input type="password" class="form-control" name="input_3" id="input_1_3"  placeholder="Password" required="">';
		}
		if ( $form_id == 1 && $field->id == 7 ) {
			$input = '<textarea  name="input_7" id="input_1_7"  cols="30" rows="5" class="form-control" placeholder="Message"></textarea>';
		}

		return $input;
	}

}