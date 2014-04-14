<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/basic.js'></script>
<?php $a = get_option('recaptcha_options'); ?>
<script type="text/javascript">
/* CODE TO ADD THEME SKIN FOR WP-RECAPTCHA PLUGIN */
	var RecaptchaOptions = {
		theme : '<?php echo $a['registration_theme']; ?>',
		lang : '<?php echo $a['recaptcha_language']; ?>'
	};
</script>
<div id="claim_listing" class="clearfix" style="display:none;">
<?php global $post,$wp_query; ?>
<form name="claim_listing_frm" id="claim_listing_frm" action="#" method="post">
 
	<input type="hidden" id="post_id" name="post_id" value="<?php _e($post->ID,'templatic'); ?>"/>
	<input type="hidden" id="request_uri" name="request_uri" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"/>
	<input type="hidden" id="link_url1" name="link_url1" value="<?php	echo the_permalink(); ?>"/>
	<input type="hidden" name="claimer_id" id="claimer_id" value="<?php _e($current_user->ID,'templatic');?>" />
	<input type="hidden" id="author_id" name="author_id" value="<?php echo $post->post_author; ?>" /><input type="hidden" id="author_id" name="author_id" value="<?php echo $post->post_author; ?>" /><input type="hidden" id="post_title" name="post_title" value="<?php echo $post->post_title; ?>" />
	<h3><?php _e('Do you own this business?','templatic'); ?></h3>
	<h4><?php _e('Verify your ownership for '.$post->post_title,'templatic');?></h4><br />
	
			<p id="reply_send_success" class="success_msg" style="display:none;"></p>

			<div class="row  clearfix" ><label><?php _e('Full name','templatic');?> : <span>*</span></label> <input name="owner_full_name" id="owner_full_name" type="text"  /><span id="owner_full_nameInfo"></span></div>
		
		 	<div class="row  clearfix" ><label> <?php _e('Your email','templatic');?> : <span>*</span></label> <input name="owner_email" id="owner_email" type="text"  /><span id="owner_emailInfo"></span></div>
			
			<div class="row  clearfix" ><label> <?php _e('Contact number','templatic');?> :</label> <input name="your_contact_number" id="your_contact_number" type="text"  /></div>	
				
			<div class="row textarea_row  clearfix" >
			<label><?php _e('Your claim','templatic');?> : <span>*</span></label> <textarea name="your_claim" id="your_claim" cols="10" rows="5" ><?php _e('Hello, I would like to notify you that I am the owner of this listing. I would like to verify it&lsquo;s authenticity.','templatic'); ?></textarea><span id="your_claimInfo"></span>
			</div>
			<div id="owner_frm"></div>
			<div class="captcha_container">
			<?php /* CODE TO ADD PLAYTHRU PLUGIN COMPATIBILITY */
			$play = get_option('ptthemes_captcha_option');
			$play_opt = get_option('ptthemes_recaptcha');
			$option = explode(",",$play_opt);
			if(file_exists(ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php')  && $play == 'PlayThru' && in_array('Claim Ownership',$option))
			{
				require_once( ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php');
				require_once(ABSPATH.'wp-content/plugins/are-you-a-human/includes/ayah.php');
				$ayah = ayah_load_library();
				echo $ayah->getPublisherHTML();
			} 
			/* ENF OF CODE */?>
			</div>
			<div class="row  clearfix" >
			<input name="Send" type="submit" value="<?php _e('Submit','templatic')?> " class="button " />
			</div>
</form>
</div>
<?php /* POST THE DATA TO SEND A MAIL */
if($_POST['your_claim'])
{
	/* CHECK IF THE USER HAS INSERTED PROPER CAPTCHA - FOR WP-RECAPTCHA PLUGIN */
	$play = get_option('ptthemes_captcha_option');
	$play_opt = get_option('ptthemes_recaptcha');
			$option = explode(",",$play_opt);
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(is_plugin_active('wp-recaptcha/wp-recaptcha.php')&& $play == 'WP-reCaptcha' &&  in_array('Claim Ownership',$option))
	{
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if ($resp->is_valid )
		{
			echo "<script>alert('Your claim for this post has been sent successfully.');</script>";
			return true;
		}
		else
		{
			echo "<script>alert('Invalid captcha. Please try again.');</script>";
			return false;	
		} 
	}
	/* END OF CODE - CHECK WP-RECAPTCHA */
	$yourname = $_POST['owner_full_name'];
	$youremail = $_POST['owner_email'];
	$c_number = $_POST['your_contact_number'];
	$message = $_POST['your_claim'];
	$post_id = $_POST['post_id'];
	$post_title = $_POST['post_title'];
	$user_id = $current_user->ID;
	$author_id = $_POST['author_id'];
	if($post_id != "")
	{
		$productinfosql = "select ID,post_title from $wpdb->posts where ID ='".$post_id."'";
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo as $productinfoObj)
		{
			$post_title = $productinfoObj->post_title; 
		}
	}
	global $wpdb,$claim_db_table_name ;
	$wpdb->query("INSERT INTO $claim_db_table_name(`clid`, `post_id`, `post_title`, `user_id`, `full_name`, `your_email`, `contact_number`, `author_id`,`status`, `comments`) VALUES (NULL, '".$post_id."', '".$post_title."', '".$user_id."', '".$yourname."', '".$youremail."', '".$c_number."', '".$author_id."', '0', '".$message."')");
	$q = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID=1");
	$to_email = get_option('admin_email');
	$to_name = $q->user_login;
	
	global $General;
	global $upload_folder_path;
	$store_name = get_option('blogname');
	
	$email_subject = "Claim to -".$post_title;
	
	
		$message1 =  __('<p>'.$yourname .' has claim for this post</p>
		<p>Dear admin,</p>
		<p>[#$message#]</p>
		<p>Link : <b>[#$post_title#]</b> </p>
		<p>From, [#$your_name#]</p>','templatic');
		$filecontent_arr1 =$message1;
		$filecontent_arr2 =$filecontent_arr1;
		
		$client_message = $filecontent_arr2;
	
	$subject = $email_subject;
	
	$post_url_link = '<a href="'.$_REQUEST['link_url1'].'">'.$post_title.'</a>';
	$yourname_link = __($youremail,'templatic');
	$search_array = array('[#$to_name#]','[#$post_title#]','[#$message#]','[#$your_name#]','[#$post_url_link#]');
	$replace_array = array($to_name,$post_url_link,$message,$yourname_link,$post_url_link);
	$client_message = str_replace($search_array,$replace_array,$client_message);
	
	/* Instantiate the AYAH object. */
	$play = get_option('ptthemes_captcha_option');
	$play_opt = get_option('ptthemes_recaptcha');
	$option = explode(",",$play_opt);
	if(file_exists(ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php') && $play == 'PlayThru'  &&  in_array('Claim Ownership',$option))
	{
		require_once( ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php');
		require_once(ABSPATH.'wp-content/plugins/are-you-a-human/includes/ayah.php');
		$ayah = new AYAH();

		/* The form submits to itself, so see if the user has submitted the form.
		 Use the AYAH object to get the score. */
		$score = $ayah->scoreResult();
		
		if($score)
		{
			/* send mail */
			templ_sendEmail($youremail,$yourname,$to_email,$to_name,$subject,$client_message,$extra='');
			echo "<script>alert('Your claim for this post has been sent successfully.');</script>";
			return true;
		}
		else
		{
			echo "<script>alert('You need to play the game to send the mail successfully.');</script>";
			return false;
		}
	}
	else
	{
		templ_sendEmail($youremail,$yourname,$to_email,$to_name,$subject,$client_message,$extra='');
		echo "<script>alert('Your claim for this post has been sent successfully.');location.href='".$_REQUEST['link_url']."'</script>";	
	}
} ?>
<script type="text/javascript">
var $q = jQuery.noConflict();
$q(document).ready(function(){

//global vars
	var claimerfrm = $q("#claim_listing_frm");
	var owner_full_name = $q("#owner_full_name");
	var owner_full_nameInfo = $q("#owner_full_nameInfo");
	var owner_email = $q("#owner_email");
	var owner_emailInfo = $q("#owner_emailInfo");	
	var your_claim = $q("#your_claim");
	var your_claimInfo = $q("#your_claimInfo");
	//On blur
	owner_full_name.blur(validate_owner_full_name);
	owner_email.blur(validate_owner_email);

	your_claim.blur(validate_your_claim);
	

	//On Submitting

	claimerfrm.submit(function(){

		if(validate_owner_full_name() & validate_owner_email() & validate_your_claim() )
		{ 
			return true;
		}
		else
		{ 
			return false;
		}

	});
	//validation functions
	function validate_owner_full_name()
	{
		if(owner_full_name.val() == '')
		{
			owner_full_name.addClass("error");
			owner_full_nameInfo.text("<?php _e('Please enter your full name','templatic');?>");

			owner_full_nameInfo.addClass("message_error2");

			return false;
		}
		else{
			owner_full_name.removeClass("error");
			owner_full_nameInfo.text("");
			owner_full_nameInfo.removeClass("message_error2");

			return true;

		}

	}
	function validate_owner_email()
	{ 
		var isvalidemailflag = 0;
		if(owner_email.val() == '')
		{
			isvalidemailflag = 1;
		}else {
			if(owner_email.val() != '')
			{
				var a = owner_email.val();

				var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

				//if it's valid owner_email

				if(filter.test(a)){

					isvalidemailflag = 0;

				}else{

					isvalidemailflag = 1;	

				}
			}
		}
		if(isvalidemailflag == 1)
		{
			owner_email.addClass("error");

			owner_emailInfo.text("<?php _e('Please enter your valid email address','templatic');?>");

			owner_emailInfo.addClass("message_error2");

			return false;

		}else
		{
			owner_email.removeClass("error");

			owner_emailInfo.text("");

			owner_emailInfo.removeClass("message_error");

			return true;

		}
	}
	function validate_your_claim()
	{
		if($q("#your_claim").val() == '')

		{
			your_claim.addClass("error");

			your_claimInfo.text("<?php _e('Please enter your claim','templatic');?>");

			your_claimInfo.addClass("message_error2");

			return false;
		}else{

			your_claim.removeClass("error");

			your_claimInfo.text("");

			your_claimInfo.removeClass("message_error2");

			return true;

		}

	}
});
</script>