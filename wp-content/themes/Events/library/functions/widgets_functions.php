<?php
// Register widgetized areas
if ( function_exists('register_sidebar') )
{

	register_sidebars(1,array('name' => __('Header: Right area','templatic'),'id' => 'social_media_widget','description' => 'The rightmost section alongside the logo. A social media widget','id' => 'header_logo_right_side','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

	register_sidebars(1,array('id' => 'front_content', 'name' => 'Front Page Content', 'description' => 'Widgets placed in this area will be displayed in Front Content.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'front_content_left', 'name' => 'Front Content Left', 'description' => 'Widgets placed in this area will be displayed on the Left side in Front Content.', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'front_content_right', 'name' => 'Front Content Right', 'description' => 'Widgets placed in this area will be displayed on the Right side in Front Content.', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'front_page_sidebar','name' => 'Front Page Sidebar', 'description' => 'Widgets placed in this area will be displayed in the Sidebar of Front Page.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'content_sidebar', 'name' => 'Content Page Sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'event_listing_sidebar', 'name' => 'Event Listing - Sidebar', 'description' => 'Widgets placed in this area will be displayed in the Sidebar of Event Listing page.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'add_event_sidebar', 'name' => 'Add Event - Sidebar', 'description' => 'Widgets placed in this area will be displayed in the Sidebar of Add Event page.', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array( 'id' => 'event_content_banner', 'name' => 'Event Content - Banner', 'description' => 'Widgets placed in this area will be displayed in the Content of an Event.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('id' => 'event_detail_sidebar', 'name' => 'Event Detail - Sidebar', 'description' => 'Widgets placed in this area will be displayed in the Sidebar of Event Detail page.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array('name' => 'Contact Page Widget Area','id'=>'contact-widget', 'description' => 'Widgets placed in this area will be displayed above tha map on the contact us page.', 'before_widget' => '<div class="address_cont">','after_widget' => '</div>','before_title' => '<h1>','after_title' => '</h1>'));
	
	register_sidebars(1,array('name' => 'Contact Page : Google Map','id'=>'contact-google', 'description' => 'Contact page google map widget is to be placed in this area. It will display above the contact form.', 'before_widget' => '','after_widget' => '','before_title' => '<h1>','after_title' => '</h1>'));
  	
	register_sidebars(1,array( 'id' => 'blog_listing_sidebar', 'name' => 'Blog Listing - Sidebar', 'description' => 'Widgets placed in this area will be displayed in the Sidebar of Blog Listing page.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array( 'id' => 'blog_detail_sidebar', 'name' => 'Blog Detail - Sidebar', 'description' => 'Widgets placed in this area will be displayed in the Sidebar of Blog Detail page.', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array( 'id' => 'blog_content_banner', 'name' => 'Blog Content - Banner', 'description' => 'Widgets placed in this area will be displayed in the Content of a Blog.', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	/* register_sidebars(1,array( 'id' => 'main_navigation', 'name' => 'Main Navigation', 'description' => 'Widgets placed in this area will be displayed in the Main Header Navigation.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	
	register_sidebars(1,array( 'id' => 'top_navigation', 'name' => 'Top Navigation', 'description' => 'Widgets placed in this area will be displayed in the Top Header Navigation.','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>')); */
	
}
//END OF WIDGET AREAS

/* =============================== REGISTER WIDGETS ======================================= */
// LOGIN AND DASHBOARD WIDGET STARTS
class loginwidget extends WP_Widget {
	function loginwidget() {
	//Constructor
		$widget_ops = array('classname' => 'Loginbox', 'description' => 'Displays links for Login, Registration and User Dashboard.' );		
		$this->WP_Widget('widget_loginwidget', 'T &rarr; Loginbox', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
            <div class="widget login_widget">
       		
 	       
          <?php
			global $current_user;
			if($current_user->ID)
			{
			?>
			<h3><?php echo MY_ACCOUNT_TEXT;?></h3>
			<ul class="xoxo blogroll">
				<li><a href="<?php echo get_author_posts_url($current_user->ID);?>"><?php echo DASHBOARD_TEXT;?></a></li>
				<li><a href="<?php echo get_option('home');?>/?page=profile"><?php echo EDIT_PROFILE_PAGE_TITLE;?></a></li>
				<li><a href="<?php echo get_option('home');?>/?page=profile#chg_pwd"><?php echo CHANGE_PW_TEXT;?></a></li>
                <li><a href="<?php echo get_option('home');?>/?page=login&amp;action=logout" class="signin"><?php echo LOGOUT_TEXT;?></a></li>
			</ul>
			<?php
			}else
			{
			?>
			<h3><?php echo $title; ?> </h3>
		    <form name="loginform" id="loginform1" action="<?php echo home_url().'/index.php?page=login'; ?>" method="post" >
           		<div class="form_row"><label><?php echo USERNAME_TEXT;?>  <span>*</span></label>  <input name="log" id="user_login1" type="text" class="textfield" /> <span id="user_loginInfo"></span> </div>
                <div class="form_row"><label><?php echo PASSWORD_TEXT;?>  <span>*</span></label>  <input name="pwd" id="user_pass1" type="password" class="textfield" /><span id="user_passInfo"></span>  </div>
                
               	<input type="hidden" name="redirect_to" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>" />
				<input type="hidden" name="testcookie" value="1" />
                <?php if(strtolower(get_option('ptttheme_fb_opt')) == strtolower('Yes')): ?>
				<div class="fbplugin"><?php do_action('oa_social_login'); ?></div>
				<?php endif; ?>
                <input type="submit" name="submit" value="<?php echo SIGN_IN_BUTTON;?>" class="b_signin" /> 
             </form> 
            <p class="forgot_link">   <?php if(get_option('users_can_register')){?> <a href="<?php echo get_option('home'); ?>/?page=register"><?php echo NEW_USER_TEXT;?></a>  <br /> <?php }?><a href="<?php echo get_option('home'); ?>/?page=login&amp;page1=sign_in"><?php echo FORGOT_PW_TEXT;?></a> </p>            
            <?php }?>
            </div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}}
register_widget('loginwidget');
// LOGIN AND DASHBOARD WIDGET ENDS

// FEEDBURNER SUBSCRIBE WIDGET STARTS ======================================================================

class subscribeWidget extends WP_Widget
{
	function subscribeWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Subscribe', 'description' => 'Displays a Newsletter Subscriber.' );		
		$this->WP_Widget('widget_subscribeWidget', 'T &rarr; Subscribe', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
		$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
		$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
		$digg = empty($instance['digg']) ? '' : apply_filters('widget_digg', $instance['digg']);
		$feeurl = empty($instance['feeurl']) ? '' : apply_filters('widget_feeurl', $instance['feeurl']);
		$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
?>
	<div class="subscribe clearfix" >
	<h3><?php echo $title; ?>  <a href="<?php if($feeurl){echo $feeurl;}else{bloginfo('rss_url');} ?>" ><img  src="<?php bloginfo('template_directory'); ?>/images/i_rss.png" alt="" class="i_rss"  /> </a> </h3>
	<?php if ( $text <> "" ) { ?>
	<p><?php echo $text; ?></p>
	<?php } ?>
	<form class="subscribe_form"  action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
		<input type="text" class="field" value="Your Email Address" onfocus="if (this.value == 'Your Email Address') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Your Email Address';}" name="email"/>
		<input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
		<input class="btn_submit" type="submit" name="submit" value="Submit" /> 
	</form>
	</div><!-- #end -->

<?php }
	function update($new_instance, $old_instance)
	{
	//save the widget
		$instance = $old_instance;		
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['title'] = ($new_instance['title']);
		$instance['text'] = ($new_instance['text']);
		$instance['twitter'] = ($new_instance['twitter']);
		$instance['facebook'] = ($new_instance['facebook']);
		$instance['digg'] = ($new_instance['digg']);
		$instance['feeurl'] = ($new_instance['feeurl']);
		return $instance;
	}
	function form($instance)
	{
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '','text' => '','twitter' => '','facebook' => '','digg' => '','myspace' => '' ) );		
		$id = strip_tags($instance['id']);
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
		$twitter = strip_tags($instance['twitter']);
		$facebook = strip_tags($instance['facebook']);
		$digg = strip_tags($instance['digg']);
		$feeurl = strip_tags($instance['feeurl']); ?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('id'); ?>"><?php echo FEED_ID_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr($id); ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('feeurl'); ?>"><?php echo RSS_URL_TEXT; ?> : <input class="widefat" id="<?php echo $this->get_field_id('feeurl'); ?>" name="<?php echo $this->get_field_name('feeurl'); ?>" type="text" value="<?php echo esc_attr($feeurl); ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php echo PRICE_DESC; ?>:<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_attr($text); ?></textarea></label></p>
<?php
	}
}
register_widget('subscribeWidget');
// FEEDBURNER SUBSCRIBE WIDGET ENDS

// SIDEBAR ADVT WIDGET STARTS =============================================================
class advtwidget extends WP_Widget {
	function advtwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advertise', 'description' => 'Display your advertisement.' );		
		$this->WP_Widget('advtwidget', 'T &rarr; Advertise', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
?>
<?php /*?><h3><?php echo $title; ?> </h3><?php */?>
<div class="advt_single">
	<?php if ( $desc1 <> "" ) { ?>
	<?php echo $desc1; ?>
	<?php } ?>
</div>
<?php }
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
        <p><label for="<?php echo $this->get_field_id('desc1'); ?>"><?php echo ADVT_CODE_TEXT;?><textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo esc_attr($desc1); ?></textarea></label></p>
       
<?php
	}
}
register_widget('advtwidget');
// SIDEBAR ADVT WIDGET ENDS

// EVENT SEARCH WIDGET STARTS ===============================================================================
class eventsearch extends WP_Widget {
	function eventsearch() {
	//Constructor
		$widget_ops = array('classname' => 'widget Event search', 'description' => 'Displays a search form where you can get better options to search an event.' );		
		$this->WP_Widget('eventsearch', 'T &rarr; Events search', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
 	<script  type="text/javascript" language="javascript">var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
    <script type="text/javascript">
    function set_search()
	{
		var sr = '';
		
		if(document.getElementById('skw').value=='<?php _e("Search for","templatic");?>')
		{
			document.getElementById('skw').value = '';
		}else
		{
			sr = sr + document.getElementById('skw').value+'-';
		}
		if(document.getElementById('scat').value)
		{
			sr = sr + document.getElementById('scat').options[document.getElementById('scat').selectedIndex].text; + '-';
		}
		if(document.getElementById('sdate').value)
		{
			sr = sr + document.getElementById('sdate').value+ '-';
		}
		if(document.getElementById('saddress').value)
		{
			sr = sr + document.getElementById('saddress').value+ '-';
		}
		if(sr)
		{
			document.getElementById('sr').value = sr;
		}else
		{
			document.getElementById('sr').value = ' ';
		}
	}
    </script>
     <form action="<?php echo home_url();?>/" id="srchevent" name="srchevent" method="get"> 
     <input type="hidden" name="s" value="" id="sr" />
     <input type="hidden" name="t" value="event" />
      <div class="widget event_search">
  		 <h3><?php echo $title; ?> </h3> 
          
          <div class="row">
          <?php if(@$_REQUEST['skw'])
		  {
			$skw = $_REQUEST['skw'];  
		  }?>
          	<input type="text" onblur="if (this.value == '') {this.value = '<?php _e('Search for','templatic');?>';}" onfocus="if (this.value == '<?php _e('Search for','templatic');?>') {this.value = '';}" class="textfield xl" id="skw" name="skw" value="<?php echo @$skw;?>" />
          <span><?php echo SEARCH_EVENT_TEXT;?></span>
          </div>
		  <div class="row">
          <?php echo get_category_dl_options(@$_REQUEST['scat']);?>
          	<span><?php echo SELECT_CATEGORY_TEXT;?></span>
          </div>
		  <div class="row">
		  <input type="text" name="sdate" id="sdate" value="<?php echo @$_REQUEST['sdate'];?>" class="textfield tsmall"  size="25"  />
		  &nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.srchevent.sdate,'yyyy-mm-dd',this)"  class="calendar_link"  />
		  <span><?php echo EVENT_START_TEXT;?></span>
		  </div>
		  <div class="row">
		  <input name="saddress" id="saddress" type="text" value="<?php echo @$_REQUEST['saddress'];?>" class="textfield xl"  />
		  <span><?php echo ZIP_OR_ADD_TEXT;?></span>
          </div>
		  <div class="row">
		  <?php 
			$custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,'0','user_side','1');
			search_custom_post_field($custom_metaboxes); ?>
		  </div>
		  <input name="search" type="submit" value="<?php echo SEARCH_EVENTS_TEXT;?>" class="b_search_event" onclick="set_search();" />
		  <div class="clearfix"></div>
	</div>
	</form>
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
}
register_widget('eventsearch');
// EVENT SEARCH WIDGET ENDS

// CATEGORIES WIDGET STARTS ===============================================================================
class catewidget extends WP_Widget {
	function catewidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget categories', 'description' => 'Displays a list of Event Categories.' );		
		$this->WP_Widget('catewidget', 'T &rarr; Browse by Categories', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$catid = empty($instance['catid']) ? '' : apply_filters('widget_catid', $instance['catid']); ?>
	
	<h3><?php echo $title; ?></h3>
	<ul class="categories">
	<?php
		$variable = wp_list_categories('echo=0&show_count=0&taxonomy=eventcategory&title_li=&exclude='.$catid);
		$variable = str_replace(array('(',')'), array('<span class="count">','</span>'), $variable);
		echo $variable;
	?>
	</ul>
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['catid'] = ($new_instance['catid']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'catid' => '' ) );		
		$title = strip_tags($instance['title']);
		$catid = ($instance['catid']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
     
         <p><label for="<?php echo $this->get_field_id('catid'); ?>"><?php echo CAT_IDS_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('catid'); ?>" name="<?php echo $this->get_field_name('catid'); ?>" type="text" value="<?php echo esc_attr($catid); ?>" /></label></p>  
	
<?php
	}
}
register_widget('catewidget');
// CATEGORIES WIDGET ENDS

// LATEST EVENTS WIDGET STARTS ==========================================================================
class news2columns extends WP_Widget {
	function news2columns() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest News', 'description' => 'Displays Latest Events in List View.' );
		$this->WP_Widget('news2columns', 'T &rarr; Latest Events List View', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		$sorting = empty($instance['event_sorting']) ? 'Latest Published' : apply_filters('widget_event_sorting', $instance['event_sorting']);
		?>
	<div class="tabber">
		<ul class="tab">
		<li class="active" id="li_upcomming_events"> <a href="javascript:void(0);" onclick="show_hide_tabs('upcoming');"><?php echo UPCOMING_TEXT; ?></a></li>
		<li  id="li_current_events"> <a href="javascript:void(0);" onclick="show_hide_tabs('current');"><?php echo CURRENT_TEXT;?></a></li>
		<li id="li_index_past_events"> <a href="javascript:void(0);" onclick="show_hide_tabs('past');"><?php echo PAST_TEXT; ?></a></li>
		</ul>
	</div>
	<script type="text/javascript">
		function show_hide_tabs(type)
		{
			if( type == 'upcoming')
			{
				document.getElementById('widget_index_upcomming_events_id').style.display='';
				document.getElementById('upcomming_event_type').style.display='';
				document.getElementById('widget_index_current_events_id').style.display='none';
				document.getElementById('current_event_type').style.display='none';
				document.getElementById('widget_index_past_events_id').style.display='none';
				document.getElementById('past_event_type').style.display='none';
				document.getElementById('li_upcomming_events').className='active';
				document.getElementById('li_current_events').className='';
				document.getElementById('li_index_past_events').className='';
			}
			else if( type == 'current')
			{
				document.getElementById('widget_index_upcomming_events_id').style.display='none';
				document.getElementById('upcomming_event_type').style.display='none';
				document.getElementById('widget_index_current_events_id').style.display='';
				document.getElementById('current_event_type').style.display='';
				document.getElementById('widget_index_past_events_id').style.display='none';
				document.getElementById('past_event_type').style.display='none';
				document.getElementById('li_current_events').className='active';
				document.getElementById('li_upcomming_events').className='';
				document.getElementById('li_index_past_events').className='';
			}
			else if( type == 'past')
			{
				document.getElementById('widget_index_upcomming_events_id').style.display='none';
				document.getElementById('upcomming_event_type').style.display='none';
				document.getElementById('widget_index_current_events_id').style.display='none';
				document.getElementById('current_event_type').style.display='none';
				document.getElementById('widget_index_past_events_id').style.display='';
				document.getElementById('past_event_type').style.display='';
				document.getElementById('li_upcomming_events').className='';
				document.getElementById('li_current_events').className='';
				document.getElementById('li_index_past_events').className='active';
			}
		}
		function show_hide_tabs_event_type(day,id)
		{
			<!--upcomming Event tab -->
			if(day=='widget_index_upcomming_events_id')
			{
				
				if(id=='widget_index_upcomming_regular_events_id')
				{					
					document.getElementById('widget_index_upcomming_recurring_events_id').style.display='none';
					document.getElementById('widget_index_upcomming_regular_events_id').style.display='';
					jQuery("#upcomming_regular").addClass("active");
					jQuery("#upcomming_recurring").removeClass("active");
				}else
				{
					document.getElementById('widget_index_upcomming_regular_events_id').style.display='none';
					document.getElementById('widget_index_upcomming_recurring_events_id').style.display='';
					jQuery("#upcomming_recurring").addClass("active");
					jQuery("#upcomming_regular").removeClass("active");
				}
			}
			<!--Current Event tab -->
			if(day=='widget_index_current_events_id')
			{
				
				if(id=='widget_index_current_regular_events_id')
				{					
					document.getElementById('widget_index_current_recurring_events_id').style.display='none';
					document.getElementById('widget_index_current_regular_events_id').style.display='';
					jQuery("#current_regular").addClass("active");
					jQuery("#current_recurring").removeClass("active");
					
				}else
				{
					jQuery("#current_recurring").addClass("active");
					jQuery("#current_regular").removeClass("active");
					document.getElementById('widget_index_current_regular_events_id').style.display='none';
					document.getElementById('widget_index_current_recurring_events_id').style.display='';
					
				}
			}
			<!--Past Event tab -->
			if(day=='widget_index_past_events_id')
			{
				
				if(id=='widget_index_past_regular_events_id')
				{					
					document.getElementById('widget_index_past_recurring_events_id').style.display='none';
					document.getElementById('widget_index_past_regular_events_id').style.display='';
					jQuery("#past_regular").addClass("active");
					jQuery("#past_recurring").removeClass("active");
				}else
				{
					document.getElementById('widget_index_past_regular_events_id').style.display='none';
					document.getElementById('widget_index_past_recurring_events_id').style.display='';
					jQuery("#past_recurring").addClass("active");
					jQuery("#past_regular").removeClass("active");
				}
			}
			
		}
		
	</script>
	<?php //$type = get_option('event_sorting');
	if ( $sorting != '' )
	{
		global $wpdb;
		if ( $sorting == 'Random' )
		{
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = p.ID and $wpdb->postmeta.meta_key like \"st_date\") ASC, rand()";
		}
		elseif ( $sorting == 'Alphabetical' )
		{
			$orderby = "p.post_title ASC";
		}elseif($sorting =='s_date'){
			 $today = date('Y-m-d');
			 $orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = p.ID and $wpdb->postmeta.meta_key like \"st_date\") ASC";
		}
		else
		{
			$today = date('Y-m-d');
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = p.ID and $wpdb->postmeta.meta_key like \"st_date\") ASC";
		}
	}
	?>
     <ul id='upcomming_event_type'>
     	<li><a class="active" href="javascript:void(0);" id="upcomming_regular" onclick="show_hide_tabs_event_type('widget_index_upcomming_events_id','widget_index_upcomming_regular_events_id');"><?php _e('Regular Events','templatic');?></a></li>
          <li><a class="" href="javascript:void(0);" id="upcomming_recurring" onclick="show_hide_tabs_event_type('widget_index_upcomming_events_id','widget_index_upcomming_recurring_events_id');"><?php _e('Recurring Events','templatic');?></a></li>
     </ul>
	<ul class="category_list_view" id="widget_index_upcomming_events_id">
	<?php
		global $post,$wpdb;
		$category1 = $category;
		$today = date('Y-m-d G:i:s');
		if($category)
		{
			$category = "'".str_replace(",","','",$category)."'";
			$where .= "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category))";
		}
		$today = date('Y-m-d G:i:s');
		@$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') >'".$today."')) AND (p.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') )";
		$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $where order by $orderby limit $post_number";
		$latest_menus = $wpdb->get_results($sql);
		echo '<li class="" id="widget_index_upcomming_regular_events_id">  <ul>';
		if($latest_menus)
		{			
		foreach($latest_menus as $post) :
		setup_postdata($post);
		$post_img = bdw_get_images_with_info($post->ID,'thumb');
		$thumb = $post_img[0]['file']; ?>		
          <li class="clearfix">
		<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
		<?php if ( $thumb != '' ) { ?>
		<a class="post_img" href="<?php the_permalink(); ?>">
		<img src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
		<?php
		} else { ?>
		<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
		<?php } ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php
		if(get_post_meta($post->ID,'address',true))
		{
			$from_add = get_post_meta($post->ID,'address',true);
		}
		if($from_add)
		{ ?>
		<p class="timing"> <span><?php echo START_DATE_TEXT;?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br /><span><?php echo END_DATE_TEXT;?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?><br />
		<span><?php echo TIME_TEXT;?>: </span>
		<?php if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
		}
		else if(get_post_meta($post->ID,'st_time',true) )
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true));
		}
		else
		{
			echo ' - ';	
		} ?><br /></p>
		<p class="address"><span><?php echo LOCATION_TEXT;?> :</span> <br /><?php echo get_post_meta($post->ID,'address',true);?></p>
		<?php }?>
		<p class="bottom">
		<span class="flm"><?php echo LISTED_IN_TEXT." "; ?> </span>
		<?php  $taxonomy_category = get_the_taxonomies();
			$taxonomy_category = @$taxonomy_category[CUSTOM_CATEGORY_TYPE1];
			$taxonomy_category = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_category);
			$taxonomy_category = str_replace(', and',',',$taxonomy_category);
			$taxonomy_category = str_replace(' and ',', ',$taxonomy_category);
			//$taxonomy_category = str_replace('.','',$taxonomy_category); ?>
		<span class="post-category"><?php echo $taxonomy_category; ?> </span>
		<?php  $taxonomy_tags = get_the_taxonomies();
			@$taxonomy_tags = $taxonomy_tags[CUSTOM_TAG_TYPE1];
			$taxonomy_tags = str_replace(CUSTOM_MENU_CAT_TITLE.':','in ',$taxonomy_tags);
			$taxonomy_tags = str_replace(', and',',',$taxonomy_tags);
			$taxonomy_tags = str_replace(' and ',', ',$taxonomy_tags);
			//$taxonomy_tags = str_replace('.','',$taxonomy_tags); ?>
		<span class="post-category">&nbsp; <?php echo $taxonomy_tags; ?></span>
		<a href="<?php the_permalink(); ?>" class="read_more" ><?php _e('Read More','templatic');?></a></p>
		</li>
		<?php endforeach; ?>
		<?php }
		else
		{
			echo "<li><p>".UPCOMING_NOT_FOUND_TEXT."</p></li>";
		} 		
		?>
          </ul>
          </li>
          <!-- Upcomming Recurring evenet list-->
          <li id="widget_index_upcomming_recurring_events_id" style="display:none;">
	          <ul>
          	<?php
				$today = date('Y-m-d G:i:s');
				$where='';
				if($category)
				{
					$category = "'".str_replace(",","','",$category)."'";
					$where .= "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category))";
				}
				$today = date('Y-m-d G:i:s');
				$recurring_date=date('Y-m-d');
				@$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') >'".$today."')) AND (p.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta inner join $wpdb->postmeta p1 on $wpdb->postmeta.post_id=p1.post_id where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value LIKE '%Recurring event%' AND p1.meta_key='recurring_search_date' AND p1.meta_value NOT LIKE '%$recurring_date%') ) ";
				$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $where order by $orderby limit $post_number";				
				$latest_menus_recurring = $wpdb->get_results($sql);
				$latest_menus=$latest_menus_recurring;
				if($latest_menus)
				{
			?>
          	
               	<?php
		foreach($latest_menus as $post) :
		setup_postdata($post);
		$post_img = bdw_get_images_with_info($post->ID,'thumb');
		$thumb = $post_img[0]['file']; ?>		
          <li class="clearfix">
		<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
		<?php if ( $thumb != '' ) { ?>
		<a class="post_img" href="<?php the_permalink(); ?>">
		<img src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
		<?php
		} else { ?>
		<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
		<?php } ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php
		if(get_post_meta($post->ID,'address',true))
		{
			$from_add = get_post_meta($post->ID,'address',true);
		}
		if($from_add)
		{ ?>
		<p class="timing"> <span><?php echo START_DATE_TEXT;?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br /><span><?php echo END_DATE_TEXT;?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?><br />
		<span><?php echo TIME_TEXT;?>: </span>
		<?php if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
		}
		else if(get_post_meta($post->ID,'st_time',true) )
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true));
		}
		else
		{
			echo ' - ';	
		} ?><br /></p>
		<p class="address"><span><?php echo LOCATION_TEXT;?> :</span> <br /><?php echo get_post_meta($post->ID,'address',true);?></p>
		<?php }?>
		<p class="bottom">
		<span class="flm"><?php echo LISTED_IN_TEXT." "; ?> </span>
		<?php  $taxonomy_category = get_the_taxonomies();
			$taxonomy_category = @$taxonomy_category[CUSTOM_CATEGORY_TYPE1];
			$taxonomy_category = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_category);
			$taxonomy_category = str_replace(', and',',',$taxonomy_category);
			$taxonomy_category = str_replace(' and ',', ',$taxonomy_category);
			//$taxonomy_category = str_replace('.','',$taxonomy_category); ?>
		<span class="post-category"><?php echo $taxonomy_category; ?> </span>
		<?php  $taxonomy_tags = get_the_taxonomies();
			@$taxonomy_tags = $taxonomy_tags[CUSTOM_TAG_TYPE1];
			$taxonomy_tags = str_replace(CUSTOM_MENU_CAT_TITLE.':','in ',$taxonomy_tags);
			$taxonomy_tags = str_replace(', and',',',$taxonomy_tags);
			$taxonomy_tags = str_replace(' and ',', ',$taxonomy_tags);
			//$taxonomy_tags = str_replace('.','',$taxonomy_tags); ?>
		<span class="post-category">&nbsp; <?php echo $taxonomy_tags; ?></span>
		<a href="<?php the_permalink(); ?>" class="read_more" ><?php _e('Read More','templatic');?></a></p>
		</li>
		<?php endforeach; 
				}else{
				echo "<li><p>".UPCOMING_RECURRING_NOT_FOUND_TEXT."</p></li>";
			}//finish upcoming recurring event?>
          </ul>
          </li>
		</ul>
          
          <!--Current Event theme -->
          <ul id='current_event_type' style="display:none;">
               <li><a href="javascript:void(0);" id="current_regular" class="active" onclick="show_hide_tabs_event_type('widget_index_current_events_id','widget_index_current_regular_events_id');"><?php _e('Regular Events','templatic');?></a></li>
               <li><a href="javascript:void(0);" id="current_recurring" class="" onclick="show_hide_tabs_event_type('widget_index_current_events_id','widget_index_current_recurring_events_id');"><?php _e('Recurring Events','templatic');?></a></li>
     	</ul>
		<ul class="category_list_view" id="widget_index_current_events_id" style="display:none;">
	<?php
		global $post,$wpdb;
		$today = date('Y-m-d');
		if($category1)
				{
					$category1 = "'".str_replace(",","','",$category1)."'";
					$where1 .= "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category1))";
				}
		
		$today = date('Y-m-d');
		$where1 .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') <='".$today."')) AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') >= '".$today."')) AND (p.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') )";
		$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $where1 order by $orderby limit $post_number";
		
		$latest_menus = $wpdb->get_results($sql);
		echo "<li id='widget_index_current_regular_events_id'>";
		echo "<ul>";
		if($latest_menus)
		{
		foreach($latest_menus as $post) :
		setup_postdata($post);
		$post_img = bdw_get_images_with_info($post->ID,'thumb');
		$thumb = $post_img[0]['file']; ?>
		<li class="clearfix">
		<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
		<?php if ( $thumb != '' ) { ?>
		<a class="post_img" href="<?php the_permalink(); ?>">
		<img src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
		<?php
		} else { ?>
		<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
		<?php } ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php
		if(get_post_meta($post->ID,'address',true))
		{
			$from_add = get_post_meta($post->ID,'address',true);
		}
		if($from_add)
		{ ?>
		<p class="timing"> <span><?php echo START_DATE_TEXT;?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br />  <span><?php echo END_DATE_TEXT;?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br />
		<span><?php echo TIME_TEXT;?>: </span>
		<?php if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
		}
		else if(get_post_meta($post->ID,'st_time',true) )
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true));
		}
		else
		{
			echo ' - ';	
		} ?></p>
		<p class="address"><span><?php echo LOCATION_TEXT;?> :</span> <br /><?php echo get_post_meta($post->ID,'address',true);?></p>
		<?php }?>
		<p class="bottom">
		<span class="flm"><?php echo LISTED_IN_TEXT." "; ?> </span>
		<?php  $taxonomy_category = get_the_taxonomies();
			$taxonomy_category = $taxonomy_category[CUSTOM_CATEGORY_TYPE1];
			$taxonomy_category = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_category);
			$taxonomy_category = str_replace(', and',',',$taxonomy_category);
			$taxonomy_category = str_replace(' and ',', ',$taxonomy_category);
			//$taxonomy_category = str_replace('.','',$taxonomy_category); ?>
		<span class="post-category"><?php echo $taxonomy_category; ?> </span>
		<?php  $taxonomy_tags = get_the_taxonomies();
			@$taxonomy_tags = $taxonomy_tags[CUSTOM_TAG_TYPE1];
			$taxonomy_tags = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_tags);
			$taxonomy_tags = str_replace(', and',',',$taxonomy_tags);
			$taxonomy_tags = str_replace(' and ',', ',$taxonomy_tags);
			//$taxonomy_tags = str_replace('.','',$taxonomy_tags); ?>
		<span class="post-category">&nbsp; <?php echo $taxonomy_tags; ?></span>
		<a href="<?php the_permalink(); ?>" class="read_more" ><?php _e('Read More','templatic');?></a></p>
		</li>
		<?php endforeach; ?>
		<?php }
		else
		{
			echo "<li><p>".CURRENT_NOT_FOUND_TEXT."</p></li>";
		} ?>
          </ul>
          </li>
          	<!--Current Recurring Event List -->
               <li id="widget_index_current_recurring_events_id" style="display:none">          	
                    <?php
                    global $post,$wpdb;
                    $today = date('Y-m-d');
				$where1='';
                    if($category1)
                    {
                         $category1 = "'".str_replace(",","','",$category1)."'";
                         $where1 .= "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";
                    }
                    $today = date('Y-m-d');
                    $where1 .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') <='".$today."')) AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d') >= '".$today."')) AND (p.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta inner join $wpdb->postmeta p1 on $wpdb->postmeta.post_id=p1.post_id where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value LIKE '%Recurring event%' AND p1.meta_key='recurring_search_date' AND p1.meta_value LIKE '%$recurring_date%') )";
                    $sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $where1 order by $orderby limit $post_number";   				
                    $current_recurring_menus = $wpdb->get_results($sql);
				$latest_menus=$current_recurring_menus;
                    echo '<ul>';
                    if($latest_menus)
				{
				foreach($latest_menus as $post) :
				setup_postdata($post);
				$post_img = bdw_get_images_with_info($post->ID,'thumb');
				$thumb = $post_img[0]['file']; ?>
				<li class="clearfix">
				<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
				<?php if ( $thumb != '' ) { ?>
				<a class="post_img" href="<?php the_permalink(); ?>">
				<img src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
				<?php
				} else { ?>
				<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
				<?php } ?>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php
				if(get_post_meta($post->ID,'address',true))
				{
					$from_add = get_post_meta($post->ID,'address',true);
				}
				if($from_add)
				{ ?>
				<p class="timing"> <span><?php echo START_DATE_TEXT;?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br />  <span><?php echo END_DATE_TEXT;?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br />
				<span><?php echo TIME_TEXT;?>: </span>
				<?php if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
				{
					echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
				}
				else if(get_post_meta($post->ID,'st_time',true) )
				{
					echo get_formated_time(get_post_meta($post->ID,'st_time',true));
				}
				else
				{
					echo ' - ';	
				} ?></p>
				<p class="address"><span><?php echo LOCATION_TEXT;?> :</span> <br /><?php echo get_post_meta($post->ID,'address',true);?></p>
				<?php }?>
				<p class="bottom">
				<span class="flm"><?php echo LISTED_IN_TEXT." "; ?> </span>
				<?php  $taxonomy_category = get_the_taxonomies();
					$taxonomy_category = $taxonomy_category[CUSTOM_CATEGORY_TYPE1];
					$taxonomy_category = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_category);
					$taxonomy_category = str_replace(', and',',',$taxonomy_category);
					$taxonomy_category = str_replace(' and ',', ',$taxonomy_category);
					//$taxonomy_category = str_replace('.','',$taxonomy_category); ?>
				<span class="post-category"><?php echo $taxonomy_category; ?> </span>
				<?php  $taxonomy_tags = get_the_taxonomies();
					@$taxonomy_tags = $taxonomy_tags[CUSTOM_TAG_TYPE1];
					$taxonomy_tags = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_tags);
					$taxonomy_tags = str_replace(', and',',',$taxonomy_tags);
					$taxonomy_tags = str_replace(' and ',', ',$taxonomy_tags);
					//$taxonomy_tags = str_replace('.','',$taxonomy_tags); ?>
				<span class="post-category">&nbsp; <?php echo $taxonomy_tags; ?></span>
				<a href="<?php the_permalink(); ?>" class="read_more" ><?php _e('Read More','templatic');?></a></p>
				</li>
				<?php endforeach; ?>
				<?php }
				else
				{
					echo "<li><p>".CURRENT_RECURRING_NOT_FOUND_TEXT."</p></li>";
				} ?>
                    </ul>
               </li>
          
		</ul>
          
          
          <!--Past Event Type -->
           <ul id='past_event_type' style="display:none;">
               <li><a href="javascript:void(0);" id="past_regular" class="active" onclick="show_hide_tabs_event_type('widget_index_past_events_id','widget_index_past_regular_events_id');"><?php _e('Regular Events','templatic');?></a></li>
               <li><a href="javascript:void(0);" id="past_recurring" class="" onclick="show_hide_tabs_event_type('widget_index_past_events_id','widget_index_past_recurring_events_id');"><?php _e('Recurring Events','templatic');?></a></li>
     	</ul>          
		<ul class="category_list_view" id="widget_index_past_events_id" style="display:none;">
            <?php
			 global $post,$wpdb;
			 $today = date('Y-m-d');
			 if($category)
					{
						$category = str_replace("","','",$category);
						$sqlsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category))";
					}
					$today = date('Y-m-d');
					$sqlsql .= " AND p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d')<'".$today."')  AND (p.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value ='Regular event') ) ";
				    $sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $sqlsql order by $orderby limit $post_number";
					$latest_menus = $wpdb->get_results($sql);
			echo '<li id="widget_index_past_regular_events_id">';
				echo "<ul>";
			if($latest_menus)
			{
			?>
			<?php
			foreach($latest_menus as $post) :
			setup_postdata($post); 
			$post_img = bdw_get_images_with_info($post->ID,'thumb');
		$thumb = $post_img[0]['file']; ?>
		<li class="clearfix">
		<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
		<?php if ( $thumb != '' ) { ?>
		<a class="post_img" href="<?php the_permalink(); ?>">
		<img src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
		<?php
		} else { ?>
		<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>"  width="125" height="75" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
		<?php } ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php
		if(get_post_meta($post->ID,'address',true))
		{
			$from_add = get_post_meta($post->ID,'address',true);
		}
		if($from_add)
		{ ?>
		<p class="timing"> <span><?php echo START_DATE_TEXT;?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br />  <span><?php echo END_DATE_TEXT;?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br />
		<span><?php echo TIME_TEXT;?>: </span>
		<?php if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
		}
		else if(get_post_meta($post->ID,'st_time',true) )
		{
			echo get_formated_time(get_post_meta($post->ID,'st_time',true));
		}
		else
		{
			echo ' - ';	
		} ?></p>
		<p class="address"><span><?php echo LOCATION_TEXT;?> :</span> <br /><?php echo get_post_meta($post->ID,'address',true);?></p>
		<?php }?>
		<p class="bottom">
		<span class="flm"><?php echo LISTED_IN_TEXT." "; ?> </span>
		<?php  $taxonomy_category = get_the_taxonomies();
			$taxonomy_category = $taxonomy_category[CUSTOM_CATEGORY_TYPE1];
			$taxonomy_category = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_category);
			$taxonomy_category = str_replace(', and',',',$taxonomy_category);
			$taxonomy_category = str_replace(' and ',', ',$taxonomy_category);
			//$taxonomy_category = str_replace('.','',$taxonomy_category); ?>
		<span class="post-category"><?php echo $taxonomy_category; ?> </span>
		<?php  $taxonomy_tags = get_the_taxonomies();
			@$taxonomy_tags = $taxonomy_tags[CUSTOM_TAG_TYPE1];
			$taxonomy_tags = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_tags);
			$taxonomy_tags = str_replace(', and',',',$taxonomy_tags);
			$taxonomy_tags = str_replace(' and ',', ',$taxonomy_tags);
			//$taxonomy_tags = str_replace('.','',$taxonomy_tags); ?>
		<span class="post-category">&nbsp; <?php echo $taxonomy_tags; ?></span>
		<a href="<?php the_permalink(); ?>" class="read_more" ><?php _e('Read More','templatic');?></a></p>
		</li> 
			<?php endforeach; ?>
			
            <?php }else{
                echo '<li><p>'.PAST_NOT_FOUND_TEXT.'</p></li>';
            }
            ?>
           </ul>
           </li>
           <!--Past Recurring Event -->
           <li id="widget_index_past_recurring_events_id" style="display:none;">
           	<?php
			 global $post,$wpdb;
			 $today = date('Y-m-d');
			 $sqlsql='';
			 if($category)
			 {
				$category = str_replace("","','",$category);
				$sqlsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category))";
			 }
			 $today = date('Y-m-d G:i:s');
			 $sqlsql .= " AND p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d')<'".$today."') AND (p.ID in ( select $wpdb->postmeta.post_id from $wpdb->postmeta inner join $wpdb->postmeta p1 on $wpdb->postmeta.post_id=p1.post_id where $wpdb->postmeta.meta_key='event_type' and $wpdb->postmeta.meta_value LIKE '%Recurring event%' AND p1.meta_key='recurring_search_date' AND p1.meta_value NOT LIKE '%$recurring_date%') )";
			 $orderbysql = " (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and $wpdb->postmeta.post_id=p.ID and $wpdb->postmeta.meta_key='featured_h' ) desc, ";
		      $sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $sqlsql order by $orderby limit $post_number";
			 $past_recurring_menus = $wpdb->get_results($sql);
			 $latest_menus=$past_recurring_menus;
			 echo "<ul>";
			 if($latest_menus)
			 {			
				foreach($latest_menus as $post) :
					setup_postdata($post); 
					$post_img = bdw_get_images_with_info($post->ID,'thumb');
				$thumb = $post_img[0]['file']; ?>
				<li class="clearfix">
				<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
				<?php if ( $thumb != '' ) { ?>
				<a class="post_img" href="<?php the_permalink(); ?>">
				<img src="<?php echo $thumb; ?>" width="125" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
				<?php
				} else { ?>
				<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>"  width="125" height="75" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
				<?php } ?>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php
				if(get_post_meta($post->ID,'address',true))
				{
					$from_add = get_post_meta($post->ID,'address',true);
				}
				if($from_add)
				{ ?>
				<p class="timing"> <span><?php echo START_DATE_TEXT;?>: </span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?><br />  <span><?php echo END_DATE_TEXT;?>: </span><?php echo get_formated_date(get_post_meta($post->ID,'end_date',true));?> <br />
				<span><?php echo TIME_TEXT;?>: </span>
				<?php if(get_post_meta($post->ID,'st_time',true) && get_post_meta($post->ID,'end_time',true))
				{
					echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> <?php _e('to','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'end_time',true));
				}
				else if(get_post_meta($post->ID,'st_time',true) )
				{
					echo get_formated_time(get_post_meta($post->ID,'st_time',true));
				}
				else
				{
					echo ' - ';	
				} ?></p>
				<p class="address"><span><?php echo LOCATION_TEXT;?> :</span> <br /><?php echo get_post_meta($post->ID,'address',true);?></p>
				<?php }?>
				<p class="bottom">
				<span class="flm"><?php echo LISTED_IN_TEXT." "; ?> </span>
				<?php  $taxonomy_category = get_the_taxonomies();
					$taxonomy_category = $taxonomy_category[CUSTOM_CATEGORY_TYPE1];
					$taxonomy_category = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_category);
					$taxonomy_category = str_replace(', and',',',$taxonomy_category);
					$taxonomy_category = str_replace(' and ',', ',$taxonomy_category);
					//$taxonomy_category = str_replace('.','',$taxonomy_category); ?>
				<span class="post-category"><?php echo $taxonomy_category; ?> </span>
				<?php  $taxonomy_tags = get_the_taxonomies();
					@$taxonomy_tags = $taxonomy_tags[CUSTOM_TAG_TYPE1];
					$taxonomy_tags = str_replace(CUSTOM_MENU_CAT_TITLE.':',' ',$taxonomy_tags);
					$taxonomy_tags = str_replace(', and',',',$taxonomy_tags);
					$taxonomy_tags = str_replace(' and ',', ',$taxonomy_tags);
					//$taxonomy_tags = str_replace('.','',$taxonomy_tags); ?>
				<span class="post-category">&nbsp; <?php echo $taxonomy_tags; ?></span>
				<a href="<?php the_permalink(); ?>" class="read_more" ><?php _e('Read More','templatic');?></a></p>
				</li> 
				<?php endforeach; ?>
                    
                 <?php }else{
                     echo '<li><p>'.PAST_RECURRING_NOT_FOUND_TEXT.'</p></li>';
                 }
                 ?>
			</ul>
           </li>
       </ul>     
			<?php
		    echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		$instance['event_sorting'] = strip_tags($new_instance['event_sorting']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '','event_sorting' => 'Latest Published' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$character_cout = strip_tags($instance['character_cout']);
		$sorting = strip_tags($instance['event_sorting']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_IDS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
  <p><?php echo fetch_categories_ids('eventcategory'); ?></p>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_POSTS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('event_sorting'); ?>"><?php echo SORT_EVENT; ?>:
  <select name="<?php echo $this->get_field_name('event_sorting'); ?>" id="<?php echo $this->get_field_id('event_sorting'); ?>">
	<option selected="selected" value="Latest Published"><?php _e('Latest Published','templatic'); ?></option>
	<option <?php if ($sorting == 'Random') { echo 'selected=selected'; } ?> value="Random"><?php _e('Random','templatic'); ?></option>
	<option <?php if ($sorting == 'Alphabetical') { echo 'selected=selected'; } ?> value="Alphabetical"><?php _e('Alphabetical','templatic'); ?></option>
	<option <?php if ($sorting == 's_date') { echo 'selected=selected'; } ?> value="s_date"><?php _e('As Per Start Date','templatic'); ?></option>
  </select>
  </label>
</p>

<?php
	}
}
register_widget('news2columns');
// LATEST EVENTS WIDGET ENDS

