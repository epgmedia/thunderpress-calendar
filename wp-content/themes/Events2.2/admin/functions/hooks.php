<?php
/*
Name : templ_footer_settings
Arguments : None
Description : Footer scripts desing option content
*/
add_action('wp_footer','templ_footer_settings');
function templ_footer_settings()
{
	echo stripslashes(get_option('ptthemes_scripts_footer'));
}

/*
Name : templ_head_css_settings
Arguments : None
Description : Site Header inside <head>...</head> settings
*/

function templ_head_css_settings()
{
	$stylesheet = get_option('ptthemes_alt_stylesheet');
	echo $stylesheet; exit;
	if($stylesheet != '')
	{
	?>
	<link href="<?php bloginfo('template_directory'); ?>/skins/<?php echo $stylesheet; ?>.css" rel="stylesheet" type="text/css" />
	<?php }
	include(TT_ADMIN_FOLDER_PATH.'functions/add_style.php');
	
	if(strtolower(get_option('ptthemes_customcss'))=='activate')
	{
	?>
		<link href="<?php bloginfo('template_directory'); ?>/library/css/custom.css" rel="stylesheet" type="text/css" />
	<?php
	}
}
add_action('templ_head_css','templ_head_css_settings');

/*
Name : templ_head_js_settings
Arguments : None
Description : return the script for header 
*/

add_action('templ_head_js','templ_head_js_settings');
function templ_head_js_settings()
{
	echo stripslashes(get_option('ptthemes_scripts_header'));
}

/* ============= Page Title Above ======================================== */
function templ_page_title_above()
{
	do_action('templ_page_title_above');	
}

/* ============= Page Title Below ======================================== */
function templ_page_title_below()
{
	do_action('templ_page_title_below');	
}

/* ============= SITE LOGO SETTINGS ======================================== */
function templ_site_logo()
{
	do_action('templ_site_logo');
}

/* ============= TWITTER BUTTON ======================================== */
function templ_show_twitter_button()
{
	do_action('templ_show_twitter_button');	
}

/* ============= FACEBOOK BUTTON ======================================== */
function templ_show_facebook_button()
{
	do_action('templ_show_facebook_button');	
}


/* ============= TOP HEADER NAVIGATION ===================================== */
function templ_get_top_header_navigation()
{
	do_action('templ_get_top_header_navigation');	
}


/* ============= MAIN HEADER NAVIGATION ======================================== */
function templ_get_main_header_navigation()
{
	do_action('templ_get_main_header_navigation');	
}

/*
Name : templ_excerpt_length
Description : EXCERPT LENGTH SETTING FILTER
*/

function templ_excerpt_length($length) {
	return 200;
}
add_filter('excerpt_length', 'templ_excerpt_length');

///=============SEO META TAGS========================================/////
function templ_seo_meta()
{
	do_action('templ_seo_meta');	
}



/*
Name : templ_wp_head
Description : Layout Hooks 
*/
function templ_wp_head()
{
	do_action('templ_wp_head');	
}
/*
Name : templ_body_start
Description : action before start body tag  
*/
function templ_body_start()
{
	do_action('templ_body_start');	
}

/*
Name : templ_body_end
Description : action after end of  body tag  
*/
function templ_body_end()
{
	do_action('templ_body_end');	
}
/*
Name : templ_header_start
Description : header start hook
*/
function templ_header_start()
{
	do_action('templ_header_start');	
}

/*
Name : templ_header_end
Description : header end hook
*/
function templ_header_end()
{
	do_action('templ_header_end');	
}
/*
Name : templ_content_start
Description : Content start hook 
*/
function templ_content_start()
{
	do_action('templ_content_start');	
}

/*
Name : templ_content_end
Description : Content end hook 
*/
function templ_content_end()
{
	do_action('templ_content_end');	
}
/*
Name : templ_before_single_entry
Description : detail page start hook 
*/
function templ_before_single_entry()
{
	do_action('templ_before_single_entry');	
}

/*
Name : templ_after_single_entry
Description : After singkle entry hook
*/
function templ_after_single_entry()
{
	do_action('templ_after_single_entry');	
}

/*
Name : templ_before_single_post_content
Description : Before single post content
*/
function templ_before_single_post_content()
{
	do_action('templ_before_single_post_content');	
}

/*
Name : templ_after_single_post_content
Description : Afetr sibgle post content hook 
*/
function templ_after_single_post_content()
{
	do_action('templ_after_single_post_content');	
}

/*
Name: templ_get_listing_content
ARGUMENTS :NONE
Description : display content or excerpt or sub part of it.
*/
function templ_get_listing_content()
{
	do_action('templ_get_listing_content');	
}

/*
Name : templ_comments_link_attributes
Description : Comment link class added via filter
*/
function templ_comments_link_attributes(){
    return ' class="comments_popup_link" ';
}
add_filter('comments_popup_link_attributes', 'templ_comments_link_attributes');

/*
Name : templ_next_posts_attributes
Description : returns Post link class added via filter
*/
function templ_next_posts_attributes(){
    return ' class="nextpostslink" ';
}
add_filter('next_posts_link_attributes', 'templ_next_posts_attributes');

/*
Name : templ_previous_posts_attributes
Description : returns Post link class added via filter
*/
function templ_previous_posts_attributes(){
    return ' class="previouspostslink" ';
}
add_filter('previous_posts_link_attributes', 'templ_previous_posts_attributes');



/*
Name : templ_get_top_header_navigation_above
Description : Top header navigation above content hook
*/
function templ_get_top_header_navigation_above()
{
	do_action('templ_get_top_header_navigation_above');	
}

/*
Name : templ_add_template_page_hook
Description : add New pages via this action hook
*/
function templ_add_template_page_hook()
{
	do_action('templ_add_template_page_hook');
}
/*
Name : templ_set_listing_post_per_page
Description : Set the filete for the post per page for listing page
*/
function templ_post_limits_listing_page() {
	global $posts_per_page;
	if ( is_home() || is_search()  || is_archive())
	{
		if(is_home())
		{
			if(isset($_REQUEST['per_pg']) && $_REQUEST['per_pg'] !='')
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ptthemes_home_page')>0)
			{
				$rtr = get_option('ptthemes_home_page');
			}else
			{
				$rtr =  10;	
			}				
		}
		if ( is_archive())
		{
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ptthemes_cat_page')>0)
			{
				$rtr = get_option('ptthemes_cat_page');
			}elseif($posts_per_page)
			{
				$rtr =  $posts_per_page;
			}else
			{
				$rtr =  10;	
			}
			
		}
		if ( is_search())
		{
			
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ptthemes_search_page')>0)
			{
				$rtr = get_option('ptthemes_search_page');
			}elseif($posts_per_page)
			{
				$rtr =  $posts_per_page;
			}else
			{
				$rtr =  10;	
			}
			
		}
		return $rtr;
	}
	if ( is_category() || is_month() || is_year() || is_tag() || is_date())
	{
		if($_REQUEST['per_pg'])
		{
			$rtr = $_REQUEST['per_pg'];
		}elseif($posts_per_page)
		{
			$rtr =  $posts_per_page;
		}else
		{
			$rtr =  10;	
		}
		return $rtr;
	}
}
/*
Name: templ_page_title_filter
Arguments: title,starting tag,ending tag
Description  : returns filtered contnet
***************************************/
function templ_page_title_filter($title,$st='',$end='')
{
	return apply_filters('templ_page_title_filter',$st.$title.$end);
}

?>
