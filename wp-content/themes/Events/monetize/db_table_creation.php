<?php

global $wpdb,$table_prefix;

/* =================================== ENABLE DEFAULT OPTIONS ================================= */
if(!get_option('ptthemes_alt_stylesheet'))
{
	add_option('ptthemes_alt_stylesheet','blue');
}
if(get_option('ptthemes_logo_url') =='')
{
	add_option("ptthemes_logo_url",get_template_directory_uri()."/skins/1-default/logo.png");
}
if(!get_option('ptthemes_notification_type'))
{
add_option('ptthemes_notification_type','PHP Mail'); 
}
if(!get_option('ptthemes_page_layout'))
{
add_option('ptthemes_page_layout','Right Sidebar'); 
}
if(!get_option('ptthemes_auto_install'))
{
add_option('ptthemes_auto_install','No'); 
}
if(!get_option('ptttheme_fb_opt'))
{
update_option('ptttheme_fb_opt','No'); 
}
if(!get_option('ptthemes_event_sorting'))
{
add_option('ptthemes_event_sorting','Latest Published'); 
}
if(!get_option('ptthemes_show_menu'))
{
add_option('ptthemes_show_menu','No'); 
}
if(!get_option('ptthemes_show_addevent_link'))
{
add_option('ptthemes_show_addevent_link','Yes'); 
}
if(!get_option('ptthemes_customcss'))
{
	add_option('ptthemes_customcss','Deactivate');
}
if(!get_option('ptthemes_noindex_category'))
{
	add_option('ptthemes_noindex_category','No'); 
}
if(!get_option('ptthemes_archives_noindex'))
{
	add_option('ptthemes_archives_noindex','No'); 
}
if(!get_option('ptthemes_noindex_tag'))
{
	add_option('ptthemes_noindex_tag','No');
}
if(!get_option('ptthemes_recaptcha'))
{
	add_option('ptthemes_recaptcha','None of them'); 
}
if(!get_option('ptthemes_use_third_party_data'))
{
	add_option('ptthemes_use_third_party_data','No'); 
}
if(!get_option('pttheme_seo_hide_fields'))
{
	add_option('pttheme_seo_hide_fields','No'); 
}
if(!get_option('is_user_eventlist'))
{
	add_option('is_user_eventlist','Yes'); 
}
if(!get_option('approve_status'))
{
	add_option('approve_status','Published'); 
}
if(!get_option('ptthemes_category_display'))
{
	add_option('ptthemes_category_display','checkbox'); 
}
if(!get_option('is_allow_coupon_code'))
{
	add_option('is_allow_coupon_code','Yes'); 
}
if(!get_option('ptttheme_currency_code'))
{
	add_option('ptttheme_currency_code','USD'); 
}
if(!get_option('ptttheme_currency_symbol'))
{
	add_option('ptttheme_currency_symbol','$'); 
}
if(!get_option('ptttheme_currency_position'))
{
	add_option('ptttheme_currency_position','Symbol Before amount'); 
}
if(!get_option('ptthemes_latitute'))
{
	add_option('ptthemes_latitute','34'); 
}
if(!get_option('ptthemes_longitute'))
{
	add_option('ptthemes_longitute','0'); 
}
if(!get_option('ptthemes_scale_factor'))
{
	add_option('ptthemes_scale_factor','11'); 
}
if(!get_option('pttthemes_maptype'))
{
	add_option('pttthemes_maptype','Roadmap'); 
}
if(!get_option('ptthemes_listing_ex_status'))
{
	add_option('ptthemes_listing_ex_status','Draft'); 
}
if(!get_option('ptthemes_listing_expiry_disable'))
{
	add_option('ptthemes_listing_expiry_disable','No'); 
}
if(!get_option('listing_email_notification'))
{
	add_option('listing_email_notification','5'); 
}
if(!get_option('ptthemes_listing_preexpiry_notice_disable'))
{
	add_option('ptthemes_listing_preexpiry_notice_disable','No'); 
}
if(!get_option('ptthemes_email_on_detailpage'))
{
	add_option('ptthemes_email_on_detailpage','Yes'); 
}
if(!get_option('ptthemes_related_event'))
{
	add_option('ptthemes_related_event','3'); 
}
if(!get_option('ptthemes_detail_gallery_map_flag'))
{
	add_option('ptthemes_detail_gallery_map_flag','Map &amp; Gallery Both - Default Map'); 
}
if(!get_option('pt_show_postacomment'))
{
	add_option('pt_show_postacomment','Yes'); 
}
if(!get_option('ptthemes_disable_rating'))
{
	add_option('ptthemes_disable_rating','No'); 
}
if(!get_option('ptthemes_print'))
{
	add_option('ptthemes_print','Yes'); 
}
if(!get_option('ptthemes_share'))
{
	add_option('ptthemes_share','Yes'); 
}
if(!get_option('ptthemes_facebook'))
{
	add_option('ptthemes_facebook','Yes'); 
}
if(!get_option('ptthemes_enable_claim'))
{
	add_option('ptthemes_enable_claim','Yes'); 
}
if(!get_option('ptthemes_attending_event'))
{
	add_option('ptthemes_attending_event','Yes'); 
}
if(!get_option('ptthemes_category_map_event'))
{
add_option('ptthemes_category_map_event','Yes'); }
if(!get_option('ptthemes_package_type')){
update_option("ptthemes_package_type","Listing as per subscriptions");
}
if(!get_option('ptthemes_max_image_size')){
update_option("ptthemes_max_image_size",90000);
}
/* Custom Post Field TABLE Creation BOF */

