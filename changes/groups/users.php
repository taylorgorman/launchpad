<?php

namespace Launchpad\Changes;

function users() {
  return [
    'title' => 'Users',
    'changes' => [
      [
        'title' => 'Add Instagram username field',
        'name' => 'user-field-instagram',
        'execute' => function () {
        },
      ],
      [
        'title' => 'Add Twitter username field',
        'name' => 'user-field-twitter',
        'execute' => function () {
        },
      ],
      [
        'title' => 'Add LinkedIn URL field',
        'name' => 'user-field-linkedin',
        'execute' => function () {
        },
      ],
      [
        'title' => 'Add Facebook URL field',
        'name' => 'user-field-facebook',
        'execute' => function () {
        },
      ],
    ],
  ];
}
