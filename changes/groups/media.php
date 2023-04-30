<?php

namespace Launchpad\Changes;
use Vendor\MakeAdmin;

function media() {
  return [
    'title' => 'Media',
    'changes' => [
      [
        'title' => UNSUPPORTED . 'Add Open Graph image size',
        'name' => 'open-graph-image-size',
        'execute' => function () {
          // 1200 x 630 (still?)
        },
      ],
      [
        'title' => UNSUPPORTED . 'Remove public attachment pages',
        'name' => 'remove-attachment-pages',
        'execute' => function () {
        },
      ],
      [
        'title' => UNTESTED . 'Show hidden image sizes in Settings / Media',
        'name' => 'show-hidden-image-sizes',
        'execute' => function () {

          // Sizes that already exist in Settings / Media
          $editable_sizes = [
            'thumbnail',
            'medium',
            'large',
          ];
          // Convert image sizes to MakeAdmin Field API
          $fields = get_all_image_sizes();
          array_walk( $fields, function ( &$data, $name ) use ( $editable_sizes ) {
            // Empty existing sizes
            if ( in_array( $name, $editable_sizes, true ) ) {
              $data = null;
            }
            else {
              $data = [
                'label' => $name . ' size',
                'callback' => function () use ( $data, $name ) {
                  ?>
                  <fieldset>
                    <legend class="screen-reader-text"><span><?php echo $name . '_size'; ?> size</span></legend>
                    <label for="<?php echo esc_attr( $name . '_size_w' ); ?>">Width</label>
                    <input disabled name="<?php echo esc_attr( $name . '_size_w' ); ?>" type="number" value="<?php echo esc_attr( $data['width'] ); ?>" class="small-text" />
                    <br>
                    <label for="<?php echo esc_attr( $name . '_size_h' ); ?>">Height</label>
                    <input disabled name="<?php echo esc_attr( $name . '_size_h' ); ?>" type="number" value="<?php echo esc_attr( $data['height'] ); ?>" class="small-text" />
                  </fieldset>
                  <?php
                },
              ];
            }
          } );
          // Remove empty values (existing sizes)
          $fields = array_filter( $fields );
          // Add new section to Settings / Media
          MakeAdmin\section( [
            'page' => 'media',
            'title' => 'Hidden Image Sizes',
            'fields' => $fields,
          ] );

        },
      ],
    ],
  ];
}

function get_all_image_sizes() {
	global $_wp_additional_image_sizes;

	$image_sizes         = [];
	$default_image_sizes = get_intermediate_image_sizes();

	foreach ( $default_image_sizes as $size ) {
		$image_sizes[ $size ]['width']  = intval( get_option( "{$size}_size_w" ) );
		$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
		$image_sizes[ $size ]['crop']   = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}

	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
	}

	return $image_sizes;
}
