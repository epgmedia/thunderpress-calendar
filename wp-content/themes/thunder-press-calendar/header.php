<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<title>
<?php
	/* * Print the <title> tag based on what is being viewed. */
	global $page, $paged,$post;
	wp_title( '|', true, 'right' );
?>
</title>
<?php wp_enqueue_script("jquery"); ?>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="google-site-verification" content="mLvqWdgZv9XcVUB3erSicIjr_j3kOm3x6mE_NeP6Dto" />
<?php if (is_home()) { ?>
<?php if ( get_option('ptthemes_meta_description') <> "" ) { ?>
<meta name="description" content="<?php echo stripslashes(get_option('ptthemes_meta_description')); ?>" />
<?php } ?>
<?php if ( get_option('ptthemes_meta_keywords') <> "" ) { ?>
<meta name="keywords" content="<?php echo stripslashes(get_option('ptthemes_meta_keywords')); ?>" />
<?php } ?>
<?php if ( get_option('ptthemes_meta_author') <> "" ) { ?>
<meta name="author" content="<?php echo stripslashes(get_option('ptthemes_meta_author')); ?>" />
<?php } ?>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
<?php if ( get_option('ptthemes_favicon') <> "" ) { ?>
<link rel="shortcut icon" type="image/png" href="<?php echo get_option('ptthemes_favicon'); ?>" />
<?php } ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('ptthemes_feedburner_url') <> "" ) { echo get_option('ptthemes_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( get_option('ptthemes_scripts_header') <> "" ) { echo stripslashes(get_option('ptthemes_scripts_header')); } ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/css/print.css" media="print" />
<link href="<?php bloginfo('template_directory'); ?>/library/css/slimbox.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('template_directory'); ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
<?php if ( is_singular() && get_option( 'thread_comments' ) )
	  wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>
<?php do_action('templ_head_js');?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/skins/<?php echo get_option('ptthemes_alt_stylesheet'); ?>.css" type="text/css" media="screen" />
<?php if ( get_option('ptthemes_customcss') ) { ?>
<link href="<?php bloginfo('template_directory'); ?>/custom.css" rel="stylesheet" type="text/css" />
<?php } ?>
</head>
<body <?php // body_class(); ?> >

<div id="top_strip">
	<div id="top_strip_in" class="top_strip_in clearfix">
    	<div class="currentmenu"><span>Menu</span></div>
		<?php if (@get_option(ptthemes_show_top_menu) == 'Yes')
		{ ?>
		<ul class="children">
		<li class="hometab <?php if ( is_home() && @$_REQUEST['page']=='' && @$_REQUEST['ptype'] =='' ) { ?> current_page_item <?php } ?>"><a href="<?php echo home_url(); ?>/"><?php _e('Home'); ?></a></li>
		<li class="<?php if($page =='page'){ echo 'current-page-item';}?>" >
		<?php $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Templates'");?>
		<a href="<?php echo get_permalink($page_id); ?>"><?php _e('Page Templates','templatic'); ?></a>
			<ul class="sub-menu">
			
			
			<?php $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Templates'");
			wp_list_pages('title_li=&post_type=page&exclude=2,'.$page_id);?>
			
			
			</ul>
		</li>
		<?php global $current_user;
			if($current_user->ID)
			{
			?>
			<li><a href="<?php echo get_author_posts_url($current_user->ID);?>"><?php echo $current_user->display_name; ?></a></li>
			<li><a href="<?php echo wp_logout_url(site_url()); ?>" title="Log out of this account"><?php echo LOGOUT_TEXT;?></a></li>
			<?php } else { ?>
		<li><a href="<?php echo site_url()."/?page=login"; ?>"><?php echo LOGIN_TEXT;?></a></li>
		<?php } ?>
		</ul>
	<?php	} else {
            $nav_menu = get_option('theme_mods_events2');
            if($nav_menu['nav_menu_locations']['primary'] != 0){
               wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary','menu_class' => 'sub-menu', ));
            } } ?>
           
	   <?php dynamic_sidebar('header_logo_right_side'); ?>     
    </div>
</div>

<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/35190362/THP_ROS_160_SB1', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-0').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_160_SB2', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-1').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_160_SB3', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-2').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_160_SB4', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-3').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_160_SB5', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-4').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_160_SB6', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-5').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_160_SB7', [[120, 240], [125, 125], [120, 600], [160, 160], [160, 240], [160, 600]], 'div-gpt-ad-1375829240899-6').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_300_LR', [[300, 250], [300, 600]], 'div-gpt-ad-1375829240899-7').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_300_Mid', [[300, 250], [300, 600]], 'div-gpt-ad-1375829240899-8').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_300_Mid2', [[300, 250], [300, 600]], 'div-gpt-ad-1375829240899-9').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_300_UR', [[300, 250], [300, 600]], 'div-gpt-ad-1375829240899-10').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_Footerboard', [[728, 90], [468, 60]], 'div-gpt-ad-1375829240899-11').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_Leaderboard', [728, 90], 'div-gpt-ad-1375829240899-12').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_middle468', [468, 60], 'div-gpt-ad-1375829240899-13').addService(googletag.pubads());
googletag.defineSlot('/35190362/THP_ROS_middle468_2', [468, 60], 'div-gpt-ad-1375829240899-14').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
</script>


