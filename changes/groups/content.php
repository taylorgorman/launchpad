<?php

namespace Launchpad\Changes;

function content() {
  return [
    'title' => 'Content',
    'changes' => [
      [
        'title' => 'Add excerpt to pages',
        'name' => 'page-excerpt',
        'execute' => function () {

          add_action( 'init', function () {
            add_post_type_support( 'page', 'excerpt' );
          } );
          
        },
      ],
      [
        'title' => UNTESTED . 'Pages have comments',
        'name' => 'page-comments',
        'execute' => function () {

          add_action( 'init', function () {
            add_post_type_support( 'page', 'comments' );
          } );
          
        },
      ],
      [
        'title' => UNTESTED . 'Excerpts can have shortcodes',
        'name' => 'excerpt-shortcodes',
        'execute' => function () {

          add_action( 'init', function () {
            add_filter( 'the_excerpt', 'do_shortcode' );
          } );
          
        },
      ],
      [
        'title' => 'Set generated excerpt length to 25 words (default is 55)',
        'name' => 'excerpt-length',
        'execute' => function () {

          /**
           * @see https://developer.wordpress.org/reference/hooks/excerpt_length/
           */
          add_filter( 'excerpt_length', function () { return 25; } );

        },
      ],
    ],
  ];
}
