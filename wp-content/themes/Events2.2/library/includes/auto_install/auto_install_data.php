<?php
set_time_limit(0);
error_reporting(0);
global  $wpdb;
require_once(ABSPATH.'wp-admin/includes/taxonomy.php');
$dummy_image_path = get_stylesheet_directory_uri().'/images/dummy/';

//====================================================================================//
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
//////////google checkout end/////// /
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
for($i=0;$i<count($paymethodinfo);$i++)
{
$payment_method_info = array();
$payment_method_info  = get_option('payment_method_'.$paymethodinfo[$i]['key']);
if(!$payment_method_info)
{
	update_option('payment_method_'.$paymethodinfo[$i]['key'],$paymethodinfo[$i]);
}
}

// PAYMENT SETTINGS END

/* =================================== BLOG SETTING STARTS ====================================== */
//Adding a "Blog" category.
$category_array1 = array('cat_name' => 'Blog', 'category_description' => 'You can write small description here to explain which type of posts are there in this category. You can add this description from here : Dashboard>> Events>> Event Categories>> Edit. The same way you can add description for Event categories as well.');

insert_category($category_array1);
function insert_category($category_array1)
{
	wp_insert_category( $category_array1);
}
/////////////// TERMS END ///////////////

/*Function to insert taxonomy category EOF*/

//Adding some Blogs.
$dummy_image_path = get_template_directory_uri().'/images/dummy/';

$post_array = array();
$blog_image = array();
$post_author = $wpdb->get_var("SELECT ID FROM $wpdb->users order by ID asc limit 1");
$post_info = array();
$blog_image[] = "dummy/blg1.jpg";
$post_info[] = array(
					"post_title"	=>	'An Exhibition',
					"post_content"	=>	"<p>An exhibition, in the most general sense, is an organized presentation and display of a selection of items. In practice, exhibitions usually occur within museums, galleries and exhibition halls, and World's Fairs. Exhibitions include [whatever as in major art museums and small art galleries; interpretive exhibitions, as at natural history museums and history museums], for example; and commercial exhibitions, or trade fairs.</p> <p>The word &quot;exhibition&quot; is usually, but not always, the word used for a collection of items. Sometimes &quot;exhibit&quot; is synonymous with &quot;exhibition&quot;, but &quot;exhibit&quot; generally refers to a single item being exhibited within an exhibition. Exhibitions may be permanent displays or temporary, but in common usage, &quot;exhibitions&quot; are considered temporary and usually scheduled to open and close on specific dates. While many exhibitions are shown in just one venue, some exhibitions are shown in multiple locations and are called travelling exhibitions, and some are online exhibitions.</p> <p>Though exhibitions are common events, the concept of an exhibition is quite wide and encompasses many variables. Exhibitions range from an extraordinarily large event such as a World's Fair exposition to small one-artist solo shows or a display of just one item. Curators are sometimes involved as the people who select the items in an exhibition. Writers and editors are sometimes needed to write text, labels and accompanying printed material such as catalogs and books. Architects, exhibition designers, graphic designers and other designers may be needed to shape the exhibition space and give form to the editorial content. Exhibition also means a scholarship.</p>",
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image
					);
$blog_image = array();
$blog_image[] = "dummy/blg2.jpg";
$post_info[] = array(
					"post_title"	=>	'Festivals',
					"post_content"	=>	'<p>A festival or gala is an event, usually and ordinarily staged by a local community, which centers on and celebrates some unique aspect of that community and the Festival. Among many religions, a feast is a set of celebrations in honour of God or gods. A feast and a festival are historically interchangeable. However, the term &quot;feast&quot; has also entered common secular parlance as a synonym for any large or elaborate meal. When used as in the meaning of a festival, most often refers to a religious festival rather than a film or art festival. In the Christian liturgical calendar there are two principal feasts, properly known as the Feast of the Nativity of our Lord (Christmas) and the Feast of the Resurrection, (Easter). In the Catholic, Eastern Orthodox, and Anglican liturgical calendars there are a great number of lesser feasts throughout the year commemorating saints, sacred events, doctrines, etc.</p>',
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image
					);
$blog_image = array();
$blog_image[] = "dummy/blg3.jpg";
$post_info[] = array(
					"post_title"	=>	'Nightlife',
					"post_content"	=>	'Nightlife is the collective term for any entertainment that is available and more popular from the late evening into the early hours of the morning. It includes the public houses, nightclubs, discothèques, bars, live music, concert, cabaret, small theatres, small cinemas, shows, and sometimes restaurants a specific area may have; these venues often require cover charge for admission, and make their money on alcoholic beverages. Nightlife encompasses entertainment from the fairly tame to the risque to the seedy. Nightlife entertainment is inherently edgier than daytime amusements, and usually more oriented to adults, including "adult entertainment" in red-light districts. People who prefer to be active during the night-time are called night owls.',
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image
					);
$blog_image = array();
$blog_image[] = "dummy/blg4.jpg";
$post_info[] = array(
					"post_title"	=>	'Life Beyond Earth',
					"post_content"	=>	'<p>Extraterrestrial life is defined as life that does not originate from Earth. Referred to as alien life, or simply aliens (or space aliens, to differentiate from other definitions of alien or aliens) these hypothetical forms of life range from simple bacteria-like organisms to beings far more complex than humans. The development and testing of hypotheses on extraterrestrial life is known as exobiology or astrobiology; the term astrobiology, however, includes the study of life on Earth viewed in its astronomical context. Many scientists consider extraterrestrial life to be plausible, but there is no conclusive evidence of the existence of extraterrestrial life.</p>',
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image
					);
$blog_image = array();
$blog_image[] = "dummy/blg5.jpg";
$post_info[] = array(
					"post_title"	=>	'Social Innovation',
					"post_content"	=>	'<p>Social innovation refers to new strategies, concepts, ideas and organizations that meet social needs of all kinds - from working conditions and education to community development and health - and that extend and strengthen civil society. The term has overlapping meanings. It can be used to refer to social processes of innovation, such as open source methods and techniques. Alternatively it refers to innovations which have a social purpose - like microcredit or distance learning. The concept can also be related to social entrepreneurship (entrepreneurship is not necessarily innovative, but it can be a means of innovation) and it also overlaps with innovation in public policy and governance. Social innovation can take place within government, the for-profit sector, the nonprofit sector (also known as the third sector), or in the spaces between them. Research has focused on the types of platforms needed to facilitate such cross-sector collaborative social innovation. Social innovation is gaining visibility within academia. Prominent innovators associated with the term include Bangladeshi Muhammad Yunus, the founder of Grameen Bank which pioneered the concept of microcredit for supporting innovators in multiple developing countries in Asia, Africa and Latin America and Stephen Goldsmith, former Indianapolis mayor who engaged the private sector in providing many city services.</p>',
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image
					);
