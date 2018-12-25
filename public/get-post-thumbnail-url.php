<?php
/*
** This really should be in core
**
** @param  integer  $post_id
** @param  string   $size
*/
function get_post_thumbnail_url( $size = 'thumbnail', $post_id = false ) {

	// Works within the loop
	if ( empty($post_id) )
		$post_id = get_the_ID();

	// Get it
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );

	// Return
	return $thumb['0'];

}
