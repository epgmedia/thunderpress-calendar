<?php
/**
 * The template used to display Author Archive pages
 *
 * @package WordPress
 * @subpackage Twenty Ten
 * @since 3.0.0
 */
?>
<?php get_header(); ?>
<script>
function showFacebookSetting(val)
{
	if(val == 'show_facebook_setting')
	{
		document.getElementById('hide_fb_fields').style.display = '';
		document.getElementById('edit_fb_fields').style.display = 'none';
		document.getElementById('show_api_fields').style.display = '';
	}
	else if(val == 'hide_facebook_setting')
	{
		document.getElementById('hide_fb_fields').style.display = 'none';
		document.getElementById('edit_fb_fields').style.display = '';
		document.getElementById('show_api_fields').style.display = 'none';
	}
	return true;
}
</script>
<?php
global $current_user,$form_fields_usermeta;
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
?>
  <div id="wrapper" class="clearfix">
            
       <div id="content" class="content_index clearfix">
         <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
        <div class="breadcrumb clearfix">
            <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
        </div>
    <?php } ?>
    <h1><?php echo $curauth->display_name; ?> </h1>
     <!-- It will show the author detail box above the listing - Begin -->   
    <div class="author_details">
    <div class="author_photo">
			<?php if($curauth->user_photo != '') : ?>
			<img src="<?php echo $curauth->user_photo; ?>" width="75" height="75" />
			<?php else : echo get_avatar($curauth->ID, 75 ); endif; ?>
			 <?php 
			  if($current_user->ID == $curauth->ID)
			  {
			   ?>
              <div class="editProfile"><a href="<?php echo get_option('home');?>/?page=profile" ><?php echo PROFILE_EDIT_TEXT;?> </a> </div>
              <?php } ?>
    </div>
	<div class="author_content">
	<div class="agent_biodata">
		<?php if($curauth->user_url){ ?>
                           <?php 
							$website = $curauth->user_url;
							 if(!strstr($website,'http'))
							 {
								 $website = 'http://'.$curauth->user_url;
							 }
							 ?>
                          <span><a href="<?php echo $website; ?>"><?php echo PRO_WEBSITE_TEXT;?> </a></span>
						  <?php } else {
							$website = $curauth->user_web; ?>
						  <span><a href="<?php echo $website; ?>"><?php echo PRO_WEBSITE_TEXT;?> </a></span>
						  <?php }
							global $wpdb,$custom_usermeta_db_table_name;
							$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active = 1 and post_type='registration' and htmlvar_name = 'user_twitter' or htmlvar_name = 'user_facebook' order by sort_order asc,admin_title asc");
							foreach($user_meta_info as $post_meta_info_obj)
							{
							if($post_meta_info_obj->htmlvar_name == 'user_twitter'){
							   $user_twitter = $curauth->user_twitter;
							 if(!strstr(@$website,'http'))
							 {
								 $user_twitter = 'http://'.$curauth->user_twitter;
							 }  ?>
						 <span class="btn_twitter"><a href="<?php echo $user_twitter; ?>"><?php echo PRO_TWITTER_TEXT;?> </a></span><?php }?> 
						 <?php if($post_meta_info_obj->htmlvar_name == 'user_facebook'){
							   $user_facebook = $curauth->user_facebook;
							 if(!strstr($user_facebook,'http'))
							 {
								 $user_facebook = 'http://'.$curauth->user_facebook;
							 } ?>
						 <span class="btn_facebook"><a href="<?php echo $user_facebook; ?>"><?php echo PRO_FACEBOOK_TEXT;?> </a></span><?php } } ?> 
                         <div class="clearfix"></div>
                         <p class="propertylistinglinks clearfix"> 
                         <span class="i_agent_others"><?php echo PRO_PROPERTY_LIST_TEXT;?> : <b>
						 <?php /* Fetch the total post of the user */
							if($curauth->ID)
							{ echo get_authorlisting_evnets($curauth->ID); } ?></b></span></p>
						<?php $user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active = 1 and post_type='registration' and htmlvar_name = 'description' order by sort_order asc,admin_title asc");
							foreach($user_meta_info as $post_meta_info_obj)
							{
								if($post_meta_info_obj->htmlvar_name == 'description'){ ?>
								<p><?php echo $curauth->user_description; ?></p>
								<?php }
							} ?>
   						<?php if($curauth->ID) {
							 $dirinfo = wp_upload_dir();
								$path = $dirinfo['path'];
								$url = $dirinfo['url'];
								$subdir = $dirinfo['subdir'];
								$basedir = $dirinfo['basedir'];
								$baseurl = $dirinfo['baseurl'];
							  if($current_user->ID == $curauth->ID){
									echo get_user_meta($curauth->ID,'user_email',true);
								  }
							 foreach($form_fields_usermeta as $key=> $_form_fields_usermeta)
							  {
								 
								  if($key != 'user_web' && $key != 'description' && $key != 'user_twitter' && $key != 'user_photo' &&  $key != 'user_fname' && $key != 'user_lname' && $key != 'user_email' && $key != 'user_facebook'):
								  	 if(get_user_meta($curauth->ID,$key,true) != ""):
									 if($_form_fields_usermeta['on_profile'] == 1):
									 if($_form_fields_usermeta['type']!='upload') : ?>	  
							 <?php if($_form_fields_usermeta['type']=='multicheckbox'): ?>
											<?php
												$checkbox = '';
												foreach(get_user_meta($curauth->ID,$key,true) as $check):
														$checkbox .= $check.",";
												endforeach; ?>
												<p><label><?php echo $_form_fields_usermeta['label']; ?></label> : <?php echo substr($checkbox,0,-1); 
											?></p>
                                        <?php else: ?>
											<p><label><?php echo $_form_fields_usermeta['label']; ?></label> : <?php echo get_user_meta($curauth->ID,$key,true); ?></p>
											
										<?php endif;
										endif;
										if($_form_fields_usermeta['type']=='upload')
										{?>
										<p><label  style="vertical-align:top;"><?php echo $_form_fields_usermeta['label']." : "; ?></label> <img src="<?php echo get_user_meta($curauth->ID,$key,true);?>" style="width:150px;height:150px" /></p>
										<?php }
										endif;
									endif;
								  endif;
							  }
						}
						?>

                     </div>		
    </div>
 </div>    			 
  <!-- Above will show the author detail box above the listing - end -->   

