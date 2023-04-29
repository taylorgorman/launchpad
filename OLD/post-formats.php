<?php
/**
 * Turn on post formats.
 * Seems like this already happens by default? So we would turn them off, then?
 */

// Post formats checkboxes on Settings/Writing
//
add_action( 'admin_init', 'post_formats_setting' );
function post_formats_setting(){

	register_setting( 'writing', 'post-formats' );

	add_settings_field(
		'post-formats',
		'Post Formats',
		function(){

			// Wrap in a div
			echo '<div style="max-width:34em">';

			// Collect checkbox settings
	    $option = get_option( 'post-formats' );
			$field_options = [];
			foreach ( [
				[
					'dashicons' => 'format-aside',
					'name' => 'aside',
				],
				[
					'dashicons' => 'format-gallery',
					'name' => 'gallery',
				],
				[
					'dashicons' => 'format-links',
					'name' => 'link',
				],
				[
					'dashicons' => 'format-image',
					'name' => 'image',
				],
				[
					'dashicons' => 'format-quote',
					'name' => 'quote',
				],
				[
					'dashicons' => 'format-video',
					'name' => 'video',
				],
				[
					'dashicons' => 'format-audio',
					'name' => 'audio',
				],
			] as $format ) {

				$field_options[] = [
					'value'   => $format['name'],
					'label'   => ' <i class="dashicons dashicons-' . $format['dashicons'] . '"></i> ' . ucwords( $format['name'] ),
					'checked' => checked( is_array( $option ) ? in_array( $format['name'], $option ) : false, true, false ),
				];

			}

			// Show admin fields
			admin_field([
				'id'    => 'post-formats',
				'type'  => 'checkbox',
				'options' => $field_options,
			]);

			// Wrap div
			echo '</div>';

		},
		'writing',
		'default'
	);

}

// Register post formats
//
add_action( 'after_setup_theme', function(){

	$option = get_option( 'post-formats' );

	if ( $option )
		add_theme_support( 'post-formats', get_option( 'post-formats' ) );

} );
