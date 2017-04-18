<?php
/*
** Add theme supports
**
** #hookable
*/
add_action( 'after_setup_theme', function(){

	$default_features = array(
		'post-thumbnails'      => true
	,	'menus'                => true
	,	'html5'                => array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets' )
	);

	// Add post formats based on Blank Slate Settings
	$bs_settings = get_option('blank_slate');
	if ( ! empty($bs_settings['post-formats']) && is_array($bs_settings['post-formats']) )
		$default_features['post-formats'] = $bs_settings['post-formats'];

	// Allow site core plugin to modify features
	$features = apply_filters( 'bs_theme_support', $default_features );

	// Bail if no features
	if ( empty($features) || ! is_array($features) )
		return;

	// Add theme supports
	foreach ( $features as $feature => $args ) {
		if ( is_array($args) ) add_theme_support( $feature, $args );
		elseif ( $args ) add_theme_support( $feature );
	}

} );
