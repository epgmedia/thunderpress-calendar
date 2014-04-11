<?php
/*
NAME : EVENT DETAIL PAGE
DESCRIPTION : THIS FILE WILL DISPLAY DATA ON EVENT DETAIL PAGE
*/
get_header(); ?>
<script src="<?php bloginfo('template_directory'); ?>/library/js/add_to_cal.js" type="text/javascript"></script>
<div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >
        <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
        <div class="breadcrumb clearfix">
            <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
        </div>
    <?php } ?>
    
      <h1 class="acenter"><?php the_title(); ?></h1>  
          <div class="views_counter"><?php view_counter($post->ID); 
		  $sep =" , ";
		  echo sprintf(TOTAL_VIEW_COUNT,user_post_visit_count($post->ID));//page tilte filter ?>
		  <?php  echo $sep.user_post_visit_count_daily($post->ID)." ".DAILY_VIEW_COUNT;//page tilte filter  ?>
		  </div>
	
<div class="event_information">      	
    <?php if(@$_REQUEST['send_inquiry']=='success'){?>
        <p class="sucess_msg"><?php echo SEND_INQUIRY_SUCCESS;?></p>
        <?php }elseif(@$_REQUEST['sendtofrnd']=='success'){?>
        <p class="sucess_msg"><?php echo SEND_FRIEND_SUCCESS;;?></p>
        <?php }?>
        <div class="date_info">
         <p>
         <?php if(get_post_meta($post->ID,'st_date',true)){?>
         <span><?php _e('Start Date');?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?> <br />
         <?php }?>
         <?php if(get_post_meta($post->ID,'end_date',true)){?>
        <span><?php _e('End Date');?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?>  <br />
        <?php }?>
        <span><?php _e('Time');?>: </span> <?php 
		echo get_formated_time(get_post_meta($post->ID,'st_time',true))?>
		<?php
        if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
		{
			_e('to ');
		}
		?><?php echo get_formated_time(get_post_meta($post->ID,'end_time',true))?> </p>
		 <p> 
          <?php if(get_post_meta($post->ID,'phone',true)){ ?>
         <span><?php _e('Phone');?>: </span> <?php echo get_post_meta($post->ID,'phone',true);?>  <br /> 
         <?php }?>  
         <?php if(get_post_meta($post->ID,'email',true) && get_option('ptthemes_event_email_on_detailpage')=='Yes'){ ?>           
		<span><?php _e('Email');?>: </span> <?php echo get_post_meta($post->ID,'email',true);?></p>	
         <?php }?>
          </div> 

    <div class="location">
        <?php if(get_post_meta($post->ID,'address',true)){ ?>
        <p><span><?php _e('Location');?>: </span>
        <?php echo get_post_meta($post->ID,'address',true);?></p>
        <?php }
		if(get_post_meta($post->ID,'website',true)){ ?>
        <p><a target="_blank" href="<?php echo get_post_meta($post->ID,'website',true);?>"><?php _e('Website');?></a></p>
        <?php }
		get_add_to_calender();

	/** -- Claim Ownership Begin -- **/			
	global $post,$wpdb,$claim_db_table_name ;
	if(get_option('ptthemes_enable_claim') == 'Yes')
	{
		$claimreq = $wpdb->get_results("select * from $claim_db_table_name where post_id= '".$post->ID."' and status = '1'");
		if(mysql_affected_rows() >0 || get_post_meta($post->ID,'is_verified',true) == 1)
		{
			_e('<p class="i_verfied">Owner Verified Listing</p>','templatic');
		} else { ?>	
		<a href="javascript:void(0);" onclick="show_hide_popup('claim_listing');" title="Claim owenership" class="i_claim c_sendtofriend">
		<?php echo CLAIM_OWNERSHIP; ?></a>
		<?php include_once (TEMPLATEPATH .'/monetize/email_notification/popup_owner_frm.php'); ?>
		<?php include_once (TEMPLATEPATH . '/monetize/email_notification/popup_frms.php');?>    
		<?php include_once (TEMPLATEPATH . '/monetize/email_notification/popup_inquiry_frm.php');?>
	<?php } } 
	/** -- Claim Ownership End -- **/
	
	/** -- Add attended events Featured  End -- **/	 ?>
	</div>
