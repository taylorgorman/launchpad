<?php
/**
 * Plugin Name:  Launchpad
 * Plugin URI:   https://thegorman.group/wordpress/launchpad
 * Version:      2.0.0
 * Description:  Tightens up really basic WordPress settings and UI, provides extra developer functions
 * Author:       Taylor Gorman
 * Author URI:   https://thegorman.group
 *
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

// Load this plugin first, so its resources are available to everyone.
add_action( 'activated_plugin', function(){

	$plugin_url = plugin_basename( __FILE__ );
	$active_plugins = get_option( 'active_plugins', array() );
	$key = array_search( $plugin_url, $active_plugins );

	if ( ! $key )
		return;

	array_splice( $active_plugins, $key, 1 );
	array_unshift( $active_plugins, $plugin_url );
	update_option( 'active_plugins', $active_plugins );

} );

/**
 * Import everything
 */
require_once 'vendor/make-admin/index.php';
require_once 'setup/constants.php';
require_once 'changes/definitions.php';
require_once 'changes/executions.php';
require_once 'admin-ui/settings.php';