$custom_post_meta_db_table_name = strtolower($table_prefix . "templatic_custom_post_fields");
global $custom_post_meta_db_table_name,$wpdb ;

//$wpdb->query("DROP TABLE $custom_post_meta_db_table_name");

$custom_field_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'field_category'");
if('field_category' != $custom_field_check)	{
	$custom_dbuser_table_alter = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `field_category` TEXT NOT NULL AFTER `admin_title`");
}
$custom_editfield_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'is_edit'");
if('is_edit' != $custom_editfield_check)	{
	$custom_editdbuser_table_alter = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `is_edit` tinyint(4) NOT NULL AFTER `is_delete`");
}
$custom_searchfield_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'is_search'");
if('is_search' != $custom_searchfield_check)	{
	$custom_searchbuser_table_alter = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `is_search` tinyint(2) NOT NULL AFTER `is_require`");
}
$custom_onpagefield_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'show_on_page'");
if('show_on_page' != $custom_onpagefield_check)	{
	$custom_onpagefield_check = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `show_on_page` char(10) NOT NULL AFTER `is_require`");
}


if($wpdb->get_var("SHOW TABLES LIKE \"$custom_post_meta_db_table_name\"") != $custom_post_meta_db_table_name){
$wpdb->query("CREATE TABLE IF NOT EXISTS $custom_post_meta_db_table_name (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `post_type` varchar(255) NOT NULL,
  `admin_title` varchar(255) NOT NULL,
  `field_category` varchar(118) NOT NULL ,
  `htmlvar_name` varchar(255) NOT NULL,
  `admin_desc` text NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `ctype` varchar(255) NOT NULL COMMENT 'text,checkbox,date,radio,select,textarea,upload',
  `default_value` text NOT NULL,
  `option_values` text NOT NULL,
  `clabels` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `is_edit` tinyint(4) NOT NULL DEFAULT '1',
  `is_require` tinyint(4) NOT NULL DEFAULT '0',
  `show_on_page` varchar(20) NOT NULL ,
  `show_on_listing` tinyint(4) NOT NULL DEFAULT '1',
  `show_on_detail` tinyint(4) NOT NULL DEFAULT '1',
  `field_require_desc` text NOT NULL,
  `style_class` varchar(200) NOT NULL,
  `extra_parameter` text NOT NULL,
  `validation_type` varchar(20) NOT NULL,
  PRIMARY KEY (`cid`)
);");
global $wpdb;

$qry = $wpdb->query("INSERT INTO $custom_post_meta_db_table_name (`cid`, `post_type`, `admin_title`, `field_category`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_edit`, `is_require`, `show_on_page`, `show_on_listing`, `show_on_detail`, `field_require_desc`, `style_class`, `extra_parameter`, `validation_type`) VALUES
(1, 'event', 'Event Title', '0', 'event_name', '', 'Event Title', 'text', '', '', 'Event Title', 1, 1, 0, 1, 1, 'user_side', 0, 0, 'Please Enter Event Title', '', '', 'require'),
(2, 'event', 'Address', '0', 'address', '', 'Address', 'text', '', '', 'Address', 2, 1, 0, 1, 1, 'both_side', 0, 0, 'Please Enter Address', '', '', 'require'),
(3, 'event', 'Address', '0', 'geo_address', 'Please enter listing address. eg. : <b>230 Vine Street And locations throughout Old City, Philadelphia, PA 19106</b>', 'Address', 'geo_map', '', '', 'Address', 3, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter address to locate your location on map.', '', '', ' '),
(4, 'event', 'Address Latitude', '0', 'geo_latitude', 'Please enter latitude for google map perfection. eg. : 39.955823048131286', 'Address Latitude', 'text', '', '', 'Address Latitude', 4, 1, 0, 1, 1, 'both_side', 0, 0, 'Please Enter Address Latitude', '', '', ''),
(5, 'event', 'Address Longitude', '0', 'geo_longitude', 'Please enter logngitude for google map perfection. eg. : -75.14408111572266', 'Address Longitude', 'text', '', '', 'Address Longitude', 5, 1, 0, 1, 1, 'both_side', 0, 0, 'Please Enter Address Longitude', '', '', ''),
(6, 'event', 'Google Map View', '0', 'map_view', '', 'Google Map View', 'radio', '', 'Road Map,Terrain Map,Satellite Map', 'Google Map View', 6, 1, 0, 1, 0, 'both_side', 0, 0, 'Please select event type', '', '', ' '),
(7, 'event', 'Event Start Date', '0', 'st_date', 'Enter Event Start Date. eg. : <b>2011-09-05</b>', 'Event Start Date', 'date', '', '', 'Event Start Date', 7, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter start date of an avent.', 'st_date', '', ' '),
(8, 'event', 'Event End Date', '0', 'end_date', 'Enter Event End Date. eg. : <b>2011-09-05</b>', 'Event End Date', 'date', '', '', 'Event End Date', 8, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter end date of event.', 'end_date', '', ' '),
(9, 'event', 'Start Time', '0', 'st_time', 'Enter Event Start Time. eg. : <b>10:14</b>', 'Start Time', 'text', '', '', 'Start Time', 9, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter start time of an event.', 'st_time', '', ' '),
(10, 'event', 'End Time', '0', 'end_time', 'Enter Event End Time. eg. : <b>10:14</b>', 'End Time', 'text', '', '', 'End Time', 10, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter event end time.', 'end_time', '', ' '),
('11', 'event', 'Consider this event as', '0', 'event_type', '', 'Consider this event as', 'radio', 'Regular event', 'Regular event, Recurring event', 'Consider this event as', 11, 1, 0, 1, 0, 'both_side', 0, 0, '', '', 'event_type', ''),
(12, 'event', 'Event Description', '0', 'proprty_desc', 'Note : Basic HTML tags are allowed', 'Event Description', 'texteditor', 'You should enter description content for your listing.', '', 'Event Description', 12, 1, 0, 1, 1, 'user_side', 0, 1, 'Please enter description of an event.', '', '', 'require'),
(13, 'event', 'How to Register', '0', 'reg_desc', 'Enter how to register details ', 'How to Register', 'texteditor', '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href &equiv; &acute;javascript:void(0)&acute; mce_href &equiv; &acute;javascript:void(0)&acute; class &equiv; &acute;button&acute;>Register Now</a></p>', '', 'How to Register', 13, 1, 1, 1, 0, 'both_side', 0, 1, '', '', '', ' '),
(14, 'event', 'Phone', '0', 'phone', 'You can enter phone number,cell phone number etc.', 'Phone', 'text', '', '', 'Phone', 14, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' '),
(15, 'event', 'Email', '0', 'email', '', 'Email', 'text', '', '', 'Email', 15, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' '),
(16, 'event', 'Website', '0', 'website', 'Enter website URL. eg. : http://myplace.com', 'Website', 'text', '', '', 'Website', 16, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' '),
(17, 'event', 'Twitter', '0', 'twitter', 'Enter twitter URL. eg. : http://twitter.com/myplace', 'Twitter', 'text', '', '', 'Twitter', 17, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' '),
(18, 'event', 'Facebook', '0', 'facebook', 'Enter facebook URL. eg. : http://facebook.com/myplace', 'Facebook', 'text', '', '', 'Facebook', 18, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' '),
(19, 'event', 'Video', '0', 'video', '', 'Video', 'textarea', '', '', 'Video', 19, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' '),
(20, 'event', 'Select Images', '0', 'listing_image', 'Note : You can sort images from Dashboard and then clicking on &quot; Edit&quot; in the lisitng', 'Select Images', 'image_uploader', '', '', 'Select Images', 20, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ''),
(21, 'organizer', 'Organizer Name', '0', 'organizer_name', 'Name of Organizer of the this Event. eg. : Castor Event Organizers', 'Organizer Name', 'text', '', '', 'Organizer Name', 21, 1, 0, 1, 0, 'both_side', 0, 0, 'Please Enter Organizer Name', '', '', ''),
(22, 'organizer', 'Organizer Email', '0', 'organizer_email', 'Email ID of Organizer of this Event. eg. : steve@event.com', 'Email', 'text', '', '', 'Organizer Email', 22, 1, 0, 1, 0, 'both_side', 0, 0, 'Please Enter Email', '', '', ''),
(23, 'organizer', 'Select Logo', '0', 'organizer_logo', 'PNG, GIF of JPEG only, for better image quality upload image size 150x150', 'Select Logo', 'upload', '', '', 'Select Logo', 23, 1, 0, 1, 0, 'both_side', 0, 0, 'Please Enter Organizer Name', '', '', ''),
(24, 'organizer', 'Organizer Address', '0', 'organizer_address', 'Address of Organizer eg. : 5 Buckingham Dr Street, paris, NX, USA - 21478', 'Address', 'text', '', '', 'Organizer Address', 24, 1, 0, 1, 0, 'both_side', 0, 0, '', '', '', ''),
(25, 'organizer', 'Organizer Contact Info.', '0', 'organizer_contact', 'Contact Information of Organizer eg. : 01-025-98745871', 'Contact Info.', 'text', '', '', 'Organizer Contact Info.', 24, 1, 0, 1, 0, 'both_side', 0, 0, '', '', '', ''),
(26, 'organizer', 'Organizer Website', '0', 'organizer_website', 'Website of Organizer eg. : http://steve.com', 'Website', 'text', '', '', 'Organizer Website', 26, 1, 0, 1, 0, 'both_side', 0, 0, '', '', '', ''),
(27, 'organizer', 'Organizer Mobile', '0', 'organizer_mobile', 'Mobile of Organizer eg. : 0897456123071', 'Mobile', 'text', '', '', 'Organizer Mobile', 27, 1, 0, 1, 0, 'both_side', 0, 0, '', '', '', ''),
(28, 'organizer', 'Short Description', '0', 'organizer_desc', 'Short Description of Organizer. Basic HTML tags are allowed', 'Short Description', 'texteditor', '', '', 'Short Description', 28, 1, 0, 1, 0, 'both_side', 0, 1, '', '', '', '')");
}

$is_recurring = $wpdb->get_row("select * from $custom_post_meta_db_table_name where htmlvar_name LIKE 'event_type'");
if(!$is_recurring){
$ins = "INSERT INTO $custom_post_meta_db_table_name (`cid`, `post_type`, `admin_title`, `field_category`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_edit`, `is_require`, `show_on_page`, `show_on_listing`, `show_on_detail`, `field_require_desc`, `style_class`, `extra_parameter`, `validation_type`) VALUES
('11', 'event', 'Consider this event as', '0', 'event_type', '', 'Consider this event as', 'radio', 'Regular event', 'Regular event, Recurring event', 'Consider this event as', 11, 1, 0, 1, 0, 'both_side', 0, 0, '', '', 'event_type', '')";
$wpdb->query($ins);
}




/* Price TABLE Creation BOF */

//================================= INSERT PAYMENT METHODS ===================================================//
/////////////// PAYMENT SETTINGS START ///////////////
$paymethodinfo = array();
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Merchant Id",
				"fieldname"		=>	"merchantid",
				"value"			=>	"myaccount@paypal.com",
				"description"	=>	"Example : myaccount@paypal.com",
				);
$payOpts[] = array(
				"title"			=>	"Cancel Url",
				"fieldname"		=>	"cancel_return",
				"value"			=>	get_option('home')."/?ptype=cancel_return&pmethod=paypal",
				"description"	=>	"Example : http://mydomain.com/cancel_return.php",
				);
$payOpts[] = array(
				"title"			=>	"Return Url",
				"fieldname"		=>	"returnUrl",
				"value"			=>	get_option('home')."/?ptype=return&pmethod=paypal",
				"description"	=>	"Example : http://mydomain.com/return.php",
				);
$payOpts[] = array(
				"title"			=>	"Notify Url",
				"fieldname"		=>	"notify_url",
				"value"			=>	get_option('home')."/?ptype=notifyurl&pmethod=paypal",
				"description"	=>	"Example : http://mydomain.com/notifyurl.php",
				);								
$paymethodinfo[] = array(
					"name" 		=> 'Paypal',
					"key" 		=> 'paypal',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'1',
					"payOpts"	=>	$payOpts,
					);
//////////pay settings end////////
//////////google checkout start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Merchant Id",
				"fieldname"		=>	"merchantid",
				"value"			=>	"1234567890",
				"description"	=>	"Example : 1234567890"
				);
$paymethodinfo[] = array(
					"name" 		=> 'Google Checkout',
					"key" 		=> 'googlechkout',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'2',
					"payOpts"	=>	$payOpts,
					);
//////////google checkout end////////
//////////authorize.net start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Login ID",
				"fieldname"		=>	"loginid",
				"value"			=>	"yourname@domain.com",
				"description"	=>	"Example : yourname@domain.com"
				);
$payOpts[] = array(
				"title"			=>	"Transaction Key",
				"fieldname"		=>	"transkey",
				"value"			=>	"1234567890",
				"description"	=>	"Example : 1234567890",
				);
$paymethodinfo[] = array(
					"name" 		=> 'Authorize.net',
					"key" 		=> 'authorizenet',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'3',
					"payOpts"	=>	$payOpts,
					);
//////////authorize.net end////////
//////////worldpay start////////
$payOpts = array();	
$payOpts[] = array(
				"title"			=>	"Instant Id",
				"fieldname"		=>	"instId",
				"value"			=>	"123456",
				"description"	=>	"Example : 123456"
				);
$payOpts[] = array(
				"title"			=>	"Account Id",
				"fieldname"		=>	"accId1",
				"value"			=>	"12345",
				"description"	=>	"Example : 12345"
				);
$paymethodinfo[] = array(
					"name" 		=> 'Worldpay',
					"key" 		=> 'worldpay',
					"isactive"	=>	'1', // 1->display,0->hide\
					"display_order"=>'4',
					"payOpts"	=>	$payOpts,
					);
//////////worldpay end////////
//////////2co start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Vendor ID",
				"fieldname"		=>	"vendorid",
				"value"			=>	"1303908",
				"description"	=>	"Enter Vendor ID Example : 1303908"
				);
$payOpts[] = array(
				"title"			=>	"Notify Url",
				"fieldname"		=>	"ipnfilepath",
				"value"			=>	get_option('home')."/?ptype=notifyurl&pmethod=2co",
				"description"	=>	"Example : http://mydomain.com/2co_notifyurl.php",
				);
$paymethodinfo[] = array(
					"name" 		=> '2CO (2Checkout)',
					"key" 		=> '2co',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'5',
					"payOpts"	=>	$payOpts,
					);
//////////2co end////////
//////////pre bank transfer start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Bank Information",
				"fieldname"		=>	"bankinfo",
				"value"			=>	"ICICI Bank",
				"description"	=>	"Enter the bank name to which you want to transfer payment"
				);
$payOpts[] = array(
				"title"			=>	"Account ID",
				"fieldname"		=>	"bank_accountid",
				"value"			=>	"AB1234567890",
				"description"	=>	"Enter your bank Account ID",
				);
$paymethodinfo[] = array(
					"name" 		=> 'Pre Bank Transfer',
					"key" 		=> 'prebanktransfer',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'6',
					"payOpts"	=>	$payOpts,
					);				
//////////pre bank transfer end////////
//////////pay cash on devivery start////////
$payOpts = array();
$paymethodinfo[] = array(
					"name" 		=> 'Pay Cash On Delivery',
					"key" 		=> 'payondelevary',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'7',
					"payOpts"	=>	$payOpts,
					);
//////////pay cash on devivery end////////

/**		Paypal pro Start		**/
	
$payOpts = array();
$payOpts[] = array(
				"title"		  => "API Username",
				"fieldname"   => "api_username",
				"value"		  => "yourusername",
				"description" => "Paypal Pro API Username.<br/> ( You will get API Credentials from paypal pro. )",
				);
				
$payOpts[] = array(
				"title"		  => "API Password",
				"fieldname"   => "api_password",
				"value"		  => "12345",
				"description" => "Paypal Pro API Password.",
				);

$payOpts[] = array(
				"title"		  => "Signature",
				"fieldname"   => "api_signature",
				"value"		  => "AHzdfe455464fdfgbdfgdf-FAsfe334",
				"description" => "Paypal Pro Signature.",
				);				

$payOpts[] = array(
				"title"		  => "Currency",
				"fieldname"   => "api_currency",
				"value"		  => "USD",
				"description" => "Currency Code. ( eg. USD )",
				);

$paymethodinfo[] = array(
						"name" 		=> 'Paypal Pro',
						"key" 		=> 'paypal_pro',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'8',
						"payOpts"	=>	$payOpts,
						);				

/**		Paypal pro End		**/

for($i=0;$i< count($paymethodinfo);$i++)
{
$payment_method_info = array();
$payment_method_info  = get_option('payment_method_'.$paymethodinfo[$i]['key']);
if(!$payment_method_info)
{
	update_option('payment_method_'.$paymethodinfo[$i]['key'],$paymethodinfo[$i]);
}
}
/////////////// PAYMENT SETTINGS END ///////////////




/* =========================================== Price TABLE Creation BOF ===================================== */

$price_db_table_name = $table_prefix . "price";

global $price_db_table_name;
if($wpdb->get_var("SHOW TABLES LIKE \"$price_db_table_name\"") != $price_db_table_name){
	$price_table = 'CREATE TABLE IF NOT EXISTS '.$price_db_table_name.' (
	  `pid` int(11) NOT NULL AUTO_INCREMENT,
	  `price_title` varchar(255) NOT NULL,
	  `price_desc` varchar(1000) NOT NULL,
	  `price_post_type` varchar(100) NOT NULL,
	  `price_post_cat` varchar(100) NOT NULL,
	  `is_show` varchar(10) NOT NULL,
	  `package_cost` int(10) NOT NULL,
	  `validity` int(10) NOT NULL,
	  `validity_per` varchar(10) NOT NULL,
	  `status` int(10) NOT NULL ,
	  `is_recurring` int(10) NOT NULL ,
	  `billing_num` int(10) NOT NULL,
	  `billing_per` varchar(10) NOT NULL,
	  `billing_cycle` varchar(10) NOT NULL,
	  `is_featured` int(10) NOT NULL,
	  `feature_amount` int(10) NOT NULL,
	  `feature_cat_amount` int(10) NOT NULL,
	  PRIMARY KEY (`pid`)
	)'; 
	$wpdb->query($price_table);

	$price_insert = '
	INSERT INTO `'.$price_db_table_name.'` (`pid`, `price_title`, `price_desc`, `price_post_type`, `price_post_cat`,`is_show`,`package_cost`,`validity`,`validity_per`,`status`,`is_recurring`,`billing_num`,`billing_per`,`billing_cycle`,`is_featured`,`feature_amount`,`feature_cat_amount`) VALUES
	(1, "Free", "Special time-limited offer: No charges for listing your event.", "event","","1","0","Unlimited","","1","","","","", 1,"0","0"),(2, "Summer pack", "Special time-limited offer", "event","","1","40","3","M","1","","","","",1,"10","4")';
	$wpdb->query($price_insert);
}$price_title = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_title'");
if(!isset($price_title))	{
$wpdb->query("ALTER TABLE $price_db_table_name CHANGE `title` `price_title` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
}

$price_desc = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_desc'");
if(!isset($price_desc))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `price_desc` VARCHAR(1000) NOT NULL AFTER `price_title`");
}

