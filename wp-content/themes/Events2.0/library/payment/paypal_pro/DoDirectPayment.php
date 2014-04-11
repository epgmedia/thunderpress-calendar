<?php
// Include required library files.
require_once('includes/config.php');
require_once('includes/paypal.class.php');

// Create PayPal object.
$PayPalConfig = array('Sandbox' => $sandbox, 'APIUsername' => $api_username, 'APIPassword' => $api_password, 'APISignature' => $api_signature);
$PayPal = new PayPal($PayPalConfig);

// Prepare request arrays
$DPFields = array(
					'paymentaction' => 'Sale', 						// How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
					'ipaddress' => $_SERVER['REMOTE_ADDR'], 							// Required.  IP address of the payer's browser.
					'returnfmfdetails' => '' 					// Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
				);
				
$CCDetails = array(
					'creditcardtype' => $CardType, 					// Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
					'acct' => $CardNumber, 								// Required.  Credit card number.  No spaces or punctuation.  
					'expdate' => $expDateMonth, 							// Required.  Credit card expiration date.  Format is MMYYYY
					'cvv2' => $cvv2Number, 								// Requirements determined by your PayPal account settings.  Security digits for credit card.
					'startdate' => '', 							// Month and year that Maestro or Solo card was issued.  MMYYYY
					'issuenumber' => ''							// Issue number of Maestro or Solo card.  Two numeric digits max.
				);
				
$PayerInfo = array(
					'email' => $email, 										// Email address of payer.
					'firstname' => $firstName, 							// Required.  Payer's first name.
					'lastname' => $lastName 							// Required.  Payer's last name.
				);
				
$BillingAddress = array(
						'street' => $ad1, 						// Required.  First street address.
						'street2' => $ad2, 						// Second street address.
						'city' => $city, 							// Required.  Name of City.
						'state' => $state, 							// Required. Name of State or Province.
						'countrycode' => 'US', 					// Required.  Country code.
						'zip' => $zip, 							// Required.  Postal code of payer.
						'phonenum' => $phone 						// Phone Number of payer.  20 char max.
					);
					
$ShippingAddress = array(
						'shiptoname' => $firstName, 					// Required if shipping is included.  Person's name associated with this address.  32 char max.
						'shiptostreet' => $ad1, 					// Required if shipping is included.  First street address.  100 char max.
						'shiptostreet2' => $ad2, 					// Second street address.  100 char max.
						'shiptocity' => $city, 					// Required if shipping is included.  Name of city.  40 char max.
						'shiptostate' => $state, 					// Required if shipping is included.  Name of state or province.  40 char max.
						'shiptozip' => $zip, 						// Required if shipping is included.  Postal code of shipping address.  20 char max.
						'shiptocountry' => 'US', 					// Required if shipping is included.  Country code of shipping address.  2 char max.
						'shiptophonenum' => $phone					// Phone number for shipping address.  20 char max.
						);
					
$PaymentDetails = array(
						'amt' => $amount, 			// Required.  Total amount of order, including shipping, handling, and tax.  
						'currencycode' => 'USD',//$currencyID,	// Required.  Three-letter currency code.  Default is USD.
						'itemamt' => '', 			// Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
						'shippingamt' => '', 					// Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
						'insuranceamt' => '', 					// Total shipping insurance costs for this order.  
						'shipdiscamt' => '', 					// Shipping discount for the order, specified as a negative number.
						'handlingamt' => '', 					// Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
						'taxamt' => '',				// Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax. 
						'desc' => 'Event Registration', 							// Description of the order the customer is purchasing.  127 char max.
						'custom' => '', 						// Free-form field for your own use.  256 char max.
						'invnum' => '', 						// Your own invoice or tracking number
						'notifyurl' => '', 						// URL for receiving Instant Payment Notifications.  This overrides what your profile is set to use.
						'recurring' => 'Y'						// Flag to indicate a recurring transaction.  Value should be Y for recurring, or anything other than Y if it's not recurring.  To pass Y here, you must have an established billing agreement with the buyer.
					);

// For order items you populate a nested array with multiple $Item arrays.  Normally you'll be looping through cart items to populate the $Item 
// array and then push it into the $OrderItems array at the end of each loop for an entire collection of all items in $OrderItems.

$OrderItems = array();		
	
