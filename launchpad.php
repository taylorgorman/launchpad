<?php
/**
 * Plugin Name:  Launchpad
 * Plugin URI:   https://taylorgorman.io/wordpress/launchpad
 * Version:      2.0.0
 * Description:  Tightens up really basic WordPress settings and UI, provides extra developer functions
 * Author:       Taylor Gorman
 * Author URI:   https://thegorman.group
 *
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 */

 /**
	* Security
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

// Global
require_once 'lib/setup.php';

// Back-end
require_once 'admin/admin-field.php';
require_once 'admin/assets.php';
require_once 'admin/media-permissions.php';
require_once 'admin/media-sizes.php';
require_once 'admin/menu.php';
// require_once 'admin/new-user-email.php';
require_once 'admin/page.php';
require_once 'admin/post-formats.php';
require_once 'admin/roles.php';
require_once 'admin/settings-contact.php';
require_once 'admin/theme-support.php';
require_once 'admin/users.php';

// Front-end
require_once 'public/excerpt.php';
require_once 'public/get-jetpack-related-posts.php';
require_once 'public/minutes-to-read.php';
