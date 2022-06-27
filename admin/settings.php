<?php
/**
 * Launchpad settings page
 * @see https://developer.wordpress.org/plugins/settings/custom-settings-page/
 */

namespace Launchpad\Settings;
use Launchpad\Setup;

/**
 * Create settings admin page
 */
add_action( 'admin_menu', function () {
  add_options_page(
    Setup\title,                    // page title
    Setup\title,                    // menu title
    'manage_options',               // capability
    sanitize_title( Setup\title ),  // menu slug
    function () {                    // callback

      // check user capabilities
      if ( ! current_user_can( 'manage_options' ) ) {
        return;
      }

      /*
      // check if the user have submitted the settings
      // WordPress will add the "settings-updated" $_GET parameter to the url
      if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved hm', 'wporg' ), 'updated' );
      }

      // show error/update messages
      settings_errors( 'wporg_messages' );
      */

      ?>
      <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
          <?php
          // output security fields for the registered setting "wporg"
          settings_fields( 'launchpad' );
          // output setting sections and their fields
          // (sections are registered for "wporg", each field is registered to a specific section)
          do_settings_sections( 'launchpad_settings_section' );
          // output save settings button
          submit_button( 'Save Settings' );
          ?>
        </form>
      </div>
      <?php

    },
  );
} );

/**
 * DB option, settings section and fields
 */
add_action( 'admin_init', function () {

  $settings = [
    'option_group' => 'launchpad',
    'option_name' => 'launchpad_settings',
    'option_args' => [
      'type' => 'object',
      'description' => 'All data related to Launchpad settings',
      // 'default' => [],
    ],
    'sections' => [
      [
        'id' => 'launchpad_settings_section',
        /*
        'title' => 'The Matrix has you.',
        'callback' => function ( $args ) {
          ?>
          <p>Follow the white rabbit.</p>
          <?php
        },
        */
        'page' => 'launchpad_settings_section',
        'fields' => [
          // [
          //   'id' => 'text-test',
          //   'title' => 'Text Test',
          //   'callback' => __NAMESPACE__ . '\\admin_field_text',
          //   'args' => [
          //     'label_for' => 'text-test',
          //     'class' => 'text-test-row',
          //     'description' => 'Are we saving the data?'
          //   ],
          // ],
          [
            'id' => 'admin-menu',
            'title' => 'Admin Menu',
            'callback' => __NAMESPACE__ . '\\admin_field_multiselect',
            'args' => [
              'label_for' => 'admin-menu',
              'class' => 'admin-menu-row',
              'options' => [
                'Move Media below post types and Comments',
                'Remove Appearance / Theme File Editor',
                'Remove Plugins / Plugin File Editor',
              ],
            ],
          ],
          [
            'id' => 'capabilities',
            'title' => 'Capabilities',
            'callback' => __NAMESPACE__ . '\\admin_field_multiselect',
            'args' => [
              'label_for' => 'capabilities',
              'class' => 'capabilities-row',
              'options' => [
                'Authors and below can\'t access other users\' media',
                'Editors can access Theme options',
              ],
            ],
          ],
          [
            'id' => 'pages',
            'title' => 'Pages',
            'callback' => __NAMESPACE__ . '\\admin_field_multiselect',
            'args' => [
              'label_for' => 'pages',
              'class' => 'pages-row',
              'options' => [
                'Add excerpt to pages',
              ],
            ],
          ],
          [
            'id' => 'media',
            'title' => 'Media',
            'callback' => __NAMESPACE__ . '\\admin_field_multiselect',
            'args' => [
              'label_for' => 'media',
              'class' => 'media-row',
              'options' => [
                'Add Open Graph image size',
              ],
            ],
          ],
          [
            'id' => 'users',
            'title' => 'Users',
            'callback' => __NAMESPACE__ . '\\admin_field_multiselect',
            'args' => [
              'label_for' => 'media',
              'class' => 'media-row',
              'options' => [
                'Add Instagram username field',
                'Add Twitter username field',
                'Add LinkedIn URL field',
                'Add Facebook URL field',
              ],
            ],
          ],
          [
            'id' => 'coauthors',
            'title' => 'Plugin: CoAuthors',
            'callback' => __NAMESPACE__ . '\\admin_field_multiselect',
            'args' => [
              'label_for' => 'coauthors',
              'class' => 'coauthors-row',
              'options' => [
                'Remove extra image sizes (LIST NAMES)',
              ],
            ],
          ],
          // [
          //   'id' => 'matrix',
          //   'title' => 'Matrix pill',
          //   'callback' => __NAMESPACE__ . '\\admin_field_select',
          //   'args' => [
          //     'label_for' => 'matrix',
          //     'class' => 'matrix_row',
          //     'options' => [
          //       'Pick a pill'
          //     ],
          //     'description' => 'I have something you want'
          //   ],
          // ],
        ],
      ],
    ],
  ];

  // Register option in wp_options table
  // But the function calls it a setting. Ook.
  register_setting(
    $settings['option_group'],
    $settings['option_name'],
    $settings['option_args']
  );

  // Register settings sections
  foreach ( $settings['sections'] as $section ) {
    add_settings_section(
      $section['id'],
      $section['title'],
      $section['callback'],
      $section['page']
    );
    // Register fields
    foreach ( $section['fields'] as $field ) {
      add_settings_field(
        $field['id'],
        $field['title'],
        $field['callback'],
        $section['page'],
        $section['id'],
        $field['args']
      );
    }
  }

} );

