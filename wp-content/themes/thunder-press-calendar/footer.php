<div id="footer" class="clearfix">
	     
	<div style="width:960px;margin:0px auto;">
	<form method="post" action="https://w1.buysub.com/servlet/PrePopGateway?cds_mag_code=THP&cds_page_id=71627&cds_response_key=THH3DEMB">
	<table width="960" height="300" align="left" style="background: url('/wp-content/uploads/2012/07/02712i-TP-Half-Price_Embedded-Sub-Formorange.jpg') no-repeat;">
	
	        <tr>
	      <td width="618" height="10"></td>
	    </tr>  
	<tr>
	      <td width="618" height="20"></td>
	    </tr>
	    <tr>
	      <td width="618"></td>
	      <td width="112" height="25"><div align="right">
	        <p><font color="black">Email:</font></p>
	      </div></td>
	      <td colspan="3"><div align="left">
	<input type="text" value="" name="cds_email" size="40"/>
	      </div></td>
	         </tr>
	    <tr>
	      <td width="618"></td>
	      <td height="25"><div align="right">
	        <p><font color="black">Name:</font></p>
	      </div></td>
	      <td colspan="3"><div align="left">
	<input type="text" value="" name="cds_name" size="40"/>
	      </div></td>
	    </tr>
	    <tr>
	      <td width="618"></td>
	      <td height="25"><div align="right">
	        <p><font color="black">Address:</font></p>
	      </div></td>
	      <td colspan="3"><div align="left">
	        <input type="text" value="" name="cds_address_1" size="40" />
	      </div></td>
	    </tr>
	    <tr>
	      <td width="618"></td>
	      <td height="25"><div align="right">
	        <p><font color="black">City:</font></p>
	      </div></td>
	      <td colspan=3><div align="left">
	        <input type="text" value="" name="cds_city" size="40"/>
	      </div></td>
	    </tr>
	    <tr>
	      <td width="618"></td>
	      <td height="25"><div align="right">
	        <p><font color="black">State:</font></p>
	      </div></td>
	      <td width="23"><div align="left">
	        <input type="text" name="cds_state" size="3" maxlength="2" /> 
	      </div></td>
	      <td width="80" height="25"><div align="right">
	        <p><font color="black">ZIP:</font></p>
	      </div></td>
	      <td width="214"><div align="left">
	        <input type="text" name="cds_zip" size="10" /> 
	      </div></td>
	    </tr>
	        <tr>
	      <td width="537"></td>
	      <td colspan="4" height="25" align="center"><input type="submit" value="Subscribe Now!" name="send"></input></td>
	         </tr>
	  <tr>
	      <td width="618" height="20"></td>
	    </tr>
	<tr>
	      <td width="618" height="5"></td>
	    </tr> 
	
	</table></form>
	</div>
	<div style="clear:both"></div>


	<br/><br/>
	<p>&copy;<?php echo date('Y'); ?>&nbsp;<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>. <?php echo RIGHTS_TEXT;?><br/><br/>
	Web Development by <a href="http://www.schoolwebworks.com" target="_blank">School Webworks</a></p>
	<br/><br/>
</div> <!-- footer #end -->
        
<script type="text/javascript">
/* <![CDATA[ */
function addToAttendEvent(post_id,action,st_date,end_date)
{
 	<?php 
	global $current_user;
	if($current_user->ID==''){ 
	?>
	window.location.href="<?php echo site_url(); ?>/?page=login&page1=sign_in";
	<?php 
	} else {
	?>
	var fav_url; 
	if(action == 'add')
	{
		if(st_date == 'undefined' || st_date == '')
			fav_url = '<?php echo site_url(); ?>/index.php?ptype=favorite&action=add&pid='+post_id;
		else
			fav_url = '<?php echo site_url(); ?>/index.php?ptype=favorite&action=add&pid='+post_id+'&st_date='+st_date+'&end_date='+end_date;
	}
	else
	{
		if(st_date == 'undefined' || st_date == '')
			fav_url = '<?php echo site_url(); ?>/index.php?ptype=favorite&action=removed&pid='+post_id;
		else
			fav_url = '<?php echo site_url(); ?>/index.php?ptype=favorite&action=remove&pid='+post_id+'&st_date='+st_date+'&end_date='+end_date;
		
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