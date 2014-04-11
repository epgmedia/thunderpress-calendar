<?php get_header();
/* fetch all the post linting post for a particular category */

 ?>

<div id="wrapper" class="clearfix">
	<div id="content" class="clearfix" >
		<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
		<div class="breadcrumb clearfix">
			<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
		</div>
		<?php } ?>
		
		<?php if (is_category()) { ?>
			<h1> <?php echo get_option('ptthemes_browsing_category'); ?><?php echo single_cat_title(); ?> </h1>
			<p><?php $category_id = get_query_var('cat');
					echo category_description($category_id); ?></p>
			<?php } elseif (is_day()) { ?>
			<h1><?php echo get_option('ptthemes_browsing_day'); ?> <?php the_time('F jS, Y'); ?> </h1>
			<?php } elseif (is_month()) { ?>
			<h1><?php echo get_option('ptthemes_browsing_month'); ?>
			<?php the_time('F, Y'); ?></h1>
			<?php } elseif (is_year()) { ?>
			<h1><?php echo get_option('ptthemes_browsing_year'); ?>
			<?php the_time('Y'); ?></h1>
			<?php } elseif (is_author()) { ?>
			<h1> <?php echo get_option('ptthemes_browsing_author'); ?> <?php echo $curauth->nickname; ?></h1>
			<?php } elseif (is_tag()) { ?>
			<h1> <?php echo get_option('ptthemes_browsing_tag'); ?> <?php echo single_tag_title('', true); ?> </h1>
			<?php } ?>
                
            
    
		<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post() ?>
		<?php $post_images = bdw_get_images_with_info($post->ID,'thumb');//fetch post thumb imae.
			$thumb = $post_images[0]['file'];?>
      
      <div id="post-<?php the_ID(); ?>" class="posts">
              		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                      <?php the_title(); ?>
                      </a></h2>
                      <p class="date"><?php _e("By ","templatic");  the_author_posts_link(); ?> <?php _e("at","templatic"); ?>  <?php the_time('F j, Y') ?>  |   <?php the_time( @$d ); ?>  | <a href="<?php the_permalink(); ?>#commentarea"><?php comments_number('0 Comment', '1 Comments', '% Comments'); ?> </a>   </p>
                         <?php if ( get_option( 'ptthemes_postcontent_full' )) {  ?>
                            <div class="post_content">
                            	
                                <?php if(get_the_post_thumbnail( $post->ID, array(100,100)))
								{ $position='left';
				 echo get_the_post_thumbnail( $post->ID, array(180,120),array('class'	=> "alignleft",));
				 ?>
				  <?php
			   }
       ?>
                                <?php if(get_post_meta($post->ID,'video',true)){?>
                                    <div class="video_main">
                                    <?php echo get_post_meta($post->ID,'video',true);?>
                                    </div>
                                 <?php }?>
                              <?php the_content(); ?>
                            </div>
                            
                            
                            <?php } else { ?>
							<img class="alignleft wp-post-image" src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  />
                            <p> <?php echo bm_better_excerpt(275, '...'); ?>
                            <a style="text-decoration:underline;" href="<?php the_permalink(); ?>"><?php _e('Read more &raquo;','templatic');?> </a></p>
                            <?php } ?>
                 <p class="post_bottom clearfix"> <span class="category"> <?php the_category(" , "); ?> </span>   <?php the_tags('<span class="tags">', ', ', '<br /> </span>'); ?>   </p>
              </div>
      <?php endwhile; ?>
      
           <?php if (function_exists('pagenavi')) { ?>
        <?php pagenavi(' <div class="pagination pagination_none"> ','</div>'); ?>

      <?php } ?>

      <?php endif; ?>
    </div> <!-- content #end -->
    <div id="sidebar">
	<?php if (function_exists('dynamic_sidebar')) { dynamic_sidebar('blog_listing_sidebar'); } ?>
	<?php //dynamic_sidebar(10);  ?>
</div> <!-- sidebar right--> 
</div> <!-- wrapper #end -->
<div id="bottom"></div>  
<?php get_footer(); ?>