<?php

use Launchpad\Setup;

add_action( 'wp_enqueue_scripts', function(){

	if ( is_admin() )
		return;

	$v = WP_DEBUG ? time() : Setup\version();

	//wp_enqueue_style( Setup\name(), plugin_dir_url( __FILE__ ). 'css/styles.css', [], $v );
	//wp_enqueue_script( Setup\name(), plugin_dir_url( __FILE__ ). 'js/scripts.js', [], $v, true );


	// jQuery
	$jquery_version = '3.3.1';
	$jquery_url = '//code.jquery.com/jquery-' . $jquery_version . '.min.js';
	$jquery_test = @fopen( 'http:' . $jquery_url, 'r' );

	if ( $jquery_test !== false ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', $jquery_url, false, $jquery_version, true );
	}

} );
