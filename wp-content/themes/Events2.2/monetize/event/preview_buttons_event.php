<?php session_start();
$property_price_info = get_property_price_info($_REQUEST['price_select']);
$payable_amount = $_POST['total_price'];
global $payable_amount;
$alive_days = $property_price_info[0]['alive_days'];
$type_title = $property_price_info[0]['title'];
if($is_delet_property)
{		
}else
{
if($_REQUEST['proprty_add_coupon']!='')
{
	if(is_valid_coupon($_SESSION['theme_info']['proprty_add_coupon']))
	{
		$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['theme_info']['proprty_add_coupon']);
	}else
	{
		echo '<p class="error_msg">'. WRONG_COUPON_MSG.'</p> <br /> ';
	}
} } ?>
	
	
<?php
if($_REQUEST['alook'])
{
}else
{
?>
<div class="preview_section" >
<?php
if($_REQUEST['pid'] || $_POST['renew'])
{
	$form_action_url = get_option( 'home' ).'/?ptype=paynow_event';
}else
{
	$form_action_url = get_ssl_normal_url(get_option( 'home' ).'/?ptype=paynow_event');
}
?>
<form method="post" action="<?php echo $form_action_url; ?>" name="paynow_frm" id="paynow_frm" >
<input type="hidden" name="price_select" value="<?php echo $_REQUEST['price_select'];?>" />
	<?php 
	$event_price_info = get_event_price_info($_REQUEST['price_select']);
	$alive_days = $event_price_info[0]['alive_days'];
	
	if($is_delet_property)
	{		
	}else
	{

	if(($_REQUEST['pid']=='' && $payable_amount>0) || ($_POST['renew'] && $payable_amount>0 && $_REQUEST['pid']!=''))
	{
		echo '<h5 class="free_property">';
		printf(GOING_TO_PAY_MSG, get_currency_sym().$payable_amount,$alive_days,$type_title);
		echo '</h5>';
	}else
	{
		echo '<h5 class="free_property">';
		if($_REQUEST['pid']==''){
			printf(GOING_TO_PAY_MSG, get_currency_sym().$payable_amount,$alive_days,$type_title);
		}else
		{
			printf(GOING_TO_UPDATE_MSG, get_currency_sym().$payable_amount,$alive_days,$type_title);
		}
		echo '</h5>';
	}
	?> 
	<?php
	}
	?>
	
	<?php
	if(($_REQUEST['pid']=='' && $payable_amount>0) || ($_POST['renew'] && $payable_amount>0 && $_REQUEST['pid']!=''))
	{
		$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
		$paymentinfo = $wpdb->get_results($paymentsql);
		if($paymentinfo)
		{
		?>
  <h5 class="payment_head"> <?php echo SELECT_PAY_MEHTOD_TEXT; ?></h5>
  <?php 
		if($_REQUEST['paypalerror'] == 'yes' && isset($_SESSION['paypal_errors'])){
			echo "<b>".$_SESSION['paypal_errors']."</b>";
		}
  ?>
  <ul class="payment_method">
	<?php
			$paymentOptionArray = array();
			$paymethodKeyarray = array();
			foreach($paymentinfo as $paymentinfoObj)
			{
				$paymentInfo = unserialize($paymentinfoObj->option_value);
				if($paymentInfo['isactive'])
				{
					$paymethodKeyarray[] = $paymentInfo['key'];
					$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
				}
			}
			ksort($paymentOptionArray);
			if($paymentOptionArray)
			{
				foreach($paymentOptionArray as $key=>$paymentInfoval)
				{
					for($i=0;$i<count($paymentInfoval);$i++)
					{
						$paymentInfo = $paymentInfoval[$i];
						$jsfunction = 'onclick="showoptions(this.value);"';
						$chked = '';
						if($key==1)
						{
							$chked = 'checked="checked"';
						}
					?>
		<li id="<?php echo $paymentInfo['key'];?>">
		  <input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> />  <?php echo $paymentInfo['name']?>
		 
		  <?php
						if(file_exists(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php'))
						{
						?>
		  <?php
							include_once(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php');
							?>
		  <?php
						} 
					 ?> </li>
		  <?php
					}
				}
			}else
			{
			?>
			<li><?php echo NO_PAYMENT_METHOD_MSG;?></li>
			<?php
			}
			
		?>
 	  
  </ul>
  <?php
		}
	}
	?>
	
 <script type="text/javascript">
function showoptions(paymethod)
{

<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';

if(document.getElementById(showoptvar))
{
	document.getElementById(showoptvar).style.display = 'none';
	if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
	{
		document.getElementById(showoptvar).style.display = '';
	}
}

<?php
}	
?>
}
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
{
showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
}
<?php
}	
?>
</script>   
<?php
if($is_delet_property)
{
	
	$post_sql = mysql_query("select post_author,ID from $wpdb->posts where post_author = '".$current_user->ID."' and ID = '".$_REQUEST['pid']."'");
	if((mysql_num_rows($post_sql) > 0) || ($current_user->ID == 1)){
		
?>
	<h5 class="payment_head"><?php echo PRO_DELETE_PRE_MSG;?></h5>
	<input type="button" name="Delete" value="<?php echo PRO_DELETE_BUTTON;?>" class="fr b_delete" onclick="window.location.href='<?php echo get_option('home');?>/?ptype=delete&pid=<?php echo $_REQUEST['pid']?>'" />
    <?php 
	global $current_user;
	if($current_user->ID)
	{
		$cancle_url = get_author_posts_url($current_user->ID);
	}else
	{
		$cancle_url = home_url();
	}
	?>
	<input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="fl b_cancel" onclick="window.location.href='<?php echo $cancle_url;?>'" />
    <?php }
	else
	{
		echo DELETE_ERROR_MSG;
	}?>

<?php
}else
{
?>
<input type="hidden" name="paynow" value="1">
<input type="hidden" name="pid" value="<?php echo $_POST['pid'];?>">
<?php
if($_REQUEST['pid'])
{
?> 
	<input type="submit" name="Submit and Pay" value="<?php echo PRO_UPDATE_BUTTON;?>" class="b_cancel fr" />
<?php
}else
{
	if($payable_amount>0)
	{
		?>
        <input type="submit" name="Submit and Pay" value="<?php echo PRO_SUBMIT_PAY_BUTTON;?>" class="fr b_cancel" />
        <?php		
	}else
	{
		?>
        <input type="submit" name="Submit and Pay" value="<?php echo PRO_SUBMIT_BUTTON;?>" class="fr b_cancel" />
        <?php		
	}

}
?>

<a href="<?php echo get_option('home');?>/?ptype=post_event&backandedit=1<?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];}?><?php if($_REQUEST['renew']){echo '&renew=1';}?>" class="b_goback fl" ><?php echo PRO_BACK_AND_EDIT_TEXT;?></a>

<?php 
global $current_user;
if($current_user->data->ID)
{
	$cancle_url = get_author_posts_url($current_user->ID);
}else
{
	$cancle_url = home_url();
}
?>
<input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="b_cancel fl" onclick="window.location.href='<?php echo $cancle_url;?>'" />
 <?php }?>  
 </form></div>
<?php }?>

