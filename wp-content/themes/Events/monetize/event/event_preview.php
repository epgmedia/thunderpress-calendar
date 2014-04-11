<?php session_start();
global $upload_folder_path;
$cat_display=get_option('ptthemes_category_display');//whether category display is checbox or select box
$proprty_desc = "";
$st_date = '';
$st_time = '';
$end_date = '';
$end_time = '';
$video = '';
$address = '';
if($_POST)
{
	if(!is_int($_POST['total_price']) && $_POST['total_price']<0)
	{ ?>
	<script>
	alert('<?php _e('Price is Invalid,please select valid price','templatic');?>');
	window.location= '<?php echo home_url(); ?>'+'/?ptype=post_event&backandedit=1';</script>
	<?php
	}
	$proprty_name = stripslashes($_POST['event_name']);
	$address = $_POST['address'];
	$geo_latitude = $_POST['geo_latitude'];
	$geo_longitude = $_POST['geo_longitude'];
	$map_view = $_POST['map_view'];
	$st_date = $_POST['st_date'];
	$st_time = $_POST['st_time'];
	$end_date = $_POST['end_date'];
	$end_time = $_POST['end_time'];
	$video = $_POST['video'];
	$phone = stripslashes($_POST['phone']);
	$email = $_POST['email'];
	$website = $_POST['website'];
	$twitter = $_POST['twitter'];
	$facebook = $_POST['facebook'];	
	$proprty_desc = stripslashes($_POST['proprty_desc']);
	$reg_desc = stripslashes($_POST['reg_desc']);
	$organizer_name = stripslashes($_POST['organizer_name']);
	$organizer_email = stripslashes($_POST['organizer_email']);
	$organizer_address = stripslashes($_POST['organizer_address']);
	$organizer_contact = stripslashes($_POST['organizer_contact']);
	$organizer_website = stripslashes($_POST['organizer_website']);
	$organizer_mobile = stripslashes($_POST['organizer_mobile']);
	$organizer_desc = stripslashes($_POST['organizer_desc']);
	$proprty_pricerange = $_POST['proprty_pricerange'];
	$proprty_type = $_POST['property_type'];
	$proprty_excerpt = $_POST['property_excerpt'];
	$proprty_add_feature = $_POST['additional_features'];
	$proprty_add_coupon = $_POST['proprty_add_coupon'];
	
	$event_type = $_POST['event_type'];
	$recurrence_occurs = $_POST['recurrence_occurs'];
	$recurrence_per = $_POST['recurrence_per'];
	$recurrence_onday = $_POST['recurrence_onday'];
	$recurrence_onweekno = $_POST['recurrence_onweekno'];
	$recurrence_days = $_POST['recurrence_days'];
	$recurrence_bydays = $_POST['recurrence_bydays'];
	

	if($cat_display == 'checkbox' && is_array($_POST['category'])){
		$cat_array1 = implode("-",$_POST['category']) ;
		$cat_array2 = explode("-",$cat_array1) ;
		$tc= count($cat_array2 );
		$allcat ="";
		for($i=0; $i<=$tc; $i++ )
		{
			//echo $cat_array2[$i];
			$allc = explode(',',$cat_array2[$i]);
			if($allc[0] != ""){
			$allc1 .= $allc[0].","; }

		}
		$cat = explode(',',$allc1);
	}else{
	$cat = $_POST['category'];
	}
	$sep = "";
	$a = "";
	$cat1 = "";
		

	$_SESSION['theme_info'] = $_POST;
	
	if($_POST['user_email'] && $_FILES['user_photo']['name'])
	{
		$src = $_FILES['user_photo']['tmp_name'];
		$dest_path = get_image_phy_destination_path_user().date('Ymdhis')."_".$_FILES['user_photo']['name'];
		$user_photo = image_resize_custom($src,$dest_path,150,150);        
        $photo_path = get_image_rel_destination_path_user().$user_photo['file'];
		$_SESSION['theme_info']['user_photo'] = $photo_path;
	}
	if($current_user->ID ==''){
			if ($_POST['user_email'] == '' )	{
			$_SESSION['userinset_error'] = array();
			$_SESSION['userinset_error'] = __('Email for Contact Details is Empty. Please enter Email, your all informations will sent to your Email.','templatic');
			wp_redirect(home_url().'/?ptype=post_event&backandedit=1&usererror=1');
			exit;
				}
		
		require( 'wp-load.php' );
		require(ABSPATH.'wp-includes/registration.php');
		
		global $wpdb;
		$errors1 = new WP_Error();
		
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_login = $user_fname;	
		$user_login = sanitize_user( $user_login );
		$user_email = apply_filters( 'user_registration_email', $user_email );
		
		// Check the username
		if ( $user_login == '' )
			$errors1->add('empty_username', __('ERROR: Please enter a username.','templatic'));
		elseif ( !validate_username( $user_login ) ) {
			$errors1->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.','templatic'));
			$user_login = '';
		} elseif ( username_exists( $user_login ) )
			$errors1->add('username_exists', __('<strong>ERROR</strong>: '.$user_login.' This username is already registered, please choose another one.','templatic'));

		// Check the e-mail address
		if ($user_email == '') {
			$errors1->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.','templatic'));
		} elseif ( !is_email( $user_email ) ) {
			$errors1->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.','templatic'));
			$user_email = '';
		} elseif ( email_exists( $user_email ) )
			$errors1->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.','templatic'));

		do_action('register_post', $user_login, $user_email, $errors1);	
		
		//$errors1 = apply_filters( 'registration_errors', $errors1 );
		
		if($errors1)
		{
			$_SESSION['userinset_error'] = '';
			foreach($errors1 as $errorsObj)
			{
				foreach($errorsObj as $key=>$val)
				{
					for($i=0;$i<count($val);$i++)
					{
						$_SESSION['userinset_error'] = $val[$i];
						if($val[$i]){break;}
					}
				} 
			}
		}
		if ($errors1->get_error_code() )
		{
			wp_redirect(home_url().'/?ptype=post_event&backandedit=1&usererror=1');
			exit;
		}
			
	}	/**registration validation for user EOF**/
	
	global $upload_folder_path;
	$_SESSION["file_info"] = explode(",",$_POST['imgarr']);
	if($_SESSION["file_info"])
	{
		foreach($_SESSION["file_info"] as $image_id=>$val)
		{
			 $image_src =  get_template_directory_uri().'/images/tmp/'.$val;
			 break;
		}
	}else
	{
		$image_src = $thumb_img_arr[0];
		if($_REQUEST['pid']){
		$large_img_arr = bdw_get_images($_REQUEST['pid'],'medium');
		$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
		}
		$image_src = $large_img_arr[0];
	}
	if($_REQUEST['pid'])
	{
		$large_img_arr = bdw_get_images($_REQUEST['pid'],'medium');
		$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
		$largest_img_arr = bdw_get_images($_REQUEST['pid'],'large');
	}
	
	$image_var = 'organizer_logo';
	if($_FILES[$image_var]['name'])
	{
		$src = $_FILES[$image_var]['tmp_name'];
		if($_FILES[$image_var]['name'] && $_FILES[$image_var]['size']>0)
		{
			$wp_upload_dir = wp_upload_dir();
			$path = $wp_upload_dir['path'];
			$url = $wp_upload_dir['url'];
			$subdir = $wp_upload_dir['subdir'];
			$baseurl = $wp_upload_dir['basedir'];
			$destination_path = $path;
			
			if (!file_exists($baseurl)){
			  mkdir($baseurl, 0777);
			}
			$subdir_arr = explode('/',$subdir);
			for($i=0;$i<count($subdir_arr);$i++)
			{
				$baseurl = $baseurl.$subdir_arr[$i]."/";
				if (!file_exists($baseurl)){
				  mkdir($baseurl, 0777);
				}	
			}
			$baseurl = substr($baseurl,0,strlen($baseurl)-1);
			$name = str_replace(array(',',' ','-'),'_',$_FILES[$image_var]['name']);
			$tmp_name = $_FILES[$image_var]['tmp_name'];
			$target_path = $baseurl. '/' . $name;
			$extension_file=array('.jpg','.JPG','jpeg','JPEG','.png','.PNG','.gif','.GIF','.jpe','.JPE'); 
			$file_ext= substr($target_path, -4, 4);
			if(in_array($file_ext,$extension_file))
			{
				if(move_uploaded_file($tmp_name, $target_path)) 
				{
					$logurl = $url . "/" . $name;
					$_SESSION['theme_info']['organizer_logo'] = $logurl;
				}
			}
		}		
	}
	if($_SESSION['theme_info']['orga_logo']!="" && $_SESSION['theme_info']['organizer_logo']==""){
		$organizer_logo = $_SESSION['theme_info']['orga_logo'];
	}
	if($_SESSION['theme_info']['organizer_logo']!=""){
		$organizer_logo = $_SESSION['theme_info']['organizer_logo'];
	}
}else
{
	$catid_info_arr = get_property_cat_id_name($_REQUEST['pid']);
	$proprty_pricerange = $catid_info_arr['price']['id'];
	$proprty_location = $catid_info_arr['location']['id'];
	$proprty_type = get_post_meta($_REQUEST['pid'],'property_type',true);
	//$proprty_bedroom = $catid_info_arr['bed']['id'];
	$post_info = get_post_info($_REQUEST['pid']);
	$proprty_name = $post_info['post_title'];
	$proprty_desc = $post_info['post_content'];
	$proprty_excerpt = $_POST['proprty_excerpt'];
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	
	$address = stripslashes($post_meta['address'][0]);
	$geo_latitude = $post_meta['geo_latitude'][0];
	$geo_longitude = $post_meta['geo_longitude'][0];
	$map_view = $post_meta['map_view'][0];
	$st_date = $post_meta['st_date'][0];
	$st_time = $post_meta['st_time'][0];
	$end_date = $post_meta['end_date'][0];
	$end_time = $post_meta['end_time'][0];
	$phone = $post_meta['phone'][0];
	$email = $post_meta['email'][0];
	$website = $post_meta['website'][0];
	$twitter = $post_meta['twitter'][0];
	$facebook = $post_meta['facebook'][0];	
	$organizer_name = $post_meta['organizer_name'][0];
	$organizer_email = $post_meta['organizer_email'][0];
	$organizer_address = $post_meta['organizer_address'][0];
	$organizer_contact = $post_meta['organizer_contact'][0];
	$organizer_website = $post_meta['organizer_website'][0];
	$organizer_mobile = $post_meta['organizer_mobile'][0];
	$organizer_logo = $post_meta['organizer_logo'][0];
	$organizer_desc = $post_meta['organizer_desc'][0];	
	$reg_desc = stripslashes($post_meta['reg_desc'][0]);
	$reg_fees = $post_meta['reg_fees'][0];
	
	$st_date = $post_meta['st_date'][0];
	$end_date = $post_meta['end_date'][0];
	$st_time = $post_meta['st_time'][0];
	$end_time = $post_meta['end_time'][0];
	$proprty_add_feature = $post_meta['proprty_add_feature'][0];
	
	$event_type = $post_meta['event_type'][0];
	$recurrence_occurs = $post_meta['recurrence_occurs'][0];
	$recurrence_per = $post_meta['recurrence_per'][0];
	$recurrence_onday = $post_meta['recurrence_onday'][0];
	$recurrence_onweekno = $post_meta['recurrence_onweekno'][0];
	$recurrence_days = $post_meta['recurrence_days'][0];
	$recurrence_bydays = $post_meta['recurrence_bydays'][0];
	
	
	$cat = $post_meta['category'];
	$sep = "";
	$a = "";
	$cat1 = "";
	if($_REQUEST['pid'])
	{
		$is_delet_property = 1;
	}
}
global $upload_folder_path;
$_SESSION["file_info"] = explode(",",$_POST['imgarr']);
if($_SESSION["file_info"])
{
	foreach($_SESSION["file_info"] as $image_id=>$val)
	{
		 $image_src =  get_template_directory_uri().'/images/tmp/'.$val;
		 break;
	}
}else
{
	$image_src = $thumb_img_arr[0];
	if($_REQUEST['pid']){
	$large_img_arr = bdw_get_images($_REQUEST['pid'],'medium');//fetch image
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
	}
	$image_src = $large_img_arr[0];
}
if($_REQUEST['pid'])
{
	$large_img_arr = bdw_get_images($_REQUEST['pid'],'medium');
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
	$largest_img_arr = bdw_get_images($_REQUEST['pid'],'large');
}
//contion for captcha inserted properly or not.
$pcd = explode(',',get_option('ptthemes_recaptcha'));
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(!$_REQUEST['pid'])
 {
 	$play = get_option('ptthemes_captcha_option');
	if((in_array('Submit Event Page',$pcd)) && is_plugin_active('wp-recaptcha/wp-recaptcha.php') && $play == 'WP-reCaptcha'){
			require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
			$a = get_option("recaptcha_options");
			$privatekey = $a['private_key'];
							$resp = recaptcha_check_answer ($privatekey,
									getenv("REMOTE_ADDR"),
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
												
			if (!$resp->is_valid ) {
				wp_redirect(home_url().'/?ptype=post_event&backandedit=1&ecptcha=captch');
				exit;
			} 
		}
 }
$play = get_option('ptthemes_captcha_option');
$play_opt = get_option('ptthemes_recaptcha');
$option = explode(",",$play_opt);
if(file_exists(ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php') && $play == 'PlayThru'  && in_array('Submit Event Page',$option) && $_REQUEST['pid'] == '')
{
	require_once( ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php');
	require_once(ABSPATH.'wp-content/plugins/are-you-a-human/includes/ayah.php');
	$ayah = new AYAH();
	$score = $ayah->scoreResult();
	if(!$score)
	{
		wp_redirect(home_url().'/?ptype=post_event&backandedit=1&invalid=playthru');
		exit;
	}
}
?>
<?php get_header(); ?>

<div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >
<?php include (TEMPLATEPATH . "/monetize/event/preview_buttons_event.php");?>
        <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
        <div class="breadcrumb clearfix">
            <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
        </div>
    <?php } ?>
        	<h1><?php echo $proprty_name; ?></h1>  
      <div class="event_information">      	
        <div class="date_info">
         <p>
         <?php  if($st_date){?>
         <span><?php _e('Start Date','templatic');?> :</span> <?php echo get_formated_date($st_date);?> <br />
         <?php }?>
         <?php if($end_date){?>
        <span><?php _e('End Date','templatic');?>  :</span> <?php echo get_formated_date($end_date);?>  <br />
        <?php }?>
        <?php if($st_time && $end_time){?><span><?php _e('Time','templatic');?>  : </span> <?php echo get_formated_time($st_time)?> <?php _e('to','templatic');?> <?php echo get_formated_time($end_time)?><?php }?> </p>
		 <p> 
          <?php if($phone){ ?>
         <span><?php _e('Phone','templatic');?> :</span> <?php echo $phone;?>  <br /> 
         <?php }?>  
         <?php if($email){ ?>           
		<span><?php _e('Email','templatic');?> :</span> <?php echo $email;?></p>	
         <?php }?>
          </div> 

          <div class="location">
          	<?php if($address){ ?>
            <p> 
            <span><?php _e('Location','templatic');?>  : </span>   <br />
           <?php echo $address;?></p>
            <?php }?>
            <?php if($website){ ?>
            <p><a href="<?php echo $website;?>"><?php _e('Website','templatic');?></a></p>
             <?php }?>
          </div>
      </div>
<script type="text/javascript">
function show_hide_tabs(type)
{
	if(type=='map')
	{
		document.getElementById('pikachoose').style.display='none';
		document.getElementById('detail_google_map_id').style.display='block';
		document.getElementById('li_location_map').className='active';
		document.getElementById('li_image_gallery').className='';
	}else if(type=='gallery')
	{
		document.getElementById('pikachoose').style.display='block';
		document.getElementById('detail_google_map_id').style.display='none';
		document.getElementById('li_location_map').className='';
		document.getElementById('li_image_gallery').className='active';
	}
}
</script>
      
       <div class="tabber">
   		 <ul class="tab">
            <li id="li_location_map" class="active"> <a href="javascript:void(0):" onclick="show_hide_tabs('map');"><?php _e('Location Map','templatic');?></a></li>
            <li id="li_image_gallery" class="" > <a href="javascript:void(0):" onclick="show_hide_tabs('gallery');"><?php _e('Image Gallery','templatic');?></a></li>
         </ul>
       </div>
			<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.pikachoose.js"></script>
            
            <script language="javascript" type="text/javascript">
            jQuery.noConflict();
			jQuery(document).ready(
                function (){
                    jQuery("#pikame").PikaChoose();            
                });
            </script>
           
                <div class="pikachoose" id="pikachoose" style="display:none" >
                 <?php if($_SESSION["file_info"] || $thumb_img_arr){?>
                <ul id="pikame" class="jcarousel-skin-pika">
                <?php
				$thumb_img_counter = 0;
				if($_SESSION["file_info"])
				{
					$thumb_img_counter = $thumb_img_counter+count($_SESSION["file_info"]);
					$image_path = get_image_phy_destination_path();
						
					$tmppath = "/".$upload_folder_path."tmp/";
						
					foreach($_SESSION["file_info"] as $image_id=>$val)
					{
						$thumb_image = get_template_directory_uri().'/images/tmp/'.$val;
					?>
					  <li>
                        <img src="<?php echo $thumb_image;?>" alt=""    />
                    </li>
					<?php
					$thumb_img_counter++;
					}
				}
				if($largest_img_arr)
				{
					$thumb_img_counter = $thumb_img_counter+count($largest_img_arr);
					for($i=0;$i<count($largest_img_arr);$i++)
					{
						$thumb_image = $largest_img_arr[$i];
					?>
					 <li>
                        <img src="<?php echo $largest_img_arr[$i];?>" alt=""    />
                    </li>
				<?php
					}
				}
				?>
               </ul>
               <?php }else
			   {
				   _e('No image gallery uploaded','templatic');
			   }?>
         </div>
  
   
       
<div class="google_map" id="detail_google_map_id">
<?php 
include_once (TEMPLATEPATH . '/library/map/google_map_detail.php');?>
</div>  <!-- google map #end -->
<?php if(get_option('is_active')=="1"){?>
<h3><?php _e('Description','templatic');?></h3>
<?php  echo $proprty_desc; ?>
<?php }?>
<div class="basicinfo">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<?php	
			//fetch custom fields for event.
			global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".CUSTOM_POST_TYPE1."' ) and show_on_detail = 1";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				$i = 1;
				$y = 0;
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
						if($_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name] != "" ){
							if($post_meta_info_obj->htmlvar_name != "event_name" && $post_meta_info_obj->htmlvar_name != "post_content" && $post_meta_info_obj->htmlvar_name != "post_excerpt" && $post_meta_info_obj->htmlvar_name != "post_title" && $post_meta_info_obj->htmlvar_name != "property_type"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "stdate" && $post_meta_info_obj->htmlvar_name != "enddate" && $post_meta_info_obj->htmlvar_name != "sttime" && $post_meta_info_obj->htmlvar_name != "endtime" && $post_meta_info_obj->htmlvar_name != "email"  && $post_meta_info_obj->htmlvar_name != "address"  && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "property_desc" && $post_meta_info_obj->htmlvar_name != "property_excerpt" && $post_meta_info_obj->htmlvar_name != "phone" && $post_meta_info_obj->htmlvar_name != "video" && $post_meta_info_obj->htmlvar_name != "map_view" && $post_meta_info_obj->htmlvar_name != "reg_desc" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "twitter")
								{
								 if($y == 0):
						 			echo "<h2 class='home'>".EVENT_CUSTOM_INFORMATION."</h2>";
									$y = 1;
								 endif;
								 if($i%2 == 0){?><tr><?php } ?><td>
									<?php
                                    if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
                                        echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".$_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name]."</div>";
                                    } else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = $_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name];
											$check = "";
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>".$check."</div>";
										else:
                                        	echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".stripslashes($_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name])."</div>";
										endif;	
                                    } 
						}?>
					 </td><?php  $i++;
					 }	
					 }
		} ?></table></div>
