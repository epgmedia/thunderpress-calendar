<?php
date_default_timezone_set('America/Chicago');	// Update to your own timezone.
$sandbox = false;	// TRUE/FALSE for test mode or not.
$domain = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';

if($sandbox == true)
{
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	
}

$paymentOpts = get_payment_optins('paypal_pro');

define('API_USERNAME', $paymentOpts['api_username']);
define('API_PASSWORD', $paymentOpts['api_password']);
define('API_SIGNATURE', $paymentOpts['api_signature']);

$api_version = '85.0';
$application_id = $sandbox ? '' : 'LIVE_APP_ID';	// Only required for Adaptive Payments.  You get your Live ID when your application is approved by PayPal.

$developer_account_email = '';			// This is the email you use to sign in to http://developer.paypal.com.  Only required for Adaptive Payments.
$api_username = $sandbox ? '' : API_USERNAME;
$api_password = $sandbox ? '' : API_PASSWORD;
$api_signature = $sandbox ? '' : API_SIGNATURE;
$api_subject = '';	// If making calls on behalf a third party, their PayPal email address or account ID goes here.

$device_id = '';
$device_ip_address = $_SERVER['REMOTE_ADDR'];
?>