<?php
/*
** Get Jetpack's related posts
** You'll have to elsewhere turn off Jetpack's automatic insertion into the content
*/
function get_jetpack_related_posts( ) {

	// Bail if we don't have Jetpack
	if ( ! class_exists( 'Jetpack_RelatedPosts' ) || ! method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) )
		return false;

	// Get related post IDs
	$jrp_raw = Jetpack_RelatedPosts::init_raw()
		->set_query_name( 'jetpack-related-posts' )
		->get_for_post_id( get_the_ID(), [ 'size' => 3 ] );

	// Bail if we don't have related posts
	if ( empty($jrp_raw) )
		return false;

	// Translate
	foreach ( $jrp_raw as $i ) $related_IDs[] = $i['id'];

	// Get the posts
	$related = get_posts([
		'include'     => $related_IDs
	, 'numberposts' => 3
	]);

	return $related;

}
