<?php

add_action( 'admin_init', 'post_formats_setting' );

function post_formats_setting(){

	register_setting( 'writing', 'post-formats' );

	add_settings_field(
		'post-formats',
		'Post Formats',
		function(){

	    $option = get_option( 'post-formats' );

			echo '<div style="max-width:34em">';
			foreach ( ['aside', 'gallery', 'links', 'image', 'quote', 'video', 'audio'] as $format ) {
				?>
				<label style="display:inline-block;padding:3px 0;width:49%;">
					<input type="checkbox" name="post-formats[]" value="<?php echo esc_attr( $format ); ?>" <?php checked( is_array( $option ) ? in_array( $format, $option ) : false ); ?>>
					&nbsp; <i class="dashicons dashicons-format-<?php echo esc_attr( $format ); ?>"></i> &nbsp; <?php echo ucwords( $format ); ?>
				</label>
				<?php
			}
			echo '</div>';

		},
		'writing',
		'default'
	);

}

add_action( 'after_setup_theme', function(){

	$option = get_option( 'post-formats' );

	if ( $option )
		add_theme_support( 'post-formats', get_option( 'post-formats' ) );

} );
