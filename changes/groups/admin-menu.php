<?php

namespace Launchpad\Changes;

function admin_menu() {
  return [
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
  ];
}
