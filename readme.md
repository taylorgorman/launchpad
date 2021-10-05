# Launchpad

A must-use plugin that makes WordPress better.
Tightens up really basic WordPress settings and UI, provides extra developer functions.

## Changes

- Add setting in Settings/Media to prevent Authors and below from seeing others' media
- Don't let user see other's media if they can't edit other's posts (according to above setting)
- Add editable image sizes: Small, XLarge, Open Graph
- Remove extra image sizes added by CoAuthors plugin
- Move media below post types in menu
- Remove theme and plugin edit menu items
- Add excerpt to pages
- Allow Editor role to edit theme options
- Contact settings screen for company name, email, address, social networks, and more. Up to theme to implement.
- Add theme support for post thumbnails, post formats, menus, HTML5
- Add user fields for Instagram username, Facebook URL, Twitter username, Linkedin URL
- Remove user fields for AIM, YIM, and Jabber
- Change excerpt length to 25 words
- Allow shortcodes in excerpts

## Helper Functions

#### `admin_fields( array $args )`

_Details coming.._

#### `minutes_to_read( string $string, int $wpm = false )`

Returns integer. Can override site-wide with 'words_per_minute_to_read' filter.

#### `get_jetpack_related_posts( int $numberposts = 3, int $postID = null )`

Returns array of post objects. $postID defaults to current if in loop.

#### `wp_parse_args_deep( array $args, array $defaults )`

Like wp_parse_args() but recursive. Pretty sure this only works with arrays.

## Hooks

#### `apply_filters( 'words_per_minute_to_read', int $wpm = 200 )`

Globally change the words per minute for the `minutes_to_read()` function.

#### `apply_filters( 'ls_new_image_sizes', array $sizes )`

Modify the image sizes added by Launchpad, which are small, xlarge, and open_graph.

## Other recommended resources

- SoberWP Models for registering post types and taxonomies
