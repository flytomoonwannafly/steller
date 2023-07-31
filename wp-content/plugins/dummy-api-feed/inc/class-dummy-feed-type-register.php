<?php

namespace Plugin\DummyApiFeed;

class DummyFeedTypeRegister{
	public function __construct() {
		add_action('init', [ $this, 'register_dummy_feed_post_type' ]);
		add_action('admin_init', [ $this, 'remove_dummy_feed_editor' ]);
		add_action('add_meta_boxes', [ $this, 'add_dummy_feed_meta_fields' ]);
		add_action('save_post', [ $this, 'save_dummy_feed_meta' ]);
		add_action( 'init', [ $this, 'register_dummy_tags_taxonomy' ] );
	}

	function register_dummy_feed_post_type() {
		$labels = array(
			'name'               => 'Dummy Feed',
			'singular_name'      => 'Dummy Feed',
			'add_new'            => 'Додати новий',
			'add_new_item'       => 'Додати новий Dummy Feed',
			'edit_item'          => 'Редагувати Dummy Feed',
			'new_item'           => 'Новий Dummy Feed',
			'view_item'          => 'Переглянути Dummy Feed',
			'search_items'       => 'Пошук Dummy Feed',
			'not_found'          => 'Dummy Feed не знайдено',
			'not_found_in_trash' => 'Dummy Feed не знайдено в кошику',
			'parent_item_colon'  => 'Батьківський Dummy Feed:',
			'menu_name'          => 'Dummy Feed',
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => 'dummy-feed' ),
			'capability_type'     => 'post',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'supports'            => array( 'title', 'editor' ),
			'menu_icon'           => 'dashicons-camera',
		);

		register_post_type( 'dummy-feed', $args );
	}
	function register_dummy_tags_taxonomy() {
		$labels = array(
			'name'              => 'Теги',
			'singular_name'     => 'Тег',
			'search_items'      => 'Пошук тегів',
			'all_items'         => 'Усі теги',
			'parent_item'       => 'Батьківський тег',
			'parent_item_colon' => 'Батьківський тег:',
			'edit_item'         => 'Редагувати тег',
			'update_item'       => 'Оновити тег',
			'add_new_item'      => 'Додати новий тег',
			'new_item_name'     => 'Новий тег',
			'menu_name'         => 'Теги',
		);

		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => 'dummy-tags' ), // Замініть на свій slug
		);

		register_taxonomy( 'dummy_tags', 'dummy-feed', $args );
	}

	function remove_dummy_feed_editor() {
		remove_post_type_support( 'dummy-feed', 'editor' );
	}
	function add_dummy_feed_meta_fields() {
		add_meta_box(
			'dummy-feed-meta',
			'Метадані Dummy Feed',
			[ $this, 'render_dummy_feed_meta_fields' ],
			'dummy-feed',
			'normal',
			'default'
		);
	}
	function save_dummy_feed_meta( $post_id ) {

		if ( ! isset( $_POST['dummy_feed_meta_nonce'] ) || ! wp_verify_nonce( $_POST['dummy_feed_meta_nonce'], 'save_dummy_feed_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['dummy_id'] ) ) {
			update_post_meta( $post_id, 'dummy_id', sanitize_text_field( $_POST['dummy_id'] ) );
		}

		if ( isset( $_POST['author_alias'] ) ) {
			update_post_meta( $post_id, 'author_alias', sanitize_text_field( $_POST['author_alias'] ) );
		}

		if ( isset( $_POST['publication_date'] ) ) {
			update_post_meta( $post_id, 'publication_date', sanitize_text_field( $_POST['publication_date'] ) );
		}
		if (isset($_POST['dummy_image'])) {
			update_post_meta($post_id, 'dummy_image', sanitize_text_field($_POST['dummy_image']));
		}

	}
	function render_dummy_feed_meta_fields( $post ) {
		$dummy_id = get_post_meta( $post->ID, 'dummy_id', true );
		$author_alias = get_post_meta( $post->ID, 'author_alias', true );
		$publication_date = get_post_meta( $post->ID, 'publication_date', true );
		$dummy_image = get_post_meta( $post->ID, 'dummy_image', true );


		wp_nonce_field( 'save_dummy_feed_meta', 'dummy_feed_meta_nonce' );

		echo '<label for="author_alias">Author alias:</label>';
		echo '<input type="text" id="author_alias" name="author_alias" value="' . esc_attr( $author_alias ) . '" style="width: 100%;" /><br>';

		echo '<label for="publication_date">Publication date:</label>';
		echo '<input type="text" id="publication_date" name="publication_date" value="' . esc_attr( $publication_date ) . '" style="width: 100%;" />';

		echo '<label for="dummy_tags">Id dummy post</label>';
		echo '<input type="text" id="dummy_id" name="dummy_id" value="' . esc_attr( $dummy_id ) . '" style="width: 100%;" />';

		echo '<label for="dummy_image">Image:</label>
        <input type="text" id="dummy_image" name="dummy_image" value="' . esc_attr( $dummy_image ) . '" style="width: 100%;" />
        <button class="button button-secondary" id="dummy_image_button">Add Image</button>';
	}
}
