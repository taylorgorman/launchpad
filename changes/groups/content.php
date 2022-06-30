<?php

namespace Launchpad\Changes;

function content() {
  return [
    'title' => 'Content',
    'changes' => [
      [
        'title' => 'Set shortened excerpt length to 25 words (default is 55)',
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
