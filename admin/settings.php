<?php
/**
 * Launchpad settings page
 */

namespace Launchpad\Settings;
use Launchpad\Setup;

// Register settings page
add_action( 'admin_menu', function() {
  add_options_page(
    /* page title */  Setup\name,
    /* menu title */  Setup\title,
    /* capability */  'manage_options',
    /* menu slug */   Setup\name,
    /* callback */    'Launchpad\Settings\output',
  );
} );

// Render for settings page
function output() {
  ?>
  <div class="wrap">
    <h1>Launchpad</h1>
    List of toggles here, defaulted to off.
  </div>
  <?php
}
