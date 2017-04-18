<?php
/*
** Needs to be moved to Blank Slate
*/
add_filter('upload_mimes', function ($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
});


/*
** Meta box
*/
add_action( 'add_meta_boxes', function() {

	add_meta_box(
		'featured-icon'
	,	'Featured Icon'
	,	'featured_icon_content'
	,	'page'
	,	'side'
	);

} );


/*
** Meta box content
*/
function featured_icon_content( $post ) {

	// Security
	wp_nonce_field( 'featured_icon_save_metabox', 'featured_icon_nonce' );

	// Get data
	$image_ID = get_post_meta( $post->ID, '_image_ID', true );

	?>
	<p><strong>Image ID</strong></p>
	<p><label class="screen-reader-text" for="image_ID">Order</label>
	<input type="text" id="image_ID" name="image_ID" value="<?php echo $image_ID; ?>"></p>
	<p class="description">In time this will have a media picker like the Featured Image box.</p>
	<?php

}

/*
** Saving actions
*/
add_action( 'save_post', function( $post_id ) {

	// Security
	if ( ! isset( $_POST['featured_icon_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['featured_icon_nonce'], 'featured_icon_save_metabox' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Save data
	update_post_meta( $post_id, '_image_ID', $_POST['image_ID'] );

} );

/*
** Display on front end
*/
function get_featured_icon( $attr=array(), $post_ID=0 ) {

	if ( empty($post_ID) ) {
		global $post;
		$post_ID = $post->ID;
	}

	if ( empty($post_ID) )
		return false;

	$attr['class'] = trim( 'featured-icon '.$attr['class'] );

	$image_ID = get_post_meta( $post_ID, '_image_ID', true );
	$img_url = wp_get_attachment_url( $image_ID );

	if ( substr($img_url, -3) == 'svg' )
		$markup = '<svg role="img" class="'. $attr['class'] .'" viewBox="0 0 100 100"><use xlink:href="'. $img_url .'#use"></use></svg>';
	else
		$markup = wp_get_attachment_image( $image_ID, 'thumbnail', 0, $attr );

	return $markup;

}

function the_featured_icon( $attr=array() ) {

	echo get_featured_icon( $attr );

}
