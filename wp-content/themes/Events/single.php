<?php
if($post->post_type=='event')
{
	require_once (TEMPLATEPATH . '/single-event.php');
}else
{
	require_once (TEMPLATEPATH . '/library/includes/blog_detail.php');
}
?>