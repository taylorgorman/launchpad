<?php

// Don't let users see each other's media if they don't have post edit priveleges.
//
add_filter( 'pre_get_posts', function( $query ){

	if ( ! is_admin() || $query->get( 'post_type' ) !== 'attachment' )
		return;

	if ( ! current_user_can( 'edit_others_posts' ) )
		$query->set( 'author', get_current_user_id() );

} );
