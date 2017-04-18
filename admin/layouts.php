<?php
/*
** Create layout taxonomy
*/
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
