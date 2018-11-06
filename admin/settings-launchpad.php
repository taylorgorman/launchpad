<?php
/*
** Register settings
*/
add_action( 'admin_init', function(){
	register_setting( 'launchpad_settings', 'launchpad' );
} );

/*
** Create subpage
*/
add_action( 'admin_menu', function(){
add_submenu_page( 'options-general.php', 'Launchpad Settings', 'Launchpad', 'manage_options', 'launchpad-settings', function(){

	?>
	<style>
		.error {color: red}
		.dashicons {opacity:.6; margin:0 .25em}
		input:not(:checked) + .dashicons {opacity:.3}
	</style>

	<div class="wrap">

		<h2>Launchpad Settings</h2>

		<form method="post" action="options.php">
		<?php
		/*
		** Set and get form data
		*/
		settings_fields('launchpad_settings');
		$launchpad_db = get_option('launchpad');
		//echo '<pre>'.print_r($launchpad_db,1).'</pre>';

		/*
		** Set up post types sorting options
		*/
		foreach ( get_post_types() as $i => $post_type ) {

			$pt_object = get_post_type_object($post_type);
			//echo '<pre>'.print_r($pt_object,1).'</pre>';

			// Only visible post types
			if ( ! $pt_object->public ) continue;

			// Get the post type icon
			if ( empty($pt_object->menu_icon) ) $pt_object->menu_icon = 'dashicons-admin-'.( $post_type == 'attachment' ? 'media' : $post_type );

			// Build markup
			$db_orderby = ( empty($launchpad_db['orderby'][$post_type]) ) ? '' : $launchpad_db['orderby'][$post_type];
			$db_order = ( empty($launchpad_db['order'][$post_type]) ) ? '' : $launchpad_db['order'][$post_type];

			$post_types_sorting_markup[$i] = '<i class="dashicons '.$pt_object->menu_icon.'"></i> ';
			$post_types_sorting_markup[$i] .= '<strong>'. $pt_object->label .'</strong> ';
			$post_types_sorting_markup[$i] .= 'sort by <input type=text name=launchpad[orderby]['.$post_type.'] value="'. $db_orderby .'"> ';
			$post_types_sorting_markup[$i] .= '<select name=launchpad[order]['.$post_type.']>';
			$post_types_sorting_markup[$i] .= '<option value="">-- default --</option>';
			$post_types_sorting_markup[$i] .= '<option value=ASC '. selected( 'ASC', $db_order, 0 ) .'>ASC</option>';
			$post_types_sorting_markup[$i] .= '<option value=DESC '. selected( 'DESC', $db_order, 0 ) .'>DESC</option>';
			$post_types_sorting_markup[$i] .= '</select>';
			$post_types_sorting_markup[$i] .= '<br>';

		}

		/*
		** Generate form fields
		*/
		$launchpad_settings_fields = [
			[
				'type' => 'checkbox',
				'label' => 'Allow page comments',
			],
			[
				'type'   => 'custom',
				'label'  => 'Post types sorting',
				'markup' => $post_types_sorting_markup,
			]
		];

		$launchpad_settings_fields = apply_filters( 'launchpad_settings_fields', $launchpad_settings_fields );

		admin_fields([
			'before_fields' => '<table class="form-table">',
			'during_fields' => '<tr><th>%1$s</th><td><fieldset>%2$s%3$s</fieldset></td></tr>',
			'after_fields'  => '</table>',
			'group_name'    => 'launchpad',
			'group_value'   => $launchpad_db,
			'fields'        => $launchpad_settings_fields
		]);

		submit_button();
		?>
		</form>

	</div>
	<?php

} );
} );
