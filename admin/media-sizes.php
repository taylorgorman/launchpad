<?php

namespace Launchpad\MediaSizes;

// Make image sizes array available everywhere
//
function new_image_sizes() {

	$new_image_sizes = [
		'small' => [
			'label'          => 'Small',
			'crop'           => false,
			'default_width'  => 400,
			'default_height' => 0,
		],
		'xlarge' => [
			'label'          => 'XLarge',
			'crop'           => false,
			'default_width'  => 1200,
			'default_height' => 0,
		],
		'open_graph' => [
			'label'          => 'Open Graph',
			'crop'           => true,
			'default_width'  => 1200,
			'default_height' => 630,
		],
	];

	// Set width and height from database or default
	foreach ( $new_image_sizes as $name => $args ) {

		$width = get_option( $name . '_size_w' );
		$new_image_sizes[$name]['width'] = empty( $width )
			? $args['default_width']
			: $width;

		$height = get_option( $name . '_size_h' );
		$new_image_sizes[$name]['height'] = empty( $height )
			? $args['default_height']
			: $width;

	}

	// Allow modification
	$new_image_sizes_filtered = apply_filters( 'ls_new_image_sizes', $new_image_sizes );
	if ( ! is_array( $new_image_sizes_filtered ) )
		$new_image_sizes_filtered = [];

	return $new_image_sizes_filtered;

}

// Utility
//
function get_all_image_sizes() {
	global $_wp_additional_image_sizes;

	$image_sizes         = [];
	$default_image_sizes = get_intermediate_image_sizes();

	foreach ( $default_image_sizes as $size ) {
		$image_sizes[ $size ]['width']  = intval( get_option( "{$size}_size_w" ) );
		$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
		$image_sizes[ $size ]['crop']   = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}

	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
	}

	return $image_sizes;
}

// Modify default image sizes
// DOESN'T WORK because we don't have bs_activation_hook anymore
// TO DO: Make this work
//
add_action( 'bs_activation_hook', function(){

	$default_sizes = array(
		'thumbnail' => array(
			'width'  => 200,
			'height' => 0,
			'crop'   => true
		),
		'medium' => array(
			'width'  => 800,
			'height' => 0,
			'crop'   => false
		),
		'large' => array(
			'width'  => 1200,
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

	// Prevent auto-linking image
	// I know having it here is a bit messy,
	// but it'd be silly to add another bs_activation_hook action
	//
	update_option('image_default_link_type','none');

} );

// Add and remove image sizes
//
add_action( 'after_setup_theme', function(){

	// Add
	//
	// Get sizes
	$sizes = namespace\new_image_sizes();
	if ( empty( $sizes ) )
		return;

	// Add sizes
	foreach ( $sizes as $name => $args )
		add_image_size( $name, $args['width'], $args['height'], $args['crop'] );

	// Remove
	//
	// Remove sizes created by Co-Authors Plus
	add_filter( 'coauthors_guest_author_avatar_sizes', function() { return []; } );

} );

// Add settings fields to Settings/Media to edit and show image sizes
//
add_action( 'admin_init', function() {

	$lp_image_sizes = namespace\new_image_sizes();

	// Register settings to Settings/Media
	foreach ( $lp_image_sizes as $name => $args ) {

		register_setting(
			'media',
			$name . '_size_w',
			[
				'type' => 'number',
				'sanitize_callback' => 'absint',
				'default' => $args['default_width'],
			]
		);
		register_setting(
			'media',
			$name . '_size_h',
			[
				'type' => 'number',
				'sanitize_callback' => 'absint',
				'default' => $args['default_height'],
			]
		);

		// Add settings to Settings/Media
		add_settings_field(
			$name . '_size',
			$args['label'] . ' size',
			function() use ( $name, $args ) {
				?>
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo $args['label']; ?> size</span></legend>
					<label for="<?php echo esc_attr( $name . '_size_w' ); ?>">Max Width</label>
					<input name="<?php echo esc_attr( $name . '_size_w' ); ?>" type="number" step="1" min="0" id="<?php echo esc_attr( $name . '_size_w' ); ?>" value="<?php form_option( $name . '_size_w' ); ?>" class="small-text" />
					<br>
					<label for="<?php echo esc_attr( $name . '_size_h' ); ?>">Max Height</label>
					<input name="<?php echo esc_attr( $name . '_size_h' ); ?>" type="number" step="1" min="0" id="<?php echo esc_attr( $name . '_size_h' ); ?>" value="<?php form_option( $name . '_size_h' ); ?>" class="small-text" />
				</fieldset>
				<?php
			},
			'media',
			'default'
		);

	}

	// Show image sizes we can't change
	// YOU CAN'T HIDE FROM ME, IMAGE SIZES
	$sizes_shown = array_merge(
		['thumbnail', 'medium', 'large'],
		array_keys( $lp_image_sizes )
	);

	foreach ( namespace\get_all_image_sizes() as $label => $data ) {

		// Skip sizes already shown
		if ( in_array( $label, $sizes_shown, true ) )
			continue;

		// Show other sizes
		add_settings_field(
			$label . '_size',
			$label . ' size',
			function() use ( $label, $data ) {
				?>
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo $label . '_size'; ?> size</span></legend>
					<label for="<?php echo esc_attr( $label . '_size_w' ); ?>">Width</label>
					<input disabled name="<?php echo esc_attr( $label . '_size_w' ); ?>" type="number" value="<?php echo esc_attr( $data['width'] ); ?>" class="small-text" />
					<br>
					<label for="<?php echo esc_attr( $label . '_size_h' ); ?>">Height</label>
					<input disabled name="<?php echo esc_attr( $label . '_size_h' ); ?>" type="number" value="<?php echo esc_attr( $data['height'] ); ?>" class="small-text" />
				</fieldset>
				<?php
			},
			'media',
			'default'
		);

	}

} );
