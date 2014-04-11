<?php 
/*show rating for comment on detail page*/
if(get_option('ptthemes_disable_rating') == 'Yes')
{
}else
{
global $post,$rating_path,$rating_image_on,$rating_image_off,$rating_table_name;
?>
<script type="text/javascript"> 
var RATING_IMAGE_ON = '<?php echo $rating_image_on;?>';
var RATING_IMAGE_OFF = '<?php echo $rating_image_off;?>';
var POSTRATINGS_MAX = '<?php echo POSTRATINGS_MAX;?>';
</script>
<script src="<?php echo $rating_path.'post_rating.js';?>" type="text/javascript"></script>
<?php
	for($i=1;$i<=POSTRATINGS_MAX;$i++)
	{
		if($i==1){$rating_text = $i.' rate';}else{$rating_text = $i.__(' rates');}
		
		echo '<img src="'.$rating_image_off.'" class="rating_img" onmouseover="current_rating_star_on(\''.$post->ID.'\',\''.$i.'\',\''.$rating_text.'\');" onmouseout="current_rating_star_off(\''.$post->ID.'\',\''.$i.'\');" id="rating_'.$post->ID.'_'.$i.'"  alt="" />';							
	}
	echo '<span id="ratings_'.$post->ID.'_text" style="float:left; padding-left:10px; padding-top:6px;" ></span>';
	echo '<input type="hidden" name="post_id" id="post_id" value="'.$post->ID.'" />';
	echo '<input type="hidden" name="post_'.$post->ID.'_rating" id="post_'.$post->ID.'_rating" value="" />';
 	echo '<script type="text/javascript">current_rating_star_on(\''.$post->ID.'\',4,\'4 '.__('rates').'\');</script>';
 //POST RATING 
}
?>
 
