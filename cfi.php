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

if ( ! class_exists( 'Contextual_Featured_Images' ) ) :
	
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
		 * @access private
		 * 
		 * @var CFI()
		 */
		protected static $_instance;

		/**
		 * Constructs all the things.
		 * 
		 * @since 1.0.0
		 *
		 * @return void
		 */
		private function __construct() {

			// PHP version
			if ( ! defined( 'CFI_REQUIRED_PHP_VERSION' ) ) {
				define( 'CFI_REQUIRED_PHP_VERSION', '5.6.0' );
			}

			// Check minimum PHP version before loading plugin
			if ( function_exists( 'phpversion' ) && version_compare( CFI_REQUIRED_PHP_VERSION, phpversion(), '>' ) ) {
				add_action( 'admin_notices', array( $this, 'minimum_phpversion_notice' ) );

				return;
			}

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 0 );

			// Admin specific actions
			if ( is_admin() ) { 
				add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_dependencies' ) );
				add_action( 'wp_ajax_save_custom_image', array( $this, 'save_custom_image' ) );
				add_action( 'wp_ajax_remove_custom_image', array( $this, 'remove_custom_image' ) );
				add_action( 'wp_ajax_get_custom_image_ajax', array( $this, 'get_custom_image_ajax' ) );
			} else {
				// Frontend specific actions
				add_filter( 'get_post_metadata', array( $this, 'get_post_meta_override' ), 10, 4 );
			}

			do_action( 'cfi_loaded' );
			
		}

		/**
		 * Returns the current singleton instance.
		 * 
		 * @since 1.0.0
		 * @access public
		 * 
		 * @static
		 * @see CFI()
		 *
		 * @return Contextual_Featured_Images
		 */
		public static function getInstance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_textdomain() {

			load_plugin_textdomain( 'cfi', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

		}

		/**
		 * Shows a minimum PHP version notice.
		 * 
		 * Basically we're requiring at least PHP v5.6 or higher.
		 * This is reflected in readme.txt
		 *
		 * @since  1.0.0
		 * @see the wonderful Give plugin by Impress.org
		 */
		public function minimum_phpversion_notice() {
			
			// Gotta be in the Dashboard.
			if ( ! is_admin() ) {
				return;
			}

			$notice_desc  = '<p><strong>' . __( 'Your site could be faster and more secure with a newer PHP version.', 'cfi' ) . '</strong></p>';
			$notice_desc .= '<p>' . __( 'Hey, we\'ve noticed that you\'re running an outdated version of PHP. PHP is the programming language that WordPress and Give are built on. The version that is currently used for your site is no longer supported. Newer versions of PHP are both faster and more secure. In fact, your version of PHP no longer receives security updates, which is why we\'re sending you this notice.', 'cfi' ) . '</p>';
			$notice_desc .= '<p>' . __( 'Hosts have the ability to update your PHP version, but sometimes they don\'t dare to do that because they\'re afraid they\'ll break your site.', 'cfi' ) . '</p>';
			$notice_desc .= '<p><strong>' . __( 'To which version should I update?', 'cfi' ) . '</strong></p>';
			$notice_desc .= '<p>' . __( 'You should update your PHP version to either 5.6 or to 7.0 or 7.1. On a normal WordPress site, switching to PHP 5.6 should never cause issues. We would however actually recommend you switch to PHP7. There are some plugins that are not ready for PHP7 though, so do some testing first. PHP7 is much faster than PHP 5.6. It\'s also the only PHP version still in active development and therefore the better option for your site in the long run.', 'cfi' ) . '</p>';
			
			echo sprintf(
				'<div class="notice notice-error">%1$s</div>',
				wp_kses_post( $notice_desc )
			);

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
					array( 'wp-element', 'jquery' ), 
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
		 * Returns an array of taxonomies/terms assigned to
		 * the current post.
		 * 
		 * @since 1.0.0
		 *
		 * @global Object $post The current Post object.
		 * 
		 * @return array Array of supported post types.
		 */
		public function get_object_terms() {
			global $post;

			$final_terms = array();

			$taxonomies = get_object_taxonomies( $post );

			foreach ( $taxonomies as $term ) {
				$post_terms = get_the_terms( $post->ID, $term );

				if ( $post_terms && ! is_wp_error( $post_terms ) ) {
				
					foreach ( $post_terms as $cat ) {
						$final_terms[] = array( 'id' => $cat->term_id, 'name' => $cat->name, 'slug' => $cat->slug );
					}

				}
			}

			return $final_terms;
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
			$term = get_queried_object();
			
			if ( isset( $term->term_id ) ) {

				// If we have context, override with the featured_image_id
				$custom_key = '_cfi_catch_' . $term->term_id;
				$featured_image_id = get_post_meta( $post_id, $custom_key, true );
				return $featured_image_id;

			}
			
			// Otherwise, return the default featured image
			return $featured_image_id;

		}

	}

endif; // End if class_exists check

/**
 * Starts up Contextual Featured Images
 * 
 * The main function responsible for returning the one true 
 * Contextual_Featured_Images instance.
 * 
 * Example: <?php $cfi = CFI(); ?>
 * 
 * @since 1.0
 * @return object|CFI
 */
function CFI() {
	return Contextual_Featured_Images::getInstance();
}

CFI();