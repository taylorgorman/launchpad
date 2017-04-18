<?php
/*
** Add new image sizes
*/
add_action( 'after_setup_theme', function(){

	$default_sizes = array(
		'small' => array(
			'width'  => 300
		,	'height' => 0
		,	'crop'   => false
		)
	);

	// Allow site core plugin to modify
	$sizes = apply_filters( 'bs_image_sizes', $default_sizes );

	// Bail if no sizes
	if ( empty($sizes) || ! is_array($sizes) )
		return;

	foreach ( $sizes as $name => $args ) {
		$args = wp_parse_args( $args, array(
			'width'  => 0
		,	'height' => 0
		,	'crop'   => false
		) );
		add_image_size( $name, $args['width'], $args['height'], $args['crop'] );
	}

} );

/*
** Modify default image sizes
*/
add_action( 'bs_activation_hook', function(){

	$default_sizes = array(
		'thumbnail' => array(
			'width'  => 150,
			'height' => 150,
			'crop'   => true
		),
		'medium' => array(
			'width'  => 640,
			'height' => 0,
			'crop'   => false
		),
		'large' => array(
			'width'  => 1024,
			'height' => 0,
			'crop'   => false
		)
	);

	// Allow site core plugin to modify
	$wp_sizes = apply_filters( 'bs_wp_image_sizes', $default_sizes );

	// Bail if no sizes
	if ( empty($wp_sizes) || ! is_array($wp_sizes) )
		return;

	foreach ( $sizes as $name => $args ) {
		$args = wp_parse_args( $args, array(
			'width'  => 0
		,	'height' => 0
		,	'crop'   => false
		) );
		update_option("{$name}_size_w", absint($args['width']));
		update_option("{$name}_size_h", absint($args['height']));
		update_option("{$name}_crop", (bool)$args["crop"]);
	}

	/*
	** Prevent auto-linking image
	** I know having it here is a bit messy,
	** but it'd be silly to add another bs_activation_hook action
	*/
	update_option('image_default_link_type','none');

} );

/*
** Removes <style> before galleries.
** Because WTF WORDPRESS

add_filter( 'use_default_gallery_style', function(){
	return false;
} );
*/

/*
** Removes inline style on caption blocks
** Because WTF WORDPRESS

add_filter( 'img_caption_shortcode_width', function(){
	return false;
} );
*/
