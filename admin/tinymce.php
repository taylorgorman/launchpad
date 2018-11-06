<?php
/*
** Add stylesheet to TinyMCE
*/
add_action( 'admin_init', function(){

	$style = apply_filters( 'lp_editor_style', 'css/tinymce.css' );
	if ( ! empty($style) )
		add_editor_style( $style );

} );
