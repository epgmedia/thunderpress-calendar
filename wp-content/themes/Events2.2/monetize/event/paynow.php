<?php
session_start();
global $wpdb,$last_postid;
$property_price_info = get_property_price_info($_SESSION['theme_info']['price_select'],$_SESSION['theme_info']['total_price']);
$property_price_info = $property_price_info[0];
$payable_amount = $_SESSION['theme_info']['total_price'];
$cat_display = get_option('ptthemes_category_dislay');
if($_SESSION['theme_info']['proprty_add_coupon'])
{
	$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['theme_info']['proprty_add_coupon']);
}

if($_REQUEST['pid']=='' && $_REQUEST['paymentmethod'] == '' && $payable_amount>0)
{
	wp_redirect(home_url().'/?ptype=preview&msg=nopaymethod');
	exit;
}
global $current_user;
if($current_user->ID=='' && $_SESSION['theme_info'])
{
	include_once(TEMPLATEPATH . '/library/includes/single_page_checkout_insertuser.php');
}

if($_POST)
{
	if($_POST['Submit_and_Pay'])
	{
		$property_info = $_SESSION['theme_info'];
		if($property_info){
			if($property_info['website'] && !strstr($property_info['website'],'http://'))
			{
				$property_info['website'] = 'http://'.$property_info['website'];
			}
			if($property_info['twitter'] && !strstr($property_info['twitter'],'http://'))
			{
				$property_info['twitter'] = 'http://'.$property_info['twitter'];
			}
			if($property_info['facebook'] && !strstr($property_info['facebook'],'http://'))
			{
				$property_info['facebook'] = 'http://'.$property_info['facebook'];
			}
		}
		$stdate = $property_info['stdate'];
		$enddate = $property_info['enddate'];
		if($property_info['sttime'])
		{
			//$stdate = $stdate . ' ' .$property_info['sttime'];	
		}
		if($property_info['enddate'])
		{
			//$enddate = $enddate . ' ' .$property_info['endtime'];	
		}

		$custom = array("address" 		=> $property_info['address'],
						"geo_latitude"	=> $property_info['geo_latitude'],
						"geo_longitude"	=> $property_info['geo_longitude'],
						"st_date"		=> $stdate,
						"st_time"		=> $property_info['sttime'],
						"end_date"		=> $enddate,
						"end_time"		=> $property_info['endtime'],
						"video"			=> $property_info['video'],
						"phone"			=> $property_info['phone'],
						"email"			=> $property_info['email'],
						"website"		=> $property_info['website'],
						"twitter"		=> $property_info['twitter'],
						"facebook"		=> $property_info['facebook'],
						"reg_desc"		=> $property_info['reg_desc'],
						"map_view"		=> $property_info['map_view'],
						"post_city_id"	=> $property_info['post_city_id'],
						"organizer_name"		=> $property_info['organizer_name'],
						"organizer_email"		=> $property_info['organizer_email'],
						"organizer_address"		=> $property_info['organizer_address'],
						"organizer_contact"		=> $property_info['organizer_contact'],
						"organizer_website"		=> $property_info['organizer_website'],
						"organizer_mobile"		=> $property_info['organizer_mobile'],
						"organizer_desc"		=> $property_info['organizer_desc'],
						"featured_type"			=>$property_info['featured_type']
					);
		if($property_info['organizer_logo']!=""){
			$custom['organizer_logo'] = $property_info['organizer_logo'];
		}		
		$post_title =  stripslashes($property_info['event_name']);
		$description = $property_info['proprty_desc'];
		$post_excerpt = $property_info['property_excerpt'];
		$catids_arr = array();
		if(get_option('ptthemes_propertycategory'))
		{
			$catids_arr[] = get_cat_id_from_name(get_option('ptthemes_propertycategory'));
		}
		$my_post = array();
		if($_REQUEST['pid'] && $property_info['renew']=='')
		{
			$my_post['ID'] = $_POST['pid'];
			if($property_info['remove_feature'] !='' && $property_info['remove_feature']=='0' && in_category(get_cat_id_from_name(get_option('ptthemes_featuredcategory')),$_REQUEST['pid']))
			{
				$catids_arr[] = get_cat_id_from_name(get_option('ptthemes_featuredcategory'));	
			}
			$my_post['post_status'] = get_post_status($_POST['pid']);
		}else
		{
			/* fetch property price package information */
			$custom['list_type'] = $property_info['property_list_type'];
			$custom['paid_amount'] = $payable_amount;
			if($_REQUEST['pid'] !='' && $property_price_info['alive_days']=="")
				$custom['alive_days'] = 'Unlimited';
			if($property_info['alive_days'] && $payable_amount >0){
					$custom['alive_days'] = $property_price_info['alive_days'];
				}elseif($property_info['alive_days'] !=''){
					$custom['alive_days'] = $property_price_info['alive_days'];
				}
			$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
			$custom['coupon_code'] = $property_info['proprty_add_coupon'];
			
			if($property_price_info['is_feature'] && get_cat_id_from_name(get_option('ptthemes_featuredcategory')))
			{
				$catids_arr[] = get_cat_id_from_name(get_option('ptthemes_featuredcategory'));
			}
			if($payable_amount>0)
			{
				$post_default_status = 'draft';
			}else
			{
				$post_default_status = get_property_default_status();
			}			
			$my_post['post_status'] = $post_default_status;
		}
		if($current_user_id)
		{
			$my_post['post_author'] = $current_user_id;
		}
		$my_post['post_title'] = $post_title;
		$my_post['post_name'] = $post_name;
		$my_post['post_content'] = $description;
		$my_post['post_category'] = $property_price_info['category'];
		if($my_post['post_excerpt'] != 'Enter excerpt for your listing.'):
			$my_post['post_excerpt'] = $post_excerpt;
		endif;
		$my_post['post_type'] = CUSTOM_POST_TYPE1;
		if($property_info['category'])
		{	
			$post_category = $property_info['category'];
		}
		
		if($_REQUEST['pid'])
		{
			if($property_info['renew'])
			{
				$custom['paid_amount'] = $payable_amount;
				$custom['alive_days'] = $property_price_info['alive_days'];
				$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_insert_post($my_post);	
			}else
			{
				$last_postid = wp_update_post($my_post);
			}
		}else
		{ 
			$last_postid = wp_insert_post( $my_post ); //Insert the post into the database
		}

		$custom["paid_amount"] = $payable_amount;
		//$custom["coupon_code"] = $coupon_code;
		global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".CUSTOM_POST_TYPE1."' or post_type='event' or post_type='organizer')";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				$i = 0;
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='select' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox'){
					if($_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name] != ""){
						if($post_meta_info_obj->htmlvar_name != "event_name" && $post_meta_info_obj->htmlvar_name != "proprty_type"  && $post_meta_info_obj->htmlvar_name != "price"  && $post_meta_info_obj->htmlvar_name != "address" && $post_meta_info_obj->htmlvar_name != "property_city" && $post_meta_info_obj->htmlvar_name != "property_state" && $post_meta_info_obj->htmlvar_name != "property_country" && $post_meta_info_obj->htmlvar_name != "property_zip" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "proprty_desc" && $post_meta_info_obj->htmlvar_name != "proprty_excerpt" && $post_meta_info_obj->htmlvar_name != "additional_features")
						{
							$custom[$post_meta_info_obj->htmlvar_name] = $property_info[$post_meta_info_obj->htmlvar_name];
						}
					 
					 
					 }
				}
				}
		
		/** ---- Save the variables of recurring event BOF -----**/
			$event_type = $_SESSION['theme_info']['event_type']; 
			$custom['recurrence_occurs'] = $event_type;
			if(trim(strtolower($event_type)) == trim(strtolower('Recurring event'))){
				$custom['recurrence_occurs'] = $_SESSION['theme_info']['recurrence_occurs'];
				$custom['recurrence_per'] = $_SESSION['theme_info']['recurrence_per'];
				$custom['recurrence_onday'] = $_SESSION['theme_info']['recurrence_onday'];
				$custom['recurrence_bydays'] = implode(',',$_SESSION['theme_info']['recurrence_bydays']);
				$custom['recurrence_onweekno'] = $_SESSION['theme_info']['recurrence_onweekno'];
				$custom['recurrence_days'] = $_SESSION['theme_info']['recurrence_days'];		
				$custom['monthly_recurrence_byweekno'] = $_SESSION['theme_info']['monthly_recurrence_byweekno'];
				$custom['recurrence_byday'] = $_SESSION['theme_info']['recurrence_byday'];
				

			}
		/** ---- Save the variables of recurring event EOF -----**/
		if(!$custom['featured_type'])
		  {
			  $custom['featured_type'] = 'none';
			  $custom['featured_c'] = 'n';
			  $custom['featured_h'] = 'n';
		  }
		if($custom['featured_type'] == 'c')
		 {
			 $custom['featured_h'] = 'n';
			 $custom['featured_c'] = 'c';
		 }
		if($custom['featured_type'] == 'h')
		 {
			 $custom['featured_c'] = 'n';
			 $custom['featured_h'] = 'h';
		 }
 		if($custom['featured_type'] == 'both')
		 {
			 $custom['featured_c'] = 'c';
			 $custom['featured_h'] = 'h';
		 }
 		if($custom['featured_type'] == 'none')
		 {
			 $custom['featured_c'] = 'n';
			 $custom['featured_h'] = 'n';
		 }
		save_recurring_event($last_postid);
		foreach($custom as $key=>$val)
		{				
			update_post_meta($last_postid, $key, $val);
		}
		
		/*Update recurring search date after insert event custom field */
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring event'))){
		/* Store Recurring Event search date*/
			$start_date = templ_recurrence_dates($last_postid);
			update_post_meta($last_postid,'recurring_search_date',$start_date);
		}		
		/* Transaction Reoprt */
		global $wpdb;
		
		$paymentmethod = $_REQUEST['paymentmethod'];
		if($paymentmethod !="" && $last_postid !=""){
		$post_author  = $wpdb->get_row("select * from $wpdb->posts where ID = '".$last_postid."'") ;
		$post_author  = $post_author->post_author ;
		$uinfo = get_userdata($post_author);
		$user_fname = $uinfo->display_name;
		$user_email = $uinfo->user_email;
		$user_billing_name = $uinfo->display_name;
		$billing_Address = '';
		global $transection_db_table_name;
		$transaction_insert = 'INSERT INTO '.$transection_db_table_name.' set 
		post_id="'.$last_postid.'",
		user_id = "'.$post_author.'",
		post_title ="'.$post_title.'",
		payment_method="'.$paymentmethod.'",
		payable_amt='.$payable_amount.',
		payment_date="'.date("Y-m-d H:i:s").'",
		paypal_transection_id="",
		status="0",
		user_name="'.$user_fname.'",
		pay_email="'.$user_email.'",
		billing_name="'.$user_billing_name.'",
		billing_add="'.$billing_Address.'"';
		}
		$wpdb->query($transaction_insert);
		/* End Transaction Report */
		
		/* Insert the post categories BOF */
		$cat_display = get_option('ptthemes_category_display');
		
		if($post_category != '' )
		{
			if($cat_display == 'checkbox')
			 {
				foreach($post_category as $_post_category)
				 {
					$cat_exp = explode(",",$_post_category);
					wp_set_post_terms($last_postid,$cat_exp[0],'eventcategory',true);
				 }
			 }else{
					$cat_exp = explode(",",$post_category);
					wp_set_post_terms($last_postid,$cat_exp[0],'eventcategory',true);
			 }
		}
		/* Insert the post categories EOF */
		
		/* Insert the post images BOF */
		if(isset($_SESSION["file_info"][0]) && $_SESSION["file_info"][0] != '')
		{
			$menu_order = 0;
			foreach($_SESSION["file_info"] as $image_id=>$val)
			{
				//$src = get_image_tmp_phy_path().$image_id.'.jpg';
				$src = TEMPLATEPATH."/images/tmp/".$val;
				if(file_exists($src))
				{
					$menu_order++;
					$dest_path = get_image_phy_destination_path().$val;
					$dirinfo = wp_upload_dir();							
					$dest_path =$dirinfo['path']."/".$val; 
					$original_size = get_image_size($src);
					$thumb_info = image_resize_custom($src,$dest_path,get_option('thumbnail_size_w'),get_option('thumbnail_size_h'));
					$medium_info = image_resize_custom($src,$dest_path,get_option('medium_size_w'),get_option('medium_size_h'));
					
					$post_img = move_original_image_file($src,$dest_path);
					
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					
					$last_postimage_id = wp_insert_post( $post_img ); // Insert the post into the database
		
					$thumb_info_arr = array();
					if($thumb_info)
					{
						$sizes_info_array = array();
						if($thumb_info)
						{
						$sizes_info_array['thumbnail'] =  array(
																"file" =>	$thumb_info['file'],
																"height" =>	$thumb_info['height'],
																"width" =>	$thumb_info['width'],
																);
						}
						if($medium_info)
						{
						$sizes_info_array['medium'] =  array(
																"file" =>	$medium_info['file'],
																"height" =>	$medium_info['height'],
																"width" =>	$medium_info['width'],
																);
						}
						$hwstring_small = "height='".$thumb_info['height']."' width='".$thumb_info['width']."'";
					}else
					{
						$hwstring_small = "height='".$original_size['height']."' width='".$original_size['width']."'";
					}
					//update_post_meta($last_postimage_id, '_wp_attached_file', get_attached_file_meta_path($post_img['guid']));
					update_post_meta($last_postimage_id, '_wp_attached_file', get_image_rel_destination_path().$val);
					$post_attach_arr = array(
										"width"	=>	$original_size['width'],
										"height" =>	$original_size['height'],
										"hwstring_small"=> $hwstring_small,
										"file"	=> get_attached_file_meta_path($post_img['guid']),
										"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}				
			}
		}
		/* Insert the post images EOF */
		if(!$_REQUEST['pid']){
		update_post_meta($last_postid, 'remote_ip',getenv('REMOTE_ADDR'));
		update_post_meta($last_postid,'ip_status',$_SESSION['theme_info']['ip_status']);
		}
	  /* Code for update menu for images */
	  
	  if($_REQUEST['pid'])
		  {
			$j = 1;
			foreach($_SESSION["file_info"] as $arrVal)
			 {
				$expName = array_slice(explode(".",$arrVal),0,1);
				$wpdb->query('update '.$wpdb->posts.' set  menu_order = "'.$j.'" where post_name = "'.$expName[0].'"  and post_parent = "'.$_REQUEST['pid'].'"');
				$j++;	
			 }
		  }

	/* End Code for update menu for images */
	
		///////ADMIN EMAIL START//////
			$fromEmail = get_site_emailId();
			$fromEmailName = get_site_emailName();
			$store_name = get_option('blogname');
			$email_content = get_option('post_submited_success_email_content');
			$email_subject = get_option('post_submited_success_email_subject');
			
			$email_content_user = get_option('post_submited_success_email_user_content');
			$email_subject_user = get_option('post_submited_success_email_user_subject');
			
			if(!$email_subject)
			{
				$email_subject = __('New place listing of ID:#'.$last_postid);	
			}
			if(!$email_content)
			{
				$email_content = __('<p>Dear [#to_name#],</p>
				<p>'.__('A New listing has been submitted on your site. Here is the information about the listing','templatic').':</p>
				[#information_details#]
				<br>
				<p>[#site_name#]</p>');
			}
			
			if(!$email_subject_user)
			{
				$email_subject_user = __(sprintf('New event listing of ID:#%s',$last_postid));	
			}
			if(!$email_content_user)
			{
				$email_content_user = __('<p>Dear [#to_name#],</p><p>'.EMAIL_CONTENT_USER_TEXT.': </p>[#information_details#]<br><p>[#site_name#]</p>');
			}
			
			$information_details = "<p>".__('ID','templatic')." : ".$last_postid."</p>";
			$information_details .= '<p>'.__('View more detail from','templatic').' <a href="'.get_permalink($last_postid).'">'.$my_post['post_title'].'</a></p>';
			
			$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
			$replace_array_admin = array($fromEmail,$information_details,$store_name);
			$replace_array_client =  array($user_email,$information_details,$store_name);
			$email_content_admin = str_replace($search_array,$replace_array_admin,$email_content);
			$email_content_client = str_replace($search_array,$replace_array_client,$email_content_user);

				templ_sendEmail($user_email,$user_fname,$fromEmail,$fromEmailName,$email_subject,$email_content_admin,$extra='');///To admin email
				templ_sendEmail($fromEmail,$fromEmailName,$user_email,$user_fname,$email_subject_user,$email_content_client,$extra='');//to client email

		/* check selected payment method and redirect accrodingly */
		if($_REQUEST['paymentmethod']!='authorizenet' && $_REQUEST['paymentmethod']!='paypal_pro')
		{
			
			$_SESSION['theme_info'] = array();
			$_SESSION["file_info"] = array();	
		}
		
		if($_REQUEST['pid']>0 && $property_info['renew']=='')
		{
			wp_redirect(get_author_link($echo = false, $current_user->ID));
			exit;
		}else
		{
			if($payable_amount == '' || $payable_amount <= 0)
			{
				$suburl .= "&pid=$last_postid";
				wp_redirect(home_url()."/?ptype=success$suburl");
				exit;
			}else
			{
				$paymentmethod = $_REQUEST['paymentmethod'];
				$paymentSuccessFlag = 0;
				if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
				{
					if($property_info['renew'])
					{
						$suburl = "&renew=1";
					}
					$suburl .= "&pid=$last_postid";
					wp_redirect(home_url().'/?ptype=success&paydeltype='.$paymentmethod.$suburl);
				}
				else
				{
					if(file_exists( TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
					{
						include_once(TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
					}
				}
				exit;	
			}
		}
	}
}
?>