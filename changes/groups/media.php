<?php

namespace Launchpad\Changes;

function media() {
  return [
    'title' => 'Media',
    'changes' => [
      [
        'title' => UNSUPPORTED . 'Add Open Graph image size',
        'name' => 'open-graph-image-size',
        'execute' => function () {
        },
      ],
      [
        'title' => UNSUPPORTED . 'Remove public attachment pages',
        'name' => 'remove-attachment-pages',
        'execute' => function () {
        },
      ],
    ],
  ];
}
