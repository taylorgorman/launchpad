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
          'title' => 'Edit Theme options: Editors and up (default is Administrators)',
          'name' => 'access-theme-options',
          'execute' => function () {
          },
        ],
        [
          'title' => 'Upload media: Contributors and up (default is Authors)',
          'name' => 'upload-media',
          'execute' => function () {
          },
        ],
        [
          'title' => 'View others\' media: only roles that can edit others\' posts (default is Authors and up)',
          'name' => 'view-others-media',
          'execute' => function () {

            add_filter( 'pre_get_posts', function( $query ){
              if (
                is_admin()
                && $query->get( 'post_type' ) === 'attachment'
                && ! current_user_can( 'edit_others_posts' )
              ) {
                // Only get posts from current user
                $query->set( 'author', get_current_user_id() );
              }
            } );

          },
        ],
        [
          'title' => 'Publish posts: Editors and up (default is Authors)',
          'name' => 'publish-posts',
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
      'title' => 'Content',
      'changes' => [
        [
          'title' => 'Set shortened excerpt length to 25 characters',
          'name' => 'excerpt-length',
          'execute' => function () {

            add_filter( 'excerpt_length', function(){ return 25; } );

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
        [
          'title' => 'Remove public attachment pages',
          'name' => 'remove-attachment-pages',
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
