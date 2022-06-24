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
add_action( 'admin_menu', function() {
  add_options_page(
    Setup\title,                    // page title
    Setup\title,                    // menu title
    'manage_options',               // capability
    sanitize_title( Setup\title ),  // menu slug
    function() {                    // callback

      // check user capabilities
      if ( ! current_user_can( 'manage_options' ) ) {
        return;
      }

      // check if the user have submitted the settings
      // WordPress will add the "settings-updated" $_GET parameter to the url
      if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved hm', 'wporg' ), 'updated' );
      }

      // show error/update messages
      settings_errors( 'wporg_messages' );
      ?>
      <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
          <?php
          // output security fields for the registered setting "wporg"
          settings_fields( 'wporg' );
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
 * Custom option and settings
 */
add_action( 'admin_init', function() {

  $settings = [
    'option_group' => 'wporg',
    'option_name' => 'wporg_options',
    'option_args' => [
      'type' => 'object',
      'description' => 'All data related to Launchpad settings',
      // 'default' => [],
    ],
    'sections' => [
      [
        'id' => 'wporg_section_developers',
        'title' => 'The Matrix has you.',
        'callback' => function( $args ) {
          ?>
          <p>Follow the white rabbit.</p>
          <?php
        },
        'page' => 'launchpad_settings_section',
        'fields' => [
          [
            'id' => 'wporg_field_pill',
            'title' => 'Pill',
            'callback' => __NAMESPACE__ . '\\wporg_field_pill_cb',
            'args' => [
              'label_for' => 'wporg_field_pill',
              'class' => 'wporg_row',
              'wporg_custom_data' => 'custom',
            ],
          ],
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
* Pill field callbakc function.
*
* WordPress has magic interaction with the following keys: label_for, class.
* - the "label_for" key value is used for the "for" attribute of the <label>.
* - the "class" key value is used for the "class" attribute of the <tr> containing the field.
* Note: you can add custom key value pairs to be used inside your callbacks.
*
* @param array $args
*/
function wporg_field_pill_cb( $args ) {
  // Get the value of the setting we've registered with register_setting()
  $options = get_option( 'wporg_options' );
  ?>
  <select
    id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
    name="wporg_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
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
