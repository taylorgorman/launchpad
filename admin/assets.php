<?php

use Launchpad\Setup;

add_action( 'admin_enqueue_scripts', function(){

	$v = WP_DEBUG ? time() : Setup\version();

	wp_enqueue_style( Setup\name(), plugin_dir_url( __FILE__ ) . 'css/styles.css', [], $v );
	//wp_enqueue_script( Setup\name(), plugin_dir_url( __FILE__ ). 'js/scripts.js', [], $v, true );

} );
