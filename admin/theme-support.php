<?php

// Add theme supports
//
add_action( 'after_setup_theme', function(){

	$features = [
		'html5' => ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets'],
	];

	foreach ( $features as $feature => $args )
		add_theme_support( $feature, $args );

} );