<div class="tabber">
<ul class="tab">
		<?php 
			//	if($current_user->ID == $curauth->ID)
				{
				?>
				<li <?php if(@$_REQUEST['list']==''){ echo 'class="active" ';}?> >  <a href="<?php echo get_author_posts_url($curauth->ID, $author_nicename = '');?>"> <?php echo PRO_LISTED_EVENT_TEXT;?></a></li>
				
				<?php
					$user_link = get_author_posts_url($curauth->ID, $author_nicename = '');
				?>
				<li <?php if(@$_REQUEST['list']=='attend'){ echo 'class="active" ';}?>>  <a href="<?php if(strstr($user_link,'?') ){echo $user_link.'&amp;list=attend';}else{echo $user_link.'?list=attend';}?>"> <?php echo PRO_ATTEND_EVENT_TEXT;?> </a></li>
				<li <?php if(@$_REQUEST['list']=='facebook_event'){ echo 'class="active" ';}?>>  <a href="<?php if(strstr($user_link,'?') ){echo $user_link.'&amp;list=facebook_event';}else{echo $user_link.'?list=facebook_event';}?>"> <?php echo FACEBOOK_EVENT_TEXT;?> </a></li>
				<?php 
				} ?>
</ul>
</div>
<?php if(have_posts()) : ?>
<ul class="category_list_view" id="widget_index_upcomming_events_id">
<?php if(@$_REQUEST['list']!='facebook_event'){
     while(have_posts()) : the_post();
	$post_images = bdw_get_images_with_info($post->ID,'large');
	$current_post_id = $post->ID; ?> 
    <?php get_the_post_content('author_listing_li');?>
 
    <?php endwhile;
	?>
</ul>
     <?php if (function_exists('pagenavi')) { ?>
        <?php pagenavi('<div class="pagination">  ','</div>'); ?>

      <?php } ?>
	  <?php } else { 
		if(_iscurlinstalled() && $current_user->ID == $curauth->ID){
		?><a id="edit_fb_fields" style="float:right; clear:both;<?php if(get_user_meta($curauth->ID,'appID',true)){?> display:block; <?php } ?>" onclick="return showFacebookSetting('show_facebook_setting');">
			<?php echo SHOW_FACEBOOK_SETTING; ?>
		</a>
		<div id="show_api_fields" <?php if(get_user_meta($curauth->ID,'appID',true)){?> style="display:none;" <?php } ?>>
	  	<table>
			<tr>
				<td>
					<?php _e('AppID','templatic'); ?>:
				</td>
				<td>
					<input type="text" name="appid" id="appid" value="<?php echo get_user_meta($curauth->ID,'appID',true); ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php _e('Secret ID','templatic'); ?>:
				</td>
				<td>
					<input type="text" name="secret_id" id="secret_id" value="<?php echo get_user_meta($curauth->ID,'secret',true); ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<?php _e('Page ID','templatic'); ?>:
				</td>
				<td>
					<input type="text" name="page_id" id="page_id" value="<?php echo get_user_meta($curauth->ID,'pageID',true); ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="submit" id="submit" value="Submit" onclick="return save_FbSetting(<?php echo $curauth->ID; ?>);" />
				</td>
			</tr>
		</table>
		</div>
		
		<div id="hide_fb_fields" style="float:right; clear:both;<?php if(get_user_meta($curauth->ID,'appID',true)){?> display:none; <?php } else { ?>display:block; <?php } ?>" onclick="return showFacebookSetting('hide_facebook_setting');">
			<?php echo HIDE_FACEBOOK_SETTING; ?>
		</div>
		<?php } ?>
		<div id="responsecontainer">
		  <?php $appID = get_user_meta($curauth->ID,'appID',true);
			if(_iscurlinstalled())
			{
				if($appID)
				 facebook_events($curauth->ID); 
				 else { ?>
    				<p class="message" ><?php echo NO_FACEBOOK_EVENT;?> </p> <?php
				}
			}else{
			   _e('CURL is not installed on your server, please enbale CURL to use Facebook evenst API.','templatic');
		    }?>
        </div> 
	<?php  } 
	else :
	if(isset($_REQUEST['list']) && $_REQUEST['list'] == 'attend')
	{
	 ?>
    <p class="message" ><?php echo NO_EVENT_ATTENDED;?> </p> 
	<?php } 
	else
	{
		if($curauth->ID) : ?>
		<p class="message" ><?php echo LISTING_NOT_AVAIL_MSG;?> </p>
		<?php else : ?>
		<p class="message" ><?php echo USER_NO_FACEBOOK_EVENT;?> </p>
		<?php endif; ?>
	<?php } ?>
