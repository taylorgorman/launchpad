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
        },
      ],
    ],
  ];
}
