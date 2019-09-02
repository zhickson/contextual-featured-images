<?php

/*
Plugin Name: Disable deleting and updating CFI
Description: Disable deleting and updating -actions for CFI plugin. Being able to delete your local development directory from WordPress is catastrophic and you can lose your git history in the process.
Version: 2.0
Author: Automattic/zhickson
Author URI: http://automattic.com/
*/

// These are the plugins we don't want to update or delete
$cfi_docker_avoided_plugins = array(
	'contextual-featured-images/cfi.php',
);

/**
 * Remove the Delete link from your plugins list for important plugins
 */
function cfi_docker_disable_plugin_deletion_link( $actions, $plugin_file, $plugin_data, $context ) {
	global $cfi_docker_avoided_plugins;
	if (
		array_key_exists( 'delete', $actions ) &&
		in_array(
			$plugin_file,
			$cfi_docker_avoided_plugins
		)
	) {
		unset( $actions['delete'] );
	}
	return $actions;
}
add_filter( 'plugin_action_links', 'cfi_docker_disable_plugin_deletion_link', 10, 4 );

/**
 * Fail deletion attempts of our important plugins
 */
function cfi_docker_disable_delete_plugin( $plugin_file ) {
	global $cfi_docker_avoided_plugins;
	if ( in_array( $plugin_file, $cfi_docker_avoided_plugins ) ) {
		wp_die(
			'Deleting plugin "' . $plugin_file . '" is disabled at mu-plugins/avoid-plugin-deletion.php',
			403
		);
	}
}
add_action( 'delete_plugin', 'cfi_docker_disable_delete_plugin', 10, 2 );

/**
 * Stop WordPress noticing plugin updates for important plugins
 */
function cfi_docker_disable_plugin_update( $plugins ) {
	global $cfi_docker_avoided_plugins;
	foreach( $cfi_docker_avoided_plugins as $avoided_plugin ) {
		if ( isset( $plugins->response[ $avoided_plugin ] ) ) {
			unset( $plugins->response[ $avoided_plugin ] );
		}
	}
	return $plugins;
}
add_filter( 'site_transient_update_plugins', 'cfi_docker_disable_plugin_update' );
