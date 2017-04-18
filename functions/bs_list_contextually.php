<?php
/*
** Get list items based on context
**
** @param  $args (array)
*/
function bs_list_contextually( $args = array() ) {

	if ( is_404() )
		return;

	global $post;

	$list_args = wp_parse_args( $args, array(
		'title_li'         => 0
	,	'show_option_none' => 0
	) );

	// Force return for now
	$list_args['echo'] = false;

	// Taxonomy archives
	if ( is_category() || is_tag() || is_tax() ) {

		// Update list options
		$query_obj = get_queried_object();
		$list_args['taxonomy'] = $query_obj->taxonomy;

		// Get list items
		$list_items = wp_list_categories($list_args);

	}

	// Hierarchical post types show sub post lists
	elseif ( is_object($post) && is_post_type_hierarchical($post->post_type) ) {

		// Update list options
		$ancestor = get_highest_ancestor();
		$list_args['child_of'] = $ancestor['id'];
		$list_args['post_type'] = $post->post_type;

		// Get list items
		$list_items = wp_list_pages($list_args);

	}

	// Non-hierarchical post types show specified taxonomy lists
	else {

		/* Need to specify which taxonomy(ies) to show for which post types
		**
		$list_args['taxonomy'] = $query_obj->taxonomy;
		*/

		$list_items = wp_list_categories($list_args);

	}

	// Default echo or return if requested
	if ( isset($args['echo']) && !$args['echo'] )
		return $list_items;
	else
		echo $list_items;

}
