<?php
/*
Template Name: Template - Short code
*/
?>
<?php get_header(); ?>

<div id="wrapper" class="clearfix fullpage_bg">
     <div id="content" class="full_page" >
    	
        <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
        <div class="breadcrumb clearfix">
            <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
        </div>
    <?php } ?>
      <h1><?php the_title(); ?></h1>   
        
        		 
<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post() ?>
            <?php $pagedesc = get_post_meta($post->ID, 'pagedesc', $single = true); ?>
            <div id="post-<?php the_ID(); ?>" >
                <div class="entry"> 
                    <?php the_content(); ?>
                </div>
            </div><!--/post-->
    <?php endwhile; else : ?>
            <div class="posts">
                <div class="entry-head"><h2><?php echo get_option('ptthemes_404error_name'); ?></h2></div>
                <div class="entry-content"><p><?php echo get_option('ptthemes_404solution_name'); ?></p></div>
            </div>
<?php endif; ?>
</div> <!-- content #end -->

 
</div> <!-- wrapper #end -->
<div id="bottom" class="fullpage_bottombg"></div>  
<?php get_footer(); ?>
