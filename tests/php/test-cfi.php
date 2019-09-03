<?php 
/**
 * Class Contextual_Featured_ImagesTest
 *
 * @package Contextual_Featured_Images
 */

/**
 * Primary test case.
 */

class Contextual_Featured_ImagesTest extends WP_UnitTestCase {

    private $admin_user_id;
    private $post;
    private $published_post_id = null;
	private $original_user = 0;

    public function setUp() {

        parent::setUp();

        // First create a post to test on
        $post_id = $this->factory->post->create( array( 'post_status' => 'publish' ) );
        $this->post = get_post( $post_id );
        
        wp_insert_post( $this->post->to_array() );
        
        // Setup fake user
        $this->admin_user_id = $this->factory->user->create( [ 'role' => 'admin' ] );
        wp_set_current_user( $this->admin_user_id );
        
        set_current_screen('edit.php');

        $this->cfi = CFI();

        $this->assertTrue( is_admin() );
    }

    public function tearDown() {

        wp_set_current_user( $this->original_user );

        parent::tearDown();  
        
    }

    public function test_plugin_loaded_success() {
        $this->assertTrue( class_exists( 'Contextual_Featured_Images' ) );
      }

    public function test_supported_post_types() {
        $types = $this->cfi->get_supported_types();

        $this->assertNotEmpty( $types );
    }

    // Add further Unit Tests

}