$price_post_type = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_post_type'");
if(!isset($price_post_type))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `price_post_type` VARCHAR(1000) NOT NULL AFTER `price_desc`");
}

$price_post_cat = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_post_cat'");
if(!isset($price_post_cat))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `price_post_cat` VARCHAR(1000) NOT NULL AFTER `price_post_type`");
}

$is_show = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'is_show'");
if(!isset($is_show))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `is_show` VARCHAR(1000) NOT NULL AFTER `price_post_cat`");
}

$price_amount = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'package_cost'");
if(!isset($price_amount))	{
	$wpdb->query("ALTER TABLE $price_db_table_name CHANGE `amount` `package_cost` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
}

$price_days = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'validity'");
if(!isset($price_days))	{
	$wpdb->query("ALTER TABLE $price_db_table_name CHANGE `days` `validity` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
}

$validity_per = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'validity_per'");
if(!isset($validity_per))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `validity_per` VARCHAR(1000) NOT NULL AFTER `validity`");
}
$is_recurring = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'is_recurring'");
if(!isset($is_recurring))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `is_recurring` VARCHAR(1000) NOT NULL AFTER `validity_per`");
}
$billing_num = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'billing_num'");
if(!isset($billing_num))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `billing_num` VARCHAR(1000) NOT NULL AFTER `validity_per`");
}
$billing_per = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'billing_per'");
if(!isset($billing_per))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `billing_per` VARCHAR(1000) NOT NULL AFTER `billing_num`");
}
$billing_cycle = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'billing_cycle'");
if(!isset($billing_cycle))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `billing_cycle` VARCHAR(1000) NOT NULL AFTER `billing_per`");
}

