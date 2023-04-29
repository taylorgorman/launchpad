# MakeAdmin
> Create interfaces in WordPress admin.

## TLDR Code Examples

```php
use MakeAdmin;

// Add page with sections with fields
MakeAdmin\page( [
  'title' => 'Cool Beans',
  'sections' => [
    [
      'title' => 'Black Beans',
      'fields' => [
        [
          'label' => 'Favorite restaurant',
        ],
        [
          'label' => 'Chipotle order',
        ],
      ],
    ],
    [
      'title' => 'Magic Beans',
      'fields' => [
        [
          'label' => 'Giant\'s name',
        ],
    ],
  ],
] );
```

## Goals

### Admin pages
- [ ] Add top-level page(s)
- [ ] Add top-level page(s) with subpage(s)
- [ ] Add top-level page(s) with subpage(s) with section(s)
- [ ] Add top-level page(s) with subpage(s) with section(s) with field(s)
- [ ] Add top-level page(s) with section(s)
- [ ] Add top-level page(s) with section(s) with field(s)
- [x] Add subpage(s)
- [x] Add subpage(s) with section(s)
- [x] Add subpage(s) with section(s) with field(s)
- [x] Add section(s) to existing page
- [x] Add section(s) with field(s) to existing page
- [ ] Add field(s) to existing section

### Input types
- [ ] Default — `text`, `number`, anything else that's just a vanilla `<input>`)
- [ ] Textbox — Long text
- [ ] Boolean — A checkbox styled to look like a switch
- [ ] Multiselect — Default style = checkboxes
  - [x] Style = checkboxes
  - [ ] Style = buttons
  - [ ] Style = images
- [ ] Select — Default style = dropdown. Can only select one
  - [ ] Style = dropdown — `<select>`
  - [ ] Style = radio buttons
  - [ ] Style = buttons
  - [ ] Style = images
- [ ] Range — Between min and max

### Input features
- [ ] Value validation

### Dashboard widgets
- [ ] Something something dashboard widget(s)

## Data models

