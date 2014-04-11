<?php
session_start();
ob_start();
$terms1 =get_terms( 'eventcategory',array(
 	'hide_empty' => 0));

$cat_display=get_option('ptthemes_category_display');
if(@$_REQUEST['backandedit'])
{
}else
{
	$_SESSION['theme_info'] = array();
	$_SESSION['userinset_error'] = '';
}
if(!is_user_can_add_event())
{
	wp_redirect(home_url());
}
if(@$_REQUEST['pid'])
{
	if(!$current_user->ID)
	{
		wp_redirect(home_url().'/index.php?ptype=login');
		exit;
	}
	$pid = $_REQUEST['pid'];
	$proprty_type = $catid_info_arr['type']['id'];
	$post_info = get_post_info($_REQUEST['pid']);
	$proprty_name = $post_info['post_title'];
	$proprty_desc = $post_info['post_content'];
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	$address = stripslashes($post_meta['address'][0]);
	$geo_latitude = $post_meta['geo_latitude'][0];
	$geo_longitude = $post_meta['geo_longitude'][0];
	$map_view = $post_meta['map_view'][0];	
	$video = $post_meta['video'][0];
	$st_date = $post_meta['st_date'][0];
	$st_date_arr = explode(' ',$st_date);
	$st_date = $st_date_arr[0];
	$st_time = $post_meta['st_time'][0];
	$end_date = $post_meta['end_date'][0];
	$end_date_arr = explode(' ',$end_date);
	$end_date = $end_date_arr[0];
	$end_time = $post_meta['end_time'][0];
	$phone = $post_meta['phone'][0];
	$email = $post_meta['email'][0];
	$website = $post_meta['website'][0];
	$twitter = $post_meta['twitter'][0];
	$facebook = $post_meta['facebook'][0];
	$reg_desc = stripslashes($post_meta['reg_desc'][0]);
	
	$organizer_name = stripslashes($post_meta['organizer_name'][0]);
	$organizer_email = $post_meta['organizer_email'][0];
	$organizer_logo = $post_meta['organizer_logo'][0];
	$organizer_address = stripslashes($post_meta['organizer_address'][0]);
	$organizer_contact = $post_meta['organizer_contact'][0];
	$organizer_website = $post_meta['organizer_website'][0];
	$organizer_mobile = $post_meta['organizer_mobile'][0];
	$organizer_desc = stripslashes($post_meta['organizer_desc'][0]);
	
	$proprty_feature = $post_meta['proprty_feature'][0];
	$post_city_id =$post_meta['post_city_id'][0];
	$cat_array = array();
	if($pid)
	{
		global $wpdb;
		$cat_array = $wpdb->get_col("select t.name from $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id join $wpdb->term_relationships tr on tr.term_taxonomy_id=tt.term_taxonomy_id where tr.object_id=\"$pid\" and tt.taxonomy='".CUSTOM_CATEGORY_TYPE1."'");
	}
	$thumb_img_arr = bdw_get_images_with_info($_REQUEST['pid'],'thumb');
}

if($_SESSION['theme_info'] && $_REQUEST['backandedit'])
{
	$proprty_name = $_SESSION['theme_info']['event_name'];
	$proprty_desc = $_SESSION['theme_info']['property_desc'];
	$proprty_feature = $_SESSION['theme_info']['event_feature'];
	$address = $_SESSION['theme_info']['address'];
	$geo_latitude = $_SESSION['theme_info']['geo_latitude'];
	$geo_longitude = $_SESSION['theme_info']['geo_longitude'];
	$map_view = $_SESSION['theme_info']['map_view'];	
	$st_date = $_SESSION['theme_info']['st_date'];
	$st_time = $_SESSION['theme_info']['st_time'];
	$end_date = $_SESSION['theme_info']['end_date'];
	$end_time = $_SESSION['theme_info']['end_time'];
	$reg_desc = $_SESSION['theme_info']['reg_desc'];
	$post_city_id = $_SESSION['theme_info']['post_city_id'];
	
	$organizer_name = $_SESSION['theme_info']['organizer_name'];
	$organizer_email = $_SESSION['theme_info']['organizer_email'];
	$organizer_logo = $_SESSION['theme_info']['organizer_logo'];
	$organizer_address = $_SESSION['theme_info']['organizer_address'];
	$organizer_contact = $_SESSION['theme_info']['organizer_contact'];
	$organizer_website = $_SESSION['theme_info']['organizer_website'];
	$organizer_mobile = $_SESSION['theme_info']['organizer_mobile'];
	$organizer_desc = stripslashes($_SESSION['theme_info']['organizer_desc']);
	
	$phone = $_SESSION['theme_info']['phone'];
	$email = $_SESSION['theme_info']['email'];
	$website = $_SESSION['theme_info']['website'];
	$twitter = $_SESSION['theme_info']['twitter'];
	$facebook = $_SESSION['theme_info']['facebook'];
	$user_fname = $_SESSION['theme_info']['user_fname'];
	$user_phone = $_SESSION['theme_info']['user_phone'];
	$user_email = $_SESSION['theme_info']['user_email'];
	$user_login_or_not = $_SESSION['theme_info']['user_login_or_not'];
	if(($cat_display == 'checkbox' || $cat_display == '') && $_SESSION['theme_info']['category'] != ''){ 
		$cat_array1 = implode("-",$_SESSION['theme_info']['category']);
		$cat_array2 = explode("-",$cat_array1) ;
		$tc= count($cat_array2 );
		$allcat ="";
		for($i=0; $i<=$tc; $i++ ){
			$allc = explode(',',$cat_array2[$i]);
			if($allc[0] != ""){
				$allc1 .= $allc[0].","; 
			}
		}
		$cat_array = explode(',',$allc1);
	}else{
		$cat_array = $_SESSION['theme_info']['category'];
	}
	$proprty_add_coupon = $_SESSION['theme_info']['proprty_add_coupon'];
	$price_select = $_SESSION['theme_info']['price_select'];
}else if(!isset($_REQUEST['pid']) && @$_REQUEST['pid'] == '')
{
	$reg_desc = HOW_TO_APPLY_DESC_TEXT;	
}
if(@$proprty_desc=='')
{
	$proprty_desc = __("You should enter description content for your listing.","templatic");
}
if(@$_REQUEST['renew'])
{
	$property_list_type = get_post_meta($_REQUEST['pid'],'list_type',true);
}
if(@$_REQUEST['ptype']=='post_event')
{
	if(@$_REQUEST['pid'])
	{
		if(@$_REQUEST['renew'])
		{
			$page_title = RENEW_EVENT_TEXT;
		}else
		{
			$page_title = EDIT_EVENT_TEXT;
		}
	}else
	{
		$page_title = POST_EVENT_TITLE;
	}
}else
{
	if(@$_REQUEST['pid'])
	{
		if($_REQUEST['renew'])
		{
			$page_title = RENEW_LISING_TEXT;
		}else
		{
			$page_title = EDIT_LISING_TEXT;
		}
	}else
	{
		$page_title = POST_PLACE_TITLE;
	}
}
if($cat_display==''){$cat_display='checkbox';}
?>

