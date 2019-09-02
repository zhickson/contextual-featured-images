<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define( 'ABSPATH', '/var/www/html/' );

/*
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress installation defined above.
 */
define( 'WP_DEFAULT_THEME', 'default' );

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
define( 'WP_DEBUG', true );

// Enable error logging for tests
define( 'WP_DEBUG_LOG', true );

// Additional constants for better error log
@error_reporting( E_ALL );
@ini_set( 'log_errors', true );
@ini_set( 'log_errors_max_len', '0' );

define( 'WP_DEBUG_DISPLAY', false );
define( 'CONCATENATE_SCRIPTS', false );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.

define( 'DB_NAME', getenv( 'MYSQL_DATABASE' ) );
define( 'DB_USER', getenv( 'MYSQL_USER' ) );
define( 'DB_PASSWORD', getenv( 'MYSQL_PASSWORD' ) );
define( 'DB_HOST', getenv( 'MYSQL_HOST' ) );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define('AUTH_KEY',         '9bG)3Ez~t,aSpSW.@]3AUkj.T]/v^GA`)n3*s)%$YoX+tl(4LeGr=diZ;_1j1{Ck');
define('SECURE_AUTH_KEY',  'n}3(eP+^=|1np+5EX{kYeU+&j,~Js7Qv1cFTg_ 6&5rS9%-DCLif90Q)$b_=l)W$');
define('LOGGED_IN_KEY',    '}d$#1gV6q(k&5fKY# ^1V<#u<1I4i]NkDA1&,-%WO:;D2RS.@d)~)6G,~1KXh_lH');
define('NONCE_KEY',        'qMXm/w]NcKfxX<LwwQE=BvS}pC)IN|@Zk1:$#_^3%&$eZ.a#ckJ%l5V#F~3{N-#a');
define('AUTH_SALT',        'wq4kXM>Z15U5ZSmA6gEl7V#+g-3ir1@L[X4+v(~>qhS*lM%TTA|APl)5h]K[hXsN');
define('SECURE_AUTH_SALT', 'Sc&|^v%$Su}#urV}s&.e0O8zJai@Le6Ql+-~eBWM|39-[Hj/;[,l@7au}1UPv F8');
define('LOGGED_IN_SALT',   '`s(3nX`+$qh$+Dob#diUex%*B%&6crYN[`=Q9E{ Dz0ze/LIMBF|t(`b|UQBxJ3x');
define('NONCE_SALT',       'Gn+RtA++;7,dL}lbP:EjSQ}AzlszM2)fp3v,#zidu++_Awjnwi<UZV,_G-=fz^[X');

$table_prefix = 'wptests_';   // Only numbers, letters, and underscores please!

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );

define( 'WP_PHP_BINARY', 'php' );

define( 'WPLANG', '' );
