<?php
$_SESSION['userinset_error'] = '';
/* file is called when user submit a form when he is logged off */
if($_POST && !$userInfo)
{
	if (  $_SESSION['theme_info']['user_email'] == '' )
	{
		$error =  __('Email for Publisher Information is Empty. Please enter Email, your all informations will sent to your Email.','templatic');	
		$_SESSION['userinset_error'] = $error;
		wp_redirect(home_url().'?ptype=post_event&backandedit=1&usererror=1');
		exit;
	}
	
	require( 'wp-load.php' );
	require(ABSPATH.'wp-includes/registration.php');
	
	global $wpdb;
	$errors = new WP_Error();
	
	$user_email = $_SESSION['theme_info']['user_email'];
	$user_login = $user_email;	
	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );
	
	// Check the username
	if ( $user_login == '' )
	{
		$errors->add('empty_username', __('ERROR: Please enter a username.','templatic'));
	}
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.','templatic'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
	{
		$errors->add('username_exists', __('<strong>ERROR</strong>: '.$user_email.' This username is already registered, please choose another one.','templatic'));
	}

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.','templatic'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.','templatic'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
	{
		$errors->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.','templatic'));
	}

	do_action('register_post', $user_login, $user_email, $errors);	
	
	$errors = apply_filters( 'registration_errors', $errors );
	if($errors)
	{
		$_SESSION['userinset_error'] = array();
		foreach($errors as $errorsObj)
		{
			foreach($errorsObj as $key=>$val)
			{
				for($i=0;$i<count($val);$i++)
				{
					$usererror .= $val[$i].'<br />';
					if($val[$i]){break;}
				}
			} 
		}
		$_SESSION['userinset_error'] = $usererror;
	}	
	if ( $errors->get_error_code() )
	{
		$_SESSION['userinset_error'] = $error;
		wp_redirect(home_url().'?ptype=post_event&backandedit=1&usererror=1');
		exit;
	}
		
	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		exit;
	}
	
	$user_fname = $_SESSION['theme_info']['user_fname'];
	$user_city = $_SESSION['theme_info']['user_city'];
	$user_state = $_SESSION['theme_info']['user_state'];
	$user_phone = $_SESSION['theme_info']['user_phone'];
	$user_twitter = $_SESSION['theme_info']['user_twitter'];
	$user_photo = $_SESSION['theme_info']['user_photo'];
	$description = $_SESSION['theme_info']['description'];
	$user_web = $_SESSION['theme_info']['user_web'];
	$userName = $_SESSION['theme_info']['user_fname'];
	$user_lname = $_SESSION['theme_info']['user_lname'];
	$user_add1 = $_SESSION['theme_info']['user_add1'];
	$user_add2 = $_SESSION['theme_info']['user_add2'];
	$user_web = $_SESSION['theme_info']['user_web'];
	$user_postalcode = $_SESSION['theme_info']['user_postalcode'];
	$user_nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$user_login));
	$user_nicename = get_user_nice_name($user_fname,''); //generate nice name
	$user_nicename = get_user_nice_name($user_fname); //generate nice name
	$user_address_info = array(
							"user_city"		=> $user_city,
							"user_state"	=> $user_state,
							"user_phone" 	=> $user_phone,
							"user_twitter"	=> $user_twitter,	
							"description"	=> addslashes($description),
							"user_photo"	=> $user_photo,
							"user_lname"	=> $user_lname,
							"user_add1"	=> $user_add1,
							"user_add2"	=> $user_add2,
							"user_web"	=> $user_web,
							"user_postalcode"	=> $user_postalcode,
							"first_name"	=>	$_SESSION['theme_info']['user_fname'],
							);
		foreach($user_address_info as $key=>$val)
		{
			update_user_meta($user_id, $key, $val); // User Address Information Here
		}
		$updateUsersql = "update $wpdb->users set user_nicename=\"$user_nicename\" , display_name=\"$user_fname\"  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
	
	if ( $user_id) 
	{
		///////REGISTRATION EMAIL START//////
		$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();
		$store_name = get_option('blogname');
		$clientdestinationfile =  stripslashes(get_option('registration_success_email_content'));
		
		if(!$clientdestinationfile && $clientdestinationfile=="")
		{
			$client_message = REGISTRATION_EMAIL_DEFAULT_TEXT;
			$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
			$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
			$subject = $filecontent_arr2[0];
			$client_message = $filecontent_arr2[1];
		}else
		{
			$client_message = $clientdestinationfile;
		}
		if($subject == '')
		{
			$subject = "Registration Email";
		}
		
		$store_login = get_option('siteurl').'/?page=login';
		$store_login_link = '<a href="'.$store_login.'">'.__('Login').'</a>';
		/////////////customer email//////////////
		$search_array = array('[#user_name#]','[#user_login#]','[#user_password#]','[#site_name#]','[#site_login_url#]','[#site_login_url_link#]');
		$replace_array = array($_POST['user_fname'],$user_login,$user_pass,$store_name,$store_login,$store_login_link);
		$client_message = str_replace($search_array,$replace_array,$client_message);	
		sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');///To clidne email
		//////REGISTRATION EMAIL END////////
	}
	$current_user_id = $user_id;
}
?>