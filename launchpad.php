<?php
/*
**  Plugin Name:  Launchpad
**  Plugin URI:   http://taylorpatrickgorman.com/wordpress-plugins/launchpad
**  Version:      1.0.0
**  Description:  Configures WordPress to a predetermined base
**  Author:       Taylor Gorman
**  Author URI:   http://taylorpatrickgorman.com
**
**  License:      GPL2
**  License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/


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

// Back-end
//
require_once 'admin/assets.php';
require_once 'admin/admin-fields.php';
require_once 'admin/settings-launchpad.php';
require_once 'admin/settings-contact.php';
require_once 'admin/roles.php';
require_once 'admin/page.php';
require_once 'admin/menu.php';
require_once 'admin/tinymce.php';
require_once 'admin/dashboard-widgets.php';
require_once 'admin/media.php';
require_once 'admin/users.php';
require_once 'admin/post-types-sorting.php';
require_once 'admin/layouts.php';
//require_once 'admin/new-user-email.php';
//require_once 'admin/featured-icon.php';

// Front-end
//
require_once 'public/lp-register-post-type.php';
require_once 'public/lp-register-taxonomy.php';
require_once 'public/get-post-thumbnail-url.php';
require_once 'public/minutes-to-read.php';
require_once 'public/date-range.php';
require_once 'public/get-adjacent-page.php';
require_once 'public/is-any-tax.php';
require_once 'public/get-jetpack-related-posts.php';
require_once 'public/the-field-markup.php';
require_once 'public/meta.php';
require_once 'public/wp-head.php';
require_once 'public/scripts.php';
require_once 'public/excerpt.php';
require_once 'public/content.php';
require_once 'public/classes.php';
require_once 'public/theme-support.php';
require_once 'public/images.php';

//if ( ! empty( $lp['post-formats'] ) )
//	require_once 'public/format-meta.php';
