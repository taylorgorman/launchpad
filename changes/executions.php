<?php

namespace Launchpad\Changes;
use Launchpad\Setup;

// Get data
$data = get_option( Setup\NAME ) ?: [];

// For each change group..
foreach ( definitions() as $change_group ) {
  // Can we get group data?
  if ( empty( $data[ sanitize_title( $change_group['title'] ) ] ) )
    continue;
  // Get group data
  $group_data = $data[ sanitize_title( $change_group['title'] ) ];
  // Is group data correct type?
  if ( ! is_array( $group_data ) )
    continue;
  // For each change..
  foreach ( $change_group['changes'] as $change ) {
    // If the setting is on..
    if ( in_array( $change['title'], $group_data ) ) {
      // Execute the change.
      $change['execute']();
    }
  }
}