// FEATURED POSTS SLIDER WIDGET STARTS ================================================================================
class featuredslider extends WP_Widget {
	function featuredslider() {
	//Constructor
		$widget_ops = array('classname' => 'widget featured post slider', 'description' => 'Displays Latest Events in a slider.' );
		$this->WP_Widget('featuredslider', 'T &rarr; Featured Slider', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		
	global $post,$wpdb;
	$today = date('Y-m-d G:i:s');
	if($category)
	{
		$category = "'".str_replace(",","','",$category)."'";
		$where .= "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";
	}
	@$where .= " AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='st_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %G:%i:%s') > '".$today."') OR ($wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %G:%i:%s') > '".$today."')  ) AND (p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key = 'featured_h' and $wpdb->postmeta.meta_value = 'h'))";
	$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id =p.ID and $wpdb->postmeta.meta_key = 'featured_h') ASC, p.post_date ASC";
	$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.id in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.post_id=p.ID and p.post_status = 'publish' $where) order by  $orderby limit $post_number";
	$latest_menus = $wpdb->get_results($sql);
	if($latest_menus)
	{ ?>
          
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.pikachoose.js"></script>

		<script language="javascript" type="text/javascript">
			jQuery(document).ready(
				function (){
					jQuery("#pikame").PikaChoose();
			});
		</script>
        <div class="pikachoose">
		<span class="h_featured"><?php echo $title; ?> </span>
		<ul id="pikame" class="jcarousel-skin-pika">
        <?php 
			foreach($latest_menus as $post) :
			setup_postdata($post);
	    ?>
         <?php $post_img = bdw_get_images_with_info($post->ID,'detail_page_image');
				$thumb = $post_img[0]['file']; ?>
		<li> 
		<?php if ( $thumb != '' ) { ?>
		<a href="<?php the_permalink(); ?>">
		<img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
		<?php
		} else { ?>
		<!--<a href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo get_template_directory_uri()."/images/no-image_full.jpg"; ?>" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
		<?php } ?>
         <span><?php the_title(); ?> <br /> <small><?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?> <?php echo get_formated_time(get_post_meta($post->ID,'st_time',true))?> </small> </span>
        </li>
<?php endforeach; ?>
<?php
   echo '</ul></div>';
}
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		return $instance;
	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$character_cout = strip_tags($instance['character_cout']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_IDS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
  <p><?php echo fetch_categories_ids('eventcategory'); ?></p>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_POSTS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
 
<?php
	}
}
register_widget('featuredslider');
// FEATURED POSTS SLIDER WIDGET ENDS

