<?php
/*
**  Plugin Name:  Launchpad
**  Plugin URI:   http://taylorpatrickgorman.com/wordpress-plugins/launchpad
**  Version:      2.0.0
**  Description:  Tightens up really basic WordPress settings and UI, provides extra developer functions
**  Author:       Taylor Gorman
**  Author URI:   http://taylorpatrickgorman.com
**
**  License:      GPL2
**  License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

// DON'T FORGET to change version number in lib/setup.php as well.

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

// Load this plugin first, so its resources are available to everyone.
//
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

// Activation & Deactivation
//
//register_activation_hook( __FILE__, function() {
//
//	require 'admin/activation.php';
//
//	Activation\activate();
//
//} );
//register_deactivation_hook( __FILE__, function() {
//
//	require 'admin/deactivation.php';
//
//} );

// Global
//
require_once 'lib/setup.php';

// Back-end
//
// TO DO: settings-contact.php: Is Settings/Contact using Settings API?
// TO DO: post-formats.php: Post format meta with Gutenburg? Or still need to provide?
// TO DO: media/sizes.php: Update default image sizes on plugin activation
// TO DO: media/sizes.php: Register new image sizes on plugin activation? Instead of every admin page load?
// TO DO: media/sizes.php: Remove CoAuthors sizes removal, let themes and other plugins do this
// TO DO: media/sizes.php: Change ls_new_image_sizes filter to give and receive size names only. Width and height should only be set on admin screen
//
require_once 'admin/admin-field.php';
require_once 'admin/assets.php';
require_once 'admin/media.php';
require_once 'admin/menu.php';
require_once 'admin/page.php';
require_once 'admin/post-formats.php';
require_once 'admin/roles.php';
require_once 'admin/settings-contact.php';
require_once 'admin/theme-support.php';
require_once 'admin/users.php';
//require_once 'admin/new-user-email.php';

/**
 * Front-end
 * TO DO: Test get_jetpack_related_posts
 */
require_once 'public/excerpt.php';
require_once 'public/get-jetpack-related-posts.php';
require_once 'public/minutes-to-read.php';
