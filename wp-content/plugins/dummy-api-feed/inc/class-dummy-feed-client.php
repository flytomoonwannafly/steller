<?php

namespace Plugin\DummyApiFeed;

class DummyApiClient {

	private $user;
	private $app_id;

	public function __construct( $user, $app_id ) {
		$this->user   = $user;
		$this->app_id = $app_id;
	}

	public function get_posts_by_user() {
		if ( empty( $this->user ) ) {
			return 'Error: User ID not specified.';
		}
		if ( empty( $this->app_id ) ) {
			return 'Error: App ID not specified.';
		}

		$api_url = 'https://dummyapi.io/data/v1/user/' . $this->user . '/post';

		$headers = array(
			'app-id' => $this->app_id,
		);

		$response = wp_remote_get( $api_url, array( 'headers' => $headers ) );

		if ( is_wp_error( $response ) ) {
			return 'Error: ' . $response->get_error_message();
		}

		$response_code = wp_remote_retrieve_response_code( $response );

		if ( $response_code === 200 ) {
			$data = wp_remote_retrieve_body( $response );

			$parsed_data = json_decode( $data, true );

			return $parsed_data['data'];
		} else {
			return 'Error: Something went wrong.';
		}
	}
}