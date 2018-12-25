<?php
/*
** Filter WordPress defaults
*/
add_filter( 'excerpt_length', function(){ return 35; } );
add_filter( 'excerpt_more', function(){ return '&hellip;'; } );

// Activate shortcodes
add_filter( 'the_excerpt', 'do_shortcode' );


/*
** Enforce trimming and stripping regardless of excerpt or content
**
** get_trimmed_excerpt() will trim the content, but not the excerpt, so you won't have consistent lengths if one post has a giant excerpt.
** get_trimmed_excerpt() doesn't allow setting length on the fly
** I can't do this with filters because I'd need new parameters for the_excerpt() or get_the_excerpt()
**
** @param reqired  int           $length  Maximum number of words. Falls back to excerpt_length filter
** @param          object | int  $post    Post object or post ID. Allows to work outside the loop. Falls back to global $post object.
*/
function get_trimmed_excerpt( $length = false, $post = null ) {

	// Get post object or bail
	$post = get_post($post);
	if ( empty($post) )
		return false;

	// Get and strip excerpt text
	$excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
	$excerpt = strip_tags( strip_shortcodes( $excerpt ) );

	// Get length
	if ( empty($length) || ! is_int($length) )
		$length = apply_filters( 'excerpt_length', 55 );

	// Return truncated
	return wp_trim_words( $excerpt, $length, apply_filters( 'excerpt_more', '&hellip;' ) );

}
