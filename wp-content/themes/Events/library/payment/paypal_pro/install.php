<?php
$paymentmethodname = 'paypal_pro'; 
if($_REQUEST['install']==$paymentmethodname)
{
	$paymethodinfo = array();
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	API_USERNAME_TEXT,
					"fieldname"		=>	"api_username",
					"value"			=>	"",
					"description"	=>	API_USERNAME_MSG,
					);
	$payOpts[] = array(
					"title"			=>	API_PASSWORD_TEXT,
					"fieldname"		=>	"api_password",
					"value"			=>	"",
					"description"	=>	"",
					);
	$payOpts[] = array(
					"title"			=>	API_SIGNATURE_TEXT,
					"fieldname"		=>	"api_signature",
					"value"			=>	"",
					"description"	=>	API_SIGNATURE_MSG,
					);
	$payOpts[] = array(
					"title"			=>	API_CURRENCY_TEXT,
					"fieldname"		=>	"api_currency",
					"value"			=>	"",
					"description"	=>	API_CURRENCY_MSG,
					);

	$paymethodinfo = array(
						"name" 		=> 'Paypal Pro',
						"key" 		=> $paymentmethodname,
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'8',
						"payOpts"	=>	$payOpts,
						);
	
	update_option("payment_method_$paymentmethodname", $paymethodinfo );
	$install_message = __("Payment Method integrated successfully",'templatic');
	$option_id = $wpdb->get_var("select option_id from $wpdb->options where option_name like \"payment_method_$paymentmethodname\"");
	wp_redirect("admin.php?page=paymentoptions&payact=setting&id=$option_id");
}elseif($_REQUEST['uninstall']==$paymentmethodname)
{ 
	delete_option("payment_method_$paymentmethodname");
	$install_message = __("Payment Method deleted successfully.",'templatic');
}
?>