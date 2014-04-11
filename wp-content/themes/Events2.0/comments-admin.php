<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php echo get_option('ptthemes_password_protected_name'); ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
<div id="comments_wrap">
<?php 
	global $post,$wpdb;
	$post_id = $post->ID;
	$pingback_count = $wpdb->get_var("SELECT COUNT( comment_ID ) AS ccount FROM $wpdb->posts LEFT JOIN $wpdb->comments ON ( comment_post_ID = ID AND comment_approved = '1' AND comment_type='pingback' )							WHERE post_status = 'publish' AND ID IN ($post_id)	GROUP BY ID");
	 if($pingback_count>0) : 
	?>
    	<h3 id="pings"><?php _e('Trackbacks For This Post','templatic'); ?></h3>
            <ol class="ping_commentlist">
 			    <?php wp_list_comments('type=pings'); ?>
            </ol>
    <?php  endif; ?>
<?php if ( have_comments() ) : ?>
 <?php global $is_place_post; if($is_place_post){ $comment_count_text = REVIEW_TEXT;}else{$comment_count_text = COMMENT_TEXT;}
 if($is_place_post){ $comment_count_text2 = REVIEW_TEXT2;}else{$comment_count_text2 = COMMENT_TEXT2;}
 ?>
	<h3>  <?php
	 comments_number('0 '.$comment_count_text, '1 '.$comment_count_text, '% '.$comment_count_text2);
	?>   </h3>
	<ol class="commentlist">
	    <?php wp_list_comments('avatar_size=48&callback=custom_comment'); ?>
	</ol>    
	<div class="navigation">
		<div class="fl"><?php previous_comments_link() ?></div>
		<div class="fr"><?php next_comments_link() ?></div>
		<div class="fix"></div>
	</div>
	<br />
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.','templatic'); ?></p>
	<?php endif; ?>
<?php endif; ?>
</div> <!-- end #comments_wrap -->
<?php if ('open' == $post->comment_status) : ?>
<div id="respond">
    <h3><?php global $post; if($post->post_type==CUSTOM_POST_TYPE1){	echo COMMENTS_TITLE_PLACE;}else{echo COMMENTS_TITLE_BLOG;}	
	?> </h3>
    <div class="cancel-comment-reply">
		<small><?php cancel_comment_reply_link(); ?></small>
	</div>
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
        <p><?php _e('You must be','templatic'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php  _e('logged in','templatic'); ?></a> <?php _e('to post a comment','templatic'); ?>.</p>
    <?php else : ?>	
        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <?php global $post; if($post->post_type==CUSTOM_POST_TYPE1 && get_option('ptthemes_disable_rating')=='' ){?> 
         <p class="commpadd"> <?php echo RATING_MSG;?>  <br /> <span class="comments_rating"> <?php require_once (TEMPLATEPATH . '/library/rating/get_rating.php');?> </span> </p>
		<?php	} ?>
        
         <p class="commpadd clearfix">
         <label for="comment"><small class="comment2">
         <?php global $post; if($post->post_type==CUSTOM_POST_TYPE1){ echo REVIEW_TEXT;}else{echo COMMENT_TEXT;}?>
		 </small></label>
        <textarea name="comment" id="comment" rows="10" cols="10" ></textarea></p>
        <?php if ( $user_ID ) : ?>
                <p><?php  _e('logged in','templatic'); ?> &rarr; <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(); ?>" title="Log out of this account"><?php _e('Logout','templatic'); ?> &raquo;</a></p>
            <?php else : ?>
                <p class="commpadd clearfix">
                <label for="author" ><small class="author"><?php _e('Name','templatic'); ?> <?php  if ($req) _e('*'); ?></small></label>
                <input type="text" name="author" id="author" value="<?php _e('Name','templatic');?>" size="22" onfocus="if (this.value == '<?php _e('Name','templatic');?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Name','templatic');?>';}" class="name" />
				 </p>
                <p class="commpadd clearfix">
                <label for="email"><small class="email2"><?php _e('Mail','templatic'); ?> <?php  if ($req) _e('*'); ?></small></label>
                <input type="text" name="email" id="email" value="<?php _e('Email','templatic');?>" size="22" onfocus="if (this.value == '<?php _e('Email','templatic');?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Email','templatic');?>';}"  class="email" />
				 </p>
				<p class="commpadd clearfix">
                <label for="url"><small class="site"><?php  _e('Website','templatic'); ?></small></label>
                <input type="text" name="url" id="url" value="<?php _e('Website','templatic');?>" size="22" onfocus="if (this.value == '<?php _e('Website','templatic');?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Website','templatic');?>';}"  class="website" />
			    </p>
            <?php endif; ?>
         <div class="aleft" ><input name="submit" type="submit" id="submit"  value="<?php global $post; if($post->post_type==CUSTOM_POST_TYPE1){echo REVIEW_SUBMIT_BTN;}else{_e('Add Comment','templatic');}?>" onclick="return check_comment();" />
		    <?php comment_id_fields(); ?>
            <input type="hidden" name="comment_post_ID" id="comment_post_ID" value="<?php echo $post->ID;?>" />
		</div>
<script type="text/javascript">
function check_comment()
{
	
	if(document.getElementById('comment').value=='')
	{
		alert('<?php _e('Please enter Comments','templatic')?>');
		document.getElementById('comment').focus();
		return false;
	}
	<?php if ($req){?>
	if(document.getElementById('author').value=='' || document.getElementById('author').value=='<?php _e('Name');?>')
	{
		alert('<?php _e('Please enter Name','templatic')?>');
		document.getElementById('author').focus();
		return false;
	}
	if(document.getElementById('email').value=='' || document.getElementById('email').value=='<?php _e('Email');?>')
	{
		alert('<?php _e('Please enter Email','templatic')?>');
		document.getElementById('email').focus();
		return false;
	}else
	{
		var a = document.getElementById('email').value;
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			
		}else{
			alert('<?php _e('Please enter valid Email','templatic')?>');
			document.getElementById('email').focus();
			return false;
		}	
	}
	<?php }?>
	return true;
}
</script>     
		<?php 
		do_action('comment_form', $post->ID); ?>
        </form>
    <?php endif; // If logged in ?>
    <div class="fix"></div>
</div> <!-- end #respond -->
<?php endif; // if you delete this the sky will fall on your head ?>