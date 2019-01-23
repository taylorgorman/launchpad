<?php
// TO DO: put option name in function? Or not, cause that function would be just as repeated as the option name.
// TO DO: namespace the option name? lp_prevent_see_others_media

// Don't let users see each other's media if they don't have post edit priveleges.
//
add_filter( 'pre_get_posts', function( $query ){

	// Bail if not admin, setting isn't checked, or post type isn't attachment
	if (
		! is_admin() ||
		! get_option( 'prevent_edit_others_media' ) ||
		$query->get( 'post_type' ) !== 'attachment'
	)
		return;

	// Do the thing
	if ( ! current_user_can( 'edit_others_posts' ) )
		$query->set( 'author', get_current_user_id() );

} );

// Add setting to turn this on and off
//
add_action( 'admin_init', function(){

	// Settings
	$settings_page = 'media';
	$section_id = 'media_permissions';
	$field_id = 'prevent_edit_others_media';
	$option_id = $field_id;

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