<?php $author_info = get_author_info($post_author_id);?>
<h3><?php _e('Organized by','templatic');?></h3>
<?php 
	global $wpdb;
	$aezaz = get_post_meta($_REQUEST['pid'],'organizer_logo',false);
	if($organizer_logo!=""){
		$organizer_logo=$organizer_logo;
	}else{
		$organizer_logo=$aezaz[0];
	}
?>
<img src="<?php echo $organizer_logo; ?>" style="height:105px;width:105px;" alt="" class="organized_logo"  title=""  />
        	<div class="organized_content" >
              <p> <?php _e('Organized by','templatic');?>  <a href="<?php echo get_author_posts_url($post->post_author);?>"><?php echo $author_info->display_name;?></a></p> 
              <p> <?php if($organizer_name){?>
             <?php echo $organizer_name;?>, <br />
              <?php }?>
<?php echo $organizer_address;?> </p>
<p>
<?php echo $organizer_desc;?>
<?php if($organizer_contact  && get_option('ptthemes_contact_on_detailpage')=='Yes'){?>
<?php _e('Tel','templatic');?>: <?php echo $organizer_contact;?> <br />
<?php }?>
<?php if($organizer_mobile){?>
<?php _e('Mobile','templatic');?>: <?php echo $organizer_mobile;?><br />
<?php }?>
<?php if($organizer_email  && get_option('ptthemes_email_on_detailpage')=='Yes'){?>
<?php _e('Email','templatic');?>: <?php echo $organizer_email;?><br />
<?php }?>
<?php if($organizer_website){?>
<?php _e('Website','templatic');?>: <a href=" <?php echo $organizer_website;?>"><?php echo $organizer_website;?></a>
<?php }?>
</p> 
<a class="b_contact" href="#" ><?php _e('Contact the Organizer','templatic');?></a>
</div>
<div class="basicinfo">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<?php	
			//fetch custom fields for organizer.
			global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='organizer' ) and show_on_detail = 1";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				$i = 1;
				$y = 0;
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
						if($_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name] != "" ){
							if($post_meta_info_obj->htmlvar_name != "event_name" && $post_meta_info_obj->htmlvar_name != "property_type"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "stdate" && $post_meta_info_obj->htmlvar_name != "enddate" && $post_meta_info_obj->htmlvar_name != "sttime" && $post_meta_info_obj->htmlvar_name != "endtime" && $post_meta_info_obj->htmlvar_name != "email"  && $post_meta_info_obj->htmlvar_name != "address"  && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "property_desc" && $post_meta_info_obj->htmlvar_name != "property_excerpt" && $post_meta_info_obj->htmlvar_name != "phone" && $post_meta_info_obj->htmlvar_name != "video" && $post_meta_info_obj->htmlvar_name != "map_view" && $post_meta_info_obj->htmlvar_name != "reg_desc" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "twitter")
								{
								 if($y == 0):
						 			echo "<h2 class='home'>".ORGANIZER_CUSTOM_INFORMATION."</h2>";
									$y = 1;
								 endif;
								 if($i%2 == 0){?><tr><?php } ?><td>
									<?php
                                    if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
                                        echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".$_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name]."</div>";
                                    } else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = $_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name];
											$check = "";
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>".$check."</div>";
										else:
                                        	echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".stripslashes($_SESSION['theme_info'][$post_meta_info_obj->htmlvar_name])."</div>";
										endif;	
                                    } 
						}?>
					 </td><?php  $i++;
					 }	
					 }
		} ?></table></div>
<?php if($reg_desc){?>
 	<div class="register_msg clearfix" ><?php echo stripslashes($reg_desc);?> </div>
<?php }?>
<div style="clear:both;"></div>
<?php include (TEMPLATEPATH . "/monetize/event/preview_buttons_event.php");?>                   
   </div> <!-- content #end -->
<?php get_sidebar(); ?>
</div> <!-- wrapper #end -->
<div id="bottom"></div>  
<?php get_footer(); ?>