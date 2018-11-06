<?php
/*
** Enqueue scripts and styles?
*/
add_action( 'admin_enqueue_scripts', function(){

	wp_enqueue_style( 'launchpad', LP_URL.'css/launchpad.css', [], filemtime(LP_PATH.'css/launchpad.css') );

} );
