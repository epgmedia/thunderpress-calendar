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
	//update_option('thumbnail_size_w', 125);
	//update_option('thumbnail_size_h', 75);
	if(get_option('thumbnail_crop')==''){
	update_option('thumbnail_crop', 0);
	}
	add_theme_support( 'nav-menus' );
	add_theme_support( 'automatic-feed-links' );
	add_image_size('detail_page_image',570, 400, false);//(cropped)
	add_image_size('listing_img',125, 75, false);//(cropped)
	add_image_size('home_listing_img',125, 125, false);//(cropped)
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
function my_custom_post_status(){
	register_post_status( 'recurring', array(
		'label'                     => _x( 'Recurring', 'event' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Recurring <span class="count">(%s)</span>', 'Recurring <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'my_custom_post_status' );


if(is_admin() && ($pagenow =='themes.php' || $pagenow =='post.php' || $pagenow =='edit.php'|| $pagenow =='admin-ajax.php' || @$_REQUEST['page'] == 'tmpl_theme_update')){
	require_once('wp-updates-theme.php');	
	new WPUpdatesEventsUpdater( 'http://templatic.com/updates/api', basename(get_stylesheet_directory_uri()) );	
}

/* frame work update templatic menu*/
function tmpl_support_theme(){
	echo "<h3>Need Help?</h3>";
	echo "<p>Here's how you can get help from templatic on any thing you need with regarding this theme. </p>";
	echo "<br/>";
	echo '<p><a href="http://templatic.com/docs/events-theme-guide/" target="blank">'."Take a look at theme guide".'</a></p>';
	echo '<p><a href="http://templatic.com/docs/" target="blank">'."Knowlegebase".'</a></p>';
	echo '<p><a href="http://templatic.com/forums/" target="blank">'."Explore our community forums".'</a></p>';
	echo '<p><a href="http://templatic.com/helpdesk/" target="blank">'."Create a support ticket in Helpdesk".'</a></p>';
}

/* framework update templatic menu*/
function tmpl_purchase_theme(){
	wp_redirect( 'http://templatic.com/wordpress-themes-store/' ); 
	exit;
}

/* frame work update templatic menu*/
function tmpl_theme_update(){
	
	require_once(get_stylesheet_directory()."/templatic_login.php");
}



add_action('admin_menu','events_theme_menu',11); // add submenu page 
function events_theme_menu(){

	add_menu_page( 'Theme Update','Theme Update', 'administrator', 'tmpl_theme_update', 'tmpl_theme_update' );
	
	add_submenu_page( 'tmpl_theme_update', 'Get Support' ,'Get Support' , 'administrator', 'tmpl_support_theme', 'tmpl_support_theme');
	
	add_submenu_page( 'tmpl_theme_update', 'Purchase theme','Purchase theme', 'administrator', 'tmpl_purchase_theme', 'tmpl_purchase_theme');
}
//Set Default permalink on theme activation: start
add_action( 'load-themes.php', 'default_permalink_set' );
if(!function_exists('default_permalink_set')){
	function default_permalink_set(){
		global $pagenow;
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){ // Test if theme is activate
			//Set default permalink to postname start
			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure( '/%postname%/' );
			$wp_rewrite->flush_rules();
			if(function_exists('flush_rewrite_rules')){
				flush_rewrite_rules(true);  
			}
			//Set default permalink to postname end
		}
	}
}
//Set Default permalink on theme activation: end
?>