<?php
/**
 * This file doesn't do anything,
 * it's just a hub for importing and exporting all the code-split changes.
 */

namespace Launchpad\Changes;

const UNSUPPORTED = '<em style="color:red">(UNSUPPORTED)</em> ';
const UNTESTED = '<em style="color:red">(UNTESTED)</em> ';

require_once 'groups/admin_menu.php';
require_once 'groups/capabilities.php';
require_once 'groups/content.php';
require_once 'groups/media.php';
require_once 'groups/users.php';
require_once 'groups/co_authors_plus.php';

/**
 * Changesets inside named groups
 * Used to both create the settings page and execute the changes.
 * 
 * @return array
 */
function definitions() {
  return [
    admin_menu(),
    capabilities(),
    content(),
    media(),
    users(),
    co_authors_plus(),
  ];
}
