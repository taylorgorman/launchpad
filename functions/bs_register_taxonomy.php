<?php
/*
** Register taxonomy
*/
function bs_register_taxonomy( $args ) {

	$v = wp_parse_args( $args, array(
		'ID'            => ''
	,	'post_types'    => ''
	,	'singular_name' => ''
	,	'plural_name'   => ''
	,	'labels'        => array()
	,	'arguments'     => array()
	) );

	// Singular name and post_types are essential
	if ( empty($v['singular_name']) || empty($v['post_types']) )
		return false;

	// ID and plural default to singular
	if ( empty($v['ID']) )
		$v['ID'] = sanitize_title($v['singular_name']);
	if ( empty($v['plural_name']) )
		$v['plural_name'] = $v['singular_name'];

	// Uppercase names
	if ( empty($v['singular_name_uppercase']) )
		$v['singular_name_uppercase'] = ucwords($v['singular_name']);
	if ( empty($v['plural_name_uppercase']) )
		$v['plural_name_uppercase'] = ucwords($v['plural_name']);

	// Labels
	$v['labels'] = wp_parse_args( $v['labels'], array(
		'name'                       => $v['plural_name_uppercase']
	,	'singular_name'              => $v['singular_name_uppercase']
	,	'search_items'               => 'Search '.$v['plural_name_uppercase']
	,	'popular_items'              => 'Popular '.$v['plural_name_uppercase']
	,	'all_items'                  => 'All '.$v['plural_name_uppercase']
	,	'parent_item'                => 'Parent '.$v['singular_name_uppercase']
	,	'parent_item_colon'          => 'Parent '.$v['singular_name_uppercase'].':'
	,	'edit_item'                  => 'Edit '.$v['singular_name_uppercase']
	,	'view_item'                  => 'View '.$v['singular_name_uppercase']
	,	'update_item'                => 'Update '.$v['singular_name_uppercase']
	,	'add_new_item'               => 'Add New '.$v['singular_name_uppercase']
	,	'new_item_name'              => 'New '.$v['singular_name_uppercase'].' Name'
	,	'separate_items_with_commas' => 'Separate '.$v['plural_name'].' with commas'
	,	'add_or_remove_items'        => 'Add or remove '.$v['plural_name']
	,	'choose_from_most_used'      => 'Choose from the most used '.$v['plural_name']
	,	'not_found'                  => 'No '.$v['plural_name'].' found.'
	,	'no_terms'                   => 'No '.$v['plural_name']
	) );

	// Register taxonomy arguments
	$v['arguments'] = wp_parse_args( $v['arguments'], array(
		'labels'            => $v['labels']
	,	'hierarchical'      => true
	,	'show_admin_column' => true
	) );

	// Go go gadget
	add_action( 'init', function($v) use ($v){
		register_taxonomy( $v['ID'], $v['post_types'], $v['arguments'] );
	});

}
