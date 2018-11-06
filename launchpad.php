<?php
/*
**  Plugin Name:  Launchpad
**  Plugin URI:   http://taylorpatrickgorman.com/wordpress-plugins/launchpad
**  Version:      0.0.1
**  Description:  Configures WordPress to a predetermined base
**  Author:       Taylor Gorman
**  Author URI:   http://taylorpatrickgorman.com
**
**  License:      GPL2
**  License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/


/*
** Constants
*/
define( 'LP_IS_LOCAL', $_SERVER['SERVER_NAME'] == 'localhost' );
define( 'LP_PATH', plugin_dir_path(__FILE__) );
define( 'LP_URL', plugin_dir_url(__FILE__) );

/*
** Settings
*/
global $lp;
$lp = get_option('launchpad');


/*
** Functions
*/
require_once 'functions/get_post_thumbnail_url.php';
require_once 'functions/highest_ancestor.php';
require_once 'functions/lp_list_contextually.php';
require_once 'functions/lp_paginate_links.php';
require_once 'functions/lp_register_post_type.php';
require_once 'functions/lp_register_taxonomy.php';
require_once 'functions/date_range.php';
require_once 'functions/minutes_to_read.php';
require_once 'functions/is_any_tax.php';
require_once 'functions/get_jetpack_related_posts.php';
require_once 'functions/the_field_markup.php';
require_once 'functions/get_adjacent_page.php';

/*
** Modify admin screens
*/
require_once 'admin/admin_fields.php';
require_once 'admin/settings-launchpad.php';
require_once 'admin/settings-contact.php';
require_once 'admin/roles.php';
require_once 'admin/page.php';
require_once 'admin/enqueues.php';
require_once 'admin/menu.php';
require_once 'admin/tinymce.php';
require_once 'admin/dashboard-widgets.php';
require_once 'admin/media.php';
require_once 'admin/users.php';
require_once 'admin/post-types-sorting.php';
require_once 'admin/layouts.php';

//require_once 'admin/new-user-email.php';
//require_once 'admin/featured-icon.php';

/*
** Add widgets
*/
require_once 'widgets/section-navigation.php';
require_once 'widgets/jp-related-posts.php';

/*
** Modify theme output
*/
require_once 'theme/wp_nav_menu.php';
require_once 'theme/meta.php';
require_once 'theme/wp_head.php';
require_once 'theme/scripts.php';
require_once 'theme/excerpt.php';
require_once 'theme/content.php';
require_once 'theme/classes.php';
require_once 'theme/theme_support.php';
require_once 'theme/images.php';
if ( ! empty($lp['post-formats']) )
	require_once 'theme/format-meta.php';


/*
** Load this plugin first, so its resources are available to everyone.
*/
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


/*
** Plugin activation
*/
function lp_activation_hook(){

	if ( ! current_user_can( 'activate_plugins' ) ) return;
	$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	check_admin_referer( "activate-plugin_{$plugin}" );

	do_action('lp_activation');

}
register_activation_hook( __FILE__, 'lp_activation_hook' );

/*
** Plugin deactivation
*/
function lp_deactivation_hook(){

	if ( ! current_user_can( 'activate_plugins' ) ) return;
	$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	check_admin_referer( "deactivate-plugin_{$plugin}" );

	do_action('lp_deactivation');

}
register_deactivation_hook( __FILE__, 'lp_deactivation_hook' );

/*
** Plugin uninstall
*/
function lp_uninstall_hook(){

	if ( ! current_user_can( 'activate_plugins' ) ) return;
	check_admin_referer( 'bulk-plugins' );
	if ( __FILE__ != WP_UNINSTALL_PLUGIN ) return;

	do_action('lp_uninstall');

}
register_uninstall_hook( __FILE__, 'lp_uninstall_hook' );
