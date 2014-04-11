<?php get_header(); ?>

<div id="wrapper" class="clearfix">
         	<div id="content" class="clearfix" >
            	
                
                 <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?>
                <div class="breadcrumb clearfix">
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
                </div>
            <?php } ?>
              <?php if (is_paged()) $is_paged = true; ?>
            	 <?php if (is_search()) { ?>
                   <?php if($_REQUEST['s']=='Calender-Event'){
					   global $wpdb,$wp_query;
						$m = $wp_query->query_vars['m'];
						$py = substr($m,0,4);
						$pm = substr($m,4,2);
						$pd = substr($m,6,2);
						$the_req_date = "$py-$pm-$pd";
					   ?>
                   <h1><?php echo date('F jS, Y',strtotime($the_req_date)); ?></h1>
                   <?php }else{?>
                    <h1 class="cat_head" ><?php _e('Search Result','templatic');?> <?php if(isset($_REQUEST['skw']) && $_REQUEST['skw']!=''){   _e(" for: ".$_REQUEST['skw'],"templatic");  }?></h1>
                    <?php }?>
                    <?php } ?>
                    
<div class="event_type">
<?php
	foreach($_REQUEST as $key=>$value)
	{
		if($key!='paged')
			$str.=$key."=".$value."&";	
	}	
	$permalink=get_bloginfo('url')."?". substr($str,0,-1);	
	$URI= $permalink;
	$event_type_=trim($_REQUEST['event_type']);
	if($event_type_ =='recurring'){ $rec_active ='current'; }else{   $reg_active ='current'; }
	$URI=str_replace('&event_type=recurring','',$URI);
?>
     <a href="<?php echo $URI; ?>&event_type=regular"  class="event_type <?php echo $reg_active?>"><?php _e('Regular Events',T_DOMAIN); ?></a>
     <a href="<?php echo $URI; ?>&event_type=recurring"  class="event_type <?php echo $rec_active;?>"><?php _e('Recurring Events',T_DOMAIN); ?></a>
</div>
 
 <ul class="category_list_view">


			<?php if(have_posts()) : ?>
 			<?php while(have_posts()) : the_post() ?>
		  <?php $post_images =  bdw_get_images_with_info($post->ID,'large');?>
           <?php get_the_post_content('listing_li')?>
          <?php endwhile; ?>
      
      </ul>
      
      
      <?php if (function_exists('pagenavi')) { ?>
        <?php pagenavi('<div class="pagination">  ','</div>'); ?>

      <?php } ?>
      <?php else: ?>
      <p class="notice_msg"><?php _e( 'Sorry, but nothing matched your search criteria. <br /> Please try again with some different criteria.','templatic'); ?></p>
      <?php endif; ?>
			 
      </div> <!-- content #end -->
        
        
		
         
         
         <div id="sidebar">
		 <?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('content_sidebar'); } ?>
	<?php //dynamic_sidebar(5);  ?>
</div> <!-- sidebar right--> 

</div> <!-- wrapper #end -->
<div id="bottom"></div>		
<?php get_footer(); ?>
