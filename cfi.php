<?php
/**
 * Welcome to Contextual Featured Images
 *
 * Make yourself @ home.
 *
 * @link              https://dunktree.com/
 * @version           1.0.0
 * @package           Contextual_Featured_Images
 *
 * @wordpress-plugin
 * Plugin Name:       Contextual Featured Images
 * Plugin URI:        https://dunktree.com/
 * Description:       Displays a custom featured image depending on the context.
 * Version:           1.0.0
 * Author:            Zachary Hickson
 * Author URI:        https://dunktree.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cfi
 * Domain Path:       /languages
 * 
 * TODO: 
 * - Add REST API/Gutenberg Sidebar support
 * - Add Conditional logic for more advanced control
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Currently plugin version.
 * 
 * @since 1.0.0
 */
if( ! defined( 'CFI_VER' ) ) {
	define( 'CFI_VER', '1.0.0' );
}

/**
 * Sets up the primary plugin class.
 * 
 * @since 1.0.0
 */
class Contextual_Featured_Images {

	/**
	 * Holds our singleton instance.
	 * 
	 * @since 1.0.0
	 */
	static $instance = false;

	/**
	 * Constructs all the things.
	 * 
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function __construct() {
		// back end specific
		if ( is_admin() ) { 
			add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_dependencies' ) );
			add_action( 'wp_ajax_save_custom_image', array( $this, 'save_custom_image' ) );
			add_action( 'wp_ajax_remove_custom_image', array( $this, 'remove_custom_image' ) );
			add_action( 'wp_ajax_get_custom_image_ajax', array( $this, 'get_custom_image_ajax' ) );
		} else {
			// front end specific
			add_filter( 'get_post_metadata', array( $this, 'get_post_meta_override' ), 10, 4 );
		}
		
	}

	/**
	 * Returns the current singleton instance.
	 * 
	 * @since 1.0.0
	 *
	 * @return Contextual_Featured_Images
	 */
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}	
		return self::$instance;
	}

	/**
	 * Enqueues admin dependencies.
	 * 
	 * @since 1.0.0
	 */
	public function admin_dependencies() {

		$types = $this->get_supported_types();

		$screen	= get_current_screen();

		if ( in_array( $screen->post_type , $types ) ) {

			wp_enqueue_media();

			wp_enqueue_script( 
				'cfi_admin_script', 
				plugins_url( 'dist/scripts/cfi-admin.js', __FILE__ ), 
				array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post', 'wp-api', 'wp-api-fetch' ), 
				CFI_VER 
			);
			wp_localize_script( 
				'cfi_admin_script', 
				'cfi_ajax', 
				array(
					'url'   => admin_url( 'admin-ajax.php' ),
					'nonce' => wp_create_nonce( 'cfi_secure' ),
					'current_post' => absint( get_the_ID() ),
				)
			);
			
			wp_enqueue_style( 'cfi_admin_css', plugins_url( 'dist/styles/cfi-admin.css', __FILE__ ), false, CFI_VER );

		}

	}

	/**
	 * Registers Metabox.
	 * 
	 * Fallback for Classic Editor.
	 * 
	 * @since 1.0.0
	 *
	 * @return add_meta_box
	 */
	public function register_meta_boxes() {

		$types = $this->get_supported_types();

		if ( $types ) {

			foreach ( $types as $type ) {

				add_meta_box( 
					'cfi-meta-box', 
					__( 'Contextual Featured Images', 'cfi' ), 
					array( $this, 'metabox_display_callback' ), 
					$type,
					'advanced',
					'default',
					array(
						'__block_editor_compatible_meta_box' => true,
					)
				);

			}

		}

	}

	/**
	 * Includes the HTML view.
	 * 
	 * @since 1.0.0
	 * 
	 * @param Object $post The current Post/Page object. 
	 *
	 * @return HTML The view HTML code.
	 */
	public function metabox_display_callback( $post ) {

		// Get that sweet view
		include 'inc/views/html-metabox.php';

	}

	/**
	 * Saves the custom image.
	 * 
	 * Adds or updates the post meta for this object.
	 * 
	 * @since 1.0.0
	 *
	 * @return array JSON success or error.
	 */
	public function save_custom_image() {
		check_ajax_referer( 'cfi_secure', 'security' );

		// Create or Update the postmetadata
		if ( array_key_exists( 'cfi_meta_key', $_POST ) ) {
			$meta_key = sanitize_key( $_POST['cfi_meta_key'] );
			$post_id = intval( $_POST['cfi_post_id'] );
			$attachment_id = intval( $_POST['cfi_attachment_id'] );

			update_post_meta( $post_id, $meta_key, $attachment_id );

			// Send a success message back
			$response = array(
				'message' => __( 'Your image was saved succesfully.', 'cfi' ),
				'ID'      => $attachment_id,
			);
			wp_send_json_success( $response );
		}

		wp_send_json_error();

	}

	/**
	 * Deletes the custom image.
	 * 
	 * Deletes the post meta for this object.
	 * 
	 * @since 1.0.0
	 *
	 * @return array JSON success or error.
	 */
	public function remove_custom_image() {
		check_ajax_referer( 'cfi_secure', 'security' );

		// Create or Update the postmetadata
		if ( array_key_exists( 'cfi_meta_key', $_POST ) ) {
			$meta_key = sanitize_key( $_POST['cfi_meta_key'] );
			$post_id = intval( $_POST['cfi_post_id'] );
			$attachment_id = intval( $_POST['cfi_attachment_id'] );

			delete_post_meta( $post_id, $meta_key, $attachment_id );

			// Send a success message back
			$response = array(
				'message' => __( 'Your image was removed succesfully.', 'cfi' ),
				'ID'      => $attachment_id,
			);
			wp_send_json_success( $response );
		}

		wp_send_json_error();

	}

	/**
	 * Gets the custom image ID.
	 * 
	 * For use in AJAX requests.
	 * 
	 * @since 1.0.0
	 *
	 * @return array JSON success or error.
	 */
	public function get_custom_image_ajax() {
		check_ajax_referer( 'cfi_secure', 'security' );

		// Get the postmetadata
		$meta_key = sanitize_key( $_POST['cfi_meta_key'] );
		$post_id = intval( $_POST['cfi_post_id'] );

		$custom_image_id = get_post_meta( $post_id, $meta_key, true );

		if ( $custom_image_id ) {

			$attachment = get_post( $custom_image_id );

			if ( $attachment ) {

				$attachment_data = [];

				$attachment_data['id'] = $attachment->ID;
				$attachment_data['url'] = wp_get_attachment_thumb_url( $attachment->ID );


				// Send the data back
				$response = array(
					'ID'      		=> $post_id,
					'attachment' 	=> $attachment_data
				);

				wp_send_json_success( $response );
				
			} else {

				$response = array(
					'message' 		=> __( 'Error couldn\'t find attachment', 'cfi' ),
					'ID'      		=> $post_id,
				);

				wp_send_json_error( $response );

			}

		} else {

			$response = array(
				'message' 		=> __( 'No image saved for this attachment ID', 'cfi' ),
				'ID'      		=> $post_id,
			);

			wp_send_json_error( $response );

		}

		wp_send_json_error();

	}

	/**
	 * Returns the list of post types that support featured images.
	 * 
	 * @since 1.0.0
	 *
	 * @return array Array of supported post types.
	 */
	public function get_supported_types() {

		$types = get_post_types( array( 
			'public' => true, 
			'show_ui' => true 
		) );

		foreach( $types as $type ) {
			if( ! post_type_supports( $type, 'thumbnail' ) ) {
				unset( $types[ $type ] );
			}
		}

		return apply_filters( 'cfi_type_support', $types );
	}

	/**
	 * Filters the get_post_thumbnail_id() function.
	 * 
	 * A bit hacky, but what can you do ¯\_(ツ)_/¯
	 * (hacky because this applies to every single post meta request).
	 * 
	 * TODO: 
	 * - allow for setting one of the secondary featured images
	 *   to be the standard default featured image.
	 * 
	 * @since 1.0.0
	 * 
	 * @see https://core.trac.wordpress.org/ticket/23983
	 * 
	 * @param string $null The value that is being searched for in '_thumbnail_id'.
	 * @param string $post_id This is the Post ID. Default the current Post ID.
	 * @param string $meta_key This is the meta key. Default '_thumbnail_id'.
	 * @param bool $single Whether to return a single value, or array.
	 * 
	 * @return string $featured_image_id The ID of the custom or featured image.
	 */
	public function get_post_meta_override( $null, $post_id, $meta_key, $single ) {
		if ( '_thumbnail_id' !== $meta_key ) {
			return $null;
		}
	
		if ( is_admin() ) {
			return $null;
		}
	
		remove_filter( 'get_post_metadata', array( $this, 'get_post_meta_override' ), 10, 4 );
	
		$featured_image_id = get_post_thumbnail_id( $post_id );
	
		add_filter( 'get_post_metadata', array( $this, 'get_post_meta_override' ), 10, 4 );

		// First check the context
		$category = get_queried_object();
		
		if ( isset( $category->term_id ) ) {

			// If we have context, override with the featured_image_id
			$custom_key = '_cfi_catch_' . $category->term_id;
			$featured_image_id = get_post_meta( $post_id, $custom_key, true );
			return $featured_image_id;

		}
		
		// Otherwise, return the default featured image
		return $featured_image_id;

	}

}

// Boot up our class
$Contextual_Featured_Images = Contextual_Featured_Images::getInstance();