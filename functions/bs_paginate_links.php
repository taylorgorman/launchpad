<?php
/*
** WordPress's paginate_links() is a bit crippled
** and can't stand on its own.
*/
function bs_paginate_links( $args=0 ) {

	global $wp_query;

	$current = 1;
	if ( $wp_query->query_vars['paged'] > 1 )
		$current = $wp_query->query_vars['paged'];

	$vars = wp_parse_args($args, array(
		'base'      => @add_query_arg('paged','%#%')
	,	'format'    => ''
	,	'total'     => $wp_query->max_num_pages
	,	'current'   => $current
	,	'mid_size'  => 1
	,	'prev_text' => '&larr; Back'
	,	'next_text' => 'More &rarr;'
	));

	$links = paginate_links($vars);
	if ( $links ) echo '<p class="pagination">'.$links.'</p>';

}
