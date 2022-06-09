<?php
// All the shit we use in the whole plugin

namespace Launchpad\Setup;

/**
	* Version number
	* Unfortunately have to set this here and in the root file
	*/
function version() {

	return '2.0.0';

}

/**
	* To be used for slugs
	*/
function name() {

	return 'launchpad';

}

const title = 'Launchpad';
const name = 'launchpad';

/**
 * The one options value (array) for/from the settings page
 */
function option( $name ) {

	$options = get_option( name() );

	if ( empty( $options[$name] ) )
		return null;
	else
		return $options[ $name ];

}
