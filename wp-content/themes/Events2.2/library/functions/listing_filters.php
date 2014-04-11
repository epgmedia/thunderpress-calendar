<?php
if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
	remove_filter('posts_where', 'search_cal_event_where');
	remove_filter('posts_orderby', 'searching_filter_orderby');
	remove_filter('posts_join', 'searching_filter_join');
	remove_filter('posts_where', 'searching_filter_where');
	remove_filter('posts_orderby', 'review_highest_orderby');
	remove_filter('posts_orderby', 'ratings_most_orderby');
	remove_filter('posts_orderby', 'archive_filter_orderby');
	remove_filter('posts_orderby', 'category_filter_orderby');
	remove_filter('posts_where', 'event_where');
}
 
add_action('pre_get_posts', 'search_filter');
function search_filter($local_wp_query) {
	if(is_search() && $_REQUEST['s']=='Calender-Event' && !isset($_REQUEST['adv_search']))
	{
		add_filter('posts_where', 'search_cal_event_where');		
	}elseif(is_search() && $_REQUEST['t']==CUSTOM_POST_TYPE1)
	{
		add_filter('posts_orderby', 'searching_filter_orderby');
		add_filter('posts_where', 'searching_filter_where');
	}elseif(is_author())
	{
		add_filter('posts_where', 'author_filter_where');	
	}
	elseif(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && is_tax())
	{
		add_filter('posts_orderby', 'category_filter_orderby');
		add_filter('posts_where', 'event_where');
	}
	if(isset($_REQUEST['adv_search']) && $_REQUEST['adv_search'] !='')
		{
			$local_wp_query->set('post_type', array('event','attachment'));
			add_filter('posts_where', 'searching_filter_where1');
		}
	@$wp_query->query_vars['post_type'] == 'ads';
}
function search_cal_event_where($where)
{
	global $wpdb,$wp_query;
	$m = @$wp_query->query_vars['m'];
	$py = substr($m,0,4);
	$pm = substr($m,4,2);
	$pd = substr($m,6,2);
	$the_req_date = "$py-$pm-$pd";
	$event_of_month_sql = "select p.ID from $wpdb->posts p where (p.post_type='".CUSTOM_POST_TYPE1."' || p.post_type ='ads') and p.ID in (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$the_req_date\" and pm.post_id in ((select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'end_date' and pm.meta_value>=\"$the_req_date\")))";
	
	$where = " AND ($wpdb->posts.post_type='".CUSTOM_POST_TYPE1."' || $wpdb->posts.post_type='ads') AND $wpdb->posts.ID in ($event_of_month_sql) and $wpdb->posts.post_status in ('publish','private','recurring')";
	
	$where.=" AND ($wpdb->posts.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') )";
		
	return $where;
}
function searching_filter_orderby($orderby) {
	global $wpdb;
	$orderby = "  (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\") desc,$wpdb->posts.post_title ";
	return $orderby;	
}
function author_filter_where($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	$query_var = @$wp_query->query_vars;

	$user_id = $query_var['author'];
	$where = " AND ($wpdb->posts.post_author = $user_id) ";
	$post_ids = get_user_meta($user_id,'user_attend_event',true);
	$final_ids = '';
	if($post_ids)
	  {
		foreach($post_ids as $key=>$value)
		 {
		  if($value != '')
		    {
			 $final_ids .= $value.',';
		    }
	    }
		$post_ids = substr($final_ids,0,-1);
	 }
	if(isset($_REQUEST['list']) && $_REQUEST['list'] == 'attend')
	{
		//if($current_user->ID==$user_id)
		{
			$where = '';
			$where .= " AND ($wpdb->posts.ID in ($post_ids)) AND ($wpdb->posts.post_type = 'event' ) AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'recurring' OR $wpdb->posts.post_status = 'draft') ";
		}
	}
	else
	{
		if($current_user->ID==$user_id)
		{
			$where .= " AND ($wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft') ";
		}else
		{
			$where .= " AND ($wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."')AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private')  ";
		}
	}
	return $where;
}
function searching_filter_join($join) {
	global $wpdb;
	$saddress = trim($_REQUEST['saddress']);
	$sdate = trim($_REQUEST['sdate']);
	if($sdate || $saddress)
	{
		$join .= " join $wpdb->postmeta on $wpdb->postmeta.post_id=$wpdb->posts.ID ";
	}
	return $join;
}

