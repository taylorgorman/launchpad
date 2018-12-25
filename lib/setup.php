<?php

namespace Launchpad\Setup;

/**
	* Version number
	* Unfortunately have to set this here and in the root file
	*/
function version() {

	return '1.0.0';

}

/**
	* To be used for slugs
	*/
function name() {

	return 'launchpad';

}

function option( $name ) {

	$options = get_option( name() );

	if ( empty( $options[$name] ) )
		return false;
	else
		return $options[ $name ];

}