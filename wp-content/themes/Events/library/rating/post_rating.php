<?php
define('POSTRATINGS_MAX',5);
$rating_path = get_bloginfo( 'template_directory', 'display' ).'/library/rating/';
$rating_image_on = $rating_path.'images/rating_on.png';
$rating_image_off = $rating_path.'images/rating_off.png';

add_action('wp_footer', 'footer_rating_off');
function footer_rating_off()
{
	if(get_option('ptthemes_disable_rating'))
	{
		echo '<style type="text/css">#content .category_list_view li .content .rating{border-bottom:none; padding:0;}
		#sidebar .company_info2 p{padding:0; border-bottom:none;}
		#sidebar .company_info2 p span.i_rating{display:none;}
		</style>';
	}
}
/* create table for rating */
global $wpdb; $rating_table_name;
$wpdb->query("CREATE TABLE IF NOT EXISTS $rating_table_name (
  rating_id int(11) NOT NULL AUTO_INCREMENT,
  rating_postid int(11) NOT NULL,
  rating_posttitle text NOT NULL,
  rating_rating int(2) NOT NULL,
  rating_timestamp varchar(15) NOT NULL,
  rating_ip varchar(40) NOT NULL,
  rating_host varchar(200) NOT NULL,
  rating_username varchar(50) NOT NULL,
  rating_userid int(10) NOT NULL DEFAULT '0',
  comment_id int(11) NOT NULL,
  PRIMARY KEY (rating_id)
) ENGINE=MyISAM");

for($i=1;$i<=POSTRATINGS_MAX;$i++)
{
	$postratings_ratingsvalue[] = $i;
}
/*function for saving rating */
function save_comment_rating( $comment_id = 0) {
	global $wpdb,$rating_table_name, $post, $user_ID;

	$rate_user = $user_ID;
	$rate_userid = $user_ID;
	$post_id = $_REQUEST['post_id'];
	$post_title = $post->post_title;
	$rating_var = "post_".$post_id."_rating";
	$rating_val = $_REQUEST["$rating_var"];
	if(!$rating_val){$rating_val=4;}
	$wpdb->query("INSERT INTO $rating_table_name (rating_postid,rating_rating,comment_id) VALUES ( \"$post_id\", \"$rating_val\",\"$comment_id\")");
}

add_action( 'wp_insert_comment', 'save_comment_rating' );
/*function for deletin rating */
function delete_comment_rating($comment_id = 0)
{
	global $wpdb,$rating_table_name, $post, $user_ID;
	if($comment_id)
	{
		$wpdb->query("delete from $rating_table_name where comment_id=\"$comment_id\"");
	}
	
}
//add_action( 'wp_delete_comment', 'delete_comment_rating' );
/* function for calculating average rating */
function get_post_average_rating($pid)
{
	global $wpdb,$rating_table_name;
	$avg_rating = 0;
	if($pid)
	{
		$comments = $wpdb->get_var("select group_concat(comment_ID) from $wpdb->comments where comment_post_ID=\"$pid\" and comment_approved=1");
		if($comments)
		{
			$avg_rating = $wpdb->get_var("select avg(rating_rating) from $rating_table_name where comment_id in ($comments)");
		}
		$avg_rating = ceil($avg_rating);
	}
	return $avg_rating;
}
/* fetching the rating star */
function draw_rating_star($avg_rating)
{
	if(get_option('ptthemes_disable_rating') == 'Yes')
	{
	}else
	{
		global $rating_image_on,$rating_image_off;
		$rtn_str = '';
		for($i=0;$i<$avg_rating;$i++)
		{
			$rtn_str .= '<img src="'.$rating_image_on.'" alt="" />';	
		}
		for($i=$avg_rating;$i<POSTRATINGS_MAX;$i++)
		{
			$rtn_str .= '<img src="'.$rating_image_off.'" alt="" />';	
		}
	}
	return @$rtn_str;
}
function get_post_rating_star($pid='')
{
	$rtn_str = '';
	$avg_rating = get_post_average_rating($pid);
	$rtn_str =draw_rating_star($avg_rating);
	return $rtn_str;
}
function get_comment_rating_star($cid = '')
{
	global $rating_table_name, $wpdb;
	$rtn_str = '';
	$avg_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$cid\"");
	$avg_rating = ceil($avg_rating);
	$rtn_str = draw_rating_star($avg_rating);
	return $rtn_str;
}

