<?php

namespace Vendor\MakeAdmin;

/**
 * Create an admin page. Under existing page or as top-level.
 * 
 * @param array $page [
 *   @value string $title - Required.
 *   @value string $capability - Required.
 *   @value string $parent - Parent page file name or title. If not supplied, will create a top-level menu page.
 *   @value string $menu_title - Falls back to title
 *   @value string $menu_slug - Falls back to kebab-caseed $title.
 *   @value string $sections_group - Falls back to slug + "-sections"
 *   @value string $options_group - Falls back to slug + "-options"
 *   @value int $position - Determines placement in the menu order
 *   @value array $sections - See section() for params.
 * ]
 * 
 * @return void
*/
function page( array $page = [] ) {
  /**
   * Required
   */
  if (
    empty( $page['title'] )
    || empty( $page['capability'] )
  )
    return; // change this to a visible useful error message

  /**
   * Defaults and fallbacks
   */
  $page = array_merge( [
    'parent' => null,
    'menu_title' => null,
    'menu_slug' => null,
    'sections_group' => null,
    'options_group' => null,
    'position' => null,
    'sections' => null,
  ], $page );
  
  /**
   * Allow easy aliases for WordPress menu pages via title instead of file name
   */
  $wp_menu_titles = [
    'tools' => 'tools.php',
    'settings' => 'options-general.php',
  ];
  if ( strtolower( $page['parent'] ) === 'settings' )
    $page['parent_slug'] = 'options-general.php';
  else
    $page['parent_slug'] = $page['parent'];

  /**
   * Fallbacks
   */
  // New value, slug, is custom menu_slug or kebab-cased title
  $page['slug'] = $page['menu_slug'] ?: sanitize_title( $page['title'] );
  // options_group falls back to slug + "-options"
  if ( empty( $page['options_group'] ) )
    $page['options_group'] = $page['slug'] . '-options';
  // sections_group falls back to slug + "-sections"
  if ( empty( $page['sections_group'] ) )
    $page['sections_group'] = $page['slug'] . '-sections';
  // menu_title falls back to title
  if ( empty( $page['menu_title'] ) )
    $page['menu_title'] = $page['title'];

  /**
   * Add page as submenu of any existing page
   */
  add_action( 'admin_menu', function () use ( $page ) {
    /**
     * @see https://developer.wordpress.org/reference/functions/add_options_page/
     * @see README.md
     */
    add_submenu_page(
      $page['parent_slug'],
      $page['title'],
      $page['menu_title'],
      $page['capability'],
      $page['slug'],
      function () use ( $page ) {
        // Double-ensure user's capabilities
        if ( ! current_user_can( $page['capability'] ) )
          return;
        // Render page
        ?>
        <div class="wrap">
          <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
          <form action="options.php" method="post">
            <?php
            // Output security fields for this options group.
            // This allows the fields to save.
            settings_fields( $page['options_group'] );
            // Output sections in this sections group
            do_settings_sections( $page['sections_group'] );
            // Submit button
            submit_button( 'Save Changes' );
            ?>
          </form>
        </div>
        <?php
      },
      $page['position'],
    );
  } );
  
  /**
   * Register nested sections
   */
  if ( ! empty( $page['sections'] ) ) {
    foreach ( $page['sections'] as $section ) {
      // Nested sections always inherit their page's groups
      $section['options_group'] = $page['options_group'];
      $section['sections_group'] = $page['sections_group'];
      $section['page_title'] = $page['title'];
      // Register section
      section( $section );
    }
  }
}