$Item	 = array(
						'l_name' => '', 						// Item Name.  127 char max.
						'l_desc' => '', 						// Item description.  127 char max.
						'l_amt' => '', 							// Cost of individual item.
						'l_number' => '', 						// Item Number.  127 char max.
						'l_qty' => '', 							// Item quantity.  Must be any positive integer.  
						'l_taxamt' => '', 						// Item's sales tax amount.
						'l_ebayitemnumber' => '', 				// eBay auction number of item.
						'l_ebayitemauctiontxnid' => '', 		// eBay transaction ID of purchased item.
						'l_ebayitemorderid' => '' 				// eBay order ID for the item.
				);

array_push($OrderItems, $Item);

$Secure3D = array(
				  'authstatus3d' => '', 
				  'mpivendor3ds' => '', 
				  'cavv' => '', 
				  'eci3ds' => '', 
				  'xid' => ''
				  );
				  
$PayPalRequestData = array(
						   'DPFields' => $DPFields, 
						   'CCDetails' => $CCDetails, 
						   'PayerInfo' => $PayerInfo, 
						   'BillingAddress' => $BillingAddress, 
						   'ShippingAddress' => $ShippingAddress, 
						   'PaymentDetails' => $PaymentDetails, 
						   'OrderItems' => $OrderItems
						   );

// Pass data into class for processing with PayPal and load the response array into $PayPalResult
$PayPalResult = $PayPal->DoDirectPayment($PayPalRequestData);

// Write the contents of the response array to the screen for demo purposes.
//echo $PayPalResult['L_ERRORCODE0']."aezaz"; 
/* echo "<br>";
echo '<pre />';
print_r($PayPalResult); */
//exit; 
$ack = @strtoupper($PayPalResult["ACK"]);
$failureMessage = @$PayPalResult['L_LONGMESSAGE0'];

$status_pro = '';
if( @$PayPalResult["ACK"] == 'Success'){
	$status_pro = '&status_pro=Success';
}	
if($ack=='FAILURE'){
	$_SESSION['paypal_errors'] = $failureMessage;
	wp_redirect(site_url()."/?ptype=preview&paypalerror=yes");
	exit;
}else{
		global $current_user,$ord_db_table_name,$wpdb;
		$user_id = $current_user->ID;
		$sql = "select max(oid) as oid,ostatus from $ord_db_table_name where uid = $user_id and ostatus='pending'";
		$sql_data = $wpdb->get_row($sql);
		//$General->set_ordert_status($sql_data->oid,'approve');		
		$last_order_id = $sql_data->oid;
		$fromEmail = $General->get_site_emailId();
		$fromEmailName = $General->get_site_emailName();
		
		$supplier_subject = get_option('order_success_ipn_supplier_email_subject');
		$supplier_message = get_option('order_success_ipn_supplier_email_content');
		$search_array = array('[#$user_name#]','[#$transaction_details#]','[#$store_name#]');
		$replace_array = array($fromEmailName,$message1,'Pay Pal');
		$supplier_message = str_replace($search_array,$replace_array,$supplier_message);
		
		$subject = __("Order Payment Success");
		$message = "";
		//$userInfo = $General->getLoginUserInfo();
		$toEmailName = $userInfo['display_name'];
		$toEmail = $userInfo['user_email'];
		if($_REQUEST['user_fname']){$toEmailName=$_REQUEST['user_fname'];}
		if($_REQUEST['user_email']){$toEmail=$_REQUEST['user_email'];}
		
		$store_name = get_option('blogname');
		//$order_info = $General->get_order_detailinfo_tableformat($last_order_id,1);
		
		if($General->is_send_order_confirm_email())
		{
		$subject = get_option('order_payment_success_client_email_subject');
		$client_message = get_option('order_payment_success_client_email_content');
		/////////////customer email//////////////
		$search_array = array('[#$to_name#]','[#$order_info#]','[#$store_name#]');
		$replace_array = array($toEmailName,$order_info,$store_name);
		$client_message = str_replace($search_array,$replace_array,$client_message);
		$General->sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$client_message,$extra='');///To clidne email
		}
		
		if($General->is_send_order_confirm_email_admin())
		{
		///////////admin email//////////
		$subject = get_option('order_submited_success_admin_email_subject');
		$admin_message = get_option('order_submited_success_admin_email_content');
		$search_array = array('[#$to_name#]','[#$order_info#]','[#$store_name#]');
		$replace_array = array($fromEmailName,$order_info,$store_name);
		$admin_message = str_replace($search_array,$replace_array,$admin_message);	
		$General->sendEmail($toEmail,$toEmailName,$fromEmail,$fromEmailName,$subject,$admin_message,$extra='');///To admin email
		}
	wp_redirect(site_url('/?ptype=success'.$status_pro));
}
?>