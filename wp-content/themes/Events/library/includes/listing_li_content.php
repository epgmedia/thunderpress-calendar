<?php global $post; ?>
<div class="event_list <?php if(get_post_meta($post->ID,'featured_c',true) == 'c'){?>event_list_featured<?php }?> clearfix">
    <?php if(get_post_meta($post->ID,'featured_c',true) == 'c'  ) { ?><div class="featured_tag"></div><?php }?>
    <?php
	$post_img = bdw_get_images_with_info($post->ID,'thumb');//fetch the event thumb image.
	$thumb = $post_img[0]['file'];
	if ( $thumb != '' ) { ?>
	 <a class="event_img" href="<?php the_permalink(); ?>">
	 <img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
	<?php
	} else { ?> 
	   <!--<a href="<?php echo get_permalink($post->ID); ?>" class="event_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" alt="<?php echo $post_img[0]['alt']; ?>"  width="125" height="75" /></a>-->
	<?php } ?>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ($post->post_type != "post") { ?>
    <p class="date"> <span><?php _e('Start Date','templatic');?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br />  
    <span><?php _e('End Date','templatic');?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br />
    <span><?php _e('Time','templatic');?>: </span> <?php 
	if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
	{
	echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
	}else if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true) =="")
	{
	echo get_formated_time(get_post_meta($post->ID,'st_time',true));
	}else
	{
		echo ' - ';	
	}
	?> </p> 
    <p class="location"> <span><?php echo LOCATION;?> :</span>  <br /> 
    <?php echo get_post_meta($post->ID,'address',true);?> </p> 
	<?php $custom_fields = show_on_listing(CUSTOM_POST_TYPE1,$post->ID);//show all the custom fields
	print_r($custom_fields); ?>
	<?php } ?>
	<?php if ($post->post_type == "post") { ?>
		<p> <?php echo bm_better_excerpt(100, ''); ?></p>
		<?php }?>
    <p class="bottom"><span class="fl"><?php _e('Listed in','templatic');?> 
    <?php the_taxonomies(array('before'=>'','sep'=>'','after'=>'')); ?>
    </span> 
<?php 	if(get_post_meta($post->ID,'address',true) != '' && get_option('ptthemes_category_map_event') == 'Yes' && !is_search()) { ?>
			<a href="#map_canvas"  class="ping" id="pinpoint_<?php echo $post->ID; ?>">&nbsp;<?php _e('Pinpoint','templatic');?></a> <?php } ?>

    <a href="<?php the_permalink(); ?>" class="read_more" > <?php _e('Read More','templatic');?> </a>
     </p>
</div>