<?php
/*
Template Name: Template - Facebook Events
*/
?>
<?php get_header(); ?>

<div id="wrapper" class="<?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
	<div id="content">
	<div class="title-container">
	    <h1 class="title_green"><span><?php the_title(); ?></span></h1>
	    <div class="clearfix"></div>
	</div>
	<?php 
	
	if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
	 <?php global $current_user; echo facebook_events_template(); ?>
	
	<!--  CONTENT AREA END -->
	</div>

<?php get_sidebar(); ?>
<div class="clearfix"></div>
</div>
<div id="bottom"></div>
<?php get_footer(); ?>