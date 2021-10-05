<?php

// Set length of excerpt generated from content
add_filter( 'excerpt_length', function(){ return 25; } );

// Process shortcodes in excerpt
add_filter( 'the_excerpt', 'do_shortcode' );
