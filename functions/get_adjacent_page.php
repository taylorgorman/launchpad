<?php
function get_adjacent_page( $previous = true ) {

	// Must be inside loop
	if ( ! $post = get_post() )
		return null;

	// Must be hierarchical (but doesn't actually have to be page)
	if ( ! is_post_type_hierarchical($post->post_type) )
		return null;

	// Get the post
	$adjacent_post = get_posts([
		'numberposts' => 1
	,	'post_type' => $post->post_type
	,	'menu_order' => ( $previous ? $post->menu_order - 1 : $post->menu_order + 1 )
	,	'post_parent' => $post->post_parent
	]);

	// Return or bail
	if ( ! empty($adjacent_post[0]) && is_object($adjacent_post[0]) )
		return $adjacent_post[0];
	else
		return null;

}
function get_next_page() {
	return get_adjacent_page( false );
}
function get_previous_page() {
	return get_adjacent_page( true );
}
