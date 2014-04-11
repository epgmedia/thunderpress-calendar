<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
$fname = get_option('post_type_export')."_report_".strtotime(date('Y-m-d')).".csv";
header('Content-Description: File Transfer');
header("Content-type: application/force-download; charset=ISO-8859-2;");
header('Content-Disposition: inline; filename="'.$fname.'"');
ob_start();
$f = fopen('php://output', 'w') or show_error("Can't open php://output");
$n = 0;
		function get_post_images($pid)
		{
			$image_array = array();
			$pmeta = get_post_meta($pid, 'key', $single = true);
			if($pmeta['productimage'])
			{
				$image_array[] = $pmeta['productimage'];
			}
			if($pmeta['productimage1'])
			{
				$image_array[] = $pmeta['productimage1'];
			}
			if($pmeta['productimage2'])
			{
				$image_array[] = $pmeta['productimage2'];
			}
			if($pmeta['productimage3'])
			{
				$image_array[] = $pmeta['productimage3'];
			}
			if($pmeta['productimage4'])
			{
				$image_array[] = $pmeta['productimage4'];
			}
			if($pmeta['productimage5'])
			{
				$image_array[] = $pmeta['productimage5'];
			}
			if($pmeta['productimage6'])
			{
				$image_array[] = $pmeta['productimage6'];
			}
			return $image_array;
		}
		/*
		Name : get_post_image
		Description : fetch the image of perticulat post
		*/
		function get_post_image($post,$img_size='thumb',$detail='',$numberofimgs=6)
		{
			$return_arr = array();
			if($post->ID)
			{
				$images = get_post_images($post->ID);
				if(is_array($images))
				{
					$return_arr = $images;
				}
			}
			$arrImages =&get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
			if($arrImages) 
			{
				$counter=0;
			   foreach($arrImages as $key=>$val)
			   {
					$counter++;
					$id = $val->ID;
					if($img_size == 'large')
					{
						$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}
					}
					elseif($img_size == 'medium')
					{
						$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}
					}
					elseif($img_size == 'thumb')
					{
						$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}						
					}
			   }
			  return $return_arr;
			}			
		}
global $wpdb,$current_user;
$post_table = $wpdb->prefix."posts";
$post_meta_table = $wpdb->prefix."postmeta";

$authorsql_select = "select DISTINCT p.ID,p.*";
$authorsql_from= " from $post_table p,$post_meta_table pm";
$authorsql_conditions= " where p.post_type = '".get_option('post_type_export')."' and p.post_status='publish' and p.ID = pm.post_id";
$authorinfo = $wpdb->get_results($authorsql_select.$authorsql_from.$authorsql_conditions);
if(get_option('post_type_export') == CUSTOM_POST_TYPE1)
{
	$post_cat_type = CUSTOM_CATEGORY_TYPE1;
	$post_tag_type = CUSTOM_TAG_TYPE1;
}elseif(get_option('post_type_export') == CUSTOM_POST_TYPE2){
	$post_cat_type = CUSTOM_CATEGORY_TYPE2;
	$post_tag_type = CUSTOM_TAG_TYPE2;
}
else{
	$post_cat_type = 'category';
	$post_tag_type = 'post_tag';
}

$old_pattern = array("/[^a-zA-Z0-9-:;<>\/=.& ]/", "/_+/", "/_$/");
$new_pattern = array("_", "_", "");