/***- Insert Blog post BOF-***/
insert_posts($post_info);
require_once(ABSPATH . 'wp-admin/includes/image.php');
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if(@$post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			@$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			$post_meta = @$post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = @$post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	570,
										"height" =>	400,
										"hwstring_small"=> "height='180' width='140'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata($last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
/***- Insert Blog post EOF-***/

/* ========================================== EVENTS SETTING STARTS ================================== */
//Add some categories in "EVENT" post type.
$category_array1 = array();
$category_array1 = array('Exhibitions','Kids','Festivals','Nightlife','Social');
insert_taxonomy_category($category_array1);
/*--Function to insert taxonomy category BOF-*/
function insert_taxonomy_category($category_array1)
{
	global $wpdb;
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'eventcategory' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'eventcategory');
					}
				}
			}
			
		}else
		{
			$catname = $category_array1[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'eventcategory');
			}
		}
	}
	
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'eventcategory', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

//===================== Add some Events ======================//
$post_info = array();
$today = date('Y-m-d');
////Event 1 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/a1.jpg";
$image_array[] = "dummy/a2.jpg";
$image_array[] = "dummy/a3.jpg";
$date = Date('Y-m-d', strtotime("+6 months"));
$post_meta = array(
					"address"			=> 'Carolina Beach Road, Wilmington, NC, United States',	
					"geo_latitude"		=> '34.1334600363166',		
					"geo_longitude"		=> '-77.91745350000002',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $today, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Regular event',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p>",
					"featured_type"		=> 'both',
					"featured_h"		=> 'h',
					"featured_c"		=> 'c',
					"alive_days"		=> '30'
				);
$post_info[] = array(
					"post_title"	=>	'An Art Exhibition',
					"post_content"	=>	"<p>Discover how war shapes lives at Imperial War Museum London. Explore six floors of galleries and displays, including a permanent exhibition dedicated to the Holocaust and a changing programme of special temporary exhibitions.</p><p> Chronicling the history of conflict from the First World War to the present day, the Museum's vast Collections range from tanks and aircraft to photographs and personal letters as well as films, sound recordings and some of the twentieth century's best-known paintings. With a daily programme of family activities, film screenings, special talks and lectures, the Museum offers a variety of events. </p><br/>FREE (NB: special exhibitions may charge an admission fee) ",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category"	=>	array('Exhibitions'),
					);
////Event 1 end///
////Event 2 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/k1.jpg";
$image_array[] = "dummy/k6.jpg";
$image_array[] = "dummy/k7.jpg";
$date = Date('Y-m-d', strtotime("+3 days"));
$date1 = Date('Y-m-d', strtotime("+3 months"));
$post_meta = array(
					"address"			=> 'Dakota Street, Winnipeg, MB, Canada',	
					"geo_latitude"		=> '49.82057499773663',		
					"geo_longitude"		=> '-97.10196274999998',
					"map_view"			=> 'Road Map',		
					"st_date"			=>  $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Recurring event',
					"recurrence_occurs"	=> 'weekly',
					"recurrence_per"	=> '2',
					"recurrence_bydays"	=> '2',
					"recurrence_days"	=> 3,
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p>",
					"featured_type"		=> 'both',
					"featured_h"		=> 'h',
					"featured_c"		=> 'c',
					"alive_days"		=> '30'
				);
$post_info[] = array(
					"post_title"	=>	'Weekly Karate Classes',
					"post_content"	=>	'Tate Modern is the national gallery of international modern art. Located in London, it is one of the family of four Tate galleries which display selections from the Tate Collection. The Collection comprises the national collection of British art from the year 1500 to the present day, and of international modern art.<br/>
					Sunday – Thursday, 10.00–18.00<br/>
					Friday and Saturday, 10.00–22.00<br/>
					Last admission into exhibitions 17.15 (Friday and Saturday 21.15)<br/>
					Closed 24, 25 and 26 December (open as normal on 1 January).',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category"	=>	array('Kids'),
					);
////Event 2 end///
////Event 3 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/ch1.jpg";
$image_array[] = "dummy/ch2.jpg";
$image_array[] = "dummy/ch5.jpg";
$date = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'Alaskan Way, Seattle, WA, United State',	
					"geo_latitude"		=> '47.59064284101658',		
					"geo_longitude"		=> '-122.33772579999999',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $today, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Regular event',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br/> <strong>How we do it?</strong><br/> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'h',
					"featured_h"		=> 'h',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Christmas Carnival',
					"post_content"	=>	"This year the Real Food Festival will be showcasing some of the finest small producers in the country on London's Southbank in September. You can see some pictures from last years Real Food Festival by clicking the link below - from hand made chocolates to cheeses, from chutneys to sausages and olive oils, it was a time to celebrate everything that's good about British food.",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category"	=>	array('Festivals'),
					);
////Event 3 end///
////Event 4 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/cs1.jpg";
$image_array[] = "dummy/cs3.jpg";
$image_array[] = "dummy/cs5.jpg";
$date = Date('Y-m-d', strtotime("-3 days"));
$date1 = Date('Y-m-d', strtotime("+8 months"));
$post_meta = array(
					"address"			=> 'California Avenue Southwest, Seattle, WA, United States',	
					"geo_latitude"		=> '47.550281221089804',		
					"geo_longitude"		=> '-122.38634315000002',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Regular event',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br/> <strong>How we do it?</strong><br/> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'h',
					"featured_h"		=> 'h',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'The Royal Casinos',
					"post_content"	=>	"Major Mondays is the Ku bars super sexy student night in the Ku Klub. Hosted by DJ P (Wigout, Lloyds hit factory) and guests, it will be a fun filled night of cheap drinks, hot boys and the best commercial Pop, R&B, Indie and Old School tracks – Plus your requests – Request a tune on face book and pick up your free shot when it’s played on the night<br/>
					10pm – 3am <br/> Facebook group - major Mondays",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category"	=>	array('Nightlife'),
					);
////Event 4 end///
////Event 5 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/bi1.jpg";
$image_array[] = "dummy/bi3.jpg";
$image_array[] = "dummy/bi4.jpg";
$date = Date('Y-m-d', strtotime("-5 days"));
$date1 = Date('Y-m-d', strtotime("+2 months"));
$post_meta = array(
					"address"			=> 'Illinois Street, San Francisco, CA, United States',	
					"geo_latitude"		=> '37.756374007080936',		
					"geo_longitude"		=> '-122.38552264999998',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Regular event',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br/> <strong>How we do it?</strong><br/> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'c',
					"featured_h"		=> 'n',
					"featured_c"		=> 'c',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Birthday Party on the Rocks',
					"post_content"	=>	"<p>Join other people all around the country in finding fun, imaginative ways to promote the goal of a Zero Carbon Britain by 2030.</p> <p>Find ways to convey to people that its both urgently necessary and feasible. We can really do it if the whole of society pulls together and starts implementing the solutions that are already out there. And there will be many added benefits too !</p> <p>There are all sorts of things that you can do - preferably teaming together with as many other people in your area as possible. A public meeting to discuss the solutions, a stall and/or display in a public place, a picnic, a cycle ride, a parade, street theatre.</p>",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category"	=>	array('Social'),
					);
