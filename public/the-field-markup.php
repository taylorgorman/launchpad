<?php

// ACF conditional output with markup before and after
//
function the_field_markup( $field_id, $before = '', $after = '' ) {

	$field = get_field( $field_id );

	if ( $field )
		echo $before . $field . $after;

}
