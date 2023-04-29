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

          add_filter( 'user_contactmethods', function( $fields ) {
            return array_merge( $fields, [
              'instagram' => 'Instagram username'
            ] );
          } );

        },
      ],
      [
        'title' => 'Add Twitter username field',
        'name' => 'user-field-twitter',
        'execute' => function () {

          add_filter( 'user_contactmethods', function( $fields ) {
            return array_merge( $fields, [
              'twitter' => 'Twitter username'
            ] );
          } );

        },
      ],
      [
        'title' => 'Add LinkedIn URL field',
        'name' => 'user-field-linkedin',
        'execute' => function () {

          add_filter( 'user_contactmethods', function( $fields ) {
            return array_merge( $fields, [
              'linkedin' => 'LinkedIn URL'
            ] );
          } );

        },
      ],
      [
        'title' => 'Add Facebook URL field',
        'name' => 'user-field-facebook',
        'execute' => function () {

          add_filter( 'user_contactmethods', function( $fields ) {
            return array_merge( $fields, [
              'facebook' => 'Facebook URL'
            ] );
          } );

        },
      ],
    ],
  ];
}
