<?php

namespace Launchpad\Changes;

function co_authors_plus() {
  return [
    'title' => 'Co-Authors Plus',
    'changes' => [
      [
        'title' => UNTESTED . 'Remove image sizes created by Co-Authors Plus',
        'name' => 'remove-image-sizes',
        'execute' => function () {

          add_action( 'after_setup_theme', function(){
            add_filter( 'coauthors_guest_author_avatar_sizes', function() { return []; } );
          } );

        },
      ],
    ],
  ];
}