////Event 5 end///
////Event 6 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/p3.jpg";
$image_array[] = "dummy/p4.jpg";
$image_array[] = "dummy/p5.jpg";
$date = Date('Y-m-d', strtotime("-5 days"));
$date1 = Date('Y-m-d', strtotime("+3 months"));
$post_meta = array(
					"address"			=> 'Indiana Street, San Francisco, CA, United States',	
					"geo_latitude"		=> '37.756085590154804',		
					"geo_longitude"		=> '-122.39106915000002',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Recurring event',
					"recurrence_occurs"	=> 'weekly',
					"recurrence_per"	=> '3',
					"recurrence_bydays"	=> '6',
					"recurrence_days"	=> 1,
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br/> <strong>How we do it?</strong><br/> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'c',
					"featured_h"		=> 'n',
					"featured_c"		=> 'c',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Painting Exhibition',
					"post_content"	=>	"<p>Discover how war shapes lives at Imperial War Museum London. Explore six floors of galleries and displays, including a permanent exhibition dedicated to the Holocaust and a changing programme of special temporary exhibitions.</p><p> Chronicling the history of conflict from the First World War to the present day, the Museum's vast Collections range from tanks and aircraft to photographs and personal letters as well as films, sound recordings and some of the twentieth century's best-known paintings. With a daily programme of family activities, film screenings, special talks and lectures, the Museum offers a variety of events. </p><br/>FREE (NB: special exhibitions may charge an admission fee) ",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Exhibitions'),
					);
////Event 6 end///
////Event 7 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/d1.jpg";
$image_array[] = "dummy/d2.jpg";
$image_array[] = "dummy/d3.jpg";
$date = Date('Y-m-d', strtotime("+5 days"));
$date1 = Date('Y-m-d', strtotime("+3 months"));
$post_meta = array(
					"address"			=> 'Kansas City, KS, United States',	
					"geo_latitude"		=> '39.114052993477756',		
					"geo_longitude"		=> '-94.6274636',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Regular event',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br/><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br/> <strong>How we do it?</strong><br/> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Summer Dance Week',
					"post_content"	=>	"Tate Modern is the national gallery of international modern art. Located in London, it is one of the family of four Tate galleries which display selections from the Tate Collection. The Collection comprises the national collection of British art from the year 1500 to the present day, and of international modern art.<br/>
					Sunday – Thursday, 10.00–18.00<br/>
					Friday and Saturday, 10.00–22.00<br/>
					Last admission into exhibitions 17.15 (Friday and Saturday 21.15)<br/>
					Closed 24, 25 and 26 December (open as normal on 1 January).",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Kids'),
					);
////Event 7 end///
////Event 8 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/t3.jpg";
$image_array[] = "dummy/t4.jpg";
$image_array[] = "dummy/t5.jpg";
$date = Date('Y-m-d', strtotime("+5 months"));
$post_meta = array(
					"address"			=> 'Kentucky Street, Lawrence, KS, United States',	
					"geo_latitude"		=> '38.95892457569876',		
					"geo_longitude"		=> '-95.23837049999997',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $today, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Regular event',
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br/> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'La Tomatina',
					"post_content"	=>	"This year the Real Food Festival will be showcasing some of the finest small producers in the country on London's Southbank in September. You can see some pictures from last years Real Food Festival by clicking the link below - from hand made chocolates to cheeses, from chutneys to sausages and olive oils, it was a time to celebrate everything that's good about British food.",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Festivals'),
					);
////Event 8 end///
////Event 9 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/f3.jpg";
$image_array[] = "dummy/f4.jpg";
$image_array[] = "dummy/f5.jpg";
$date = Date('Y-m-d', strtotime("+2 days"));
$date1 = Date('Y-m-d', strtotime("+5 months"));
$post_meta = array(
					"address"			=> 'Louisiana Street, Houston, TX, United States',	
					"geo_latitude"		=> '29.75549595189908',		
					"geo_longitude"		=> '-95.37178675000001',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"event_type"		=> 'Regular event',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '', 
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Food Streets at Night',
					"post_content"	=>	"Major Mondays is the Ku bars super sexy student night in the Ku Klub. Hosted by DJ P (Wigout, Lloyds hit factory) and guests, it will be a fun filled night of cheap drinks, hot boys and the best commercial Pop, R&B, Indie and Old School tracks – Plus your requests – Request a tune on face book and pick up your free shot when it’s played on the night<br/>
					10pm – 3am <br /> Facebook group - major Mondays",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Nightlife'),
					);
////Event 9 end///
////Event 10 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/m1.jpg";
$image_array[] = "dummy/m2.jpg";
$image_array[] = "dummy/m3.jpg";
$date = Date('Y-m-d', strtotime("-5 days"));
$date1 = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'Massachusetts Avenue Northwest, Washington, DC, United States',	
					"geo_latitude"		=> '38.92256631958141',		
					"geo_longitude"		=> '-77.05360435',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Recurring event',
					"recurrence_occurs"	=> 'monthly',
					"recurrence_per"	=> '2',
					"recurrence_bydays"	=> '2',
					"recurrence_days"	=> 3,
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Community Meeting',
					"post_content"	=>	"<p>Join other people all around the country in finding fun, imaginative ways to promote the goal of a Zero Carbon Britain by 2030.</p> <p>Find ways to convey to people that its both urgently necessary and feasible. We can really do it if the whole of society pulls together and starts implementing the solutions that are already out there. And there will be many added benefits too !</p> <p>There are all sorts of things that you can do - preferably teaming together with as many other people in your area as possible. A public meeting to discuss the solutions, a stall and/or display in a public place, a picnic, a cycle ride, a parade, street theatre.</p>",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Social'),
					);
////Event 10 end///
////Event 11 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/c4.jpg";
$image_array[] = "dummy/c5.jpg";
$image_array[] = "dummy/c6.jpg";
$date = Date('Y-m-d', strtotime("+5 days"));
$date1 = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'Maryland Avenue, Rockville, MD, United States',	
					"geo_latitude"		=> '39.081568368325996',		
					"geo_longitude"		=> '-77.15622340000004',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Regular event',
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Old Cars Exhibition',
					"post_content"	=>	"<p>Discover how war shapes lives at Imperial War Museum London. Explore six floors of galleries and displays, including a permanent exhibition dedicated to the Holocaust and a changing programme of special temporary exhibitions.</p><p> Chronicling the history of conflict from the First World War to the present day, the Museum's vast Collections range from tanks and aircraft to photographs and personal letters as well as films, sound recordings and some of the twentieth century's best-known paintings. With a daily programme of family activities, film screenings, special talks and lectures, the Museum offers a variety of events. </p><br />FREE (NB: special exhibitions may charge an admission fee) ",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Exhibitions'),
					);