function searching_filter_where($where) {
	global $wpdb;
	$skw = trim($_REQUEST['skw']);
	$scat = trim($_REQUEST['scat']);
	$saddress = trim($_REQUEST['saddress']);
	$sdate = trim($_REQUEST['sdate']);
	
	if($saddress )
	{
		add_filter('posts_join', 'searching_filter_join');
	}
	
	$where = '';
	$where = " AND $wpdb->posts.post_type in ('".CUSTOM_POST_TYPE1."') AND ($wpdb->posts.post_status = 'publish' or $wpdb->posts.post_status = 'recurring') ";
	if($skw)
	{
		$where .= " AND (($wpdb->posts.post_title LIKE \"%$skw%\") OR ($wpdb->posts.post_content LIKE \"%$skw%\")) ";
	}
	if($sdate)
	{
		$where .= " AND $wpdb->posts.ID in (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$sdate\" and pm.post_id in ((select pm2.post_id from $wpdb->postmeta pm2 where pm2.meta_key like 'end_date' and pm2.meta_value>=\"$sdate\"))) ";
	}
	if($scat>0)
	{
		$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$scat\" ) ";
	}
	if($saddress)
	{
		$where .= " AND ($wpdb->postmeta.meta_key like 'address' and $wpdb->postmeta.meta_value like \"%$saddress%\") ";
	}
	$serch_post_types = "'event','attachment'";
	$custom_metaboxes = get_post_custom_fields_templ($serch_post_types,'','user_side','1');
	foreach($custom_metaboxes as $key=>$val) {
	$name = $key;
		if($_REQUEST[$name]){ 
			$value = $_REQUEST[$name];
			if($name == 'event_desc'){
				$where .= " AND ($wpdb->posts.post_content like \"%$value%\" )";
			} else if($name == 'event_name'){
				$where .= " AND ($wpdb->posts.post_title like \"%$value%\" )";
			}else {
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='$name' and ($wpdb->postmeta.meta_value like \"%$value%\" ))) ";
			}
		}
	}
	/* Recurring and regular event filter*/
	
	{
		$where.=" AND ($wpdb->posts.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') )";
	}	
	
	if(is_search()){
	$where .= " OR  ($wpdb->posts.ID in (select p.ID from $wpdb->terms c,$wpdb->term_taxonomy tt,$wpdb->term_relationships tr,$wpdb->posts p ,$wpdb->postmeta t where c.name like '".$skw."' and c.term_id=tt.term_id and tt.term_taxonomy_id=tr.term_taxonomy_id and tr.object_id=p.ID and p.ID = t.post_id and p.post_status = 'publish' group by  p.ID))";
	}	
	
	return $where;
}
function searching_no_filter_where($where) {
	global $wpdb;
	$s = trim($_REQUEST['s']);
	$where = " AND $wpdb->posts.post_type  in ('post','".CUSTOM_POST_TYPE1."') AND (($wpdb->posts.post_title LIKE \"%$s%\") OR ($wpdb->posts.post_content LIKE \"%$s%\") OR ($wpdb->postmeta.meta_key like 'address' and $wpdb->postmeta.meta_value like \"%$s%\"))) ";
	return $where;
}

function category_filter_orderby($orderby)
{      
	global $wpdb;
	if ( @$_REQUEST['sortby'] == 'title_asc' )
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c') ASC, $wpdb->posts.post_title ASC";
	}
	elseif ( @$_REQUEST['sortby'] == 'title_desc' )
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c') ASC, $wpdb->posts.post_title DESC";
	}
	elseif ( @$_REQUEST['sortby'] == 'stdate_low_high' )
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = $wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") ASC";
	}
	elseif ( @$_REQUEST['sortby'] == 'stdate_high_low' )
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = $wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") DESC";
	}
	elseif ( @$_REQUEST['sortby'] == 'address_high_low' )
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = $wpdb->posts.ID and $wpdb->postmeta.meta_key like \"address\") ASC";
	}
	elseif ( @$_REQUEST['sortby'] == 'address_low_high' )
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = $wpdb->posts.ID and $wpdb->postmeta.meta_key like \"address\") DESC";
	}
	else
	{
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c') ASC";
	}
	return $orderby;
}