</div>
<!-- Recurring information area BOF -->
<script type="text/javascript">
function show_recurring_event(type)
{
	if(type == 'show')
	{
		document.getElementById("show_recurring").style.display = 'none';
		document.getElementById("hide_recurring").style.display = '';
		document.getElementById("recurring_events").style.display = '';
	}
	else if(type == 'hide')
	{
		document.getElementById("show_recurring").style.display = '';
		document.getElementById("hide_recurring").style.display = 'none';
		document.getElementById("recurring_events").style.display = 'none';
	}
	return true;
}
</script>
<?php
$event_type = get_post_meta($post->ID,'event_type',true);
if(trim(strtolower($event_type)) == trim(strtolower('Recurring event'))){ ?>
<div id="show_recurring"  onclick="return show_recurring_event('show');" ><span><?php _e('Show other occurences','Templatic'); ?></span></div>
<div id="hide_recurring" style="display:none;" onclick="return show_recurring_event('hide');" ><span><?php _e('Hide other occurences','Templatic'); ?></span></div>
	<div id="recurring_events" style="display:none;" class="recurring_info">
	<?php
	echo recurrence_event($post->ID);
	?>
	</div>
<?php } ?>
<!-- Recurring information area EOF -->
 <?php  
	/** -- Add attended events Featured  Begin -- **/
	if(get_option('ptthemes_attending_event') == 'Yes' && $current_user->ID !='' && (trim(strtolower($event_type)) == trim(strtolower('Regular event')) || $event_type == '' ))
		{
	?> <div class="attending_event"> 
	<?php global $post,$wpdb,$claim_db_table_name ;
		
			echo attend_event_html($post->post_author,$post->ID);	  ?>
			<div class="clearfix"></div>
	   </div>  
	<?php  } ?>
<?php
include_once (TEMPLATEPATH . '/monetize/event/event_detail_content.php');

if(get_the_content())
{ ?>
<h3><?php _e('Description');?></h3>
<?php
the_content();	
}else
{
?>
<h3><?php _e('Description');?></h3>
<?php
	echo '<p>'. nl2br($post->post_content).'</p>';	
}?>

<?php $author_info = get_author_info($post->post_author);?>

 <?php echo get_post_meta($post->ID,'video',true);?>         
 <div class="basicinfo">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<?php	global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".CUSTOM_POST_TYPE1."' ) and show_on_detail = 1";
				if(@$fields_name)
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
						if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" ){
							if($post_meta_info_obj->htmlvar_name != "event_name" && $post_meta_info_obj->htmlvar_name != "property_type"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "stdate" && $post_meta_info_obj->htmlvar_name != "enddate" && $post_meta_info_obj->htmlvar_name != "sttime" && $post_meta_info_obj->htmlvar_name != "endtime" && $post_meta_info_obj->htmlvar_name != "email"  && $post_meta_info_obj->htmlvar_name != "address"  && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "property_desc" && $post_meta_info_obj->htmlvar_name != "property_excerpt" && $post_meta_info_obj->htmlvar_name != "phone" && $post_meta_info_obj->htmlvar_name != "video" && $post_meta_info_obj->htmlvar_name != "map_view" && $post_meta_info_obj->htmlvar_name != "reg_desc" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "twitter")
								{
								 if($y == 0):
						 			echo "<h2 class='home'>".EVENT_CUSTOM_INFORMATION."</h2>";
									$y = 1;
								 endif;
								 if($i%2 == 0){?><tr><?php } ?><td>
									<?php
                                    if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
                                        echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
                                    } else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true);
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
                                        	echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
										endif;	
                                    } 
						}?>
					 </td><?php  $i++;
					 }	
					 }
		} ?></table></div>
