<?php
/* DEFINE NAME FOR RATING TABLE */
$rating_table_name = $wpdb->prefix.'ratings';
global $rating_table_name;
/* Function to fetch category name EOF */
function display_custom_post_field($custom_metaboxes,$session_variable,$geo_latitude='',$geo_longitude='',$geo_address='',$post_type){
	add_action('wp_head','add_recurring_js');
	foreach($custom_metaboxes as $key=>$val) {
		$name = $val['name'];
		$site_title = $val['site_title'];
		$type = $val['type'];
		$htmlvar_name = $val['htmlvar_name'];
		$admin_desc = $val['desc'];
		$option_values = $val['option_values'];
		$default_value = $val['default'];
		$style_class = $val['style_class'];
		$extra_parameter = $val['extra_parameter'];
		/* Is required CHECK BOF */
		$is_required = '';
		$input_type = '';
		if($val['is_require'] == '1'){
			$is_required = '<span>*</span>';
			$is_required_msg = '<span id="'.$name.'_error" class="message_error2"></span>';
		} else {
			$is_required = '';
			$is_required_msg = '';
		}
		/* Is required CHECK EOF */
		if(@$_REQUEST['pid'])
		{
			$post_info = get_post_info($_REQUEST['pid']);
			if($name == 'event_name') {
				$value = $post_info['post_title'];
			} elseif( $name == 'proprty_desc' ) {
				$value = $post_info['post_content'];
			}
			else {
				$value = get_post_meta($_REQUEST['pid'], $name,true);
			}
			
		}
		if(@$_SESSION[$session_variable] && $_REQUEST['backandedit'])
		{
			$value = $_SESSION[$session_variable][$name];
		}
	?>
	<div class="form_row clearfix <?php echo $style_class; ?>">
	   <?php if($type=='text'){ ?>
	   <label><?php echo $site_title.$is_required; ?></label>
	   <div class="ghst">
	   <?php if($name == 'geo_latitude' || $name == 'geo_longitude') {
			$extra_script = 'onblur="changeMap();"';
			
		} else {
			$extra_script = '';
			
		}?></div>
	 <input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo stripslashes(@$value);?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> <?php echo $extra_script;?> PLACEHOLDER="<?php echo  $val['default']; ?>"/>
	<?php
		}elseif(@$type=='date'){
		?>     
		<label><?php echo $site_title.$is_required; ?></label>
		<input type="text" name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield <?php echo $style_class;?>" value="<?php echo esc_attr(stripslashes(@$value)); ?>" size="25" <?php echo $extra_parameter;?> />
		&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" id="<?php echo $name;?>" alt="Calendar" onclick="displayCalendar(document.propertyform.<?php echo $name;?>,'yyyy-mm-dd',this); check_date(this.id);" style="cursor: pointer; margin-left:5px;" />
		<?php
		}
		elseif($type=='multicheckbox')
		{ ?>
		 <label><?php echo $site_title.$is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if(!isset($_REQUEST['pid']) && !$_REQUEST['backandedit'])
			{
				$default_value = explode(",",$val['default']);
			}
			if($options)
			{  $chkcounter = 0;
				echo '<div class="form_cat_right">';
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if(isset($_REQUEST['pid']) || $_REQUEST['backandedit'])
					{
						$default_value = $value;
					}
					if($default_value !=''){
					if(in_array($option_values_arr[$i],$default_value)){ 
					$seled='checked="checked"';} }	
										
					echo '
					<div class="form_cat">
						<label>
							<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				echo '</div>';
			}
		}
		
		elseif($type=='texteditor'){	?>
		<label><?php echo $site_title.$is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" PLACEHOLDER="<?php echo  $val['default']; ?>" class="mce <?php if($style_class != '') { echo $style_class;}?>" <?php echo $extra_parameter;?> ><?php if(@$value != '') { echo stripslashes($value); }else{ echo  stripslashes($val['default']); } ?></textarea>
		<?php
		}elseif($type=='textarea'){
		?>
		<label><?php echo $site_title.$is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" class="<?php if($style_class != '') { echo $style_class;}?> textarea" <?php echo $extra_parameter;?>><?php echo stripslashes(@$value);?></textarea>       
		<?php
		}elseif($type=='radio'){
		?>     
		 <label class="r_lbl"><?php echo $site_title.$is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if(!isset($_REQUEST['pid']) && !$_REQUEST['backandedit'])
			{
				$default_value = explode(",",$val['default']);
			}
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if(isset($_REQUEST['pid']) || $_REQUEST['backandedit'])
					{
						$default_value = $value;
					}
					
					if($default_value == $option_values_arr[$i] || in_array($option_values_arr[$i],$default_value)){ $seled="checked=checked";}							
					if (trim(@$value) == trim($option_values_arr[$i])){ $seled="checked=checked";}
					$event_type = array("Regular event", "Recurring event");
					if($key == 'event_type'):
						if (trim(@$value) == trim($event_type[$i])){ $seled="checked=checked";}
						echo '
							<label class="r_lbl_option">
								<input name="'.$key.'"  id="'.$key.'_'.$chkcounter.'" type="radio" value="'.$event_type[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
							</label>';
					else:
					echo '
						<label class="r_lbl_option">
							<input name="'.$key.'"  id="'.$key.'_'.$chkcounter.'" type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>';
					endif;
				}
				
			}
		}elseif($type=='select'){
		?>
			<label><?php echo $site_title.$is_required; ?></label>
            <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield textfield_x <?php echo $style_class;?>" <?php echo $extra_parameter;?>>
            <option value="">Please Select</option>
            <?php if($option_values){
			if(!isset($_REQUEST['pid']) && !$_REQUEST['backandedit'])
			{
				$default_value = explode(",",$val['default']);
			}
            $option_values_arr = explode(',',$option_values);
            for($i=0;$i<count($option_values_arr);$i++)
            {
				if(isset($_REQUEST['pid']) || $_REQUEST['backandedit'])
				{
					$value = $option_values_arr[$i];
				}
            ?>
            <option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value == $option_values_arr[$i] || in_array($option_values_arr[$i],$default_value)){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
            <?php	
            }
            ?>
            <?php }?>
           
            </select>
		<?php
		}else if($type=='upload'){ ?>
		 <label><?php echo $site_title.$is_required; ?></label>
         <div class="upload" style="overflow:hidden; position:relative;" ><span>Upload Image</span>
		 <input type="file" value="<?php echo @$value; ?>" name="<?php echo $name; ?>" style="font-size:28px; cursor:pointer;opacity:0;position:absolute; bottom:0; right:-2px; top:-6px;" onchange="check_file_type(this,'<?php echo $name; ?>');"/>
		 </div>           
           <span id="<?php echo $name; ?>" class="status_message message_note"></span>
		<?php }else if($type=='checkbox'){ ?>

		<input type="checkbox" value="<?php echo $value; ?>" name="<?php echo $name; ?>"/><?php echo $site_title.$is_required; ?>
		
		<?php }
		if($type != 'image_uploader') {?>
		 <span class="message_note"><?php echo $admin_desc;?></span><?php echo $is_required_msg;?>
		 <?php } ?>
	  </div>
	  <?php if($type=='geo_map') { ?>
		<div class="form_row clearfix"> 
		<?php include_once(TEMPLATEPATH . "/library/map/location_add_map.php");?>
		<span class="message_note"><?php echo GET_MAP_MSG;?></span>
		</div> <?php } ?>
	<?php if($type=='image_uploader') { ?>
		<h5 class="form_title"> <?php echo PRO_PHOTO_TEXT;?></h5>
		<div class="form_row clearfix">
			<?php include (TT_MODULES_FOLDER_PATH."general/image_uploader.php"); ?>
			<span class="message_note"><?php echo $admin_desc;?></span>
		</div>
	<?php } 
					if($key == "event_type"){ 
						$name_of_day = event_get_days_names();
						$hours_format = event_get_hour_format();
						if($_SESSION[$session_variable] && $_REQUEST['backandedit'])
						{
							$event_type = $_SESSION[$session_variable]['event_type'];
							$recurrence_occurs = $_SESSION[$session_variable]['recurrence_occurs'];
							$recurrence_per = $_SESSION[$session_variable]['recurrence_per'];
							$recurrence_onday = $_SESSION[$session_variable]['recurrence_onday'];
							$recurrence_onweekno = $_SESSION[$session_variable]['recurrence_onweekno'];
							$recurrence_days = $_SESSION[$session_variable]['recurrence_days'];
							$recurrence_byday = $_SESSION[$session_variable]['recurrence_byday'];
							$monthly_recurrence_byweekno = $_SESSION[$session_variable]['monthly_recurrence_byweekno'];
						}
						else
						{
							$event_type = get_post_meta(@$_REQUEST['pid'],'event_type',true);
							$recurrence_occurs = get_post_meta(@$_REQUEST['pid'],'recurrence_occurs',true);
							$recurrence_per = get_post_meta(@$_REQUEST['pid'],'recurrence_per',true);
							$recurrence_onday = get_post_meta(@$_REQUEST['pid'],'recurrence_onday',true);
							$recurrence_onweekno = get_post_meta(@$_REQUEST['pid'],'recurrence_onweekno',true);
							$recurrence_days = get_post_meta(@$_REQUEST['pid'],'recurrence_days',true);
							$monthly_recurrence_byweekno = get_post_meta(@$_REQUEST['pid'],'monthly_recurrence_byweekno',true);
							$recurrence_byday = get_post_meta(@$_REQUEST['pid'],'recurrence_byday',true);
						}

					?>
                    <div class="form_row clearfix" id="recurring_event" <?php if(trim(strtolower($event_type)) == trim(strtolower('Recurring event'))){  ?>style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
					
						
						 <div class="form_row_rec form_row clearfix">
							 <?php _e('Event will repeat','templatic'); ?>
							 <select id="recurrence-occurs" name="recurrence_occurs">
								<?php
									$rec_options = array ("daily" => __ ( 'Daily', 'templatic' ), "weekly" => __ ( 'Weekly', 'templatic' ), "monthly" => __ ( 'Monthly', 'templatic' ), 'yearly' => __('Yearly','templatic') );
									event_rec_option_items ( $rec_options,$recurrence_occurs); 
								echo @$recurrence_occurs; ?>
							</select>
							<?php _e ( 'every', 'templatic' )?>
							<input id="recurrence-per" name='recurrence_per' size='2' value='<?php echo $recurrence_per ; ?>' />
							
							<span class='rec-span' id="recurrence-perday" <?php if((@$recurrence_occurs =='daily' && @$recurrence_per == 1) || !$recurrence_occurs){ ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'day', 'templatic' )?></span>
							<span class='rec-span' id="recurrence-perdays" <?php  if(@$recurrence_occurs =='daily' && @$recurrence_per > 1){ ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'days', 'templatic' ) ?></span>
							
							<span class='rec-span' id="recurrence-perweek" <?php if(@$recurrence_occurs =='weekly' && @$recurrence_per == 1){ ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'week on', 'templatic'); ?></span>
							<span class='rec-span' id="recurrence-perweeks" <?php if(@$recurrence_occurs =='weekly' && @$recurrence_per > 1){ ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'weeks on', 'templatic'); ?></span>
		
							<span class='rec-span' id="recurrence-permonth" <?php if(@$recurrence_occurs =='monthly' && @$recurrence_per == 1){ ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'month on the', 'templatic' )?></span>
							<span class='rec-span' id="recurrence-permonths" <?php if(@$recurrence_occurs =='monthly' && @$recurrence_per > 1){ ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'months on the', 'templatic' )?></span>

							
							<span class='rec-span' id="recurrence-peryear" <?php if(@$recurrence_occurs =='yearly' && @$recurrence_per == 1){   ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'year', 'templatic' )?></span> 
							<span class='rec-span' id="recurrence-peryears" <?php if(@$recurrence_occurs =='yearly' && @$recurrence_per > 1){   ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>><?php _e ( 'years', 'templatic' ) ?></span>

						 </div>
						 
						 <div class="form_weekly_days form_row clearfix" id="weekly-days" <?php  if(@$recurrence_occurs =='weekly' || $recurrence_occurs =='weekly'){  ?>style="display:inline-block;"<?php }else{ ?>style="display:none;"<?php } ?>>
							<?php
								$saved_bydays =  explode ( ",", $recurrence_onday ); 
								event_checkbox_items ( 'recurrence_bydays[]', $name_of_day, $saved_bydays ); 
							?>
						 </div>
							<div class="monthly_opt_container" id="monthly_opt_container" <?php if($recurrence_occurs =='monthly'){ ?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?>>
								<select id="monthly-modifier" name="monthly_recurrence_byweekno">
									<?php
										$weeks_options = array ("1" => __ ( 'first', 'templatic' ), '2' => __ ( 'second', 'templatic' ), '3' => __ ( 'third', 'templatic' ), '4' => __ ( 'fourth', 'templatic' ), '-1' => __ ( 'last', 'templatic' ) ); 
										event_rec_option_items ( $weeks_options, $monthly_recurrence_byweekno  ); 
									?>
								</select>
								<select id="recurrence-weekday" name="recurrence_byday">
									<?php event_rec_option_items ( $name_of_day, $recurrence_byday  ); ?>
								</select>
								<?php _e('of each month','templatic'); ?>
								&nbsp;
							</div>
						<div class="form_last_days form_row clearfix">
							<?php _e('Each event ends after ','templatic'); ?>
							<input id="end_days" type="text"  maxlength="8" name="recurrence_days" value="<?php echo $recurrence_days; ?>" />
							<?php _e('day(s)','templatic'); ?>
						</div>
						

						<?php global $pagenow; 
						if((isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') || (isset($_REQUEST['renew']) && $_REQUEST['renew'] == 1)):
					?>
						<p><span style="color:red;font-weight:bold;"><?php _e('Please note',T_DOMAIN);  ?>: </span> <?php _e('Updating these recurring properties will generate new URLs for instances of this recurring event. When that happens external links to those instances will stop working.',T_DOMAIN); ?></p>
					<?php endif; 

							if(!isset($_REQUEST['pid'])): ?>
								<div style="color:red;"><?php _e('Each occurrence of this recurring event will be created as a separate event.',T_DOMAIN); ?></div>
							<?php endif;  

							if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' || $_REQUEST['pid'] !=''){

									global $post;
									$chk_sel = get_post_meta($post->ID,'allow_to_create_rec',true);
									if($chk_sel == 'yes'){ $checked = "checked=checked";  }else{ $checked = ""; }
								
						?>
							<!--<input type="checkbox" id="allow_to_create_rec" name="allow_to_create_rec" value="yes" <?php //echo $checked; ?>/><?php //_e('Allow to create new recurrences',T_DOMAIN); ?>-->
							
						<?php } ?>
                    </div>
                    <script type="text/javascript">
				 function getExtension(filename) {
				    var i = filename.lastIndexOf('.');
				    return (i < 0) ? '' : filename.substr(i);
				 }
				 function check_file_type(name,id)
				 {
					 var value=name.value;						
					 var ext=getExtension(value);			
					 if (! (ext && /^(.jpg|.png|.jpeg|.gif)$/.test(ext))){									 	
						jQuery('#'+id).html('Only JPG, PNG or GIF files are allowed');
					}else
					{
						jQuery('#'+id).html('');
					}				 
				 }
				 </script>
					<?php } 
	}
} ?>
<?php /* Function to fetch category name BOF */
function get_categoty_name($cat_id)
{

	global $wpdb;
	$cat_name ="";
		$table_prefix = $wpdb->prefix;
		$wpcat_id = NULL; 
	$pos = explode(',',$cat_id);
	$cat_id1 = implode('&',$pos);
	$pos_of = strpos($cat_id1,'&');
	if($pos_of == false){
		$wpcategories = $wpdb->get_row("
        SELECT * FROM {$table_prefix}terms
        WHERE {$table_prefix}terms.term_id = '".$cat_id."'");
		_e($wpcategories->name,'templatic');
	}else{
		$cid = explode('&',$cat_id1);
		$total_cid = count($cid);
		for($c=0;$c<=$total_cid;$c++){
			$wpcategories = $wpdb->get_row("
        SELECT * FROM {$table_prefix}terms
        WHERE {$table_prefix}terms.term_id = '".$cid[$c]."'");
			if($wpcategories->name !=""){
			$cat_name .= $wpcategories->name.", "; }
		}
			echo $cat_name;
	}
	
	   
}
/* Function to fetch category name EOF */


function get_price_info($title='',$catid = '',$ptype)
{	
	global $price_db_table_name,$wpdb;

	$catarray = explode(',',$catid);
	$cat_display=get_option('ptthemes_category_dislay');
	$catid1 = ",".$catid.",";
	$catid2 = $catid.",";
	$catid3 = ",".$catid;
	if($catid != ""){ 
		if($cat_display == 'select'){ 
			$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both') and ((price_post_cat LIKE '%".$catid1."%' or price_post_cat LIKE '%".$catid2."%' or price_post_cat LIKE '%".$catid3."%' or price_post_cat = '".$catid."') or is_show=1) and status=1  "; 
		}else{
			$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both') and (price_post_cat RLIKE '".$catid.'0'."' or is_show=1) and status=1";
		}
	} else {
		
		$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both') and status=1 and is_show=1" ;
	}

	$priceinfo = $wpdb->get_results($pricesql);
	if($priceinfo)
	{
		$counter=1;
		foreach($priceinfo as $priceinfoObj)
		{	
			$pricecat= stristr($priceinfoObj->price_post_cat,$catid1);
	
		?>
         <div class="package">
		 <label><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>" onClick="show_featuredprice(this.value);"/>
		 <h3><?php _e($priceinfoObj->price_title,'templatic');?></h3>
		 <p><?php _e($priceinfoObj->price_desc,'templatic');?></p>
		 <p class="cost"><span><?php _e('Cost :','templatic'); ?> <?php _e(display_amount_with_currency($priceinfoObj->package_cost),'templatic'); ?></span> <span><?php _e('Package Validity :','templatic'); ?> <?php _e($priceinfoObj->validity,'templatic'); if($priceinfoObj->validity_per == 'D'){ _e(' Days','templatic'); }else if($priceinfoObj->validity_per == 'M'){ _e(' Months','templatic'); }else{   _e(' Years','templatic'); }?></span>
		 <br/><?php if('recurring' == '1') { ?>
		 <span><?php if($priceinfoObj->billing_cycle != "")
				{
					_e('Will be auto renewed','templatic');
					echo "&nbsp;"; _e($priceinfoObj->billing_cycle,'templatic'); 
					echo "&nbsp;"; _e('times','templatic');
				}
				if($priceinfoObj->billing_num != "")
				{
					echo "&nbsp;"; _e('every','templatic');
					echo "&nbsp;"; _e($priceinfoObj->billing_num,'templatic');
					echo "&nbsp;";
					if($priceinfoObj->billing_num == 'D'){ _e(' Days','templatic'); }else if($priceinfoObj->billing_num == 'M'){ _e(' Months','templatic'); }else{   _e(' Years','templatic'); }
				} ?></span><?php } ?>
		</p></label>
		 </div>
        <?php $counter++;
		}
	}
}
function search_custom_post_field($custom_metaboxes){
		foreach($custom_metaboxes as $key=>$val) {
		$name = $val['name'];
		$site_title = $val['site_title'];
		$type = $val['type'];
		$admin_desc = $val['desc'];
		$option_values = $val['option_values'];
		$default_value = $val['default'];
		$style_class = $val['style_class'];
		$extra_parameter = $val['extra_parameter'];
		if(@$_REQUEST[$name]){
			$value = $_REQUEST[$name];
		} ?>
	<div class="search_row clearfix">
	   <?php if($type=='text'){?>
	   <label><?php echo $site_title; ?></label>
		<input name="<?php echo $name;?>"  value="<?php echo $_REQUEST[$name];?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> />
	   <?php 
		}elseif($type=='geo_map'){
		?>     
		 <label><?php echo $site_title; ?></label>      
		<input name="<?php echo $name;?>"  value="<?php echo $_REQUEST[$name];?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> />
		
		<?php
		}elseif($type=='checkbox'){
		?>     
		 <label>&nbsp;</label>      
		<input name="<?php echo $name;?>"  <?php if($_REQUEST[$name]){ echo 'checked="checked"';}?>  value="<?php echo $value;?>" type="checkbox" <?php echo 	$extra_parameter;?> /> <?php echo $site_title; ?>
		<?php
		}elseif($type=='radio'){
		?>     
		 <label class="search_row clearfix"><?php echo $site_title." : "; ?></label>
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
					if (trim($_REQUEST[$name]) == trim($option_values_arr[$i])){ $seled='checked="checked"';}	
					echo '
					<div>
						<label>
							<input name="'.$key.'"   type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				
			}
	   
		}elseif($type=='date'){
		?>     
		<label><?php echo $site_title; ?></label>
		<input type="text" name="<?php echo $name;?>" class="textfield <?php echo $style_class;?>" value="<?php echo esc_attr(stripslashes(@$_REQUEST[$name])); ?>" size="25" <?php echo 	$extra_parameter;?> />
		&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.srchevent.<?php echo $name;?>,'yyyy-mm-dd',this)" style="cursor: pointer; margin-left:5px;" />
		<?php
		}
		elseif($type=='multicheckbox')	{ ?>
		 <label><?php echo $site_title." : "; ?></label>
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
					echo '
					<div >
						<label>
							<input name="'.$key.'[]"   type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				
			}
		}
		elseif($type=='textarea' || $type=='texteditor'){ ?>
		<label><?php echo $site_title; ?></label>
		<textarea name="<?php echo $name;?>"  class="<?php if($style_class != '') { echo $style_class;}?> textfield" <?php echo $extra_parameter;?>><?php echo $_REQUEST[$name];?></textarea>       
		<?php
		}elseif($type=='select'){
	   
		?>
		 <label><?php echo $site_title; ?></label>
		<select name="<?php echo $name;?>" class="textfield textfield_x <?php echo $style_class;?>" <?php echo $extra_parameter;?>>
		<option value="" ><?php echo __('Select','templatic')." ".$name;?></option>
		<?php if($option_values){
		
		$option_values_arr = explode(',',$option_values);
		
		for($i=0;$i<count($option_values_arr);$i++)
		{
		?>
		<option value="<?php echo $option_values_arr[$i]; ?>" <?php if($_REQUEST[$name]==$option_values_arr[$i]){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
		<?php	
		}
		?>
		<?php }?>
	   
		</select>
		
		<?php
		}
		 ?>
	  </div>
	
	<?php
	
	}
}
/* ====================== FUNCTION TO FETCH USER META =================== */
function templ_get_user_meta($types='registration')
{ 
	global $wpdb,$custom_usermeta_db_table_name;
	$custom_usermeta_db_table_name = $wpdb->prefix . "templatic_custom_usermeta";
	$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active=1 and post_type=\"$types\" order by sort_order asc,admin_title asc");
	$return_arr = array();
	if($user_meta_info){
		foreach($user_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->ctype){ 
				//$options = explode(',',$post_meta_info_obj->option_values);
				$options = '';
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"site_title" 	=> $post_meta_info_obj->site_title,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"is_require"  => $post_meta_info_obj->is_require,
					"on_registration"  => $post_meta_info_obj->show_on_listing,
					"on_profile"  => $post_meta_info_obj->show_on_detail,
					"extrafield1"  => $post_meta_info_obj->extrafield1,
					"extrafield2"  => $post_meta_info_obj->extrafield2,
					);
			if($options)
			{
				$custom_fields["options"] = $options;
			}
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
		}
	}
	return $return_arr; 		
}
?>