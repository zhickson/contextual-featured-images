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

    public function setUp() {
        parent::setUp();

        $this->class_instance = new Contextual_Featured_Images();
    }

    public function tearDown() {

        parent::tearDown();  
        
	}

}