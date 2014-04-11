<?php
if(@$_REQUEST['ptype'] == 'favorite'){
		if(@$_REQUEST['action']=='add')	{
			if(isset($_REQUEST['st_date']) && $_REQUEST['st_date'] != '' && $_REQUEST['st_date'] != 'undefined' )
			{
				add_to_attend_event($_REQUEST['pid'],$_REQUEST['st_date'],$_REQUEST['end_date']);
			}
			else
				add_to_attend_event($_REQUEST['pid']);
		}else{
			if(isset($_REQUEST['st_date']) && $_REQUEST['st_date'] != '' && $_REQUEST['st_date'] != 'undefined')
				remove_from_attend_event($_REQUEST['pid'],$_REQUEST['st_date'],$_REQUEST['end_date']);
			else
				remove_from_attend_event($_REQUEST['pid']);
		}
	}
if(@$_REQUEST['ptype'] == 'csvdl')
{
	include (TEMPLATEPATH . "/library/includes/csvdl.php");
}
elseif(@$_REQUEST['page'] == 'register' || @$_REQUEST['page'] == 'login')
{
	include (TEMPLATEPATH . "/monetize/registration/registration.php");
	exit;
}
elseif(@$_REQUEST['page'] == 'profile')
{
	include (TEMPLATEPATH . "/library/includes/edit_profile.php");
}
elseif(@$_REQUEST['ptype']=='post_listing')
{
	if(get_option('is_user_addevent')=='0'){wp_redirect(home_url().'/?ptype=event');exit;}
	include_once(TEMPLATEPATH.'/submit_event.php');exit;
}elseif(@$_REQUEST['ptype'] == 'preview')
{
	include (TEMPLATEPATH . "/monetize/event/event_preview.php");
}
elseif(@$_REQUEST['ptype']=='post_event')
{
	if(@$_REQUEST['ptype']=='post_event' && get_option('is_user_eventlist') == 'No'){wp_redirect(home_url());exit;}
	include_once(TEMPLATEPATH.'/monetize/event/submit_event.php');exit;
}
elseif(@$_REQUEST['ptype'] == 'paynow_event')
{
	include (TEMPLATEPATH . "/monetize/event/paynow.php");
}
elseif(@$_REQUEST['ptype'] == 'cancel_return')
{
	include_once(TEMPLATEPATH . '/monetize/general/cancel.php');
	set_property_status(@$_REQUEST['pid'],'draft');
	exit;
}
elseif(@$_GET['ptype'] == 'return' || @$_GET['ptype'] == 'payment_success')  // PAYMENT GATEWAY RETURN
{
	//set_property_status($_REQUEST['pid'],'publish');
	include_once(TEMPLATEPATH . '/monetize/general/return.php');
	exit;
}
elseif(@$_GET['ptype'] == 'success')  // PAYMENT GATEWAY RETURN
{
	include_once(TEMPLATEPATH . '/monetize/general/success.php');
	exit;
}
elseif(@$_GET['ptype'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
{
	if(@$_GET['pmethod'] == 'paypal')
	{
		include_once(TEMPLATEPATH . '/monetize/general/ipn_process.php');
	}elseif(@$_GET['pmethod'] == '2co')
	{
		include_once(TEMPLATEPATH . '/monetize/general/ipn_process_2co.php');
	}
	exit;
}
elseif(@$_REQUEST['ptype'] == 'sort_image')
{
	global $wpdb;
	//echo $_REQUEST['pid'];
	$arr_pid = explode(',',@$_REQUEST['pid']);
	for($j=0;$j<count($arr_pid);$j++)
	{
		$media_id = $arr_pid[$j];
		if(strstr($media_id,'div_'))
		{
			$media_id = str_replace('div_','',$arr_pid[$j]);
		}
		$wpdb->query('update '.$wpdb->posts.' set  menu_order = "'.$j.'" where ID = "'.$media_id.'" ');
	}
	echo 'Image order saved successfully';
}
elseif(@$_REQUEST['ptype'] == 'delete')
{
	global $current_user;
	if(@$_REQUEST['pid'])
	{
		wp_delete_post(@$_REQUEST['pid']);
		wp_redirect(get_author_posts_url($current_user->ID));
	}	
}
elseif(@$_REQUEST['ptype'] == 'att_delete')
{	
    if(@$_REQUEST['remove'] == 'temp')
	{

		if($_SESSION["file_info"])
		{
			$tmp_file_info = array();
			foreach($_SESSION["file_info"] as $image_id=>$val)
			{
				    if($image_id == @$_REQUEST['pid'])
					{
						@unlink(ABSPATH."/".$upload_folder_path."tmp/".@$_REQUEST['pid'].".jpg");
					}else{	
						$tmp_file_info[$image_id] = $val;
					}
					
			}
			$_SESSION["file_info"] = $tmp_file_info;
		}
		
		
	}else{		
			wp_delete_attachment(@$_REQUEST['pid']);	
	}	
}elseif(isset($_REQUEST['ptype']) && $_REQUEST['ptype'] == "googlecheckout_success"){
	include(TEMPLATEPATH.'/library/payment/googlechkout/googlecheckout_success.php');
	exit;
}else
{

get_header();?>
<div id="wrapper" class="clearfix">
<div id="content" class="clearfix">
<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('front_content'); } ?>
		<?php //dynamic_sidebar(3);  ?>  

<div class="clearfix">
 <div class="twocolumns fl">
<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('front_content_left'); } ?>
<?php //dynamic_sidebar(1);  ?>  
 	
        
 </div>
 
  <div class="twocolumns fr">
 <?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('front_content_right'); } ?>
 	<?php //dynamic_sidebar(2);  ?>  
 	
  </div>
 
 </div>
 
 
 

</div> <!-- content #end -->
<div id="sidebar">
<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('front_page_sidebar'); } ?>
<?php //dynamic_sidebar(4);  ?>  
</div> <!-- sidebar #end -->  
<div style="clear:both;"></div>
</div> <!-- wrapper #end -->
<div id="bottom"></div>

<?php  get_footer(); ?>
<?php }?>