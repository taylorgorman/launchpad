<?php
/*
** Add option to Launchpad settings screen
*/
add_filter( 'launchpad_settings_fields', function( $fields ){

	$fields[] = [
		'type' => 'checkbox',
		'label' => 'Layout classes',
	];

	return $fields;

} );

/*
** Create layout taxonomy
*/
global $lp;
if ( ! empty($lp['layout-classes']) )
	bs_register_taxonomy( array(
		'singular_name' => 'layout'
	,	'plural_name'   => 'layouts'
	,	'post_types'    => get_post_types(array('show_ui'=>true))
	,	'arguments'     => array(
			'show_in_menu'      => false
		,	'show_in_nav_menus' => false
		,	'show_admin_column' => false
		)
	) );
