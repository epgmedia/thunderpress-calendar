<?php
/*
NAME : SUCCESS FILE FOR PAYMENT THROUGH PRE BANK TRANSFER
DESCRIPTION : THIS FILE WILL BE CALLED ON SUCCESSFUL PAYMENT THROUGH PRE BANK TRANSFER. THE CODE MENTIONED IN THIS FILE WILL SHOW A MESSAGE IF THE USER SUBMIT HIS EVENT BY USING PRE BANK TRANSFER.
*/
if($_REQUEST['renew'])
{
	$title = RENEW_SUCCESS_TITLE;
}else
{
	$title = POSTED_SUCCESS_TITLE;
}
?>
<?php
$paymentmethod = get_post_meta($_REQUEST['pid'],'paymentmethod',true);
$paid_amount = get_currency_sym().get_post_meta($_REQUEST['pid'],'paid_amount',true);
global $upload_folder_path;

if($paymentmethod == 'prebanktransfer')
{
	$filecontent = POSTED_SUCCESS_PREBANK_MSG;
}else
{
	$filecontent = stripslashes(get_option('post_added_success_msg_content'));
	if(!$filecontent)
		$filecontent = POSTED_SUCCESS_MSG;	
	$filecontent = __($filecontent);
}
if(file_exists($destinationfile))
{
	$filecontent = file_get_contents($destinationfile);
}
?>
<?php get_header(); ?>

<div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >

    <h1><?php echo $title;?></h1>   
    <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><?php yoast_breadcrumb('',' &raquo; '.$title);  ?></div>
    </div>
<?php } ?>
<div id="content" class="content_inner hrspc" >
<?php
$store_name = get_option('blogname');
if($paymentmethod == 'prebanktransfer')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_name='payment_method_".$paymentmethod."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	$paymentInfo = unserialize($paymentupdinfo[0]->option_value);
	$payOpts = $paymentInfo['payOpts'];
	$bankInfo = $payOpts[0]['value'];
	$accountinfo = $payOpts[1]['value'];
}
$order_id = $_REQUEST['pid'];
$post_link = get_option('home').'/?ptype=preview&alook=1&pid='.$_REQUEST['pid'];
$orderId = $_REQUEST['pid'];
$search_array = array('[#order_amt#]','[#bank_name#]','[#account_number#]','[#orderId#]','[#site_name#]','[#submited_information_link#]');
$replace_array = array($paid_amount,$bankInfo,$accountinfo,$order_id,$store_name,$post_link);
$filecontent = str_replace($search_array,$replace_array,$filecontent);
echo $filecontent;
?> 
</div> <!-- content #end -->
<?php if(get_post_type($order_id)== CUSTOM_POST_TYPE1){ ?>
<h1><?php echo get_the_title($_REQUEST['pid']); ?></h1>
<div class="detail_list">
    <div class="col_right">
                 <?php	
                global $custom_post_meta_db_table_name;
                $sql = "select * from $custom_post_meta_db_table_name where is_active=1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both')";
                if($fields_name)
                {
                    $fields_name = '"'.str_replace(',','","',$fields_name).'"';
                    $sql .= " and htmlvar_name in ($fields_name) ";
                }
                $sql .=  " order by sort_order asc,cid asc";
                $post_meta_info = $wpdb->get_results($sql);
                foreach($post_meta_info as $post_meta_info_obj){
                    if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
                            if($post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "how_to_apply" && $post_meta_info_obj->htmlvar_name != "proprty_desc" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "map_view" && $post_meta_info_obj->htmlvar_name != "reg_desc" && $post_meta_info_obj->htmlvar_name != "phone" && $post_meta_info_obj->htmlvar_name != "email" && $post_meta_info_obj->htmlvar_name != "website")
                                {
                                    if($post_meta_info_obj->ctype =='texteditor') {
										if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) !=''){
                                        echo "<div class='text-editor'><span>".$post_meta_info_obj->site_title."</span>: ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</div>";
										}
                                    }
                                    elseif($post_meta_info_obj->ctype =='textarea') {
										if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) !=''){
											echo "<p><span>".$post_meta_info_obj->site_title.":</span></p><p class='text-width'> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
										}
                                    }
                                    else {
                                        if($post_meta_info_obj->ctype == 'multicheckbox'):
                                            $checkArr = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true);
                                            if($checkArr):
                                                foreach($checkArr as $_checkArr)
                                                {
                                                    $check .= $_checkArr.",";
                                                }
                                            endif;	
											$check = substr($check,0,-1);
											if($check):
	                                            echo "<p><span>".$post_meta_info_obj->site_title.":</span></p><p class='text-width'> ".$check."</p>";
											endif;	
                                        else:
                                            if(get_post_meta($order_id,$post_meta_info_obj->htmlvar_name,$single = true) != ""):
                                                echo "<p><span>".$post_meta_info_obj->site_title.":</span></p><p class='text-width'> ".get_post_meta($order_id,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
                                            endif;	
                                        endif;	
                                    } 
                        }?>
                     <?php  $i++;
                     }
        }			
        ?>
    </div>
    <div class="clear"></div>
</div>
<?php } ?>
</div> <!-- content #end -->

    <?php get_sidebar(); ?>

</div> <!-- wrapper #end -->
<div id="bottom"></div>  
<?php get_footer(); ?>