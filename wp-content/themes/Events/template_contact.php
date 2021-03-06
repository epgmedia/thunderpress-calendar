<?php
/*
Template Name: Template - Contact Us
*/
?>
<?php
	if($_POST)
	{
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$play = get_option('ptthemes_captcha_option');
			$play_opt = get_option('ptthemes_recaptcha');
			$option = explode(",",$play_opt);
			if(file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && is_plugin_active('wp-recaptcha/wp-recaptcha.php') && $play == 'WP-reCaptcha' && in_array("Contact Us Page",$option)) {
				require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
				$a = get_option("recaptcha_options");
				$privatekey = $a['private_key'];
	  						$resp = recaptcha_check_answer ($privatekey,
	                                getenv("REMOTE_ADDR"),
	                                $_POST["recaptcha_challenge_field"],
	                                $_POST["recaptcha_response_field"]);
									
				if (!$resp->is_valid ) {
					wp_redirect($_REQUEST['request_url'].'/?ecptcha=captch');
					exit;
				} 
			}	
		if($_POST['your-email'])
		{
			$toEmailName = get_option('blogname');
			$toEmail = get_site_emailId();
			//echo get_option('admin_email');
			$subject = $_POST['your-subject'];
			$message = '';
			$message .= '<p>'.DEAR.$toEmailName.',</p>';
			$message .= '<p>'.NAME.' : '.$_POST['your-name'].',</p>';
			$message .= '<p>'.EMAIL.' : '.$_POST['your-email'].',</p>';
			$message .= '<p>'.MESSAGE.' : '.nl2br($_POST['your-message']).'</p>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			// Additional headers
			$headers .= 'To <'.$toEmail.">\r\n";
			$headers .= 'From <'.$fromemail1.">\r\n";
			// Instantiate the AYAH object.
			$play = get_option('ptthemes_captcha_option');
			$play_opt = get_option('ptthemes_recaptcha');
			$option = explode(",",$play_opt);
			if(file_exists(ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php') && $play == 'PlayThru'  && $message && in_array("Contact Us Page",$option))
			{
				require_once( ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php');
				require_once(ABSPATH.'wp-content/plugins/are-you-a-human/includes/ayah.php');
				$ayah = new AYAH();

				// The form submits to itself, so see if the user has submitted the form.
				// Use the AYAH object to get the score.
				$score = $ayah->scoreResult();
				
				if($score)
				{
					// Mail it
					@mail($toEmail, $subject, $message, $headers);
					// Add code to process the form.
					echo "<br/>Hello ".$toEmailName.", Messege sent successfully!";
				}
				else
				{
					echo "<br/>Please try again!";
				}
			}
			elseif(!is_plugin_active('are-you-a-human/areyouahuman.php') || is_plugin_active('wp-recaptcha/wp-recaptcha.php'))
			{
				// Mail it
					@mail($toEmail, $subject, $message, $headers);
			}
			
			if(strstr($_REQUEST['request_url'],'?'))
			{
				if(strstr($_REQUEST['request_url'],'?ecptcha'))
				{
					 $contact_url = explode("?", $_REQUEST['request_url']);
					  $url = $contact_url[0]."?msg=success";
				}
				else
					$url =  $_REQUEST['request_url'].'&msg=success'	;	
			}else
			{
				$url =  $_REQUEST['request_url'].'?msg=success'	;
			}
			echo "<script type='text/javascript'>location.href='".$url."';</script>";
		}
	}
	
	
	?>
<?php get_header(); ?>

<div id="wrapper" class="<?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
	<div id="content">
	<?php 
	
	if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
		
	 <?php $a = get_option('recaptcha_options'); ?>
	  <script type="text/javascript">
			 var RecaptchaOptions = {
				theme : '<?php echo $a['registration_theme']; ?>',
				lang : '<?php echo $a['recaptcha_language']; ?>'
			 };
	  </script>
	
	
	<div class="title-container">
	    <h1 class="title_green"><span><?php echo CONTACT_US; ?></span></h1>
	    <div class="clearfix"></div>
	</div>
	
	<!--  CONTENT AREA START -->
	
	<!-- contact -->
	<?php global $is_home; ?>
	<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	
	<div class="entry cont_us">
	  <div id="post_<?php the_ID(); ?>">
	    <div class="post-content">
	      <?php the_content(); ?>
	    </div>
		<?php
		if($_REQUEST['msg'] == 'success')
		{
		?>
			<p class="success_msg">
			  <?php echo CONTACT_SUCCESS_TEXT;?>
			</p>
			<?php
		}
		?>
	    <?php dynamic_sidebar('contact-widget'); ?>
	    <div class="graybox">
			<?php dynamic_sidebar('contact-google'); ?>
		</div>
	    
	  </div>
	</div>
	<?php endwhile; ?>
	<?php endif; ?>

	<?php  if(isset($_REQUEST['ecptcha']) == 'captch') {
		$a = get_option("recaptcha_options");
		$blank_field = $a['no_response_error'];
		$incorrect_field = $a['incorrect_response_error'];
		echo '<div class="error_msg">'.$incorrect_field.'</div>';
		}?>
	
	
	<form action="<?php echo get_permalink($post->ID);?>" method="post" id="contact_frm" name="contact_frm" class="wpcf7-form">
		<div>
	      <input type="hidden" name="request_url" value="<?php echo $_SERVER['REQUEST_URI'];?>" />
	      <div class="form_row clearfix">
	        <label>
	          <?php _e('Name','templatic');?>
	          <span class="indicates">*</span></label>
	        <input type="text" name="your-name" id="your-name" value="" class="textfield" size="40" />
	        <span id="your_name_Info" class="error"></span> </div>
            
	      <div class="form_row clearfix">
	        <label>
	          <?php _e('Email','templatic');?>
	          <span class="indicates">*</span></label>
	        <input type="text" name="your-email" id="your-email" value="" class="textfield" size="40" />
	        <span id="your_emailInfo"  class="error"></span> </div>
            
	      <div class="form_row clearfix">
	        <label>
	          <?php _e('Subject','templatic');?>
	          <span class="indicates">*</span></label>
	        <input type="text" name="your-subject" id="your-subject" value="" size="40" class="textfield" />
	        <span id="your_subjectInfo" class="error"></span> </div>
            
	      <div class="form_row clearfix">
	        <label>
	          <?php _e('Message','templatic');?>
	          <span class="indicates">*</span></label>
	        <textarea name="your-message" id="your-message" cols="40" class="textarea textarea2" rows="10"></textarea>
	        <span id="your_messageInfo"  class="error"></span>
	      </div>
          
	      <div class="form_row clearfix">
		<?php $play = get_option('ptthemes_captcha_option');
			$play_opt = get_option('ptthemes_recaptcha');
			$option = explode(",",$play_opt);
			if($play == 'WP-reCaptcha')
			{
				//$pcd = explode(',',get_option('ptthemes_contact_captcha'));
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if(is_plugin_active('wp-recaptcha/wp-recaptcha.php') && in_array("Contact Us Page",$option))
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
			<?php	// Use the AYAH object to get the HTML code needed to
				// load and run the PlayThru�.
				$play_opt = get_option('ptthemes_recaptcha');
				$option = explode(",",$play_opt);
				if(file_exists(ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php')  && $play == 'PlayThru' && in_array("Contact Us Page",$option))
				{
					require_once( ABSPATH.'wp-content/plugins/are-you-a-human/areyouahuman.php');
					require_once(ABSPATH.'wp-content/plugins/are-you-a-human/includes/ayah.php');
					$ayah = ayah_load_library();
					echo $ayah->getPublisherHTML();
				}?>
			</div>
			<?php }?>
	       </div> 
	      <input type="submit" value="Send" class="b_submit" />
		</div>
	    
	</form>
	<script type="text/javascript">
	var $c = jQuery.noConflict();
	$c(document).ready(function(){
	
		//global vars
		var enquiryfrm = $c("#contact_frm");
		var your_name = $c("#your-name");
		var your_email = $c("#your-email");
		var your_subject = $c("#your-subject");
		var your_message = $c("#your-message");
		
		var your_name_Info = $c("#your_name_Info");
		var your_emailInfo = $c("#your_emailInfo");
		var your_subjectInfo = $c("#your_subjectInfo");
		var your_messageInfo = $c("#your_messageInfo");
		
		//On blur
		your_name.blur(validate_your_name);
		your_email.blur(validate_your_email);
		your_subject.blur(validate_your_subject);
		your_message.blur(validate_your_message);
	
		//On key press
		your_name.keyup(validate_your_name);
		your_email.keyup(validate_your_email);
		your_subject.keyup(validate_your_subject);
		your_message.keyup(validate_your_message);
		
		
	
		//On Submitting
		enquiryfrm.submit(function(){
			if(validate_your_name() & validate_your_email() & validate_your_subject() & validate_your_message())
			{
				hideform();
				return true
			}
			else
			{
				return false;
			}
		});
	
		//validation functions
		function validate_your_name()
		{
			
			if($c("#your-name").val() == '')
			{
				your_name.addClass("error");
				your_name_Info.text("<?php _e('Please enter your name','templatic'); ?>");
				your_name_Info.addClass("message_error");
				return false;
			}
			else
			{
				your_name.removeClass("error");
				your_name_Info.text("");
				your_name_Info.removeClass("message_error");
				return true;
			}
		}
	
		function validate_your_email()
		{
			var isvalidemailflag = 0;
			if($c("#your-email").val() == '')
			{
				isvalidemailflag = 1;
			}else
			if($c("#your-email").val() != '')
			{
				var a = $c("#your-email").val();
				var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
				//if it's valid email
				if(filter.test(a)){
					isvalidemailflag = 0;
				}else{
					isvalidemailflag = 1;	
				}
			}
			
			if(isvalidemailflag)
			{
				your_email.addClass("error");
				your_emailInfo.text("<?php _e('Please enter valid email address','templatic'); ?>");
				your_emailInfo.addClass("message_error");
				return false;
			}else
			{
				your_email.removeClass("error");
				your_emailInfo.text("");
				your_emailInfo.removeClass("message_error");
				return true;
			}
		}
	
		
	
		function validate_your_subject()
		{
			if($c("#your-subject").val() == '')
			{
				your_subject.addClass("error");
				your_subjectInfo.text("<?php _e('Please enter a subject','templatic'); ?>");
				your_subjectInfo.addClass("message_error");
				return false;
			}
			else{
				your_subject.removeClass("error");
				your_subjectInfo.text("");
				your_subjectInfo.removeClass("message_error");
				return true;
			}
		}
	
		function validate_your_message()
		{
			if($c("#your-message").val() == '')
			{
				your_message.addClass("error");
				your_messageInfo.text("<?php _e('Please enter your message','templatic'); ?>");
				your_messageInfo.addClass("message_error");
				return false;
			}
			else{
				your_message.removeClass("error");
				your_messageInfo.text("");
				your_messageInfo.removeClass("message_error");
				return true;
			}
		}
	
	});
	</script>
	<!--  CONTENT AREA END -->
	</div>

<?php get_sidebar(); ?>
<div class="clearfix"></div>
</div>
<div id="bottom"></div>
<?php get_footer(); ?>