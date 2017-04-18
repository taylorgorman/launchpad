<?php

add_action( 'admin_menu', function(){

	/*
	** Move Media under all the post types
	*/
	global $menu;
	foreach ( $menu as $key => $item )
		if ( in_array('Media', $item) )
			$media_key = $key;

	$menu[58] = $menu[$media_key];
	unset( $menu[$media_key] );

	/*
	** Remove editor menu pages
	*/
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

}, 999 );
