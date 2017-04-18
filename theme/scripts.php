<?php
/*
** Call jQuery from CDN
*/
add_action( 'wp_enqueue_scripts', function(){

	if ( is_admin() )
		return;

	$jquery_url = '//code.jquery.com/jquery-2.2.4.min.js';
	$test_url = @fopen( 'http:'.$jquery_url, 'r' );

	// Google CDN failed, keep using WordPress's
	if ( false === $test_url )
		$jquery_url = includes_url( '/js/jquery/jquery.js' );

	// Put it in the footer
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', $jquery_url, false, false, true );

} );
