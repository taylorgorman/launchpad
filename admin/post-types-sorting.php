<?php
/*
** Sort posts by occur date
** Ascending order
** Date is higher than right now
*/
add_filter( 'pre_get_posts', function( $query ){

	$blank_slate_db = get_option('blank_slate');

	// Is orderby set?
	if ( ! is_string($query->get('post_type')) || empty($blank_slate_db['orderby'][$query->get('post_type')]) )
		return;

	// Standard WP_Query orderby parameters
	if ( in_array( $blank_slate_db['orderby'][$query->get('post_type')], [
		'none'
	,	'ID'
	,	'author'
	,	'title'
	,	'name'
	,	'type'
	,	'date'
	,	'modified'
	,	'parent'
	,	'rand'
	,	'comment_count'
	,	'menu_order'
	] ) ) {
		$query->set( 'orderby', $blank_slate_db['orderby'][$query->get('post_type')] );

	// Otherwise must be a meta key
	} else {
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', $blank_slate_db['orderby'][$query->get('post_type')] );
	}

	// Ascending or descending
	$query->set( 'order', $blank_slate_db['order'][$query->get('post_type')] );

} );

/*
** Add column to post type list screen
*/


