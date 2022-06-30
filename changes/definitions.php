<?php

namespace Launchpad\Changes;

const UNSUPPORTED = '<em style="color:red">(UNSUPPORTED)</em> ';
const UNTESTED = '<em style="color:red">(UNTESTED)</em> ';

require_once 'groups/admin-menu.php';
require_once 'groups/capabilities.php';
require_once 'groups/pages.php';
require_once 'groups/content.php';
require_once 'groups/media.php';
require_once 'groups/users.php';

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
    pages(),
    content(),
    media(),
    users(),
  ];
}
