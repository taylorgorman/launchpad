<?php
/**
 * Launchpad settings page
 * @see https://developer.wordpress.org/plugins/settings/custom-settings-page/
 */

namespace Launchpad\Settings;
use Launchpad\Setup;
use Utilities\MakeAdmin;

/**
 * Create settings admin page
 */
MakeAdmin\page( [
  'title' => Setup\title,
  'capability' => 'manage_options',
  'parent' => 'Settings',
  'sections' => [
    [
      'title' => 'Launchpad',
      // 'content' => function () {
      //   echo 'Next: nested fields..';
      // },
      'fields' => [
        [
          'type' => 'multiselect',
          'label' => 'Admin Menu',
          'options' => [
            'Move Media below post types and Comments',
            'Remove Appearance / Theme File Editor',
            'Remove Plugins / Plugin File Editor',
          ],
        ],
        [
          'type' => 'multiselect',
          'label' => 'Capabilities',
          'options' => [
            'Authors and below can\'t access other users\' media',
            'Editors can access Theme options',
          ],
        ],
        [
          'type' => 'multiselect',
          'label' => 'Pages',
          'options' => [
            'Add excerpt to pages',
          ],
        ],
        [
          'type' => 'multiselect',
          'label' => 'Media',
          'options' => [
            'Add Open Graph image size',
          ],
        ],
        [
          'type' => 'multiselect',
          'label' => 'Users',
          'options' => [
            'Add Instagram username field',
            'Add Twitter username field',
            'Add LinkedIn URL field',
            'Add Facebook URL field',
          ],
        ],
        [
          'type' => 'multiselect',
          'label' => 'Plugin: CoAuthors',
          'options' => [
            'Remove extra image sizes (LIST NAMES)',
          ],
        ],
      ],
    ],
  ],
] );

