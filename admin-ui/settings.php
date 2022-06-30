<?php
/**
 * Launchpad settings page
 * @see https://developer.wordpress.org/plugins/settings/custom-settings-page/
 */

namespace Launchpad\Settings;
use Launchpad\Changes;
use Launchpad\Setup;
use Utilities\MakeAdmin;

/**
 * Convert changeset groups to MakeAdmin API
 */
$fields = array_map( function ( $change_group ) {
  return [
    'type' => 'multiselect',
    'label' => $change_group['title'],
    'options' => array_map( function ( $change ) {
      return $change['title'];
    }, $change_group['changes'] ),
  ];
}, Changes\definitions() );

/**
 * Create settings admin page
 */
MakeAdmin\page( [
  'title' => Setup\TITLE,
  'capability' => 'manage_options',
  'parent' => 'Settings',
  'sections' => [
    [
      'title' => Setup\TITLE,
      'fields' => $fields,
    ],
  ],
] );
