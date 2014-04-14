<div id="footer" class="clearfix"><p class="fl">&copy;<?php echo date('Y'); ?>&nbsp;<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>. <?php echo RIGHTS_TEXT;?></p>
<p class="copy"><span class="themeby"> <?php echo DESIGNED_TEXT; ?> </span>  <a href="http://templatic.com" title="wordpress themes" alt="wordpress themes"><img src="<?php bloginfo('template_directory'); ?>/images/templatic-wordpress-themes.png" alt="wordpress themes" class="flogo" /></a> </p>
</div> <!-- footer #end -->
        
<script type="text/javascript">
/* <![CDATA[ */
function addToAttendEvent(post_id,action,st_date,end_date)
{
 	<?php 
	global $current_user;
	if($current_user->ID==''){ 
	?>
	window.location.href="<?php echo home_url(); ?>/?page=login&page1=sign_in";
	<?php 
	} else {
	?>
	var fav_url; 
	if(action == 'add')
	{
		if(st_date == 'undefined' || st_date == '')
			fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=add&pid='+post_id;
		else
			fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=add&pid='+post_id+'&st_date='+st_date+'&end_date='+end_date;
	}
	else
	{
		if(st_date == 'undefined' || st_date == '')
			fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=removed&pid='+post_id;
		else
			fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=remove&pid='+post_id+'&st_date='+st_date+'&end_date='+end_date;
		
	}
	var $ac = jQuery.noConflict();
	$ac.ajax({	
		url: fav_url ,
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
		error: function(){
			alert("Error loading user's attending event.");
		},
		success: function(html){	
		<?php 
		if($_REQUEST['list']=='favourite')
		{ ?>
			//document.getElementById('list_property_'+post_id).style.display='none';	
			document.getElementById('post_'+post_id).style.display='none';	
			<?php
		}
		?>
			if(!st_date)
			{
				document.getElementById('attend_event_'+post_id).innerHTML=html;
			}
			else
			{
				document.getElementById('attend_event_'+post_id+'-'+st_date).innerHTML=html;
			}
		}
	});
	return false;
	<?php } ?>
}
/* ]]> */
</script>  
<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE')){?>
<script src="<?php bloginfo('template_directory'); ?>/library/js/jquery.helper.js" type="text/javascript" ></script>
<?php }?>

  <?php wp_footer(); ?><?php if ( get_option('ptthemes_google_analytics') <> "" ) { echo stripslashes(get_option('ptthemes_google_analytics')); } ?>
 </body>
</html>