$feature_amount = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'is_featured'");
if(!isset($feature_amount))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `is_featured` VARCHAR(1000) NOT NULL AFTER `billing_cycle`");
}

$feature_amount = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'feature_amount'");
if(!isset($feature_amount))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `feature_amount` VARCHAR(1000) NOT NULL AFTER `is_featured`");
}
$feature_cat_amount = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'feature_cat_amount'");
if(!isset($feature_cat_amount))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `feature_cat_amount` VARCHAR(1000) NOT NULL AFTER `feature_amount`");

	$price_insert = '
	INSERT INTO `'.$price_db_table_name.'` (`pid`, `price_title`, `price_desc`, `price_post_type`, `price_post_cat`,`is_show`,`package_cost`,`validity`,`validity_per`,`status`,`is_recurring`,`billing_num`,`billing_per`,`billing_cycle`,`is_featured`,`feature_amount`,`feature_cat_amount`) VALUES
	(1, "Free", "Special time-limited offer: No charges for listing your event.", "event","","1","0","Unlimited","","1","","","","", 1,"0","0"),(2, "Summer pack", "Special time-limited offer","event","","1","40","3","M","1","","","","",1,"10","4")';
	$wpdb->query($price_insert);
}


/*  Price TABLE Creation EOF */



/* ================================== Price TABLE Creation EOF =========================== */