////Event 11 end///
////Event 12 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/h3.jpg";
$image_array[] = "dummy/h4.jpg";
$image_array[] = "dummy/h6.jpg";
$date1 = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'Maine Avenue Southwest, Washington, DC, United States',	
					"geo_latitude"		=> '38.88207077465083',		
					"geo_longitude"		=> '-77.02876980000002',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $today, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Regular event',					
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Colorful Holi',
					"post_content"	=>	"This year the Real Food Festival will be showcasing some of the finest small producers in the country on London's Southbank in September. You can see some pictures from last years Real Food Festival by clicking the link below - from hand made chocolates to cheeses, from chutneys to sausages and olive oils, it was a time to celebrate everything that's good about British food.",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Festivals'),
					);
////Event 12 end///
////Event 13 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/b2.jpg";
$image_array[] = "dummy/b4.jpg";
$image_array[] = "dummy/b5.jpg";
$date = Date('Y-m-d', strtotime("+7 days"));
$date1 = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'New Hampshire Avenue, Hillandale, MD, United States',	
					"geo_latitude"		=> '39.02404183584668',		
					"geo_longitude"		=> '-76.97746959999995',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Regular event',					
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'Baseball Champs',
					"post_content"	=>	'Tate Modern is the national gallery of international modern art. Located in London, it is one of the family of four Tate galleries which display selections from the Tate Collection. The Collection comprises the national collection of British art from the year 1500 to the present day, and of international modern art.<br/>
					Sunday – Thursday, 10.00–18.00<br/>
					Friday and Saturday, 10.00–22.00<br/>
					Last admission into exhibitions 17.15 (Friday and Saturday 21.15)<br/>
					Closed 24, 25 and 26 December (open as normal on 1 January).',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"post_category" =>	array('Kids'),
					);
////Event 13 end///
////Event 14 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/di1.jpg";
$image_array[] = "dummy/di2.jpg";
$image_array[] = "dummy/di4.jpg";
$date = Date('Y-m-d', strtotime("-7 days"));
$date1 = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'New Jersey Turnpike, Mount Laurel, NJ, United States',	
					"geo_latitude"		=> '39.95796638154377',		
					"geo_longitude"		=> '-74.91579899999999',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Regular event',
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'The Dance Floor',
					"post_content"	=>	"Major Mondays is the Ku bars super sexy student night in the Ku Klub. Hosted by DJ P (Wigout, Lloyds hit factory) and guests, it will be a fun filled night of cheap drinks, hot boys and the best commercial Pop, R&B, Indie and Old School tracks – Plus your requests – Request a tune on face book and pick up your free shot when it’s played on the night<br />
					10pm – 3am </br> Facebook group - major Mondays",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Nightlife'),
					);
////Event 14 end///
////Event 15 start///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/w1.jpg";
$image_array[] = "dummy/w2.jpg";
$image_array[] = "dummy/w3.jpg";
$date = Date('Y-m-d', strtotime("-5 days"));
$date1 = Date('Y-m-d', strtotime("+12 months"));
$post_meta = array(
					"address"			=> 'New Mexico 15, Silver City, NM, United States',	
					"geo_latitude"		=> '47.550281221089804',		
					"geo_longitude"		=> '-122.38634315000002',		
					"map_view"			=> 'Road Map',		
					"st_date"			=> $date, //Full Time,Part Time,freelance
					"st_time"			=> '10.00',	
					"end_date"			=> $date1,
					"end_time"			=> '05.00',
					"reg_desc"			=> '',
					"phone"				=> '+91123456789',
					"email"				=> 'mymail@gmail.com',
					"website"			=> 'http://mysite.com',
					"twitter"			=> 'http://twitter.com/myplace',
					"facebook"			=> 'http://facebook.com/myplace',
					"video"				=> '',
					"event_type"		=> 'Regular event',
					"organizer_name"	=> 'Castor Event Organizers', 
					"organizer_email"	=> 'steve@event.com', 
					"organizer_logo"	=> '', 
					"organizer_address"	=> '5 Buckingham Dr Street, paris, NX, USA - 21478', 
					"organizer_contact"	=> '01-025-98745871', 
					"organizer_website"	=> 'http://steve.com', 
					"organizer_mobile"	=> '0897456123071', 
					"organizer_desc"	=> "<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>",
					"featured_type"		=> 'none',
					"featured_h"		=> 'n',
					"featured_c"		=> 'n',
					"alive_days"		=> '30'
					);
$post_info[] = array(
					"post_title"	=>	'The Wedding',
					"post_content"	=>	"<p>Join other people all around the country in finding fun, imaginative ways to promote the goal of a Zero Carbon Britain by 2030.</p> <p>Find ways to convey to people that its both urgently necessary and feasible. We can really do it if the whole of society pulls together and starts implementing the solutions that are already out there. And there will be many added benefits too !</p> <p>There are all sorts of things that you can do - preferably teaming together with as many other people in your area as possible. A public meeting to discuss the solutions, a stall and/or display in a public place, a picnic, a cycle ride, a parade, street theatre.</p>",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_feature"	=>	0,
					"post_category" =>	array('Social'),
					);
////Event 15 end///

insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='".CUSTOM_POST_TYPE1."' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = CUSTOM_POST_TYPE1;
			if(@$post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy = CUSTOM_CATEGORY_TYPE1);
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					if(trim(strtolower($mval)) == trim(strtolower('Recurring event')))
					{
						$start_date = templ_recurrence_dates($last_postid);
						update_post_meta($last_postid,'recurring_search_date',$start_date);
						update_post_meta($last_postid,'tmpl_post_status','publish');
						//templ_save_recurrence_events($my_post,$last_postid);// to save event recurrences
					}
				}
			}
			$post_image1 = $post_info_arr['post_image'];
			if($post_image1)
			{
				for($m=0;$m<count($post_image1);$m++)
				{
					$menu_order1 = $m+1;
					$image_name_arr1 = explode('/',$post_image1[$m]);
					$img_name1 = $image_name_arr1[count($image_name_arr1)-1];
					$img_name_arr1 = explode('.',$img_name1);
					$post_img1 = array();
					$post_img1['post_title'] = $img_name_arr1[0];
					$post_img1['post_status'] = 'inherit';
					$post_img1['post_parent'] = $last_postid;
					$post_img1['post_type'] = 'attachment';
					$post_img1['post_mime_type'] = 'image/jpeg';
					$post_img1['menu_order'] = $menu_order1;
					$last_postimage_id2 = wp_insert_post( $post_img1 );
					update_post_meta($last_postimage_id2, '_wp_attached_file', $post_image1[$m]);				
					$post_attach_arr1 = array(
										"width"				=>	570,
										"height" 			=>	400,
										"hwstring_small"	=> array("file"=>$post_image1[$m],"height"=>125 ,"width"=>75),
										"post-thumbnails"	=> array("file"=>$post_image1[$m],"height"=>125 ,"width"=>75),
										"detail_page_image"	=>  array("file"=>$post_image1[$m],"height"=>400, "width"=>570),
										"file"				=> $post_image1[$m],
										//"sizes"=> $sizes_info_array,
										);	
					wp_update_attachment_metadata( $last_postimage_id2, $post_attach_arr1 );
				}
			}
		}
	}
}

