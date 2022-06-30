<?php

namespace Launchpad\Changes;

/**
 * Changesets inside named groups
 * Used to both create the settings page and execute the changes.
 * 
 * @return array
 */
function definitions() {
  return [
    [
      'title' => 'Admin Menu',
      'changes' => [
        [
          'name' => 'remove-theme-editor',
          'title' => 'Remove Appearance / Theme File Editor',
          'execute' => function () {
    
            add_action( 'admin_menu', function () {
              remove_submenu_page( 'themes.php', 'theme-editor.php' );
            }, 999 );
    
          },
        ],
        [
          'name' => 'remove-plugin-editor',
          'title' => 'Remove Plugins / Plugin File Editor',
          'execute' => function () {
    
            add_action( 'admin_menu', function () {
              remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
            }, 999 );
    
          },
        ],
        [
          'title' => 'Move Media below post types and Comments',
          'name' => 'move-media-below',
          'execute' => function () {
    
            add_action( 'admin_menu', function () {
              global $menu;
              foreach ( $menu as $key => $item )
                if ( in_array('Media', $item) )
                  $media_key = $key;
          
              $menu[50] = $menu[$media_key];
              unset( $menu[$media_key] );
            }, 999 );
            
          },
        ],
      ],
    ],
    [
      'title' => 'Capabilities',
      'changes' => [
        [
          'title' => 'Editors can access Theme options',
          'name' => 'access-theme-options',
          'execute' => function () {
          },
        ],
        [
          'title' => 'Authors and below can\'t access other users\' media',
          'name' => 'access-other-users-media',
          'execute' => function () {
          },
        ],
      ],
    ],
    [
      'title' => 'Pages',
      'changes' => [
        [
          'title' => 'Add excerpt to pages',
          'name' => 'page-excerpt',
          'execute' => function () {
          },
        ],
      ],
    ],
    [
      'title' => 'Media',
      'changes' => [
        [
          'title' => 'Add Open Graph image size',
          'name' => 'open-graph-image-size',
          'execute' => function () {
          },
        ],
      ],
    ],
    [
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
    ],
  ];
}
