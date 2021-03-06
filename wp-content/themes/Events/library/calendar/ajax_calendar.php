<?php
/* Calendar code file will call through ajax using calendar.php */
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
global $post,$wpdb;
if(is_plugin_active('wpml-translation-management/plugin.php'))
{
	global  $sitepress;
	$sitepress->switch_lang($_REQUEST['language']);
}
/* display calendar fetching all event */
$monthNames = Array(__('January','templatic'), __('February','templatic'), __('March','templatic'), __('April','templatic'), __('May','templatic'), __('June','templatic'), __('July','templatic'), __('August','templatic'), __('September','templatic'), __('October','templatic'), __('November','templatic'), __('December','templatic'));
	
	if (!isset($_REQUEST["mnth"])) $_REQUEST["mnth"] = date("n");
	if (!isset($_REQUEST["yr"])) $_REQUEST["yr"] = date("Y");
	
	$cMonth = $_REQUEST["mnth"];
	$cYear = $_REQUEST["yr"];
	$prev_year = $cYear;
	$next_year = $cYear;
	$prev_month = $cMonth-1;
	$next_month = $cMonth+1;
	
	if ($prev_month == 0 ) {
		$prev_month = 12;
		$prev_year = $cYear - 1;
	}
	if ($next_month == 13 ) {
		$next_month = 1;
		$next_year = $cYear + 1;
	}
	$mainlink = $_SERVER['REQUEST_URI'];
	if(strstr($_SERVER['REQUEST_URI'],'?mnth') && strstr($_SERVER['REQUEST_URI'],'&yr'))
	{
		$replacestr = "?mnth=".$_REQUEST['mnth'].'&yr='.$_REQUEST['yr'];
		$mainlink = str_replace($replacestr,'',$mainlink);
	}elseif(strstr($_SERVER['REQUEST_URI'],'&mnth') && strstr($_SERVER['REQUEST_URI'],'&yr'))
	{
		$replacestr = "&mnth=".$_REQUEST['mnth'].'&yr='.$_REQUEST['yr'];
		$mainlink = str_replace($replacestr,'',$mainlink);
	}
	if(strstr($_SERVER['REQUEST_URI'],'?') && (!strstr($_SERVER['REQUEST_URI'],'?mnth')))
	{
		$pre_link = $mainlink."&mnth=". $prev_month . "&yr=" . $prev_year."#event_cal";
		$next_link = $mainlink."&mnth=". $next_month . "&yr=" . $next_year."#event_cal";
	}else
	{
		$pre_link = $mainlink."?mnth=". $prev_month . "&yr=" . $prev_year."#event_cal";	
		$next_link = $mainlink."?mnth=". $next_month . "&yr=" . $next_year."#event_cal";
	}