<?php get_header(); ?>
<script type="text/javascript" language="javascript" >var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/monetize/event/property.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		editor_selector : "mce",
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

function validate_coupon()
{
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(xmlhttp == null)
	{
		alert("Your browser not support the AJAX");	
		return;
	}
	if(document.getElementById("proprty_add_coupon"))
		add_coupon = document.getElementById("proprty_add_coupon").value;
		total_price = document.getElementById("total_price").value;
		var url = "<?php echo get_template_directory_uri(); ?>/monetize/event/ajax_check_coupon.php?add_coupon="+add_coupon+"&total_price="+total_price;

		xmlhttp.open("GET",url,true);
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{	
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText)
				{
					document.getElementById("msg_coudon_code").innerHTML = xmlhttp.responseText;
					jQuery("#msg_coudon_code").removeClass('error_msg');
					jQuery("#msg_coudon_code").addClass('success_msg');
				}
				else
				{
					document.getElementById("msg_coudon_code").innerHTML = 'Sorry! coupon code does not exist.Please try an aother coupon code.';
					jQuery("#msg_coudon_code").removeClass('success_msg');
					jQuery("#msg_coudon_code").addClass('error_msg');
				}
			}
		}
		return true;
}
</script>
<!-- /TinyMCE -->
<script type="text/javascript">
function show_featuredprice(pkid)
{
	if (pkid=="")
	  {
	  document.getElementById("featured_h").innerHTML="";
	  return;
	  }else{
	  //document.getElementById("featured_h").innerHTML="";
	  document.getElementById("process").style.display ="block";
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("process").style.display ="none";
		var myString =xmlhttp.responseText;
		var myStringArray = myString.split("###RAWR###");  
		document.getElementById('property_list_type').value = myStringArray[7];
		document.getElementById('alive_days').value = myStringArray[6];
		if(myStringArray[5] == 1){
		if(document.getElementById('is_featured').style.display == "none")
		{
			document.getElementById('is_featured').style.display="";
		}
			document.getElementById('featured_h').value = myStringArray[0];
			document.getElementById('featured_c').value = myStringArray[1];
			var position = document.getElementById('c_position').value;
			if(position == 'Symbol Before amount'){ 
			document.getElementById('ftrhome').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>"+myStringArray[0]+")";

			document.getElementById('ftrcat').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>"+myStringArray[1]+")";
			}else if(position == 'Space between Before amount and Symbol'){
			document.getElementById('ftrhome').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?> "+myStringArray[0]+")";
			document.getElementById('ftrcat').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?> "+myStringArray[1]+")";
			}else if(position == 'Symbol After amount'){
			document.getElementById('ftrhome').innerHTML = "("+myStringArray[0]+"<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			document.getElementById('ftrcat').innerHTML = "("+myStringArray[1]+"<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			}else{
			document.getElementById('ftrhome').innerHTML = "("+myStringArray[0]+" <?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			document.getElementById('ftrcat').innerHTML = "("+myStringArray[1]+" <?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			}
			document.getElementById('pkg_price').innerHTML = myStringArray[4];   
		}else{
			document.getElementById('pkg_price').innerHTML = myStringArray[4];  
			document.getElementById('featured_c').value=0;
			document.getElementById('ftrcat').innerHTML	=0+"<?php echo fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');?>";		
			document.getElementById('featured_h').value=0;
			document.getElementById('ftrhome').innerHTML = 0+"<?php echo fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');?>";		
			document.getElementById('is_featured').style.display = "none"; 
		 	document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1])  + parseFloat(myStringArray[4]);
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) +   parseFloat(myStringArray[4]);
		
		}
		if((document.getElementById('featured_h').checked== true) && (document.getElementById('featured_c').checked== true))
		{	
			
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) ;
			
			document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1])  + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1])  + parseFloat(myStringArray[4]);
			
		}else if((document.getElementById('featured_h').checked == true) && (document.getElementById('featured_c').checked == false)){
			
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[0]);
			
			document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(document.getElementById('feture_price').innerHTML)  + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(document.getElementById('feture_price').innerHTML)  + parseFloat(myStringArray[4]);
		}else if((document.getElementById('featured_h').checked == false) && (document.getElementById('featured_c').checked == true)){
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[1]);
			document.getElementById('total_price').value = parseFloat(myStringArray[1]) + parseFloat(document.getElementById('feture_price').innerHTML)  + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[1]) + parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
		}else{
			document.getElementById('total_price').value = parseFloat(document.getElementById('feture_price').innerHTML)  + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML =parseFloat(document.getElementById('feture_price').innerHTML)  + parseFloat(myStringArray[4]);
		}
	  } 
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/event/ajax_price.php?pkid="+pkid
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
	 
}

