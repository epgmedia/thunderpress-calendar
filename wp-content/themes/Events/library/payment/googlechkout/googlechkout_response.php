<?php 
session_start();
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
$merchantid = $paymentOpts['merchantid'];
$currency_code = get_currency_type();
global $payable_amount,$post_title,$last_postid,$current_user;
$display_name = $current_user->data->display_name;
$user_email = $current_user->data->user_email;
$sql_qry = "select trans_id from $transection_db_table_name where status=0 order by trans_id desc limit 1";
$id = $wpdb->get_var($sql_qry);
$nonce= wp_create_nonce('google-checkout-nonce'); 
$_SESSION['wp_google_nonce'] = $nonce;
?>
<form method="POST" name="frm_payment_method"  action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/<?php echo $merchantid;?>"  accept-charset="utf-8">
<?php/*<form method="POST" name="frm_payment_method" action="https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/<?php echo $merchantid;?>" accept-charset="utf-8">*/?>
<input type="hidden" name="item_name_1" value="<?php echo $post_title;?>"/>
<input type="hidden" name="item_description_1" value="<?php echo $post_title;?>"/>
<input type="hidden" name="item_quantity_1" value="1"/>
<input type="hidden" name="item_price_1" value="<?php echo $payable_amount;?>"/>
<input type="hidden" name="item_currency_1" value="<?php echo $currency_code;?>"/>
<input type="hidden" name="checkout-flow-support.merchant-checkout-flow-support.continue-shopping-url" value="<?php echo site_url()."/?ptype=googlecheckout_success&pid=".$last_postid."&transaction_id=".$id;?>"/>
<input type="hidden" name="_charset_"/>
</form>
  <div class="wrapper" >
		<div class="clearfix container_message">
            	<h1 class="head2"><?php echo GOOGLE_CHKOUT_MSG;?></h1>
            </div>
 
<script>
setTimeout("document.frm_payment_method.submit()",50);
</script>
