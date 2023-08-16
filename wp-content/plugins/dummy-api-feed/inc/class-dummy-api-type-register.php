<?php

namespace Plugin\DummyApiFeed;

class DummyApiTypeRegister {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'my_admin_menu' ] );
		add_action( 'auto_parse_data', [ $this, 'auto_parse_data' ] );
		add_action( 'wp', [ $this, 'schedule_cron_job' ] );
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
		add_submenu_page(
			'dummy-api-client',
			__( 'Auto parse', 'my-textdomain' ),
			__( 'Auto parse', 'my-textdomain' ),
			'manage_options',
			'dummy-api-client-subpage',
			[ $this, 'auto_parse_contents' ]
		);
	}

	function my_admin_page_contents() {
		if ( isset( $_POST['save_app_id'] ) && isset( $_POST['app_id_field'] ) ) {
			update_option( 'app_id_field', sanitize_text_field( $_POST['app_id_field'] ) );
			echo '<div class="updated"><p>' . __( 'App ID saved successfully.', 'my-textdomain' ) . '</p></div>';
		}
		if ( isset( $_POST['save_users_id'] ) && isset( $_POST['users_id_field'] ) ) {
			update_option( 'users_id_field', sanitize_textarea_field( $_POST['users_id_field'] ) );
			echo '<div class="updated"><p>' . __( 'Users ID Fields saved successfully.', 'my-textdomain' ) . '</p></div>';
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Dummy api client application page', 'my-plugin-textdomain' ); ?></h1>
			<form method="POST" action="">
				<label for="app_id_field"><?php _e( 'App ID', 'my-textdomain' ); ?></label>
				<div class="field-with-button">
					<input type="text" size="34" id="app_id_field" name="app_id_field"
					       value="<?php echo esc_attr( get_option( 'app_id_field' ) ); ?>">
					<button class="button button-primary" type="submit"
					        name="save_app_id"><?php _e( 'Save', 'my-textdomain' ); ?></button>
				</div>
				<label for="users_id_field"><?php _e( 'Users ID Fields', 'my-textdomain' ); ?></label>
				<div class="field-with-button">
					<textarea id="users_id_field" name="users_id_field" rows="5" cols="33"><?php echo esc_attr( get_option( 'users_id_field' ) ); ?></textarea>
					<br>
					<button class="button button-primary" type="submit"
					        name="parse_users_id"><?php _e( 'Parse immediately', 'my-textdomain' ); ?></button>
					<button class="button button-primary" type="submit"
					        name="save_users_id"><?php _e( 'Save changes', 'my-textdomain' ); ?></button>
				</div>
			</form>
		</div>
		<?php
		if ( isset( $_POST['parse_users_id'] ) && ! empty( $_POST['users_id_field'] ) ) {
			$parsed_data = $this->parse_data_immediately( $_POST['users_id_field'] );

			if ( $parsed_data ) {
				echo '<div class="updated"><p>' . __( 'Data parsed successfully and added to Dummy Feed.', 'my-textdomain' ) . '</p></div>';
			} else {
				echo '<div class="error"><p>' . __( 'Error parsing data.', 'my-textdomain' ) . '</p></div>';
			}
		}
	}

	function parse_data_immediately( $user_ids = '' ) {
		if ( empty( $user_ids ) ) {
			$user_ids = get_option( 'users_id_field' );
		}

		$start_time = current_time( 'mysql' );
		$log_file = 'dummy_api_log_' . date( 'Y-m-d_H-i-s', strtotime( $start_time ) ) . '.log';

		$parsed_data_all_users = array();
		$user_ids    = explode( ',', sanitize_text_field( $user_ids ) );

		foreach ( $user_ids as $user_id ) {
			$user_id                 = trim( $user_id );
			$parsed_data_single_user = new \Plugin\DummyApiFeed\DummyApiClient( $user_id, get_option( 'app_id_field' ) );
			$parsed_data_single_user = $parsed_data_single_user->get_posts_by_user();
			$i = 0;
			$log_handle = fopen( WP_CONTENT_DIR . '/logs/' . $log_file, 'a' );

			foreach ( $parsed_data_single_user as $data ) {
				$post_data = array(
					'post_title'  => $data['text'],

					'meta_input'  => array(
						'dummy_id'         => $data['id'],
						'publication_date' => $data['publishDate'],
						'author_alias'     => $data['owner']['title'] . ' ' . $data['owner']['firstName'] . ' ' . $data['owner']['lastName'],
					),
					'post_status' => 'publish',
					'post_type'   => 'dummy-feed',
				);
				//check dummy_id for uniq
				$existing_dummy_id = $this->get_post_id_by_dummy_id( $data['id'] );

				if ( ! $existing_dummy_id ) {
					$new_post_id = wp_insert_post( $post_data );
					if ( $new_post_id && ! is_wp_error( $new_post_id ) ) {
						//add tags to post
						wp_set_post_terms( $new_post_id, $data['tags'], 'dummy_tags' );

						$this->parse_data_and_add_image($data['image'], $new_post_id);
						$i++;
						//Record the log of the added post
						$log_msg = 'Пост з айді ' . $data['id'] . ' був доданий.' . PHP_EOL;
						error_log( $log_msg, 3, WP_CONTENT_DIR . '/logs/' . $log_file );
					}
				} else {
					// Write a log of a post that was not added due to a unique dummy_id
					$log_msg = 'Пост з айді ' . $data['id'] . ' не був доданий через не унікальний dummy_id.' . PHP_EOL;
					error_log( $log_msg, 3, WP_CONTENT_DIR . '/logs/' . $log_file );
				}
			}

			echo 'The number of posts that have been added - ' . $i;
			echo '<div class="updated"><p>' . __( 'Users ID Fields saved successfully.', 'my-textdomain' ) . '</p></div>';
			$parsed_data_all_users[] = $parsed_data_single_user;
			fclose( $log_handle );
		}

		return $parsed_data_all_users;
	}

	function get_post_id_by_dummy_id( $dummy_id ) {
		$args = array(
			'post_type'      => 'dummy-feed',
			'meta_key'       => 'dummy_id',
			'meta_value'     => $dummy_id,
			'posts_per_page' => 1,
			'fields'         => 'ids',
		);

		$posts = get_posts( $args );

		if ( ! empty( $posts ) ) {
			return $posts[0];
		}

		return false;
	}
	function parse_data_and_add_image( $image_url, $post_id ) {
		$image_data = wp_remote_get( $image_url );

		if ( is_wp_error( $image_data ) ) {
			error_log( 'Error loading image: ' . $image_data->get_error_message() );
			return;
		}

		$image_code = $image_data['response']['code'];

		if ( $image_code !== 200 ) {
			error_log( 'Error loading image. Response code: ' . $image_code );
			return;
		}

		$image_name = basename( $image_url );

		$upload_dir = wp_upload_dir();
		$image_path = trailingslashit( $upload_dir['path'] ) . $image_name;

		$image_file = fopen( $image_path, 'w' );
		if ( ! $image_file ) {
			error_log( 'Error creating image file' );
			return;
		}

		fwrite( $image_file, $image_data['body'] );
		fclose( $image_file );

		$image_mime_type = wp_check_filetype( $image_path );
		$attachment = array(
			'post_mime_type' => $image_mime_type['type'],
			'post_title'     => $image_name,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		$attach_id = wp_insert_attachment( $attachment, $image_path, $post_id );
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$attach_data = wp_generate_attachment_metadata( $attach_id, $image_path );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		if ( is_numeric( $attach_id ) ) {
			update_post_meta( $post_id, 'dummy_image', wp_get_attachment_image_src( $attach_id, 'full' )[0] );
		} else {
			error_log( 'Error adding image to media library' );
			return;
		}
	}
	function auto_parse_contents() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Dummy Api Client Second Subpage', 'my-plugin-textdomain' ); ?></h1>
			<p><?php esc_html_e( 'This is the content of the second subpage.', 'my-plugin-textdomain' ); ?></p>
		</div>
		<form method="POST" action="">
			<label for="enable_cron_job"><?php _e( 'Enable Cron Job', 'my-textdomain' ); ?></label>
			<input type="hidden" name="enable_cron_job" value="0">
			<input type="checkbox" id="enable_cron_job" name="enable_cron_job" value="1" <?php checked( get_option( 'enable_cron_job', true ), 1 ); ?>>
			<button class="button button-primary" type="submit" name="save_option_cron"><?php _e( 'Save', 'my-textdomain' ); ?></button>
		</form>
		<?php
		if ( isset( $_POST['save_option_cron'] ) ) {
			if ( isset( $_POST['enable_cron_job'] ) && $_POST['enable_cron_job'] === '1' ) {
				update_option( 'enable_cron_job', true );

				$this->schedule_cron_job();
				echo '<div class="notice notice-success is-dismissible"><p>Cron job has been enabled and scheduled successfully.</p></div>';
			} else {
				update_option( 'enable_cron_job', false );
				$this->unschedule_cron_job();
			}
		}
	}
	function schedule_cron_job() {
		if ( ! wp_next_scheduled( 'auto_parse_data' )  ) {
			wp_schedule_event( time(), 'ten_minutes', 'auto_parse_data' );
		}
	}

	function unschedule_cron_job() {
		wp_clear_scheduled_hook( 'auto_parse_data' );
	}

	function auto_parse_data($user_ids = '') {
		if ( empty( $user_ids ) ) {
			$user_ids = get_option( 'users_id_field' );
		}

		$start_time = current_time( 'mysql' );
		$log_file = 'dummy_api_log_' . date( 'Y-m-d_H-i-s', strtotime( $start_time ) ) . '.log';

		$parsed_data_all_users = array();
		$user_ids = explode( ',', sanitize_text_field( $user_ids ) );

		$total_added_posts = 0; // Лічильник доданих постів

		foreach ( $user_ids as $user_id ) {
			$user_id = trim( $user_id );
			$parsed_data_single_user = new \Plugin\DummyApiFeed\DummyApiClient( $user_id, get_option( 'app_id_field' ) );
			$parsed_data_single_user = $parsed_data_single_user->get_posts_by_user();

			$i = 0;
			$log_handle = fopen( WP_CONTENT_DIR . '/logs/' . $log_file, 'a' );

			foreach ( $parsed_data_single_user as $data ) {
				if ($total_added_posts >= 10) {
					break 2; // Завершити обробку всіх користувачів, якщо додано 10 постів
				}

				$post_data = array(
					'post_title' => $data['text'],

					'meta_input' => array(
						'dummy_id' => $data['id'],
						'publication_date' => $data['publishDate'],
						'author_alias' => $data['owner']['title'] . ' ' . $data['owner']['firstName'] . ' ' . $data['owner']['lastName'],
					),
					'post_status' => 'publish',
					'post_type' => 'dummy-feed',
				);

				// Перевірити dummy_id для унікальності
				$existing_dummy_id = $this->get_post_id_by_dummy_id( $data['id'] );

				if ( ! $existing_dummy_id ) {
					$new_post_id = wp_insert_post( $post_data );
					if ( $new_post_id && ! is_wp_error( $new_post_id ) ) {
						wp_set_post_terms( $new_post_id, $data['tags'], 'dummy_tags' );
						$total_added_posts++;
						$this->parse_data_and_add_image($data['image'], $new_post_id);
						$i++;
						//Record the log of the added post
						$log_msg = 'Пост з айді ' . $data['id'] . ' був доданий.' . PHP_EOL;
						error_log( $log_msg, 3, WP_CONTENT_DIR . '/logs/' . $log_file );
					}
				} else {
					// Write a log of a post that was not added due to a unique dummy_id
					$log_msg = 'Пост з айді ' . $data['id'] . ' не був доданий через не унікальний dummy_id.' . PHP_EOL;
					error_log( $log_msg, 3, WP_CONTENT_DIR . '/logs/' . $log_file );
				}
			}
			echo 'The number of posts that have been added - ' . $i;
			echo '<div class="updated"><p>' . __( 'Users ID Fields saved successfully.', 'my-textdomain' ) . '</p></div>';
			$parsed_data_all_users[] = $parsed_data_single_user;
			fclose( $log_handle );
		}

		return $parsed_data_all_users;
	}
}