<div class="topbannerad">
	<!-- THP_ROS_Leaderboard -->
<div id='div-gpt-ad-1375829240899-12' style='width:728px; height:90px;'>
<script type='text/javascript'>
googletag.cmd.push(function() { googletag.display('div-gpt-ad-1375829240899-12'); });
</script>
</div>

</div>
    

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42840259-5', 'thunderpress.net');
  ga('send', 'pageview');

</script>




 <div  id="header">



      <div class="header_left">
    <?php if ( strtolower(get_option('ptthemes_show_blog_title')) == strtolower('Yes') ) { ?>
       <div class="blog-title"><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> 
             <p class="blog-description"><?php bloginfo('description'); ?></p>
       </div> 


    



    <?php } else { ?>
<a href="http://www.thunderpress.net/" title="Thunder Press"><img alt="Thunder Press" src="http://calendar.thunderpress.net.php53-26.dfw1-2.websitetestlink.com/wp-content/uploads/2012/08/tplogo.jpg"></a>

   
    <?php } ?>



    </div> <!-- header left #end -->
    
 
<div class="header_center">


</div>
    
    
     <?php if( get_option('is_user_eventlist') == 'Yes' ){ ?>
     <a class="b_sbumit" href="<?php echo get_option('siteurl'); ?>/?ptype=post_event"><?php _e('Submit Event');?> </a>
     <?php }?>
    
    <?php $total_events = get_total_events_count();
		if($total_events)
		{ ?>
   	<p class="general_statics">  <?php _e('Total Events','templatic');?> : <span><?php echo $total_events;?></span></p>
    <?php }?>
 </div>

   <div id="main_navi">
   <div class="currentmenu2"><span><?php _e('Menu','templatic'); ?></span></div>
   <?php if ( get_option('ptthemes_show_menu') == 'No' )
		{  
			$nav_menu = get_option('theme_mods_events2');
			wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary','menu_class' => 'sub-menu', ));
			} else { ?>
			<div class="menu-header">
				<ul id="menu-below-main" class="sub-menu">
					<li class="hometab <?php if ( is_home() && @$_REQUEST['page']=='' && @$_REQUEST['ptype'] =='') { ?> current_page_item <?php } ?>"><a href="<?php echo home_url(); ?>/"><?php _e('Home'); ?></a></li>
							
							<?php $terms = get_terms('eventcategory');
							foreach ($terms as $term) :
							$link = get_term_link($term->slug, 'eventcategory');
							global $wp_query,$post;
							$current_term = $wp_query->get_queried_object();
							?>
							<li class="<?php if(@$current_term->name == @$term->name || @$slug == @$term->slug ){ echo 'current_page_item ';}?>">
							<a href="<?php echo $link; ?>"><?php echo $term->name; ?></a>
							</li>
							<?php endforeach; ?>
							
							<li class="<?php if(@$_REQUEST['ptype']=='blog' || @$slug =='blog'){ echo 'current_page_item ';}?>">
							<?php $id1 = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Blog'");
								$link1 = get_category_link( $id1 );?>
							<a href="<?php echo $link1; ?>"><?php _e('Blog','templatic'); ?></a>
							</li>
							
							<?php if (get_option('ptthemes_show_addevent_link') == 'Yes') { ?>
						<li class="<?php if(@$_REQUEST['ptype']=='post_event' || @$slug =='post_event'){ echo 'current_page_item'; }?>">
							<a href="<?php echo get_option('siteurl'); ?>/?ptype=post_event"><?php _e('Add Event','templatic'); ?></a>
							</li><?php } ?>
				</ul>
			<?php } ?>
     <span class="nav_left"></span>
    <span class="nav_right"></span>
	</div>
	</div>