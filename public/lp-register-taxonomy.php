<?php

// Register taxonomy with sane defaults
//
function lp_register_taxonomy( $args ) {

	$v = wp_parse_args( $args, [
		'id'            => '',
		'post_types'    => '',
		'singular_name' => '',
		'plural_name'   => '',
		'args'          => [],
	] );

	// Singular name and post_types are required
	if ( empty($v['singular_name']) || empty($v['post_types']) )
		return false;

	// Defaults
	if ( empty( $v['id'] ) )
		$v['id'] = sanitize_title( $v['singular_name'] );

	if ( empty( $v['plural_name'] ) )
		$v['plural_name'] = $v['singular_name'] . 's';

	// Register taxonomy arguments
	$arguments = wp_parse_args_deep( $v['args'], [
		'labels'            => [
			'name'                       => $v['plural_name'],
			'singular_name'              => $v['singular_name'],
			'search_items'               => 'Search ' . $v['plural_name'],
			'popular_items'              => 'Popular ' . $v['plural_name'],
			'all_items'                  => 'All ' . $v['plural_name'],
			'parent_item'                => 'Parent ' . $v['singular_name'],
			'parent_item_colon'          => 'Parent ' . $v['singular_name'] . ':',
			'edit_item'                  => 'Edit ' . $v['singular_name'],
			'view_item'                  => 'View ' . $v['singular_name'],
			'update_item'                => 'Update ' . $v['singular_name'],
			'add_new_item'               => 'Add New ' . $v['singular_name'],
			'new_item_name'              => 'New ' . $v['singular_name'] . ' Name',
			'separate_items_with_commas' => 'Separate ' . $v['plural_name'] . ' with commas',
			'add_or_remove_items'        => 'Add or remove ' . $v['plural_name'],
			'choose_from_most_used'      => 'Choose from the most used ' . $v['plural_name'],
			'not_found'                  => 'No ' . $v['plural_name'] . ' found.',
			'no_terms'                   => 'No ' . $v['plural_name'],
		],
		'hierarchical'      => true,
		'show_admin_column' => true,
	] );

	// Go go gadget
	add_action( 'init', function() use ( $v, $arguments ) {
		register_taxonomy( $v['id'], $v['post_types'], $arguments );
	});

}
