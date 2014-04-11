<?php ob_start();
ini_set('set_time_limit', 0);
ini_set('max_execution_time', 0);
error_reporting(E_ERROR);

load_theme_textdomain('templatic');
load_textdomain( 'templatic', TEMPLATEPATH.'/languages/en_US.mo' );
require_once(ABSPATH.'/wp-includes/plugin.php');

define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
define('TT_ADMIN_FOLDER_NAME','admin');
define('TT_ADMIN_FOLDER_PATH',TEMPLATEPATH.'/'.TT_ADMIN_FOLDER_NAME.'/'); //admin folder path

/* call file for advanced setting variables */
if(file_exists(TT_ADMIN_FOLDER_PATH . 'constants.php')){
	include_once(TT_ADMIN_FOLDER_PATH.'constants.php');  //ALL CONSTANTS FILE INTEGRATOR
}

/**-- add an image size for detail page and slider Begin--*/
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(125, 75); // default Post Thumbnail dimensions   
	update_option('thumbnail_size_w', 125);
	update_option('thumbnail_size_h', 75);
	if(get_option('thumbnail_crop')==''){
	update_option('thumbnail_crop', 0);
	}
	add_theme_support( 'nav-menus' );
	add_theme_support( 'automatic-feed-links' );
	add_image_size('detail_page_image',570, 400, false);//(cropped)
	add_image_size('listing_img',125, 75, false);//(cropped)
}

/* add an image size for detail page and slider End */

/* Set the file extension for allown only image/picture file extension in upload file*/
$extension_file=array('.jpg','.JPG','jpeg','JPEG','.png','.PNG','.gif','.GIF','.jpe','.JPE');  
global $extension_file;

/*
Description : admin folder file integration contain the coad for basic settings and option tree integration to save different input types.
*/
include_once(TT_ADMIN_FOLDER_PATH.'admin_main.php');  //ALL ADMIN FILE INTEGRATOR
require_once (TEMPLATEPATH . '/library/functions/theme_variables.php');

/* Plugin file for plugin functions integration */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once ($functions_path . 'custom_functions.php');/* file for custom functions */
/* file for facebook events integration for page template */
if(!is_plugin_active('facebook-comments-for-wordpress/facebook-comments.php') && _iscurlinstalled() && !strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
include_once (TEMPLATEPATH.'/library/facebook-platform/src/facebook.php');
}
/* file contaion inclution of all monetize files */
if(file_exists(TT_MODULES_FOLDER_PATH . 'modules_main.php'))
{
		include_once (TT_MODULES_FOLDER_PATH . 'modules_main.php'); // Theme moduels include file
}

require(TEMPLATEPATH. "/library/includes/auto_install/auto_install.php");/* to run auto install */

/*************************************************************
* Do not modify unless you know what you're doing, SERIOUSLY!
*************************************************************/

add_theme_support( 'automatic-feed-links' );
	
global $blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
include_once (TEMPLATEPATH . '/library/map/map_functions.php'); /* contaion all mapping functions and files */
include_once (TEMPLATEPATH . '/library/rating/post_rating.php'); /* contaion all rating functions and files */

include_once (TEMPLATEPATH . '/language.php');
include_once (TEMPLATEPATH . '/library/functions/theme_variables.php');

//** FRONT-END FILES **//

include_once ($functions_path . 'widgets_functions.php'); /* file for widget creation */
include_once ($functions_path . 'common_widgets.php');
include_once ($functions_path . 'custom_functions.php'); /* file contain custom functions */
include_once ($functions_path . 'comments_functions.php'); /* contain function for comments form */
include_once ($functions_path . 'yoast-breadcrumbs.php');
include_once ($functions_path . 'most-popular.php');
include_once ($functions_path . 'image_resizer.php');/* contain code to resize image while upload */
include_once ($functions_path . 'listing_filters.php'); /* filtering posts while search and list*/

add_action( 'init', 'register_templatic_menus' );

/* DEFINE NAME FOR RATING TABLE */
$rating_table_name = $wpdb->prefix.'ratings';
global $rating_table_name;


/* FILTERS TO ADD A COLUMN ON ALL USRES PAGE */
add_filter('manage_users_columns', 'add_event_column');
add_filter('manage_users_custom_column', 'view_event_column', 10, 3);

/* FUNCTION TO ADD A COLUMN */
function add_event_column($columns) {
$columns['events'] = 'Events';
return $columns;

}

/* FUNCTION TO DISPLAY NUMBER OF ARTICLES */
function view_event_column($out, $column_name, $user_id)
{
	global $wpdb,$events;
	if( $column_name == 'events' )
	{
		$events = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = '".CUSTOM_POST_TYPE1."' AND post_author = ".$user_id."");
	}
	return $events;
}
/* EOF - ADD COLUMN ON ALL USERS PAGE */

/*
 * Add action save posts for store then recurring event user template
 */
add_action( 'save_post', 'recurring_event_user' );
function recurring_event_user()
{
	global $post;	
	if(isset($_POST['page_template']) && $_POST['page_template']=='template_recurring_event_user.php')
	{
		update_option('recurring_event_page_template_id',$post->ID);
	}
	
}

/* START School Webworks Code to protect event submitters from getting into the admin to create posts. */
function get_user_role() {
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
	return $user_role;
}

function sno_header_redirect() {
	if (is_user_logged_in()) {
		$currentrol =  get_user_role();
	    if ( $currentrol=='author'  ) {	
		    if (headers_sent()) {
	            echo '<meta http-equiv="refresh" content="0;url="/">';
	            echo '<script type="text/javascript">document.location.href="/"</script>';
	        } else {
	            wp_redirect('/');
	            exit();
	        }
		}
	}
}

function sno_header_removebar() {
	if (is_user_logged_in()) {
		$currentrol =  get_user_role();
	    if ( $currentrol=='author'  ) {	
	    	show_admin_bar(false);
		}
	}
}

add_action('admin_head', 'sno_header_redirect');
add_action('wp_head', 'sno_header_removebar');
/* END School Webworks Code */

?>