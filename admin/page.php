<?php
/*
** Modify Page post type
*/
add_action( 'init', function(){

	add_post_type_support( 'page', 'excerpt' );

	global $lp;
	if ( empty($lp['allow-page-comments']) )
		remove_post_type_support( 'page', 'comments' );

} );