/**
 * Create an admin section.
 * 
 * @param array $section [
 *   @value string $title - Required.
 *   @value string $id - Falls back to kebab-cased $title + "-section"
 *   @value string $options_group - Required. Name of option group on the page to which this section belongs
 *   @value string $option_name - Falls back to kebab-case of $title
 *   @value string $option_args - Optional, but encouraged
 *   @value string $sections_group - Required (unless $page is provided instead). Relates this section to the page where it should appear
 *   @value string $page - Alias for $sections_group to match add_settings_section() param names
 *   @value string|callable $content - Markup that appears between title and fields
 *   @value callable $callback - Alias for $content to match add_settings_section() param names
 * ]
 * 
 * @return void
*/
function section( array $section = [] ) {
  /**
   * Required
   */
  if (
    empty( $section['title'] )
  )
    return; // change this to a visible useful error message

  /**
   * Defaults and fallbacks
   */
  $section = array_merge( [
    'id' => null,
    'options_group' => null,
    'option_name' => null,
    'option_args' => null,
    'sections_group' => null,
    'page' => null,
    'content' => null,
    'callback' => null,
  ], $section );

  /**
   * Fallbacks
   */
  if ( is_string( $section['content'] ) ) {
    $content = $section['content'];
    $section['content'] = function () use ( $content ) {
      // Wrap string in a <p> if it doesn't start with a tag
      // to prevent inconsistent typography.
      // Logic hole: the string starts with an inline formatting tag, like <strong>
      if ( substr( $content, 0, 1 ) !== '<' )
        $content = "<p>$content</p>";
      // Render
      echo $content;
    };
  }
  $section['id'] = $section['id'] ?: sanitize_title( $section['title'] ) . '-section';
  $section['option_name'] = $section['option_name'] ?: sanitize_title( $section['title'] );
  $section['sections_group'] = $section['sections_group'] ?: $section['page'];
  $section['content'] = $section['content'] ?: $section['callback'];

  add_action( 'admin_init', function () use ( $section ) {
    /**
     * Register option in wp_options table for this section
     * ..But the function calls it "setting". Ook.
     * @see https://developer.wordpress.org/reference/functions/register_setting/
     */
    register_setting(
      $section['options_group'],
      $section['option_name'],
      $section['option_args']
    );

    /**
     * @see https://developer.wordpress.org/reference/functions/add_settings_section/
     */
    add_settings_section(
      $section['id'], // Unique ID used in.. something. But not necessery to make this work.
      $section['title'] === $section['page_title'] ? '' : $section['title'], // Don't display section title if it repeats page title.
      $section['content'], // Just renders content btw heading and fields.
      $section['sections_group'] // same as do_settings_sections() on the settings page.
    );
  } );

  /**
   * Register nested fields
   */
  if ( ! empty( $section['fields'] ) ) {
    foreach ( $section['fields'] as $field ) {
      // Nested sections always inherit their page's groups
      $field['section_id'] = $section['id'];
      $field['sections_group'] = $section['sections_group'];
      $field['option_name'] = $section['option_name'];
      // Register field
      field( $field );
    }
  }
}

/**
 * Create an admin field.
 * 
 * @param array $field [
 *   @value array $type - Required.
 *   @value array $label - Required.
 *   @value array $id - Falls back to kebab-cased $label
 *   @value array $description - Help text appears beneath the input
 *   @value callable $callback - Optional. Advanced use only. Custom control the render of the field. Passed directly to add_settings_field( $callback ).
 * ]
 * 
 * @return void
*/
function field( array $field = [] ) {
  /**
   * Required
   */
  if (
    empty( $field['type'] )
    || empty( $field['label'] )
  )
    return; // change this to a visible useful error message

  /**
   * Defaults and fallbacks
   */
  $field = array_merge( [
    'id' => sanitize_title( $field['label'] ),
    'description' => null,
    'callback' => null,
  ], $field );

  add_action( 'admin_init', function () use ( $field ) {
    /**
     * @see https://developer.wordpress.org/reference/functions/add_settings_field/
     */
    add_settings_field(
      $field['id'],
      $field['label'],
      $field['callback'] ?: __NAMESPACE__ . '\\input',
      $field['sections_group'],
      $field['section_id'],
      $field, // Just pass entire $field array to input()
    );
  } );
}

/**
 * Render input fields. Even fancy ones!
 * 
 * @param array $field [
 *   @value array $type - Required.
 *   @value array $label - Required.
 *   @value array $id - Falls back to kebab-cased $label
 *   @value array $description - Help text appears beneath the input
 * ]
 * 
 * @return void
 */
function input( $field ) {
  // This section's data
  $option_value = get_option( $field['option_name'] );
  // This field's data
  $field['value'] = ! empty( $option_value[ $field['id'] ] )
    ? $option_value[ $field['id'] ]
    : null;

  // Render input
  switch ( $field['type'] ) {
    case 'multiselect':
    case 'checkboxes':
      input_multiselect( $field );
      break;
    default:
      input_default( $field );
  }

  // Render description
  if ( $field['description'] ) {
    ?>
    <p class="description">
      <?php echo $field['description']; ?>
    </p>
    <?php
  }
}

/**
 * Multiple choice question: can pick more than one
 */
function input_multiselect( $field ) {
  ?>
  <fieldset>
    <legend class="screen-reader-text"><?php echo $field['description']; ?></legend>
    <?php
    foreach ( $field['options'] as $option ) {
      ?>
      <label>
        <input
          type="checkbox"
          name="<?php echo esc_attr( $field['option_name'] . '[' . $field['id'] . '][]' ); ?>"
          value="<?php echo esc_attr( $option ); ?>"
          <?php checked( is_array( $field['value'] ) && in_array( $option, $field['value'] ) ); ?>
        />
        <?php echo wp_kses_post( $option ); ?>
      </label>
      <br />
      <?php
    }
    ?>
  </fieldset>
  <?php
}

/**
 * An <input> with the type value blindly thrown in
 */
function input_default( $field ) {
  // Fallbacks
  $field['type'] = $field['type'] ?: 'text';

  // Render
  ?>
  <input
    type="<?php echo esc_attr( $field['type'] ?: 'text' ); ?>"
    id="<?php echo esc_attr( $field['id'] ); ?>"
    name="<?php echo esc_attr( $field['option_name'] . '[' . $field['id'] . ']' ); ?>"
    value="<?php echo $field['value']; ?>"
  />
  <?php
}
