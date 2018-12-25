<?php

// https://mekshq.com/recursive-wp-parse-args-wordpress-function/
//
function wp_parse_args_deep( &$a, $b ) {

	$a = (array) $a;
	$b = (array) $b;
	$result = $b;

	foreach ( $a as $k => &$v ) {
		if ( is_array( $v ) && isset( $result[ $k ] ) ) {
			$result[ $k ] = wp_parse_args_deep( $v, $result[ $k ] );
		} else {
			$result[ $k ] = $v;
		}
	}

	return $result;
}