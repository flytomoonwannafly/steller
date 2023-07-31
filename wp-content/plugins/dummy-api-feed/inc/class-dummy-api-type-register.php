<?php

namespace Plugin\DummyApiFeed;

class DummyApiTypeRegister {
	public function __construct() {
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
		if ( isset( $_POST['save_app_id'] ) && isset( $_POST['app_id_field'] ) ) {
			update_option( 'app_id_field', sanitize_text_field( $_POST['app_id_field'] ) );
			echo '<div class="updated"><p>' . __( 'App ID saved successfully.', 'my-textdomain' ) . '</p></div>';
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Dummy api client application page', 'my-plugin-textdomain' ); ?></h1>
			<form method="POST" action="">
				<label for="app_id_field"><?php _e( 'App ID', 'my-textdomain' ); ?></label>
				<div class="field-with-button">
					<input type="text" id="app_id_field" name="app_id_field"
					       value="<?php echo esc_attr( get_option( 'app_id_field' ) ); ?>">
					<button class="button button-primary" type="submit"
					        name="save_app_id"><?php _e( 'Save', 'my-textdomain' ); ?></button>
				</div>
				<label for="users_id_field"><?php _e( 'Users ID Fields', 'my-textdomain' ); ?></label>
				<div class="field-with-button">
					<textarea id="users_id_field" name="users_id_field"></textarea>
					<button class="button button-primary" type="submit"
					        name="parse_users_id"><?php _e( 'Parse', 'my-textdomain' ); ?></button>
				</div>
			</form>
		</div>
		<?php
		if ( isset( $_POST['parse_users_id'] ) && ! empty( $_POST['users_id_field'] ) ) {
			$user_ids    = explode( ',', sanitize_text_field( $_POST['users_id_field'] ) );
			$parsed_data = $this->parse_data_for_users( $user_ids );

			if ( $parsed_data ) {
				echo '<div class="updated"><p>' . __( 'Data parsed successfully and added to Dummy Feed.', 'my-textdomain' ) . '</p></div>';
			} else {
				echo '<div class="error"><p>' . __( 'Error parsing data.', 'my-textdomain' ) . '</p></div>';
			}
		}
	}

	function parse_data_for_users( $user_ids ) {
		$start_time = current_time( 'mysql' );
		$log_file = 'dummy_api_log_' . date( 'Y-m-d_H-i-s', strtotime( $start_time ) ) . '.log';

		$parsed_data_all_users = array();

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
}