// ADD EVENT TAGS
function set_post_tag($pid,$post_tags)
{
	global $wpdb;
	$post_tags_arr = explode(',',$post_tags);
	for($t=0;$t<count($post_tags_arr);$t++)
	{
		$posttag = $post_tags_arr[$t];
		$term_id = $wpdb->get_var("SELECT t.term_id FROM $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where t.name=\"$posttag\" and tt.taxonomy='post_tag'");
		if($term_id == '')
		{
			$srch_arr = array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_');
				$replace_arr = array('','','','','','','','','','','','','','','','','','','','',',','','');
			$posttagslug = str_replace($srch_arr,$replace_arr,$posttag);
			$termsql = "insert into $wpdb->terms (name,slug) values (\"$posttag\",\"$posttagslug\")";
			$wpdb->query($termsql);
			$last_termsid = $wpdb->get_var("SELECT max(term_id) as term_id FROM $wpdb->terms");
		}else
		{
			$last_termsid = $term_id;
		}
		$term_taxonomy_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy where term_id=\"$last_termsid\" and taxonomy='post_tag'");
		if($term_taxonomy_id=='')
		{
			$termpost = "insert into $wpdb->term_taxonomy (term_id,taxonomy,count) values (\"$last_termsid\",'post_tag',1)";
			$wpdb->query($termpost);
			$term_taxonomy_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy where term_id=\"$last_termsid\" and taxonomy='post_tag'");
		}else
		{
			$termpost = "update $wpdb->term_taxonomy set count=count+1 where term_taxonomy_id=\"$term_taxonomy_id\"";
			$wpdb->query($termpost);
		}
		$termsql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$pid\",\"$term_taxonomy_id\")";
		$wpdb->query($termsql);
	}
}

/* ========================================= ADDING PAGE TEMPLATES =========================================== */
$pages_array = array();
$pages_array = array('Page Templates','Contact Us','About Us', 'Archives', 'Sitemap', 'Short Codes', 'Map' );
$page_info_arr = array();
$page_info_arr['Page Templates'] = '
<p>We are providing the following page templates with this theme : <br>
	<ul style="margin-left:35px;">
		<li> Contact Us</li>
		<li> About Us</li>
		<li> Archives</li>
		<li> Short Codes</li>
		<li> Sitemap</li>
	</ul></p>
<p>You can create a page with a sidebar by using these page templates.</p>
<p>Follow the below steps to use this page tempate in your site : 
	<ul>
		<li>Go to the Dashboard of your site.</li>
		<li>Now, Go to Dashboard >> Pages >> Add New Page. </li>
		<li>Give a title of your choice. Now, you will see "Page Attribute" meta box in the right hand site of the page.<br/><br/>
			Looks like : &nbsp;&nbsp;<img src="'.$dummy_image_path.'add_page.png" >
		</li>
		<li>Now, select a Template from here.</li>
	</ul></p>';
	
$page_info_arr['Contact Us'] = '
<p>Simply designed page template to display a contact form. An easy to use page template to get contacted by the users directly via an email. You can use this page template the same way mentioned in "Page Templates" page. You just need to select <strong>Contact Us</strong> template to use it.</p>';

$page_info_arr['Map'] = '
<p>Here is for you, a page template that displays a large map with the <strong>Pin Points</strong> of the <strong>Event Locations</strong> added in your site. You can use this page template the same way mentioned in "Page Templates" page. You just need to select <strong>Map</strong> template to use it.</p><br><p>You need to click on the RED pin points to see the event locations.</p>';

$page_info_arr['About Us'] = "<p>An <strong>About Us</strong> page template where you can briefly write about the services you provide on your site.</p>
<br />
<strong>What we do?</strong><br /><p>An event is normally a large gathering of people, who have come to a particular place at a particular time for a particular reason. Having said that, there's very little that's normal about an event. In our experience, each one is different and their variety is enormous. And that's as it should be: an event is something special. Aone - off. We plan these occasions in meticulous details, manage them from the ground, dismantle them when they are over and assess the result.</p><br /> <strong>How we do it?</strong><br /> <p>Events can be used to communicate key message, faster community relations, motivate work forces or raise funds. One of the first things we ask our clients is, what they want to achieve from their event. This is the cornerstone of the whole operation for us, our starting point and most importantly, it's the way success can be measured.</p>";

$page_info_arr['Archives'] = 'This is Archives page template. Just select <strong>Page - Archives</strong> page template from templates section and you&rsquo;re good to go.';

$page_info_arr['Sitemap'] =  '
See, how easy is to use page templates. Just add a new page and select <strong>Page - Sitemap</strong> from the page templates section. Easy peasy, isn&rsquo;t it.
';

$page_info_arr['Short Codes'] = '
This theme comes with built in shortcodes. The shortcodes make it easy to add stylised content to your site, plus they&rsquo;re very easy to use. Below is a list of shortcodes which you will find in this theme.
[ Download ]
[Download] Download: Look, you can use me for highlighting some special parts in a post. I can make download links more highlighted. [/Download]
[ Alert ]
[Alert] Alert: Look, you can use me for highlighting some special parts in a post. I can be used to alert to some special points in a post. [/Alert]
[ Note ]
[Note] Note: Look, you can use me for highlighting some special parts in a post. I can be used to display a note and thereby bringing attention.[/Note]
[ Info ]
[Info] Info: Look, you can use me for highlighting some special parts in a post. I can be used to provide any extra information. [/Info]
[ Author Info ]
[Author Info]<img src="'.$dummy_image_path.'no-avatar.png" alt="" />
<h4>About The Author</h4>
Use me for adding more information about the author. You can use me anywhere within a post or a page, i am just awesome. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing.
[/Author Info]
<h3>Button List</h3>
[ Small_Button class="red" ]
[Small_Button class="red"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="grey"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="black"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="blue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="lightblue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="purple"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="magenta"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="green"]<a href="#">Button Text</a>[/Small_Button]  [Small_Button class="orange"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="yellow"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="pink"]<a href="#">Button Text</a>[/Small_Button]
<hr />
<h3>Icon list view</h3>
[ Icon List ]
[Icon List]
<ul>
	<li> Use the shortcode to add this attractive unordered list</li>
	<li> SEO options in every page and post</li>
	<li> 5 detailed color schemes</li>
	<li> Fully customizable front page</li>
	<li> Excellent Support</li>
	<li> Theme Guide &amp; Tutorials</li>
	<li> PSD File Included with multiple use license</li>
	<li> Gravatar Support &amp; Threaded Comments</li>
	<li> Inbuilt custom widgets</li>
	<li> 30 built in shortcodes</li>
	<li> 8 Page templates</li>
	<li>Valid, Cross browser compatible</li>
