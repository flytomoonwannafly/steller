<?php

namespace Plugin\DummyApiFeed;

class DummyApiClient {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'my_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'my_settings_init' ] );

	}

	function my_admin_menu() {
		add_menu_page(
			__( 'Dummy Api Client', 'my-textdomain' ),
			__( 'Dummy Api Client', 'my-textdomain' ),
			'manage_options',
			'dummy-api-client',
			[$this, 'my_admin_page_contents'],
			'dashicons-schedule',
			3
		);
	}

	function my_admin_page_contents() {
		?>
		<h1> <?php esc_html_e( 'Dummy api client application page', 'my-plugin-textdomain' ); ?> </h1>
		<form method="POST" action="options.php">
			<?php
			settings_fields( 'dummy-api-client' );
			do_settings_sections( 'dummy-api-client' );
			submit_button('Save');
			?>
		</form>
		<?php
	}

	function my_settings_init() {

		add_settings_section(
			'dummy_api_client_setting_section',
			__( 'Dummy api client settings', 'my-textdomain' ),
			[ $this, 'my_setting_section_callback_function' ],
			'dummy-api-client'
		);

		add_settings_field(
			'my_setting_field',
			__( 'Dummy api', 'my-textdomain' ),
			[ $this, 'my_setting_markup' ],
			'dummy-api-client',
			'dummy_api_client_setting_section'
		);

		register_setting( 'dummy-api-client', 'app_id_field' );
	}

	function my_setting_section_callback_function() {
		echo '<p>Intro text for our settings section</p>';
	}


	function my_setting_markup() {
		?>
		<label for="my-input"><?php _e( 'App ID' ); ?></label>
		<input type="text" id="my_setting_field" name="my_setting_field"
		       value="<?php echo get_option( 'my_setting_field' ); ?>">
		<?php
	}
}