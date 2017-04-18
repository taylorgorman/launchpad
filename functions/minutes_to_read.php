<?php
/*
** Minutes to read
** Determines how many minutes an average reader would take to read a given string.
**
** Could maybe add an argument to override the words per minute setting.
** Or a filter so could be changed site-wide.
** Or a setting in WP? Seems overkill.
*/
function minutes_to_read( $string='' ) {

	// Slightly below average words per minute
	$wpm = 200;

	// Strip everything but words
	$string = strip_tags(strip_shortcodes($string));

	// Find number of words, calculate minutes to read
	$words = explode( ' ', $string );
	$mtr = count($words) / $wpm;

	return ceil($mtr);

}