<?php endif; ?>      
</div> <!-- content #end -->
<div id="sidebar">
<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('event_listing_sidebar'); } ?>
<?php //dynamic_sidebar(6);  ?>
</div>
<div class="clearfix"></div>
 </div> <!-- wrapper #end -->
<div id="bottom"></div>
 <?php get_footer(); ?>
<script>
function save_FbSetting(user_id)
{
var xmlHTTP;
function GetXmlHttpObject()
{
	xmlHTTP=null;
	try
	{
		xmlhttp=new XMLHttpRequest();
	}
	catch (e)
	{
		try
		{
			xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");			
		}
		catch (e)
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	
}

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
	

	var appid = document.getElementById("appid").value;
	var secret_id = document.getElementById("secret_id").value;
	var page_id = document.getElementById("page_id").value;
	  
	var url = "<?php echo get_template_directory_uri(); ?>/ajax_save_fb_setting.php?appid="+appid+"&secret_id="+secret_id+"&page_id="+page_id;
	//xmlhttp.onreadystatechang = handleResponce();

	xmlhttp.onreadystatechange=function()
	{
	   	if(xmlhttp.readyState==4 && xmlhttp.status==200)
	   	{
			document.getElementById("responsecontainer").innerHTML=xmlhttp.responseText;
		}
	} 
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

</script>