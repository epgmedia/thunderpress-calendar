<?php
/*
URI: http://wphacks.com/log/how-to-add-spam-and-delete-buttons-to-your-blog/
*/ 

function delete_comment_link($id) {
    if (current_user_can('edit_post')) {
        echo '<a href="'.admin_url("comment.php?action=cdc&amp;c=$id").'">'.__('Delete').'</a> ';
        echo '<a href="'.admin_url("comment.php?action=cdc&amp;dt=spam&amp;c=$id").'">'.__('Spam').'</a>';
    }
}

// Use legacy comments on versions before WP 2.7
add_filter('comments_template', 'old_comments');

function old_comments($file) {

	if(!function_exists('wp_list_comments')) : // WP 2.7-only check
		$file = TEMPLATEPATH . '/comments-old.php';
	endif;

	return $file;
}

// Custom comment loop
function custom_comment($comment, $args, $depth)
{
	global $post,$current_user,$wpdb;
	$GLOBALS['comment'] = $comment;
	$show_gravtar = get_option('show_avatars');
	$comment_user_photo = get_user_meta($comment->user_id,'user_photo');
	$gravtar = get_avatar( $comment, 78, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar.png' );?>
	
<li class="comment wrap threaded" id="comment-<?php comment_ID() ?>">
    <div class="meta-left">
        <div class="meta-wrap">
		<?php if($show_gravtar == '1') : ?>
		<span class="gravatar_bg"></span><?php echo $gravtar;
		else : ?>
		<img src="<?php echo $comment_user_photo[0]; ?>" width="75" height="75" />
		<?php endif; ?>
        </div>
    </div>
    <div class="text-right <?php if (1 == $comment->user_id) $oddcomment = "authcomment"; echo $oddcomment; ?>">
        <p class="authorcomment "> <span class="fl" > <?php 
		$timezone = new DateTimeZone("Asia/Kolkata" );
		$date = new DateTime();
		$date->setTimezone($timezone );
		$tz=  strtotime($date->format( 'H:i:s' ));
		comment_author_link(); ?> 
               <small><?php if(!function_exists('how_long_ago')){comment_date('M d, Y'); } else { echo human_time_diff(get_comment_time('U'),$tz); } ?></small> </span> <br />
                <?php echo get_comment_rating_star($comment->comment_ID);?>
                </p>
             <?php comment_text() ?>  
        <?php if ($comment->comment_approved == '0') : ?>
        <p><em><?php _e('Your comment is awaiting moderation.','templatic'); ?></em></p>
        <?php endif; ?>
    </div>
    <span class="comm-reply">		
    <span class="fr" ><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>  </span> 
    <?php  edit_comment_link(''.__('Edit').'', '', ''); ?>
    <?php delete_comment_link(get_comment_ID()); ?>
    </span>
    <div class="clearfix"></div>
<?php } ?>