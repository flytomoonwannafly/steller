<?php

namespace Plugin\DummyApiFeed;

class DummyApiTypeRegister {
	public function __construct() {
		add_action( 'admin_init', [ $this, 'my_settings_init' ] );
		add_action( 'admin_menu', [ $this, 'my_admin_menu' ] );
	}

	function my_admin_menu() {
		add_menu_page(
			__( 'Dummy Api Client', 'my-textdomain' ),
			__( 'Dummy Api Client', 'my-textdomain' ),
			'manage_options',
			'dummy-api-client',
			[ $this, 'my_admin_page_contents' ],
			'dashicons-schedule',
			3
		);
	}

	function my_admin_page_contents() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Dummy api client application page', 'my-plugin-textdomain' ); ?></h1>
			<form method="POST" action="options.php">
				<label for="app_id_field"><?php _e( 'App ID', 'my-textdomain' ); ?></label>
				<div class="field-with-button">

					<input type="text" id="app_id_field" name="app_id_field"
					       value="<?php echo esc_attr( get_option( 'app_id_field' ) ); ?>">

					<button class="button button-primary" type="submit"
					        name="save_app_id"><?php _e( 'Save', 'my-textdomain' ); ?></button>
				</div>
				<label for="users_id_field"><?php _e( 'Users ID Fields', 'my-textdomain' ); ?></label>
				<div class="field-with-button">
					<textarea id="users_id_field"
					          name="users_id_field"><?php echo esc_textarea( get_option( 'users_id_field' ) ); ?></textarea>
					<button class="button button-primary" type="submit"
					        name="parse_users_id"><?php _e( 'Parse', 'my-textdomain' ); ?></button>
				</div>
				<?php
				settings_fields( 'dummy-api-client' );
				do_settings_sections( 'dummy-api-client' );
				?>
			</form>
		</div>
		<?php
	}

	function my_settings_init() {
		add_settings_field(
			'app_id_field',
			__( 'App ID', 'my-textdomain' ),
			'dummy-api-client',
			'dummy_api_client_setting_section'
		);

		add_settings_field(
			'users_id_field',
			__( 'Users ID Fields', 'my-textdomain' ),
			'dummy-api-client',
			'dummy_api_client_setting_section'
		);

		register_setting( 'dummy-api-client', 'app_id_field' );
		register_setting( 'dummy-api-client', 'users_id_field' );
	}

}