?>
<table width="100%" class="calendar">
	<tr align="center">
	<td> 
    
    <table width="100%">
     <tr align="center" class="title">
    <td width="10%" class="title"> <a href="javascript:void(0);" onclick="change_calendar(<?php echo $prev_month; ?>,<?php echo $prev_year; ?>)"> <img src="<?php bloginfo('template_directory'); ?>/library/calendar/previous.png" alt=""  /></a></td>
	<td   class="title"><?php _e($monthNames[$cMonth-1],'templatic'); echo ' '.$cYear; ?></td>
    <td width="10%" class="title"><a href="javascript:void(0);"  onclick="change_calendar(<?php echo $next_month; ?>,<?php echo $next_year; ?>)">  <img src="<?php bloginfo('template_directory'); ?>/library/calendar/next.png" alt=""  /></a> </td>
	</tr>
            </table>
    
     </td>
	</tr>
	<tr>
	<td align="center">
	<table width="100%" border="0" cellpadding="2" cellspacing="2"  class="calendar_widget">
	
	<tr>
	<td class="days" ><?php _e('M','templatic'); ?></td>
	<td  class="days" ><?php _e('T','templatic'); ?></td>
	<td class="days" ><?php _e('W','templatic'); ?></td>
	<td class="days" ><?php _e('T','templatic'); ?></td>
	<td class="days" ><?php _e('F','templatic'); ?></td>
	<td class="days" ><?php _e('S','templatic'); ?></td>
	<td  class="days" ><?php _e('S','templatic'); ?></td>
	</tr> 
	<?php
	$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
	$maxday = date("t",$timestamp);
	$thismonth = getdate ($timestamp);
	$startday = $thismonth['wday'];
			
	if(@$_GET['m'])
	{
		$m = $_GET['m'];	
		$py=substr($m,0,4);
		$pm=substr($m,4,2);
		$pd=substr($m,6,2);
		$monthstdate = "$cYear-$cMonth-01";
		$monthenddate = "$cYear-$cMonth-$maxday";
		
	}

	global $wpdb;
	$sun_start_date = 0;
	if($startday == 0 )
	{
		$count = 7;
	}else
	{
		$count = 0;
	}
	for ($i=1; $i<($maxday+$startday+$count); $i++) {
		if($startday == 0 )
		{
			$add_sun_start_date = 7;
			$sun_start_date++;
		}else
		{
			$add_sun_start_date = $startday;
			$sun_start_date = $i;
		}
		if(($sun_start_date % 7) == 1 ) echo "<tr>\n";
		if($sun_start_date < $add_sun_start_date){
			echo "<td class='date_n'></td>\n";
		}
		else 
		{
			$cal_date = $i - $add_sun_start_date + 1;
			$calday = $cal_date;
			if(strlen($cal_date)==1)
			{
				$calday="0".$cal_date;
			}
			$the_cal_date = $cal_date;
			$cMonth_date = $cMonth;
			if(strlen($the_cal_date)==1){$the_cal_date = '0'.$the_cal_date;}
			if(strlen($cMonth_date)==1){$cMonth_date = '0'.$cMonth_date;}
			global $post,$wpdb;
			$urlddate = "$cYear$cMonth_date$calday";
			$thelink = get_option('home')."/?s=Calender-Event&amp;m=$urlddate";
			
			$todaydate = "$cYear-$cMonth_date-$the_cal_date";
			global $todaydate;
			$posts_per_page=get_option('posts_per_page');
				$args=
				array( 'post_type' => 'event',
				'posts_per_page' => $posts_per_page	,
				'post_status' => array('publish','recurring')	,
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'st_date',
						'value' => $todaydate,
						'compare' => '<=',
						'type' => 'DATE'
					),
			// this array results in no return for both arrays
					array(
						'key' => 'end_date',
						'value' => $todaydate,
						'compare' => '>=',
						'type' => 'DATE'
					),
					array(
						'key' => 'event_type',
						'value' => 'Regular event',
						'compare' => '='
					)
				)
				);

				$my_query1 = null;
				$my_query1 = new WP_Query($args);
				add_action('posts_orderby','wpcal_orederby');
					//print_r($my_query);
				$post_info = '';
				$c = 0;
				$rec_dates = '';
				if( $my_query1->have_posts() )
				{
					$post_info .='<span class="popup_event">';
					while ($my_query1->have_posts()) : $my_query1->the_post();
						$is_recurring = get_post_meta($post->ID,'event_type',true);
							if(strtolower(trim($is_recurring)) == strtolower(trim('Recurring event'))){
									$recurrence_occurs = get_post_meta($post->ID,'recurrence_occurs',true);
									$rec_date = templ_recurrence_dates($post->ID);
									if(strstr($rec_date,',')){
										$rec_dates = explode(',',$rec_date);
									}else{
										$rec_dates = $rec_date;
									}													
							}
							//echo $todaydate;
							if(is_array($rec_dates) && strtolower(trim($is_recurring)) == strtolower(trim('Recurring event')) && in_array($todaydate,$rec_dates)){ /* if recurring event */
							$c = $counter++;
							$recurrence_days = get_post_meta($post->ID,'recurrence_days',true);	//on which day
					//	print_r($rec_dates);
							$end_date1 = strtotime(date("Y-m-d", strtotime($todaydate)) . " +$recurrence_days day");
							$end_date = get_formated_date(date('Y-m-d', $end_date1));
							$start_date1 = strtotime(date("Y-m-d", strtotime($todaydate)) . " +$recurrence_days day");
							$start_date = get_formated_date(date('Y-m-d', $start_date1));
								$post_info .=' 
								<a class="event_title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a><small>'.
								__('<b>Location : </b>').get_post_meta($post->ID,'address',true) .'<br>'.
								__('<b>Start Date : </b>').get_formated_date(get_post_meta($post->ID,'st_date',true)).' '.get_formated_time(get_post_meta($post->ID,'st_time',true)) .'<br />'. 
								__('<b>End Date : </b>').get_formated_date(get_post_meta($post->ID,'end_date',true)).' '.get_formated_time(get_post_meta($post->ID,'end_time',true)) .'</small>';
							}else if(strtolower($is_recurring) == strtolower('Regular event')){ /* if regular event */
									$post_info .=' 
								<a class="event_title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a><small>'.
								__('<b>Location : </b>').get_post_meta($post->ID,'address',true) .'<br>'.
								__('<b>Start Date : </b>').get_formated_date(get_post_meta($post->ID,'st_date',true)).' '.get_formated_time(get_post_meta($post->ID,'st_time',true)) .'<br />'. 
								__('<b>End Date : </b>').get_formated_date(get_post_meta($post->ID,'end_date',true)).' '.get_formated_time(get_post_meta($post->ID,'end_time',true)) .'</small>';							
							}
							endwhile;
					$post_info .='</span>';
				}
				echo "<td class='date_n' >";
				if($my_query1->have_posts())
				{
						
					$temp_calendar_date='';
					while ($my_query1->have_posts()) : $my_query1->the_post();
						/* separate out recurring events with regular events */
						$is_recurring = get_post_meta($post->ID,'event_type',true);
						if(is_array($rec_dates) && strtolower(trim($is_recurring)) == strtolower(trim('Recurring event')) && in_array($todaydate,$rec_dates) && $c >=0){ /* if recurring event */
							$calendar_date= "<a class=\"event_highlight\" href=\"$thelink\">". ($cal_date) . "</a>";
						}elseif(strtolower(trim($is_recurring)) == strtolower(trim('Regular event'))){
							$calendar_date= "<a class=\"event_highlight\" href=\"$thelink\">". ($cal_date) . "</a>";
						}else{
							$flg=1;							
							$calendar_date="<span class=\"no_event\" >". ($cal_date) . "</span>";
						}						
						
						if($cal_date!=$tmp_date)
						{							
							if($flg==1)						
							{
								$flg=0;
								$p=1;
								$temp_calendar_date=$calendar_date;								
							}
							else	
							{
								$p=0;
								$temp_calendar_date=$calendar_date;
								$tmp_date=$cal_date;
							}
						}	
					endwhile;	
					if($p==1)
						echo $temp_calendar_date;
					else
						echo '<div>'.$temp_calendar_date.$post_info."</div>";
				}else
				{
						echo "<span class=\"no_event\" >". ($cal_date) . "</span>";
				}
				echo "</div></td>\n";
		}
		if(($i % 7) == 0 ) echo "</tr>\n";
	}
	?>
	</tr>
	</table>
	</td>
</tr>
</table>