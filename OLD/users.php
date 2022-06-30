<?php
/*
** Modify fields on user edit screen
*/
add_filter( 'user_contactmethods', function( $fields ) {

	// Add fields
	$add = apply_filters( 'lp_add_user_fields', [
		'instagram' => 'Instagram username',
		'facebook' => 'Facebook URL',
		'twitter' => 'Twitter username',
		'linkedin' => 'LinkedIn URL',
	] );

	$fields = array_merge( $fields, $add );

	// Remove fields
	$remove = apply_filters( 'lp_remove_user_fields', [
		'aim',
		'yim',
		'jabber'
	] );

	foreach ( $remove as $field )
		unset( $fields[$field] );

	// Return
	return $fields;

} );