//FILER FOR SEPARATING UPCOMING, CURRENT AND PAST EVENTS
function event_where($where)
{
	global $wpdb,$wp_query;
	$current_term = $wp_query->get_queried_object();
	if((is_archive() || is_tag()) && ($current_term->taxonomy==CUSTOM_CATEGORY_TYPE1 || $current_term->taxonomy==CUSTOM_TAG_TYPE1))
	{
		if($current_term->taxonomy == CUSTOM_CATEGORY_TYPE1 || $current_term->taxonomy == CUSTOM_TAG_TYPE1)
		{
			if(@$_REQUEST['etype']=='')
			{
				$_REQUEST['etype']=get_option('ptthemes_category_current_tab')?get_option('ptthemes_category_current_tab'):'upcoming';
			}
			if(@$_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') >'".$today."' and ($wpdb->posts.post_status = 'publish' or $wpdb->posts.post_status = 'recurring'))) ";
			}
			elseif($_REQUEST['etype']=='current')
			{
				$today = date('Y-m-d');
				$where .= "  AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d ') <='".$today."')) AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d ') >= '".$today."')) ";
			}
			elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d ') < '".$today."')) ";
			}
		}elseif(is_day() || is_month() || is_year())
		{
			$where = str_replace("'post'","'".CUSTOM_POST_TYPE1."'",$where); 
		}
		
		
		{
			$where.=" AND ($wpdb->posts.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') )";
		}
	}
	return $where;
}

function searching_filter_where1($where) {
	global $wpdb;
	$scat = trim($_REQUEST['catdrop']);
	$todate = trim($_REQUEST['todate']);
	//$todate = date('Y-m-d G:i:s');
	$frmdate = trim($_REQUEST['frmdate']);
	$articleauthor = trim($_REQUEST['articleauthor']);
	$exactyes = trim($_REQUEST['exactyes']);
	if($scat>0)
	{
		$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$scat\" ) ";
	}
	if($todate!="" && $frmdate=="")
	{
		$where .= " AND   DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d %G:%i:%s') >='".$todate."'";
	}
	else if($frmdate!="" && $todate=="")
	{
		
		$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d %G:%i:%s') <='".$frmdate."'";
	}
	else if($todate!="" && $frmdate!="")
	{
		$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d %G:%i:%s') BETWEEN '".$todate."' and '".$frmdate."'";
		
	}
	if($articleauthor!="" && $exactyes!=1)
	{
		$where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  like '".$articleauthor."') ";
	}
	if($articleauthor!="" && $exactyes==1)
	{
		$where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  = '".$articleauthor."') ";
	}
	$serch_post_types = "'event','attachment'";
	$custom_metaboxes = get_post_custom_fields_templ($serch_post_types,'','user_side','1');
	foreach($custom_metaboxes as $key=>$val) {
	$name = $key;
		if($_REQUEST[$name]){ 
			$value = $_REQUEST[$name];
			if($name == 'event_desc'){
				$where .= " AND ($wpdb->posts.post_content like \"%$value%\" )";
			} else if($name == 'event_name'){
				$where .= " AND ($wpdb->posts.post_title like \"%$value%\" )";
			}else {
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='$name' and ($wpdb->postmeta.meta_value like \"%$value%\" ))) ";
			}
		}
	}
	/*Recurring Event and regular event search */
	if(isset($_REQUEST['todate']) && $_REQUEST['todate']!="")
		$todate = $todate;
	else
		$todate = date("Y-m-d");			
	
	if(isset($_REQUEST['event_type']) && $_REQUEST['event_type']=='recurring')
	{
		$where.=" AND ($wpdb->posts.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta inner join $wpdb->postmeta p1 on $wpdb->postmeta.post_id=p1.post_id where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value LIKE '%Recurring event%' AND p1.meta_key='recurring_search_date' AND p1.meta_value NOT LIKE '%$todate%') )";
		
	}else
	{
		$where.=" AND ($wpdb->posts.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') )";
	}		
	if($_REQUEST['tag_s'])
	{
	$where .= " OR  ($wpdb->posts.ID in (select p.ID from $wpdb->terms c,$wpdb->term_taxonomy tt,$wpdb->term_relationships tr,$wpdb->posts p ,$wpdb->postmeta t where c.name like '".$_REQUEST['tag_s']."' and c.term_id=tt.term_id and tt.term_taxonomy_id=tr.term_taxonomy_id and tr.object_id=p.ID and p.ID = t.post_id and p.post_status = 'publish' group by  p.ID))";
	}
	return $where;
}
?>