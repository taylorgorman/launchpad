<?php

function get_highest_ancestor( $args=0 ) {

	$d = array(
		'id'     => 0
	,	'title'  => ''
	,	'name'   => ''
	,	'object' => false
	);
	$posttype = get_post_type();

	// Default homepage
	if ( is_front_page() && is_home() ) {

		$ancestor = array(
			'id'     => 0
		,	'title'  => 'home'
		,	'name'   => 'Home'
		);

	// Static front page
	} elseif ( is_front_page() ) {

		$front_page = get_post( get_option('page_on_front') );
		$ancestor = array(
			'id'     => $front_page->ID
		,	'title'  => $front_page->post_title
		,	'name'   => $front_page->post_name
		,	'object' => $front_page
		);

	// Static posts page
	} elseif ( is_home() ) {

		$home = get_post( get_option('page_for_posts') );
		$ancestor = array(
			'id'     => $home->ID
		,	'title'  => $home->post_title
		,	'name'   => $home->post_name
		,	'object' => $home
		);

	} elseif ( is_search() ) {

		$ancestor = array(
			'title' => 'Search Results' // Want to add number of search results
		,	'name'  => 'search'
		);

	} elseif ( is_page() ) {

		global $post;
		$page = $post;

		while ( $page->post_parent > 0 )
			$page = get_post( $page->post_parent );

		$ancestor = array(
			'id'     => $page->ID
		,	'title'  => $page->post_title
		,	'name'   => $page->post_name
		,	'object' => $page
		);

	} elseif ( is_singular() || is_post_type_archive() || is_tax() ) {

		$pt_obj = get_post_type_object( $posttype );
		$ancestor = array(
			'id'     => 0
		,	'title'  => $pt_obj->label
		,	'name'   => $posttype
		,	'object' => $pt_obj
		);

	} elseif ( is_404() ) {

		$ancestor = array(
			'title' => 'Page Not Found'
		,	'name'  => 'error404'
		);

	/* Need to finish.
	** Not 100% confident about the get_taxonomy function or its results.
	**
	} elseif ( is_tax() ) {

		$queried = get_queried_object();
		$tax = get_taxonomy($queried->taxonomy);
		$ancestor = array(
			'id'    => $queried->term_id
		,	'title' => $queried->name
		,	'name'  => $queried->slug
		);

	} elseif (is_year()) {

	} elseif (is_month()) {

	} elseif (is_day()) {

	} elseif (is_author()) {

	} elseif (is_attachment()) {
	*/

	} else {

		$ancestor = array(
			'title' => wp_title( '', false )
		);

	}

	$ancestor = wp_parse_args( $ancestor, $d );
	return $ancestor;

}

function highest_ancestor( $echo='title' ) {

	$ancestor = get_highest_ancestor();
	echo $ancestor[$echo];

}

function is_highest_ancestor() {

	global $post;

	if ( is_page() && $post->post_parent == 0 )
		return true;

	if ( is_post_type_archive() )
		return true;

	return false;

}