WordPress honestly is disappointingly inconsistent with their terms. Here I attempt to untangle the Christmas lights around the functions related to the [Settings API](https://developer.wordpress.org/plugins/settings/settings-api/).

I use the word "object" loosely here. These aren't PHP objects, they're conceptual objects to help us understand the data models. However, they do often obviously map to WordPress concepts.

### Option
_A key/value data saved in the `wp_options` database table._

| Key | Type | Default | Description
| - | - | - | -
| `name` | _string_ | | Key of data in `wp_options` database table

### Page
_A page in WP admin. Top level or belonging to an existing page._

| Key | Type | Default | Description
| - | - | - | -
| `parent` | _string_ | `'Settings'` | If falsey, will make a top-level page. Default is `'Settings'` because cluttering WP admin with plugin top-level pages is not good UX.
| `title` | _string_ | | Displayed as a heading at the top of the section
| `slug` | _string_ | `title`, kebab-cased |
| `menu_label` | _string_ | `title` | Text that appears in WP admin menu
| `menu_slug` | _string_ | `title`, kebab-cased | 
| `options_group` | _string_ | `title + 'options'` | Relates options (many) to page (one). Executed by [`settings_fields()`](https://developer.wordpress.org/reference/functions/settings_fields/).
| `sections_group` | _string_ | `title + 'sections'` | Relates sections (many) to page (one). Executed by [`do_settings_sections()`](https://developer.wordpress.org/reference/functions/do_settings_sections/).
| `capability` | _string_ | | The [capability name](https://wordpress.org/support/article/roles-and-capabilities/) required to access this page

### Section
_Sections must belong to a page._

| Key | Type | Default | Description
| - | - | - | -
| `title` | _string_ | | Publically rendered name for this section 
| `id` | _string_ | `title`, kebab-cased | Relates fields (many) to section (one).
| `slug` | _string_ | `title`, kebab-cased | Relates other objects to this section. Usually just a kebab-case version of Title.
| `content` | _string_ | | Renders between title and fields

### Field
_Fields must belong to a section._

| Key | Type | Default | Description
| - | - | - | -
| `type` | _string_ | `'text'` | One of the types this package supports. Doesn't map to a WordPress function, but informs the field markup.
| `label` | _string_ | | 
| `id` | _string_ | `label`, kebab-cased | 
| `render` | _string_ | | The blind markup for this field. Which this package makes simpler and predictable.

## WordPress functions
This is how the above data models are used when executing [Settings API](https://developer.wordpress.org/plugins/settings/settings-api/) functions.

### Make top-level Page
```php
FUNCTIONNAME(

)
```

### Make child Page ([docs](https://developer.wordpress.org/reference/functions/add_submenu_page/))
```php
add_submenu_page(
  $parent_slug,    // Page → parent
  $page_title,     // Page → title
  $menu_title,     // Page → menu_label
  $capability,     // Page → capability
  $menu_slug,      // Page → slug
  $callback = '',  // Page → content
  $position = null // Page → position
)
```

### Secure Options for this Page ([docs](https://developer.wordpress.org/reference/functions/settings_fields/))
```php
settings_fields(
  $option_group, // Page → options_group
)
```

### Render Sections related to this Page ([docs](https://developer.wordpress.org/reference/functions/do_settings_sections/))
```php
do_settings_sections(
  $page, // Page → sections_group
)
```

### Make  database option ([docs](https://developer.wordpress.org/reference/functions/register_setting/))
```php
register_setting(
  $option_group, // Page → options_group
  $option_name,  // Option → name
  $args = []     // 
)
```

### Associate Section to Page ([docs](https://developer.wordpress.org/reference/functions/add_settings_section/))
```php
add_settings_section(
  $id,       // Section → id
  $title,    // Section → title
  $callback, // Section → content
  $page      // Page → sections_group
)
```

### Associate Field to Section ([docs](https://developer.wordpress.org/reference/functions/add_settings_field/))
```php
add_settings_field(
  $id,                  // Field → id
  $title,               // Field → label
  $callback,            // Field → render
  $page,                // Page → sections_group
  $section = 'default', // Section → id
  $args = []            //
)
```
> In regards to `add_settings_field( $page )`, I don't understand why WordPress wants to relate a Field to a Page. If a Field must be related to a Section and a Section must be related to a Page, this seems redundant. But we can't provide `$args` without it because function arguments are stupidly linear.

## Frequent questions

### Uh, why not [ACF](https://www.advancedcustomfields.com/) / [Carbon Fields](https://carbonfields.net/) / {{insert other project here}}?
You know, I did, at first. And you could too, go for it! Reinventing the wheel is rarely a good idea. However, none of them did everything I needed. Yes, ACF does everything and more, _but_ it requires the ACF plugin, naturally. This package lets our plugins stand on their own, and also follow WordPress style guidelines to the letter.

### Why you changin' all these terms?
Listen, WordPress is great, but it is old and slow. It _has_ to be, it runs under nearly 40% of the internet. Open source packages like this are what help it rise above faster than it can on its own. Long live open source!

### Why change from option to options and section to sections?
You're a pedantic little shit, aren't you? Good, me too. If it's a group, it's a plural. A group of sections; a group of options; a pride of lions; a murder of crows. You get it.

## Scratch notes, don't read

So it's technically possible to add a field on more than one section. But I'm not sure it would work because the real magic happens with settings_fields( $option_group ) at the top of the page, plus name="$option_name[$field_name]" on the inputs. ..Hm but those are different.. and are connected byyy.. register_setting() it seems. Ok ok ok, so the PAGE says "this is my settings/option group name" with settings_fields( $option_group ). Then, to add data to that page, you register_setting() with THAT $option_group and YOUR $option_name. So multiple $option_names on one $option_group. And the args on register_setting() just describe the data and model. THEN to create user inputs, you must add YOUR $option_name to the name attribute on the input. Sheesh. That is so brittle and unclear.
