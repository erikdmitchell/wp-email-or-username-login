<?php
/*
 Plugin Name: WP Email or Username Login
 Plugin URI:
 Description: Allows users to login by their username or email.
 Version: 0.1.1
 Author: Erik Mitchell
 Author URI: http://erikmitchell.net
 License: GPLv2 or later
 Text Domain: ememaillogin
*/

/**
 * mdw_allow_email_login filter to the authenticate filter hook, to fetch a username based on entered email
 * @param  obj $user
 * @param  string $username [description]
 * @param  string $password [description]
 * @return boolean
 */
function em_allow_email_login($user, $username, $password) {
	if (is_email($username)) :
		$user=get_user_by_email($username);
		if ($user) :
			$username=$user->user_login;
		endif;
	endif;

	return wp_authenticate_username_password(null, $username, $password);
}
add_filter('authenticate', 'em_allow_email_login', 20, 3);


/**
 * em_add_email_to_login function to add email address to the username label
 * @param string $translated_text   translated text
 * @param string $text              original text
 * @param string $domain            text domain
 */
function em_add_email_to_login($translated_text,$text,$domain) {
	if ("Username"==$translated_text) :
		$translated_text.= __(' Or Email', 'ememaillogin');
	endif;

	return $translated_text;
}
add_filter('gettext', 'em_add_email_to_login', 20, 3);