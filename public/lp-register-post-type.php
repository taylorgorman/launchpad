<?php

use Launchpad\Utilities;


// Register post type with sane defaults
//
function lp_register_post_type( $args ) {

	$v = wp_parse_args( $args, [
		'id'            => '',
		'singular_name' => '',
		'plural_name'   => '',
		'args'          => [],
	] );

	// Singular name is required
	if ( empty( $v['singular_name'] ) )
		return false;

	// Defaults
	if ( empty( $v['id'] ) )
		$v['id'] = sanitize_title( $v['singular_name'] );

	if ( empty( $v['plural_name'] ) )
		$v['plural_name'] = $v['singular_name'] . 's';

	$supports = [
		'title',
		'editor',
		'thumbnail',
		'excerpt',
		'revisions',
		'author',
	];
	if ( ! empty( $v['args']['hierarchical'] ) )
		$supports[] = 'page-attributes';

	// Merge defaults
	$arguments = Utilities\wp_parse_args_deep( $v['args'], [
		'labels'          => [
			'name'               => $v['plural_name'],
			'singular_name'      => $v['singular_name'],
			'add_new_item'       => 'Add New ' . $v['singular_name'],
			'edit_item'          => 'Edit ' . $v['singular_name'],
			'new_item'           => 'New ' . $v['singular_name'],
			'view_item'          => 'View ' . $v['singular_name'],
			'search_items'       => 'Search ' . $v['plural_name'],
			'not_found'          => 'No ' . $v['plural_name'] . ' found',
			'not_found_in_trash' => 'No ' . $v['plural_name'] . ' found in Trash.',
			'parent_item_colon'  => 'Parent ' . $v['singular_name'] . ':',
			'all_items'          => 'All ' . $v['plural_name'],
		],
		'supports'        => $supports,
		'public'          => true,
		'menu_position'   => 20,
		'hierarchical'    => true,
		'has_archive'     => true,
		'capability_type' => 'page',
		'rewrite'         => [
			'with_front' => false,
		],
	] );

	// Register
	add_action( 'init', function() use ( $v, $arguments ) {
		register_post_type( $v['id'], $arguments );
	} );

}
