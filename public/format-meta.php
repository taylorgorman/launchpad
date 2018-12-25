<?php
/*
** Add meta box to every post type edit screen
*/
add_action( 'add_meta_boxes', function() {

	// Get all post types except system's
	$post_types = get_post_types();

	// Go for it
	foreach ( $post_types as $pt ) { if ( post_type_supports( $pt, 'post-formats' ) ) {

		add_meta_box(
			'format-meta'
		,	'Format Data'
		,	'format_meta_content'
		,	$pt
		);

	} }

} );


/*
** Meta box content
*/
function format_meta_content( $post ) {

	// Security
	wp_nonce_field( 'format_meta_save_metabox', 'format_meta_nonce' );

	// Get data
	$format_meta = wp_parse_args(
		get_post_meta( $post->ID, 'format_meta', true )
	, array(
			'permalink' => ''
		,	'source_name' => ''
		)
	);
	?>
	<table class="form-table">
	<tr>
		<th><label>Custom URL</label></th>
		<td>
			<input type="text" name="format_meta[permalink]" value="<?php echo $format_meta['permalink']; ?>" class="regular-text">
			<p class="description">This URL will override the permalink for this post. Include "http://" or the link will not work.</p>
		</td>
	</tr>
	<tr>
		<th><label>Source Name</label></th>
		<td>
			<input type="text" name="format_meta[source_name]" value="<?php echo $format_meta['source_name']; ?>" class="regular-text">
		</td>
	</tr>
	</table>
	<?php

}

/*
** Saving actions
*/
add_action( 'save_post', function( $post_id ) {

	// Security
	if ( ! isset( $_POST['format_meta_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['format_meta_nonce'], 'format_meta_save_metabox' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Save data
	update_post_meta( $post_id, 'format_meta', $_POST['format_meta'] );

} );
