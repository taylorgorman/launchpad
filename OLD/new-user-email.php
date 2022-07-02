<?php
/**
 * I think this isn't called anywhere. It it too bespoke?
 * Check out https://wordpress.org/plugins/bnfw/ and see if it replaces this.
 */
if ( ! function_exists('wp_new_user_notification') ) {
function wp_new_user_notification( $user_id, $plaintext_password='' ) {

	// Get data
	$user = get_userdata($user_id);
	$usermeta = get_user_meta($user_id);
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$nl = "\r\n";

	// Build site admin email
	$message  = 'Username: '. $user->user_login .$nl;
	$message .= 'Email: '. $user->user_email .$nl;
	$message .= $nl;
	if ( !empty($usermeta['first_name']) ) $message .= 'First Name: '. reset($usermeta['first_name']) .$nl;
	if ( !empty($usermeta['last_name']) ) $message .= 'Last Name: '. reset($usermeta['last_name']) .$nl;
	if ( !empty($usermeta['birthdate']) ) $message .= 'Birthdate: '. reset($usermeta['birthdate']) .$nl;
	if ( !empty($usermeta['hometown']) ) $message .= 'Hometown: '. reset($usermeta['hometown']) .$nl;
	if ( !empty($usermeta['gender']) ) $message .= 'Gender: '. reset($usermeta['gender']) .$nl;

	// Send email to site admin
	wp_mail( get_option('admin_email'), "New user on $blogname", $message );

	// Need password to send it to new user
	if ( empty($plaintext_password) )
		return;

	// Build new user email
	$message  = 'Hey '. reset($usermeta['first_name']) .', you\'re all set up to write on '. $blogname .'! To get started, go to '. wp_login_url() .' and use the information below to log in. Feel free to change your password and update your information any time.' .$nl;
	$message .= $nl;
	$message .= 'Username: '. $user->user_login .$nl;
	$message .= 'Password: '. $plaintext_password .$nl;
	$message .= $nl;
	$message .= 'See you soon and happy writing!' .$nl;
	$message .= 'Your friends at '. $blogname;

	// Send email to new user
	wp_mail( $user->user_email, "Weclome to $blogname!", $message );

}
}

/*
** This is just to display the email without having to create a new user
**
add_action( 'admin_menu', function() {
add_submenu_page( 'users.php', 'New User Email', 'New User Email', 'edit_pages', 'new-user-email', function() {

	// Get data
	$user_id = 57;
	$user = get_userdata($user_id);
	$usermeta = get_user_meta($user_id);
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$nl = '<br>';

	// Build site admin email
	$message  = 'Username: '. $user->user_login ."/r/n";
	$message .= 'Email: '. $user->user_email .$nl;
	$message .= $nl;
	$message .= 'First Name: '. reset($usermeta['first_name']) .$nl;
	$message .= 'Last Name: '. reset($usermeta['last_name']) .$nl;
	$message .= 'Birthdate: '. reset($usermeta['birthdate']) .$nl;
	$message .= 'Hometown: '. reset($usermeta['hometown']) .$nl;
	$message .= 'Gender: '. reset($usermeta['gender']) .$nl;

	// Send email to site admin
	echo "<h2>New user on $blogname</h2>".$message;

	// Need password to send it to new user
	if ( empty($plaintext_password) )
		return;

	// Build new user email
	$message  = 'Hey '. reset($usermeta['first_name']) .', you\'re all set up to write on '. $blogname .'! To get started, go to '. wp_login_url() .' and use the information below to log in. Feel free to change your password and update your information any time.' .$nl;
	$message .= $nl;
	$message .= 'Username: '. $user->user_login .$nl;
	$message .= 'Password: '. $plaintext_password .$nl;
	$message .= $nl;
	$message .= 'See you soon and happy writing!' .$nl;
	$message .= 'Your friends at '. $blogname;

	// Send email to new user
	echo "<h2>Weclome to $blogname!</h2>".$message;

} );
} );
*/