<h3><?php _e('Organizers','templatic');?></h3>
         <?php if(get_post_meta($post->ID,'organizer_logo',true))
		 {
		 $post_img = get_post_meta($post->ID,'organizer_logo',true); ?>
			<img src="<?php echo $post_img; ?>" style="height:105px;width:105px;" alt="" class="organized_logo"  title=""  />
       <?php } ?>
	  
        	<div class="organized_content" >
              <p class="org_con_mar"><strong class="float"><?php _e('Organized by : ','templatic');?></strong>&nbsp;<?php echo get_post_meta($post->ID,'organizer_name',true);?>
               <?php if(get_post_meta($post->ID,'organizer_address',true)){?>
			   <strong class="float"><?php _e("Organizer's Address : ",'templatic');?></strong><span class="float2"><?php echo get_post_meta($post->ID,'organizer_address',true);?>
              <?php }?></span>
<?php if(get_post_meta($post->ID,'organizer_contact',true)  && get_option('ptthemes_contact_on_detailpage')=='Yes'){?>
<strong class="float"><?php _e('Tel : ','templatic');?></strong><span class="float2"><?php echo get_post_meta($post->ID,'organizer_contact',true);?></span> 
<?php }?>
<?php if(get_post_meta($post->ID,'organizer_mobile',true)){?>
<strong class="float"><?php _e('Mobile : ','templatic');?></strong><span class="float2"><?php echo get_post_meta($post->ID,'organizer_mobile',true);?></span>
<?php }?>
<?php if(get_post_meta($post->ID,'organizer_email',true) && get_option('ptthemes_email_on_detailpage')=='Yes'){?>
<strong class="float"><?php _e('Email : ','templatic');?></strong><span class="float2"><?php echo get_post_meta($post->ID,'organizer_email',true);?></span>
<?php }?>
<?php if(get_post_meta($post->ID,'organizer_website',true)){?>
<strong class="float"><?php _e('Website : ','templatic');?></strong><span class="float2"><a href=" <?php echo get_post_meta($post->ID,'organizer_website',true);?>"><?php echo get_post_meta($post->ID,'organizer_website',true);?></a></span>
<?php }?>
<div class="clearfix"></div></p>
<?php echo get_post_meta($post->ID,'organizer_desc',true);?>
<div class="clearfix"></div>
</p>
<?php if(get_post_meta($post->ID,'organizer_email',true) && get_option('ptthemes_email_on_detailpage')=='Yes'){?>
<a class="b_contact b_send_inquiry" href="javascript:void(0);" onclick="show_hide_popup('basic-modal-content2');" ><?php _e('Contact the Organizer');?></a>
<?php } ?>
</div>
<div class="clearfix"></div>
<div class="basicinfo">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<?php	global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='organizer' ) and show_on_detail = 1";
				if(@$fields_name)
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
						if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" ){
							if($post_meta_info_obj->htmlvar_name != "event_name" && $post_meta_info_obj->htmlvar_name != "property_type"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "stdate" && $post_meta_info_obj->htmlvar_name != "enddate" && $post_meta_info_obj->htmlvar_name != "sttime" && $post_meta_info_obj->htmlvar_name != "endtime" && $post_meta_info_obj->htmlvar_name != "email"  && $post_meta_info_obj->htmlvar_name != "address"  && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "property_desc" && $post_meta_info_obj->htmlvar_name != "property_excerpt" && $post_meta_info_obj->htmlvar_name != "phone" && $post_meta_info_obj->htmlvar_name != "video" && $post_meta_info_obj->htmlvar_name != "map_view" && $post_meta_info_obj->htmlvar_name != "reg_desc" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "twitter")
								{
								 if($y == 0):
						 			echo "<h2 class='home'>".ORGANIZER_CUSTOM_INFORMATION."</h2>";
									$y = 1;
								 endif;
								 if($i%2 == 0){?><tr><?php } ?><td>
									<?php
                                    if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
                                        echo "<div class='i_customlable'><strong><span>".$post_meta_info_obj->site_title.": "."</span></strong>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
                                    } else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true);
											$check = "";
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											echo "<div class='i_customlable'><strong><span>".$post_meta_info_obj->site_title." :"."</span></strong>".$check."</div>";
										else:
                                        	echo "<div class='i_customlable'><strong><span>".$post_meta_info_obj->site_title.": "."</span></strong>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
										endif;	
                                    } 
						}?>
					 </td><?php  $i++;
					 }	
					 }
		} ?></table></div>
		