$file_name = strtolower(preg_replace($old_pattern, $new_pattern , $text_title));
if(get_option('post_type_export') == CUSTOM_POST_TYPE1)
{
	if($authorinfo)
	{
	$header_top =  "post_title,post_content,category,tags,Post_author,post_date,post_date_gmt,post_excerpt,post_status,video,address,geo_latitude,geo_longitude,phone,st_date,st_time,end_date,end_time,email,alive_days,website,twitter,facebook,reg_desc,organizer_name,organizer_email,organizer_logo,organizer_address,organizer_contact,organizer_website,organizer_mobile,IMAGE";
	echo $header_top .= "\r\n";
		foreach($authorinfo as $postObj)
		{
		global $post,$wpdb;
		$product_image_arr = get_post_image($postObj,'large','',5);
		$image = '';
		if(count($product_image_arr)>1)
		{
			foreach($product_image_arr as $_product_image_arr)
				{
				  $image .= basename($_product_image_arr).";";
				}
			$image = substr($image,0,-1);
		}
		//$post_title =  preg_replace($old_pattern, $new_pattern , $postObj->post_title); 
		$post_title =  iconv("UTF-8", "ISO-8859-1//IGNORE", $postObj->post_title);
		$post_date =  $postObj->post_date;
		$post_date_gmt = $postObj->post_date_gmt;
		//$post_content = preg_replace($old_pattern, $new_pattern , $postObj->post_content);
		$post_content =   $postObj->post_content;
		//$post_excerpt = preg_replace($old_pattern, $new_pattern , $postObj->post_excerpt);
		$post_excerpt =  $postObj->post_excerpt;
		//$is_featured =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'is_featured',true));
		$is_featured =  get_post_meta($postObj->ID,'is_featured',true);
		$organizer_name =  get_post_meta($postObj->ID,'organizer_name',true);
		$video =  get_post_meta($postObj->ID,'video',true);
		$email =  get_post_meta($postObj->ID,'email',true);
		$website =  get_post_meta($postObj->ID,'website',true);
		$organizer_email = get_post_meta($postObj->ID,'organizer_email',true);
		$organizer_logo =  get_post_meta($postObj->ID,'organizer_logo',true);
		//$organizer_address =  preg_replace($old_pattern, $new_pattern ,get_post_meta($postObj->ID,'organizer_address',true));
		$organizer_address =  get_post_meta($postObj->ID,'organizer_address',true);
		$organizer_contact =  get_post_meta($postObj->ID,'organizer_contact',true);
		$organizer_website =  get_post_meta($postObj->ID,'organizer_website',true);
		$organizer_mobile =  get_post_meta($postObj->ID,'organizer_mobile',true);
		$twitter = get_post_meta($postObj->ID,'twitter',true);
		$facebook = get_post_meta($postObj->ID,'facebook',true);
	//	$reg_desc =  preg_replace($old_pattern, $new_pattern ,get_post_meta($postObj->ID,'reg_desc',true));
		$reg_desc = get_post_meta($postObj->ID,'reg_desc',true);
	//	$geo_address =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'address',true));
		$geo_address =  get_post_meta($postObj->ID,'address',true);
		$geo_latitude = get_post_meta($postObj->ID,'geo_latitude',true);
		$geo_longitude = get_post_meta($postObj->ID,'geo_longitude',true);
		$phone = get_post_meta($postObj->ID,'phone',true);
		$allow_resume =  get_post_meta($postObj->ID,'allow_resume',true);
	//	$paid_amount = preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'paid_amount',true));
		$paid_amount = get_post_meta($postObj->ID,'paid_amount',true);
		//$alive_days =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'alive_days',true));
		$alive_days =  get_post_meta($postObj->ID,'alive_days',true);
		//$paymentmethod = preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'paymentmethod',true));
		$paymentmethod =  get_post_meta($postObj->ID,'paymentmethod',true);
		$st_date =  htmlspecialchars(stripslashes(get_post_meta($postObj->ID,'st_date',true)),ENT_QUOTES,'UTF-8',true);
		$st_time =  htmlspecialchars(stripslashes(get_post_meta($postObj->ID,'st_time',true)),ENT_QUOTES,'UTF-8',true);
		$end_date = htmlspecialchars(stripslashes(get_post_meta($postObj->ID,'end_date',true)),ENT_QUOTES,'UTF-8',true);
		$end_time = htmlspecialchars(stripslashes(get_post_meta($postObj->ID,'end_time',true)),ENT_QUOTES,'UTF-8',true);

		
		
		$udata = get_userdata($postObj->post_author);
		$category_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_cat_type, array('fields' => 'names'));
		$category = '';
		if($category_array){
			$category =implode('&',$category_array);
		}
	//	$category = preg_replace($old_pattern, $new_pattern , $category);
		$tag_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_tag_type, array('fields' => 'names'));
		$tags = '';
		if($tag_array){
			$tags =implode('&',$tag_array);
		}
		//$tags = preg_replace($old_pattern, $new_pattern , $tags);
		$args = array('post_id'=>$postObj->ID);
		$comments_data = get_comments( $args );
		//*--fetch comments ----*//;
	
		if($comments_data){
		foreach($comments_data as $comments_data_obj){
			foreach($comments_data_obj as $_comments_data_obj)
			  {
				if($_comments_data_obj ==""){
				$_comments_data_obj = "null";
				}
				 $newarray .= $_comments_data_obj."~";
			  }
			  $newarray .="##";
		}
		$newarray = str_replace(','," ",$newarray);
		}else{
		$newarray = "";
		}
	
		$csv_array=array("$post_title","$post_content","$category","$tags","$postObj->post_author","$post_date","$post_date_gmt","$post_excerpt","$postObj->post_status","$video","$geo_address","$geo_latitude","$geo_longitude","$phone","$st_date","$st_time","$end_date","$end_time","$email","$alive_days","$website","$twitter","$facebook","$reg_desc","$organizer_name","$organizer_email","$organizer_logo","$organizer_address","$organizer_contact","$organizer_website","$organizer_mobile","$image");
		$content_1_array=array("$newarray");
	$new_csv_array=array_merge($csv_array,$content_1_array);

	if ( !fputcsv($f, $new_csv_array))
	{
		echo "Can't write line $n: $line";
	}

	
	//echo $content_1." \r\n";

	
		}
		
	fclose($f);
	$csvStr = ob_get_contents();
	ob_end_clean();

	echo $csvStr;
	}else
	{
	echo "No record available";
	
	}
}
else
{
  	if($authorinfo)
	{
	$header_top =  "Post_author,post_date,post_date_gmt,post_title,category,IMAGE,tags,post_content,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,menu_order,post_type,post_mime_type,comment_count";
	echo $header_top .= ",comments_data"." \r\n";
		foreach($authorinfo as $postObj)
		{
		global $post,$wpdb;
		$product_image_arr = get_post_image($postObj,'large','',5);
		
		$image = '';
		
			foreach($product_image_arr as $_product_image_arr)
				{
				
				  $image .= basename($_product_image_arr).";";
				}
			$image = substr($image,0,-1);
		
		//$post_title =  preg_replace($old_pattern, $new_pattern , $postObj->post_title); 
		$post_title =  iconv("UTF-8", "ISO-8859-1//IGNORE", $postObj->post_title); 
		$post_date =  $postObj->post_date;
		$post_date_gmt = $postObj->post_date_gmt;
		$post_content = $postObj->post_content;
		$post_excerpt =  $postObj->post_excerpt;
		
		$udata = get_userdata($postObj->post_author);
		$category_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_cat_type, array('fields' => 'names'));
		$category = '';
		if($category_array){
			$category =implode('&',$category_array);
		}
		$tag_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_tag_type, array('fields' => 'names'));
		$tags = '';
		if($tag_array){
			$tags =implode('&',$tag_array);
		}
		$args = array('post_id'=>$postObj->ID);
		$comments_data = get_comments( $args );
		//*--fetch comments ----*//;
	
		if($comments_data){
		foreach($comments_data as $comments_data_obj){
			foreach($comments_data_obj as $_comments_data_obj)
			  {
				if($_comments_data_obj ==""){
				$_comments_data_obj = "null";
				}
				 $newarray .= $_comments_data_obj."~";
			  }
			  $newarray .="##";
		}
		$newarray = str_replace(','," ",$newarray);
		}else{
		$newarray = "";
		}
	
		$content_1 =  array("$postObj->post_author","$post_date","$post_date_gmt","$post_title","$category","$image","$tags","$post_content","$post_excerpt","$postObj->post_status","$postObj->comment_status","$postObj->ping_status","$postObj->post_password","$postObj->post_name","$postObj->to_ping","$postObj->pinged","$postObj->post_modified","$postObj->post_modified_gmt","$postObj->post_content_filtered","$postObj->post_parent","$postObj->menu_order","$postObj->post_type","$postObj->post_mime_type","$postObj->comment_count");
		$content_1_array=array("$newarray");
	$new_csv_array=array_merge($content_1,$content_1_array);

	if ( !fputcsv($f, $new_csv_array))
	{
		echo "Can't write line $n: $line";
	}

	
	//echo $content_1." \r\n";

	
		}
		
	fclose($f);
	$csvStr = ob_get_contents();
	ob_end_clean();

	echo $csvStr;
	}else
	{
	echo "No record available";
	
	}
	
}
	?>