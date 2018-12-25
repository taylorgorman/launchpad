<?php

// Prevent empty paragraphs around shortcodes
//
add_filter( 'the_content', function ( $content ) {

	return strtr( $content, array(
		'<p>['    => '['
	,	']</p>'   => ']'
	,	']<br />' => ']'
	) );

} );
