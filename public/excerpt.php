<?php

// WordPress settings
//
add_filter( 'excerpt_length', function(){ return 25; } );

// Allow shortcodes
//
add_filter( 'the_excerpt', 'do_shortcode' );

// Enforce trimming and stripping regardless of excerpt or content
// the_excerpt() trims content, but not excerpt
// get_the_excerpt() doesn't set length, doesn't output <p>
// I can't do this with filters because I'd need new parameters for the_excerpt() or get_the_excerpt()
//
function get_trimmed_excerpt( $length = 0, $post = null ) {

	// Get post object or bail
	$post = get_post( $post );
	if ( empty( $post ) )
		return '';

	// Get and strip excerpt text
	$excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
	$excerpt = do_shortcode( $excerpt );

	// Get length
	$length = intval( $length );
	if ( empty( $length ) )
		$length = apply_filters( 'excerpt_length', 55 );
	$length = intval( $length );

	// Return truncated
	return '<p>' . wp_trim_words( $excerpt, $length, apply_filters( 'excerpt_more', null ) ) . '</p>';

}
