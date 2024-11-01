<?php
/*
Plugin Name: Two Factor Auth for WooCommerce
Description: Adds Two Factor Auth login for WooCommerce. Needs the free plugin Two Factor Auth to function.
Author: Oskar Hane
Author URI: http://oskarhane.com
Version: 1.0.2
License: GPLv2 or later
*/


function tfaAddOTPButtonToWC()
{

	if(!is_user_logged_in())
	{
		wp_enqueue_script( 'tfa-wc-ajax-request', plugin_dir_url( __FILE__ ) . 'tfa_v4.1.2.js', array( 'jquery' ) );
		wp_localize_script( 'tfa-wc-ajax-request', 'tfa_wc_settings', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'click_to_enter_otp' => __("Click to enter One Time Password", 'tfa_woocommerce'),
			'enter_username_first' => __('You have to enter a username first.', 'tfa_woocommerce'),
			'otp' => __("One Time Password", 'tfa_woocommerce')
		));
	}
}

add_action('wp_enqueue_scripts', 'tfaAddOTPButtonToWC');


function checkTFAforWCDependencies()
{
	if(!is_plugin_active('two-factor-auth/two-factor-login.php'))
	{
		deactivate_plugins( basename( __FILE__ ) );
		die('<p>The <strong>Two Factor Auth for WooCommerce</strong> needs the plugin <a href="http://wordpress.org/plugins/two-factor-auth/">Two Factor Auth</a> to be installed first.</p>');
	}
}
register_activation_hook(__FILE__, 'checkTFAforWCDependencies');
?>