/**
 * Admin field
 * See other admin field functions for args specific to each input type.
 * In the fields for each type below, the name attribute is what makes it save properly.
 * 
 * @param array $args
 * @param array $args['label_for'] - WordPress adds to the for attribute of the <label>. Add it to the field's id attribute.
 * @param array $args['class'] - WordPress adds to the class of the <tr> containing the field and label.
 * @param array $args['description']
 */
function admin_field( $args, $render_field ) {
  $data = get_option( 'launchpad_settings' );
  $render_field( $data[ $args['label_for'] ] );
  if ( $args['description'] ) {
    ?>
    <p class="description">
      <?php echo $args['description']; ?>
    </p>
    <?php
  }
}

/**
 * Admin field: multi-select
 * Achieved with checkboxes
 * See admin_field() for arguments across input types
 * 
 * @param array $args
 * @param array $args['options']
 */
function admin_field_multiselect( $args ) {
  admin_field( $args, function ( $data ) use ( $args ) {

    ?>
    <fieldset>
      <legend class="screen-reader-text"><?php echo $args['description']; ?></legend>
      <?php
      foreach ( $args['options'] as $option ) {
        ?>
        <label>
          <input
            type="checkbox"
            name="launchpad_settings[<?php echo esc_attr( $args['label_for'] ); ?>][]"
            value="<?php echo $option; ?>"
            <?php checked( is_array( $data ) && in_array( $option, $data ) ); ?>
          />
          <?php echo $option; ?>
        </label>
        <br />
        <?php
      }
      ?>
    </fieldset>
    <?php

  } );
}

/**
 * Admin field: select
 * Achieved with dropdown or radio buttons, depending on an argument
 */

/**
 * Admin field: boolean
 * Achieved with one checkbox
 */

/**
 * Admin field: text
 * Achieved with text input
 */
function admin_field_text( $args ) {
  admin_field( $args, function ( $data ) use ( $args ) {
    ?>
    <input
      type="text"
      id="<?php echo esc_attr( $args['label_for'] ); ?>"
      name="launchpad_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
      value="<?php echo $data; ?>"
    />
    <?php
  } );
}

/**
 * Admin field
 * 
 * @param array $args
 * @param array $args['label_for'] - WordPress adds to the for attribute of the <label>. Add it to the field's id attribute.
 * @param array $args['class'] - WordPress adds to the class of the <tr> containing the field and label.
 */
function admin_field_select( $args ) {
  $options = get_option( 'launchpad_settings' );
  ?>
  <select
    id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
    name="launchpad_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
  >
    <option
      value="red"
      <?php
      echo isset( $options[ $args['label_for'] ] )
        ? ( selected( $options[ $args['label_for'] ], 'red', false ) )
        : ( '' ); 
      ?>
    >
      red pill
    </option>
    <option
      value="blue"
      <?php
      echo isset( $options[ $args['label_for'] ] )
        ? ( selected( $options[ $args['label_for'] ], 'blue', false ) )
        : ( '' );
      ?>
    >
      blue pill
    </option>
  </select>
  <p class="description">
    You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.
  </p>
  <p class="description">
    You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.
  </p>
  <?php
}
