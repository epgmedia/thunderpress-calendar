<?php get_header(); 
/* post detail page */
?>

<div id="wrapper" class="clearfix">
          	<div id="content" class="clearfix" >
            	<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
                <div class="breadcrumb clearfix">
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
                </div>
            <?php } ?>
            	<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                      <?php the_title(); ?>
                      </a></h1>   
                
  		 
        <div class="single_post_blog">
      <?php if(have_posts()) : ?>
         <?php $post_images = bdw_get_images_with_info($post->ID,'detail_page_image');//fetch post detail page image.
				$thumb = $post_images[0]['file']; ?>
		  <?php while(have_posts()) : the_post() ?>
              <div id="post-<?php the_ID(); ?>" class="posts post_spacer">
              
 
		<?php if(get_post_meta($post->ID,'video',true)){?>
            <div class="video_main">
            <?php echo get_post_meta($post->ID,'video',true);?>
            </div>
         <?php }?>
			<img class="alignleft wp-post-image" src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>"   />
			
			<?php the_content(); ?>
                   <p class="post_bottom clearfix"> <span class="category"> <?php the_category(" "); ?> </span>   <?php the_tags('<span class="tags">', ', ', '<br /> </span>'); ?>   </p>
              </div> <!-- post #end -->
              
               
<div class="pos_navigation clearfix">
			<div class="post_left fl"><?php previous_post_link('%link',''.__('Previous')) ?></div>
			<div class="post_right fr"><?php next_post_link('%link',__('Next').'') ?></div>
	</div>
              </div> <!-- single post content #end -->
              
              <div class="single_post_advt">
			  <?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('blog_content_banner'); } ?>
			  <?php //dynamic_sidebar(12);  ?>
			  </div>
              
              
                  
                		
      <?php endwhile; ?>
 <?php endif; ?>
 
          <div id="comments" class="clearfix"> <?php comments_template(); ?></div>
          
  </div> <!-- content #end -->
           
      
      <div id="sidebar">
	  <?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('blog_detail_sidebar'); } ?>
       	<?php //dynamic_sidebar(11);  ?>
       </div>
</div> <!-- wrapper #end -->
<div id="bottom"></div>  
<?php get_footer(); ?>