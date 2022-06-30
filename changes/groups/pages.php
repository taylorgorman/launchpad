<?php

namespace Launchpad\Changes;

function pages() {
  return [
    'title' => 'Pages',
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
    ],
  ];
}
