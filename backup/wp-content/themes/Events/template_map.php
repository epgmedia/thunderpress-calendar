<?php
/*
Template Name: Template - Map
*/
get_header();
?>
<script type="text/javascript">
function toggle(){
	var div1 = document.getElementById('toggleID');
	if (div1.style.display == 'none') {
		div1.style.display = 'block';
	} else {
		div1.style.display = 'none';
	}
	if(document.getElementById('toggle').getAttribute('class') == 'toggleoff'){
		document.getElementById('toggle').setAttribute('class','toggleon');
	} else {
		document.getElementById('toggle').setAttribute('class','toggleoff');
	}
}
</script>

<div class="graybox plist_map">
<?php
if(file_exists(TEMPLATEPATH . '/library/map/home_map_widget.php'))
{
	include_once (TEMPLATEPATH . '/library/map/home_map_widget.php');
}
?>
</div>

<?php
get_footer();
?>