</ul>
[/Icon List]
<h3>Dropcaps Content</h3>
[ Dropcaps ] 
[Dropcaps] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

[Dropcaps] Dropcaps can be so useful sometimes. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

<h3>Content boxes</h3>
We, the content boxes can be used to highlight special parts in the post. We can be used anywhere, just use the particular shortcode and we will be there.
[ Normal_Box ]
[Normal_Box]
<h3>Normal Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Normal_Box]

[ Warning_Box ]
[Warning_Box]
<h3>Warring Box</h3>
This is how a warning content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Warning_Box]

[ Download_Box ]
[Download_Box]
<h3>Download Box</h3>
This is how a download content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Download_Box]

[ About_Box ]
[About_Box]
<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

[/About_Box]

[ Info_Box ]

[Info_Box]
<h3>Info Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Info_Box]

[ Alert_Box ]
[Alert_Box]
<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Alert_Box]

[Info_Box_Equal]
<h3>Info Box</h3>
This is how info content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of Info box.<strong> [ Info_Box_Equal ]</strong>
[/Info_Box_Equal]


[Alert_Box_Equal]

<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of alert box.<strong> [ Alert_Box_Equal ]</strong>


[/Alert_Box_Equal]

[About_Box_Equal]

<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, molestie in, commodo  porttitor. Use this shortcode for this type of about box. <strong>[ About_Box_Equal ]</strong>

[/About_Box_Equal]


[One_Half]
<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half ]</strong>

[/One_Half]


[One_Half_Last]
<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half_Last ]</strong>

[/One_Half_Last]



[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam ut lacus. <strong>[ One_Third ]</strong>

[/One_Third]


[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in. Commodo  porttitor, felis. Nam lacus. <strong> [ One_Third ]</strong>

[/One_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. <strong>[ One_Third_Last ]</strong>

[/One_Third_Last]



[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong> [ One_Fourth ]</strong>

[/One_Fourth]


[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth_Last]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth_Last ]</strong>

[/One_Fourth_Last]



[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus. <strong>[ One_Third ]</strong>

[/One_Third]



[Two_Third_Last]
<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus.  <strong> [ Two_Third_Last ]</strong>

[/Two_Third_Last]



[Two_Third]
<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. <strong>[ Two_Third ]</strong>

[/Two_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, commodo  porttitor, felis.  <strong> [ One_Third_Last ]</strong>

[/One_Third_Last]
';

set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				@$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				
				$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title=\"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					$post_name = $post_name.'-'.($post_name_count+1);
				}
				$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_id_count==0)
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('home')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}

//Update the page templates
$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contact Us' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'template_contact.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'template_archives.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sitemap' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'template_sitemap.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Short Codes' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'template_short_code.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Map' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'template_map.php' );

//PAGE TEMPLATES END

/* ======================================== DESIGN SETTINGS START =============================== */
update_option("site_email_id",get_option('admin_email'));
update_option("approve_status",'Published');
update_option("ptthemes_listing_ex_status",'Draft');
update_option("ptthemes_show_addevent_link",'Yes');
update_option("pt_show_postacomment",'Yes');
update_option("ptthemes_print",'Yes');
update_option("ptthemes_share",'Yes');
update_option("ptthemes_facebook",'Yes');
update_option("ptthemes_enable_claim",'Yes');
update_option("ptthemes_attending_event",'Yes');
update_option("ptthemes_facebook_id",'Yes');
update_option("ptthemes_twitter_id",'Yes');
update_option("ptthemes_facebook_url",'http://www.facebook.com/templatic');
update_option("ptthemes_twitter_url",'https://twitter.com/templatic');
update_option("ptthemes_show_blog_title",'No');
update_option("ptthemes_event_sorting",'Latest Published');
update_option("ptthemes_latitute",34);
update_option("ptthemes_longitute",0);
update_option("ptthemes_scale_factor",3);
update_option("pttthemes_maptype",'Roadmap');
update_option("ptthemes_map_display",'As per Zoom Level');
update_option("ptthemes_disable_rating",'No');
update_option("ptthemes_category_display",'select');
update_option("ptthemes_logo_url",get_template_directory_uri()."/skins/1-default/logo.png");
update_option("ptthemes_package_type","Pay per event listing");
update_option("ptthemes_alt_stylesheet",'blue');
update_option("ptthemes_feedburner_url",'http://feeds.feedburner.com/Templatic');
update_option("ptthemes_show_menu",'Yes');
update_option("ptthemes_show_top_menu",'Yes');
update_option("ptthemes_detail_gallery_map_flag",'Map & Gallery Both - Default Gallery');
update_option("ptttheme_currency_code",'USD');
update_option("ptttheme_currency_symbol",'$');
update_option("ptthemes_category_map_event",'Yes');

// Design Settings END ==================

/* ============================================== WIDGET SETTINGS START ================================================ */

$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();

//FRONT CONTENT WIDGETS ======================================================
// 1. FRONT PAGE SLIDER
$featuredslider = array();
$featuredslider[1] = array(
					"title"			=>	'Featured Events',
					"category"		=>	'',
					"post_number"	=>	'5',
					);
$featuredslider['_multiwidget'] = '1';
update_option('widget_featuredslider',$featuredslider);
$featuredslider = get_option('widget_featuredslider');
krsort($featuredslider);
foreach($featuredslider as $key1=>$val1)
{
	$featuredslider_key = $key1;
	if(is_int($featuredslider_key))
	{
		break;
	}
}

// 2. LATEST EVENTS WIDGET
$news2columns = array();
$news2columns[1] = array(
					"title"			=>	'Events',
					"category"		=>	'',
					"post_number"	=>	'5',
					"character_cout"	=>	'20',
					);
$news2columns['_multiwidget'] = '1';
update_option('widget_news2columns',$news2columns);
$news2columns = get_option('widget_news2columns');
krsort($news2columns);
foreach($news2columns as $key1=>$val1)
{
	$news2columns_key = $key1;
	if(is_int($news2columns_key))
	{
		break;
	}
}

$sidebars_widgets["front_content"] = array("featuredslider-$featuredslider_key","news2columns-$news2columns_key");

// 3. LATEST EVENT LIST VIEW WIDGETS
$onecolumnslist = array();
$id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Exhibitions'");
$onecolumnslist[1] = array(
					"title"			=>	'Exhibitions',
					"category"		=>	$id,
					"post_number"	=>	'5',
					);
$onecolumnslist['_multiwidget'] = '1';
update_option('widget_onecolumnslist',$onecolumnslist);
$onecolumnslist = get_option('widget_onecolumnslist');
krsort($onecolumnslist);
foreach($onecolumnslist as $key1=>$val1)
{
	$onecolumnslist_key = $key1;
	if(is_int($onecolumnslist_key))
	{
		break;
	}
}
$sidebars_widgets["front_content_left"] = array("onecolumnslist-$onecolumnslist_key");

// 4. LATEST EVENT LIST VIEW WIDGETS
$onecolumnslist = array();
$id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Festivals'");
$onecolumnslist = get_option('widget_onecolumnslist');
$onecolumnslist[2] = array(
					"title"			=>	'Festivals',
					"category"		=>	$id,
					"post_number"	=>	'5',
					);
$onecolumnslist['_multiwidget'] = '1';
update_option('widget_onecolumnslist',$onecolumnslist);
$onecolumnslist = get_option('widget_onecolumnslist');
krsort($onecolumnslist);
foreach($onecolumnslist as $key1=>$val1)
{
	$onecolumnslist_key = $key1;
	if(is_int($onecolumnslist_key))
	{
		break;
	}
}
$sidebars_widgets["front_content_right"] = array("onecolumnslist-$onecolumnslist_key");

// FRONT CONTENT SIDEBAR WIDGETS ===============================================================
// EVENTS SEARCH WIDGET
$eventsearch = array();
$eventsearch[1] = array(
					"title"			=>	'Events Search',
					);
$eventsearch['_multiwidget'] = '1';
update_option('widget_eventsearch',$eventsearch);
$eventsearch = get_option('widget_eventsearch');
krsort($eventsearch);
foreach($eventsearch as $key1=>$val1)
{
	$eventsearch_key = $key1;
	if(is_int($eventsearch_key))
	{
		break;
	}
}

// EVENTS CALENDER WIDGET
$event_calendar = array();
$event_calendar[1] = array(
					"title"			=>	'Event Calendar',
					);
$event_calendar['_multiwidget'] = '1';
update_option('widget_event_calendar',$event_calendar);
$event_calendar = get_option('widget_event_calendar');
krsort($event_calendar);
foreach($event_calendar as $key1=>$val1)
{
	$event_calendar_key = $key1;
	if(is_int($event_calendar_key))
	{
		break;
	}
}

// RECENT REVIEWS WIDGET
$comment = array();
$comment[1] = array(
					"title"			=>	'Recent Reviews',
					"count"			=>	'3',
					);
$comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$comment);
$comment = get_option('widget_widget_comment');
krsort($comment);
foreach($comment as $key1=>$val1)
{
	$comment_key = $key1;
	if(is_int($comment_key))
	{
		break;
	}
}

