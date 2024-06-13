<?php

namespace Launchpad\Changes;

function admin_menu() {
  return [
    'title' => 'Admin Menu',
    'changes' => [
      [
        'title' => 'Remove Theme File Editor',
        'name' => 'remove-theme-editor',
        'default' => true,
        'execute' => function () {
  
          add_action( 'admin_menu', function () {
            // < 5.9
            remove_submenu_page( 'themes.php', 'theme-editor.php' );
            // >= 5.9
            remove_submenu_page( 'tools.php', 'theme-editor.php' );
          }, 999 );
  
        },
      ],
      [
        'title' => 'Remove Plugin File Editor',
        'name' => 'remove-plugin-editor',
        'default' => true,
        'execute' => function () {
  
          add_action( 'admin_menu', function () {
            // < 5.9
            remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
            // >= 5.9
            remove_submenu_page( 'tools.php', 'plugin-editor.php' );
          }, 999 );
  
        },
      ],
      [
        'title' => 'Move Media below post types and Comments',
        'name' => 'move-media-below',
        'default' => true,
        'execute' => function () {
  
          add_action( 'admin_menu', function () {
            global $menu;
            foreach ( $menu as $key => $item )
              if ( in_array( 'Media', $item ) )
                $media_key = $key;
        
            $menu[50] = $menu[$media_key];
            unset( $menu[$media_key] );
          }, 999 );
          
        },
      ],
      [
        'title' => 'Move Pages above Posts',
        'name' => 'move-pages-above',
        'default' => true,
        'execute' => function () {
  
          add_action( 'admin_menu', function () {
            global $menu;
            // echo '<pre style="padding-left:13em">'; print_r($menu); echo '</pre>';
            foreach ( $menu as $key => $item ) {
              if ( in_array( 'Pages', $item ) ) {
                $pages_key = $key;
                $pages_item = $item;
              }
              if ( in_array( 'Posts', $item ) ) {
                $posts_key = $key;
                $posts_item = $item;
              }
            }

            unset( $menu[$pages_key], $menu[$posts_key] );
            $menu[5] = $pages_item;
            $menu[6] = $posts_item;
          }, 999 );
          
        },
      ],
    ],
  ];
}
