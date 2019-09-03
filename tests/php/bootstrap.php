<?php
/**
 * Bootstrap the plugin unit testing environment.
 *
 * @package Contextual_Featured_Images
 */

define( 'TESTING_IN_CFI', true );

// Support for:
// 1. `WP_DEVELOP_DIR` environment variable
// 2. Plugin installed inside of WordPress.org developer checkout
// 3. Tests checked out to /tmp
if( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
	// Defined on command line
	$test_root = getenv( 'WP_DEVELOP_DIR' );
} else if ( file_exists( '../../../../tests/phpunit/includes/bootstrap.php' ) ) {
	// Installed inside wordpress-develop
	$test_root = '../../../../tests/phpunit';
} else if ( file_exists( '/vagrant/www/wordpress-develop/public_html/tests/phpunit/includes/bootstrap.php' ) ) {
	// VVV
	$test_root = '/vagrant/www/wordpress-develop/public_html/tests/phpunit';
} else if ( file_exists( '/srv/www/wordpress-trunk/public_html/tests/phpunit/includes/bootstrap.php' ) ) {
	// VVV 3.0
	$test_root = '/srv/www/wordpress-trunk/public_html/tests/phpunit';
} else if ( file_exists( '/tmp/wordpress-develop/tests/phpunit/includes/bootstrap.php' ) ) {
	// Manual checkout & CFI's docker environment
	$test_root = '/tmp/wordpress-develop/tests/phpunit';
} else if ( file_exists( '/tmp/wordpress-tests-lib/includes/bootstrap.php' ) ) {
	// Legacy tests
	$test_root = '/tmp/wordpress-tests-lib';
}

echo "Using test root $test_root\n";

if ( '1' != getenv( 'WP_MULTISITE' ) &&
 ( defined( 'WP_TESTS_MULTISITE') && ! WP_TESTS_MULTISITE ) ) {
 echo "To run CFI's multisite, use -c tests/php.multisite.xml" . PHP_EOL;
 echo "Disregard Core's -c tests/phpunit/multisite.xml notice below." . PHP_EOL;
}

require $test_root . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( __FILE__ ) . '/../../cfi.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $test_root . '/includes/bootstrap.php';