<?php if(get_post_meta($post->ID,'reg_desc',true)){?>
	<div class="register_msg clearfix" ><?php echo get_post_meta($post->ID,'reg_desc',true);?></div>
<?php }?>
        <div class="event_social_media">
		<?php if (get_option('ptthemes_share') == 'Yes') { ?>
        <div class="addthis_toolbox addthis_default_style">
		<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c873bb26489d97f" class="addthis_button_compact sharethis">
		<img src="<?php bloginfo('template_directory'); ?>/images/i_share.png" alt=""  /></a>
		</div>
		<?php } ?>


		<?php if (get_option('ptthemes_facebook') == 'Yes' && get_post_meta($post->ID,'facebook',true)) { ?>
         <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
        <a href="<?php echo get_post_meta($post->ID,'facebook',true);?>"><img src="<?php bloginfo('template_directory'); ?>/images/i_facebook2.png" alt="facebook"  /></a>
        <?php } ?>
      <?php if (get_option('ptthemes_twitter') == 'Yes' && get_post_meta($post->ID,'twitter',true)) {?>


<img src="<?php bloginfo('template_directory'); ?>/images/i_twitter2.png" alt="twitter"  /></a>
        <?php }  ?>
		<?php if ( get_option('ptthemes_email_on_detailpage') == 'Yes' ) { ?>
        <a href="javascript:void(0);" onclick="show_hide_popup('basic-modal-content');" class="b_sendtofriend"><img src="<?php bloginfo('template_directory'); ?>/images/i_emailtofriend.png" alt="email to friend"  /> </a>
        <?php } ?>     
      </div>        
        <?php the_taxonomies(array('before'=>'<p class="bottom_line"><span class="i_category">','sep'=>'</span><span class="i_tag">','after'=>'</span></p>')); ?>
		<?php if ( get_option('ptthemes_tweet_button') || get_option('ptthemes_facebook_button') ) 
		{ ?>
		<div class="event_bookmark">
        	<?php if ( get_option('ptthemes_tweet_button') ) { ?>
               <a href="http://twitter.com/share" class="twitter-share-button"><?php _e('Tweet');?></a>
             <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>                     
            <?php } ?>             
             <?php if ( get_option('ptthemes_facebook_button') ) { ?>                     
            <iframe class="facebook" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=standard&amp;show_faces=false&amp;width=290&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0"  style="border:none; overflow:hidden; width:290px; height:24px"></iframe> 
              <?php } ?>
		</div>
		<?php } ?>
        <div class="pos_navigation clearfix">
			<div class="post_left fl"><?php previous_post_link('%link',''.__('Previous')) ?></div>
			<div class="post_right fr"><?php next_post_link('%link',__('Next').'') ?></div>
	</div>
    
     <div class="single_post_advt">
	 <?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('event_content_banner'); } ?>
	 </div>
 <?php if ( get_option('default_comment_status') ){ ?>        
 <div id="comments" class="clearfix"> <?php comments_template(); ?></div>
 <?php } ?>   
<?php 
	//get_related_posts($post); 
	get_related_posts($post,CUSTOM_POST_TYPE1,CUSTOM_TAG_TYPE1,CUSTOM_CATEGORY_TYPE1);
?>

</div> <!-- content #end -->


<?php get_sidebar(); ?>
<div style="clear:both;"></div>
</div> <!-- wrapper #end -->
<div id="bottom"></div>
<?php get_footer(); ?>