function fetch_packages(pkgid,form,pri)
{ 
	var total = 0;
	var t=0;
	//var c= form['category[]'];
	var dml = document.forms['propertyform'];
	var c = dml.elements['category[]'];
	var cats = document.getElementById('all_cat').value;
	document.getElementById('all_cat').value = "";
	document.getElementById('all_cat_price').value = 0;
	
	if(c)
	{
	for(var i=0;i<c.length;i++){
		c[i].checked?t++:null;
		if(c[i].checked)
		{	
			var a = c[i].value.split(",");
		
			document.getElementById('all_cat').value += a[0]+"|";
			
			
			document.getElementById('all_cat_price').value = parseFloat(document.getElementById('all_cat_price').value) + parseFloat(a[1]);
			
			

		}
		
			document.getElementById('total_price').value =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);

			
			document.getElementById('result_price').innerHTML =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	}
	}
	var cats = document.getElementById('all_cat').value ;
	
	  document.getElementById("packages_checkbox").innerHTML="";
	  document.getElementById("process2").style.display ="";
	 
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("packages_checkbox").innerHTML =xmlhttp.responseText;
			document.getElementById("process2").style.display ="none";
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/event/ajax_price.php?pckid="+cats
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();		
}
function allplaces_packages(cp_price) {
	var total = 0;
	var t=0;
	//var c= form['category[]'];
	var dml = document.forms['propertyform'];
	var c = dml.elements['category[]'];
	var selectall = dml.elements['selectall'];
	if(selectall.checked == false){
		cp_price = 0;
	} else {
		cp_price = cp_price;
	}
	var cats = document.getElementById('all_cat').value;
	document.getElementById('all_cat').value = "";
	document.getElementById('all_cat_price').value = 0;
	
	
		for(var i=0 ;i < c.length;i++){
		c[i].checked?t++:null;
		if(c[i].checked){	
			var a = c[i].value.split(",");
			if(i ==  (c.length - 1) ){
				document.getElementById('all_cat').value += a[0]+"|";
			} else {
				document.getElementById('all_cat').value += a[0]+"|";
			}
		}
	}

	document.getElementById('all_cat_price').value = parseFloat(cp_price);

	document.getElementById('total_price').value =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	document.getElementById('result_price').innerHTML =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	
	var cats = document.getElementById('all_cat').value ;
	
	  document.getElementById("packages_checkbox").innerHTML="";
	  document.getElementById("process2").style.display ="";
	
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("packages_checkbox").innerHTML =xmlhttp.responseText;;
		document.getElementById("process2").style.display ="none";
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/event/ajax_price.php?pckid="+cats
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();	

	}
</script>
<?php $a = get_option('recaptcha_options'); ?>
<script type="text/javascript">
	 var RecaptchaOptions = {
		theme : '<?php echo $a['registration_theme']; ?>',
		lang : '<?php echo $a['recaptcha_language']; ?>'
	 };
</script>
<div id="wrapper" class="clearfix">
 <div id="content" class="clearfix" >
 	
    <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><?php yoast_breadcrumb('',' &raquo; '.$page_title);  ?></div>
    </div>
<?php } ?>
    <h1><?php echo $page_title;?></h1>   
    
