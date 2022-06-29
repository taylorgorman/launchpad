<?php

//use Launchpad\Setup;

add_action( 'init', function(){

	// Page excerpt
	add_post_type_support( 'page', 'excerpt' );

	// Page comments
	//if ( Setup\option( 'support-page-comments' ) )
	//	add_post_type_support( 'page', 'comments' );
	//else
	//	remove_post_type_support( 'page', 'comments' );

} );
