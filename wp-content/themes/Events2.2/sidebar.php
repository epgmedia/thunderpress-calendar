<div id="sidebar">
	<?php
	/* DEFINING WIDGET AREAS FOR SIDEBARS */
	global $post;
	if(is_archive() || is_tag())
	{
		global $wp_query;
		$current_term = $wp_query->get_queried_object();
		if($current_term->taxonomy==CUSTOM_CATEGORY_TYPE1 || is_tag())
		{
			dynamic_sidebar('event_listing_sidebar');
		}else
		{
			dynamic_sidebar('blog_listing_sidebar');
		}
	}else
	if(is_single())
	{
		if($post->post_type==CUSTOM_POST_TYPE1)
		{
			dynamic_sidebar('event_detail_sidebar'); 
		}else
		{
			dynamic_sidebar('blog_detail_sidebar');
		}
	}else
	if(is_page())
	{
		dynamic_sidebar('content_sidebar');
	}else
	{
		dynamic_sidebar('add_event_sidebar');
	}?>
</div> <!-- sidebar right--> 