<?php  if(isset($_REQUEST['ecptcha']) == 'captch') {
	$a = get_option("recaptcha_options");
	$blank_field = $a['no_response_error'];
	$incorrect_field = $a['incorrect_response_error'];
	echo '<div class="error_msg">'.$incorrect_field.'</div>';
}
if(isset($_REQUEST['invalid']) == 'playthru') {
	echo '<div class="error_msg">You need to play the game to post the event successfully.</div>';
}
 ?>

 <?php if(is_allow_user_register()){?>
			 <p class="frm_note note"> <span class="required">*</span> <?php echo INDICATES_MANDATORY_FIELDS_TEXT;?> </p>
             <?php
			if(@$_REQUEST['emsg']==1)
			{
			?>
			<div class="error_msg"><?php echo INVALID_USER_PW_MSG;?></div>
			<?php
			}
			if(@$_SESSION['userinset_error'])
			{
			?>
			<div class="error_msg"><?php echo $_SESSION['userinset_error'];?></div>
			<?php
			}
			if(@$_SESSION['error'])
			{
			?>
			<div class="error_msg"><?php echo $_SESSION['error'];?></div>
			<?php
			}
			global $current_user;
			if($current_user->ID=='')
			 {
			 ?>
              <div class="form_row clearfix">
             	<label><?php echo IAM_TEXT;?> </label>
             	 <span class=" user_define"> <input name="user_login_or_not" type="radio" value="existing_user" <?php if(!get_option('users_can_register')){echo 'checked="checked"';}else{ if($user_login_or_not=='existing_user'){ echo 'checked="checked"';}}?> onclick="set_login_registration_frm(this.value);" /> <?php echo EXISTING_USER_TEXT;?> </span>  
				 <?php if(get_option('users_can_register')){?>
				 <span class="user_define"> <input name="user_login_or_not" type="radio" value="new_user" <?php if($user_login_or_not=='new_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm(this.value);" /> <?php echo NEW_USER_TEXT;?> </span>
				 <?php }?>
              </div>
              <div class="login_submit clearfix" id="login_user_frm_id">
              <form name="loginform" id="loginform" action="<?php echo get_ssl_normal_url(home_url().'/index.php?page=login'); ?>" method="post" >
			   <?php
				if(strtolower(get_option('ptttheme_fb_opt')) == strtolower('Yes'))
				  { ?>
			  <div class="fbplugin"><?php do_action('oa_social_login'); ?></div></br><?php  _e('OR','templatic'); ?><?php } ?>
              <div class="form_row clearfix">
             	<label><?php echo LOGIN_TEXT;?>  <span>*</span> </label>
             	<input type="text" class="textfield " id="user_login" name="log" />
              </div>
              
               <div class="form_row clearfix">
             	<label><?php echo PASSWORD_TEXT;?>  <span>*</span> </label>
             	<input type="password" class="textfield " id="user_pass" name="pwd" />
              </div>
              
              <div class="form_row clearfix">
              <input name="submit" type="submit" value="<?php echo SUBMIT_BUTTON;?>" class="b_submit" />
			  </div>
			
			  <?php	$login_redirect_link = home_url().'/?ptype=post_event';?>
			  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
			  <input type="hidden" name="testcookie" value="1" />
			  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
			  </form>
              </div>
             <?php }?>
 <?php
			 if(@$_REQUEST['pid'] || @$_POST['renew']){
				$form_action_url = get_option( 'home' ).'/?ptype=preview';
			 }else
			 {
				 $form_action_url = get_ssl_normal_url(get_option( 'home' ).'/?ptype=preview',@$_REQUEST['pid']);
			 }?>
			 <form name="propertyform" id="propertyform" action="<?php echo $form_action_url; ?>" method="post" enctype="multipart/form-data">
			 <?php  if($cat_display == 'select')
			{  	if($current_user->ID=='')	 {
				 ?>
				 
				<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "new_user";}?>" />		
				<div id="contact_detail_id" style="display:none; padding-bottom:25px;"> 
                    <?php 		
					/* validation fields for registration form */
						global $form_fields_usermeta;
						$validation_info = array();
						foreach($form_fields_usermeta as $key=>$val)
						{
						if($val['on_registration']){
						$str = ''; $fval = '';
						$field_val = $key.'_val';
						if($$field_val){$fval = $$field_val;}else{$fval = $val['default'];}
						
						if($val['is_require'])
						{
							$validation_info[] = array(
													   'name'	=> $key,
													   'espan'	=> $key.'_error',
													   'type'	=> $val['type'],
													   'text'	=> $val['label'],
													   );
						}
						if($val['type']=='text')
						{
							$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';
							}
						}elseif($val['type']=='hidden')
						{
							$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='textarea')
						{
							$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='texteditor')
						{
							$str = $val['tag_before'].'<textarea name="'.$key.'" PLACEHOLDER="'.$val["default"].'" class="mce $val["extra_parameter"]">'.$fval.'</textarea>'.$val['tag_after'];
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='file')
						{
							$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='include')
						{
							$str = @include_once($val['default']);
						}else
						if($val['type']=='head')
						{
							$str = '';
						}else
						if($val['type']=='date')
						{
							$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';	
							$str .= '<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.registerform.'.$key.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catselect')
						{
							$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
							$str = '<select name="'.$key.'" '.$val['extra'].'>';
							$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
							$all_categories = get_categories($args);
							foreach($all_categories as $key => $cat) 
							{
							
								$seled='';
								if($term->name==$cat->name){ $seled='selected="selected"';}
								$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
							}
							$str .= '</select>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catdropdown')
						{
							$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
							$cat_args['show_option_none'] = __('Select Category','templatic');
							$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='select')
						{
							$str = '<select name="'.$key.'" '.$val['extra'].'>';
							$option_values_arr = explode(',', $val['options']);

							for($i=0;$i<count($option_values_arr);$i++)
							{
								$seled='';
								
								if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
								$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
							}
							$str .= '</select>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catcheckbox')
						{
							$fval_arr = explode(',',$fval);
							$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catradio')
						{
							$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
							$all_categories = get_categories($args);
							foreach($all_categories as $key1 => $cat) 
							{
								
								
									$seled='';
									if($fval==$cat->term_id){ $seled='checked="checked"';}
									$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
								
							}
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='checkbox')
						{
							if($fval){ $seled='checked="checked"';}
							$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='upload')
						{
							
							$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}
						else
						if($val['type']=='radio')
						{
							$options = $val['options'];
				
							if($options)
							{
								$option_values_arr = explode(',',$options);
								for($i=0;$i<count($option_values_arr);$i++)
								{ //$option_values_arr[$i];
									$seled='';
									if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
									if($i ==0){
									  $str = $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
									}else{
									$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
									}
								}
								if($val['is_require'])
								{
									$str .= '<span id="'.$key.'_error"></span>';	
								}
							}
						}else
						if($val['type']=='multicheckbox')
						{
							$options = $val['options'];
							if($options)
							{  $chkcounter = 0;
								
								$option_values_arr = explode(',',$options);
								for($i=0;$i<count($option_values_arr);$i++)
								{
									$chkcounter++;
									$seled='';
									$fval_arr = explode(',',$fval);
									if(in_array($option_values_arr[$i],$fval_arr)){ $seled='checked="checked"';}
									$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
								}
								if($val['is_require'])
								{
									$str .= '<span id="'.$key.'_error"></span>';	
								}
							}
						}
						else
						if($val['type']=='packageradio')
						{
							$options = $val['options'];
							foreach($options as $okey=>$oval)
							{
								$seled='';
								if($fval==$okey){$seled='checked="checked"';}
								$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
							}
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='geo_map')
						{
							do_action('templ_submit_form_googlemap');	
						}else
						if($val['type']=='image_uploader')
						{
							do_action('templ_submit_form_image_uploader');	
						}
						if($val['is_require'])
						{
							$label = '<label>'.$val['label'].' <span class="indicates">*</span> </label>';
						}else
						{
							$label = '<label>'.$val['label'].'</label>';
						}
						echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
						}
						}
				 ?>
					</div>
				<?php } else { ?>
				<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if(@$user_login_or_not != '') {echo $user_login_or_not; } else { echo "existing_user";}?>" />		
				<?php }?> 
             <?php } }?>
			<?php 
			$post_sql = $wpdb->get_row("select post_author,ID from $wpdb->posts where post_author = '".$current_user->data->ID."' and ID = '".$_REQUEST['pid']."'");
			if((count($post_sql) <= 0) && ($current_user->data->ID != '') && ($current_user->data->ID != 1) && (isset($_REQUEST['pid'])))
			{ 
				echo '<div class="error_msg">'.ERROR_MSG.'</div>';
			}
			else
			{ 
			?>
            <input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php echo @$user_login_or_not;?>" />
            <input type="hidden" name="pid" value="<?php echo @$_REQUEST['pid'];?>" />
            <input type="hidden" name="renew" value="<?php echo @$_REQUEST['renew'];?>" />
			<?php $cur_pos = get_option('ptttheme_currency_position');?>
			<input type='hidden' name='c_position' id='c_position' value='<?php echo $cur_pos; ?>'/>
			 <?php
             /*--When going to renew the package ---*/
			 if(isset($_REQUEST['renew']) && $_REQUEST['renew'] != ''): ?>
			 <input type="hidden" name="renew" id="renew" value="1"/>
			 <?php endif; ?> 

			 <?php 
			  /*----Package information for edit-----------*/
			 if(isset($_REQUEST['pid']) !="" && !isset($_REQUEST['renew'])): ?>
				<?php /*?><input type="hidden" name="price_select" id="price_select" value="<?php echo get_post_meta($_REQUEST['pid'],'pkg_id',true); ?>"/><?php */?>
                <input type="hidden" name="total_price" id="total_price" value="<?php echo get_post_meta($_REQUEST['pid'],'paid_amount',true); ?>"/>
                <input type="hidden" name="featured_type" id="featured_type" value="<?php echo get_post_meta($_REQUEST['pid'],'featured_type',true); ?>"/>
			<?php endif; ?>

			<input type="hidden" name="property_list_type" id="property_list_type" value="<?php echo get_post_meta(@$_REQUEST['pid'],'property_list_type',true); ?>"/>
            <?php if(!isset($_REQUEST['backandedit'])): ?>
	            <input type="hidden" name="total_price" id="total_price" value="<?php echo get_post_meta(@$_REQUEST['pid'],'paid_amount',true); ?>"/>
            <?php endif; 
			global $wpdb,$current_user;
			$cur_user_id = $current_user->ID;
			$user_last_post = $wpdb->get_row("select * from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_author = '".$cur_user_id."' order by p.ID DESC LIMIT 0,1");
			$payment_type = get_option('ptthemes_package_type');
			if($user_last_post && strtolower($payment_type) == strtolower('Pay per subscriptions'))
			{
				$total_days = get_post_meta($user_last_post->ID,'alive_days',true);
				
				$publish_date = $user_last_post->post_date;
				$curdate = date('Y-m-d');
		
				$diff = abs(strtotime($curdate) - strtotime($publish_date));
				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
				$passing_days  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
				$alive_days = $total_days - $passing_days ;
			}else{
				$alive_days =30;
			}
			?>    
			<input type="hidden" name="alive_days" id="alive_days" value="<?php if($_REQUEST['pid'] !=''){ echo get_post_meta(@$_REQUEST['pid'],'alive_days',true); }else{ echo $alive_days; }?>"/>
		    <input type="hidden" name="all_cat" id="all_cat" value=""/>
			<input type="hidden" name="all_cat_price" id="all_cat_price" value="<?php if(@$_REQUEST['category'] !=""){ $cat = explode(",",$_REQUEST['category']); echo $cat[2]; }else{ echo "0";}?>"/>
			<?php if(@$_REQUEST['pid']=='' || $_REQUEST['renew']=='1'){ ?>
			 <?php  if($cat_display == 'select')
			  {
			  function get_terms_dropdown($taxonomies, $args){
				$myterms = get_terms($taxonomies, array('hide_empty' => 0));
				$output ="<select name='category' id='category'>";
				foreach($myterms as $term){
					$root_url = get_bloginfo('url');
					$term_taxonomy=$term->taxonomy;
					$term_slug=$term->slug;
					$term_id=$term->term_id;
					$term_name =$term->name;
					$link = $term_id;
					$output .="<option value='".$link."'>".$term_name."</option>";
				}
				$output .="</select>";
			return $output;
			}
			
			?>
			
			<h5 class="form_title "> <?php echo EVENT_DETAILS_TEXT;?> </h5>
			 <div class="form_row clearfix">
             	<label><?php echo P_CATEGORY_TEXT;?> <span>*</span> </label>
            	<div class="category_label"><?php $args = array('hide_empty' => 0); echo get_terms_dropdown('eventcategory',$args);?></div>
                <span class="message_note"><?php echo CATEGORY_MSG;?></span>
                <span id="category_span" class="message_error2"></span>
            </div>
		<?php 	}
		} ?>
             <?php
		if(isset($_REQUEST['pid']) && $_REQUEST['pid'] != '' && $cat_display == 'select') { ?>
			<input type="hidden" name="post_city_id" value="<?php echo $post_city_id;?>" />
<?php	} else {
			if($cat_display != 'select' && !isset($_REQUEST['category'])){ ?>
<?php			if($current_user->ID=='')	{	 ?>
					<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "new_user";}?>" />				
					<div id="contact_detail_id" style="display:none; padding-bottom:25px;"> 
                    <?php 		
						global $form_fields_usermeta;
						$validation_info = array();
						foreach($form_fields_usermeta as $key=>$val)
						{
						if($val['on_registration']){
						$str = ''; $fval = '';
						$field_val = $_SESSION['theme_info'][$key];
						if($field_val){$fval = $field_val;}else{$fval = $val['default'];}
						
						if($val['is_require'])
						{
							$validation_info[] = array(
													   'name'	=> $key,
													   'espan'	=> $key.'_error',
													   'type'	=> $val['type'],
													   'text'	=> $val['label'],
													   );
						}
						if($val['type']=='text')
						{
							$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';
							}
						}elseif($val['type']=='hidden')
						{
							$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='textarea')
						{
							$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='texteditor')
						{
							$str = $val['tag_before'].'<textarea name="'.$key.'" PLACEHOLDER="'.$val["default"].'" class="mce $val["extra_parameter"]">'.$fval.'</textarea>'.$val['tag_after'];
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='file')
						{
							$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='include')
						{
							$str = @include_once($val['default']);
						}else
						if($val['type']=='head')
						{
							$str = '';
						}else
						if($val['type']=='date')
						{
							$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';	
							$str .= '<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.registerform.'.$key.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catselect')
						{
							$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
							$str = '<select name="'.$key.'" '.$val['extra'].'>';
							$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
							$all_categories = get_categories($args);
							foreach($all_categories as $key => $cat) 
							{
							
								$seled='';
								if($term->name==$cat->name){ $seled='selected="selected"';}
								$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
							}
							$str .= '</select>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catdropdown')
						{
							$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
							$cat_args['show_option_none'] = __('Select Category','templatic');
							$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='select')
						{
							$str = '<select name="'.$key.'" '.$val['extra'].'>';
							$option_values_arr = explode(',', $val['options']);
							for($i=0;$i<count($option_values_arr);$i++)
							{
								$seled='';
								
								if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
								$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
							}
							$str .= '</select>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catcheckbox')
						{
							$fval_arr = explode(',',$fval);
							$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='catradio')
						{
							$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
							$all_categories = get_categories($args);
							foreach($all_categories as $key1 => $cat) 
							{
								
								
									$seled='';
									if($fval==$cat->term_id){ $seled='checked="checked"';}
									$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
								
							}
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='checkbox')
						{
							if($fval){ $seled='checked="checked"';}
							$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='upload')
						{
							
							$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}
						else
						if($val['type']=='radio')
						{
							$options = $val['options'];
				
							if($options)
							{
								$option_values_arr = explode(',',$options);
								for($i=0;$i<count($option_values_arr);$i++)
								{ //$option_values_arr[$i];
									$seled='';
									if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
									if($i ==0){
									  $str = $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
									}else{
									$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
									}
								}
								if($val['is_require'])
								{
									$str .= '<span id="'.$key.'_error"></span>';	
								}
							}
						}else
						if($val['type']=='multicheckbox')
						{
							$options = $val['options'];
							if($options)
							{  $chkcounter = 0;
								
								$option_values_arr = explode(',',$options);
								for($i=0;$i<count($option_values_arr);$i++)
								{
									$chkcounter++;
									$seled='';
									$fval_arr = explode(',',$fval);
									if(in_array($option_values_arr[$i],$fval_arr)){ $seled='checked="checked"';}
									$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
								}
								if($val['is_require'])
								{
									$str .= '<span id="'.$key.'_error"></span>';	
								}
							}
						}
						else
						if($val['type']=='packageradio')
						{
							$options = $val['options'];
							foreach($options as $okey=>$oval)
							{
								$seled='';
								if($fval==$okey){$seled='checked="checked"';}
								$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
							}
							if($val['is_require'])
							{
								$str .= '<span id="'.$key.'_error"></span>';	
							}
						}else
						if($val['type']=='geo_map')
						{
							do_action('templ_submit_form_googlemap');	
						}else
						if($val['type']=='image_uploader')
						{
							do_action('templ_submit_form_image_uploader');	
						}
						if($val['is_require'])
						{
							$label = '<label>'.$val['label'].' <span class="indicates">*</span> </label>';
						}else
						{
							$label = '<label>'.$val['label'].'</label>';
						}
						echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
						}
						}
				 ?>
					</div>
<?php 			} else { ?>
					<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "existing_user";}?>" />
<?php 			} ?> 
				<h5 class="form_title "> <?php echo EVENT_DETAILS_TEXT;?> </h5>
				
				<?php if(!isset($_REQUEST['pid']) && count($terms1) > 0){ ?>
				<div class="form_row clearfix">
					<label><?php echo P_CATEGORY_TEXT;?> <span>*</span> </label>
					<div class="category_label"><?php require_once (TT_MODULES_FOLDER_PATH.'event/property_category.php');?></div>
					<span class="message_note"><?php echo CATEGORY_MSG;?></span>
					<span id="category_span" class="message_error2"></span>
				</div>
				<?php }else if(isset($_REQUEST['renew']) && count($terms1) > 0){?>
				<div class="form_row clearfix">
					<label><?php echo P_CATEGORY_TEXT;?> <span>*</span> </label>
					<div class="category_label"><?php require_once (TT_MODULES_FOLDER_PATH.'event/property_category.php');?></div>
					<span class="message_note"><?php echo CATEGORY_MSG;?></span>
					<span id="category_span" class="message_error2"></span>
				</div>
				<?php } ?>
<?php 		} else { 
			if(@$_REQUEST['category'] != "" && isset($_REQUEST['category'])){
			$cat = explode(",",$_REQUEST['category']);
			}
			?>
				<input type="hidden" name="renew" value="<?php echo @$_REQUEST['renew'];?>" />
          
				<input type="hidden" name="post_city_id" value="<?php echo @$_REQUEST['post_city_id'];?>" />
				
<?php 		} 
		}
		
			 
             if(!isset($geo_longitude)){$geo_longitude = '';	}
			if(!isset($geo_latitude)){$geo_latitude = '';	}
			if(!isset($geo_address)){$geo_address = '';	}
				$default_custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,'0','user_side');
				display_custom_post_field($default_custom_metaboxes,'theme_info',$geo_latitude,$geo_longitude,$geo_address,CUSTOM_POST_TYPE1);//display custom filed of event
				?>
				  <h5 class="form_title"><?php echo ORGANIZER_INFO_TITLE_TEXT;?></h5> 
			<?php
				$organizer_custom_metaboxes = get_post_custom_fields_templ('organizer','0','user_side');
				display_custom_post_field($organizer_custom_metaboxes,'theme_info',$geo_latitude,$geo_longitude,$geo_address,CUSTOM_POST_TYPE1);//display custom fields of organizer
			?><?php if($_SESSION['theme_info']['organizer_logo']!=""){?>
					<input type="hidden" name="orga_logo" value="<?php if($_SESSION['theme_info']['organizer_logo']!=""){echo $_SESSION['theme_info']['organizer_logo'];}?>"/>
			
             <?php 	}
			 global $current_user;	
			if(@$_REQUEST['pid']=='' || $_REQUEST['renew']=='1'){
			 	 $place_price_info = get_event_price_info();
			 	  if($place_price_info && is_more_alive_days($current_user->ID)){ ?>
		 		 <h5 class="form_title"> <?php echo SELECT_PACKAGE_TEXT;?></h5>
				 <?php if($cat_display == 'select'){ ?>
                    <div class="form_row_pkg clearfix">
                        <?php
						$category_array = wp_get_post_terms(@$_REQUEST['pid'],CUSTOM_CATEGORY_TYPE1);
						foreach($category_array as $_cat_array):
							$renewCatId = $_cat_array->term_taxonomy_id;
						endforeach;
						if(isset($_REQUEST['renew'])):
							$catid = $renewCatId;
						else:
						$catExp =  explode(",",@$_REQUEST['category']);
							$catid = $catExp[0];
						endif;
						
						if(!isset($_REQUEST['pid']) && @$_REQUEST['backandedit']):
							$catid = $_SESSION['theme_info']['category'];
						endif;
						
                        if($catid != "")
                        {
                            get_price_info($price_select,$catid,CUSTOM_POST_TYPE1);
						}
                        else
                        {
                            get_price_info(@$price_select,'',CUSTOM_POST_TYPE1);
                        }
                        if(@$cat_array != "")
                        {
                            $catid = $cat_array;
                        }else
                        {
                            $catid = @$_REQUEST['category'];
                        }
                        ?>
                    </div>
			<?php }else{ ?>
			<span id='process2' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span>
			<div class="form_row_pkg clearfix" id="packages_checkbox">
			<?php
			if(isset($_REQUEST['pid']) && isset($_REQUEST['renew']))
			  {
				$cat_array = wp_get_post_terms($_REQUEST['pid'],CUSTOM_CATEGORY_TYPE1);
				foreach($cat_array as $_cat_array)
				 {
					$taxtId .= $_cat_array->term_taxonomy_id."|";
				 }
				get_price_info($price_select,$taxtId,CUSTOM_POST_TYPE1);//fetch price package.
			  }
			if(!$_REQUEST['pid'])
			  {
				if($cat_array !="")
				  {
					$cat_chk = implode("|",$cat_array);
				  }
				if(!isset($catid)){ $catid = ''; }
				if($catid != "")
				  {
				 	get_price_info($price_select,$catid,CUSTOM_POST_TYPE1); 
				  }
				elseif($cat_array !="")
					 {
						get_price_info($price_select,$cat_chk,CUSTOM_POST_TYPE1);
					 }
				else
				 {
				 	if(!isset($price_select)){ $price_select = ''; }
				 	get_price_info($price_select,'',CUSTOM_POST_TYPE1);
				 }
			}?>
			</div>
            <span class="message_error2" id="price_package_error"></span>
			<?php } ?>
			<div class="form_row clearfix" id="is_featured" <?php if(@$is_feature == '0'){ echo "style=display:none;"; } ?>>
					<label><?php echo FEATURED_TEXT; ?> </label>
					<div class="feature_label">
					<label style="clear:both;width:430px;"><input type="checkbox" name="featured_h" id="featured_h" value="0" onclick="featured_list(this.id)" <?php if(@$featured_h !=""){ echo "checked=checked"; } ?>/><?php _e(FEATURED_H,'templatic'); ?> <span id="ftrhome"><?php if(@$featured_h !=""){ echo "(".display_amount_with_currency($featured_h).")"; }else{ echo "(".display_amount_with_currency('0').")"; } ?></span></label>
					<label style="clear:both;width:430px;"><input type="checkbox" name="featured_c" id="featured_c" value="0" onclick="featured_list(this.id)" <?php if(@$featured_c !=""){ echo "checked=checked"; } ?>/><?php _e(FEATURED_C,'templatic'); ?><span id="ftrcat"><?php if(@$featured_c !=""){ echo "(".display_amount_with_currency($featured_c).")"; }else{ echo "(".display_amount_with_currency('0').")"; } ?></span></label>
					
					<input type="hidden" name="featured_type" id="featured_type" value="none"/>
					<span id='process' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span> 
					</div>
					<span class="message_note"><?php echo FEATURED_MSG;?></span>

					<span id="category_span" class="message_error2"></span>
			</div>
			  <div class="form_row clearfix totalprice_asp">
             	<label><?php echo TOTAL_TEXT; ?> <span>*</span> </label>
            	<div class="form_row clearfix">
                <?php 
					if(!isset($total_price)){ $total_price = ''; }
					if(!isset($fprice)){ $fprice = ''; }
				?>
				<?php $currency = fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');
				$position = (get_option('ptttheme_currency_position'));
				if($cat_display == 'select'):
					if(is_array($catid)):
						foreach($catid as $_catid):
							$catid = $_cat_array->term_taxonomy_id;
						endforeach;	
					endif;
				endif;
				?>
				
				 <?php if($position == 'Symbol Before amount'){ echo $currency; }else if($position == 'Space between Before amount and Symbol'){ echo $currency.' '; } ?>
				 <span id="pkg_price"><?php if(isset($price_select) && $price_select !=""){ echo $packprice; } else{ echo "0";}?></span>
				 <?php if($position == 'Symbol After amount'){ echo $currency; }else if($position != 'Symbol Before amount' && $position != 'Space between Before amount and Symbol' && $position !='Symbol After amount'){ echo ' '.$currency; } ?>
				 + 
				 <?php if($position == 'Symbol Before amount'){ echo $currency; }else if($position == 'Space between Before amount and Symbol'){ echo $currency.' '; } ?>
				 <span id="feture_price"><?php if($fprice !=""){ echo $fprice ; }else{ echo "0"; }?></span>
				  <?php if($position == 'Symbol After amount'){ echo $currency; }else if($position != 'Symbol Before amount' && $position != 'Space between Before amount and Symbol' && $position !='Symbol After amount'){ echo ' '.$currency; } ?>
				 = 
				 <?php if($position == 'Symbol Before amount'){ echo $currency; }else if($position == 'Space between Before amount and Symbol'){ echo $currency.' '; } ?>
				 <span id="result_price"><?php if($total_price != ""){ echo $total_price; }else if($catid != ""){  echo $catprice->term_price; }else{ echo "0";} ?></span>
				  <?php if($position == 'Symbol After amount'){ echo $currency; }else if($position != 'Symbol Before amount' && $position != 'Space between Before amount and Symbol' && $position !='Symbol After amount'){ echo ' '.$currency; } ?>
				<?php if(isset($_REQUEST['backandedit'])): ?>
	                <input type="hidden" name="total_price" id="total_price" value="<?php if($total_price != ""){ echo $total_price; }else if($catid != ""){  echo $catprice->term_price; }else{ echo "0";} ?>"/>
                <?php endif; ?>    
				</div>
                <span class="message_note"> </span>
                <span id="category_span" class="message_error2"></span>
            </div>
			 <?php if(get_option('is_allow_coupon_code'))
				  { ?>
			 <h5 class="form_title"><?php echo COUPON_CODE_TITLE_TEXT;?></h5> 
              <div class="form_row clearfix">
             	<label><?php echo PRO_ADD_COUPON_TEXT;?> </label>
				<input type="text" name="proprty_add_coupon" id="proprty_add_coupon" class="textfield" value="<?php echo esc_attr(stripslashes(@$proprty_add_coupon)); ?>" />
				<input class="validate_btn" type="button" name="validate_coupon_code" id="validate_coupon_code" value="<?php _e('Validate','templatic');?>" onclick="return validate_coupon();"  />
				 <span class="message_note"><?php echo COUPON_NOTE_TEXT; ?></span>
				<span style="display:block;margin:5px 0 0 265px;float:left;padding:5px;"  class="success_msg" id="msg_coudon_code"></span>
             </div>
			 <?php }?>
			 <?php }?>
             <?php }?>
			 <script type="text/javascript">
			 function show_value_hide(val)
			 {
			 	document.getElementById('property_submit_price_id').innerHTML = document.getElementById('span_'+val).innerHTML;
			 }
			 </script>
        		
		 <?php $play = get_option('ptthemes_captcha_option');
			if($play == 'WP-reCaptcha')
			{
				 $pcd = explode(',',get_option('ptthemes_recaptcha'));
				  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				  if((in_array('Submit Event Page',$pcd)) && is_plugin_active('wp-recaptcha/wp-recaptcha.php'))
				  {
					echo '<div class="form_row clearfix">';
					$a = get_option("recaptcha_options");
					echo '<label>'.WORD_VERIFICATION.'</label>';
					$publickey = $a['public_key']; // you got this from the signup page
					echo recaptcha_get_html($publickey);
					echo '</div>';
				}
			}
			else
			{?>
			<div class="captcha_container">
				<?php $play = get_option('ptthemes_captcha_option');
				$play_opt = get_option('ptthemes_recaptcha');
				$option = explode(",",$play_opt);
				if(file_exists(ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php')  && $play == 'PlayThru' && in_array('Submit Event Page',$option))
				{
					require_once( ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php');
					require_once(ABSPATH.'wp-content/plugins/are-you-a-human/includes/ayah.php');
					$ayah = ayah_load_library();
					echo $ayah->getPublisherHTML();
				}?>
			</div>
			<?php }?>
			  <input type="submit" name="Update" value="<?php echo PRO_PREVIEW_BUTTON;?>" class="b_review" />
		</form>
		<div class="form_row clearfix"> 
			  	 <span class="message_note"> <?php _e('Note: You will be able to see a preview in the next page','templatic');?>  </span>
		</div>
		<?php } ?>   
</div> <!-- content #end -->

<?php get_sidebar(); ?>



<script language="javascript" type="text/javascript">
function set_login_registration_frm(val)
{
	if(val=='existing_user')
	{
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{
		document.getElementById('contact_detail_id').style.display = '';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}
}
<?php if($user_login_or_not)
{
?>
set_login_registration_frm('<?php echo $user_login_or_not;?>');
<?php
}
?>
var ptthemes_category_dislay = '<?php echo get_option('ptthemes_category_dislay');?>';
</script>
<?php 
$form_fields = array();

$form_fields['category'] = array(
				   'name'	=> 'category',
				   'espan'	=> 'category_span',
				   'type'	=> get_option('ptthemes_category_display'),
				   'text'	=> 'Please select Category',
				   'validation_type' => 'require');
global $wpdb,$custom_post_meta_db_table_name;
$custom_post_meta_db_table_name = $wpdb->prefix."templatic_custom_post_fields";
if(get_option('ptthemes_category_dislay') == 'select'){
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both') and (show_on_page = 'user_side' or show_on_page = 'both_side') and (field_category = '$category_id' or field_category = '0') order by sort_order");
} else {
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both') and (show_on_page = 'user_side' or show_on_page = 'both_side') order by sort_order");
}
while($res = mysql_fetch_array($extra_field_sql)){
	$title = $res['site_title'];
	$name = $res['htmlvar_name'];
	$type = $res['ctype'];
	$require_msg = $res['field_require_desc'];
	$validation_type = $res['validation_type'];
	$form_fields[$name] = array(
				   'title'	=> $title,
				   'name'	=> $name,
				   'espan'	=> $name.'_error',
				   'type'	=> $type,
				   'text'	=> $require_msg,
				   'validation_type' => $validation_type);	
	
}
$validation_info = array();
 foreach($form_fields as $key=>$val)
			{			
				$str = ''; $fval = '';
				$field_val = $key.'_val';
				if(!isset($val['title']))
				   {
					 $val['title'] = '';   
				   }	
				$validation_info[] = array(
											   'title'	=> $val['title'],
											   'name'	=> $key,
											   'espan'	=> $key.'_error',
											   'type'	=> $val['type'],
											   'text'	=> $val['text'],
											   'validation_type'	=> $val['validation_type']);
			}	
include_once(TT_MODULES_FOLDER_PATH.'event/submition_validation.php'); 
?>
</div> <!-- wrapper #end -->
<div id="bottom"></div> 
<script type="text/javascript">
function check_date(str)
{
	if(str =='end_date'){
		if(jQuery("#st_date").val() !=''){
			jQuery("#st_date_error").removeClass("message_error2");
			jQuery("#st_date_error").text("");
		}
			jQuery("#end_date_error").removeClass("message_error2");
			jQuery("#end_date_error").text("");
	}
	
	if(jQuery("#"+str).val() !=''){
		jQuery("#"+str+"_error").removeClass("message_error2");
		jQuery("#"+str+"_error").text("");
	}
}
</script> 
<?php get_footer(); ?>
