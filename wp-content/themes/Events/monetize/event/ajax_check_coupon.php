<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");

global $wpdb;
$add_coupon = $_REQUEST['add_coupon'];
$total_price = $_REQUEST['total_price'];

$discount_amt = get_discount_amount($add_coupon,$total_price);
if($discount_amt >= $total_price)
{
	$result = "Apologies, You can not use this coupon as it exceeds the amount you are going to pay.";
}
else
{
	$discount = display_amount_with_currency($discount_amt);
	$result = "Congrats!!! You are going to save $discount";
}
echo $result;
exit;
?>