// SUBSCRIBE WIDGET
$subscribewidget = array();
$subscribewidget[1] = array(
					"title"			=>	'Newsletter Subscribe',
					"text"			=>	'If you would like to stay updated with all our latest news please enter your e-mail address here',
					);
$subscribewidget['_multiwidget'] = '1';
update_option('widget_widget_subscribewidget',$subscribewidget);
$subscribewidget = get_option('widget_widget_subscribewidget');
krsort($subscribewidget);
foreach($subscribewidget as $key1=>$val1)
{
	$subscribewidget_key = $key1;
	if(is_int($subscribewidget_key))
	{
		break;
	}
}

// ADVERTISEMENT WIDGET
$advtwidget = array();
$advtwidget[1] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="http://templatic.com"><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /></a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

$sidebars_widgets["front_page_sidebar"] = array("eventsearch-$eventsearch_key","event_calendar-$event_calendar_key","widget_comment-$comment_key","widget_subscribewidget-$subscribewidget_key","advtwidget-$advtwidget_key");

$sidebars_widgets["content_sidebar"] = array("eventsearch-$eventsearch_key","event_calendar-$event_calendar_key","advtwidget-$advtwidget_key");

$sidebars_widgets["event_listing_sidebar"] = array("eventsearch-$eventsearch_key","event_calendar-$event_calendar_key","advtwidget-$advtwidget_key");

// LOGIN WIDGET
$loginwidget = array();
$loginwidget[1] = array(
					"title"			=>	'Member Login',
					);
$loginwidget['_multiwidget'] = '1';
update_option('widget_widget_loginwidget',$loginwidget);
$loginwidget = get_option('widget_widget_loginwidget');
krsort($loginwidget);
foreach($loginwidget as $key1=>$val1)
{
	$loginwidget_key = $key1;
	if(is_int($loginwidget_key))
	{
		break;
	}
}

// TEXT WIDGET
$text2 = array();
$text2 = get_option('widget_text');
$text2[1] = array(
					"title"			=>	'100% Satisfaction Guaranteed',
					"text"			=>	'<p> If you&acute;re not 100% satisfied with the results from your listing, request a full refund within 30 days after your listing expires. No questions asked. Promise.</p><p>See also our <a href="#"> frequently asked questions</a>.</p>',
					);
$text2['_multiwidget'] = '1';
update_option('widget_text',$text2);
$text2 = get_option('widget_text');
krsort($text2);
foreach($text2 as $key1=>$val1)
{
	$text2_key = $key1;
	if(is_int($text2_key))
	{
		break;
	}
}

// TEXT WIDGET
$text22 = array();
$text22 = get_option('widget_text');
$text22[2] = array(
					"title"			=>	'Payment Info',
					"text"			=>	'<p> $250 Full-time listing (60 days) </p><p>$75 Freelance listing (30 days) </p><p>Visa, Mastercard, American Express, and Discover cards accepted  </p><p><p> All major credit cards  accepted. Payments are processed by PayPal, but you do not need an account with PayPal to complete your transaction. (Contact us with any questions.) </p>',
					);
$text22['_multiwidget'] = '1';
update_option('widget_text',$text22);
$text22 = get_option('widget_text');
krsort($text22);
foreach($text22 as $key1=>$val1)
{
	$text22_key = $key1;
	if(is_int($text22_key))
	{
		break;
	}
}

$sidebars_widgets["add_event_sidebar"] = array("widget_loginwidget-$loginwidget_key","text-$text2_key","text-$text22_key");

// EVENT CONTENT BANNER WIDGET
$advtwidget = array();
$advtwidget = get_option('widget_advtwidget');
$advtwidget[4] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="http://templatic.com"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}
$sidebars_widgets["event_content_banner"] = array("advtwidget-$advtwidget_key");

$sidebars_widgets["event_detail_sidebar"] = array("eventsearch-$eventsearch_key","event_calendar-$event_calendar_key","advtwidget-14");

// SUBSCRIBE WIDGET
$subscribewidget = array();
$subscribewidget = get_option('widget_widget_subscribewidget');
$subscribewidget[2] = array(
					"title"			=>	'Newsletter Subscribe',
					"text"			=>	'If you did like to stay updated with all our latest news please enter your e-mail address here',
					);
