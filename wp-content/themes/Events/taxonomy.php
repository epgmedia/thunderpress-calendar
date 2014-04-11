<?php
/*
NAME : TAXONOMY TABBER
DESCRIPTIPN : THIS FILE CREATES TABBER FOR UPCOMING, CURRENT AND PAST EVENTS ON EVENT DETAIL PAGE
*/
get_header(); 
if(get_option('ptthemes_category_map_event') == 'Yes' || get_option('ptthemes_category_map_event') == ''){
	if(file_exists(TEMPLATEPATH . '/library/map/category_listing_map.php')){
		include_once (TEMPLATEPATH . '/library/map/category_listing_map.php');
	}
	$map_display_category = 'no';
	global $map_display_category;
}  else {
	$map_display_category = 'yes';
	global $map_display_category;
}
global $wp_query,$post;
$current_term = $wp_query->get_queried_object();
if($_REQUEST['etype']=='')
{
	$_REQUEST['etype'] = 'upcoming';   
}
?>
<div id="wrapper" class="clearfix">
 <div id="content" class="clearfix" >
    <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
    </div>
<?php } ?>
  <h1><?php echo $current_term->name; ?></h1>
	<p class="cat_desc"><?php echo $current_term->description; ?></p>
<div class="tabber">

              <form method="get" name="sort_by_result_frm" id="sort_by_result_frm" action="" >
              
              <?php	if(@$_REQUEST[CUSTOM_CATEGORY_TYPE1]){?>
				<input type="hidden" name="<?php echo CUSTOM_CATEGORY_TYPE1;?>" value="<?php echo $_REQUEST[CUSTOM_CATEGORY_TYPE1];?>" />
				<?php }	?>
                <?php if(@$_REQUEST['etype']){?>
                <input type="hidden" name="etype" value="<?php echo $_REQUEST['etype']; ?>" />
                <?php }
				if(isset($_REQUEST['eventtags'])){
				?>
				<input type="hidden" name="eventtags" value="<?php echo $_REQUEST['eventtags']; ?>" />
				<?php }
				
				?>
              <select name="sortby" id="sortby_id" class="category" onchange="sort_as_set()">
                <option value=""> <?php _e('Select Sorting','templatic');?></option>
                <!--<option value="title_asc" <?php if($_REQUEST['sortby']=='title_asc'){ echo 'selected="selected"';}?>> <?php _e('Title (Z-A)','templatic');?></option>-->
                <!--<option value="title_desc" <?php if($_REQUEST['sortby']=='title_desc'){ echo 'selected="selected"';}?>> <?php _e('Title (A-Z)','templatic');?></option>-->
                <option value="stdate_low_high" <?php if($_REQUEST['sortby']=='stdate_low_high'){ echo 'selected="selected"';}?>> <?php _e('Start Date (present to future)','templatic');?></option>
                <option value="stdate_high_low" <?php if($_REQUEST['sortby']=='stdate_high_low'){ echo 'selected="selected"';}?>> <?php _e('Start Date (future to present)','templatic');?></option>
                <!--<option value="address_high_low" <?php if($_REQUEST['sortby']=='address_high_low'){ echo 'selected="selected"';}?>> <?php _e('City (A-Z)','templatic');?></option>-->
                <!--<option value="address_low_high" <?php if($_REQUEST['sortby']=='address_low_high'){ echo 'selected="selected"';}?>> <?php _e('City (Z-A)','templatic');?></option>-->
              </select>
              </form>
              <ul class="tab">
		<?php $category_link =  get_term_link( $term, $taxonomy );?>
        <li class="<?php if($_REQUEST['etype']=='upcoming'){ echo 'active';}?>"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;etype=upcoming";}else{ echo $cat_url = $category_link."?etype=upcoming&sortby=stdate_low_high";}?>"><?php echo UPCOMING_TEXT;?> </a></li>
        <li class="<?php if($_REQUEST['etype']=='current'){ echo 'active';}?>"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;etype=current";}else{ echo $cat_url = $category_link."?etype=current&sortby=stdate_low_high";}?>"><?php echo CURRENT_TEXT;?> </a></li>
		<li class="<?php if($_REQUEST['etype']=='past'){ echo 'active';}?>"> <a href="<?php if(strstr($category_link,'?')){ echo $cat_url = $category_link."&amp;etype=past";}else{ echo $cat_url = $category_link."?etype=past&sortby=stdate_high_low";}?>"><?php echo PAST_TEXT;?> </a></li>
</ul>


              <script type="text/javascript">
				function sort_as_set()
				{
					if(document.getElementById('sortby_id').value)
					{
						document.sort_by_result_frm.submit();	
					}
				}
				</script>
   </div> 
<div class="event_type">
	<?php
		if(strstr($category_link,'?'))
		{
			$recurring_event=$category_link."&etype=".$_REQUEST['etype']."&event_type=recurring";
			$regular_event=$category_link."&etype=".$_REQUEST['etype']."&event_type=regular";
		}else
		{
			$recurring_event=$category_link."?etype=".$_REQUEST['etype']."&event_type=recurring";
			$regular_event=$category_link."?&etype=".$_REQUEST['etype']."&event_type=regular";
		}
		if(isset($_GET['event_type']) && $_GET['event_type']=='recurring')
			$recurring_class='current';
		else
			$regular_class='current';
	?>
	<a class="<?php echo $regular_class?> event_type" href="<?php echo $regular_event?>"><?php _e('Regular Events',T_DOMAIN); ?></a>
     <a class="<?php echo $recurring_class?> event_type" href="<?php echo $recurring_event?>"><?php _e('Recurring Events',T_DOMAIN); ?></a>
</div>
         <?php if(have_posts()) : $pcount=0; ?>
      <?php while(have_posts()) : the_post()  ?>
         <?php get_the_post_content('listing_li')?>
        <?php endwhile; ?>
        <?php if (function_exists('pagenavi')) { ?>
        <?php pagenavi('<div class="pagination">  ','</div>'); ?>

      <?php } ?>
        <?php else: ?>
     <b><?php echo CUSTOM_POST_NOT_FOUND;?></b>
      <?php endif; ?>
      
</div> <!-- content #end -->
    <?php get_sidebar(); ?>
</div> <!-- wrapper #end -->
<div id="bottom"></div>    
<?php get_footer(); ?>