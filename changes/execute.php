<?php

namespace Launchpad\Changes;
use Launchpad\Setup;

// Get data
$data = get_option( Setup\NAME );

// For each change group..
foreach ( Setup\changes() as $change_group ) {
  // Get group data
  $group_data = $data[ sanitize_title( $change_group['title'] ) ];
  // If we don't even have group data, don't bother
  if ( is_array( $group_data ) ) {
    // For each change..
    foreach ( $change_group['changes'] as $change ) {
      // If the setting is on..
      if ( in_array( $change['title'], $group_data ) ) {
        // Execute the change.
        $change['execute']();
      }
    }
  }
}
