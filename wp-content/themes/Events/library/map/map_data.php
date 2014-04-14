<?php
if(!function_exists('get_category_lists'))
{
	function get_category_lists()
	{
		global $wpdb,$wp_query, $post;	
		if(is_search() || is_tag())
		{
			if ( have_posts() ) 
			{
				$srch_posts = array();
				while ( have_posts() ){ the_post();
					$srch_posts[] = $post->ID;
				}
				if($srch_posts)
				{
					$srch_posts_str = implode(',',$srch_posts);
					$catinfo = $wpdb->get_results("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id INNER JOIN $wpdb->term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tt.taxonomy IN ('category','eventcategory') AND tr.object_id IN ($srch_posts_str) group by t.term_id");
				}
			}
		}else
		if(is_single() && $post->ID)
		{
			if($post->post_type==CUSTOM_POST_TYPE1)
			{
				$catinfo= wp_get_object_terms( $post->ID, CUSTOM_CATEGORY_TYPE1 );
			}else
			{
				$catinfo= wp_get_object_terms( $post->ID, 'category' );
			}
		}elseif(is_archive())
		{
			global $wp_query;
			$current_term = $wp_query->get_queried_object();
			$query_var = $wp_query->query_vars;
			//$cid = $query_var['cat'];
			$cid = $current_term->term_id;
			$catsql = "select c.* from $wpdb->terms c where c.term_id=\"$cid\"";
			$catinfo = $wpdb->get_results($catsql);	
		}else
		{
			$blog_cats = get_blog_sub_cats_str('string');
			$map_cat_arr = get_option('ptthemes_map_cat');
			if(is_array($map_cat_arr) && $map_cat_arr[0])
			{
				$map_cat_ids = implode(',',$map_cat_arr);
				$catsql = "select c.* from $wpdb->terms c  where c.term_id in ($map_cat_ids) order by c.name";	
			}else
			{
				$catsql = "select c.* from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy in ('category','eventcategory') and count>0 and c.term_id not in ($blog_cats) order by c.name";	
			}
			$catinfo = $wpdb->get_results($catsql);	
		}
		return $catinfo;
	}
}
if(!function_exists('get_category_data')){
	function collect_map_post_data($rtn_arr=0,$cat_arr=array())
	{
		global $post,$wpdb,$paged;
		$rtn_val = array();
		if($cat_arr)
		{
			for($i=0;$i<count($cat_arr);$i++)
			{
				$post_info_str .= 'POST_INFO['.$i.']=[';
				$catid = $cat_arr[$i];
				$myposts = array();
				if(is_single() && $post->ID){
					if($post->post_type==CUSTOM_POST_TYPE1)
					{
						$pid=$post->ID; 
						$myposts = get_posts("numberposts=1&include=$pid&post_type=event");						
					}else
					{
						$pid=$post->ID; 
						$myposts = get_posts("numberposts=1&include=$pid&category=$catid");
					}
				}elseif(is_search() || is_tag()){
					while ( have_posts() ){ the_post();
					$srch_posts[] = $post->ID;
					}
					if($srch_posts)
					{
						$srch_posts_str = implode(',',$srch_posts);	
					}
				$myposts = get_posts("numberposts=1000&category=$catid&include=$srch_posts_str");
				}else{
				if(is_archive()){
					if(!$paged){$paged=0;}
					global $wp_query;
					$current_term = $wp_query->get_queried_object();
					$query_var = $wp_query->query_vars;
					$catid = $current_term->term_id;

					if($current_term->taxonomy=='eventcategory')
					{
						global $wpdb;
						$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$catid\" )";
						$myposts = $wpdb->get_results($sql);
					}else
					{
						$myposts = get_posts("numberposts=10000&category=$catid");
					}					
					}else{
						$myposts = get_posts("numberposts=10000&category=$catid");
						//print_r($myposts);
						global $wpdb;
						$today = date('Y-m-d');
						$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$catid\" and t.taxonomy='".CUSTOM_CATEGORY_TYPE1."' )";
						$sql .= " AND p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and $wpdb->postmeta.meta_value>='".$today."') ";
						$event_myposts = $wpdb->get_results($sql);
						if($event_myposts)
						{
							$myposts = array_merge($myposts,$event_myposts);		
						}
					}				
				}	
				$pcnt = 0;
				if($rtn_arr)
				{
					foreach($myposts as $myposts_val)
					{					
						$rtn_val[$myposts_val->ID] = array('cat'=>$i,'pst'=>$pcnt);
						$pcnt++;
					}
				}else
				{
					foreach($myposts as $myposts_val)
					{
					$srch_arr = array("'",'"','\\');
					$rpl_arr = array('','','');
					$post_title = trim(str_replace($srch_arr,$rpl_arr,$myposts_val->post_title));
					$post_lat = trim(str_replace($srch_arr,$rpl_arr,get_post_meta($myposts_val->ID,'geo_latitude',true)));
					$post_lng = trim(str_replace($srch_arr,$rpl_arr,get_post_meta($myposts_val->ID,'geo_longitude',true)));
					$address = trim(htmlentities(str_replace($srch_arr,$rpl_arr,get_post_meta($myposts_val->ID,'address',true))));
					$contact = trim(str_replace($srch_arr,$rpl_arr,get_post_meta($myposts_val->ID,'contact',true)));
					if($myposts_val->post_type==CUSTOM_POST_TYPE1)
					{
						$timing = trim(str_replace($srch_arr,$rpl_arr,str_replace(' ','&nbsp;',date('F d',strtotime(get_post_meta($myposts_val->ID,'st_date',true)))).__('&nbsp;to&nbsp;') .str_replace(' ','&nbsp;',date('F d',strtotime(get_post_meta($myposts_val->ID,'end_date',true)))))).'<br/>'.str_replace(' ','&nbsp;',get_post_meta($myposts_val->ID,'st_time',true)).__('&nbsp;to&nbsp;') .str_replace(' ','&nbsp;',get_post_meta($myposts_val->ID,'end_time',true));	
					}else
					{
						$timing = trim(str_replace($srch_arr,$rpl_arr,get_post_meta($myposts_val->ID,'timing',true)));
					}
					$permalink = get_permalink($myposts_val->ID);
					$tooltip_message='';
					$prdimage =   bdw_get_images_with_info($myposts_val->ID,'thumb',1);
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , 'thumb'  );
					if($image[0] != '')
						$thumb = $image[0];
					elseif($prdimage[0] != '')
						$thumb = $prdimage[0];
					if($thumb)
					{
						$tooltip_message = '<img src="'.$thumb.'" width=90 height=70 style="float:left; margin:0 11px 22px 0;" />';	
					}
					$tooltip_message .= '<a href="'.$permalink.'" class=ptitle>'.$post_title.'</a>';
					$address = htmlspecialchars_decode($address);
					if($address){
					//$tooltip_message .= '<br/><span class=paddress>'. wordwrap($address,40,'<br>\n') .'</span>';
					}
					if($timing){
					$tooltip_message .= '<br/><span class=ptiming>'.wordwrap($timing,40,'<br/>\n') .'</span>';
					}
					if($contact){
					$tooltip_message .= '<br/><span class=pcontact>'.wordwrap($contact,40,'<br/>\n').'</span>';
					}
					$post_info_str .= '[\''.$post_title.'\',\''.$post_lat.'\',\''.$post_lng.'\',\''.$tooltip_message.'\'],';
				
					}
				}
				
				
				if(count($myposts)>0){$post_info_str = substr($post_info_str,0,strlen($post_info_str)-1);}
				$post_info_str .='];';
			}
		}
		if($rtn_arr)
		{
			return $rtn_val;
		}else
		{
			return $post_info_str;
		}
	}
}
$category_id_arr = array();
$category_name_arr = array();
$category_icon_arr = array();
global $map_category_name_arr,$map_category_icon_arr;
$category_info = get_category_lists($args);
if($category_info){
	foreach($category_info as $category_info_obj)
	{
		$category_id_arr[] = $category_info_obj->term_id;
		$map_category_name_arr[] = $category_info_obj->name;
		if($category_info_obj->term_icon){
		$category_icon_arr[] = $category_info_obj->term_icon;
		}else{
		$category_icon_arr[] = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
	}
	$map_category_icon_arr = $category_icon_arr;
	$category_ids = implode(',',$category_id_arr);
	$term_names = '"'.implode('", "',$map_category_name_arr).'"';
	$cat_map_icons = '"'.implode('", "',$category_icon_arr).'"';
	$post_info_str = collect_map_post_data(0,$category_id_arr);
}
?>
<script type="text/javascript">
/* <![CDATA[ */
// content of your Javascript goes here
<?php if(is_single()){global $post; ?>
var CITY_MAP_ZOOMING_FACT=17;
var CITY_MAP_CENTER_LAT = '<?php echo get_post_meta($post->ID,'geo_latitude',true);?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_post_meta($post->ID,'geo_longitude',true);?>';
<?php 
if(get_post_meta($post->ID,'map_view',true)!=''){?>
var CITY_MAP_VIEW_TYPE = <?php echo get_post_meta($post->ID,'map_view',true);?>;
<?php }?>
<?php }else{?>
var CITY_MAP_CENTER_LAT = '<?php echo get_option('ptthemes_latitute');?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_option('ptthemes_longitute');?>';
var CITY_MAP_ZOOMING_FACT=<?php echo get_option('ptthemes_scaling_factor');?>;
var CITY_MAP_VIEW_TYPE = '';
<?php if(get_option('ptthemes_disable_map_scroll_flag')=='Yes')
{
?>
var MAP_DISABLE_SCROLL_WHEEL_FLAG='Yes';
<?php
}else
{
?>
var MAP_DISABLE_SCROLL_WHEEL_FLAG='No';
<?php
}
?>
<?php }?>
var IMAGES = [<?php echo $cat_map_icons;?>]; //category image according to category
var IMAGES_SHADOW = [];
var ICONS = [];
var CAT_INFO = [<?php echo $term_names;?>];
var POST_INFO = [];
<?php echo $post_info_str;?>
/* ]]> */
</script>