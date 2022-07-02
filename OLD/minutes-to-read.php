<?php
/**
 * Determines how many minutes an average reader would take to read a given string.
 * Can override with filter or argument.
 * TO DO: Uhhhhh where to put this? It doesn't belong in Launchpad anymore.
 * 
 * @param string $string - How long would it take to read this string?
 * @param integer $wpm - Words per minute for this process only
 * @return integer $minutes_to_read
 */
function minutes_to_read( $string, $wpm = false ) {

	// Slightly below average words per minute
	if ( ! $wpm )
		$wpm = apply_filters( 'words_per_minute_to_read', 200 );

	// Sanitize
	$string = strval( $string );
	$wpm = intval( $wpm );

	// Strip everything but words
	$string = strip_shortcodes( $string );
	$string = strip_tags( $string );

	// Number of words
	$words = explode( ' ', $string );
	// Minutes to read
	$mtr = count( $words ) / $wpm;

	return ceil( $mtr );

}
