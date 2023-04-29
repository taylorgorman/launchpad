<?php

namespace Launchpad\Changes;

function capabilities() {
  return [
    'title' => 'Capabilities',
    'changes' => [
      [
        'title' => 'Editors can edit theme options',
        'name' => 'access-theme-options',
        'execute' => function () {

          $role = get_role( 'editor' );
          $role->add_cap( 'edit_theme_options' );

        },
      ],
      [
        'title' => UNSUPPORTED . 'Upload media: Contributors and up (default is Authors)',
        'name' => 'upload-media',
        'execute' => function () {
        },
      ],
      [
        'title' => 'View others\' media: only roles that can edit others\' posts (default is Authors and up)',
        'name' => 'view-others-media',
        'execute' => function () {

          add_filter( 'pre_get_posts', function ( $query ) {
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
        'title' => UNSUPPORTED . 'Publish posts: Editors and up (default is Authors)',
        'name' => 'publish-posts',
        'execute' => function () {
        },
      ],
    ],
  ];
}
