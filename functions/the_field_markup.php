<?php
function the_field_markup( $field_id, $before='', $after='' ){

	if ( $field = get_field($field_id) )
		echo $before . $field . $after;

}
