<?php
/*
** Add checkboxes to Launchpad settings screen
*/
add_filter( 'launchpad_settings_fields', function( $fields ){

	$fields[] = [
		'type'    => 'checkbox',
		'label'   => 'Post formats',
		'options' => [
			[
				'label' => '<i class="dashicons dashicons-format-aside"></i> Aside'
			],
			[
				'label' => '<i class="dashicons dashicons-format-gallery"></i> Gallery'
			],
			[
				'label' => '<i class="dashicons dashicons-admin-links"></i> Link'
			],
			[
				'label' => '<i class="dashicons dashicons-format-image"></i> Image'
			],
			[
				'label' => '<i class="dashicons dashicons-format-quote"></i> Quote'
			],
			[
				'label' => '<i class="dashicons dashicons-format-video"></i> Video'
			],
			[
				'label' => '<i class="dashicons dashicons-format-audio"></i> Audio'
			],
		],
	];

	return $fields;

} );

/*
** Add theme supports
**
** #hookable
*/
add_action( 'after_setup_theme', function(){

	$features = array(
		'post-thumbnails'      => true
	,	'menus'                => true
	,	'html5'                => array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widgets' )
	);

	// Add post formats from Launchpad settings
	$lp_settings = get_option('launchpad');
	if ( ! empty($lp_settings['post-formats']) && is_array($lp_settings['post-formats']) )
		$features['post-formats'] = $lp_settings['post-formats'];

	// Bail if no features
	if ( empty($features) || ! is_array($features) )
		return;

	// Add theme supports
	foreach ( $features as $feature => $args ) {
		if ( is_array($args) ) add_theme_support( $feature, $args );
		elseif ( $args ) add_theme_support( $feature );
	}

} );
