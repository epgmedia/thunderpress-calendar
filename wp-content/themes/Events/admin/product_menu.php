<?php

/************* Theme Options Page **********/
/*
Name : mkt_add_product
Description : Add the menu at admin side
*/
add_action('admin_menu', 'mkt_add_product'); //Add new menu block to admin side

function mkt_add_product(){	
	
	add_theme_page('product_menu.php', CUSTOM_MENU_GENERAL_SETTINGS, CUSTOM_MENU_GENERAL_SETTINGS, 8, 'product_menu.php', 'admin_settings');
	add_theme_page('product_menu.php', "Design Settings", "Design Settings", 8, 'theme_settings', 'theme_settings');
	add_theme_page('product_menu.php', "Payment Options", "Payment Options", 8, 'paymentoptions', 'payment_options');
	add_theme_page('product_menu.php', "Catetory Icons", "Catetory Icons", 8, 'catetory_icons', 'catetory_icons');
	add_theme_page('product_menu.php', "Manage Coupon", "Manage Coupon", 8, 'managecoupon', 'manage_coupon');
	add_theme_page('product_menu.php', "Manage Price", "Manage Price", 8, 'price', 'manage_price');
	add_theme_page('product_menu.php', "Manage Post Custom Fields", "Custom Field Settings", 8, 'custom', 'manage_custom');
	add_theme_page('product_menu.php', "Bulk Upload", "Bulk Upload", 8, 'bulk', 'bulk_upload');
}
/*
Name : mkt_add_product
Description : Camm when click on Manage Post Custom Fields, returns custom fields
*/
function manage_custom()
{
	include_once(TEMPLATEPATH . '/admin/admin_manage_custom_fields.php');
}

/*
Name : bulk_upload
Description : Camm when click on Bulk upload, returns Bulk upload feature
*/ 
function bulk_upload()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_bulk_upload.php');
}
/*
Name : admin_settings
Description : Camm when click on settings, returns admin setings
*/
function admin_settings()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_settings.php');
}
/*
Name : theme_settings
Description : Camm when click on theme settings, returns theme setings
*/
function theme_settings()
{
	mytheme_add_admin();
}
/*
Name : payment_options
Description : Camm when click on Payment options, returns payment options
*/
function payment_options()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_paymethods.php');
}
/*
Name : catetory_icons
Description : Camm when click on Category settings, returns category price and icons settings
*/
function catetory_icons()
{
	include_once(TEMPLATEPATH . '/library/includes/admin_catetory_icons.php');
}

/*
Name : manage_coupon
Description : Camm when click on Manage coupons, returnssettings for add coupons.
*/
function manage_coupon()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_coupon.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_coupon.php');
	}
}
/*
Name : manage_price
Description : Camm when click on Manage price packages, returns price package settins.
*/ 
function manage_price()
{
	if($_REQUEST['pagetype']=='addedit')
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_price.php');
	}else
	{
		include_once(TEMPLATEPATH . '/library/includes/admin_manage_price.php');
	}
}
?>