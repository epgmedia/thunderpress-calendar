<?php 
if( get_option('ptthemes_auto_install') == 'No' || get_option('ptthemes_auto_install') == ''){
	add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.
}
function autoinstall_admin_header(){
	global $wpdb;
	if(strstr($_SERVER['REQUEST_URI'],'themes.php') && @$_REQUEST['template']=='' && @$_GET['page']==''){
		$menu_msg = "<p><b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/events-v2-theme-guide/'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums'> <b>Community Forum</b></a></p>";
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
		if($post_counts>0){
			$dummy_data_msg = 'Sample data has been <b>populated</b> on your site. Your sample portal website is ready, click <strong><a href='.site_url().'>here</a></strong> to see how its looks.<a href="javascript:;" id="dismiss-ajax-notification" class="templatic-dismiss" style="float:right;">Dismiss</a>'.$menu_msg.'<p> Wish to delete sample data?  <a class="button_delete button-primary" href="'.home_url().'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a></p>';
		}else{
			$dummy_data_msg = 'Install sample data: Would you like to <b>auto populate</b> sample data on your site?  <a class="button_insert button-primary" href="'.home_url().'/wp-admin/themes.php?dummy_insert=1&dump=1">Yes, insert please</a><a href="javascript:;" id="dismiss-ajax-notification" class="templatic-dismiss" style="float:right;">Dismiss</a>'.$menu_msg;
		}
		if(@$_REQUEST['dummy']=='del'){
			delete_dummy_data();
			wp_redirect(admin_url().'themes.php');
		}
		if(@$_REQUEST['dummy_insert']){
			require_once (TEMPLATEPATH . '/library/includes/auto_install/auto_install_data.php');
			wp_redirect(admin_url().'themes.php');
		}
		echo '<div id="ajax-notification" class="updated templatic_autoinstall"><p> '.$dummy_data_msg.'</p><span id="ajax-notification-nonce" class="hidden">' . wp_create_nonce( 'ajax-notification-nonce' ) . '</span></div>';
	}
}
function delete_dummy_data(){
	global $wpdb;
	delete_option('sidebars_widgets'); //delete widgets
	$productArray = array();
	$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')";
	$pids_info = $wpdb->get_results($pids_sql);
	foreach($pids_info as $pids_info_obj){
		wp_delete_post($pids_info_obj->ID,true);
	}
}

/* Setting For dismiss auto install notification message from themes.php START */
register_activation_hook( __FILE__, 'activate'  );
register_deactivation_hook( __FILE__, 'deactivate'  );
add_action( 'admin_enqueue_scripts', 'register_admin_scripts'  );
add_action( 'wp_ajax_hide_admin_notification', 'hide_admin_notification' );
function activate() {
	add_option( 'ptthemes_auto_install', 'No' );
}
function deactivate() {
	delete_option( 'ptthemes_auto_install' );
}
function register_admin_scripts() {
	wp_register_script( 'ajax-notification-admin', get_stylesheet_directory_uri().'/js/admin_notification.js'  );
	wp_enqueue_script( 'ajax-notification-admin' );
}
function hide_admin_notification() {
	if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax-notification-nonce' ) ) {
		if( update_option( 'ptthemes_auto_install', 'Yes' ) ) {
			die( '1' );
		} else {
			die( '0' );
		}
	}
}
/* Setting For dismiss auto install notification message from themes.php END */


//Alert warning message when user goes to delete data: start
add_action('admin_footer','delete_sample_data');
if(!function_exists('delete_sample_data')){
function delete_sample_data(){
?>
<script type="text/javascript">
jQuery(document).ready( function(){
	jQuery('.button_delete').click( function() {
		if(confirm('All the sample data and your modifications done with it, will be deleted forever! Still you want to proceed?')){
			window.location = "<?php echo home_url()?>/wp-admin/themes.php?dummy=del";
		}else{
			return false;
		}	
	});
});
</script>
<?php } }?>