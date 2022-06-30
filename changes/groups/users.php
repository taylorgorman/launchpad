<?php

namespace Launchpad\Changes;

function users() {
  return [
    'title' => 'Users',
    'changes' => [
      [
        'title' => UNSUPPORTED . 'Add Instagram username field',
        'name' => 'user-field-instagram',
        'execute' => function () {
        },
      ],
      [
        'title' => UNSUPPORTED . 'Add Twitter username field',
        'name' => 'user-field-twitter',
        'execute' => function () {
        },
      ],
      [
        'title' => UNSUPPORTED . 'Add LinkedIn URL field',
        'name' => 'user-field-linkedin',
        'execute' => function () {
        },
      ],
      [
        'title' => UNSUPPORTED . 'Add Facebook URL field',
        'name' => 'user-field-facebook',
        'execute' => function () {
        },
      ],
    ],
  ];
}