$ip_db_table_name= strtolower($table_prefix . "ip_settings");
global $ip_db_table_name;
if($wpdb->get_var("SHOW TABLES LIKE \"$ip_db_table_name\"") != $ip_db_table_name){
	$ip_table = 'CREATE TABLE IF NOT EXISTS `'.$ip_db_table_name.'` (
	  `ipid` int(11) NOT NULL AUTO_INCREMENT,
	  `ipaddress` varchar(255) NOT NULL,
	  `ipstatus` varchar(25) NOT NULL,
	  PRIMARY KEY (`ipid`)
	)';
	$wpdb->query($ip_table);
}

/* ======================================= Custome User meta TABLE Creation BOF ===================================== */
$table_prefix = $wpdb->prefix;
global $wpdb,$table_prefix;
$custom_usermeta_db_table_name = $table_prefix . "templatic_custom_usermeta";
global $wpdb,$custom_usermeta_db_table_name;
if(strtolower($wpdb->get_var("SHOW TABLES LIKE \"$custom_usermeta_db_table_name\"")) != strtolower($custom_usermeta_db_table_name))
{
$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_usermeta_db_table_name.'` (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `post_type` varchar(255) NOT NULL,
	  `admin_title` varchar(255) NOT NULL,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,date,radio,select,textarea,upload",
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT "1",
	  `is_delete` tinyint(4) NOT NULL DEFAULT "0",
	  `is_require` tinyint(4) NOT NULL DEFAULT "0",
	  `show_on_listing` tinyint(4) NOT NULL DEFAULT "1",
	  `show_on_detail` tinyint(4) NOT NULL DEFAULT "1",
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  PRIMARY KEY (`cid`)
	)');
	
	$qry = $wpdb->query("INSERT INTO $custom_usermeta_db_table_name (`cid`, `post_type`, `htmlvar_name`, `admin_desc`, `site_title`,  `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_require`,  `show_on_listing`, `show_on_detail`,  `extrafield1`, `extrafield2`) VALUES
(1, 'registration', 'user_email', '',  'Email', 'text', '', '', '', 0, 1, 0, 1, 1, '1', '', ''),
(2, 'registration', 'user_fname', '',  'First Name', 'text', '', '', '', 1, 1, 0, 1, 1, '1', '', ''),
(3, 'registration', 'user_lname', '',  'Last Name', 'text', '', '', '', 2, 1, 0, 0, 0, '1', '', ''),
(4, 'registration', 'user_add1', '',  'Address1', 'text', '', '', '', 3, 1, 0, 0, 0, '1', '', ''),
(5, 'registration', 'user_add2', '',  'Address2', 'text', '', '', '', 4, 1, 0, 0, 0, '1', '', ''),
(6, 'registration', 'user_city', '',  'City', 'text', '', '', '', 5, 1, 0, 0, 0, '1', '', ''),
(7, 'registration', 'user_state', '',  'State', 'text', '', '', '', 6, 1, 0, 0, 0, '1', '', ''),
(8, 'registration', 'user_country', '',  'Country', 'text', '', '', '', 7, 1, 0, 0, 0, '1', '', ''),
(9, 'registration', 'user_postalcode', '',  'Postal Code', 'text', '', '', '', 8, 1, 0, 0, 0, '1', '', ''),
(10, 'registration', 'user_photo', '',  'User Image', 'upload','', '', '', 10, 1, 0, 0, 1, '1', '', ''),
(11, 'registration', 'user_phone', '',  'Contact', 'text', '', '', '', 10, 1, 0, 0, 0, '1', '', ''),
(12, 'registration', 'user_web', '',  'Your Website', 'text', '', '', '', 11, 1, 0, 0, 0, '1', '', ''),
(13, 'registration', 'user_twitter', '',  'Your Twitter URL', 'text', '', '', '', 12, 1, 0, 0, 0, '1', '', ''),
(14, 'registration', 'user_facebook', '',  'Your Facebook URL', 'text', '', '', '', 12, 1, 0, 0, 0, '1', '', ''),
(15, 'registration', 'description', '',  'Description', 'textarea', '', '', '', 13, 1, 0, 0, 0, '1', '', '')


");
}
/* ============================ Custome User meta TABLE Creation EOF ========================= */