// LATEST NEWS WIDGET STARTS ======================================================================================

class eventwidget extends WP_Widget {
	function eventwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest News', 'description' => 'Displays a list of Latest Blog posts.' );
		$this->WP_Widget('eventwidget', 'T &rarr; Latest News', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '';
		 ?>
          <h3> <?php echo $title; ?> </h3>
          <ul>
                
				<?php 
			        global $post;
			        $latest_menus = get_posts('numberposts='.$post_number.'postlink='.$post_link.'&category='.$category.'');
                    foreach($latest_menus as $post) :
                    setup_postdata($post);
			    ?>
                <?php $post_images = bdw_get_images_with_info($post->ID,'thumb');
				$thumb = $post_images[0]['file']; ?>
				<li class="clearfix">
				<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_tag"></div><?php }?>
				<?php if ( $thumb != '' ) { ?>
				<a class="post_img" href="<?php the_permalink(); ?>">
				<img src="<?php echo $thumb; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
				<?php
				} else { ?>
				<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="125" height="75" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
				<?php } ?>
                   <h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  </h3><br />
                   <span class="date"><?php the_time('j F Y') ?> <?php _e('at','templatic'); ?> <?php the_time('H : s A') ?> </span> 
               </li>
    
<?php endforeach; ?>
<?php
	    echo '</ul>';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_IDS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_POSTS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('eventwidget');
// LATEST NEWS WIDGET ENDS


// LATEST EVENTS WIDGET STARTS ===================================================================================

class onecolumnslist extends WP_Widget {
	function onecolumnslist() {
	//Constructor
		$widget_ops = array('classname' => 'widget category List View', 'description' => 'Displays a list of Latest Events. To be placed in Front Content Left / Right widget area.' );
		$this->WP_Widget('onecolumnslist', 'T &rarr; Latest Events', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$more_link = empty($instance['more_link']) ? '' : apply_filters('widget_more_link', $instance['more_link']);
		$character_cout = empty($instance['character_cout']) ? '15' : apply_filters('widget_character_cout', $instance['character_cout']);
		$sorting = empty($instance['event_sorting']) ? 'Latest Published' : apply_filters('widget_event_sorting', $instance['event_sorting']);
		 ?>
          <h3 class="clearfix"><?php echo $title; ?> </h3>
          <ul class="listingview clearfix">
		  <?php //$type = get_option('ptthemes_event_sorting');
			if ( $sorting != '' )
			{
				global $wpdb;
				if ( $sorting == 'Random' )
				{
					$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = p.ID and $wpdb->postmeta.meta_key like \"st_date\") ASC, rand()";
				}
				elseif ( $sorting == 'Alphabetical' )
				{
					$orderby = "p.post_title ASC";
				}elseif($sorting =='s_date'){
			 		$today = date('Y-m-d');
					 $orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id = p.ID and $wpdb->postmeta.meta_key like \"st_date\") ASC";
				}
				else
				{
					$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=p.ID and $wpdb->postmeta.meta_key = 'featured_h') ASC, p.post_date DESC";
				}
			}
			?>
		  <?php 
			global $post,$wpdb;
			if($category)
			{
				$category = "'".str_replace(",","','",$category)."'";
				$sqlsql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";
			}
			@$sql = "select p.* from $wpdb->posts p where p.post_type='".CUSTOM_POST_TYPE1."' and p.post_status='publish' $sqlsql order by $orderby limit $post_number";
			$latest_menus = $wpdb->get_results($sql);
			$pcount=0;
			if($latest_menus)
			{
				foreach($latest_menus as $post) :
				setup_postdata($post);
				$pcount++; ?>
					<?php $post_images = bdw_get_images_with_info($post->ID,'thumb');
					$thumb = $post_images[0]['file']; ?>
					<li class="clearfix">
					<?php if(get_post_meta($post->ID,'featured_h',true) == 'h' ) { ?><div class="featured_img_s"></div><?php }?>
					<?php if ( $thumb != '' ) { ?>
					<a class="post_img" href="<?php the_permalink(); ?>">
					<img src="<?php echo $thumb; ?>" width="85" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /></a>
					<?php
					} else { ?>
					<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="85" alt="<?php echo @$post_img[0]['alt']; ?>" /></a>-->
					<?php } ?>
            		<h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                    <p> <span> <?php echo get_formated_date(get_post_meta($post->ID,'st_date',true));?> <?php _e('at','templatic');?> <?php echo get_formated_time(get_post_meta($post->ID,'st_time',true))?></span> <br /> 
                    <?php echo get_post_meta($post->ID,'address',true);?> </p>
            	 </li>
				<?php endforeach; ?>
                 <?php }else{ ?>
				  <p><?php _e('Not a single Event is there','templatic');?></p>
			 	<?php } ?>
<?php

	    echo '</ul>';

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['more_link'] = strip_tags($new_instance['more_link']);
		$instance['character_cout'] = strip_tags($new_instance['character_cout']);
		$instance['event_sorting'] = strip_tags($new_instance['event_sorting']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '','more_link' => '', 'event_sorting' => 'Latest Published' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$more_link = strip_tags($instance['more_link']);
		$character_cout = strip_tags($instance['character_cout']);
		$sorting = strip_tags($instance['event_sorting']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_IDS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>  <p><?php echo fetch_categories_ids('eventcategory'); ?></p>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_POSTS_TEXT; ?>:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('event_sorting'); ?>"><?php echo SORT_EVENT; ?>:
  <select name="<?php echo $this->get_field_name('event_sorting'); ?>" id="<?php echo $this->get_field_id('event_sorting'); ?>">
	<option selected="selected" value="Latest Published"><?php _e('Latest Published','templatic'); ?></option>
	<option <?php if ($sorting == 'Random') { echo 'selected=selected'; } ?> value="Random"><?php _e('Random','templatic'); ?></option>
	<option <?php if ($sorting == 'Alphabetical') { echo 'selected=selected'; } ?> value="Alphabetical"><?php _e('Alphabetical','templatic'); ?></option>
    <option <?php if ($sorting == 's_date') { echo 'selected=selected'; } ?> value="s_date"><?php _e('As Per Start Date','templatic'); ?></option>
  </select>
  </label>
</p>
<?php
	}
}
register_widget('onecolumnslist');
// LATEST EVENTS WIDGET ENDS

// FEATURED VIDEO WIDGET STARTS ==========================================================================

class spotlightpost extends WP_Widget {
	function spotlightpost() {
	//Constructor
		$widget_ops = array('classname' => 'widget Featured Video', 'description' => 'Displays a list of Videos added in Events.' );
		$this->WP_Widget('spotlight_post', 'T &rarr; Featured Video', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo ' <div class="featured_video">';?>
        		
                <h3 class="clearfix"> <span class="fl"><?php echo $title; ?> </span>
                  <?php if ( $video_link <> "" ) { ?>	 
                   <span class="more"><a href="<?php echo $video_link; ?>"> <?php _e('View All','templatic');?></a> </span> 
          		<?php } ?>
                 </h3>

				<?php 
			        global $post;
					$cat = get_the_category_by_ID($category); 
					$args = array( 'numberposts' => $post_number,'taxonomy' => 'eventcategory', 'category' => $cat, 'post_type' => CUSTOM_POST_TYPE1);
			        $latest_menus = get_posts( $args );
                    foreach($latest_menus as $post) :
                    setup_postdata($post); ?>
	 
                <?php if(get_post_meta($post->ID,'video',true)){?>
                     <div class="video" style="height:317px; width:300px;">
                    <?php echo get_post_meta($post->ID,'video',true);?>
                    	<h4><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h4>
                    </div>
                    <?php }?>   
                 <?php endforeach; ?>
                <?php

	    echo '</div>';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_IDS_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_POSTS_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('spotlightpost');

// FEATURED VIDEO WIDGET ENDS

// FLICKR PHOTOS WIDGET STARTS =============================================================

class flickrWidget extends WP_Widget {
	function flickrWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Flickr Photos ', 'description' => 'Displays a list of Flickr photos of the mentioned Flickr ID.' );
		$this->WP_Widget('widget_flickrwidget', 'T &rarr; Flickr Photos', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$number = empty($instance['number']) ? '' : apply_filters('widget_number', $instance['number']);

?>
	<h3 ><span><?php echo FLICKR_TITLE_TEXT; ?></span></h3>
	<div class="flickr clearfix">
 		 <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
 		 
	</div>

<?php
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('title' => '',  'id' => '', 'number' => '') );
		$id = strip_tags($instance['id']);
		$number = strip_tags($instance['number']);
?>

<p>
  <label for="<?php echo $this->get_field_id('id'); ?>"><?php echo FLICKR_ID_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr($id); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>"><?php echo NUMBER_PHOTOS_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('flickrWidget');

// FLICKR PHOTOS WIDGET ENDS

 
// =============================== Popular Posts Widget ======================================
class popular_posts_sidebar extends WP_Widget {
function popular_posts_sidebar()
{
	//Constructor
		$widget_ops = array('classname' => 'popular_posts_sidebar', 'description' => 'Displays a list of Flickr photos of the mentioned Flickr ID.' );
		$this->WP_Widget('popular_posts_sidebar', 'T &rarr; Popular Posts', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? 'Popular Posts' : apply_filters('widget_title', $instance['title']);
		$number = empty($instance['number']) ? '3' : apply_filters('widget_number', $instance['number']);
?>
	<div  class="popular_post">
	<h3 class="popular" ><span><?php echo $title; ?></span></h3>
		<ul>
 			<?php
			global $wpdb;
            $now = gmdate("Y-m-d H:i:s",time());
            $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
             $popularposts = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT $number";
            $posts = $wpdb->get_results($popularposts);
            $popular = '';
            if($posts){
                foreach($posts as $post){
	                $post_title = stripslashes($post->post_title);
		               $guid = get_permalink($post->ID);
					   
					      $first_post_title=substr($post_title,0,26);
            ?>
             <?php $post_img = bdw_get_images_with_info($post->ID,'thumb');
		$thumb = $post_img[0]['file'];?>
            	
		        <li class="clearfix">
				<?php 
				if($thumb)
				{?>
				<a class="post_img" href="<?php the_permalink(); ?>">
				<img src="<?php echo $thumb; ?>" alt="<?php echo $post->post_title; ?>" width="125" height="75" title="<?php echo $post->post_title; ?>"  /></a>
			<?php	} else { ?>
		<!--<a href="<?php echo get_permalink($post->ID); ?>" class="post_img"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>" width="125" height="75" alt="<?php echo $post_img[0]['alt']; ?>" /></a>-->
		<?php } ?>
                    <a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></a>  
                     </li>
            <?php } } ?>

		</ul>
 
 </div>

<?php
}
function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('title' => 'Popular Posts', 'number' => '') );
		$title = strip_tags($instance['title']);
		$number = strip_tags($instance['number']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>"><?php echo NUMBER_PHOTOS_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('popular_posts_sidebar');


// RECENT REVIEWS WIDGET STARTS ============================================================================
class CommentsWidget extends WP_Widget {
	function CommentsWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Recent Review', 'description' => 'Displays a list of comments added in events and posts.' );		
		$this->WP_Widget('widget_comment', 'T &rarr; Recent Review', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$count = empty($instance['count']) ? '5' : apply_filters('widget_count', $instance['count']);
 		 ?>						
		
        
        <div class="widget recent_comments_section">
        
        <h3> <?php echo $title; ?> </h3>
       
       	<ul class="recent_comments">
		   <?php
 		  if(function_exists('recent_comments')) {
			recent_comments(30, $count, 100, false);
		  }
		?>
       </ul>
            
            </div> 
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'count' => '' ) );		
		$title = strip_tags($instance['title']);
		$count = strip_tags($instance['count']);
 ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php echo NUMBER_REVIEWS_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>
<?php
	}
}
register_widget('CommentsWidget');
// RECENT REVIEWS WIDGET ENDS




/*
 * Create the templatic twiter post widget
 */	

// Display Twitter messages
function templatic_twitter_messages($options) {
	
	// CHECK OPTIONS
	
	if ($options['username'] == '') {
		return __('Twitter username not configured','templatic');
	} 
	
	if (!is_numeric($options['num']) or $options['num']<=0) {
		return __('Number of tweets not valid','templatic');
	}

	// SET THE NUMBER OF ITEMS TO RETRIEVE - IF "SKIP TEXT" IS ACTIVE, GET MORE ITEMS
	$max_items_to_retrieve = $options['num'];
	if ($options['skip_text']!='') {
		$max_items_to_retrieve *= 3;
	}
	
	// USE TRANSIENT DATA, TO MINIMIZE REQUESTS TO THE TWITTER FEED
	
	$timeout = 30 * 60; //30m
	$error_timeout = 5 * 60; //5m
	$no_cache_timeout = 60 * 60 * 24 * 365 * 10; //10 years should be fine...
	
	$transient_name = 'twitter_data_'.$options['username'].$options['skip_text'].'_'.$options['num'];
    
    $twitter_data = get_transient($transient_name);
    $twitter_status = get_transient($transient_name."_status");
    
	// Twitter Status
    if(!$twitter_status || !$twitter_data) {
        $json = wp_remote_get('http://api.twitter.com/1/account/rate_limit_status.json');
		$twitter_status = json_decode($json['body'], true);
        
		set_transient($transient_name."_status", $twitter_status, $no_cache_timeout);
    }
	//echo "<!-- Twitter status: ".print_r($twitter_status,true)." -->";
    $reset_seconds = (strtotime($twitter_status['reset_time'])-time());
    
    
	// Tweets
	if (!$twitter_data) {

		//echo "\n<!-- Fetching data from Twitter... -->";                            /* Debug Stuff */
		
		if($twitter_status['remaining_hits'] <= 7) {
		    $timeout = $reset_seconds;
		    $error_timeout = $timeout;
		}		
	    
        
		$json = wp_remote_get('http://api.twitter.com/1/statuses/user_timeline.json?screen_name='.$options['username'].'&count='.$max_items_to_retrieve);
 		if( is_wp_error( $json ) ) {
			return __('Error retrieving tweets','templatic');
		} else {
			$twitter_data = json_decode($json['body'], true);
                        
            if(!isset($twitter_data['error']) && (count($twitter_data) == $options['num']) ) {
			    set_transient($transient_name, $twitter_data, $timeout);
			    set_transient($transient_name."_valid", $twitter_data, $no_cache_timeout);
            } else {
			    set_transient($transient_name, $twitter_data, $error_timeout);	// Wait 5 minutes before retry
	            echo "\n<!-- Twitter error: ".$twitter_data['error']." -->";          /* Debug Stuff */
		    }
		}
	} else {		
		if(isset($twitter_data['error'])) {
	        echo "\n<!-- Twitter error: ".$twitter_data['error']." -->";              /* Debug Stuff */
		} 
	}
    
	$items_retrieved = count($twitter_data); 
    
	if (empty($twitter_data) and false === ($twitter_data = get_transient($transient_name."_valid"))) {
	    return __('No public tweets','templatic');
	}

	if (isset($twitter_data['errors'])) {
		// STORE ERROR FOR DISPLAY
		$twitter_error = $twitter_data['errors'];
	    if(false === ($twitter_data = get_transient($transient_name."_valid"))) {
			$debug = ($options['debug']) ? '<br /><i>Debug info:</i> ['.$twitter_error[0]['code'].'] '.$twitter_error[0]['message'].' - username: "'.$options['username'].'"' : '';
		    return __('Unable to get tweets'.$debug,'templatic');
		}
	}
	
	// SET THE MAX NUMBER OF ITEMS  
	$num_items_shown = $options['num'];
	if ($items_retrieved<$options['num']) {
		$num_items_shown = $items_retrieved;
	}
	
	$link_target = ($options['link_target_blank']) ? ' target="_blank" ' : '';
		
	$out = '<ul id="twitter_update_list" class="templatic_twitter_widget">';

	$i = 0;
	foreach($twitter_data as $message){
		if ($i>=$num_items_shown) {
			break;
		}
		$msg = $message['text'];
		
		if ($options['skip_text']!='' and strpos($msg, $options['skip_text'])!==false) {
			continue;
		}
		if($options['encode_utf8']) $msg = utf8_encode($msg);
				
		$out .= '<li>';

		if ($options['hyperlinks']) { 
			// match protocol://address/path/file.extension?some=variable&another=asf%
			$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);
			// match www.something.domain/path/file.extension?some=variable&another=asf%
			$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);    
			// match name@address
			$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\" ".$link_target.">$1</a>", $msg);
			//NEW mach #trendingtopics
			//$msg = preg_replace('/#([\w\pL-.,:>]+)/iu', '<a href="http://twitter.com/#!/search/\1" class="twitter-link">#\1</a>', $msg);
			//NEWER mach #trendingtopics
			$msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="http://twitter.com/#!/search/%23\2" class="twitter-link" '.$link_target.'>#\2</a>', $msg);
		}
		if ($options['twitter_users'])  { 
			$msg = preg_replace('/([\.|\,|\:|\�|\�|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\" ".$link_target.">@$2</a>$3 ", $msg);
		}
          					
		$link = 'http://twitter.com/#!/'.$options['username'].'/status/'.$message['id_str'];
		if($options['linked'] == 'all')  { 
			$msg = '<a href="'.$link.'" class="twitter-link" '.$link_target.'>'.$msg.'</a>';  // Puts a link to the status of each tweet 
		} else if ($options['linked'] != '') {
			$msg = $msg . ' <a href="'.$link.'" class="twitter-link" '.$link_target.'>'.$options['linked'].'</a>'; // Puts a link to the status of each tweet
		} 
		$out .= $msg;
		
		if($options['update']) {				
			$time = strtotime($message['created_at']);
			$h_time = ( ( abs( time() - $time) ) < 86400 ) ? sprintf( __('%s ago', 'templatic'), human_time_diff( $time )) : date(__('Y/m/d'), $time);
			$out .= '<span class="rstw_comma">,</span> '.sprintf( __('%s', 'templatic'),' <span class="twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s', 'templatic'), $time) . '">' . $h_time . '</abbr></span>' );
		}          
                  
		$out .= '</li>';
		$i++;
	}
	$out .= '</ul>';
	
	if ($options['link_user']) {
		$out .= '<div class="rstw_link_user"><a href="http://twitter.com/' . $options['username'] . '" '.$link_target.'>'.$options['link_user_text'].'</a></div>';
	}
	
	return $out;
}



/**
 * ReallySimpleTwitterWidget Class
 */
class templatic_twiter extends WP_Widget {
	private /** @type {string} */ $languagePath;

    /** constructor */
    function templatic_twiter() {
		$this->options = array(
			array(
				'name'	=> 'title',
				'label'	=> __( 'Title', 'templatic' ),
				'type'	=> 'text'
			),			
			array(
				'name'	=> 'username',
				'label'	=> __( 'Twitter Username', 'templatic' ),
				'type'	=> 'text'
			),
			array(
				'name'	=> 'num',
				'label'	=> __( 'Show # of Tweets', 'templatic' ),
				'type'	=> 'text'
			),
			
			
		);

        $widget_ops = array('classname' => 'widget Templatic twitter', 'description' => __('Show your latest tweets on your site.') );
		$this->WP_Widget('templatic_twiter', __('T &rarr; Latest Twitter Feeds'), $widget_ops);
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$username = apply_filters('widget_title', $instance['username']);
		$follow_text = apply_filters('widget_title', $instance['follow_text']);
		echo $before_widget ;
		echo $before_widget ;
		echo '<div id="twitter" style="margin:auto">';
		if ( $title ) {
			$title_icon = ($instance['title_icon']) ? '<img src="'.WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/twitter_small.png" alt="'.$title.'" title="'.$title.'" /> ' : '';
			if ( $instance['link_title'] === true ) {
				$link_target = ($instance['link_target_blank']) ? ' target="_blank" ' : '';
				echo $before_title . '<a href="http://twitter.com/' . $instance['username'] . '" class="twitter_title_link" '.$link_target.'>'. $title_icon . $instance['title'] . '</a>' . $after_title;
			} else {
				echo '<h3 class="i_twitter">' . $title_icon . $instance['title'] . '</h3>';
			}
		}
		echo templatic_twitter_messages($instance);
		
		echo '</div>';
		echo $after_widget;
		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		
		foreach ($this->options as $val) {
			if ($val['type']=='text') {
				$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
			} else if ($val['type']=='checkbox') {
				$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
			}
		}
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		if (empty($instance)) {
			$instance['title']			= __( 'Live Tweet', 'templatic' );			
			$instance['username']		= 'templatic';
			$instance['num']			= '5';			
			$instance['follow_text']	= __('Follow Us','templatic');
			
		}					
	
		foreach ($this->options as $val) {
			$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
			if ($val['type']=='separator') {
				echo '<hr />';
			} else if ($val['type']=='text') {
				echo '<p>'.$label.'<br />';
				echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
			} else if ($val['type']=='checkbox') {
				$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
				echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
			}
		}
	}

} // class templatic_twiter

// register templatic_twiter widget
add_action('widgets_init', create_function('', 'return register_widget("templatic_twiter");'));










// EVENTS CALENDER WIDGET STARTS ================================================================
class my_event_calender_widget extends WP_Widget {
	function my_event_calender_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Event Listing calender.', 'description' => 'Event Listing calender' );		
		$this->WP_Widget('event_calendar', 'T &rarr; Event Listing Calender', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		global $post;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		include_once (TEMPLATEPATH . '/library/calendar/calendar.php');
		if($title)
		{
		echo '<h3>'.$title.'</h3>';	
		}
		get_my_event_calendar();
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );		
		$title = strip_tags($instance['title']);
		?>
        
        
        
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
        <?php
	}
}
register_widget('my_event_calender_widget');
// EVENTS CALENDER WIDGET ENDS

/* =============================== Contact Information Widget START ======================================  */
if(!class_exists('contact_info_widget')){
	class contact_info_widget extends WP_Widget {
		function contact_info_widget() {
		//Constructor
			$widget_ops = array('classname' => 'About us', 'description' => 'Display contact us information.' );		
			$this->WP_Widget('contact_info_widget', 'T &rarr; Contact Us Information Widget', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
			$phone = empty($instance['phone']) ? '' : apply_filters('widget_phone', $instance['phone']);
			$email = empty($instance['email']) ? '' : apply_filters('widget_email', $instance['email']);
			echo $before_widget;
			 ?>
			<h3><span>
			<?php _e($title,'templatic'); ?>
			</span></h3>
			<?php if ( $desc1 <> "" ) { ?>
			<p>
			<?php _e($desc1,'templatic');?> 
			</p>
			<?php } ?>
			<?php if ( $phone <> "" ||  $email <> "" ) { ?>
			<p>
			<span class="contact phone"><img src="<?php echo get_template_directory_uri()."/images/phone.png";?>"  /><?php _e($phone,'templatic'); ?></span></br><span class="contact email">&nbsp;<img src="<?php echo get_template_directory_uri()."/images/mail.png";?>"  /><?php _e($email,'templatic'); ?></span>
			</p>
		<?php 
			} 
				echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['desc1'] = ($new_instance['desc1']);
			$instance['phone'] = ($new_instance['phone']);
			$instance['email'] = ($new_instance['email']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ,'phone' => '','email' => '') );		
			$title = strip_tags($instance['title']);
			$desc1 = ($instance['desc1']);
			$phone = ($instance['phone']);
			$email = ($instance['email']);
	?>
				<p>
				  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo WIDGET_TITLE_TEXT;?>:
					<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('desc1'); ?>"><?php echo DESCRIPTION_TEXT;?> :
					<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo esc_attr($desc1); ?></textarea>
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('phone'); ?>"><?php echo CONTACTNO_TEXT;?> :
					<input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($phone); ?>" />
				  </label>
				</p>
				<p>
				  <label for="<?php echo $this->get_field_id('email'); ?>"><?php echo EMAIL_TEXT;?> :
					<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
				  </label>
				</p>
		<?php
		}
	}
	register_widget('contact_info_widget');
}
/* =============================== Contact Information Widget END ======================================  */


// =============================== Location Map Widget ======================================
if(!class_exists('templ_locationmap'))
{
	class templ_locationmap extends WP_Widget {
		function templ_locationmap() {
		//Constructor
			$widget_ops = array('classname' => 'widget location_map', 'description' => 'Display map on contact us page');		
			$this->WP_Widget('widget_location_map', 'T &rarr; Contact Page Google Map', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$address_latitude = empty($instance['address_latitude']) ? '0' : apply_filters('widget_address_latitude', $instance['address_latitude']);
			$address_longitude = empty($instance['address_longitude']) ? '34' : apply_filters('widget_address_longitude', $instance['address_longitude']);
			$address = empty($instance['address']) ? '' : apply_filters('widget_address', $instance['address']);
			$map_type = empty($instance['map_type']) ? 'ROADMAP' : apply_filters('widget_map_type', $instance['map_type']);
			$map_width = empty($instance['map_width']) ? '200' : apply_filters('widget_map_width', $instance['map_width']);
			$map_height = empty($instance['map_height']) ? '200' : apply_filters('widget_map_height', $instance['map_height']);
			$scale = empty($instance['scale']) ? '10' : apply_filters('widget_scale', $instance['scale']);
			?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.5&sensor=false"></script>

<script type="text/javascript">
              var geocoder;
              var map;
              function initialize() {
                geocoder = new google.maps.Geocoder();
                var latlng = new google.maps.LatLng(-34.397, 150.644);
                var myOptions = {
                zoom: <?php echo $scale; ?>,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.<?php echo $map_type; ?>
                }
                map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
                codeAddress();
              }
            
              function codeAddress() {
                var address = '<?php echo $address; ?>';//document.getElementById("address").value;
                geocoder.geocode( { 'address': address}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map, 
                        position: results[0].geometry.location
                    });
                  } else {
                    alert("Geocode was not successful for the following reason: " + status);
                  }
                });
              }
             google.maps.event.addDomListener(window, 'load', initialize); 
            </script>
<div id="map-canvas" style="height:<?php echo $map_height; ?>px;"></div>
<?php 
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = ($new_instance['title']);
			$instance['address'] = strip_tags($new_instance['address']);
			$instance['address_latitude'] = strip_tags($new_instance['address_latitude']);
			$instance['address_longitude'] = strip_tags($new_instance['address_longitude']);
			$instance['map_width'] = strip_tags($new_instance['map_width']);
			$instance['map_height'] = strip_tags($new_instance['map_height']);
			$instance['map_type'] = strip_tags($new_instance['map_type']);
			$instance['scale'] = strip_tags($new_instance['scale']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );		
			$title = ($instance['title']);
			$address = strip_tags($instance['address']);
			$address_latitude = strip_tags($instance['address_latitude']);
			$address_longitude = strip_tags($instance['address_longitude']);
			$map_width = strip_tags($instance['map_width']);
			$map_height = strip_tags($instance['map_height']);
			$map_type = strip_tags($instance['map_type']);
			$scale = strip_tags($instance['scale']);
			
	?>
<p>
  <label for="<?php  echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT;?>:
    <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('address'); ?>"><?php echo ADDRESS_FOR_MAP_TEXT;?> :
    <input type="text" class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"  value="<?php echo esc_attr($address); ?>">
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('map_height'); ?>"><?php echo MAP_HEIGHT_TEXT;?> :
    <input type="text" class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('map_height'); ?>" name="<?php echo $this->get_field_name('map_height'); ?>" value="<?php echo esc_attr($map_height); ?>">
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('scale'); ?>"><?php echo MAP_ZOOM_TEXT;?> :
    <select id="<?php echo $this->get_field_id('scale'); ?>" name="<?php echo $this->get_field_name('scale'); ?>">
      <?php
	for($i=3;$i<20;$i++)
	{
	?>
      <option value="<?php echo $i;?>" <?php if(esc_attr($scale)==$i){echo 'selected="selected"';}?> ><?php echo $i;;?></option>
      <?php	
	}
	?>
    </select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('map_type'); ?>"><?php echo SELECT_MAP_TEXT;?> :
    <select id="<?php echo $this->get_field_id('map_type'); ?>" name="<?php echo $this->get_field_name('map_type'); ?>">
      <option value="ROADMAP" <?php if(esc_attr($map_type)=='ROADMAP'){echo 'selected="selected"';}?> ><?php echo ROAD_MAP_TEXT;?></option>
      <option value="SATELLITE" <?php if(esc_attr($map_type)=='SATELLITE'){echo 'selected="selected"';}?>><?php echo SATELLITE_MAP_TEXT;?></option>
    </select>
  </label>
</p>
<?php
	}
}
	register_widget('templ_locationmap');
}
class social_media extends WP_Widget {
	function social_media() {
	//Constructor

		$widget_ops = array('classname' => 'widget Social Media', 'description' => apply_filters('templ_socialmedia_widget_desc_filter',__('Show social media sharing buttons.','templatic')) );		
		$this->WP_Widget('social_media', apply_filters('templ_socialmedia_widget_title_filter',__('T &rarr; Social media buttons','templatic')), $widget_ops);

	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
		$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
		$digg = empty($instance['digg']) ? '' : apply_filters('widget_digg', $instance['digg']);
		$linkedin = empty($instance['linkedin']) ? '' : apply_filters('widget_linkedin', $instance['linkedin']);
		$myspace = empty($instance['myspace']) ? '' : apply_filters('widget_myspace', $instance['myspace']);
		$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
		 ?>						

		<span class="social_icon">
       	<?php if ( $twitter <> "" ) { ?>	
        <a href="<?php echo $twitter; ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/i_twitter.png" alt=""  /></a>
         <?php } ?>
         	<?php if ( $facebook <> "" ) { ?>	
        	<a href="<?php echo $facebook; ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/i_facebook.png" alt=""  /></a>
         <?php } ?>
         	<?php if ( $digg <> "" ) { ?>	
        	<a href="<?php echo $digg; ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/digg_alt_16.png" alt=""  /></a>
         <?php } ?>
         	<?php if ( $linkedin <> "" ) { ?>	
        	<a href="<?php echo $linkedin; ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/linkedin_16.png" alt=""  /></a> 
         <?php } ?>
         	<?php if ( $myspace <> "" ) { ?>	
        	<a href="<?php echo $myspace; ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/myspace_16.png" alt=""  /></a>  
         <?php } ?>
         	<?php if ( $rss <> "" ) { ?>	
        	<a href="<?php echo $rss; ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/i_rss.png" alt=""  /></a>
         <?php } ?>
        <span class="clearfix"></span>
        
       </span> 
            
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['twitter'] = ($new_instance['twitter']);
		$instance['facebook'] = ($new_instance['facebook']);
		$instance['digg'] = ($new_instance['digg']);
		$instance['linkedin'] = ($new_instance['linkedin']);
		$instance['myspace'] = ($new_instance['myspace']);
		$instance['rss'] = ($new_instance['rss']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array(  'twitter' => '', 'facebook' => '', 'digg' => '',  'linkedin' => '', 'myspace' => '','rss' => '' ) );		
		$twitter = ($instance['twitter']);
		$facebook = ($instance['facebook']);
		$digg = ($instance['digg']);
		$linkedin = ($instance['linkedin']);		
		$myspace = ($instance['myspace']);
		$rss = ($instance['rss']);
?>
        <p><i>Please specify full URL to your profiles.</i></p>
       <p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter profile URL','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo attribute_escape($twitter); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook profile URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo attribute_escape($facebook); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('digg'); ?>"><?php _e('Digg profile URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('digg'); ?>" name="<?php echo $this->get_field_name('digg'); ?>" type="text" value="<?php echo attribute_escape($digg); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin profile URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo attribute_escape($linkedin); ?>" /></label></p>
       <p><label for="<?php echo $this->get_field_id('myspace'); ?>"><?php _e('Myspace profile URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('myspace'); ?>" name="<?php echo $this->get_field_name('myspace'); ?>" type="text" value="<?php echo attribute_escape($myspace); ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS feeds URL','templatic');?> : <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo attribute_escape($rss); ?>" /></label></p>

<?php
	}}
register_widget('social_media');

?>