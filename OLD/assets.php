<?php
/**
 * Set up scripts and styles
 * TO DO: Maybe do this with MakeAdmin?
 */
use Launchpad\Setup;

add_action( 'admin_enqueue_scripts', function(){

	$version = WP_DEBUG ? time() : Setup\version();

	wp_enqueue_style(
    Setup\name(),
    plugin_dir_url( __FILE__ ) . 'assets/styles.css',
    [],
    $version
  );
	// wp_enqueue_script(
  //   Setup\name(),
  //   plugin_dir_url( __FILE__ ). 'assets/scripts.js',
  //   [],
  //   $version,
  //   true
  // );

} );
