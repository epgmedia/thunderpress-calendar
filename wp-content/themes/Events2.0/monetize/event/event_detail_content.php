<?php
/*
NAME : FILE TO DISPLAY MAP AND IMAGE GALLERY ON EVENT DETAIL PAGE
DESCRIPTION : THIS FILE WILL DISPLAY GOOGLE MAP AND IMAGE GALLERY ON EVENT DETAIL PAGE DEPENDING UPON THE OPTION SELECTED IN BACK END.
*/
$gallery_map_flag = get_option('ptthemes_detail_gallery_map_flag');
if($gallery_map_flag == 'Hide Both')
{
}
else
{
	if($gallery_map_flag == 'Map & Gallery Both - Default Map' || $gallery_map_flag == 'Map & Gallery Both - Default Gallery')
	{ ?> 
	<script type="text/javascript">
	function show_hide_tabs(type)
	{
		if(type == 'map')
		{
			document.getElementById('pikachoose').style.display = 'none';
			document.getElementById('detail_google_map_id').style.visibility='visible';
			document.getElementById('detail_google_map_id').style.height='auto';
			document.getElementById('li_location_map').className = 'active';
			document.getElementById('li_image_gallery').className = '';
		} else if (type == 'gallery')
		{
			document.getElementById('pikachoose').style.display = 'block';
			document.getElementById('detail_google_map_id').style.visibility='hidden';
			document.getElementById('detail_google_map_id').style.height='0';
			document.getElementById('li_location_map').className = '';
			document.getElementById('li_image_gallery').className = 'active';
		}
	}
	</script>     
	<div class="tabber">
	 <ul class="tab">
		<li id="li_location_map" <?php if( $gallery_map_flag == 'Map & Gallery Both - Default Map'){ echo 'class="active"'; }?>> <a href="javascript:void(0):" onclick="show_hide_tabs('map');"><?php _e('Location Map');?></a></li>
		<li id="li_image_gallery" <?php if( $gallery_map_flag == 'Map & Gallery Both - Default Gallery') { echo 'class="active"'; }?> > <a href="javascript:void(0):" onclick="show_hide_tabs('gallery');"><?php _e('Image Gallery');?></a></li>
		<?php if (get_option('ptthemes_print') == 'Yes' ) { ?>
		<li class="fr" > <a href="#" onclick="window.print();return false;" class="i_print"><?php _e('Print');?></a></li>
		<?php } ?>
	 </ul>
	</div>
	<?php }
	if($gallery_map_flag == 'Map & Gallery Both - Default Gallery' || $gallery_map_flag == 'Gallery Only' || $gallery_map_flag = 'Map & Gallery Both - Default Map')
	{ ?>        
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.pikachoose.js"></script>
	
	<script language="javascript" type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(
		function (){
			jQuery("#pikame").PikaChoose();
		});
	</script>
	<div class="pikachoose" id="pikachoose" <?php if($gallery_map_flag == 'Map & Gallery Both - Default Gallery' || $gallery_map_flag == 'Gallery Only'){ } else { echo 'style="display:none;"'; }?> >
	<?php $post_img = bdw_get_images_with_info($post->ID,'large'); ?>
	<?php if(count($post_img) > 0) { ?>
	<ul id="pikame" class="jcarousel-skin-pika">
	<?php
		foreach ($post_img as $thumb)
		{
		?>
	   <li>
			<img src="<?php echo $thumb['file'];?>" alt="" width="70px" height="60px"/>
		</li>
	<?php }
		?>	
		   </ul>
	<?php }
	else
	{ ?>
		<!-- <a href="<?php echo get_permalink($post->ID); ?>" class="event_img"><img src="<?php echo get_template_directory_uri()."/images/no-image_full.jpg"; ?>" alt="<?php echo $post_img[0]['alt']; ?>" /></a> -->
	<?php } ?>       
	</div>
	<?php }
	if($gallery_map_flag == 'Map & Gallery Both - Default Map' || $gallery_map_flag == 'Map & Gallery Both - Default Gallery' || $gallery_map_flag == 'Map Only' )
	{ ?> 
	<div class="google_map" id="detail_google_map_id" style="<?php if($gallery_map_flag == 'Map Only'){ echo 'width:593px; height:400px;'; } if($gallery_map_flag == 'Map & Gallery Both - Default Map' || $gallery_map_flag == 'Map Only' ){ } else { echo ' visibility:hidden;height:0'; }?>" > 
	<?php 
	$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
	$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
	$map_type = get_post_meta($post->ID,'map_view',true);
	include_once (TEMPLATEPATH . '/library/map/google_map_detail.php');?> 
	</div>  <!-- google map #end -->
	<?php } ?>
<?php }?>