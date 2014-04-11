<?php
global $current_user;
/* Manage permission modue integration */
if(get_option('set_permission') == '') {
 set_option_selling('set_permission','administrator');
}
/*
Name : get_current_user_role
Desc :function return role of user
*/
function get_current_user_role() {
	global $wp_roles,$current_user;
	if(isset($current_user) && $current_user != ""){
	$roles = $current_user->roles;
	if(count($roles) > 1){
		$role = array_shift($roles);
		return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
	}else {
		if($roles){
		return $roles[0]; }
	}
	}
}
/*
Name : restrict_admin
Desc :function to restrict admin
*/
function restrict_admin(){
	$user_role = strtolower(get_current_user_role());
	$permission = explode(',',get_option('set_permission'));
	if(in_array($user_role,$permission) && get_option('set_permission') != '') {
		wp_die( __('You are not allowed to access this part of the site','templatic') );
	}
}
if(strtolower(get_current_user_role()) != 'administrator' ){
	add_action( 'admin_init','restrict_admin', 1 );
}
if(get_option('currency_symbol') == '') {
 set_option_selling('currency_symbol','USD');
}
if(get_option('set_permission') == '') {
 set_option_selling('set_permission','administrator');
}
/* Manage permission modue integration */
/* ========================== FUNCTION TO FETCH AMOUNT =============== */
function display_amount_with_currency($amount,$currency = ''){
	$amt_display = '';
	if($amount != ""){
	$currency = fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');
	$position = get_option('ptttheme_currency_position');
	if($position == 'Symbol Before amount'){
		$amt_display = $currency.$amount;
	} else if($position == 'Space between Before amount and Symbol'){
		$amt_display = $currency.' '.$amount;
	} else if($position == 'Symbol After amount'){
		$amt_display = $amount.$currency;
	} else {
		$amt_display = $amount.' '.$currency;
	}
	return $amt_display;
	}
}
//END OF FUNCTION

/* ============================= FUNCTION TO FETCH CURRENCY ================== */
function fetch_currency($currency_code,$field = '')
{
	global $wpdb;
	$currency_res = get_option('ptttheme_currency_symbol');
	return $currency_res;
}
//END OF FUNCTION

/* ================== FUNCTION TO FETCH TRANSACTIONS ============== */
function get_transaction_status($tid){
	global $wpdb,$transection_db_table_name;
	$trans_status = $wpdb->get_var("select status from $transection_db_table_name where trans_id = '".$tid."'");
	echo "<div id='p_status_".$tid."'>";
	if($trans_status == 0){
		echo '<a style="color:#E66F00; font-weight:normal;" onclick="change_transstatus('.$tid.')" href="javascript:void(0);">Pending</a>';
	}else if($trans_status == 1){
		echo '<span style="color:green; font-weight:normal;">Approved</span>';
	}else{
		echo '<span style="color:red">Canceled</span>';
	}
	echo "</div>";	
}
//END OF FUNCTION

/* set option BOF*/
function set_option_selling($option_name,$option_value){
	global $wpdb;
	$option_sql = "select option_value from $wpdb->options where option_name='$option_name'";
	$option_info = $wpdb->get_results($option_sql);
	if($option_info)	{
		update_option($option_name,$option_value);
	} else {
		$insertoption = "insert into $wpdb->options (option_name,option_value) values ('$option_name','$option_value')";
		$wpdb->query($insertoption);
	}
}
/* set option EOF*/

/*================= FUNCTION FOR PAGINATION FOR TRANSACTION REPTORT =====*/
function get_pagination_of($targetpage,$total_pages,$limit=10,$page=0,$extra_url = '')
{
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	if(strstr($targetpage,'?'))
	{
		$querystr = "&amp;pagination";
	}else
	{
		$querystr = "?pagination";
	}
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= '<a href="'.$targetpage.$querystr.'='.$prev.$extra_url.'">&laquo; previous</a>';
		else
			$pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= '<a href="'.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= '<a href="'.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
				}
				$pagination.= "...";
				$pagination.= '<a href="'.$targetpage.$querystr.'='.$lpm1.$extra_url.'">'.$lpm1.'</a>';
				$pagination.= '<a href="'.$targetpage.$querystr.'='.$lastpage.$extra_url.'">'.$lastpage.'</a>';		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= '<a href="'.$targetpage.$querystr.'=1'.$extra_url.'">1</a>';
				$pagination.= '<a href="'.$targetpage.$querystr.'=2'.$extra_url.'">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= '<a href='.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
				}
				$pagination.= "...";
				$pagination.= '<a href="'.$targetpage.$querystr.'='.$lpm1.$extra_url.'">'.$lpm1.'</a>';
				$pagination.= '<a href="'.$targetpage.$querystr.'='.$lastpage.$extra_url.'">'.$lastpage.'</a>';		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= '<a href="'.$targetpage.$querystr.'=1'.$extra_url.'">1</a>';
				$pagination.= '<a href="'.$targetpage.$querystr.'=2'.$extra_url.'">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= '<a href="'.$targetpage.$querystr.'='.$counter.$extra_url.'">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= '<a href="'.$targetpage.$querystr.'='.$next.$extra_url.'">next &raquo;</a>';
		else
			$pagination.= "<span class=\"disabled\">next &raquo;</span>";
		$pagination.= "</div>\n";		
	}
	return $pagination;
}
//END OF FUNCTION
?>