<?php
/*
** This really should be in core
**
** @param  integer  $post_id
** @param  string   $size
*/
function get_post_thumbnail_url( $post_id=0, $size='thumbnail' ) {

	// Works within the loop
	if ( $post_id == 0 ) {
		global $post;
		if ( !is_object($post) ) return;
		$post_id = $post->ID;
	}

	// Get it
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );

	// Return
	return $thumb['0'];

}
