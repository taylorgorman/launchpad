<?php
/*
** Change menu arguments
*/
add_filter( 'wp_nav_menu_args', function( $args ){

	// Better defaults
	if ( $args['container'] !== false ) $args['container'] = 'nav';
	$args['fallback_cb']  = '__return_false';
	$args['container_id'] = 'menu-location-'.$args['theme_location'];

	if ( empty( $args['container'] ) ) {
		$args['menu_id']     = $args['container_id'];
		$args['menu_class'] .= ' '.$args['container_id'];
	}

	// Cleanup
	$args['container_class'] = trim($args['container_class']);
	$args['menu_class']      = trim($args['menu_class']);

	// Return
	return $args;

} );

/*
** Change <li> tags
*/
add_filter( 'wp_nav_menu_objects', function( $sorted_menu_items, $args ){

	// Not on admin
	if ( is_admin() ) return;

	//echo '<pre>'.print_r($sorted_menu_items,1).'</pre>';
	foreach ( $sorted_menu_items as $item ) {

		// Menu items with hashlink
		$hashpos = strpos( $item->url, '#' );
		if ( $hashpos !== false ) {

			// Temporarily strip off hashlink
			$url_wo_hash = substr( $item->url, 0, $hashpos );
			//echo '<pre>'; var_dump($url_wo_hash); echo '</pre>';

			// TODO: Strip domain from both URLs

			// If we're at the item's URL, just display the hash
			if ( $url_wo_hash === $_SERVER['REQUEST_URI'] )
				$item->url = substr( $item->url, $hashpos );

		}

		// Bootstrap navbar-nav
		if ( strpos($args->menu_class, 'nav') !== false ) {

			// All <li>
			if ( ! $item->menu_item_parent ) {
				$item->classes[] = 'nav-item';
			}
			// Dropdown container
			if ( strpos($args->menu_class, 'nav-dropdown') !== false && in_array( 'menu-item-has-children', $item->classes ) && $args->depth !== 1 ) {
				$item->classes[] = 'dropdown';
			}

		}

	}

	return $sorted_menu_items;

}, 10, 2 );

/*
** Change <a> tags
*/
add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args, $depth ){

	//echo '<pre>$ATTS: '; print_r($atts); echo '<br>$ITEM: '; print_r($item); echo '<br>$ARGS: '; print_r($args); echo '<br>$DEPTH: '; print_r($depth); echo '</pre>';

	// Bail if not Bootstrap navbar-nav
	if ( strpos($args->menu_class, 'nav') === false )
		return $atts;

	$is_nav_dropdown = ( strpos($args->menu_class, 'nav-dropdown') !== false );

	// Establish
	$atts['class'] = '';

	// Dropdown or everything else
	if ( $is_nav_dropdown && $item->menu_item_parent )
		$atts['class'] .= 'dropdown-item ';
	else
		$atts['class'] .= 'nav-link ';

	// Dropdown toggle
	if ( $is_nav_dropdown && in_array( 'menu-item-has-children', $item->classes ) && $args->depth !== 1 ) {
		$atts['class']        .= 'dropdown-toggle ';
		$atts['data-toggle']   = 'dropdown';
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
		$atts['id']            = sanitize_title($item->title) .'-dropdown';
	}

	// Cleanup
	$atts['class'] = trim($atts['class']);

	// Return
	return $atts;

}, 10, 4 );

/*
** Whole menu string replacement. Last resort.
*/
add_filter( 'wp_nav_menu_items', function( $items, $args ){

	// Dropdown <ul>
	if ( strpos($args->menu_class, 'nav-dropdown') !== false )
		$items = str_replace( 'class="sub-menu', 'class="sub-menu dropdown-menu', $items );

	// Return
	return $items;

}, 10, 2 );
