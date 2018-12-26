<?php

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
			foreach ( ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'] as $format ) {

				$field_options[] = [
					'value'   => $format,
					'label'   => ' <i class="dashicons dashicons-format-' . $format . '"></i> ' . ucwords( $format ),
					'checked' => checked( is_array( $option ) ? in_array( $format, $option ) : false, true, false ),
				];

			}

			// Show admin fields
			admin_field([
				'id'    => 'post-formats',
				'type'  => 'checkbox',
				'options' => $field_options,
			]);

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
