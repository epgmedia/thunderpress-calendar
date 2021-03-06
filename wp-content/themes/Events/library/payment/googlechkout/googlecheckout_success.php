<?php
session_start();
/*
NAME : RETURN FILE AFTER PAYING FOR AN EVENT
DESCRIPTION : THIS FILE WILL BE CALLED ON SUCCESSFUL PAYMENT AFTER SUBMITTING AN EVENT.
*/
$page_title = PAYMENT_SUCCESS_TITLE;
global $page_title;?>
<?php get_header(); ?>
<div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >
	 <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
<div class="breadcrumb_in"><a href="<?php echo home_url(); ?>"><?php _e('Home','templatic'); ?></a> &raquo; <?php echo $page_title; ?></div><?php } ?>
<?php 
$google_checkout_nonce = $_SESSION['wp_google_nonce'];
if ( wp_verify_nonce($google_checkout_nonce, 'google-checkout-nonce') ){
	unset($_SESSION['wp_google_nonce']);
if($_REQUEST['transaction_id'] != "" && $_REQUEST['pid'] != ""){
global $wpdb,$transection_db_table_name;
$trans_id = $wpdb->get_row("select * from $transection_db_table_name where trans_id='".$_REQUEST['transaction_id']."' and status=0");
if($trans_id !=""){
$filecontent = stripslashes(get_option('post_payment_success_msg_content'));
if(!$filecontent)
{
	$filecontent = PAYMENT_SUCCESS_MSG;
}
$store_name = get_option('blogname');
$order_id = $_REQUEST['pid'];
if(get_post_type($order_id)=='event')
{
	$post_link = home_url().'/?ptype=preview_event&alook=1&pid='.$_REQUEST['pid'];
}else
{
$post_link = home_url().'/?ptype=preview&alook=1&pid='.$_REQUEST['pid'];	
}


$buyer_information = "";
								global $custom_post_meta_db_table_name;
								$post = get_post($_REQUEST['pid']);
								$address = stripslashes(get_post_meta($post->ID,'geo_address',true));
								$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
								$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
								$timing = get_post_meta($post->ID,'timing',true);
								$contact = stripslashes(get_post_meta($post->ID,'contact',true));
								$email = get_post_meta($post->ID,'email',true);
								$website = get_post_meta($post->ID,'website',true);
								$twitter = get_post_meta($post->ID,'twitter',true);
								$facebook = get_post_meta($post->ID,'facebook',true);
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both') ";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,admin_title asc";
				$post_meta_info = $wpdb->get_results($sql);
				$buyer_information .= "<b>".$post->post_title."</b>";
				$buyer_information .= $post->post_content;
				if($address) {  
							$buyer_information .="<p> <span class='i_location'>".ADDRESS." :" ."</span> ". get_post_meta($post->ID,'geo_address',true)."  </p> "; 
							} 
				
				foreach($post_meta_info as $post_meta_info_obj){ 
					
					if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" ){
						if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "timing")
						{
							 
							
						
							$buyer_information .= "<div class='i_customlable'><span class='i_lbl'>".$post_meta_info_obj->site_title." :"."</span>";
							$buyer_information  .="<div class='i_customtext'>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div></div>";
						}
					 }		
		}
		
$search_array = array('[#site_name#]','[#submited_information_link#]','[#submited_information#]');
$replace_array = array($store_name,$post_link,$buyer_information);

$filecontent = str_replace($search_array,$replace_array,$filecontent);
?>
<div class="content-title"><?php echo $page_title; ?></div>
<?php
echo $filecontent;
if($_REQUEST['pid']!="" && $_REQUEST['transaction_id']!=""){
	global $wpdb,$transection_db_table_name;
	$default_post_status = strtolower(get_option('approve_status'));
	if($default_post_status=="published"){$default_post_status = "publish";}
	$wpdb->query("UPDATE $transection_db_table_name SET status=1, paypal_transection_id ='".$_REQUEST['txn_id']."' where trans_id = '".$_REQUEST['transaction_id']."'");
	$wpdb->query("UPDATE $wpdb->posts SET post_status='".$default_post_status."' where ID = '".$_REQUEST['pid']."'");
}
}else{
	echo INVALID_TRANSACTION_TITLE;
	echo AUTHENTICATION_CONTENT;

}
}else{
	echo INVALID_TRANSACTION_TITLE;
	echo INVALID_TRANSACTION_CONTENT;
}
}else{
	unset($_SESSION['wp_google_nonce']);
	echo INVALID_TRANSACTION_TITLE;
	echo INVALID_TRANSACTION_CONTENT;
}
?>
</div> <!-- content #end -->

<?php get_sidebar(); ?>

</div> 
<?php get_footer(); ?>