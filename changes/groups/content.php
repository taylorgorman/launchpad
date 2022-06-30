<?php

namespace Launchpad\Changes;

function content() {
  return [
    'title' => 'Content',
    'changes' => [
      [
        'title' => 'Set shortened excerpt length to 25 characters',
        'name' => 'excerpt-length',
        'execute' => function () {

          add_filter( 'excerpt_length', function(){ return 25; } );

        },
      ],
    ],
  ];
}
