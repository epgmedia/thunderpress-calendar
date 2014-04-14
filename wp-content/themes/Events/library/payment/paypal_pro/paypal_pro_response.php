<?php session_start();
global $current_user,$General,$wpdb;

//print_r($_SESSION);
//exit;
 
$firstName = "";
$lastName = "";
$email = "";
$ad1 = "";
$ad2 = "";
$city = "";
$state = "";
$zip = "";
$phone = "";
$country = "";

if(count($current_user) == 0){
	$firstName = $_SESSION['theme_info']['user_fname'];
	$lastName = $_SESSION['theme_info']['user_lname'];
	$email = $_SESSION['theme_info']['user_email'];
	$ad1 = $_SESSION['theme_info']['user_add1'];
	$ad2 = $_SESSION['theme_info']['user_add2'];
	$city = $_SESSION['theme_info']['user_city'];
	$state = $_SESSION['theme_info']['user_state'];
	$zip = $_SESSION['theme_info']['user_postalcode'];
	$phone = $_SESSION['theme_info']['user_phone'];
	$country = $_SESSION['theme_info']['user_country'];	
}else {
	$sql_query = "select * from wp_usermeta where user_id=$current_user->ID";
	$query_result = $wpdb->get_results($sql_query);

	foreach($query_result as $user_data){
		if($user_data->meta_key == "user_fname"){
			$firstName = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_lname"){
			$lastName = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_email"){
			$email = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_add1"){
			$ad1 = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_add2"){
			$ad2 = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_city"){
			$city = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_state"){
			$state = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_postalcode"){
			$zip = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_phone"){
			$phone = $user_data->meta_value;
		}
		if($user_data->meta_key == "user_country"){
			$country = $user_data->meta_value;
		}
	}
}

$currency_opt = get_payment_optins('paypal_pro');
$CardType = $_POST['payment']['cc_type'];
$CardNumber = $_POST['ACCT'];
$expDateMonth = $_POST['EXPDATE'];
$cvv2Number = $_POST['CVV'];
$amount = $payable_amount;
$currencyID = $currency_opt['api_currency'];

require_once('DoDirectPayment.php');
?>