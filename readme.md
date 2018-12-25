# Launchpad

A must-use plugin that makes WordPress better.
Tightens up really basic WordPress settings and UI, provides extra developer functions.

## Changes

- Contact settings screen for company name, email, address, social networks, and more. Up to theme to implement.
- Allow Editor role to edit theme options
- Add excerpt to pages
- Remove theme and plugin edit menu items
- Move media below post types in menu
- Don't user see other's media if they can't edit other's posts
- Add user fields for Instagram username, Facebook URL, Twitter username, Linkedin URL
- Remove from wp_head: generator meta tag, wlwmanifest meta tag, emoji scripts and styles
- Change excerpt length to 25 words
- Allow shortcodes in excerpts
- Prevent empty paragraphs around shortcodes
- Add post slug, terms, post template to post_class() and body_class()
- Add theme support for post thumbnails, post formats, menus, HTML5
- Add more image sizes (this is probably going away)

## Helper Functions

#### `wp_parse_args_deep( array $args, array $defaults )`

Like wp_parse_args() but recursive. Pretty sure this only works with arrays.

#### `admin_fields( array $args )`

#### `lp_register_post_type( array $args )`

Register post type with sane defaults.

- **$args**
  - **'id'** _(int)_ Post type name. Default is lowercase hyphened $singular_name.
   - **'singular_name'** _(string) (Required)_ Uppercased singular name of post type.
  - **'plural_name'** _(string)_ Uppercased plural name of post type. Default is $singular_name with an 's'.
  - **'args'** _(array)_ Passed directly to register_post_type( $args ) after being merged with sane defaults. Start with passing nothing to this then adding what's missing for you.

#### `lp_register_taxonomy( array $args )`

Register post type with sane defaults.

- **$args**
  - **'id'** _(int)_ Taxonomy name. Default is lowercase hyphened $singular_name.
   - **'post_types'** _(array|string) (Required)_ Passed directly to register_taxonomy( $object_type ).
   - **'singular_name'** _(string) (Required)_ Uppercased singular name of taxonomy.
  - **'plural_name'** _(string)_ Uppercased plural name of taxonomy. Default is $singular_name with an 's'.
  - **'args'** _(array)_ Passed directly to register_taxonomy( $args ) after being merged with sane defaults. Start with passing nothing to this then adding what's missing for you.

#### `minutes_to_read( string $string, int $wpm = false )`

Returns integer. Can override site-wide with 'words_per_minute_to_read' filter.

#### `date_range( string $start_date, string $end_date )`

Honestly can't remember exactly what this does or returns.

#### `get_jetpack_related_posts( int $numberposts = 3, int $postID = null )`

Returns array of post objects. $postID defaults to current if in loop.

#### `the_field_markup( int $field_id, string $before = '', string $after = '' )`

Display an ACF field with optional markup, similar to WordPress functions like the_title().

#### `get_trimmed_excerpt( int $length = 0, int|WP_Post $post = null )`

Returns &lt;p&gt; wrapped string of excerpt or content trimmed to $length, which falls back to 'excerpt_length' filter, ammended with 'excerpt_more' filter. $post defaults to current if in loop. Because the_excerpt() trims content, but not excerpt and get_the_excerpt() doesn't truncate and doesn't output &lt;p&gt;.

## Hooks

#### `apply_filters( 'words_per_minute_to_read', int $wpm )`
