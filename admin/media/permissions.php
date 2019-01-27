<?php

// Hide others' media
//
add_filter( 'pre_get_posts', function( $query ){

	// Requirements:
	// - Must be admin
	// - Post type must be attachment
	// - User doesn't have desired capability
	// - Our db setting must be true
	if (
		! is_admin() ||
		$query->get( 'post_type' ) !== 'attachment' ||
		! current_user_can( 'edit_others_posts' ) ||
		! get_option( 'prevent_edit_others_media' )
	)
		return;

	// Only get posts from current user
	$query->set( 'author', get_current_user_id() );

} );

// Add checkbox setting in wp-admin/media.php
//
add_action( 'admin_init', function(){

	// Settings
	$settings_page = 'media';
	$section_id = 'media_permissions';
	$option_id = 'prevent_edit_others_media';
	$field_id = $option_id;

	// Section
	add_settings_section( $section_id, 'Permissions', '__return_false', $settings_page );

	// Database option
	register_setting( $settings_page, $option_id );

	// Field
	add_settings_field(
		$field_id,
		'Permissions',
		function() use ( $option_id, $field_id ){
			?>
			<label>
				<input type="checkbox" name="<?php echo $field_id; ?>" value="1" <?php checked( get_option( $option_id ) ); ?> />
				Prevent authors from seeing others' media
			</label>
			<?php
		},
		$settings_page,
		$section_id
	);

} );

