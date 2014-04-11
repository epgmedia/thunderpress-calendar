<?php
/*
Template Name: Template - Sitemap
*/
?>
<?php get_header(); ?>
<?php $is_page = true; ?>

<div id="wrapper" class="clearfix">
  <div id="content" class="clearfix" >
  				 
                 <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
                <div class="breadcrumb clearfix">
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
                </div>
            <?php } ?>
             	 <h1 class="cat_head" >
				  <?php 
				  if(have_posts()) 
				  {
						while(have_posts())
						{ 
							the_post();
							the_title();
						}
					}
				   ?> 
				 </h1> 
                
                
       	
		<div id="post-<?php the_ID(); ?>" class="post archive-spot">
      <div class="arclist clearfix">
        <h3><?php _e('Pages','templatic'); ?></h3>
        <ul >
          <?php wp_list_pages('title_li='); ?>
        </ul>
      </div>
      <!--/arclist -->
	  <div class="arclist clearfix">
        <h3><?php _e('Latest Posts','templatic'); ?></h3>
        <ul>
          <?php $archive_query = new WP_Query('showposts=60&post_type=post');
		                       $args = array(
									'post_type'=> 'post'
								);
								$posts = query_posts( $args ); 
								while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <strong>
            <?php comments_number('0', '1', '%'); ?>
            </strong></li>
          <?php endwhile; ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist clearfix">
        <h3><?php _e('Latest Events','templatic'); ?></h3>
        <ul>
          <?php $archive_query = new WP_Query('showposts=60&post_type=event');
		                       $args = array(
									'post_type'=> 'event'
								);
								$posts = query_posts( $args ); 
								while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <strong>
            <?php comments_number('0', '1', '%'); ?>
            </strong></li>
          <?php endwhile; ?>
        </ul>
      </div>
      <!--/arclist -->
     <div class="arclist clearfix">
        <h3><?php _e('Monthly Archives','templatic'); ?></h3>
        <ul>
          <?php wp_get_archives('type=monthly'); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist clearfix">
        <h3><?php _e('Post Categories','templatic'); ?></h3>
        <ul>
          <?php wp_list_categories('title_li=&hierarchical=0&show_count=1&exclude=1') ?>
        </ul>
      </div>
      <!--/arclist -->
	  <div class="arclist clearfix">
        <h3><?php _e('Event Categories','templatic');?></h3>
        <ul>
          <?php wp_list_categories('title_li=&hierarchical=0&show_count=1&taxonomy=eventcategory') ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist clearfix">
        <h3><?php _e('RSS Feed','templatic'); ?></h3>
        <ul>
          <li><a href="<?php bloginfo('rdf_url'); ?>" title="RDF/RSS 1.0 feed"><?php _e('RDF / RSS 1.0 feed','templatic'); ?></a></li>
          <li><a href="<?php bloginfo('rss_url'); ?>" title="RSS 0.92 feed"><?php _e('RSS 0.92 feed','templatic'); ?></a></li>
          <li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS 2.0 feed"><?php _e('RSS 2.0 feed','templatic'); ?></a></li>
          <li><a href="<?php bloginfo('atom_url'); ?>" title="Atom feed"><?php _e('Atom feed','templatic'); ?></a></li>
        </ul>
      </div>
      <!--/arclist -->
    </div> 
 </div> <!-- content  #end -->
<div id="sidebar">
<?php dynamic_sidebar('content_sidebar'); ?>
  </div>
 </div> <!-- wrapper #end -->
<div id="bottom"></div>
	
<?php get_footer(); ?>