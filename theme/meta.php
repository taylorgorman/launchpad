<?php
/*
** Filter wp_title to add blog name, description, page number
*/
add_filter( 'wp_title', function ( $title, $sep ) {

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	if ( is_front_page() && $description = get_bloginfo( 'description', 'display' ) )
		$title .= " $sep $description";

	// Add a page number if necessary.
	global $paged, $page;
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep Page ". max($paged, $page);

	return $title;

}, 10, 2 );

/*
** Returns an appropriate description for the current page.
** Can be modified with bs_description filter.
*/
function bs_description() {

	$desc = '';

	if ( is_singular() && !is_front_page() && !is_home() )
		$desc = get_trimmed_excerpt( get_queried_object() );

	if ( strlen($desc) == 0 )
		$desc = get_bloginfo('description', 'display');

	echo apply_filters( 'bs_description', strip_tags($desc) );

}
