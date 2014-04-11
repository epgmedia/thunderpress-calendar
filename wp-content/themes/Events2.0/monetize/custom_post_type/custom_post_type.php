<?php
/* CODE TO ADD CUSTOM POST TYPES IN THE THEME */

add_action("init", "custom_posttype_menu_wp_admin");
function custom_posttype_menu_wp_admin()
{
/*
NAME : REGISTER POST TYPE - EVENT
DESCRIPTION : ADDING A POST TYPE, CUSTOM TAXONOMY AND TAG FOR EVENT POST TYPE
*/
$custom_post_type = CUSTOM_POST_TYPE1;
$custom_cat_type = CUSTOM_CATEGORY_TYPE1;
$custom_tag_type = CUSTOM_TAG_TYPE1;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM,
														'edit' 					=>  CUSTOM_MENU_EDIT,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM,
														'new_item' 				=>  CUSTOM_MENU_NEW,
														'view_item'				=>  CUSTOM_MENU_VIEW,
														'search_items' 			=>  CUSTOM_MENU_SEARCH,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, /* SHOW UI IN ADMIN PANEL */
						'_builtin' 			=> false, /* IT IS A CUSTOM POST TYPE NOT BUILT IN */
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "$custom_post_type"), /* PERMALINKS TO EVENT POST TYPE */
						'query_var' 		=> "$custom_post_type", /* THIS GOES TO WPQUERY SCHEMA */
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);
/* EOF - REGISTER EVENT POST TYPE */
				
/* REGISTER CUSTOM TAXONOMY FOR POST TYPE EVENT */
register_taxonomy(	"$custom_cat_type", 
				array(	"$custom_post_type"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> CUSTOM_MENU_CAT_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_CAT_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_SIGULAR_CAT,
														'search_items' 		=>  CUSTOM_MENU_CAT_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_CAT_SEARCH,
														'all_items' 		=>  CUSTOM_MENU_CAT_ALL,
														'parent_item' 		=>  CUSTOM_MENU_CAT_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_CAT_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_CAT_EDIT,
														'update_item'		=>  CUSTOM_MENU_CAT_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_CAT_ADDNEW,
														'new_item_name' 	=>  CUSTOM_MENU_CAT_NEW_NAME,	), 
						'object_type' 			=> 'post',
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
/*EOF - REGISTER CUSTOM TAXONOMY FOR POST TYPE EVENT */

/* REGISTER TAG FOR POST TYPE EVENT */
register_taxonomy(	"$custom_tag_type", 
				array(	"$custom_post_type"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> CUSTOM_MENU_TAG_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_TAG_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_TAG_NAME,
														'search_items' 		=>  CUSTOM_MENU_TAG_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_TAG_POPULAR,
														'all_items' 		=>  CUSTOM_MENU_TAG_ALL,
														'parent_item' 		=>  CUSTOM_MENU_TAG_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_TAG_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_TAG_EDIT,
														'update_item'		=>  CUSTOM_MENU_TAG_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_TAG_ADD_NEW,
														'new_item_name' 	=>  CUSTOM_MENU_TAG_NEW_ADD,	),  
						'public' 			=> true,
						'object_type' 			=> 'post',
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
/* EOF - REGISTER TAG FOR EVENT */
				
/*
NAME : FUNCTION TO DISPLAY EVENT POST TYPE IN BACK END
DESCRIPTION : THIS FUNCTION ADDS COLUMNS IN EVENT POST TYPE IN BACK END
*/
add_filter( 'manage_edit-event_columns', 'templatic_edit_event_columns' ) ;
function templatic_edit_event_columns( $columns )
{
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => EVENT_TITLE_HEAD,
		'author' => AUTHOR_TEXT,
		'address' => ADDRESS,
		'start_timing' => EVENT_ST_TIME,
		'end_timing' => EVENT_END_TIME,
		'post_category' => CATGORIES_TEXT,
		'post_tags' => TAGS_TEXT_HEAD,
		'comments' => '<img src="'.get_template_directory_uri().'/images/comment-grey-bubble.png" alt="Comments">',
		'date' => DATE_TEXT
	);
	return $columns;
}
/* END OF FUNCTION */

/*
NAME : FETCH DATA FOR EVENT POST TYPE
DESCRIPTION : FETCH EVENT CATEGORIES, TAGS, ADDRESS ETC FIELD TO DISPLAY THEM IN EVENTS PAGE - BACK END
*/
add_action( 'manage_event_posts_custom_column', 'templatic_manage_event_columns', 10, 2 );
function templatic_manage_event_columns( $column, $post_id )
{
	echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
	global $post;

	switch( $column ) {
	case 'post_category' :
			/* Get the post_category for the post. */
			$templ_events = get_the_terms($post_id,CUSTOM_CATEGORY_TYPE1);
			if (is_array($templ_events)) {
				foreach($templ_events as $key => $templ_event) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_CATEGORY_TYPE1."=".$templ_event->slug."&post_type=".CUSTOM_POST_TYPE1;
					$templ_events[$key] = '<a href="'.$edit_link.'">' . $templ_event->name . '</a>';
					}
				echo implode(' , ',$templ_events);
			}else {
				_e( 'Uncategorized' );
			}
			break;
			
		case 'post_tags' :
			/* Get the post_tags for the post. */
			$templ_event_tags = get_the_terms($post_id,CUSTOM_TAG_TYPE1);
			if (is_array($templ_event_tags)) {
				foreach($templ_event_tags as $key => $templ_event_tag) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_TAG_TYPE1."=".$templ_event_tag->slug."&post_type=".CUSTOM_POST_TYPE1;
					$templ_event_tags[$key] = '<a href="'.$edit_link.'">' . $templ_event_tag->name . '</a>';
				}
				echo implode(' , ',$templ_event_tags);
			}else {
				_e( '' );
			}
				
			break;
		case 'address' :
			/* Get the address for the post. */
			$geo_address = get_post_meta( $post_id, 'address', true );
				if($geo_address != ''){
					$geo_address = $geo_address;
				} else {
					$geo_address = ' ';
				}
				echo $geo_address;
			break;
		case 'start_timing' :
			/* Get the start_timing for the post. */
			$st_date = get_post_meta( $post_id, 'st_date', true );
				if($st_date != ''){
					$st_date = $st_date.' '.get_post_meta( $post_id, 'st_time', true );
				} else {
					$st_date = ' ';
				}
				echo $st_date;
			break;
		case 'end_timing' :
			/* Get the end_timing for the post. */
			$end_date = get_post_meta( $post_id, 'end_date', true );
				if($end_date != ''){
					$end_date = $end_date.' '.get_post_meta( $post_id, 'end_time', true );
				} else {
					$end_date = ' ';
				}
				echo $end_date;
			break;
		
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
/* EOF - FETCH DATA IN BACK END */

/* ADD FILTER TO SORT THE COLUMNS IN BACK END */
add_filter( 'manage_edit-event_sortable_columns', 'templatic_event_sortable_columns' );
function templatic_event_sortable_columns( $columns ) {
	$columns['post_category'] = 'Categories';
	$columns['geo_address'] = 'Address';
	$columns['start_timing'] = 'Start time';
	$columns['end_timing'] = 'End time';
	return $columns;
}
/* EOF - SORT COLUMNS */
}

/*
NAME : FUNCTION TO FETCH POST TYPE EVENT IN RSS FEEDS
DESCRIPTION : THIS FUNCTION FETCHES THE DATA OF EVENTS IN RSS FEEDS
*/
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request');
/* EOF - FETCH EVENTS IN RSS FEEDS */
?>