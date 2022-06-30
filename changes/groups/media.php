<?php

namespace Launchpad\Changes;

function media() {
  return [
    'title' => 'Media',
    'changes' => [
      [
        'title' => 'Add Open Graph image size',
        'name' => 'open-graph-image-size',
        'execute' => function () {
        },
      ],
      [
        'title' => 'Remove public attachment pages',
        'name' => 'remove-attachment-pages',
        'execute' => function () {
        },
      ],
    ],
  ];
}
