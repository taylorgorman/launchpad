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

use Launchpad\Changes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

// On activation and deactivation
register_activation_hook( __FILE__, function () {

	// Save default Launchpad settings upon activation
	$option_value = array_reduce( Changes\definitions(), function ( $wp_option, $change_group ) {
		// Change title case to kebab-case
		$group_name = sanitize_title( $change_group['title'] );
		// Reformat array to look like value that MakeAdmin puts in wp_options table
		$group_changes = array_map( function ( $change ) {
			return empty( $change['default'] ) ? null : $change['title'];
		}, $change_group['changes'] );
		// array_filter clears empty values
		$wp_option[$group_name] = array_filter( $group_changes );
		return $wp_option;
	}, [] );
	// Save in wp_options table
	add_option( 'launchpad', $option_value );

} );

register_deactivation_hook( __FILE__, function () {
	// Delete settings upon deactivation
	// Should we not do this? Somehow ask the user if they want it or not?
	delete_option( 'launchpad' );
} );

// Load this plugin first, so its resources are available to everyone.
add_action( 'activated_plugin', function (){

	$plugin_url = plugin_basename( __FILE__ );
	$active_plugins = get_option( 'active_plugins', [] );
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
// Helps us easily render WP Admin UI
// Yes, I'm hijacking Composer's "vendor" folder.
// I'll stop doing that in a later update after MakeAdmin gets a Composer package.
require_once 'vendor/make-admin/index.php';
// Very basic data about this plugin. Title, name, version.
require_once 'setup/constants.php';
// The meat and potatoes. Imports the actual settings and how to execute them.
require_once 'changes/definitions.php';
// Executes changes that are checked in the admin
require_once 'changes/executions.php';
// Renders the WP Admin page with the checkboxes
require_once 'admin-ui/settings.php';
