<?php
/*
Template Name: Template - Recurring Events User List
*/
get_header(); ?>
<div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >
     	 <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes'): ?>
             <div class="breadcrumb clearfix">
                 <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
             </div>
   		 <?php endif; ?>
      	<h1><?php the_title(); ?></h1>   
          <?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post() ?>
            <?php $pagedesc = get_post_meta($post->ID, 'pagedesc', $single = true); ?>
            <div id="post-<?php the_ID(); ?>" >
                <div class="entry"> 
                    <?php the_content(); ?>
                    <?php
				global $wpdb;
				if(isset($_REQUEST['eid']) && $_REQUEST['eid']!=""):							
					$event_id=$_REQUEST['eid'];					
					$qry_results = $wpdb->get_results("select distinct user_id from $wpdb->usermeta where meta_key LIKE '%user_attend_event%' and meta_value LIKE '%$event_id%' ");	
					$user_attend='<h3 class="page-title entry-title"><a href="'.get_permalink($event_id).'" >'.get_the_title($event_id).'</a> Event Attend User list.</h3>';
					$user_attend.='<ul class="user_list">';
					foreach($qry_results as $res)
					{			
						$user = get_userdata($res->user_id);
						$user_attend.='<li>';
						$user_attend.='<div class="user_gravater"><a href="'.get_bloginfo('url').'/author/' . $user->user_nicename . '">'.str_replace("alt=''",'',get_avatar($user->user_email, '100')).'</a></div>';
						$user_attend.='<div class="user_info"><span>Name:&nbsp;<a href="'.get_bloginfo('url').'/author/' . $user->user_nicename . '">'.$user->display_name.'</a><br />';
						$user_attend.='Email:&nbsp;'.$user->user_email.'</div>';
						$user_attend.='</li>';
						
					}
					$user_attend.='</ul>';	
					echo $user_attend;
				 endif;// request eid if condition
				 ?>
                    
                </div>
            </div><!--/post-->
    <?php endwhile; else : ?>
            <div class="posts">
                <div class="entry-head"><h2><?php echo get_option('ptthemes_404error_name'); ?></h2></div>
                <div class="entry-content"><p><?php echo get_option('ptthemes_404solution_name'); ?></p></div>
            </div>
<?php endif; ?>
     </div>
<?php get_sidebar(); ?>
</div><!-- wrapper #end -->
<?php get_footer(); ?>