$subscribewidget['_multiwidget'] = '1';
update_option('widget_widget_subscribewidget',$subscribewidget);
$subscribewidget = get_option('widget_widget_subscribewidget');
krsort($subscribewidget);
foreach($subscribewidget as $key1=>$val1)
{
	$subscribewidget_key = $key1;
	if(is_int($subscribewidget_key))
	{
		break;
	}
}

// ADVERTISEMENT WIDGET
$advtwidget = array();
$advtwidget = get_option('widget_advtwidget');
$advtwidget[5] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="http://templatic.com"><img src="'.$dummy_image_path.'advt300x150px.jpg" alt="" /></a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

// CATEGORIES WIDGET
$categories = array();
$categories[1] = array(
					"title"		=>	'',
					"count"		=>	0,
					"hierarchical"		=>	0,
					"dropdown"		=>	0,
					);
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}

// ARCHIVES WIDGET
$archives = array();
$archives[1] = array(
					"title"		=>	'Archives',
					"count"		=>	0,
					"dropdown"		=>	0,
					);
$archives['_multiwidget'] = '1';
update_option('widget_archives',$archives);
$archives = get_option('widget_archives');
krsort($archives);
foreach($archives as $key1=>$val1)
{
	$archives_key = $key1;
	if(is_int($archives_key))
	{
		break;
	}
}

// LINKS WIDGET
$links = array();
$links[1] = array(
					"images"	=>	'1',
					"name"	=>	'1',
					"description"	=>	'0',
					"rating"	=>	'0',
					"category"	=>	'0',
					);
$links['_multiwidget'] = '1';
update_option('widget_links',$links);
$links = get_option('widget_links');
krsort($links);
foreach($links as $key1=>$val1)
{
	$links_key = $key1;
	if(is_int($links_key))
	{
		break;
	}
}

$sidebars_widgets["blog_listing_sidebar"] = array("categories-$categories_key","widget_subscribewidget-$subscribewidget_key","archives-$archives_key","links-$links_key","advtwidget-$advtwidget_key");

$sidebars_widgets["blog_detail_sidebar"] = array("categories-$categories_key","widget_subscribewidget-$subscribewidget_key","archives-$archives_key","links-$links","advtwidget-$advtwidget_key");

// ADVERTISEMENT WIDGET
$advtwidget = array();
$advtwidget = get_option('widget_advtwidget');
$advtwidget[8] = array(
					"title"			=>	'',
					"desc1"			=>	'<a href="http://templatic.com"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

$sidebars_widgets["blog_content_banner"] = array("advtwidget-$advtwidget_key");

/* ===================================== CONTACT US PAGE WIDGETS ==================================== */

// CONTACT INFO WIDGET
$contact_info = array();
$contact_info = get_option('widget_contact_info_widget');
$contact_info[8] = array(
					"title"			=>	'Address',
					"desc1"			=>	'230 Vine Street And locations throughout Old City, Philadelphia, PA 19106',
					"phone"			=>	'+91 123456',
					"email"			=>	'mymail@gmail.com'
					);
$contact_info['_multiwidget'] = '1';
update_option('widget_contact_info_widget',$contact_info);
$contact_info = get_option('widget_contact_info_widget');
krsort($contact_info);
foreach($contact_info as $key1=>$val1)
{
	$contact_info_key = $key1;
	if(is_int($contact_info_key))
	{
		break;
	}
}

$sidebars_widgets["contact-widget"] = array("contact_info_widget-$contact_info_key");

// GOOGLE MAP WIDGET
$add_map = array();
$add_map = get_option('widget_widget_location_map');
$add_map[8] = array(
					"title"			=>	'Address',
					"address"		=>	'230 Vine Street And locations throughout Old City, Philadelphia, PA 19106',
					"map_height"	=>	'200',
					"scale"			=>	'3',
					);
$add_map['_multiwidget'] = '1';
update_option('widget_widget_location_map',$add_map);
$add_map = get_option('widget_widget_location_map');
krsort($add_map);
foreach($add_map as $key1=>$val1)
{
	$add_map_key = $key1;
	if(is_int($add_map_key))
	{
		break;
	}
}

$sidebars_widgets["contact-google"] = array("widget_location_map-$add_map_key");

// SOCICL MEDIA WIDGET
$social = array();
$social = get_option('widget_social_media');
$social[8] = array(
					"twitter"	=>	'https://twitter.com/templatic',
					"facebook"	=>	'http://www.facebook.com/templatic',
					"digg"		=>	'http://digg.com',
					"linkedin"	=>	'http://in.linkedin.com',
					"myspace"	=>	'http://myspace.com',
					"rss"		=>	'http://feeds.feedburner.com/Templatic',
					);
$social['_multiwidget'] = '1';
update_option('widget_social_media',$social);
$social = get_option('widget_social_media');
krsort($social);
foreach($social as $key1=>$val1)
{
	$social_key = $key1;
	if(is_int($social_key))
	{
		break;
	}
}

$sidebars_widgets["header_logo_right_side"] = array("social_media-$social_key");

update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END ///////////////

// COPY THE DUMMY FOLDER ======================================================================
global $upload_folder_path,$blog_id;
//$folderpath = $upload_folder_path . "dummy/";
$dirinfo = wp_upload_dir();
$target =$dirinfo['basedir']."/dummy"; 

full_copy( get_template_directory()."/images/dummy/", $target );
//full_copy( get_template_directory()."/images/dummy/", ABSPATH . "wp-content/uploads/dummy/" );
function full_copy( $source, $target ) 
{
	global $upload_folder_path;
	$dirinfo = wp_upload_dir();
	$imagepatharr = explode('/',$upload_folder_path."/dummy");	
	$year_path = $dirinfo['basedir']."/";
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i]!='wp-content' && $imagepatharr[$i]!='uploads' && $imagepatharr[$i]!='')
	  {
		  $year_path .= $imagepatharr[$i]."/";		 
		  if (!file_exists($year_path)){
			  mkdir($year_path, 0777);
		  }     
		}
	}
	@mkdir( $target );
		$d = dir( $source );
		
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source  . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}				
			copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {

		copy( $source, $target );
	}
}

/* ======================== CODE TO ADD RESIZED IMAGES ======================= */
regenerate_all_attachment_sizes();
 
function regenerate_all_attachment_sizes() {
	$args = array( 'post_type' => 'attachment', 'numberposts' => 100, 'post_status' => 'attachment'); 
	$attachments = get_posts( $args );
	if ($attachments) {
		foreach ( $attachments as $post ) {
			$file = get_attached_file( $post->ID );
			wp_update_attachment_metadata( $post->ID, wp_generate_attachment_metadata( $post->ID, $file ) );
		}
	}		
}

?>