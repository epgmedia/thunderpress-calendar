<?php
/*
Template Name: Page - Advanced Search
*/
?>
<?php
add_action('wp_head','templ_header_tpl_advsearch');
function templ_header_tpl_advsearch()
{
	?>
	<script type="text/javascript" language="javascript">var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
    <?php
}
?>
<?php get_header(); ?>
<div id="wrapper" class="right-side">
<div  id="content" class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb clearfix">
               
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
             </div><?php } ?>
<!--  CONTENT AREA START -->

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
  <div  id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <?php //templ_page_title_above(); //page title above action hook?>
		<h1 class='title_green'><span><?php echo templ_page_title_filter(get_the_title()); //page tilte filter?></span></h1>
      <?php templ_page_title_below(); //page title below action hook?>
     </div>
    <div class="post-content">
      <?php endwhile; ?>
      <?php endif; ?>
      
        <div class="post-content">
    	 <?php the_content(); ?>
    </div>

      <div id="advancedsearch">
        <form method="get"  action="<?php echo bloginfo('url')."/"; ?>" name="searchform" onsubmit="return sformcheck();">
          <div class="advanced_left">
          <div class="form_row clearfix"> <label><?php echo SEARCH;?></label>
              <input class="textfield" name="s" id="adv_s" type="text" PLACEHOLDER="<?php echo SEARCH; ?>" value="" />
			  <input class="textfield" name="adv_search" id="adv_search" type="hidden" value="1"  />
            </div> 
			<div class="form_row clearfix"> <label><?php echo TAG_SEARCG_TEXT;?></label>
              <input class="textfield" name="tag_s" id="tag_s" type="text"  PLACEHOLDER="<?php echo TAG_SEARCG_TEXT; ?>" value=""  />
			  <input class="textfield" name="adv_search" id="adv_search" type="hidden" value="1"  />
            </div>
           <div class="form_row clearfix"> <label><?php echo CATEGORY;?></label>
         
              <?php wp_dropdown_categories( array('name' => 'catdrop','orderby'=> 'name','show_option_all' => __('select category','templatic'), 'taxonomy'=> CUSTOM_CATEGORY_TYPE1,) ); ?>
            </div>
            <div class="form_row select_advt clearfix">
              <label><?php echo DATE_TEXT;?></label>
                <input name="todate" type="text" class="adv_input" />
                <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" class="adv_calendar" onclick="displayCalendar(document.searchform.todate,'yyyy-mm-dd',this)"  />
				<?php echo TO;?> 
                <input name="frmdate" type="text" class="adv_input ex_spc"  />
                <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar"  class="adv_calendar" onclick="displayCalendar(document.searchform.frmdate,'yyyy-mm-dd',this)"  />
            </div>
            <div class="form_row clearfix">
              <label><?php echo AUTHOR_TEXT;?> </label>
                <input name="articleauthor" type="text" class="textfield"  />
			</div>
			<div class="form_row clearfix">
			<?php 
			$post_types = "'place','event'";
			$custom_metaboxes = get_post_custom_fields_templ($post_types,'0','user_side','1');
			search_custom_post_field($custom_metaboxes); ?>
            </div>
          </div>
          <input type="submit" value="Submit" class="b_submit" />
        </form>
      </div>
    </div>
  </div>

<!--  CONTENT AREA END -->

</div>
<?php get_sidebar(); ?>

<div id="bottom"></div>
<script type="text/javascript" >
function sformcheck()
{
if(document.getElementById('adv_s').value=="")
{
	alert('<?php echo SEARCH_ALERT_MSG;?>');
	document.getElementById('adv_s').focus();
	return false;
}
if(document.getElementById('adv_s').value=='<?php echo SEARCH;?>')
{
document.getElementById('adv_s').value = ' ';
}
return true;
}
</script>
</div>
<?php get_footer(); ?>