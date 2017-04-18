<?php
/*
** Remove columns from user list screen
*/
add_filter( 'manage_users_columns', function($cols) {

	unset($cols['posts']);
	return $cols;

} );

/*
** Modify fields on user edit screen
*/
add_filter( 'user_contactmethods', function($fields) {

	// Add fields
	$add = apply_filters('bs_add_user_fields', array(
		'facebook' => 'Facebook',
		'googleplus' => 'Google+',
		'linkedin' => 'LinkedIn',
		'twitter' => 'Twitter'
	));

	$fields = array_merge($fields, $add);

	// Remove fields
	$remove = apply_filters('bs_remove_user_fields', array(
		'aim',
		'yim',
		'jabber'
	));

	foreach ($remove as $field)
		unset( $fields[$field] );

	// Return
	return $fields;

} );
