<?php
/*  Theme Options Page */
$admin_menu_access_level = apply_filters('templ_admin_menu_access_level_filter',8);
define('TEMPL_ACCESS_USER',$admin_menu_access_level);
add_action('admin_menu', 'templ_admin_menu'); //Add new menu block to admin side
/*
Name : templ_admin_menu
Description : return action for admin menu.
*/
add_action('templ_admin_menu', 'templ_add_admin_menu');
function templ_admin_menu()
{
	do_action('templ_admin_menu');	
}

/*
Name : templ_add_admin_menu
Description : Add admin menu.
*/

function templ_add_admin_menu(){
	$menu_title = apply_filters('templ_admin_menu_title_filter',__('Theme Settings','templatic'));
	if(function_exists('add_object_page'))
    {
       add_object_page("Admin Menu",  $menu_title, 'administrator', 'templatic_wp_admin_menu', 'design', TT_ADMIN_FOLDER_URL.'images/favicon.ico', 1);  // title of new sidebar
    }
    else
    {
       add_add_menu_page("Admin Menu",  $menu_title, 'administrator', 'templatic_wp_admin_menu', 'design', TT_ADMIN_FOLDER_URL.'images/favicon.ico'); // title of new sidebar
    }
	$menu_title = apply_filters('templ_design_menu_title_filter',__('Basic settings','templatic'));
	add_submenu_page('templatic_wp_admin_menu', $menu_title,$menu_title, 'administrator', 'templatic_wp_admin_menu', 'design');
	add_submenu_page('templatic_wp_admin_menu', __('Advanced Settings',''),__("Advanced Settings"), 'administrator', 'manage_settings', 'manage_settings'); // sublink2
}

/*
Name : design
Description : call function when click on basic settings
*/

function design()
{
	include_once(TT_ADMIN_FOLDER_PATH . 'theme_options/options.php');
}
/*
Name : manage_settings
Description : call function when click on Advance settings
*/
function manage_settings()
{
	include_once(TT_MODULES_FOLDER_PATH.'manage_settings/admin_manage_settings.php');

}
?>