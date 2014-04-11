<?php session_start();
	if(isset($_REQUEST['paypalerror']) == 'yes'){
	echo "<p class='error_msg'>".$_SESSION['paypal_errors']."</p>";
	}
 ?>

<?php
global $General, $Cart, $wpdb, $current_user, $country_db_table_name, $state_db_table_name;
?>
<table id="paypal_prooptions" class="table" style=" <?php if($_REQUEST['error'] == '') { ?>display:none;<?php } ?> " >
    <input type="hidden" name="VENDOR" value="<?php echo $paymentOpts['vendorid']; ?>"/>
	<input type="hidden" name="USER" value="<?php echo  $paymentOpts['USER']; ?>" class="formFieldMedium" style="clear:both;"/>
	<input type="hidden" name="PARTNER" value="<?php echo  $paymentOpts['PARTNER']; ?>" PLACEHOLDER="paypaluk" class="formFieldMedium"/>
    <input type="hidden" name="PWD" value="<?php echo $PWD; ?>" class="formFieldMedium"/>
	<input type="hidden" name="AMT" value="<?php echo $payable_amt; ?>" class="formFieldMedium"/>
	<input type="hidden" name="currency" id="currency" value="<?php echo $currency_code; ?>"/>
	<input type="hidden" name="ORIGID" id="ORIGID" class="formFieldMedium" value="<?php echo  $paymentOpts['ORIGID']; ?>"/>
	<input type="hidden" name="TRXTYPE" id="TRXTYPE" class="formFieldMedium" value="<?php echo  $paymentOpts['TRXTYPE']; ?>"/>
	<input type="hidden" name="TENDER" id="TENDER" class="formFieldMedium" value="<?php echo  $paymentOpts['TENDER']; ?>"/>
	<tr>
		<td class="row3"><?php echo CART_TYPE_TEXT; ?> :&nbsp; </td>
		<td>
           <select class="required-entry validate-cc-type-select" name="payment[cc_type]" id="payment[cc_type]" autocomplete="off">
                <option value=""  selected="selected" ><?php echo PLEASE_SELECT_TEXT;?></option>
                <option value="American Express"><?php echo CART_TYPE1_TEXT; ?></option>
                <option value="Visa"><?php echo CART_TYPE2_TEXT; ?></option>
                <option value="MasterCard"><?php echo CART_TYPE3_TEXT; ?></option>
                <option value="Discover"><?php echo CART_TYPE4_TEXT; ?></option>
          </select>
		</td>
    </tr>
    <tr> 
      <td class="row3"> <?php echo CC_TEXT; ?> :&nbsp; </td>
      <td class="row3"> <input type="text" name="ACCT" id="ACCT" value="<?php echo $_SESSION['paypal_data']['ACCT']; ?>" class="formFieldMedium" autocomplete="off"/></td>
    </tr>
    <tr> 
      <td class="row3"><?php echo EXPIREATION_DATE_TEXT; ?>:</td>
      <td class="row3"> <input type="text" name="EXPDATE" id="EXPDATE" value="<?php echo $_SESSION['paypal_data']['EXPDATE']; ?>" class="formFieldMedium"/></td>
    </tr>
	<tr>
	   <td class="row3"><?php echo CV2_LABEL; ?></td>
      <td class="row3"><input type="text" size="4" maxlength="5" id="CVV" name="CVV" class="formFieldMedium" value="<?php echo $_SESSION['paypal_data']['CVV']; ?>"/></td>
    </tr>
    
  </table>