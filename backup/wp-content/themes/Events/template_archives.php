<?php
/*
Template Name: Template - Archives
*/
?>
<?php get_header(); ?>
                
        
      <div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >
    	
        <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
        <div class="breadcrumb clearfix">
            <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
        </div>
    <?php } ?>
     <h1><?php _e('Archives for Events','templatic'); ?></h1>   
   
     <div id="post-<?php the_ID(); ?>">
		<div class="arclist clearfix">
        <ul>
          <?php query_posts('showposts=60&post_type=event'); ?>
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <li>
            <div class="archives-time">
              <?php the_time('M j Y') ?>
            </div>
            <a href="<?php the_permalink() ?>">
            <?php the_title(); ?>
            </a> - <?php echo $post->comment_count ?> </li>
          <?php endwhile; endif; ?>
        </ul>
      </div>
	  <h1><?php _e('Archives for Posts','templatic'); ?></h1>   
	  <div class="arclist clearfix">
        <ul>
          <?php query_posts('showposts=60&post_type=post'); ?>
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <li>
            <div class="archives-time">
              <?php the_time('M j Y') ?>
            </div>
            <a href="<?php the_permalink() ?>">
            <?php the_title(); ?>
            </a> - <?php echo $post->comment_count ?> </li>
          <?php endwhile; endif; ?>
        </ul>
      </div>
    </div>
      <!--/arclist -->
   
       </div> <!-- content-in #end -->
        
        
<div id="sidebar">
<?php dynamic_sidebar('content_sidebar'); ?>
  </div>
		  
</div> <!-- wrapper #end -->
<div id="bottom"></div>  
<?php get_footer(); ?>