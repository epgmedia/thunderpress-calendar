<?php global $post; 
/* author dashboard page*/
?>
<script type="text/javascript">
function showRecurringEvent(post_id,display)
{
	if(display == 'show')
	{
		document.getElementById(post_id).style.display = '';
		document.getElementById(post_id+'_hide').style.display = '';
		document.getElementById(post_id+'_show').style.display = 'none';
	}
	if(display == 'hide')
	{
		document.getElementById(post_id).style.display = 'none';
		document.getElementById(post_id+'_hide').style.display = 'none';
		document.getElementById(post_id+'_show').style.display = '';
	}
	return true;
}
</script>
<div class="event_list <?php if(get_post_meta($post->ID,'featured_type',true) != 'none'){?>event_list_featured<?php }?>clearfix">
    <?php if(get_post_meta($post->ID,'featured_type',true) != 'none'){?><div class="featured_tag"> </div><?php }?>
    <?php
	$post_img = bdw_get_images_with_info($post->ID,'thumb');//fetch the event thumb image.
	$thumb = $post_img[0]['file'];
	if ( $thumb != '' ) { ?>
	 <a class="event_img" href="<?php the_permalink(); ?>" >
	 <img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
	<?php
	} else { ?> 
	   <a href="<?php echo get_permalink($post->ID); ?>" class="event_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" alt="<?php echo $post_img[0]['alt']; ?>"  width="125" height="75" /></a>
	<?php } ?>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p class="date"> <span><?php _e('Start Date','templatic');?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br />  
    <span><?php _e('End Date','templatic');?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br />
    <span><?php _e('Time','templatic');?>: </span> <?php 
	if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
	{
	echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));	
	}else
	{
		echo ' - ';	
	}
	
	?> </p> 
	<?php $location = get_post_meta($post->ID,'address',true); 
	if($location){ ?>
    <p class="location"> <span><?php echo LOCATION;?>: </span>  <br /> 
    <?php echo get_post_meta($post->ID,'address',true);?>
    <?php  global $current_user; if($current_user->ID == $post->post_author){?>
    <br /> <br />
    <span class="author_link"> 
        <?php
        if(get_time_difference( $post->post_date, $post->ID ))
		{
		?>
        <a href="<?php echo get_option('home');?>/?ptype=post_event&pid=<?php echo $post->ID;?>"><?php echo EDIT_TEXT;?></a> | 
        <?php	
		}else
		{
		?>
        <a href="<?php echo get_option('home');?>/?ptype=post_event&renew=1&pid=<?php echo $post->ID;?>"><?php echo RENEW_TEXT;?></a> |
		<?php
		}
		?>
        <a href="<?php echo get_option('home');?>/?ptype=preview&pid=<?php echo $post->ID;?>"><?php echo DELETE_TEXT;?></a> </span>  
       <?php }?>
    </p>
	<?php }
		$event_type = get_post_meta($post->ID,'event_type',true);
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring event')) && $_REQUEST['list'] == 'attend'){ ?>
	<p>
		<div onclick="return showRecurringEvent(<?php echo $post->ID ?>,'show')" id="<?php echo $post->ID ?>_show" class="show_rec_ev"><span>show recurring event</span></div>
		<div onclick="return showRecurringEvent(<?php echo $post->ID ?>,'hide')" id="<?php echo $post->ID ?>_hide" style="display:none;" class="show_rec_ev"><span>hide recurring event</span></div>
		<div class="column_recurring" id="<?php echo $post->ID ?>" style="display:none;">
			<ul>
			<?php
				$get_st_date = get_user_meta($post->post_author,'user_attend_event_st_date');
				$get_end_date = get_user_meta($post->post_author,'user_attend_event_end_date');
				for($i=0;$i<count($get_st_date[0]);$i++)
				{
					$get_post_id = explode("_",$get_st_date[0][$i]);
					$get_post_end_date = explode("_",$get_end_date[0][$i]);
					if($post->ID == $get_post_id[0])
					{?>
							<li>
								<div class='date_info'>
									<p>
								  		<span><?php _e('Date','templatic'); ?>:</span>  <?php echo  $get_post_id[1]; ?>
										 <?php _e('to','templatic');?> <?php echo $get_post_end_date[1]; ?> <br/>
										<span>Time  : </span> <?php  echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true)); ?>
									</p>
								</div>
								<div class="clearfix"></div>
							</li>
					<?php
					}
				}
				?>
				
			</ul>
			<div class="clearfix"></div>
		</div>
	</p>
	<?php }
	?>
    <p class="bottom"><span class="fl"><?php _e('Listed in','templatic');?> 
    <?php the_taxonomies(array('before'=>'','sep'=>'','after'=>'')); ?>
    </span> 
    <a href="<?php the_permalink(); ?>" class="read_more" > <?php _e('Read More','templatic');?> </a></p>
	<div class="clearfix"></div>
</div>