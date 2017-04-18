<?php
/*
** Register settings
*/
add_action( 'admin_init', function(){
	register_setting( 'contact_info_settings', 'contact_info' );
} );

/*
** Create subpage
*/
add_action( 'admin_menu', function(){
add_submenu_page( 'options-general.php', 'Contact Settings', 'Contact', 'publish_pages', 'contact-info', function(){

	?>
	<style>
		input#contact_info-locations-count {width:3em}
	</style>

	<div class="wrap">

		<h2>Contact Settings</h2>

		<form method="post" action="options.php">
		<?php
		settings_fields('contact_info_settings');
		$contact_info_db = get_option('contact_info');
		//echo '<pre>'.print_r($contact_info_db,1).'</pre>';

		admin_fields(array(
			'group_name'  => 'contact_info'
		,	'group_value' => $contact_info_db
		,	'before_fields' => '<table class="form-table">'
		,	'during_fields' => '<tr><th>%1$s</th><td><fieldset>%2$s%3$s</fieldset></td></tr>'
		,	'after_fields'  => '</table>'
		,	'fields'      => array(
				array(
					'label'       => 'Company Name'
				,	'placeholder' => get_bloginfo('name')
				,	'cols'        => 2
				,	'desc'        => 'Fallback is Site Title in <a href="/wp-admin/options-general.php">Settings / General</a>.'
				)
			,	array(
					'label'       => 'Catch-all Email'
				,	'placeholder' => get_bloginfo('admin_email')
				,	'cols'        => 2
				,	'desc'        => 'Fallback is E-mail Address in <a href="/wp-admin/options-general.php">Settings / General</a>.'
				)
			)
		));

		admin_fields(array(
			'group_name'    => 'contact_info'
		,	'group_value'   => $contact_info_db
		,	'before_fields' => ''
		,	'during_fields' => '<h3>%2$s %1$s</h3>%3$s'
		,	'after_fields'  => ''
		,	'fields'        => array(
				array(
					'type'  => 'number'
				,	'label' => 'Locations'
				,	'name'  => 'locations-count'
				,	'desc'  => 'Save Changes to update number of fields below.'
				)
			)
		));

		for ( $i = 1; $i <= get_contactinfo('locations-count'); $i++ ) {
			admin_fields(array(
				'group_name'  => 'contact_info'
			,	'group_value' => $contact_info_db
			,	'fields'      => array(
					array(
						'label' => 'Location '.$i.' Name'
					,	'name'  => 'location-name-'.$i
					,	'cols'  => 2
					)
				,	array(
						'label' => 'Street Address'
					,	'name'  => 'street-address-'.$i
					,	'cols'  => 2
					)
				,	array(
						'label' => 'City'
					,	'name'  => 'city-'.$i
					,	'cols'  => 2
					)
				,	array(
						'label' => 'State'
					,	'name'  => 'state-'.$i
					,	'cols'  => 4
					)
				,	array(
						'label' => 'Zip'
					,	'name'  => 'zip-'.$i
					,	'cols'  => 4
					)
				,	array(
						'label' => 'Phone'
					,	'name'  => 'phone-'.$i
					,	'cols'  => 2
					)
				,	array(
						'label' => 'Fax'
					,	'name'  => 'fax-'.$i
					,	'cols'  => 2
					)
				)
			));
		}
		?>

		<h3>Social Networks</h3>
		<p class="description">Make sure to include the http:// for all URLs.</p>

		<?php
		admin_fields(array(
			'group_name' => 'contact_info'
		,	'group_value' => $contact_info_db
		,	'before_fields' => '<table class="form-table">'
		,	'during_fields' => '<tr><th>%1$s</th><td><fieldset>%2$s%3$s</fieldset></td></tr>'
		,	'after_fields'  => '</table>'
		,	'fields'     => array(
				array(
					'label' => 'Facebook URL'
				)
			,	array(
					'label' => 'Twitter Username'
				)
			,	array(
					'label' => 'Instagram Username'
				)
			,	array(
					'label' => 'Tumblr URL'
				)
			,	array(
					'label' => 'Linkedin URL'
				)
			,	array(
					'label' => 'Vimeo URL'
				)
			,	array(
					'label' => 'YouTube URL'
				)
			)
		));

		submit_button();
		?>
		</form>

	</div>
	<?php
	//echo '<pre>'.print_r($_POST,1).'</pre>';

} );
} );

/*
** Just an easy way to echo get_contactinfo
*/
function contactinfo( $name = '', $fallback = '' ) {
	echo get_contactinfo( $name, $fallback );
}

/*
** Retrieve all this stuff here
** Only pulls from the database once
*/
function get_contactinfo( $name = '', $fallback = '' ) {

	// Get from global, or from database
	global $contact_info;
	if ( empty($contact_info) )
		$contact_info = get_option('contact_info');

	// If no specific value requested, you must want the whole thing
	if ( empty($name) )
		return $contact_info;

	// Requested doesn't exist
	if ( empty($contact_info[$name]) ) {

		// Specified fallback
		if ( ! empty($fallback) )
			return $fallback;

		// Alternates
		if ( is_string($fallback) ) { switch ( $name ) {

			case 'company-name' :
				return get_bloginfo('name');

			case 'catch-all-email' :
				return get_bloginfo('admin_email');

			case 'locations-count' :
				return 1;

			default :
				return $fallback;

		} }

		// Or bail
		return false;

	}

	// Return requested value
	return $contact_info[$name];

}

/*
** Easy way to just get URLs
*/
function get_socialurls( $network='' ) {

	$urls = array(
		'facebook' => get_contactinfo('facebook-url')
	,	'twitter' => 'https://twitter.com/'.get_contactinfo('twitter-username')
	,	'instagram' => 'https://instagram.com/'.get_contactinfo('instagram-username')
	,	'tumblr' => get_contactinfo('tumblr-url')
	,	'linkedin' => get_contactinfo('linkedin-url')
	,	'vimeo' => get_contactinfo('vimeo-url')
	,	'youtube' => get_contactinfo('youtube-url')
	);

	if ( empty($network) )
		return array_filter($urls);

	if ( empty($urls[$network]) )
		return false;

	return $urls[$network];

}
