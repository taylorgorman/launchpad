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
require 'lib/setup.php';
require 'lib/util.php';

// Back-end
//
// TO DO: admin fields from.. roundabout?
// TO DO: Are settings pages using settings api?
// TO DO: Remove Launchpad settings screen - plugin should be invisible
// TO DO: Admin setting for seeing other's media. Plenty of sites would need to reuse media between authors.
//
require_once 'admin/admin-fields.php';
require_once 'admin/assets.php';
require_once 'admin/media.php';
require_once 'admin/menu.php';
require_once 'admin/page.php';
require_once 'admin/post-formats.php';
require_once 'admin/roles.php';
require_once 'admin/settings-contact.php';
require_once 'admin/users.php';
//require_once 'admin/new-user-email.php';
//require_once 'admin/featured-icon.php';

// Front-end
//
// TO DO: Test get_jetpack_related_posts
// TO DO: Check classes.php
// TO DO: Check theme-support.php
// TO DO: Put post format checkboxes in Settings/Writing
// TO DO: Do we even need images.php?
// TO DO: Post format meta with Gutenburg? Or still need to provide?
//
require_once 'public/lp-register-post-type.php';
require_once 'public/lp-register-taxonomy.php';
require_once 'public/minutes-to-read.php';
require_once 'public/date-range.php';
require_once 'public/get-jetpack-related-posts.php';
require_once 'public/the-field-markup.php';
require_once 'public/wp-head.php';
require_once 'public/excerpt.php';
require_once 'public/content.php';
require_once 'public/classes.php';
require_once 'public/theme-support.php';
require_once 'public/images.php';

//if ( ! empty( $lp['post-formats'] ) )
//	require_once 'public/format-meta.php';