//================REVIEW RATING SHORTING START==========================//
if((@$_REQUEST['sort'] =='' || @$_REQUEST['sort']!='' || @$_REQUEST['rating']!='') && @$_REQUEST['sortby']!='' || !is_category())
{
//if(!strstr($_SERVER['REQUEST_URI'],'/author/')){
	add_action('pre_get_posts', 'ratings_sorting');
	//}
}
add_action('pre_get_posts', 'ratings_sorting');
function ratings_sorting($local_wp_query) {
	global $wp_query, $post;
	if(!strstr($_SERVER['REQUEST_URI'],'/author/')){
		$current_term = @$wp_query->get_queried_object();
	}
	if(@$current_term){
	if((@$current_term->taxonomy == CUSTOM_CATEGORY_TYPE1) || (@$current_term->taxonomy == CUSTOM_TAG_TYPE1))
	{
	if(@$_REQUEST['sort']=='review') {
		add_filter('posts_orderby', 'review_highest_orderby');
		remove_filter('posts_orderby', 'ratings_most_orderby');
	} elseif(@$_REQUEST['sort']=='rating') {
		add_filter('posts_orderby', 'ratings_most_orderby');
		remove_filter('posts_orderby', 'review_highest_orderby');	
	}else
	{
		add_filter('posts_orderby', 'archive_filter_orderby');
		remove_filter('posts_orderby', 'ratings_most_orderby');
		remove_filter('posts_orderby', 'review_highest_orderby');
	}
	add_filter('dynamic_sidebar', 'widget_reset_filter');
	//add_filter('posts_orderby', 'listing_filter_orderby');
	} }
}

/* function listing_filter_orderby($orderby) {
	
	global $wpdb;
	if($_REQUEST['sortby']=='title_asc')
	{
		$orderby = " $wpdb->posts.post_title asc ";
	}elseif($_REQUEST['sortby']=='title_desc')
	{
		$orderby = " $wpdb->posts.post_title desc ";
	}elseif($_REQUEST['sortby']=='stdate_low_high')
	{
		$orderby = "  (select date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %G:%i:%s') from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,$wpdb->posts.post_title ";
	}elseif($_REQUEST['sortby']=='stdate_high_low')
	{
		$orderby = "  (select date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %G:%i:%s') from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") desc,$wpdb->posts.post_title ";
	}elseif($_REQUEST['sortby']=='address_high_low')
	{
		$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"address_high_low\") asc,$wpdb->posts.post_title asc";
	}elseif($_REQUEST['sortby']=='address_low_high')
	{
		$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"address_low_high\") desc,$wpdb->posts.post_title desc";
	}else
	{
			if($_REQUEST['etype'] == "past")
			{
		$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") desc, (select date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %G:%i:%s') from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,$wpdb->posts.post_title"; 
			}elseif($_REQUEST['etype'] == "upcoming")
			{
				$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") desc, (select date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %G:%i:%s') from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,$wpdb->posts.post_title";
			}
	}
	return $orderby;	
} */

function widget_reset_filter()
{
	add_filter('posts_orderby', 'widget_filter_orderby');
}

function widget_filter_orderby($orderby)
{
	global $wpdb;
	$orderby="$wpdb->posts.post_date asc";
	return $orderby;
	
}
function archive_filter_orderby($orderby) {
	global $wpdb,$wp_query;
	$current_term = @$wp_query->get_queried_object();
	if($current_term->taxonomy==CUSTOM_CATEGORY_TYPE1 || $current_term->taxonomy=='category')
	{
		$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") desc,$wpdb->posts.post_date desc";
	}
	return $orderby;	
}

function review_highest_orderby($content) {
	$orderby = 'desc';
	$content = " comment_count $orderby";
	return $content;
}
function ratings_most_orderby($content) {
	global $wpdb,$rating_table_name;
	$content = " (select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=$wpdb->posts.ID and cm.comment_approved=1)) desc, comment_count desc ";
	return $content;	
}
//================REVIEW RATING SHORTING END==========================//
?>