/* =========================== transaction table BOF ================================= */

global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "transactions";
if($wpdb->get_var("SHOW TABLES LIKE \"$transection_db_table_name\"") != $transection_db_table_name)
{
	$transaction_table = 'CREATE TABLE IF NOT EXISTS `'.$transection_db_table_name.'` (
	`trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) NOT NULL,
	`post_id` bigint(20) NOT NULL,
	`post_title` varchar(255) NOT NULL,
	`status` int(2) NOT NULL,
	`payment_method` varchar(255) NOT NULL,
	`payable_amt` float(25,5) NOT NULL,
	`payment_date` datetime NOT NULL,
	`paypal_transection_id` varchar(255) NOT NULL,
	`user_name` varchar(255) NOT NULL,
	`pay_email` varchar(255) NOT NULL,
	`billing_name` varchar(255) NOT NULL,
	`billing_add` text NOT NULL,
	PRIMARY KEY (`trans_id`)
	)';
	$wpdb->query($transaction_table);	
}

/* transaction table EOF */

/* ================================ CLAIM OWNERSHIP TABLE ================================ */
$claim_db_table_name = $table_prefix."claim_ownership";
global $claim_db_table_name ;
if($wpdb->get_var("SHOW TABLES LIKE \"$claim_db_table_name\"") != $claim_db_table_name){
$ownership_table = 'CREATE TABLE `'.$claim_db_table_name .'`  (
`clid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`post_id` INT NOT NULL, `post_title` VARCHAR(2000) NOT NULL, 
`user_id` INT NOT NULL, `full_name` VARCHAR(1000) NOT NULL, 
`your_email` VARCHAR(250) NOT NULL, 
`contact_number` VARCHAR(200) NOT NULL, 
`your_position` VARCHAR(100) NOT NULL, 
`author_id` VARCHAR(100) NOT NULL, 
`status` VARCHAR(100) NOT NULL, 
`comments` VARCHAR(1000) NOT NULL)';
$wpdb->query($ownership_table);
}
//END OF CLAIM OWNERSHIP TABLE
/* filter terms table for add term icons */
global $wpdb;
$term_icon_column=$wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms where field='term_icon'");
if(!$term_icon_column)
{
	$wpdb->query("ALTER TABLE $wpdb->terms ADD `term_icon` TEXT NULL DEFAULT NULL");
}