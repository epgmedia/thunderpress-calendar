<?php
function getWeek($timestamp){
	$weekNum = date("W", $timestamp) - date("W",strtotime(date("Y-m-01", $timestamp)))+1;
	return $weekNum;
}

/* Set Excerpt length  START */
function bm_better_excerpt($length, $ellipsis) {
	$text = get_the_content();
	$text = strip_tags($text);
	$text = substr($text, 0, $length);
	$text = substr($text, 0, strrpos($text, " "));
	$text = $text.$ellipsis;
return $text;
}
/* Set Excerpt length  START */

/*	Function to get the relative date START	 */
function relativeDate($posted_date) {
    $tz = 0;    // change this if your web server and weblog are in different timezones
                // see project page for instructions on how to do this
    $month = substr($posted_date,4,2);
    if ($month == "02") { // february
    	// check for leap year
    	$leapYear = isLeapYear(substr($posted_date,0,4));
    	if ($leapYear) $month_in_seconds = 2505600; // leap year
    	else $month_in_seconds = 2419200;
    }
    else { // not february
    // check to see if the month has 30/31 days in it
    	if ($month == "04" or 
    		$month == "06" or 
    		$month == "09" or 
    		$month == "11")
    		$month_in_seconds = 2592000; // 30 day month
    	else $month_in_seconds = 2678400; // 31 day month;
    }
  
/* 
some parts of this implementation borrowed from:
http://maniacalrage.net/archives/2004/02/relativedatesusing/ 
*/
    $in_seconds = strtotime(substr($posted_date,0,8).' '.
                  substr($posted_date,8,2).':'.
                  substr($posted_date,10,2).':'.
                  substr($posted_date,12,2));
    $diff = time() - ($in_seconds + ($tz*3600));
    $months = floor($diff/$month_in_seconds);
    $diff -= $months*2419200;
    $weeks = floor($diff/604800);
    $diff -= $weeks*604800;
    $days = floor($diff/86400);
    $diff -= $days*86400;
    $hours = floor($diff/3600);
    $diff -= $hours*3600;
    $minutes = floor($diff/60);
    $diff -= $minutes*60;
    $seconds = $diff;
    if ($months>0) {
        // over a month old, just show date ("Month, Day Year")
        echo ''; the_time('F jS, Y');
    } else {
        if ($weeks>0) {
            // weeks and days
            $relative_date .= ($relative_date?', ':'').$weeks.' '.__('week').''.($weeks>1?''.__('s').'':'');
            $relative_date .= $days>0?($relative_date?', ':'').$days.' '.__('day').''.($days>1?''.__('s').'':''):'';
        } elseif ($days>0) {
            // days and hours
            $relative_date .= ($relative_date?', ':'').$days.' '.__('day').''.($days>1?''.__('s').'':'');
            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' '.__('hour').''.($hours>1?''.__('s').'':''):'';
        } elseif ($hours>0) {
            // hours and minutes
            $relative_date .= ($relative_date?', ':'').$hours.' '.__('hour').''.($hours>1?''.__('s').'':'');
            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' '.get_option('ptthemes_relative_minute').''.($minutes>1?''.__('s').'':''):'';
        } elseif ($minutes>0) {
            // minutes only
            $relative_date .= ($relative_date?', ':'').$minutes.' '.get_option('ptthemes_relative_minute').''.($minutes>1?''.__('s').'':'');
        } else {
            // seconds only
            $relative_date .= ($relative_date?', ':'').$seconds.' '.get_option('ptthemes_relative_minute').''.($seconds>1?''.__('s').'':'');
        }
        // show relative date and add proper verbiage
    	echo ''.__('Posted').' '.$relative_date.' '.__('ago').'';
    }
}
/*	Function to get the relative date END	 */

/*	Function to check whether the year is leap or not START	 */
function isLeapYear($year) {
        return $year % 4 == 0 && ($year % 400 == 0 || $year % 100 != 0);
}
/*	Function to check whether the year is leap or not END	 */

/************************************
//FUNCTION NAME : templ_listing_content
//ARGUMENTS :NONE
//RETURNS : display content or excerpt or sub part of it.
***************************************/
function templ_listing_content($post)
{
	global $post;
	if (apply_filters('templ_get_listing_content_filter', true))
	{
		if(get_option('ptthemes_postcontent_full')=='Full Content')
		{ 
			echo $post->post_content;			
		}else
		{
			if($post->post_excerpt != ''){
				$string = $post->post_excerpt;		
			} else {
				$string = $post->post_content;		
			}
			$limit = get_option('ptthemes_content_excerpt_count');
			if ($limit)
			{
				echo templ_get_excerpt($string, $limit);
			}
			else {
			echo templ_get_excerpt($string,15);
			}
		}
	}
}
add_action('templ_get_listing_content','templ_listing_content');

/*	Function to get how long old the event is  - START  */
if(!function_exists('how_long_ago')){
	function how_long_ago($timestamp){
		$difference = time() - $timestamp;

		if($difference >= 60*60*24*365){        // if more than a year ago
			$int = intval($difference / (60*60*24*365));
			$s = ($int > 1) ? ''.__('s').'' : '';
			$r = $int . ' '.__('year').'' . $s . ' '.__('ago').'';
		} elseif($difference >= 60*60*24*7*5){  // if more than five weeks ago
			$int = intval($difference / (60*60*24*30));
			$s = ($int > 1) ? ''.__('s').'' : '';
			$r = $int . ' '.__('month').'' . $s . ' '.__('ago').'';
		} elseif($difference >= 60*60*24*7){        // if more than a week ago
			$int = intval($difference / (60*60*24*7));
			$s = ($int > 1) ? ''.__('s').'' : '';
			$r = $int . ' '.__('week').'' . $s . ' '.__('ago').'';
		} elseif($difference >= 60*60*24){      // if more than a day ago
			$int = intval($difference / (60*60*24));
			$s = ($int > 1) ? ''.__('s').'' : '';
			$r = $int . ' '.__('day').'' . $s . ' '.__('ago').'';
		} elseif($difference >= 60*60){         // if more than an hour ago
			$int = intval($difference / (60*60));
			$s = ($int > 1) ? ''.__('s').'' : '';
			$r = $int . ' '.__('hour').'' . $s . ' '.__('ago').'';
		} elseif($difference >= 60){            // if more than a minute ago
			$int = intval($difference / (60));
			$s = ($int > 1) ? ''.__('s').'' : '';
			$r = $int . ' '.get_option('ptthemes_relative_minute').'' . $s . ' '.__('ago').'';
		} else {                                // if less than a minute ago
			$r = ''.get_option('ptthemes_relative_moments').' '.__('ago').'';
		}

		return $r;
	}
}

/*	Function to get how long old the event is  - END  */


/*  PLUGIN: MostWanted Plugin configuration START   */


/* popular posts*/
$mostwanted_ver = "0.1.9v";
$total_hits = -1;
//$futureSpamOption = "";
$futureSpamOption = "and spam=0";
$cache_until = 0;
$cached_result = "";

// what's the table name?
$tablestattraq = $table_prefix . 'stattraq';


function rjb_mostwanted($top_n=5, $curtail=0, $showviews=false, $show_views_in_tt=true, $duration = null, $pre="<li>", $post="</li>", $method="ip", $as_percentage = false) {
    MostWanted::mostwanted($top_n, $curtail, $showviews, $show_views_in_tt, $duration, $pre, $post, $method, $as_percentage);
}
function mostwanted_conf() {
	global $tablestattraq;
?>
<div class="wrap">
	<h2><?php _e("MostWanted Configuration","templatic");?></h2>
	<?php
		if ( isset($_POST['submit']) ) {
			MostWanted::fixstats($_POST['sleep']);
		} else { ?>
			<p><?php _e("MostWanted uses the database tables from StatTraq to provide a list of the most popular articles.","templatic");?></p>
			<p><?php _e("There is a small quirk in StatTraq that results in all page views showing up as &quot;Multiple Posts&quot; in cases where permalinks are used.  These stats are not lost, they&apos;re just incorrectly recorded, and can be fixed.","templatic");?></p>

			<p><?php _e("Currently there are ","templatic");  
			
			global $wpdb;
			
			$q = "SELECT count(*) FROM $tablestattraq WHERE article_id = '0' AND url LIKE '/index.php?name=%'";
			$potential = $wpdb->get_var( $q );
		_e( $potential );
			
			 _e("rows in your database that could be repaired.","templatic");?></p>
			
			<p><?php _e("Between each update, the fix mechanism can pause in order to give the database a rest.  This is handy if you're running a live service and don't want the update to be noticed - a value of &quot;0&quot; can safely be used if you are the sole user of the DB and you just want to get the fix done.","templatic");?></p>
			<form action="" method="post" id="akismet-conf" style="margin: auto; width: 25em; ">
				<p><?php _e("Pause time (in seconds)","templatic");?><input type="text" name="sleep" value="1" /></p>
				<p class="submit"><input type="submit" name="submit" value="Fix stats &raquo;" /></p>
			</form><?php 
		}
	?>
</div>
<?php	
}

class MostWanted {

	function config_page() {
		global $wpdb;
		if ( function_exists('add_submenu_page') )
			add_submenu_page('plugins.php', 'MostWanted Configuration', 'MostWanted Config', 1, basename(__FILE__), 'mostwanted_conf');
	}

	
	function mostwanted($top_n=5, $curtail=0, $showviews=false, $show_views_in_tt=true, $duration="", $pre="<li>", $post="</li>", $method="ip", $as_percentage = false, $timeout=1800){
		global $wpdb, $tablestattraq, $tableposts, $user_level, $mostwanted_ver, $total_hits, $cache_until, $cached_result;

		$time_now = time();
		if ($time_now > $cache_until) {
			// the cache_until time has been passed so the cache is invalid.
			// the content must therefore be regenerated.
			$cache_until = $time_now+$timeout;
			_e("<!-- MostWanted Generated ".$time_now." Expires ".$cache_until." -->");

			get_currentuserinfo();

   		$dateOption = "";
        	$durationExplained = "";
			if ($duration != "") {
				$dateOption .= "AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < st.access_time";
				$durationExplained = " in the last ".$duration." days";
			}
			if ($method == "ip") {
				$method="ip_address";
			} else {
				$method="session_id";
			}

			$distinct = ($as_percentage?" of":"")." distinct viewers";

			$q = "SELECT p.post_title, st.article_id, COUNT( DISTINCT (st.$method) ) as cnt FROM $tablestattraq st, $tableposts p where p.ID=st.article_id AND p.post_status='publish' ".$futureSpamOption." AND st.user_agent_type='0' ".$dateOption." GROUP BY st.article_id ORDER BY cnt DESC LIMIT 0,$top_n";
			$output = $wpdb->get_results( $q );
			$cached_result="";

			_e("<!-- ",'templatic');
			_e($q,'templatic');
			_e(" -->",'templatic');

        if (isset($output)) {
            foreach ($output as $line) {
                if ($showviews) {
                    $views = " ".MostWanted::getHits($as_percentage, $line->cnt, $dateOption)."";
                }
                if ($show_views_in_tt) {
                    $ttviews = " (".MostWanted::getHits($as_percentage, $line->cnt, $dateOption).$distinct.$durationExplained.")".$append;
                }
					 
                $short = MostWanted::curtail($line->post_title, $curtail) ;
                $t= str_replace("'","&apos;", $line->post_title);
                
					 $cached_result .= $pre . "<a title='". $t . $ttviews . "' href='" . get_permalink($line->article_id) . "'>" . ($short) . "</a>".$post;
            }
        } else {
            $cached_result .= $pre . "No results available.".$post;
        }
		} else {
			_e("<!-- MostWanted Cache Hit -->",'templatic');
			// the cache is still valid
			// there no need to do anything 
		}
		echo $cached_result;

		// reset the hits value so it is checked once when
		// the next page is loaded.
		$total_hits = -1;
		return;
    }


	function getHits($as_percentage, $count, $dateOption) {
		global $total_hits, $wpdb;
		// start percentage lookup
		if ($as_percentage) {
			// get the total number of hits if it's not known already
			if ($total_hits == -1) {
				$q = "SELECT COUNT( * ) as cnt FROM $tablestattraq st where st.user_agent_type='0'" . $futureSpamOption." ".$dateOption;
				$total_hits = $wpdb->get_var( $q );
			}
			return "" . round((($count / $total_hits) * 100), 1) . "%";
		} else {
			return $count;
		}
		// end percentage lookup
	}


	// trims a message down so that it is shorter than the length
	// specified in the $trim_chars argument.
	function curtail($trim_this, $trim_chars=0) {
		if ($trim_chars > 0 && strlen($trim_this) > $trim_chars) {
			return substr($trim_this,0,($trim_chars-3)) . “…”;
		}
		return $trim_this;
	}


	// This utility method is not used by the main plugin.  It is as a
	// repair tool for stattraq data which may be incorrectly recorded
	// without an article_id, which means that the data can't show up
	// in the MostWanted output.
	//
	// If you've not hacked your stattraq plugin to fix this, then
	// a call to this method will repair all entries in your database.
    function fixstats($sleep = 1){
        global $wpdb, $tablestattraq, $tableposts;
        get_currentuserinfo();

        // calculate duration
        $output = $wpdb->get_results( "SELECT COUNT( DISTINCT (ID) ) as cnt FROM $wpdb->posts;" );
        foreach ($output as $line) {
            $duration = ($sleep * $line->cnt) /60;
        }
        _e("<p>MostWanted is now updating your stattraq database as a LOW_PRIORITY task.  This will probably take around " . $duration . " minutes.  Your previous statistics are being ever-so-slightly-repaired.  Every record of a post that was accessed using a permalink is having it's post id added to it.</p><ol>");
        _e("<p>This page shows the progress of that process.  If you wander off to another page, the process will continue in the background, but you won't know precicely when it's complete.</p>");
        $output = $wpdb->get_results( "SELECT id, post_name FROM $wpdb->posts where post_status = 'publish' ORDER BY id DESC;" );

        foreach ($output as $line) {
            $q = "SELECT count(*) from $tablestattraq WHERE (article_id = '0' and url like '%name=" . $line->post_name . "%');";
            $changes = $wpdb->get_var( $q );

				if ($changes > 0) {
	            $q = "UPDATE low_priority $tablestattraq SET article_id = '" . $line->id . "' WHERE (article_id = '0' and url like '%name=" . $line->post_name . "%');";
	            _e("<li class='active'><span class='name'>Converting " . $line->post_name);
   	         $o2 = $wpdb->get_results( $q );
					_e(" - $changes rows altered",'templatic');
		   
	 				if ($sleep > 0) {
					 	_e(" - sleeping for " . $sleep . " seconds");
					}
					_e("</span></li>",'templatic');
            	flush();
            	sleep($sleep);
				} else {
	            _e("<li>Skipping " . $line->post_name . " because no rows require update</li>");
				}
            ob_end_flush();
        }
        _e("</ol>",'templatic');
        _e("<h1>Finished!</h1>",'templatic');
       return;
    }
}
//add_action('wp_head', array('MostWanted', 'signature'));
add_action('admin_menu', array('MostWanted', 'config_page'));

/*  PLUGIN: MostWanted Plugin configuration -- END   */
// NOTE the ">" symbol in the following line must
// be the last character in the file - do not add
// any spaces, tabs or newlines after it, or you
// will get "header already sent" errors.
/*
Plugin Name: WP-PageNavi 
Plugin URI: http://www.lesterchan.net/portfolio/programming.php 
*/ 

function wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {

	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {
		$prelabel  = '<strong>&laquo;</strong>';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '<strong>&raquo;</strong>';
	}
	$half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(is_tag()) {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
		} elseif (!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);	
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
		}
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class='Navi'>";
			if ($paged >= ($pages_to_show-1)) {
				echo '<a href="'.str_replace('&paged','&amp;paged',get_pagenum_link()).'">&laquo;</a>';
			}
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong class='on'>$i</strong>";
					} else {
						echo ' <a href="'.str_replace('&paged','&amp;paged',get_pagenum_link($i)).'">'.$i.'</a> ';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
				echo '<a href="'.str_replace('&paged','&amp;paged',get_pagenum_link($max_page)).'">&raquo;</a>';
			}
			echo "</div> $after";
		}
	}
}

/* Use Noindex for sections specified in theme admin */

function ptthemes_noindex_head() {
    if ((is_category() && get_option('ptthemes_noindex_category')) ||
	    (is_tag() && get_option('ptthemes_noindex_tag')) ||
		(is_day() && get_option('ptthemes_noindex_daily')) ||
		(is_month() && get_option('ptthemes_noindex_monthly')) ||
		(is_year() && get_option('ptthemes_noindex_yearly')) ||
		(is_author() && get_option('ptthemes_noindex_author')) ||
		(is_search() && get_option('ptthemes_noindex_search'))) {

		$meta_string .= '<meta name="robots" content="noindex,follow" />';
	echo $meta_string;
	}	
}
add_action('wp_head', 'ptthemes_noindex_head');

/* ======================================================== NEW FUNCTIONS  START ==================================================== */
/* ======================== LOGO FUNCTION ======================= */
// Build the logo
// Child Theme Override: child_logo();

if (!function_exists('st_header' ))
	{
		function st_header() {
		  do_action('st_header');
		}
	}

/************************************
//FUNCTION NAME : templ_get_excerpt
//ARGUMENTS :string content, number of characters limit
//RETURNS : string with limit of number of characters
***************************************/
function templ_get_excerpt($finalstring, $limit='',$post_id='') {
	global $post;
	if(!$post_id)
	{
		$post_id=$post->ID;
	}
	$finalstring = strip_tags($finalstring);
	$read_more = stripslashes(get_option('ptthemes_content_excerpt_readmore'));
	$words = explode(" ",$finalstring);
	
	if ( count($words) >= $limit){
	if($read_more)
	{
		$read_more1 = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.$read_more.'</a>';
	}else
	{
		$read_more1 = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.READ_MORE_LABEL.'</a>';
	}
	}
	$read_more1 = apply_filters('templ_get_excerpt_readmore_filter',$read_more1);
	if($limit)
	{
		$words = explode(" ",$finalstring);
		if ( count($words) >= $limit)
			return apply_filters('templ_get_excerpt_filter',implode(" ",array_splice($words,0,$limit)).$read_more1);
		else
			return apply_filters('templ_get_excerpt_filter',$finalstring.$read_more1);
		
	}else
	{
		return apply_filters('templ_get_excerpt_filter',$finalstring.$read_more1);
	}
}
	
if ( !function_exists( 'st_logo' ) ) {

function st_logo() {
	if ( strtolower(get_option('ptthemes_show_blog_title')) == strtolower('Yes')):
		$class="text";
	else:
		if (get_option('ptthemes_logo_url')) {
			$class="logo-image";
		} else {
			$class="text";
		}
	endif;
	if(get_option('ptthemes_logo_url')){
		$logo = '<img alt="'.get_bloginfo('name').'" src="'.get_option('ptthemes_logo_url').'"/>';
	}else{
		$logo = get_bloginfo('name');
	}
	$st_logo  = '<a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo('name','display')).'">'.$logo.'</a>'. "\n";
	$desc = get_option('blogdescription');
	
	echo apply_filters ( 'child_logo' , $st_logo);
	if(@$desc){
		echo "<p class='blog-description'>".$desc."</p>";
	}
}
} // endif

add_action('st_header','st_logo', 3);

/* ================ FUNCTION TO SET LOGO HEIGHT ================= */
if ( !function_exists( 'logostyle' ) ) {

function logostyle() {
	if (get_option('ptthemes_logo_url')) {
	echo '<style type="text/css">
	#header .header_left .logo img {width: '.get_option('ptthemes_logo_width').'px;height: '.get_option('ptthemes_logo_height').'px;}</style>';
	}
}

} //endif

add_action('wp_head', 'logostyle');

/* ======================== END OF LOGO FUNCTION ======================= */

/* =========================== IMAGE FUNCTION ========================== */
function bdw_get_images($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	//$images =& get_children( 'post_type=attachment&post_mime_type=image' );
	//$videos =& get_children( 'post_type=attachment&post_mime_type=video/mp4' );
	
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				//$return_arr[] = '<img src="'.wp_get_attachment_url($id).'" alt="">';	// THE FULL SIZE IMAGE INSTEAD
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'medium')
			{
				//$return_arr[] = '<img src="'.wp_get_attachment_url($id, $size='medium').'" alt="">'; //THE medium SIZE IMAGE INSTEAD
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'thumb')
			{
				//$return_arr[] = '<img src="'.wp_get_attachment_thumb_url($id).'" alt="">'; // Get the thumbnail url for the attachment
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
				
			}
	   }
	  return $return_arr;
	}
}


/**	 function to get related posts START  **/
function get_related_posts($postdata,$my_post_type,$post_tags,$post_category) {
 
global $wp_query,$post;
$do_not_duplicate[] = $postdata->ID;
if(strtolower(get_option('ptthemes_related_listing_per')) == strtolower('Tags')){
$terms = wp_get_post_terms($postdata->ID, $post_tags, array("fields" => "names"));
$post_category = $post_tags;
}else{ 
$terms = wp_get_post_terms($postdata->ID, $post_category, array("fields" => "names"));
}
$relatedcats = get_the_terms( $postdata->ID,'eventcategory' );
foreach($relatedcats as $category) {
	$cat_term[] = $category->term_id;
}
if(is_array($terms[0])){
$terms = implode(',',$terms[0]);
}else{
$terms = $terms[0];
}
if(!empty($terms)){
	$count = get_option('ptthemes_related_event');
	if($count ==0 || $count == '')
		$count = 3;
	 $postQuery = array(
                        'post_type'                 => $my_post_type,
                        'post_status'               => 'publish',
                        'posts_per_page'            => $count,
						'meta_query' => array(
										'relation' => 'AND',
										array(
											'key' => 'event_type',
											'value' => 'Regular event',
											'compare' => '=',
											'type'=> 'text'
										)
									),
						'tax_query' => array(
						array(
							'taxonomy' => 'eventcategory',
							'field' => 'id',
							'terms' => implode(",",$cat_term),
							'operator'  => 'IN'
						)),
                        'orderby'                   => 'date',
                        'order'                     => 'DESC',
						'post__not_in' => array($postdata->ID)
                    );
        //query_posts($postQuery );
		$my_query = new wp_query($postQuery);
       if( $my_query->have_posts() ) { ?>
<div class="realated_post clearfix">  
            			
<h3><span><?php _e('Related Events','templatic');?></span></h3>
<ul class="category_grid_view clearfix">
			<?php $relatedprd_count = 0;
			$GLOBALS['comment'] = $comment;
            while ( $my_query->have_posts() ) : $my_query->the_post(); $do_not_duplicate[] = $postdata->ID; 
			$comment_count = @$post->comment_count; 
			$post_rel_img =  bdw_get_images_with_info(get_the_ID(),'thumb'); 
			$attachment_id = $post_rel_img[0]['id'];
			$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			$attach_data = get_post($attachment_id);
			$title = $attach_data->post_title;
			if($title ==''){ $title = @$post->post_title; }
			if($alt ==''){ $alt = @$post->post_title; } 
			$relatedprd_count++; 
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) , 'single-post-thumbnail'  );
			if($image[0] != '')
				$thumb = $image[0];
			elseif($post_rel_img[0]['file'] != '')
				$thumb = $post_rel_img[0]['file'];
			?>
            <li class="clearfix">
				<?php if($thumb){  ?>
				<a class="post_img" href="<?php echo get_permalink(get_the_ID());?>"><img  src="<?php echo $thumb;?>" alt="<?php $alt; ?>" title="<?php echo $title; ?>" width="112" height="75" /> </a>
				<?php 	}else{ ?>
				<a class="post_img" href="<?php echo get_permalink(get_the_ID());  ?>"><img src="<?php echo get_template_directory_uri()."/images/no-image.png"; ?>"  width="112" height="75" alt="<?php echo $post_img[0]['alt']; ?>" /></a>
				<?php } ?>
				<h3><a href="<?php echo get_permalink(get_the_ID());?>" > <?php the_title();?> </a></h3>
				<?php if(get_option('ptthemes_disable_rating') == 'No') {?>
                    <span class="rating">
                    <?php echo get_post_rating_star(get_the_ID());?>
				</span><?php } ?>
				<p class="review clearfix">
				<a href="<?php echo get_permalink(get_the_ID()); ?>#commentarea" class="pcomments" ><?php _e('Comments :','templatic'); ?></a>&nbsp;<?php echo $comment_count; ?>
			  </p>
				<p><?php echo templ_listing_content($post); ?></p>
            </li>

			<?php $count = get_option('ptthemes_related_event');
			if( $count != '' && $relatedprd_count == $count){
			break; ?>
			 <li class="hr"></li>
			<?php }	?>
            <?php endwhile; ?>
</ul>
</div>
<?php
        }
	}
}
/**	 function to get related posts END  **/

/*	Function for getting recent comments -- START	*/
function recent_comments($g_size = 30, $no_comments = 10, $comment_lenth = 60, $show_pass_post = false) {
        global $wpdb, $tablecomments, $tableposts,$rating_table_name;
		$tablecomments = $wpdb->comments;
		$tableposts = $wpdb->posts;
		$request = "SELECT ID, comment_ID, comment_content, comment_author,comment_post_ID, comment_author_email FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_status = 'publish' ";

        if(!$show_pass_post) { $request .= "AND post_password ='' "; }

        $request .= "AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT $no_comments";
        $comments = $wpdb->get_results($request);

        foreach ($comments as $comment) {
		$comment_id = $comment->comment_ID;
		$comment_content = strip_tags($comment->comment_content);
		$comment_excerpt = mb_substr($comment_content, 0, $comment_lenth)."";
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$comment_author_email = $comment->comment_author_email;
		$comment_post_ID = $comment->comment_post_ID;
		$post_title = get_the_title($comment_post_ID);
		$permalink = get_permalink($comment_post_ID);
		
   echo '<li class="clearfix">';
   echo "<span class=\"li".$comment_id."\">";
		if (function_exists('get_avatar')) {
					  if ('' == @$comment->comment_type) {
						  echo  '<a href="'.$permalink.'">';
						 echo get_avatar($comment->comment_author_email, 60, @$template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						 echo '</a>';
					  } elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
						 echo  '<a href="'.$permalink.'">';
						 echo get_avatar($comment->comment_author_url, 60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
					  }
				   } elseif (function_exists('gravatar')) {
					  echo  '<a href="'.$permalink.'">';
					  echo "<img src=\"";
					  if ('' == $comment->comment_type) {
						 echo gravatar($comment->comment_author_email,60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						  echo '</a>';
					  } elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
						echo  '<a href="'.$permalink.'">';
						echo gravatar($comment->comment_author_url,60, $template_path . ''.get_bloginfo('template_directory').'/images/gravatar2.png');
						 echo '</a>';
					  }
					  echo "\" alt=\"\" class=\"avatar\" />";
				   }
    echo "</span>\n";
    echo '' ;

           
 			echo  '<a href="'.$permalink.'">'.$post_title.'</a>';
			 $post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$comment_id\"");
			 echo '<br />'.draw_rating_star($post_rating);
			 
 			echo "<a class=\"comment_excerpt\" href=\"" . $permalink . "\" title=\"View the entire comment\">";
			echo $comment_excerpt;
			echo "</a>";
			
			echo '</li>';

	            }

}
/*	Function for getting recent comments -- END	*/

/*	Function to get excerpt	-- START	*/
function excerpt($limit=10) {
  $excerpt = explode(' ', get_the_excerpt(),$limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
/*	Function to get excerpt	-- END  */

/*	function to apply filter on contents  -- START  */
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  //$content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
/*	function to apply filter on contents  -- START  */
function is_user_can_add_event()
{
	global $current_user;
	//$current_user->ID
	return 1;	
}

/*	Function to getting currency symbol	-- START */
function get_currency_sym()
{
	global $wpdb;
	if(get_option('ptttheme_currency_symbol'))
	{
		return stripslashes(get_option('ptttheme_currency_symbol'));
	}else
	{
		return '$';
	}
}
/*	Function to getting currency symbol	-- END */

/*	Function for getting currency type whether its a USD or GBP or Rs. etc...	-- START */
function get_currency_type()
{
	global $wpdb;
	if(get_option('ptttheme_currency_code'))
	{
		return stripslashes(get_option('ptttheme_currency_code'));
	}else
	{
		return 'USD';
	}
	
}
/*	Function for getting currency type whether its a USD or GBP or Rs. etc...	-- END */

/*		Get the admin email ID	-- START	*/
function get_site_emailId()
{
	if(get_option('ptthemes_sender_email'))
	{
		return get_option('admin_email');
	}else
	{
		return get_option('admin_email');
	}
}
/*		Get the admin email ID	-- END	*/

/*		Get the email sender name / blog name	-- START	*/
function get_site_emailName()
{
	if(get_option('ptthemes_sender_name'))
	{
		return stripslashes(get_option('blogname'));
	}else
	{
		return stripslashes(get_option('blogname'));
	}
}
/*		Get the email sender name / blog name	-- END		*/


function is_allow_user_register()
{
	if(get_option('is_allow_user_add')!='')
	{
		return get_option('is_allow_user_add');
	}else
	{
		return 1;
	}
}
/*	Function for getting secure Url / normal Url -- START	*/
function get_ssl_normal_url($url,$pid='')
{
	if($pid)
	{
		return $url;
	}else
	{
		if(get_option('is_allow_ssl')=='0')
		{
		}else
		{
			$url = str_replace('http://','https://',$url);
		}
	}
	return $url;
}
/*	Function for getting secure Url / normal Url -- END	*/

/*	Function for getting billing information -- START	*/
function get_property_price_info($pro_type='')
{global $price_db_table_name,$wpdb;
	if($pro_type !="")
	{
		$subsql = " and pid=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array();
	if($priceinfo !="")
	{
		foreach($priceinfo as $priceinfoObj)
		{
			$info = array();
			$vper = $priceinfoObj->validity_per;
			$validity = $priceinfoObj->validity;
			if(($priceinfoObj->validity != "" || $priceinfoObj->validity != 0))
			{
				if($vper == 'M')
				{
					$tvalidity = $validity*30 ;
				}else if($vper == 'Y'){
					$tvalidity = $validity*365 ;
				}else{
					$tvalidity = $validity ;
				}
			}
		$info['title'] = $priceinfoObj->price_title;
		$info['price'] = $price;
		$info['days'] = $tvalidity;
		$info['alive_days'] =$tvalidity;
		$info['cat'] =$priceinfoObj->price_post_cat;
		$info['is_featured'] = $priceinfoObj->is_featured;
		$info['title_desc'] =$priceinfoObj->title_desc;
		$info['is_recurring'] =$priceinfoObj->is_recurring;
		if($priceinfoObj->is_recurring == '1') {
			$info['billing_num'] =$priceinfoObj->billing_num;
			$info['billing_per'] =$priceinfoObj->billing_per;
			$info['billing_cycle'] =$priceinfoObj->billing_cycle;
		}
		$price_info[] = $info;
		}
	}
	return $price_info;
}
/*	Function for getting billing information -- END	*/

/*	Function to get the payment options information -- START		*/
function get_payment_optins($method)
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
		foreach($paymentinfo as $paymentinfoObj)
		{
			$option_value = unserialize($paymentinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
			$optReturnarr = array();
			for($i=0;$i<count($paymentOpts);$i++)
			{
				$optReturnarr[$paymentOpts[$i]['fieldname']] = $paymentOpts[$i]['value'];
			}
			//echo "<pre>";print_r($optReturnarr);
			return $optReturnarr;
		}
	}
}
/*	Function to get the payment options information -- END		*/

/*		Function to get the status of the event -- START 	*/
function get_property_default_status()
{
	if(get_option('approve_status'))
	{
		if(get_option('approve_status') == 'Published')
			return 'publish';
		else
			return get_option('approve_status');
	}else
	{
		return 'publish';
	}
}
/*		Function to get the status of the event -- START 	*/

/*	Function to get the user's nice name -- START 	*/
function get_user_nice_name($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}
	//$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$uname));
	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}
/*	Function to get the user's nice name -- END 	*/

/*	Function for sending mail -- START		*/
function sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";

	@mail($toEmail, $subject, $message, $headers);
}
/*	Function for sending mail -- END	*/

/*	Function for gettting the physical path of the image -- START	*/
function get_image_phy_destination_path()
{	
	$today = getdate();
	if ($today['month'] == "January"){
	  $today['month'] = "01";
	}
	elseif ($today['month'] == "February"){
	  $today['month'] = "02";
	}
	elseif  ($today['month'] == "March"){
	  $today['month'] = "03";
	}
	elseif  ($today['month'] == "April"){
	  $today['month'] = "04";
	}
	elseif  ($today['month'] == "May"){
	  $today['month'] = "05";
	}
	elseif  ($today['month'] == "June"){
	  $today['month'] = "06";
	}
	elseif  ($today['month'] == "July"){
	  $today['month'] = "07";
	}
	elseif  ($today['month'] == "August"){
	  $today['month'] = "08";
	}
	elseif  ($today['month'] == "September"){
	  $today['month'] = "09";
	}
	elseif  ($today['month'] == "October"){
	  $today['month'] = "10";
	}
	elseif  ($today['month'] == "November"){
	  $today['month'] = "11";
	}
	elseif  ($today['month'] == "December"){
	  $today['month'] = "12";
	}
	global $upload_folder_path;
	$tmppath = $upload_folder_path;

	
	  $destination_path = ABSPATH . $tmppath.$today['year']."/".$today['month']."/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',$tmppath.$today['year']."/".$today['month']);
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	
	  return $destination_path;
	
}
/*	Function for gettting the physical path of the image -- END	*/


//This function would return paths of folder to which upload the image 
function get_image_phy_destination_path_user()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	$destination_path = ABSPATH . $tmppath."users/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',$tmppath."users");
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	 return $destination_path;	
}

/* function for getting the relatice path of the image -- START  */
function get_image_rel_destination_path_user()
{	
	global $upload_folder_path;
	$destination_path = get_option( 'home' ) ."/".$upload_folder_path."users/";
	  return $destination_path;
}
/* function for getting the relatice path of the image -- START  */


function get_image_rel_destination_path()
{
	$today = getdate();
	if ($today['month'] == "January"){
	  $today['month'] = "01";
	}
	elseif ($today['month'] == "February"){
	  $today['month'] = "02";
	}
	elseif  ($today['month'] == "March"){
	  $today['month'] = "03";
	}
	elseif  ($today['month'] == "April"){
	  $today['month'] = "04";
	}
	elseif  ($today['month'] == "May"){
	  $today['month'] = "05";
	}
	elseif  ($today['month'] == "June"){
	  $today['month'] = "06";
	}
	elseif  ($today['month'] == "July"){
	  $today['month'] = "07";
	}
	elseif  ($today['month'] == "August"){
	  $today['month'] = "08";
	}
	elseif  ($today['month'] == "September"){
	  $today['month'] = "09";
	}
	elseif  ($today['month'] == "October"){
	  $today['month'] = "10";
	}
	elseif  ($today['month'] == "November"){
	  $today['month'] = "11";
	}
	elseif  ($today['month'] == "December"){
	  $today['month'] = "12";
	}
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	global $blog_id;
	if($blog_id)
	{
		return $user_path = $today['year']."/".$today['month']."/";
	}else
	{
		return $user_path = get_option( 'home' ) ."/$tmppath".$today['year']."/".$today['month']."/";
	}
}

/*		Function for getting the temparary path of image uploaded -- START	*/
function get_image_tmp_phy_path()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	return $destination_path = ABSPATH . $tmppath."tmp/";
}
/*		Function for getting the temparary path of image uploaded -- START	*/


function move_original_image_file($src,$dest)
{
	copy($src, $dest);
	unlink($src);
	$dest = explode('/',$dest);
	$img_name = $dest[count($dest)-1];
	$img_name_arr = explode('.',$img_name);

	$my_post = array();
	$my_post['post_title'] = $img_name_arr[0];
	$my_post['guid'] = get_image_rel_destination_path().$img_name;
	return $my_post;
}
/*	Function for getting the meta path of the attechment image -- START		*/
function get_attached_file_meta_path($imagepath)
{
	$imagepath_arr = explode('/',$imagepath);
	$imagearr = array();
	for($i=0;$i<count($imagepath_arr);$i++)
	{
		$imagearr[] = $imagepath_arr[$i];
		if($imagepath_arr[$i] == 'uploads')
		{
			break;
		}
	}
	$imgpath_ini = implode('/',$imagearr);
	return str_replace($imgpath_ini.'/','',$imagepath);
}
/*	Function for getting the meta path of the attechment image -- START		*/


/*		Function to custom resize images -- START	*/
function image_resize_custom($src,$dest,$twidth,$theight)
{
	global $image_obj;
	// Get the image and create a thumbnail
	$img_arr = explode('.',$dest);
	$imgae_ext = strtolower($img_arr[count($img_arr)-1]);
	if($imgae_ext == 'jpg' || $imgae_ext == 'jpeg')
	{
		$img = imagecreatefromjpeg($src);
	}elseif($imgae_ext == 'gif')
	{
		$img = imagecreatefromgif($src);
	}
	elseif($imgae_ext == 'png')
	{
		$img = imagecreatefrompng($src);
	}
	
	if($img)
	{
		$width = imageSX($img);
		$height = imageSY($img);
	
		if (!$width || !$height) {
			echo "ERROR:Invalid width or height";
			exit(0);
		}
		
		if(($twidth<=0 || $theight<=0))
		{
			return false;
		}
		$image_obj->load($src);
		$image_obj->resize($twidth,$theight);
		$new_width = $image_obj->getWidth();
		$new_height = $image_obj->getHeight();
		$imgname_sub = '-'.$new_width.'X'. $new_height.'.'.$imgae_ext;
		$img_arr1 = explode('.',$dest);
		unset($img_arr1[count($img_arr1)-1]);
		$dest = implode('.',$img_arr1).$imgname_sub;
		$image_obj->save($dest);
		
		
		return array(
					'file' => basename( $dest ),
					'width' => $new_width,
					'height' => $new_height,
				);
	}else
	{
		return array();
	}
}
/*		Function to custom resize images -- END	*/
function get_author_info($aid)
{
	global $wpdb;
	$infosql = "select * from $wpdb->users where ID=$aid";
	$info = $wpdb->get_results($infosql);
	if($info)
	{
		return $info[0];
	}
}
/*		Function to custom resize images -- END	*/

/*		function to Set the event status -- START	*/
function set_property_status($pid,$status='publish')
{
	if($pid)
	{
		 global $wpdb;
		 $my_post = array();
		 $my_post['ID'] = $pid;
 		 $my_post['post_status'] = $status;
		 wp_update_post($my_post);
	
		//$wpdb->query("update $wpdb->posts set post_status=\"$status\" where ID=\"$pid\"");
	}
}
/*		function to Set the property status -- START	*/


function get_post_info($pid)
{
	global $wpdb;
	$productinfosql = "select ID,post_title,post_content from $wpdb->posts where ID=$pid";
	$productinfo = $wpdb->get_results($productinfosql);
	if($productinfo)
	{
		foreach($productinfo[0] as $key=>$val)
		{
			$productArray[$key] = $val; 
		}
	}
	return $productArray;
}
/*	Function for Getting the custom added size of image -- START	*/
function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'detail_page_image')
			{
				$img_arr = wp_get_attachment_image_src($id, 'detail_page_image'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
	   }
	  return $return_arr;
	}
}
/*	Function for Getting the custom added size of image -- END	*/

/*	function for getting event id name -- START		*/
function get_property_cat_id_name($postid='')
{
	global $wpdb;
	$bedcatid = get_cat_id_from_name(get_option('ptthemes_bedroomcategory'));
	$bedcatarr = getCategoryList($bedcatid);
	if($bedcatarr)
	{
		foreach($bedcatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$bed_catid_arr[] = $val['ID'];
				$bed_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}	
	$typecatid = get_cat_id_from_name(get_option('ptthemes_property_typecategory'));
	$typecatarr = getCategoryList($typecatid);
	if($typecatarr)
	{
		foreach($typecatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$type_catid_arr[] = $val['ID'];
				$type_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}	
	$loccatid = get_cat_id_from_name(get_option('ptthemes_locationcategory'));
	$loccatarr = getCategoryList($loccatid);
	if($loccatarr)
	{
		foreach($loccatarr as $key=>$val)
		{
			if($val['ID'])
			{
				$loc_catid_arr[] = $val['ID'];
				$loc_catname_arr[$val['ID']] = $val['name'];
			}
		}
	}
	$pn_categories_obj = $wpdb->get_var("SELECT GROUP_CONCAT(distinct($wpdb->terms.term_id)) as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms,  $wpdb->term_relationships
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->term_taxonomy.taxonomy = 'category'
								and $wpdb->term_relationships.term_taxonomy_id=$wpdb->term_taxonomy.term_taxonomy_id and $wpdb->term_relationships.object_id=\"$postid\"");
								
	$post_cats_arr = explode(',',$pn_categories_obj);
	if($post_cats_arr)
	{
		for($i=0;$i<count($post_cats_arr);$i++)
		{
			if($bed_catid_arr && in_array($post_cats_arr[$i],$bed_catid_arr))
			{
				$post_cat_info['bed'] = array('id'=>$post_cats_arr[$i],'name'=>$bed_catname_arr[$post_cats_arr[$i]]);
			}
			if($loc_catid_arr && in_array($post_cats_arr[$i],$loc_catid_arr))
			{
				$post_cat_info['location'] = array('id'=>$post_cats_arr[$i],'name'=>$loc_catname_arr[$post_cats_arr[$i]]);
			}

		}
	}
	return $post_cat_info;
}
/*	function for getting property id name -- END		*/

/*	Function for getting category id from name -- START  */
function get_cat_id_from_name($catname)
{
	global $wpdb;
	if($catname)
	{
	return $pn_categories_obj = $wpdb->get_var("SELECT $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->terms.name like \"$catname\"
                                AND $wpdb->term_taxonomy.taxonomy = 'eventcategory'");
	}
}
/*	Function for getting category id from name -- END  */

/*	Function that return the category list -- START  */
function getCategoryList( $parent = 0, $level = 0, $categories = 0, $page = 1, $per_page = 1000 ) 
{
	$count = 0;
	if ( empty($categories) ) 
	{
		$args = array('hide_empty' => 0,'orderby'=>'id');
			
		$categories = get_categories( $args );
		if ( empty($categories) )
			return false;
	}		
	$children = _get_term_hierarchy('category');
	return _cat_rows1( $parent, $level, $categories, $children, $page, $per_page, $count );
}
/*	Function that return the category list -- END  */

/*	Function to return the category lists -- START	*/
function _cat_rows1( $parent = 0, $level = 0, $categories, &$children, $page = 1, $per_page = 20, &$count )
{
	//global $category_array;
	$start = ($page - 1) * $per_page;
	$end = $start + $per_page;
	ob_start();

	foreach ( $categories as $key => $category ) 
	{
		if ( $count >= $end )
			break;

		$_GET['s']='';
		if ( $category->parent != $parent && empty($_GET['s']) )
			continue;

		// If the page starts in a subtree, print the parents.
		if ( $count == $start && $category->parent > 0 ) {
			$my_parents = array();
			$p = $category->parent;
			while ( $p ) {
				$my_parent = get_category( $p );
				$my_parents[] = $my_parent;
				if ( $my_parent->parent == 0 )
					break;
				$p = $my_parent->parent;
			}

			$num_parents = count($my_parents);
			while( $my_parent = array_pop($my_parents) ) {
				$category_array[] = _cat_rows1( $my_parent, $level - $num_parents );
				$num_parents--;
			}
		}

		if ($count >= $start)
		{
			$categoryinfo = array();
			$category = get_category( $category, '', '' );
			$default_cat_id = (int) get_option( 'default_category' );
			$pad = str_repeat( '&#8212; ', max(0, $level) );
			$name = ( $name_override ? $name_override : $pad . ' ' . $category->name );
			$categoryinfo['ID'] = $category->term_id;
			$categoryinfo['name'] = $name;
			$category_array[] = $categoryinfo;
		}

		unset( $categories[ $key ] );
		$count++;
		if ( isset($children[$category->term_id]) )
			_cat_rows1( $category->term_id, $level + 1, $categories, $children, $page, $per_page, $count );
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $category_array;
}
/*	Function to return the category lists -- END	*/

/*	Function for getting sub category list -- START 	*/
function get_blog_sub_cats_str($type='array')
{
	$catid_arr = get_option('ptthemes_blogcategory');
	$blogcatids = '';
	$subcatids_arr = array();
	for($i=0;$i<count($catid_arr);$i++)
	{
		if($catid_arr[$i])
		{
			$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
		}
	}
	if($subcatids_arr && $type=='string')
	{
		$blogcatids = implode(',',$subcatids_arr);
		return $blogcatids;	
	}else
	{
		return $subcatids_arr;
	}			
}
/*	Function for getting sub category list -- END 	*/

/*	Add the custom image size -- START  */
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(588, 250, true); // Normal post thumbnails
	add_image_size('loopThumb', 588, 125, true);
}
/*	Add the custom image size -- END  */

/*	Function for getting payable amounts with discount -- START 	*/
function get_payable_amount_with_coupon($total_amt,$coupon_code)
{
	$discount_amt = get_discount_amount($coupon_code,$total_amt);
	if($discount_amt>0)
	{
		return $total_amt-$discount_amt;
	}else
	{
		return $total_amt;
	}
}
/*	Function for getting payable amounts with discount -- END 	*/

/*	Function for checking whether the coupon is valid or not -- START	*/
function is_valid_coupon($coupon)
{
	global $wpdb;
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
			foreach($option_value as $key=>$value)
			{
				if($value['couponcode'] == $coupon)
				{
					return true;
				}
			}
		}
	}
	return false;
}
/*	Function for checking whether the coupon is valid or not -- END	*/

/* Function for gettiong the discount ammont -- START */
function get_discount_amount($coupon,$amount)
{
	global $wpdb;
	if($coupon!='' && $amount>0)
	{
		$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
		$couponinfo = $wpdb->get_results($couponsql);
		if($couponinfo)
		{
			foreach($couponinfo as $couponinfoObj)
			{
				$option_value = unserialize($couponinfoObj->option_value);
				foreach($option_value as $key=>$value)
				{
					if($value['couponcode'] == $coupon)
					{
						if($value['dis_per']=='per')
						{
							$discount_amt = ($amount*$value['dis_amt'])/100;
						}else
						if($value['dis_per']=='amt')
						{
							$discount_amt = $value['dis_amt'];
						}
					}
				}
			}
			return $discount_amt;
		}
	}
	return '0';			
}
/* Function for gettiong the discount ammont -- END */

/*	Function for getting the difference between time -- START	*/
function get_time_difference( $start, $pid )
{
	$alive_days = get_post_meta($pid,'alive_days',true);
	$uts['start']      =    strtotime( $start );
	$uts['end']        =    mktime(0,0,0,date('m',strtotime($start)),date('d',strtotime($start))+$alive_days,date('Y',strtotime($start)));

	$post_days = gregoriantojd(date('m'), date('d'), date('Y')) - gregoriantojd(date('m',strtotime($start)), date('d',strtotime($start)), date('Y',strtotime($start)));
	$days = $alive_days-$post_days;

	if($days>0)
	{
		return $days;	
	}
    return( false );
}
/*	Function for getting the difference between time -- END	*/

/*	Function to get the image cutting edge -- START	 */
function get_image_cutting_edge($args=array())
{
	if(@$args['image_cut'])
	{
		$cut_post =$args['image_cut'];
	}else
	{
		$cut_post = get_option('ptthemes_image_x_cut');
	}
	if($cut_post)
	{		
		if($cut_post=='top')
		{
			$thumb_url .= "&amp;a=t";	
		}elseif($cut_post=='bottom')
		{
			$thumb_url .= "&amp;a=b";	
		}elseif($cut_post=='left')
		{
			$thumb_url .= "&amp;a=l";
		}elseif($cut_post=='right')
		{
			$thumb_url .= "&amp;a=r";
		}elseif($cut_post=='top right')
		{
			$thumb_url .= "&amp;a=tr";
		}elseif($cut_post=='top left')
		{
			$thumb_url .= "&amp;a=tl";
		}elseif($cut_post=='bottom right')
		{
			$thumb_url .= "&amp;a=br";
		}elseif($cut_post=='bottom left')
		{
			$thumb_url .= "&amp;a=bl";
		}
	}
	return @$thumb_url;
}
/*	Function to get the image cutting edge -- START	 */

function get_category_dl_options($selected)
{
		$cat_args = array('name' => 'scat', 'id' => 'scat', 'selected' => $selected, 'class' => 'select', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
		$cat_args['show_option_none'] = __('Select Category','templatic');
		return wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
}

/*	Function to get the total number of events -- START	 */
function  get_total_events_count()
{
	global $wpdb;
	return $wpdb->get_var("select count(ID) from $wpdb->posts where post_type='".CUSTOM_POST_TYPE1."' and post_status='publish'");
}
/*	Function to get the total number of events -- START	 */

/*	Function to get the content of the post --  START	*/
function get_the_post_content($type='listing_li',$file='')
{
	if($file)
	{
		include($file);	
	}elseif($type=='listing_li')
	{
		include(TEMPLATEPATH . '/library/includes/listing_li_content.php');
	}elseif($type=='author_listing_li')
	{
		include(TEMPLATEPATH . '/library/includes/author_listing_li_content.php');
	}			
}
/*	Function to get the content of the post --  START	*/


function get_formated_date($date)
{
	return mysql2date(get_option('date_format'), $date);
}
function get_formated_time($time)
{
	return mysql2date(get_option('time_format'), $time, $translate=true);;
}

function get_add_to_calender($args=array('outlook'=>1,'google_calender'=>1,'yahoo_calender'=>1,'ical_cal'=>1))
{
	global $post;
	if($args)
	{
		$icalurl = get_event_ical_info($post->ID);
?>
<div class="i_addtocalendar"> <a href="#"><?php _e('Add to my calendar','templatic');?></a> 
<div class="addtocalendar">
<ul>
<?php if($args['outlook']){?><li class="i_calendar"><a href="<?php echo $icalurl['ical']; ?>"> <?php _e('Outlook Calendar','templatic');?></a> </li><?php }?>
<?php if($args['google_calender']){?><li class="i_google"><a href="<?php echo $icalurl['google']; ?>" target="_blank"> <?php _e('Google Calendar','templatic');?> </a> </li><?php }?>
<?php if($args['yahoo_calender']){?><li class="i_yahoo"><a href="<?php echo $icalurl['yahoo']; ?>" target="_blank"><?php _e('Yahoo! Calendar','templatic');?></a> </li><?php }?>
<?php if($args['ical_cal']){?><li class="i_calendar"><a href="<?php echo $icalurl['ical']; ?>"> <?php _e('iCal Calendar','templatic');?> </a> </li><?php }?>
</ul>
</div>
</div>
<?php
	}
}

/*	Function to get the events info on calander -- START	*/
function get_event_ical_info($post_id) {
	require_once(TEMPLATEPATH.'/library/ical/iCalcreator.class.php');
	$cal_post = get_post($post_id);
	if ($cal_post) {
		$location = get_post_meta($post_id,'address',true);
		$start_year = date('Y',strtotime(get_post_meta($post_id,'st_date',true)));
		$start_month = date('m',strtotime(get_post_meta($post_id,'st_date',true)));
		$start_day = date('d',strtotime(get_post_meta($post_id,'st_date',true)));
		
		$end_year = date('Y',strtotime(get_post_meta($post_id,'end_date',true)));
		$end_month = date('m',strtotime(get_post_meta($post_id,'end_date',true)));
		$end_day = date('d',strtotime(get_post_meta($post_id,'end_date',true)));
		
		$start_time = get_post_meta($post_id,'st_time',true);
		$end_time = get_post_meta($post_id,'end_time',true);
		if (($start_time != '') && ($start_time != ':')) { $event_start_time = explode(":",$start_time); }
		if (($end_time != '') && ($end_time != ':')) { $event_end_time = explode(":",$end_time); }
		
		$post_title = get_the_title($post_id);
		$v = new vcalendar();                          
		$e = new vevent();  
		$e->setProperty( 'categories' , 'Events' );                   
		
		if (isset( $event_start_time)) { @$e->setProperty( 'dtstart' 	,  @$start_year, @$start_month, @$start_day, @$event_start_time[0], @$event_start_time[1], 00 ); } else { $e->setProperty( 'dtstart' ,  $start_year, $start_month, $start_day ); } // YY MM dd hh mm ss
		if (isset($event_end_time)) { @$e->setProperty( 'dtend'   	,  $end_year, $end_month, $end_day, $event_end_time[0], $event_end_time[1], 00 );  } else { $e->setProperty( 'dtend' , $end_year, $end_month, $end_day );  } // YY MM dd hh mm ss
		$e->setProperty( 'description' 	, strip_tags($cal_post->post_excerpt) ); 
		if (isset($location)) { $e->setProperty( 'location'	, $location ); } 
		$e->setProperty( 'summary'	, $post_title );                 
		$v->addComponent( $e );                        
	
		$templateurl = get_bloginfo('template_url').'/cache/';
		$home = get_bloginfo('url');
		$dir = str_replace($home,'',$templateurl);
		$dir = str_replace('/wp-content/','wp-content/',$dir);
		
		$v->setConfig( 'directory', $dir ); 
		$v->setConfig( 'filename', 'event-'.$post_id.'.ics' ); 
		$v->saveCalendar(); 
		////OUT LOOK & iCAL URL//
		$output['ical'] = $templateurl.'event-'.$post_id.'.ics';
		////GOOGLE URL//
		$google_url = "http://www.google.com/calendar/event?action=TEMPLATE";
		$google_url .= "&text=".urlencode($post_title);
		if (isset($event_start_time) && isset($event_end_time)) { 
			$google_url .= "&dates=".@$start_year.@$start_month.@$start_day."T".str_replace('.','',@$event_start_time[0]).str_replace('.','',@$event_start_time[1])."00/".@$end_year.@$end_month.@$end_day."T".str_replace('.','',@$event_end_time[0]).str_replace('.','',@$event_end_time[1])."00"; 

		} else { 
			$google_url .= "&dates=".$start_year.$start_month.$start_day."/".$end_year.$end_month.$end_day; 
		}
		$google_url .= "&sprop=website:".$home;
		$google_url .= "&details=".strip_tags($cal_post->post_excerpt);
		if (isset($location)) { $google_url .= "&location=".$location; } else { $google_url .= "&location=Unknown"; }
		$google_url .= "&trp=true";
		$output['google'] = $google_url;
		////YAHOO URL///
		$yahoo_url = "http://calendar.yahoo.com/?v=60&view=d&type=20";
		$yahoo_url .= "&title=".str_replace(' ','+',$post_title);
		if (isset($event_start_time)) 
		{ 
			$yahoo_url .= "&st=".@$start_year.@$start_month.@$start_day."T".@$event_start_time[0].@$event_start_time[1]."00"; 
		}
		else
		{ 
			$yahoo_url .= "&st=".$start_year.$start_month.$start_day;
		}
		if(isset($event_end_time))
		{
			//$yahoo_url .= "&dur=".$event_start_time[0].$event_start_time[1];
		}
		$yahoo_url .= "&desc=".__('For+details,+link+').get_permalink($post_id).' - '.str_replace(' ','+',strip_tags($cal_post->post_excerpt));
		$yahoo_url .= "&in_loc=".str_replace(' ','+',$location);
		$output['yahoo'] = $yahoo_url;
	}
	return $output;
} 
/*	Function to get the events info on calander -- END	*/


/*	Function to display post on listing page -- START	*/
function show_on_listing($post_type,$post_id)
{
global $wpdb;
$result ="";
	$result .= "<p>
			<table width='100%' border='0' cellpadding='0' cellspacing='0'>";
				global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".$post_type."' ) and show_on_listing = 1";
				if(@$fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				$i = 1;
				$y = 0;
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
						if(get_post_meta($post_id,$post_meta_info_obj->htmlvar_name,true) != "" ){
							{
								 if($y == 0):
//						 			$result .= "<h2 class='home'>".EVENT_CUSTOM_INFORMATION."</h2>";
									$y = 1;
								 endif;
								 if($i%2 == 0){$result .="<tr>";} $result .="<td>";
                                    if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
                                        $result .= "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post_id,$post_meta_info_obj->htmlvar_name,true)."</div>";
                                    } else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = get_post_meta($post_id,$post_meta_info_obj->htmlvar_name,true);
											$check = "";
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											$result .= "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>".$check."</div>";
										else:
                                        	$result .= "<div class='i_customlable'><span>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post_id,$post_meta_info_obj->htmlvar_name,true)."</div>";
										endif;	
                                    } 
						}
					$result .= "</td>";  $i++;
					 }	
					 }
		}$result .="</table></p>";
		return $result;
}
/*	Function to display post on listing page -- START	*/

/* ======================================= FUNCTION TO ADD META BOXES FOR CLAIM OWNERSHIP =========================== */
//Claim ownership to Edit Event in back end

if(get_option('ptthemes_enable_claim') =='Yes')
{
	add_action("admin_init", "admin_init");
}
	
function admin_init()
{
	add_meta_box("Claim post", "Claim post", "meta_options", CUSTOM_POST_TYPE1, "side", "high");
}
if(isset($_REQUEST['poid']) && $_REQUEST['poid'] != "")
	{
		global $wpdb,$post;
		$claim_db_table_name = $wpdb->prefix."claim_ownership";
	  	$vclid = $_REQUEST['poid'];
		$wpdb->query("Delete from $claim_db_table_name where clid = '".$vclid."'");
		delete_post_meta($post->ID,'is_verified',0);
	}
function meta_options()
{
	global $wpdb,$post,$claim_db_table_name;

	if(@$_REQUEST['verified'] == 'yes')
	{	
		$clid = $_REQUEST['user_id'];
		$wpdb->query("Update $claim_db_table_name set status ='1' where user_id = '".$clid."'");
		update_post_meta($post->ID,'is_verified',1);
		$event_type = get_post_meta($post->ID,'event_type',true);
		$event_id = $post->ID;
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring Event')))
		{
			$fetch_status = 'recurring';
			/* to delete the old recurrences BOF */
			$args =	array( 
						'post_type' => 'event',
						'posts_per_page' => -1	,
						'post_status' => array($fetch_status),
						'meta_query' => array(
						'relation' => 'AND',
							array(
									'key' => '_event_id',
									'value' => $event_id,
									'compare' => '=',
									'type'=> 'text'
								),
							)
						);
			$post_query = null;
			$post_query = new WP_Query($args);
			
			if($post_query){
				while ($post_query->have_posts()) : $post_query->the_post();
						update_post_meta($post->ID,'is_verified',1);
				endwhile;
				wp_reset_query();
			}
		}
	}else if(@$_REQUEST['verified'] == 'no'){
		$clid = $_REQUEST['clid'];
		$wpdb->query("DELETE FROM $claim_db_table_name where clid = '".$clid."'");
		update_post_meta($post->ID,'is_verified',0);
		$event_type = get_post_meta($post->ID,'event_type',true);
		$event_id = $post->ID;
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring Event')))
		{
			$fetch_status = 'recurring';
			/* to delete the old recurrences BOF */
			$args =	array( 
						'post_type' => 'event',
						'posts_per_page' => -1	,
						'post_status' => array($fetch_status),
						'meta_query' => array(
						'relation' => 'AND',
							array(
									'key' => '_event_id',
									'value' => $event_id,
									'compare' => '=',
									'type'=> 'text'
								),
							)
						);
			$post_query = null;
			$post_query = new WP_Query($args);
			
			if($post_query){
				while ($post_query->have_posts()) : $post_query->the_post();
						update_post_meta($post->ID,'is_verified',0);
				endwhile;
				wp_reset_query();
			}
		}
	}
	if(@$_REQUEST['vpid'] == 1)
	{
		$wpdb->query("INSERT INTO $claim_db_table_name(`clid`, `post_id`, `post_title`, `user_id`, `full_name`, `your_email`, `contact_number`, `your_position`, `author_id`,`status`, `comments`) VALUES (NULL, '".$post->ID."', '".$post->post_title."', '', '', '', '', '', '".$post->post_author."', '1', '')");
		update_post_meta($post->ID,'is_verified',1);
	}
	$claimreq = $wpdb->get_row("select * from $claim_db_table_name where post_id = '".$post->ID."' ");
	if(count($claimreq) > 0 && get_post_meta($post->ID,'is_verified',true) == '1')
	{ ?>
	<h4><img src="<?php echo get_template_directory_uri(); ?>/images/verified.png" alt="<?php echo YES_VERIFIED;?>" border="0" align="middle" style="position:relative; top:-4px; margin-right:5px;" /> <?php echo POST_VERIFIED_TEXT; ?></h4>
	<a href="<?php echo home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&verified=no&clid='.$claimreq->clid;?>" title="<?php echo REMOVE_CLAIM_REQUEST; ?>"><?php echo REMOVE_CLAIM_REQUEST; ?></a>
	<?php }
	elseif(count($claimreq) > 0)
	{
	echo "<p>" . NO_CLAIM . "<p/>"; ?>
	<a href="<?php echo home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&verified=yes&user_id='.$claimreq->user_id;?>" title="<?php echo CLAIM_THIS; ?>">
    <img src="<?php echo get_template_directory_uri(); ?>/images/accept.png" alt="<?php echo VERIFY_THIS; ?>" border="0" style="position:relative; top:-4px; margin-right:10px; float:left;" />  <strong><?php echo VERIFY_THIS.__(' for ','templatic').get_userdata($claimreq->user_id)->display_name; ?></strong></a>
	<?php }
	else
	{
	echo "<p>" . NO_CLAIM . "<p/>"; ?>
	<a href="<?php echo home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&verified=yes&vpid=1&user_id='.$claimreq->user_id;?>" title="<?php echo CLAIM_THIS; ?>">
    <img src="<?php echo get_template_directory_uri(); ?>/images/accept.png" alt="<?php echo VERIFY_THIS; ?>" border="0" style="position:relative; top:-4px; margin-right:10px; float:left;" />  <strong><?php echo VERIFY_THIS; ?></strong></a>
	<?php }
	}
	global $current_user;
	if(isset($current_user) && $current_user != "")
	{
		if(is_super_admin($current_user->ID))
		{
			add_action('wp_dashboard_setup', 'claim_ownership_widgets' );
		}
	}

/*	Function to get the recent events on dashboard -- START	 */	
function recent_events_dashboard_widgets()
{
	global $current_user;
	if(is_super_admin($current_user->ID))
	{
		wp_add_dashboard_widget('claim_ownership_widgets', RECENT_EVENTS_TEXT, 'recent_events_dashboard_widget');
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$example_widget_backup = array('claim_ownership_widgets' => $normal_dashboard['claim_ownership_widgets']);
		unset($normal_dashboard['claim_ownership_widgets']);
		$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
}

add_action('wp_dashboard_setup', 'recent_events_dashboard_widgets' );



function recent_events_dashboard_widget()
{ ?>
<script type="text/javascript">
function change_poststatus(str)
{ 
	if (str=="")
	  {
	  document.getElementById("p_status_"+str).innerHTML="";
	  return;
	  }
	  if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("p_status_"+str).innerHTML=xmlhttp.responseText;
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/library/functions/ajax_update_status.php?post_id="+str
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
}
</script>
<?php
	$event_args = array('post_status'=>'draft,publish','post_type' => CUSTOM_POST_TYPE1,'order'=>'DESC');
	$recent_events = get_posts( $event_args );

	if($recent_events){
		echo '<table class="widefat"  width="100%" >
			<thead>	';
		$th='	<tr>
				<th valign="top" align="left">'.__('ID','templatic').'</th>
				<th valign="top" align="left">'.__('Event title','templatic').'</th>
				<th valign="top" align="left">'.__('Address','templatic').'</th>
				<th valign="top" align="left">'.__('Duration','templatic').'</th>
				<th valign="top" align="left">'.__('Paid amount','templatic').'</th>
				<th valign="top" align="left">'.__('Alive days','templatic').'</th>
				<th valign="top" align="left">'.__('Status','templatic').'</th>';
		
		$th .=	'</tr>';   
		echo $th;
		foreach($recent_events as $event) {
			echo '<tr>
				<td valign="top" align="left">'.$event->ID.'</td>
				<td valign="top" align="left"><a href="'.home_url().'/wp-admin/post.php?post='.$event->ID.'&action=edit">'.$event->post_title.'</a></td>
				<td valign="top" align="left">'.get_post_meta($event->ID,'address',true).'</td>';
			if(get_post_meta($event->ID,'st_date',true) !="" && get_post_meta($event->ID,'st_time',true) !="")	{
			echo '<td valign="top" align="left">'.get_post_meta($event->ID,'st_date',true).' '.get_post_meta($event->ID,'st_time',true).' <strong>to</strong> '.get_post_meta($event->ID,'end_date',true).' '.get_post_meta($event->ID,'end_time',true).'</td>';
			}else{
			echo '<td valign="top" align="left">'.get_post_meta($event->ID,'end_date',true).'-'.get_post_meta($event->ID,'end_time',true).'</td>';
			}
			echo '<td valign="top" align="left">';
				if(get_post_meta($event->ID,'paid_amount',true)) { echo display_amount_with_currency(get_post_meta($event->ID,'paid_amount',true));} else { echo display_amount_with_currency('0'); } echo '</td>
				<td valign="top" align="left">';
				if(get_post_meta($event->ID,'alive_days',true)) { echo get_post_meta($event->ID,'alive_days',true);} else { echo '0';} echo '</td>';
			if(get_post_status($event->ID) =='draft'){
			echo '<td valign="top" align="left" id="p_status_'.$event->ID.'"><a href="javascript:void(0);" onclick="change_poststatus('.$event->ID.')"  style="color:#E66F00">Pending</a></td>';
			}else if(get_post_status($event->ID) =='publish'){
			echo '<td valign="top" align="left" style="color:green" id="p_status_'.$event->ID.'">'.PUBLISHED_TEXT.'</td>';
            }
			echo '</tr>';
			
			} 
		echo '</thead>	</table>';	
	} else {
		_e('No recent event available','templatic');
	}
}
/*	Function to get the recent events on dashboard -- END	 */	

/*******
 Create the function to output the contents of our claim ownership Dashboard Widget BOF
 *****/
 function call_widget_js()
 {
 	wp_enqueue_script('script', get_template_directory_uri() .'/js/widget.js', 'jquery', false); 
 }
 add_action('admin_init', 'call_widget_js', 1);
	function claimownership_dashboard_widget_function() { 
	if((!isset($_REQUEST['dummy']) && $_REQUEST['dummy']=='') && (!isset($_REQUEST['dummy_insert']) && $_REQUEST['dummy_insert']=='') && strstr($_SERVER['REQUEST_URI'],'/wp-admin/')) { ?>
	<script type="text/javascript">
	/* <![CDATA[ */
	function confirmSubmit(str) {
			var answer = confirm("<?php echo DELETE_CONFIRM_ALERT; ?>");
			if (answer){
				window.location = "<?php echo home_url(); ?>/wp-admin/index.php?poid="+str;
				alert('<?php echo ENTRY_DELETED; ?>');
			}
		}
	/* ]]> */
	</script>
	<?php } 
	global $wpdb,$claim_db_table_name ;
	
	$claimreq = $wpdb->get_results("select * from $claim_db_table_name where status = '0'");
	echo "<table class='widefat'>
	<tr>
			<th>".ID_TEXT."</th>
			<th>".TITLE_TEXT."</th>
			<th>".AUTHOR_NAME_TEXT."</th>
			<th>".CLAIMER_TEXT."</th>
			<th>".CONTACT_NUM_TEXT."</th>
			<th>".ACTION_TEXT."</th></tr>";
	if(mysql_affected_rows() > 0)
	{	$counter =0;
		foreach($claimreq as $cro)
		{
			$udata = get_userdata($cro->author_id);
			echo "<tr><td>".$cro->post_id."</td>
			<td>".$cro->post_title."</td>
			<td>".$udata->user_login."</td>
			<td>".$cro->full_name."</td>
			<td>".$cro->contact_number."</td>
			<td>"; ?>
			 <a href="javascript:void(0);claimer_showdetail('<?php echo $cro->clid;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Details','templatic');?>" title="<?php _e('Detail','templatic');?>" border="0" /></a> &nbsp;&nbsp; 
			<a href="<?php echo home_url().'/wp-admin/post.php?post='.$cro->post_id.'&action=edit&verified=yes&clid='.$cro->clid ;?>" title="<?php _e('Verify this post','templatic');?>"><img style="width:16px; height:16px;" src="<?php echo get_template_directory_uri(); ?>/images/accept.png" alt="<?php _e('Verify','templatic');?>" border="0" /></a> &nbsp;&nbsp;
			<a href="<?php echo home_url().'/wp-admin/post.php?post='.$cro->post_id.'&action=edit';?>" title="<?php _e('View post','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/view.png" alt="<?php _e('View','templatic');?>" border="0" /></a> &nbsp;&nbsp; 
			<a href="javascript:void(0);" onclick="return confirmSubmit(<?php echo $cro->clid; ?>);" title="<?php _e('Delete','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete this request','templatic');?>" border="0" /></a>
		<?php	echo "</td>
			</tr>"; ?>
			<tr id='<?php echo "comments_".$cro->clid; ?>' style='display:none; padding:5px;'><td colspan="7"><?php echo $cro->comments; ?> </td></tr>
		<?php 
		$c = $counter ++;
		}
	}else{
		echo "<tr><td colspan='6'>No claim request</td></tr>";
	}
	echo "</table>";
	} 
	/* Create the function to output the contents of our claim ownership Dashboard Widget EOF */
	/* to display widget */
	function claim_ownership_widgets() { 
		
		wp_add_dashboard_widget('claim_dashboard_widget', 'Ownership claims', 'claimownership_dashboard_widget_function');
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$example_widget_backup = array('claim_dashboard_widget' => $normal_dashboard['claim_dashboard_widget']);
		unset($normal_dashboard['claim_dashboard_widget']);
		$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
	
function add_to_attend_event($post_id,$st_date='',$end_date='')
{
	global $current_user;
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID,'user_attend_event',true);
	$user_meta_data[]=$post_id;
	update_user_meta($current_user->ID, 'user_attend_event', $user_meta_data);
	if($st_date)
	{
		$user_meta_start_date = array();
		$user_meta_start_date = get_user_meta($current_user->ID,'user_attend_event_st_date',true);
		$user_meta_start_date[]=$post_id."_".$st_date;
		update_user_meta($current_user->ID, 'user_attend_event_st_date', $user_meta_start_date);
	}
	if($end_date)
	{
		$user_meta_end_date = array();
		$user_meta_end_date = get_user_meta($current_user->ID,'user_attend_event_end_date',true);
		$user_meta_end_date[]=$post_id."_".$end_date;
		update_user_meta($current_user->ID, 'user_attend_event_end_date', $user_meta_end_date);
	}
	
	$user_meta_data = get_user_meta($current_user->ID,'user_attend_event',true);
	$user_attend_event_start_date = get_user_meta($current_user->ID,'user_attend_event_st_date',true);	
	$user_attend_event_end_date = get_user_meta($current_user->ID,'user_attend_event_end_date',true);
	$a .= get_avatar($current_user->user_email,35,35);	
	
	if(!$st_date)
	{
		echo '<span class="span_msg"><a href="'.get_author_posts_url($current_user->ID).'">'.$current_user->display_name."</a> ,".REMOVE_EVENT_MSG." ".get_the_title($post_id).". ".'</span>		
		<a href="javascript:void(0);" class="addtofav b_review" onclick="javascript:addToAttendEvent(\''.$post_id.'\',\'remove\');">'.REMOVE_EVENT_TEXT.'</a><span id="attended_persons" class="attended_persons">'.event_atended_persons($post_id).'</span>';exit;	
		}
	elseif($user_meta_data && in_array($post_id,$user_meta_data,true) && in_array($post_id."_".$st_date,$user_attend_event_start_date,true) && in_array($post_id."_".$end_date,$user_attend_event_end_date,true))
	{
		echo '<span class="span_msg"><a href="'.get_author_posts_url($current_user->ID).'">'.$current_user->display_name."</a> ,".REMOVE_EVENT_MSG." ".get_the_title($post_id).". ".'</span>		
		<a href="javascript:void(0);" class="addtofav b_review" onclick="javascript:addToAttendEvent(\''.$post_id.'\',\'remove\',\''.$st_date.'\',\''.$end_date.'\');">'.REMOVE_EVENT_TEXT.'</a><span id="attended_persons" class="attended_persons">'.event_attend_recurring_event_persons($post_id).'</span>';exit;	
	}
}
//This function would remove the favorited property earlier
function remove_from_attend_event($post_id,$st_date='',$end_date='')
{
	global $current_user;
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID,'user_attend_event',true);
	if(in_array($post_id,$user_meta_data))
	{
		$i = 0;
		$user_new_data = array();
		foreach($user_meta_data as $key => $value)
		{
			
			if($post_id == $value && $i == 0)
			{
				$value= '';
				$i++;
			}else{
				$user_new_data[] = $value;
			}
		}	
		$user_meta_data	= $user_new_data;
	}
	update_user_meta($current_user->ID, 'user_attend_event', $user_meta_data);
	
	$user_attend_event_st_date = array();
	$user_attend_event_st_date = get_user_meta($current_user->ID,'user_attend_event_st_date',true);
	
	if($st_date)
	{
	if(in_array($post_id."_".$st_date,$user_attend_event_st_date))
	{
		$user_new_data = array();
		foreach($user_attend_event_st_date as $key => $value)
		{
			if($post_id."_".$st_date == $value)
			{
				$value= '';
			}else{
				$user_new_data[] = $value;
			}
		}
		$user_attend_event_st_date	= $user_new_data;
	}
	update_user_meta($current_user->ID, 'user_attend_event_st_date', $user_attend_event_st_date);
	
	$user_attend_event_end_date = array();
	$user_attend_event_end_date = get_user_meta($current_user->ID,'user_attend_event_end_date',true);
	if(in_array($post_id."_".$end_date,$user_attend_event_end_date))
	{
		$user_new_data = array();
		foreach($user_attend_event_end_date as $key => $value)
		{
			if($post_id."_".$end_date == $value)
			{
				$value= '';
			}else{
				$user_new_data[] = $value;
			}
		}	
		$user_attend_event_end_date	= $user_new_data;
	}
	update_user_meta($current_user->ID, 'user_attend_event_end_date', $user_attend_event_end_date);
	}
	if(!$st_date)
	{
		echo '<span class="span_msg"><a href="'.get_author_posts_url($current_user->ID).'">'.$current_user->display_name.'</a> ,'.ATTEND_EVENT_MSG.' '.get_the_title($post_id).' ?</span>		
		<a class="addtofav b_review" href="javascript:void(0);"  onclick="javascript:addToAttendEvent(\''.$post_id.'\',\'add\');">'.ATTEND_EVENT_TEXT.'</a><span id="attended_persons" class="attended_persons">'.event_atended_persons($post_id).'</span>';exit;
	}
	else
	{
		echo '<span class="span_msg"><a href="'.get_author_posts_url($current_user->ID).'">'.$current_user->display_name.'</a> ,'.ATTEND_EVENT_MSG.' '.get_the_title($post_id).' ?</span>		
		<a class="addtofav b_review" href="javascript:void(0);"  onclick="javascript:addToAttendEvent(\''.$post_id.'\',\'add\',\''.$st_date.'\',\''.$end_date.'\');">'.ATTEND_EVENT_TEXT.'</a><span id="attended_persons" class="attended_persons">'.event_attend_recurring_event_persons($post_id).'</span>';exit;
	}

}
function attend_event_html($user_id,$post_id)
{
	global $current_user;
	$post = get_post($post_id);
	$user_meta_data = get_user_meta($current_user->ID,'user_attend_event',true);
	echo get_avatar($current_user->user_email,35,35);
	if($user_meta_data && in_array($post_id,$user_meta_data))
	{
		?>
	<span id="attend_event_<?php echo $post_id;?>" class="fav"  > 
	<span class="span_msg"><a href="<?php echo get_author_posts_url($current_user->ID);?>"><?php echo $current_user->display_name."</a>, ".REMOVE_EVENT_MSG." ".get_the_title($post_id)."."; ?></span>     
	<a href="javascript:void(0);" class="addtofav b_review" onclick="javascript:addToAttendEvent('<?php echo $post_id;?>','remove');"><?php echo REMOVE_EVENT_TEXT;?></a>
     <span id="attended_persons" class="attended_persons"><?php echo event_atended_persons($post_id); ?></span>
        </span>    
		<?php
	}else{
	?>
	<span id="attend_event_<?php echo $post_id;?>" class="fav">
	<span class="span_msg"><a href="<?php echo get_author_posts_url($current_user->ID);?>"><?php echo $current_user->display_name."</a>, ".ATTEND_EVENT_MSG." ".get_the_title($post_id)." ?"; ?></span>     
	<a href="javascript:void(0);" class="addtofav b_review"  onclick="javascript:addToAttendEvent(<?php echo $post_id;?>,'add');"><?php echo ATTEND_EVENT_TEXT;?></a>
     <span id="attended_persons" class="attended_persons"><?php echo event_atended_persons($post_id); ?></span>
     </span>
	<?php } 
}
function attend_event_html1($user_id,$post_id,$st_date,$end_date)
{
	global $current_user,$post;
	$a = "";
	
	$post = get_post($post_id);
	$user_meta_data = get_user_meta($current_user->ID,'user_attend_event',true);
	$user_attend_event_start_date = get_user_meta($current_user->ID,'user_attend_event_st_date',true);
	$user_attend_event_end_date = get_user_meta($current_user->ID,'user_attend_event_end_date',true);
	$a .= get_avatar($current_user->user_email,35,35);
	if($user_meta_data && in_array($post_id,$user_meta_data) && in_array($post_id."_".$st_date,$user_attend_event_start_date) && in_array($post_id."_".$end_date,$user_attend_event_end_date))
	{
	$a.="<span id='attend_event_$post_id-$st_date' class='fav' > 
	<span class='span_msg'><a href='".get_author_posts_url($current_user->ID)."'>".$current_user->display_name."</a>, ".REMOVE_EVENT_MSG." ".get_the_title($post_id).". </span>	
	<a href='javascript:void(0)' class='addtofav b_review' onclick='javascript:addToAttendEvent(".$post_id.",\"remove\",\"".$st_date."\",\"".$end_date."\")'>".REMOVE_EVENT_TEXT."</a>   
	<span id='attended_persons' class='attended_persons'>".event_attend_recurring_event_persons($post_id,$st_date,$end_date)."</span>
	</span>    
	";		
	}else{
	$a.="<span id='attend_event_$post_id-$st_date' class='fav'>
	<span class='span_msg'><a href='".get_author_posts_url($current_user->ID)."'>".$current_user->display_name."</a>, ".ATTEND_EVENT_MSG." ".get_the_title($post_id)." ?</span>	
	<a href='javascript:void(0)' class='addtofav b_review'  onclick='javascript:addToAttendEvent(".$post_id.",\"add\",\"".$st_date."\",\"".$end_date."\")'>".ATTEND_EVENT_TEXT."</a>
	<span id='attended_persons' class='attended_persons'>".event_attend_recurring_event_persons($post_id,$st_date,$end_date)."</span>
	</span>";
	} 
	return $a;
}
/*
Nane " templ_atended_persons
args : post id
description : count how many numbers of users going to attend the event (regular event attenders)
*/
function event_atended_persons($post_id){
	global $wpdb;
	$qry_results = $wpdb->get_results("select * from $wpdb->usermeta where meta_key LIKE '%user_attend_event%' and meta_value LIKE '%$post_id%' ");	
	$peoples = count($qry_results);
	
	if($peoples >0){
		$page_template_url=get_permalink(get_option('recurring_event_page_template_id'));		
		if(strstr($page_template_url,'?'))		
			$userlist_url=$page_template_url.'&eid='.$post_id;
		else
			$userlist_url=$page_template_url.'?eid='.$post_id;
		
		if($peoples == 1){
			return $peoples." <a href='".$userlist_url."' target='_blank'>".__('person is attending.',T_DOMAIN)." </a>";
		}else{
			return $peoples." <a href='".$userlist_url."' target='_blank'>".__('peoples are attending.',T_DOMAIN)." </a>";			
		}
	}else{
		return __('No one is attending yet.',T_DOMAIN);
	}
}
/*
Name : attend_recurring_event_persons
description : list all recurring dates on detail page (recurring event attenders)
*/
function event_attend_recurring_event_persons($post_id,$st_date,$end_date){
	global $wpdb;	
	$qry_results = $wpdb->get_results("select * from $wpdb->usermeta where meta_key LIKE '%user_attend_event_st_date%' and meta_value LIKE '%$post_id"._."$st_date%'");	
	$peoples = count($qry_results);
	
	if($peoples >0){
		$page_template_url=get_permalink(get_option('recurring_event_page_template_id'));		
		if(strstr($page_template_url,'?'))		
			$userlist_url=$page_template_url.'&eid='.$post_id;
		else
			$userlist_url=$page_template_url.'?eid='.$post_id;
			
			if($peoples == 1){
				return $peoples." <a href='".$userlist_url."' target='_blank'>".__('person is attending.',T_DOMAIN)." </a>";
			}else{
				return $peoples." <a href='".$userlist_url."' target='_blank'>".__('peoples are attending.',T_DOMAIN)." </a>";
			}
	}else{
		return __('No one is attending yet.',T_DOMAIN);
	}	
}
/** to fetch the recurrence of an event BOF **/
function event_rec_option_items($array, $saved_value) {
	$output = "";
	foreach($array as $key => $item) {
		$selected ='';
		if ($key == $saved_value)
			$selected = "selected='selected'";
		$output .= "<option value='".esc_attr($key)."' $selected >".esc_html($item)."</option>\n";

	}
	echo $output;
}
/** to fetch the recurrence of an event EOF **/

/** to fetch the days of an event BOF **/
function event_checkbox_items($name, $array, $saved_values, $horizontal = true) {
	$output = "";
	foreach($array as $key => $item) {
		$checked = "";
		if (in_array($key, $saved_values))
			$checked = "checked='checked'";
		$output .=  "<input type='checkbox' name='".esc_attr($name)."' value='".esc_attr($key)."' $checked /> ".esc_html($item)."&nbsp; ";
		if(!$horizontal)
			$output .= "<br/>\n";
	}
	echo $output;

}
/** to fetch the days of an event EOF **/
function event_get_hour_format(){
	return get_option('date_format_custom') ? "H:i":"h:i A";
}

function event_get_days_names(){
	return array (1 => __ ( 'Mon' ,'templatic'), 2 => __ ( 'Tue','templatic' ), 3 => __ ( 'Wed','templatic' ), 4 => __ ( 'Thu' ,'templatic'), 5 => __ ( 'Fri','templatic' ), 6 => __ ( 'Sat','templatic' ), 7 => __ ( 'Sun','templatic' ) );
}
add_action('wp_footer','recurring_event_js');
function recurring_event_js(){
	wp_enqueue_script('recurring_js', get_template_directory_uri().'/library/js/recurring_event.js');
}
/*
Function : get_event_price_info
Description :return the price package information 
*/
function get_event_price_info($pro_type='',$price='')
{
	global $price_db_table_name,$wpdb;
	if($pro_type !="")
	{
		$subsql = " and pid=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array();
	if($priceinfo !="")
	{
		foreach($priceinfo as $priceinfoObj)
		{
			$info = array();
			$vper = $priceinfoObj->validity_per;
			$validity = $priceinfoObj->validity;
			if(($priceinfoObj->validity != "" || $priceinfoObj->validity != 0))
			{
				if($vper == 'M')
				{
					$tvalidity = $validity*30 ;
				}else if($vper == 'Y'){
					$tvalidity = $validity*365 ;
				}else{
					$tvalidity = $validity ;
				}
			}
		$info['title'] = $priceinfoObj->price_title;
		$info['price'] = $price;
		$info['days'] = $tvalidity;
		$info['alive_days'] =$tvalidity;
		$info['cat'] =$priceinfoObj->price_post_cat;
		$info['is_featured'] = $priceinfoObj->is_featured;
		$info['title_desc'] = @$priceinfoObj->title_desc;
		$info['is_recurring'] =$priceinfoObj->is_recurring;
		if($priceinfoObj->is_recurring == '1') {
			$info['billing_num'] =$priceinfoObj->billing_num;
			$info['billing_per'] =$priceinfoObj->billing_per;
			$info['billing_cycle'] =$priceinfoObj->billing_cycle;
		}
		$price_info[] = $info;
		}
	}
	return $price_info;

}


// ---------------------------------------------------------------------- ///
//Shortcodes add START --------------------------------------------------------
//----------------------------------------------------------------------- /// 

// Shortcodes - Messages -------------------------------------------------------- //
function message_download( $atts, $content = null ) {
   return '<p class="download">' . $content . '</p>';
}
add_shortcode( 'Download', 'message_download' );

function message_alert( $atts, $content = null ) {
   return '<p class="alert">' . $content . '</p>';
}
add_shortcode( 'Alert', 'message_alert' );

function message_note( $atts, $content = null ) {
   return '<p class="note">' . $content . '</p>';
}
add_shortcode( 'Note', 'message_note' );


function message_info( $atts, $content = null ) {
   return '<p class="info">' . $content . '</p>';
}
add_shortcode( 'Info', 'message_info' );


// Shortcodes - About Author -------------------------------------------------------- //

function about_author( $atts, $content = null ) {
   return '<div class="about_author">' . $content . '</p></div>';
}
add_shortcode( 'Author Info', 'about_author' );


function icon_list_view( $atts, $content = null ) {
   return '<div class="check_list">' . $content . '</p></div>';
}
add_shortcode( 'Icon List', 'icon_list_view' );


// Shortcodes - Boxes -------------------------------------------------------- //

function normal_box( $atts, $content = null ) {
   return '<div class="boxes normal_box">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box', 'normal_box' );

function warning_box( $atts, $content = null ) {
   return '<div class="boxes warning_box">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box', 'warning_box' );

function about_box( $atts, $content = null ) {
   return '<div class="boxes about_box">' . $content . '</p></div>';
}
add_shortcode( 'About_Box', 'about_box' );

function download_box( $atts, $content = null ) {
   return '<div class="boxes download_box">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box', 'download_box' );

function info_box( $atts, $content = null ) {
   return '<div class="boxes info_box">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box', 'info_box' );


function alert_box( $atts, $content = null ) {
   return '<div class="boxes alert_box">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box', 'alert_box' );


/*
Function : view_counter
Description : Count/fetch the daily views and total views BOF
*/
function view_counter($pid){
	if($_SERVER['HTTP_REFERER'] == '' || !strstr($_SERVER['HTTP_REFERER'],$_SERVER['REQUEST_URI']))
	{
	$viewed_count = get_post_meta($pid,'viewed_count',true);
	$viewed_count_daily = get_post_meta($pid,'viewed_count_daily',true);
	$daily_date = get_post_meta($pid,'daily_date',true);

	update_post_meta($pid,'viewed_count',$viewed_count+1);

	if(get_post_meta($pid,'daily_date',true) == date('Y-m-d')){
		update_post_meta($pid,'viewed_count_daily',$viewed_count_daily+1);
	} else {
		update_post_meta($pid,'viewed_count_daily','1');
	}
	update_post_meta($pid,'daily_date',date('Y-m-d'));
	}
}
/*
Name : user_post_visit_count 
Description : update total views 
*/
function user_post_visit_count($pid)
{
	if(get_post_meta($pid,'viewed_count',true))
	{
		return get_post_meta($pid,'viewed_count',true);
	}else
	{
		return '0';	
	}
}
/*
Name : user_post_visit_count_daily 
Description : update daily views 
*/
function user_post_visit_count_daily($pid)
{
	if(get_post_meta($pid,'viewed_count_daily',true))
	{
		return get_post_meta($pid,'viewed_count_daily',true);
	}else
	{
		return '0';	
	}
}

// Shortcodes - Boxes - Equal -------------------------------------------------------- //

function normal_box_equal( $atts, $content = null ) {
   return '<div class="boxes normal_box small">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box_Equal', 'normal_box_equal' );

function warning_box_equal( $atts, $content = null ) {
   return '<div class="boxes warning_box small">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box_Equal', 'warning_box_equal' );

function about_box_equal( $atts, $content = null ) {
   return '<div class="boxes about_box small_without_margin">' . $content . '</p></div>';
}
add_shortcode( 'About_Box_Equal', 'about_box_equal' );

function download_box_equal( $atts, $content = null ) {
   return '<div class="boxes download_box small">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box_Equal', 'download_box_equal' );

function info_box_equal( $atts, $content = null ) {
   return '<div class="boxes info_box small">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box_Equal', 'info_box_equal' );


function alert_box_equal( $atts, $content = null ) {
   return '<div class="boxes alert_box small">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box_Equal', 'alert_box_equal' );


// Shortcodes - Content Columns -------------------------------------------------------- //

function one_half_column( $atts, $content = null ) {
   return '<div class="one_half_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Half', 'one_half_column' );

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half_column right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Half_Last', 'one_half_last' );


function one_third_column( $atts, $content = null ) {
   return '<div class="one_third_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Third', 'one_third_column' );

/* Shortcodes - one-third column  last*/

function one_third_column_last( $atts, $content = null ) {
   return '<div class="one_third_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Third_Last', 'one_third_column_last' );

/* Shortcodes - one-fourth column  */

function one_fourth_column( $atts, $content = null ) {
   return '<div class="one_fourth_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Fourth', 'one_fourth_column' );

/* Shortcodes - one-fourth column  */

function one_fourth_column_last( $atts, $content = null ) {
   return '<div class="one_fourth_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Fourth_Last', 'one_fourth_column_last' );

/* Shortcodes - two-third left  */

function two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds left">' . $content . '</p></div>';
}
add_shortcode( 'Two_Third', 'two_thirds' );

/* Shortcodes - two-third column  */

function two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'Two_Third_Last', 'two_thirds_last' );

/* Shortcodes - Drop cap */
function dropcaps( $atts, $content = null ) {
   return '<p class="dropcaps">' . $content . '</p>';
}
add_shortcode( 'Dropcaps', 'dropcaps' );


/* Shortcodes - Small Buttons */

function small_button( $atts, $content ) {
 return '<div class="small_button '.$atts['class'].'">' . $content . '</div>';
}
add_shortcode( 'Small_Button', 'small_button' );

/* Short codes functions end */

/* 
Name: remove_metaboxes
Description : remove custom user meta box
*/
function remove_metaboxes() {
 remove_meta_box( 'postcustom' , CUSTOM_POST_TYPE1 , 'normal' ); //removes custom fields for page
}
add_action( 'admin_menu' , 'remove_metaboxes' );

/* 
Name: get_image_size
Description : To get the size of image
*/
function get_image_size($src)
{
	$filextenson = stripExtension($src);
	if($filextenson == "jpeg" || $filextenson == "jpg")
	  {
		$img = imagecreatefromjpeg($src);  
	  }
	
	if($filextenson == "png")
	  {
		$img = imagecreatefrompng($src);  
	  }

	if($filextenson == "gif")
	  {
		$img = imagecreatefromgif($src);  
	  }

	$width = imageSX($img);
	$height = imageSY($img);
	return array('width'=>$width,'height'=>$height);
	
}

function stripExtension($filename = '') {
    if (!empty($filename)) 
	   {
        $filename = strtolower($filename);
        $extArray = split("[/\\.]", $filename);
        $p = count($extArray) - 1;
        $extension = $extArray[$p];
        return $extension;
    } else {
        return false;
    }
}
/* 
Name : is_more_alive_days
Description : Function to check more alive days or not 
*/
function is_more_alive_days($cur_user_id){
	global $wpdb;
	if(strtolower(get_option('ptthemes_package_type')) == strtolower('Pay per subscriptions')){
		if($cur_user_id){
		$qry= "select * from $wpdb->posts p, $wpdb->postmeta pm where p.ID = pm.post_id and p.post_author = '".$cur_user_id."' and (pm.meta_key LIKE '%alive_days%') order by p.post_date desc LIMIT 0,1";
		$adays = $wpdb->get_row($qry);
		if($adays->ID){
		$alive_day = $adays->meta_value;
		$publish_date = $adays->post_date;
		$curdate = date('Y-m-d');
		$diff = abs(strtotime($curdate) - strtotime($publish_date));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

			if($alive_day >= $days && ($alive_day - $days) == 0){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
		}else{
			return true;
		}
	}else{
		return true;
	}
}

/**-- Function to check more alive days or not EOF--**/

/*
Name: register_templatic_menus
Description : add menu location in theme BOF */
function register_templatic_menus() {
	register_nav_menus(array(
		'primary' => __( 'Top Navigation','templatic' ),
		'secondary' => __( 'Main Navigation','templatic')
		));
}
/** --  add menu location in theme EOF --**/

/*
Name : recurrence_event
Description : start of function for recurrence event.
*/
function recurrence_event($post_id)
{
	global $wpdb,$current_user,$post;
	$start_date = strtotime(get_post_meta($post_id,'st_date',true));
	$end_date = strtotime(get_post_meta($post_id,'end_date',true));
	$recurrence_occurs = get_post_meta($post_id,'recurrence_occurs',true);//reoccurence type
	$recurrence_per = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
	$current_date = date('Y-m-d');
	$recurrence_days = get_post_meta($post_id,'recurrence_days',true);	//on which day
	$recurrence_list = "";
	_e('This is a ','Templatic');echo $recurrence_occurs;_e(' Event.','Templatic');
	if($recurrence_occurs == 'daily')
	{
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$recurrence_list .= "<ul>";
		for($i=0;$i<($days_between+1);$i++)
		{
			$class= ($i%2) ? "odd" : "even";
			if(($i%$recurrence_per) == 0 )
			{
				$j = $i+$recurrence_days;
				$st_date1 = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$i day");
				$st_date = date('l dS \o\f F Y', $st_date1);
				$end_date1 = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$j day");
				$post_end_date  = strtotime(get_post_meta($post_id,'end_date',true));
				if($end_date1 >  $post_end_date)
					$end_date1 = $post_end_date;
				$end_date = date('l dS \o\f F Y', $end_date1);
				$st_time = get_formated_time(get_post_meta($post_id,'st_time',true));
				$end_time = get_formated_time(get_post_meta($post_id,'end_time',true));
				$recurrence_list .= "<li class=$class>";
				$recurrence_list .= "<div class='date_info'>
				<p>
					  <strong>From</strong>   $st_date $st_time
							  <strong>To </strong>   $end_date $end_time <br/>
				</p>
								</div>";
				if(get_option('ptthemes_attending_event') == 'Yes')
							{
							$recurrence_list .= "<div class='attending_event'> ";
							$recurrence_list .= attend_event_html1($post->post_author,$post->ID,date("Y-m-d", $st_date1),date("Y-m-d",$end_date1));
							$recurrence_list .= "	<div class='clearfix'></div>
						   </div>  ";
						  } 
				$recurrence_list .= "</li>";
			}
			else
			{
				continue;
			}
		}
	}
	if($recurrence_occurs == 'weekly' )
	{
		$recurrence_interval = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$l = 0;
		$count_recurrence = 0;
		$current_week = 0;
		$recurrence_list .= "<ul>";
		
		if(strstr(get_post_meta($post_id,'recurrence_bydays',true),","))
			$recurrence_byday = explode(',',get_post_meta($post_id,'recurrence_byday',true));	//on which day
		else
			$recurrence_byday = get_post_meta($post_id,'recurrence_byday',true);	//on which day
		$start_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) );
		$end_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'end_date',true))) );
		
		//sort out week one, get starting days and then days that match time span of event (i.e. remove past events in week 1)
		$weekdays = explode(",", get_post_meta($post_id,'recurrence_bydays',true));
		$matching_days = array(); 
		$aDay = 86400;  // a day in seconds
		$aWeek = $aDay * 7;
			$start_of_week = get_option('start_of_week'); //Start of week depends on WordPress
			//first, get the start of this week as timestamp
			$event_start_day = date('w', $start_date);
			$offset = 0;
			if( $event_start_day > $start_of_week ){
				$offset = $event_start_day - $start_of_week; //x days backwards
			}elseif( $event_start_day < $start_of_week ){
				$offset = $start_of_week;
			}
			$start_week_date = $start_date - ( ($event_start_day - $start_of_week) * $aDay );
			//then get the timestamps of weekdays during this first week, regardless if within event range
			$start_weekday_dates = array(); //Days in week 1 where there would events, regardless of event date range
			for($i = 0; $i < 7; $i++){
				$weekday_date = $start_week_date+($aDay*$i); //the date of the weekday we're currently checking
				$weekday_day = date('w',$weekday_date); //the day of the week we're checking, taking into account wp start of week setting
				if( in_array( $weekday_day, $weekdays) ){
					$start_weekday_dates[] = $weekday_date; //it's in our starting week day, so add it
				}
			}
			//for each day of eventful days in week 1, add 7 days * weekly intervals
			foreach ($start_weekday_dates as $weekday_date){
				//Loop weeks by interval until we reach or surpass end date
				while($weekday_date <= $end_date){
					if( $weekday_date >= $start_date && $weekday_date <= $end_date ){
						$matching_days[] = $weekday_date;
					}
					$weekday_date = $weekday_date + ($aWeek *  $recurrence_interval);
				}
			}//done!
			sort($matching_days);
			for($z=0;$z<count($matching_days);$z++)
			{
				$class= ($z%2) ? "odd" : "even";
				$st_date1 = $matching_days[$z];
				$st_date = date('l dS \o\f F Y', $st_date1);
				$st_end_date = date("Y-m-d", $matching_days[$z]);
				$end_date1 = strtotime(date("Y-m-d", strtotime($st_end_date)) . " +$recurrence_days day");
				$post_end_date  = strtotime(get_post_meta($post_id,'end_date',true));
				if($end_date1 >  $post_end_date)
					$end_date1 = $post_end_date;
				$end_date = date('l dS \o\f F Y', $end_date1);
				$st_time = get_formated_time(get_post_meta($post_id,'st_time',true));
				$end_time = get_formated_time(get_post_meta($post_id,'end_time',true));
				$recurrence_list .= "<li class=$class>";
				$recurrence_list .= "<div class='date_info'>
					<p>
						  <strong>From</strong>   $st_date $st_time
								  <strong>To </strong>   $end_date $end_time <br/>
					</p>
						</div>";
				if(get_option('ptthemes_attending_event') == 'Yes' )
					{
					$recurrence_list .= "<div class='attending_event'> ";
					$recurrence_list .= attend_event_html1($post->post_author,$post->ID,date("Y-m-d", $st_date1),date("Y-m-d",$end_date1));
					$recurrence_list .= "	<div class='clearfix'></div>
				   </div>  ";
				  } 
				$recurrence_list .= "</li>";
			}
	}
	
	if($recurrence_occurs == 'monthly' )
	{
		$recurrence_interval = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$recurrence_byweekno = get_post_meta($post_id,'monthly_recurrence_byweekno',true);	//on which day
		$l = 0;
		$month_week = 0;
		$count_recurrence = 0;
		$current_month = 0;
		$recurrence_list .= "<ul>";
		
			if(strstr(get_post_meta($post_id,'recurrence_bydays',true),","))
				$recurrence_byday = explode(',',get_post_meta($post_id,'recurrence_byday',true));	//on which day
			else
				$recurrence_byday = get_post_meta($post_id,'recurrence_byday',true);	//on which day
			$start_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) );
			$end_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'end_date',true))) );
		
		$matching_days = array(); 
		$aDay = 86400;  // a day in seconds
		$aWeek = $aDay * 7;		 
		$current_arr = getdate($start_date);
		$end_arr = getdate($end_date);
		$end_month_date = strtotime( date('Y-m-t', $end_date) ); //End date on last day of month
		$current_date = strtotime( date('Y-m-1', $start_date) ); //Start date on first day of month
		while( $current_date <= $end_month_date ){
			 $last_day_of_month = date('t', $current_date);
			//Now find which day we're talking about
			$current_week_day = date('w',$current_date);
			$matching_month_days = array();
			//Loop through days of this years month and save matching days to temp array
			for($day = 1; $day <= $last_day_of_month; $day++){
				if((int) $current_week_day == $recurrence_byday){
					$matching_month_days[] = $day;
				}
				$current_week_day = ($current_week_day < 6) ? $current_week_day+1 : 0;							
			}
			//Now grab from the array the x day of the month
			$matching_day = ($recurrence_byweekno > 0) ? $matching_month_days[$recurrence_byweekno-1] : array_pop($matching_month_days);
			$matching_date = strtotime(date('Y-m',$current_date).'-'.$matching_day);
			if($matching_date >= $start_date && $matching_date <= $end_date){
				$matching_days[] = $matching_date;
			}
			//add the number of days in this month to make start of next month
			$current_arr['mon'] += $recurrence_interval;
			if($current_arr['mon'] > 12){
				//FIXME this won't work if interval is more than 12
				$current_arr['mon'] = $current_arr['mon'] - 12;
				$current_arr['year']++;
			}
			$current_date = strtotime("{$current_arr['year']}-{$current_arr['mon']}-1"); 
			
			
		}
		sort($matching_days);
		for($z=0;$z<count($matching_days);$z++)
		{
			$class= ($z%2) ? "odd" : "even";
			$st_date1 = $matching_days[$z];
			$st_date = date('l dS \o\f F Y', $matching_days[$z]);
			$st_end_date = date("Y-m-d", $matching_days[$z]);
			$end_date1 = strtotime(date("Y-m-d", strtotime($st_end_date)) . " +$recurrence_days day");
			$post_end_date  = strtotime(get_post_meta($post_id,'end_date',true));
			if($end_date1 >  $post_end_date)
				$end_date1 = $post_end_date;
			$end_date = date('l dS \o\f F Y', $end_date1);
			$st_time = get_formated_time(get_post_meta($post_id,'st_time',true));
			$end_time = get_formated_time(get_post_meta($post_id,'end_time',true));
			$recurrence_list .= "<li class=$class>";
			$recurrence_list .= "<div class='date_info'>
			<p>
				  <strong>From</strong>   $st_date $st_time
						  <strong>To </strong>   $end_date $end_time <br/>
			</p>
							</div>";
							if(get_option('ptthemes_attending_event') == 'Yes' )
							{
								$recurrence_list .= "<div class='attending_event'> ";
								$recurrence_list .= attend_event_html1($post->post_author,$post->ID,date("Y-m-d", $st_date1),date("Y-m-d",$end_date1));
								$recurrence_list .= "	<div class='clearfix'></div>
							   </div>  ";
							} 
			$recurrence_list .= "</li>";
		}
			
	}
	if($recurrence_occurs == 'yearly' )
	{
		$date1 = get_post_meta($post_id,'st_date',true);
		$date2 = get_post_meta($post_id,'end_date',true);
		$st_startdate1 = explode("-",$date1);
		$st_year = $st_startdate1[0];
		$st_month = $st_startdate1[1];
		$st_day = $st_startdate1[2];
		$st_date1 = mktime(0, 0, 0, $st_month, $st_day, $st_year);
		$st_date__month = (int)date('n', $st_date1); //get the current month of start date.
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years_between = floor($diff / (365*60*60*24));
		$recurrence_list .= "<ul>";
		for($i=0;$i<($years_between+1);$i++)
		{
			$class= ($i%2) ? "odd" : "even";
			$startdate = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$i year");
			$startdate1 = explode("-",date('Y-m-d',$startdate));
			$year = $startdate1[0];
			$month = $startdate1[1];
			$day = $startdate1[2];
			$date2 = mktime(0, 0, 0, $month, $day, $year);
			$month = (int)date('n', $date2); //get the current month.
			if($month == $st_date__month  && $i%$recurrence_per == 0)
			{
				$st_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))). " +$i year");
				$st_date = date('l dS \o\f F Y', $st_date);
				$end_date = $date2 = mktime(0, 0, 0, $month, $day+$recurrence_days, $year);
				$post_end_date  = strtotime(get_post_meta($post_id,'end_date',true));
				if($end_date >  $post_end_date)
					$end_date = $post_end_date;
				$end_date = date('l dS \o\f F Y', $end_date);
				$st_time = get_formated_time(get_post_meta($post_id,'st_time',true));
				$end_time = get_formated_time(get_post_meta($post_id,'end_time',true));
				$recurrence_list .= "<li class=$class>";
				$recurrence_list .= "<div class='date_info'>
				<p>
					  <strong>From</strong>   $st_date $st_time
							  <strong>To </strong>   $end_date $end_time <br/>
				</p>
								</div>";
								if(get_option('ptthemes_attending_event') == 'Yes' )
							{
							$recurrence_list .= "<div class='attending_event'> ";
							$recurrence_list .= attend_event_html1($post->post_author,$post->ID,date("Y-m-d", $st_date1),date("Y-m-d",$end_date1));
							$recurrence_list .= "	<div class='clearfix'></div>
						   </div>  ";
						  } 
				$recurrence_list .= "</li>";

			}
			else
			{
				continue;
			}
		}
	}
	return $recurrence_list;
}
/* end of function for recurrence event */

/*
Name : _iscurlinstalled
Description : Returns tru/false , check CURL is enable or not
*/
function _iscurlinstalled() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else{
		return false;
	}
}
/*
Name : facebook_events
arguments : $user_id as user id
Description : Returns facebook events
*/

function facebook_events($user_id)
{
	 $appID = get_user_meta($user_id,'appID',true);
	 $secret = get_user_meta($user_id,'secret',true);
	 $pageID = get_user_meta($user_id,'pageID',true);
	$config = array(
		'appId' => $appID,
		'secret' => $secret,
	  );
	 if(class_exists('Facebook')){
	 $facebook = new Facebook($config);
	 $user_id = $facebook->getUser();
		if($appID) 
		{

		  /*  We have a user ID, so probably a logged in user.
		   If not, we'll get an exception, which we handle below. */
		  try {
		  

		/* just a heading once it creates an event */
			$fql    =   "SELECT eid,name, pic, start_time, end_time, location, description 
				FROM event WHERE eid IN ( SELECT eid FROM event_member WHERE uid = $pageID ) 
				ORDER BY start_time asc";			
				$param  =   array(
				'method'    => 'fql.query',
				'query'     => $fql,
				'callback'  => '');
				$fqlResult   =   $facebook->api($param);
	
	if(!$fqlResult)
	{?>
		 <p class="message" ><?php echo NO_FACEBOOK_EVENT;?> </p> 
	<?php }
	
	/* looping through retrieved data */
	foreach( $fqlResult as $keys => $values ){
		/* see here for the date format I used
		The pattern string I used 'l, F d, Y g:i a'
		will output something like this: July 30, 2015 6:30 pm */

		/* getting 'start' and 'end' date,
		'l, F d, Y' pattern string will give us
		something like: Thursday, July 30, 2015 */
		$start_date = date( 'l, F d, Y', $values['start_time'] );
		$end_date = date( 'l, F d, Y', $values['end_time'] );

		/* getting 'start' and 'end' time
		'g:i a' will give us something
		like 6:30 pm */
		$start_time = date( 'g:i a', $values['start_time'] );
		$end_time = date( 'g:i a', $values['end_time'] );

		//printing the data
		$link = "http://www.facebook.com/events/".$values['eid'];
	   echo "<div class='event_list  clearfix'>";
			echo "<a class='event_img'><img  src={$values['pic']} /></a>";
	   
			echo "<h3><a href='".$link."'>{$values['name']}</a></h3>";
			echo "<p class='date'> ";
			if( $start_date == $end_date ){
				/* if $start_date and $end_date is the same
				it means the event will happen on the same day
				so we will have a format something like:
				July 30, 2015 - 6:30 pm to 9:30 pm */
				echo "<span>Start date :</span> {$start_date} "."<br/>";
			}else{
				echo "<span>Start date :</span> {$start_date}"."<br/>";
				echo "<span>End date : </span>{$end_date}"."<br/>";
			}
			echo "<span>Time : </span>{$start_time} - {$end_time}"."<br/>";
			echo "</p>";
			if($values['location']){
			echo "<p class='location'><span>Location</span>: " . $values['location'] . "</p>";
			}
			echo "<div class='clearfix'></div>";
			if($values['description']){
			echo "<p>More Info: " . $values['description'] . "</p>";
			}

		echo "<div style='clear: both'></div>";
		echo "<div class='clearfix'></div>";
	echo "</div>";
		
	}
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type='text/javascript'>
	//just to add some hover effects
	$(document).ready(function(){

	$('.event').hover(
		function () {
			$(this).css('background-color', '#CFF');
		}, 
		function () {
			$(this).css('background-color', '#E3E3E3');
		}
	);

	});</script>
	<?php
			/* FQL queries return the results in an array, so we have to get the user's name from the first element in the array. */
		   

		  } catch(FacebookApiException $e) {
			/* If the user is logged out, you can have a user ID even though the access token is invalid.In this case, we'll get an exception, so we'll just ask the user to login again here. */
			$login_url = $facebook->getLoginUrl(); 
			echo 'Please <a href="' . $login_url . '">login.</a>';
			error_log($e->getType());
			error_log($e->getMessage());
		  }   
		}
		}else{
			_e('Facebook Plugin not installed.','templatic');
		}
}

/*
Name : facebook_events
Description : Returns facebook events for page template
*/

function facebook_events_template()
{
	 $appID = get_option('ptthemes_appid');
	 $secret = get_option('ptthemes_secret_id');
	 $pageID = get_option('ptthemes_page_id');
	$config = array(
		'appId' => $appID,
		'secret' => $secret,
	  );
	 if(class_exists('Facebook')){
	 $facebook = new Facebook($config);
	 $user_id = $facebook->getUser();
		if($appID) 
		{

		  /*  We have a user ID, so probably a logged in user.
		   If not, we'll get an exception, which we handle below. */
		  try {
		  

		/* just a heading once it creates an event */
			$fql    =   "SELECT eid,name, pic, start_time, end_time, location, description 
				FROM event WHERE eid IN ( SELECT eid FROM event_member WHERE uid = $pageID ) 
				ORDER BY start_time asc";			
				$param  =   array(
				'method'    => 'fql.query',
				'query'     => $fql,
				'callback'  => '');
				$fqlResult   =   $facebook->api($param);
	
	if(!$fqlResult)
	{?>
		 <p class="message" ><?php echo NO_FACEBOOK_EVENT;?> </p> 
	<?php }
	
	/* looping through retrieved data */
	foreach( $fqlResult as $keys => $values ){
		/* see here for the date format I used
		The pattern string I used 'l, F d, Y g:i a'
		will output something like this: July 30, 2015 6:30 pm */

		/* getting 'start' and 'end' date,
		'l, F d, Y' pattern string will give us
		something like: Thursday, July 30, 2015 */
		$start_date = date( 'l, F d, Y', $values['start_time'] );
		$end_date = date( 'l, F d, Y', $values['end_time'] );

		/* getting 'start' and 'end' time
		'g:i a' will give us something
		like 6:30 pm */
		$start_time = date( 'g:i a', $values['start_time'] );
		$end_time = date( 'g:i a', $values['end_time'] );

		//printing the data
		$link = "http://www.facebook.com/events/".$values['eid'];
	   echo "<div class='event_list  clearfix'>";
			echo "<a class='event_img'><img  src={$values['pic']} /></a>";
	   
			echo "<h3><a href='".$link."' target='blank'>{$values['name']}</a></h3>";
			echo "<p class='date'> ";
			if( $start_date == $end_date ){
				/* if $start_date and $end_date is the same
				it means the event will happen on the same day
				so we will have a format something like:
				July 30, 2015 - 6:30 pm to 9:30 pm */
				echo "<span>Start date :</span> {$start_date} "."<br/>";
			}else{
				echo "<span>Start date :</span> {$start_date}"."<br/>";
				echo "<span>End date : </span>{$end_date}"."<br/>";
			}
			echo "<span>Time : </span>{$start_time} - {$end_time}"."<br/>";
			echo "</p>";
			if($values['location']){
			echo "<p class='location'><span>Location </span>: " . $values['location'] . "</p>";
			}
			echo "<div class='clearfix'></div>";
			if($values['description']){
			echo "<p>More Info: " . $values['description'] . "</p>";
			}

		echo "<div style='clear: both'></div>";
		echo "<div class='clearfix'></div>";
	echo "</div>";
		
	}
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
	<script type='text/javascript'>
	//just to add some hover effects
	$(document).ready(function(){

	$('.event').hover(
		function () {
			$(this).css('background-color', '#CFF');
		}, 
		function () {
			$(this).css('background-color', '#E3E3E3');
		}
	);

	});</script>
	<?php
			/* FQL queries return the results in an array, so we have to get the user's name from the first element in the array. */
		   

		  } catch(FacebookApiException $e) {
			/* If the user is logged out, you can have a user ID even though the access token is invalid.In this case, we'll get an exception, so we'll just ask the user to login again here. */
			$login_url = $facebook->getLoginUrl(); 
			echo 'Please <a href="' . $login_url . '">login.</a>';
			error_log($e->getType());
			error_log($e->getMessage());
		  }   
		}
		}else{
			_e('Facebook Plugin not installed.','templatic');
		}
}

/**-- function to fetch category listng--**/
function fetch_categories_ids($taxonomy){
global $wpdb;
 $terms = $wpdb->get_results("select * from $wpdb->terms t,$wpdb->term_taxonomy tt where t.term_id = tt.term_id and tt.taxonomy = '".$taxonomy."'");
 foreach($terms as $ttl){
	$sep=" , ";
	$cat_list = "<b>".$ttl->term_id."</b> - ".$ttl->name.$sep;
	echo $cat_list;
 }	
}
if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') and !is_single()) /*--this condition is because plugin is conflict with comment box in backend --*/
{
 /*@Author: Boutros AbiChedid
* @Date:   March 20, 2011
* @Websites: http://bacsoftwareconsulting.com/
* http://blueoliveonline.com/
* @Description: Numbered Page Navigation (Pagination) Code.
* @Tested: Up to WordPress version 3.1.2 (also works on WP 3.3.1)
********************************************************************/
 
/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}

/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
	
    $pagenavi_options = array();
   // $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = 'Next &raquo;';
    $pagenavi_options['prev_text'] = '&laquo; Previous';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
 
    if (!is_single()) {
        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
 
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
 
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
 
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
 
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
				   echo $before.'<div class="Navi">'."\n";
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {

            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
			previous_posts_link($pagenavi_options['prev_text']);
 

 
            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span>';
            }
       
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);

                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">1</a>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                }
            }
 
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="on">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$max_page.'</a>';
            }
           
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }

			 next_posts_link($pagenavi_options['next_text'], $max_page);
        }
		            echo '</div>'.$after."\n";
    }
}
}
/* Events Expiration Conditins start */

global $table_prefix, $wpdb;
$table_name = $table_prefix . "event_expire_session";

$current_date = date('Y-m-d');
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
{
   global $table_prefix, $wpdb,$table_name;
   $sql = 'DROP TABLE `' . $table_name . '`';  // drop the existing table
   mysql_query($sql);

	$sql = 'CREATE TABLE `'.$table_name.'` (
			`session_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`execute_date` DATE NOT NULL ,
			`is_run` TINYINT( 4 ) NOT NULL DEFAULT "0"
			) ENGINE = MYISAM ;';
   mysql_query($sql);
}

$today_executed = $wpdb->get_var("select session_id from $table_name where execute_date=\"$current_date\"");
if(@$listing_ex_status):
$wpdb->query("update $wpdb->posts set post_status=\"$listing_ex_status\" where ID in ($postid_str)");
endif;
if($today_executed && $today_executed>0)
{
}else
{
	if(get_option('ptthemes_listing_expiry_disable') == 'No')
	{
		
	}else
	{ 
		if(get_option('ptthemes_listing_preexpiry_notice_disable') == 'No')
		{
			
			$number_of_grace_days = get_option('ptthemes_listing_preexpiry_notice_days');
			if($number_of_grace_days=='')
			{
				$number_of_grace_days=1;	
			}
			$postid_str = $wpdb->get_results("select p.ID,p.post_author,p.post_date, p.post_title from $wpdb->posts p where p.post_type='event' and (p.post_status='publish' or p.post_status='recurring') and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) = (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')-$number_of_grace_days");
			foreach($postid_str as $postid_str_obj)
			{
				$ID = $postid_str_obj->ID;
				$auth_id = $postid_str_obj->post_author;
				$post_author = $postid_str_obj->post_author;
				$post_date = date('dS m,Y',strtotime($postid_str_obj->post_date));
				$post_title = $postid_str_obj->post_title;
				$userinfo = $wpdb->get_results("select user_email,display_name,user_login from $wpdb->users where ID=\"$auth_id\"");
				
				$user_email = $userinfo[0]->user_email;
				$display_name = $userinfo[0]->display_name;
				$user_login = $userinfo[0]->user_login;
				
				$fromEmail = get_site_emailId();
				$fromEmailName = get_site_emailName();
				$alivedays = get_post_meta($ID,'alive_days',true);
				$productlink = get_permalink($ID);
				$loginurl = get_option('home').'/?ptype=login';
				$home = get_option('home');
				$client_message = "<p>Dear $display_name,<p><p>Your listing -<a href=\"$productlink\"><b>$post_title</b></a> posted on  <u>$post_date</u> for $alivedays days.</p>
				<p>It's going to expiry after $number_of_grace_days day(s). If the listing expire, it will no longer appear on the site.</p>
				<p> If you want to renew, Please login to your member area of our site and renew it as soon as it expire. You may like to login the site from <a href=\"$loginurl\">$loginurl</a>.</p>
				<p>Your login ID is <b>$user_login</b> and Email ID is <b>$user_email</b>.</p>
				<p>Thank you,<br /><a href=\"$home\">$fromEmailName</a>.</p>";
				$subject = 'Place listing expiration Notification';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers .= 'To: '.$display_name.' <'.$user_email.'>' . "\r\n";
				$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
				@mail($user_email,$subject,$client_message,$headers);///To client email
			}
		}
		
		$postid_str = $wpdb->get_var("select group_concat(p.ID) from $wpdb->posts p where p.post_type='event' and (p.post_status='publish' or p.post_status='recurring') and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) = (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')");
		
		if($postid_str)
		{
			$listing_ex_status = get_option('ptthemes_listing_ex_status');
			if($listing_ex_status=='')
			{
				$listing_ex_status = 'draft';	
			}
			$wpdb->query("update $wpdb->posts set post_status=\"$listing_ex_status\" where ID in ($postid_str)");
		}
		$wpdb->query("insert into $table_name (execute_date,is_run) values (\"$current_date\",'1')");
	}
}

/* Events Expiration Conditins end */

/*
Name : get_authorlisting_evnets
Description : to fetch the number of listing by author
*/
function get_authorlisting_evnets($cur_author){
	global $wpdb;
	$post_count = 0;
	$post_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_author = '" . $cur_author . "' AND post_type = 'event' AND post_status = 'publish'");
	return $post_count;
}
function get_company_logo($files)
{
	$imagepath = '';
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	$destination_path = $wp_upload_dir['path'].'/';
	
	if (!file_exists($destination_path))
	{
		$imagepatharr = explode('/',$destination_path);
		$year_path = '';
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			 $year_path .= $imagepatharr[$i]."/";
			 
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	if($files['organizer_logo']['name'])
	{
		$name = time().'_'.$files['organizer_logo']['name'];
		$tmp_name = $files['organizer_logo']['tmp_name'];
		$target_path = $destination_path . str_replace(',','',$name);
		$extension_file1=array('.jpg','.JPG','jpeg','JPEG','.png','.PNG','.gif','.GIF','.jpe','.JPE'); 
		$file_ext= substr($target_path, -4, 4);
		if(in_array($file_ext,$extension_file1))
		{
			if(move_uploaded_file($tmp_name, $target_path)) 
			{
				$imagepath1 = $url."/".$name;
				$upload_path = get_option('upload_path');
				return $imagepath1;
			}
		}else{
			_e('Incurrect file format','templatic');
		}
	}	
}
/*
 *Function Name : templ_recurrence_dates
 *Description : return recurrence dates.
 */
function templ_recurrence_dates($post_id)
{
	
	global $wpdb,$current_user,$post;
	$start_date = strtotime(get_post_meta($post_id,'st_date',true));
	$end_date = strtotime(get_post_meta($post_id,'end_date',true));
	$recurrence_occurs = get_post_meta($post_id,'recurrence_occurs',true);//reoccurence type
	$recurrence_per = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
	$current_date = date('Y-m-d');
	$recurrence_days = get_post_meta($post_id,'recurrence_days',true);	//on which day
	$recurrence_list = "";
	
	if($recurrence_occurs == 'daily' )
	{
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$recurrence_list .= "<ul>";
		for($i=0;$i<($days_between+1);$i++)
		{
			$class= ($i%2) ? "odd" : "even";
			if(($i%$recurrence_per) == 0 )
			{
				$j = $i+$recurrence_days;
				$st_date1 = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$i day");
				if($recurrence_days==0)
					$recurrence_days=1;
				for($rd=0;$rd<$recurrence_days;$rd++)
				{
					$st_date2 = strtotime(date("Y-m-d", $st_date1) . " +$rd day");
					$st_date .= date("Y-m-d", $st_date2).",";
				}
//				$st_date .= date('Y-m-d', $st_date1).",";
			}
			else
			{
				continue;
			}
		}
	}
	if($recurrence_occurs == 'weekly' )
	{
		$recurrence_interval = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$l = 0;
		$count_recurrence = 0;
		$current_week = 0;
		$recurrence_list .= "<ul>";
		
		if(strstr(get_post_meta($post_id,'recurrence_bydays',true),","))
			$recurrence_byday = explode(',',get_post_meta($post_id,'recurrence_byday',true));	//on which day
		else
			$recurrence_byday = get_post_meta($post_id,'recurrence_byday',true);	//on which day
		$start_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) );
		$end_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'end_date',true))) );
		
		//sort out week one, get starting days and then days that match time span of event (i.e. remove past events in week 1)
		$weekdays = explode(",", get_post_meta($post_id,'recurrence_bydays',true));
		$matching_days = array(); 
		$aDay = 86400;  // a day in seconds
		$aWeek = $aDay * 7;
			$start_of_week = get_option('start_of_week'); //Start of week depends on WordPress
			//first, get the start of this week as timestamp
			$event_start_day = date('w', $start_date);
			$offset = 0;
			if( $event_start_day > $start_of_week ){
				$offset = $event_start_day - $start_of_week; //x days backwards
			}elseif( $event_start_day < $start_of_week ){
				$offset = $start_of_week;
			}
			$start_week_date = $start_date - ( ($event_start_day - $start_of_week) * $aDay );
			//then get the timestamps of weekdays during this first week, regardless if within event range
			$start_weekday_dates = array(); //Days in week 1 where there would events, regardless of event date range
			for($i = 0; $i < 7; $i++){
				$weekday_date = $start_week_date+($aDay*$i); //the date of the weekday we're currently checking
				$weekday_day = date('w',$weekday_date); //the day of the week we're checking, taking into account wp start of week setting
				if( in_array( $weekday_day, $weekdays) ){
					$start_weekday_dates[] = $weekday_date; //it's in our starting week day, so add it
				}
			}
			
			//for each day of eventful days in week 1, add 7 days * weekly intervals
			foreach ($start_weekday_dates as $weekday_date){
				//Loop weeks by interval until we reach or surpass end date
				while($weekday_date <= $end_date){
					if( $weekday_date >= $start_date && $weekday_date <= $end_date ){
						$matching_days[] = $weekday_date;
					}					
					$weekday_date = $weekday_date + strtotime("+$recurrence_interval week", date("Y-m-d",$weekday_date));
				}
			}//done!
			 sort($matching_days);
			 $tmd = count($matching_days);
			 for($z=0;$z<count($matching_days);$z++)
			{
				$class= ($z%2) ? "odd" : "even";
				$st_date1 = $matching_days[$z];
				if($z <= ($tmd-1)){
					if($recurrence_days==0)
						$recurrence_days=1;
					for($rd=0;$rd<$recurrence_days;$rd++)
					{
						$st_date1 = strtotime(date("Y-m-d", $matching_days[$z]) . " +$rd day");
						$st_date .= date("Y-m-d", $st_date1).",";
					}
				}
			}

	}
	
	if($recurrence_occurs == 'monthly' )
	{
		$recurrence_interval = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$recurrence_byweekno = get_post_meta($post_id,'monthly_recurrence_byweekno',true);	//on which day
		$l = 0;
		$month_week = 0;
		$count_recurrence = 0;
		$current_month = 0;
		$recurrence_list .= "<ul>";
		
			if(strstr(get_post_meta($post_id,'recurrence_bydays',true),","))
				$recurrence_byday = explode(',',get_post_meta($post_id,'recurrence_byday',true));	//on which day
			else
				$recurrence_byday = get_post_meta($post_id,'recurrence_byday',true);	//on which day
			$start_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) );
			$end_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'end_date',true))) );
		
		$matching_days = array(); 
		$aDay = 86400;  // a day in seconds
		$aWeek = $aDay * 7;		 
		$current_arr = getdate($start_date);
		$end_arr = getdate($end_date);
		$end_month_date = strtotime( date('Y-m-t', $end_date) ); //End date on last day of month
		$current_date = strtotime( date('Y-m-1', $start_date) ); //Start date on first day of month
		while( $current_date <= $end_month_date ){
			 $last_day_of_month = date('t', $current_date);
			//Now find which day we're talking about
			$current_week_day = date('w',$current_date);
			$matching_month_days = array();
			//Loop through days of this years month and save matching days to temp array
			for($day = 1; $day <= $last_day_of_month; $day++){
				if((int) $current_week_day == $recurrence_byday){
					$matching_month_days[] = $day;
				}
				$current_week_day = ($current_week_day < 6) ? $current_week_day+1 : 0;							
			}
			//Now grab from the array the x day of the month
			$matching_day = ($recurrence_byweekno > 0) ? $matching_month_days[$recurrence_byweekno-1] : array_pop($matching_month_days);
			$matching_date = strtotime(date('Y-m',$current_date).'-'.$matching_day);
			if($matching_date >= $start_date && $matching_date <= $end_date){
				$matching_days[] = $matching_date;
			}
			//add the number of days in this month to make start of next month
			$current_arr['mon'] += $recurrence_interval;
			if($current_arr['mon'] > 12){
				//FIXME this won't work if interval is more than 12
				$current_arr['mon'] = $current_arr['mon'] - 12;
				$current_arr['year']++;
			}
			$current_date = strtotime("{$current_arr['year']}-{$current_arr['mon']}-1"); 
			
		}
		sort($matching_days);
			$tmd = count($matching_days);
			 for($z=0;$z<count($matching_days);$z++)
			{
				$class= ($z%2) ? "odd" : "even";
				$st_date1 = $matching_days[$z];
				date("Y-m-d", $matching_days[$z]);
				if($z <= ($tmd-1)){
					if($recurrence_days==0)
						$recurrence_days=1;
					for($rd=0;$rd<$recurrence_days;$rd++)
					{
						$st_date2 = strtotime(date("Y-m-d", $matching_days[$z]) . " +$rd day");
						$st_date .= date("Y-m-d", $st_date2).",";
					}
				}
			}
			
	}
	if($recurrence_occurs == 'yearly' )
	{
		$date1 = get_post_meta($post_id,'st_date',true);
		$date2 = get_post_meta($post_id,'end_date',true);
		$st_startdate1 = explode("-",$date1);
		$st_year = $st_startdate1[0];
		$st_month = $st_startdate1[1];
		$st_day = $st_startdate1[2];
		$st_date1 = mktime(0, 0, 0, $st_month, $st_day, $st_year);
		$st_date__month = (int)date('n', $st_date1); //get the current month of start date.
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years_between = floor($diff / (365*60*60*24));
		$recurrence_list .= "<ul>";
		for($i=0;$i<($years_between+1);$i++)
		{
			$class= ($i%2) ? "odd" : "even";
			$startdate = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$i year");
			$startdate1 = explode("-",date('Y-m-d',$startdate));
			$year = $startdate1[0];
			$month = $startdate1[1];
			$day = $startdate1[2];
			$date2 = mktime(0, 0, 0, $month, $day, $year);
			$month = (int)date('n', $date2); //get the current month.
			
			if($month == $st_date__month  && $i%$recurrence_per == 0)
			{				
				$st_date1 = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))). " +$i year");
				if($recurrence_days==0)
					$recurrence_days=1;
				for($rd=0;$rd<$recurrence_days;$rd++)
				{
					$st_date2 = strtotime(date("Y-m-d", $st_date1) . " +$rd day");
					$st_date .= date("Y-m-d", $st_date2).",";
				}

			}
			else
			{
				continue;
			}
		}
	}
	return $st_date;
}
/* function to show facebook share button BOF */

function facebook_meta_tags($post){
	global $post; 
	$post_title = $post->post_title;
	$img = bdw_get_images($post->ID,'thumb');
	echo '<meta property="og:title" content="'.$post_title.'" /> 
	<meta property="og:image" content="'.$img[0].'" /> ';
}
/* function to show facebook share button EOF */
if(strstr($_SERVER['REQUEST_URI'],'wp-admin') && isset($_REQUEST['event_type']) && ($_REQUEST['post_type'] ==  'event') && isset($_REQUEST['action'])  && $_REQUEST['action'] == 'editpost') 
{
	//$pID = $_POST['post_ID'];
	//save_recurring_event($pID);
}
function save_recurring_event($last_postid,$recurring_event_type='')
{
	global $wpdb,$last_postid,$post;
	
	/* save editional data when submit event from front end */
	if(!strstr($_SERVER['REQUEST_URI'],'wp-admin') && get_post_type( $last_postid) == CUSTOM_POST_TYPE1)
	{
	 	$post_address 	= $_SESSION['theme_info']['address'];
		$latitude 		= $_SESSION['theme_info']['geo_latitude'];
		$longitude 		= $_SESSION['theme_info']['geo_longitude'];
		
		$event_type = $_SESSION['theme_info']['event_type'];
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring event')))
		{
			
			$st_date = get_post_meta($last_postid,'st_date',true);
			$end_date = get_post_meta($last_postid,'end_date',true);
			$args =	array( 
							'post_type' => 'event',
							'posts_per_page' => 1	,
							'post_status' => 'recurring',
							'meta_query' => array(
							'relation' => 'AND',
								array(
										'key' => '_event_id',
										'value' => $last_postid,
										'compare' => '=',
										'type'=> 'text'
									),
								)
							);
				$post_query = null;
				$child_data = new WP_Query($args);
			if(($_SESSION['theme_info']['st_date'] != $st_date  || $_SESSION['theme_info']['end_date'] != $end_date) || ($child_data->posts[0]->post_title != get_the_title($last_postid) ) || ($child_data->posts[0]->post_content != get_post_field('post_content', $last_postid)) || $_SESSION['theme_info']['allow_to_create_rec'] =='yes' )
			{
				$parent_data = get_post($last_postid);
				$parent_post_status = get_post_meta($last_postid,'tmpl_post_status',true);
				$fetch_status = 'recurring';
				/* to delete the old recurrences BOF */
				$args =	array( 
							'post_type' => 'event',
							'posts_per_page' => -1	,
							'post_status' => array($fetch_status),
							'meta_query' => array(
							'relation' => 'AND',
								array(
										'key' => '_event_id',
										'value' => $last_postid,
										'compare' => '=',
										'type'=> 'text'
									),
								)
							);
				$post_query = null;
				$post_query = new WP_Query($args);
				
				if($post_query){
					while ($post_query->have_posts()) : $post_query->the_post();
							wp_delete_post($post->ID);
					endwhile;
					wp_reset_query();
				}
				update_post_meta($last_postid, 'recurrence_occurs', $_SESSION['theme_info']['recurrence_occurs']);
				update_post_meta($last_postid, 'recurrence_per', $_SESSION['theme_info']['recurrence_per']);
				update_post_meta($last_postid, 'recurrence_onday', $_SESSION['theme_info']['recurrence_onday']);
		
				update_post_meta($last_postid, 'recurrence_bydays', implode(',',$_SESSION['theme_info']['recurrence_bydays']));
				if($_SESSION['theme_info']['featured_type'])
				{ 
					if($_SESSION['theme_info']['featured_type']):
						if($_SESSION['theme_info']['featured_type'] == 'both'):
							 update_post_meta($last_postid, 'featured_c', 'c');
							 update_post_meta($last_postid, 'featured_h', 'h');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;
						if($_SESSION['theme_info']['featured_type'] == 'c'):
							 update_post_meta($last_postid, 'featured_c', 'c');
							 update_post_meta($last_postid, 'featured_h', 'n');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;	 
						if($_SESSION['theme_info']['featured_type'] == 'h'):
							 update_post_meta($last_postid, 'featured_h', 'h');
							 update_post_meta($last_postid, 'featured_c', 'n');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;
						if($_SESSION['theme_info']['featured_type'] == 'none'):
							 update_post_meta($last_postid, 'featured_h', 'n');
							 update_post_meta($last_postid, 'featured_c', 'n');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;	 
					else:
						 update_post_meta($last_postid, 'featured_type', 'none');
						 update_post_meta($last_postid, 'featured_c', 'n');
						 update_post_meta($last_postid, 'featured_h', 'n');
					endif;
				}
				update_post_meta($last_postid, 'recurrence_onweekno', $_SESSION['theme_info']['recurrence_onweekno']);
				update_post_meta($last_postid, 'recurrence_days', $_SESSION['theme_info']['recurrence_days']);	
				update_post_meta($last_postid, 'monthly_recurrence_byweekno', $_SESSION['theme_info']['monthly_recurrence_byweekno']);	
				update_post_meta($last_postid, 'recurrence_byday', $_SESSION['theme_info']['recurrence_byday']);	
				update_post_meta($last_postid, 'st_date', $_SESSION['theme_info']['st_date']);	
				update_post_meta($last_postid, 'end_date', $_SESSION['theme_info']['end_date']);	
				update_post_meta($last_postid, 'st_time', $_SESSION['theme_info']['st_time']);	
				update_post_meta($last_postid, 'end_time', $_SESSION['theme_info']['end_time']);	
				update_post_meta($last_postid, 'address', $_SESSION['theme_info']['address']);
				templ_save_recurrence_events( $_SESSION['theme_info'],$last_postid);// to save event recurrences - front end
			}
			/* to delete the old recurrences EOF */
		
			$start_date = templ_recurrence_dates($last_postid);
			update_post_meta($last_postid,'recurring_search_date',$start_date);
	
			
		}
		 $event_type_regular = get_post_meta($last_postid,'event_type',true);
		if(trim(strtolower($event_type_regular)) == trim(strtolower('Recurring event')) && trim(strtolower($event_type)) == trim(strtolower('Regular event')))
		{
			
			$st_date = get_post_meta($last_postid,'st_date',true);
			$end_date = get_post_meta($last_postid,'end_date',true);
			
				$parent_data = get_post($last_postid);
				$parent_post_status = get_post_meta($last_postid,'tmpl_post_status',true);
				$fetch_status = 'recurring';
				/* to delete the old recurrences BOF */
				$args =	array( 
							'post_type' => 'event',
							'posts_per_page' => -1	,
							'post_status' => array($fetch_status),
							'meta_query' => array(
							'relation' => 'AND',
								array(
										'key' => '_event_id',
										'value' => $last_postid,
										'compare' => '=',
										'type'=> 'text'
									),
								)
							);
				$post_query = null;
				$post_query = new WP_Query($args);
				if($post_query){
					while ($post_query->have_posts()) : $post_query->the_post();
							wp_delete_post($post->ID);
					endwhile;
					wp_reset_query();
				}
				
				update_post_meta($last_postid, 'recurrence_occurs', $_SESSION['theme_info']['recurrence_occurs']);
				update_post_meta($last_postid, 'recurrence_per', $_SESSION['theme_info']['recurrence_per']);
				update_post_meta($last_postid, 'recurrence_onday', $_SESSION['theme_info']['recurrence_onday']);
		
				update_post_meta($last_postid, 'recurrence_bydays', implode(',',$_SESSION['theme_info']['recurrence_bydays']));
				if($_SESSION['custom_fields']['featured_type'])
				{ 
					if($_SESSION['theme_info']['featured_type']):
						if($_SESSION['theme_info']['featured_type'] == 'both'):
							 update_post_meta($last_postid, 'featured_c', 'c');
							 update_post_meta($last_postid, 'featured_h', 'h');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;
						if($_SESSION['theme_info']['featured_type'] == 'c'):
							 update_post_meta($last_postid, 'featured_c', 'c');
							 update_post_meta($last_postid, 'featured_h', 'n');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;	 
						if($_SESSION['theme_info']['featured_type'] == 'h'):
							 update_post_meta($last_postid, 'featured_h', 'h');
							 update_post_meta($last_postid, 'featured_c', 'n');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;
						if($_SESSION['theme_info']['featured_type'] == 'none'):
							 update_post_meta($last_postid, 'featured_h', 'n');
							 update_post_meta($last_postid, 'featured_c', 'n');
							 update_post_meta($last_postid, 'featured_type', $_SESSION['theme_info']['featured_type']);
						endif;	 
					else:
						 update_post_meta($last_postid, 'featured_type', 'none');
						 update_post_meta($last_postid, 'featured_c', 'n');
						 update_post_meta($last_postid, 'featured_h', 'n');
					endif;
				}
				update_post_meta($last_postid, 'recurrence_onweekno', $_SESSION['theme_info']['recurrence_onweekno']);
				update_post_meta($last_postid, 'recurrence_days', $_SESSION['theme_info']['recurrence_days']);	
				update_post_meta($last_postid, 'monthly_recurrence_byweekno', $_SESSION['theme_info']['monthly_recurrence_byweekno']);	
				update_post_meta($last_postid, 'recurrence_byday', $_SESSION['theme_info']['recurrence_byday']);	
				update_post_meta($last_postid, 'st_date', $_SESSION['theme_info']['st_date']);	
				update_post_meta($last_postid, 'end_date', $_SESSION['theme_info']['end_date']);	
				update_post_meta($last_postid, 'st_time', $_SESSION['theme_info']['st_time']);	
				update_post_meta($last_postid, 'end_time', $_SESSION['theme_info']['end_time']);	
				update_post_meta($last_postid, 'address', $_SESSION['theme_info']['address']);	
			//	templ_save_recurrence_events( $_SESSION['custom_fields'],$last_postid);// to save event recurrences - front end
			
			/* to delete the old recurrences EOF */
		
			$start_date = templ_recurrence_dates($last_postid);
			update_post_meta($last_postid,'recurring_search_date',$start_date);
	
			
		}
		
	}
	
	/* save editional data when submit event from backend */
	if(strstr($_SERVER['REQUEST_URI'],'wp-admin') && isset($_REQUEST['event_type']) && isset($_REQUEST['action'])  && $_REQUEST['action'] == 'editpost') 
	{
		$event_type = $_POST['event_type'];
		$pID = $_POST['post_ID'];
		
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring event')) && isset($_POST['post_type']) &&  $_POST['post_type'] == 'event')
		{
			update_post_meta($pID, 'recurrence_occurs', $_POST['recurrence_occurs']);
			update_post_meta($pID, 'recurrence_per', $_POST['recurrence_per']);
			update_post_meta($pID, 'recurrence_onday', $_POST['recurrence_onday']);
	
			update_post_meta($pID, 'recurrence_bydays', implode(',',$_POST['recurrence_bydays']));
	
			update_post_meta($pID, 'recurrence_onweekno', $_POST['recurrence_onweekno']);
			update_post_meta($pID, 'recurrence_days', $_POST['recurrence_days']);	
			update_post_meta($pID, 'monthly_recurrence_byweekno', $_POST['monthly_recurrence_byweekno']);	
			update_post_meta($pID, 'recurrence_byday', $_POST['recurrence_byday']);	
			update_post_meta($pID, 'allow_to_create_rec', $_POST['allow_to_create_rec']);
		}
		if(trim(strtolower($event_type)) == trim(strtolower('Recurring event')) && isset($_POST['post_type']) &&  $_POST['post_type'] == 'event' )
		{ 
			$start_date = templ_recurrence_dates($pID);
			$post_data = $_POST;
			$parent_data = get_post($pID);
			$st_date = get_post_meta($pID,'st_date',true);
			$end_date = get_post_meta($pID,'end_date',true);
			if($_POST['old_st_date'] != $st_date  || $_POST['old_end_date'] != $end_date || $_POST['allow_to_create_rec'] =='yes')
			{
				$parent_post_status = get_post_meta($pID,'tmpl_post_status',true);
				
					$fetch_status = 'recurring';
				
				/* to delete the old recurrences BOF */
				$args =	array( 
							'post_type' => 'event',
							'posts_per_page' => -1	,
							'post_status' => array($fetch_status),
							'meta_query' => array(
							'relation' => 'AND',
								array(
										'key' => '_event_id',
										'value' => $pID,
										'compare' => '=',
										'type'=> 'text'
									),
								)
							);
				$post_query = null;
				$post_query = new WP_Query($args);
				if($post_query){
					while ($post_query->have_posts()) : $post_query->the_post();
							wp_delete_post($post->ID);
						 
					endwhile;
					wp_reset_query();
				}
				/* to delete the old recurrences EOF */
				templ_save_recurrence_events($post_data,$pID);// to save event recurrences
			}
			
			update_post_meta($pID,'recurring_search_date',$start_date);
			
		}
		
		if(trim(strtolower($recurring_event_type)) == trim(strtolower('Recurring event')) && trim(strtolower($event_type)) == trim(strtolower('Regular event')))
		{
			$pID = $_REQUEST['post'];
			$event_type = get_post_meta($pID,'event_type',true);
			$post_type = get_post_type($pID);

				/* to delete the old recurrences BOF */
				$args =	array( 
							'post_type' => 'event',
							'posts_per_page' => -1	,
							'post_status' => array('recurring'),
							'meta_query' => array(
							'relation' => 'AND',
								array(
										'key' => '_event_id',
										'value' => $pID,
										'compare' => '=',
										'type'=> 'text'
									),
								)
							);
				$post_query = null;
				$post_query = new WP_Query($args);
				if($post_query){
					while ($post_query->have_posts()) : $post_query->the_post();
						wp_delete_post($post->ID);
					endwhile;
					wp_reset_query();
				
				/* to delete the old recurrences EOF */
			}
		}
	}
	/* delete additional data event from backend */
	if(strstr($_SERVER['REQUEST_URI'],'wp-admin')  && isset($_REQUEST['action'])  && $_REQUEST['action'] == 'trash') 
	{
		$pID = $_REQUEST['post'];
		$event_type = get_post_meta($pID,'event_type',true);
		$post_type = get_post_type($pID);

		if(trim(strtolower($event_type)) == trim(strtolower('Recurring event')) && isset($post_type) &&  $post_type == 'event' )
		{ 
			/* to delete the old recurrences BOF */
			$args =	array( 
						'post_type' => 'event',
						'posts_per_page' => -1	,
						'post_status' => array('recurring'),
						'meta_query' => array(
						'relation' => 'AND',
							array(
									'key' => '_event_id',
									'value' => $pID,
									'compare' => '=',
									'type'=> 'text'
								),
							)
						);
			$post_query = null;
			$post_query = new WP_Query($args);
			if($post_query){
				while ($post_query->have_posts()) : $post_query->the_post();
					wp_delete_post($post->ID);
				endwhile;
				wp_reset_query();
			}
			/* to delete the old recurrences EOF */
		}
	}
}




/*
 *Function Name : templ_recurrence_dates
 *Description : return recurrence dates.
 */
function templ_save_recurrence_events($post_data,$pID)
{

	global $wpdb,$current_user;
	$post_id = $pID;
	$start_date = strtotime(get_post_meta($post_id,'st_date',true));
	$end_date = strtotime(get_post_meta($post_id,'end_date',true));
	$tmpl_end_date = strtotime(get_post_meta($post_id,'end_date',true));
    $recurrence_occurs = get_post_meta($post_id,'recurrence_occurs',true);//reoccurence type
	$recurrence_per = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
	$current_date = date('Y-m-d');
	$recurrence_days = get_post_meta($post_id,'recurrence_days',true);	//on which day
	$recurrence_list = "";
	
	
	if($recurrence_occurs == 'daily' )
	{
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		for($i=0;$i<($days_between);$i++)
		{
			$class= ($i%2) ? "odd" : "even";
			if(($i%$recurrence_per) == 0 )
			{
				$j = $i+$recurrence_days;
				$st_date1 = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$i day");
				if($recurrence_days==0)
					$recurrence_days=1;
				
				$st_date2 = strtotime(date("Y-m-d", $st_date1) );
				$st_date = date('Y-m-d',$st_date2);
				if($recurrence_days ==1):
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date))));
					else:
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date)) . " +".($recurrence_days-1)." day"));
				
					endif;
				if($tmpl_end_date < strtotime($end_date)){
					$end_date = date("Y-m-d", $tmpl_end_date);
				}
				templ_update_rec_data($post_data,$post_id,$st_date,$end_date);

			}
			else
			{
				continue;
			}
		}
	}
	if($recurrence_occurs == 'weekly' )
	{ 
		$recurrence_interval = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$l = 0;
		$count_recurrence = 0;
		$current_week = 0;
		$recurrence_list .= "<ul>";
		
		if(strstr(get_post_meta($post_id,'recurrence_bydays',true),","))
			$recurrence_byday = explode(',',get_post_meta($post_id,'recurrence_byday',true));	//on which day
		else
			$recurrence_byday = get_post_meta($post_id,'recurrence_byday',true);	//on which day
		$start_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) );
		$end_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'end_date',true))) );
		
		//sort out week one, get starting days and then days that match time span of event (i.e. remove past events in week 1)
		$weekdays = explode(",", get_post_meta($post_id,'recurrence_bydays',true));
		$matching_days = array(); 
		$aDay = 86400;  // a day in seconds
		$aWeek = $aDay * 7;
			$start_of_week = get_option('start_of_week'); //Start of week depends on WordPress
			//first, get the start of this week as timestamp
			$event_start_day = date('w', $start_date);
			$offset = 0;
			if( $event_start_day > $start_of_week ){
				$offset = $event_start_day - $start_of_week; //x days backwards
			}elseif( $event_start_day < $start_of_week ){
				$offset = $start_of_week;
			}
			$start_week_date = $start_date - ( ($event_start_day - $start_of_week) * $aDay );
			//then get the timestamps of weekdays during this first week, regardless if within event range
			$start_weekday_dates = array(); //Days in week 1 where there would events, regardless of event date range
			for($i = 0; $i < 7; $i++){
				$weekday_date = $start_week_date+($aDay*$i); //the date of the weekday we're currently checking
				$weekday_day = date('w',$weekday_date); //the day of the week we're checking, taking into account wp start of week setting
				if( in_array( $weekday_day, $weekdays) ){
					$start_weekday_dates[] = $weekday_date; //it's in our starting week day, so add it
				}
			}
	
			//for each day of eventful days in week 1, add 7 days * weekly intervals
			foreach ($start_weekday_dates as $weekday_date){
				//Loop weeks by interval until we reach or surpass end date
				
				while($weekday_date <= $end_date){
					if( $weekday_date >= $start_date && $weekday_date <= $end_date ){
						$matching_days[] = $weekday_date;
					}					
					$weekday_date = $weekday_date + strtotime("+$recurrence_interval week", date("Y-m-d",$weekday_date));
				}
			}//done!
			 sort($matching_days);
			 $tmd = count($matching_days);
			 for($z=0;$z<count($matching_days);$z++)
			{
				$st_date1 = $matching_days[$z];
				if($z <= ($tmd-1)){
					if($recurrence_days==0)
						$recurrence_days=1;
				
					$st_date2 = strtotime(date("Y-m-d", $matching_days[$z]));
					$st_date = date('Y-m-d',$st_date2);
					if($recurrence_days ==1):
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date))));
					else:
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date)) . " +".($recurrence_days-1)." day"));
				
					endif;
					if($tmpl_end_date < strtotime($end_date)){
						$end_date = date("Y-m-d", $tmpl_end_date);
					}
					templ_update_rec_data($post_data,$post_id,$st_date,$end_date);
				
				}
			}

	}

	if($recurrence_occurs == 'monthly' )
	{
		$recurrence_interval = get_post_meta($post_id,'recurrence_per',true);//no. of occurence.
		$days_between = ceil(abs($end_date - $start_date) / 86400);
		$recurrence_byweekno = get_post_meta($post_id,'monthly_recurrence_byweekno',true);	//on which day
		$l = 0;
		$month_week = 0;
		$count_recurrence = 0;
		$current_month = 0;
		$recurrence_list .= "<ul>";
		
			if(strstr(get_post_meta($post_id,'recurrence_bydays',true),","))
				$recurrence_byday = explode(',',get_post_meta($post_id,'recurrence_byday',true));	//on which day
			else
				$recurrence_byday = get_post_meta($post_id,'recurrence_byday',true);	//on which day
			$start_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) );
			$end_date = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'end_date',true))) );
		
		$matching_days = array(); 
		$aDay = 86400;  // a day in seconds
		$aWeek = $aDay * 7;		 
		$current_arr = getdate($start_date);
		$end_arr = getdate($end_date);
		$end_month_date = strtotime( date('Y-m-t', $end_date) ); //End date on last day of month
		$current_date = strtotime( date('Y-m-1', $start_date) ); //Start date on first day of month
		while( $current_date <= $end_month_date ){
			 $last_day_of_month = date('t', $current_date);
			//Now find which day we're talking about
			$current_week_day = date('w',$current_date);
			$matching_month_days = array();
			//Loop through days of this years month and save matching days to temp array
			for($day = 1; $day <= $last_day_of_month; $day++){
				if((int) $current_week_day == $recurrence_byday){
					$matching_month_days[] = $day;
				}
				$current_week_day = ($current_week_day < 6) ? $current_week_day+1 : 0;							
			}
			//Now grab from the array the x day of the month
			$matching_day = ($recurrence_byweekno > 0) ? $matching_month_days[$recurrence_byweekno-1] : array_pop($matching_month_days);
			$matching_date = strtotime(date('Y-m',$current_date).'-'.$matching_day);
			if($matching_date >= $start_date && $matching_date <= $end_date){
				$matching_days[] = $matching_date;
			}
			//add the number of days in this month to make start of next month
			$current_arr['mon'] += $recurrence_interval;
			if($current_arr['mon'] > 12){
				//FIXME this won't work if interval is more than 12
				$current_arr['mon'] = $current_arr['mon'] - 12;
				$current_arr['year']++;
			}
			$current_date = strtotime("{$current_arr['year']}-{$current_arr['mon']}-1"); 
			
		}
		sort($matching_days);
			$tmd = count($matching_days);
			 for($z=0;$z<count($matching_days);$z++)
			{
				$class= ($z%2) ? "odd" : "even";
				$st_date1 = $matching_days[$z];
				date("Y-m-d", $matching_days[$z]);
				if($z <= ($tmd-1)){
					if($recurrence_days==0)
						$recurrence_days=1;
				
					$st_date2 = strtotime(date("Y-m-d", $matching_days[$z]) );
					$st_date = date("Y-m-d", $st_date2);
					if($recurrence_days ==1):
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date))));
					else:
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date)) . " +".($recurrence_days-1)." day"));
				
					endif;
					if($tmpl_end_date < strtotime($end_date)){
						$end_date = date('Y-m-d',strtotime(date("Y-m-d", $tmpl_end_date)));
					}

					templ_update_rec_data($post_data,$post_id,$st_date,$end_date);

				}

			}
			
	}
	if($recurrence_occurs == 'yearly' )
	{

		$date1 = get_post_meta($post_id,'st_date',true);
		$date2 = get_post_meta($post_id,'end_date',true);
		$st_startdate1 = explode("-",$date1);
		$st_year = $st_startdate1[0];
		$st_month = $st_startdate1[1];
		$st_day = $st_startdate1[2];
		$st_date1 = mktime(0, 0, 0, $st_month, $st_day, $st_year);
		$st_date__month = (int)date('n', $st_date1); //get the current month of start date.
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years_between = floor($diff / (365*60*60*24));
		$recurrence_list .= "<ul>";
		for($i=0;$i<($years_between+1);$i++)
		{
			$class= ($i%2) ? "odd" : "even";
			$startdate = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))) . " +$i year");
			$startdate1 = explode("-",date('Y-m-d',$startdate));
			$year = $startdate1[0];
			$month = $startdate1[1];
			$day = $startdate1[2];
			$date2 = mktime(0, 0, 0, $month, $day, $year);
			$month = (int)date('n', $date2); //get the current month.
			
			if($month == $st_date__month  && $i%$recurrence_per == 0 )
			{				
				$st_date1 = strtotime(date("Y-m-d", strtotime(get_post_meta($post_id,'st_date',true))). " +$i year");
				if($recurrence_days==0)
					$recurrence_days=1;
				
				$st_date2 = strtotime(date("Y-m-d", $st_date1));
				$st_date = date("Y-m-d", $st_date2);
				if($recurrence_days ==1):
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date))));
				else:
						$end_date =  date('Y-m-d',strtotime(date("Y-m-d", strtotime($st_date)) . " +".($recurrence_days-1)." day"));
				
				endif;
				if($tmpl_end_date < strtotime($end_date)){
					$end_date = date("Y-m-d", $tmpl_end_date);
				}
				$main_event_end_date = strtotime(get_post_meta($post_id,'end_date',true));
			
				if($main_event_end_date >= $st_date2)
					templ_update_rec_data($post_data,$post_id,$st_date,$end_date);

			}
			else
			{
				continue;
			}
		}
	}

}
/*
Name : templ_update_rec_data
Description : it's update other recurrances while update the evenets
*/	

function templ_update_rec_data($post_data,$post_id,$st_date,$end_date){
	
	global $wpdb,$post;
	remove_action('save_post', 'ptthemes_event_metabox_insert');
	$recurring_update = $_REQUEST['recurring_update'];
	$parent_data = get_post($post_id);

	if(!strstr($_SERVER['REQUEST_URI'],'wp-admin'))
		update_post_meta($post_id,'tmpl_post_status',$parent_data->post_status);
	
	$parent_post_status = get_post_meta($parent_data->ID,'tmpl_post_status',true);
	$p_status = $parent_data->post_status;
	if($parent_post_status =='draft' && $p_status == 'draft'){
		$child_status = 'pending';
	}else{
		$child_status = 'recurring';
	}
	if((isset($recurring_update) && $recurring_update != ''))
	{
		$post_details = array('post_title' => $post_data->post_title,
					'post_content' => $post_data->post_content,
					'post_status' => $child_status,
					'post_type' => 'event',
					'post_name' => str_replace(' ','-',$post_data->post_title)."-".$st_date,
					'post_parent' => $post_id,
				  );
	}
	elseif(strstr($_SERVER['REQUEST_URI'],'wp-admin'))
	{
		
		$post_details = array('post_title' => $post_data['post_title'],
					'post_content' => $post_data['post_content'],
					'post_status' => $child_status,
					'post_type' => 'event',
					'post_name' => str_replace(' ','-',$post_data['post_title'])."-".$st_date,
					'post_parent' => $post_id,
				  );
	}
	else
	{
		$post_details = array('post_title' => stripslashes($post_data['event_name']),
					'post_content' => stripslashes($post_data['proprty_desc']),
					'post_status' => $child_status,
					'post_type' => 'event',
					'post_name' => str_replace(' ','-',stripslashes($post_data['post_title']))."-".$st_date,
					'post_parent' => $post_id,
				  );
	}
	$alive_days = get_post_meta($post_id,'alive_days',true);
	$last_rec_post_id = wp_insert_post($post_details); // insert recurrences of events 
	$tl_dummy_content = get_post_meta($post_id,'tl_dummy_content',true);
	
	$where = array( 'post_parent' => $post_id , 'post_type' => 'event' );
	$wpdb->update( $wpdb->posts, array( 'post_status' => $child_status ), $where );
	
	if(isset($recurring_update) && $recurring_update != '')
		tmpl_set_my_categories($last_rec_post_id,$post_id); // assign category of parent post
	if((isset($_REQUEST['tax_input']['eventcategory']) && $_REQUEST['tax_input']['eventcategory']!='') || $_SESSION['theme_info']['category'] !='' || $_SESSION['category'])
		tmpl_set_my_categories($last_rec_post_id,$post_id); // assign category of parent post
	if(isset($_SESSION['theme_info']['pid']) && $_SESSION['theme_info']['pid'] != '')
		tmpl_set_my_categories($last_rec_post_id,$post_id); 

	if(isset($tl_dummy_content) && $tl_dummy_content != '')
	{
		tmpl_set_my_categories($last_rec_post_id,$post_id); 
		update_post_meta($last_rec_post_id,'tl_dummy_content',1);
	}
	$st_time = get_post_meta($post_id,'st_time',true);
	$end_time = get_post_meta($post_id,'end_time',true);
	$address = get_post_meta($post_id,'address',true);
	$featured_type = get_post_meta($post_id,'featured_type',true);
	$featured_h = get_post_meta($post_id,'featured_h',true);
	$featured_c = get_post_meta($post_id,'featured_c',true);
	/* add parent post valy with different date and time */
	update_post_meta($last_rec_post_id,'event_type','Regular event'); 
	update_post_meta($last_rec_post_id,'end_date',$end_date); 
	update_post_meta($last_rec_post_id,'st_date',$st_date);
	update_post_meta($last_rec_post_id,'st_time',$st_time);
	update_post_meta($last_rec_post_id,'end_time',$end_time);
	update_post_meta($last_rec_post_id,'_event_id',$post_id); 
	update_post_meta($last_rec_post_id,'address',$address); 
	update_post_meta($last_rec_post_id,'alive_days',$alive_days); 
	update_post_meta($last_rec_post_id,'featured_type',$featured_type); 
	update_post_meta($last_rec_post_id,'featured_h',$featured_h); 
	update_post_meta($last_rec_post_id,'featured_c',$featured_c); 
}
/*
Name : tmpl_set_my_categories
Description : set the categories of recurrence events 
*/
function tmpl_set_my_categories($last_rec_post_id,$post_id=''){
global $wpdb,$post;
	$cat_1 = "";
		$recurring_update = $_REQUEST['recurring_update'];
		$tl_dummy_content = get_post_meta($post_id,'tl_dummy_content',true);
		if(strstr($_SERVER['REQUEST_URI'],'wp-admin') && !isset($recurring_update) && $recurring_update == ''  && $tl_dummy_content == ''){
			$cats = $_REQUEST['tax_input']['eventcategory']; 
			$tags = $_REQUEST['tax_input']['eventtags']; 
			$tags = explode(',',$tags);
		}else if(isset($recurring_update) && $recurring_update != '')
		{
			$terms = wp_get_post_terms( $post_id, 'eventcategory' , array("fields" => "all"));
			$terms_tag = wp_get_post_terms( $post_id, 'eventtags' );
			
			$cat_count = count($terms);
			$sep =",";
			
				for($c=0; $c < $cat_count ; $c++){
					
					if(($cat_count - 1)  == $c)
						$sep = "";
					$cat_1 .= $terms[$c]->term_id.$sep;
				
				}
			
			$sep =",";
			$term_count = count($terms_tag);
			{
				for($c=0; $c < $term_count ; $c++){
				
					if(($term_count - 1)  == $c)
						$sep = "";
					$tag_1 .= $terms_tag[$c]->name.$sep;
				
				}
				
			}
			$cats = explode(',',$cat_1);
			$tags = explode(',',$tag_1);
		}
		elseif((isset($_SESSION['theme_info']['pid']) && $_SESSION['theme_info']['pid'] != '') || (isset($tl_dummy_content) && $tl_dummy_content != ''))
		{
			$terms = wp_get_post_terms( $post_id, 'eventcategory' );
			$terms_tag = wp_get_post_terms( $post_id, 'eventtags' );
			
			$cat_count = count($terms);
			$sep =",";
			
				for($c=0; $c < $cat_count ; $c++){
					
					if(($cat_count - 1)  == $c)
						$sep = "";
					$cat_1 .= $terms[$c]->term_id.$sep;
				
				}
			
			$sep =",";
			$term_count = count($terms_tag);
			{
				for($c=0; $c < $term_count ; $c++){
				
					if(($term_count - 1)  == $c)
						$sep = "";
					$tag_1 .= $terms_tag[$c]->name.$sep;
				
				}
				
			}
			$cats = explode(',',$cat_1);
			$tags = explode(',',$tag_1);
		}
		else{
			if($_SESSION['theme_info']['category']){
				$cats = $_SESSION['theme_info']['category']; 
			}else{
				$cats = $_SESSION['theme_info']['category']; 
			}
			$tags = $_SESSION['theme_info']['e_tags']; 
			$sep =",";
			for($c=0; $c < count($cats) ; $c++){
				$cat_0 = explode(',',$cats[$c]);
				if((count($cats) - 1)  == $c)
					$sep = "";
				$cat_1 .= $cat_0[0].$sep;
				
			}
			$cats = explode(',',$cat_1);
		
		}

		wp_set_post_terms( $last_rec_post_id, $cats,'eventcategory' ,false);
		wp_set_post_terms( $last_rec_post_id, $tags,'eventtags' ,false);
}

/*
Name : delete_recurring_event
Description : to delete recurring data from front end.
*/
if(!strstr($_SERVER['REQUEST_URI'],'wp-admin') )
	add_action('delete_post', 'delete_recurring_event'); // to delete the post of old recurrencies

function delete_recurring_event()
{
	global $wpdb,$post,$post_id;

	/* to delete the old recurrences BOF */
	$args =	array( 
				'post_type' => 'event',
				'posts_per_page' => -1	,
				'post_status' => array('recurring'),
				'meta_query' => array(
				'relation' => 'AND',
					array(
							'key' => '_event_id',
							'value' => $_REQUEST['pid'],
							'compare' => '=',
							'type'=> 'text'
						),
					)
				);
	$post_query = null;
	$post_query = new WP_Query($args);
	if($post_query){
		while ($post_query->have_posts()) : $post_query->the_post();
			wp_delete_post($post->ID);
		endwhile;wp_reset_query();
	}
	remove_action('delete_post', 'delete_recurring_event');
	/* to delete the old recurrences EOF */
}

/*
Name : delete_recurring_event
Description : to delete recurring data from front end.
*/
if(strstr($_SERVER['REQUEST_URI'],'wp-admin') )
{
	add_action('trash_event', 'delete_admin_recurring_event',1,1); // to delete the post of old recurrencies
}
function delete_admin_recurring_event($post_id)
{
	global $wpdb,$post,$post_id;

	if(!is_array($_REQUEST['post']))
	{
		$_REQUEST['post'] = array($_REQUEST['post']);
	}
	 for($i=0;$i<count($_REQUEST['post']);$i++)
	 {
		/* to delete the old recurrences BOF */
		$args =	array( 
					'post_type' => 'event',
					'posts_per_page' => -1	,
					'post_status' => array('recurring'),
					'meta_query' => array(
					'relation' => 'AND',
						array(
								'key' => '_event_id',
								'value' =>$_REQUEST['post'][$i],
								'compare' => '=',
								'type'=> 'text'
							),
						)
					);
		$post_query = null;
		$post_query = new WP_Query($args);
		if($post_query){
			while ($post_query->have_posts()) : $post_query->the_post();
				wp_delete_post($post->ID);
			endwhile;wp_reset_query();
		}
	}
	remove_action('delete_post', 'delete_recurring_event');
	/* to delete the old recurrences EOF */
}
// for Custom Post Types
// add_filter('cpt_name_row_actions', 'tmpl_qe_download_link', 10, 2);

function tmpl_qe_download_link($actions, $post) {
	$post_status = trim(strtolower('Recurring'));
	if(trim(strtolower($post->post_status)) == $post_status  && $post->post_type =='event'){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
		$plugin = "woocommerce/woocommerce.php";
		$url = get_edit_post_link( $post->ID );
		if(is_plugin_active($plugin)){
			$actions['edit'] = "<a href='".$url."'>".__('Manage tickets',T_DOMAIN)."</a>";
		}else{
			unset($actions['edit'],$actions['trash']);
			$actions['status'] = "<strong>".__('Recurrence',T_DOMAIN)."</strong>";
		}
		unset($actions['inline hide-if-no-js'],$actions['trash']);
		
	}
    return $actions; 
}
/* code for remove the edit link from recurring events */
add_filter('post_row_actions', 'tmpl_qe_download_link', 10, 2);
add_action( 'admin_menu', 'tmpl_remove_meta_boxes' );
function tmpl_remove_meta_boxes($post_id)
{ 	
	//remove custom setting metabox in staff custom post type echo "asdhasdghasfdgh";
	global $post;
	if(isset($_REQUEST['post']) && $_REQUEST['post'] != '')
	{
		$post_edit = $_REQUEST['post'];
		$post = get_post($post_edit);
		if($post_edit !='' && $post->post_type =='event' && $post->post_parent != 0){
			global $post;
			$post_edit = $_REQUEST['post'];
			$post = get_post($post_edit);
			$post_status = trim(strtolower('Recurring'));
			if(trim(strtolower($post->post_status)) == $post_status && $_REQUEST['action'] =='edit'){
				remove_meta_box('ptthemes-settings', 'event', 'normal');
				remove_meta_box('trackbacksdiv', 'event', 'normal');
				remove_meta_box('slugdiv', 'event', 'normal');
				remove_meta_box('revisionsdiv', 'event', 'normal');
				remove_meta_box('authordiv', 'event', 'normal');
				remove_meta_box('ecategorydiv', 'event', 'normal');
				remove_meta_box('tagsdiv', 'event', 'normal');
				remove_meta_box('postimagediv', 'event', 'normal');
				remove_meta_box('post-stylesheets', 'event', 'normal');
			
				add_action('admin_init', 'remove_all_media_buttons');
			}
		}
	}
}

/* remove add media button for recurring post for events */
function remove_all_media_buttons()
{
    remove_all_actions('media_buttons');	
	add_meta_box('tmpl_recurring_dates','Event is on','tmpl_recurring_on','event','side','high');
}
/*
Name :tmpl_recurring_on
description : show recurring dates
*/
function tmpl_recurring_on($post){
	global $post;
	echo "<p class='error'>";
	_e('This event is the recurrence of the event.',T_DOMAIN);
	echo "</p>";
	$st_date = get_post_meta($post->ID,'st_date',true);
	$end_date =  get_post_meta($post->ID,'end_date',true);
	$st_time =  get_post_meta($post->ID,'st_time',true);
	$end_time =  get_post_meta($post->ID,'end_time',true);
	$address =  get_post_meta($post->ID,'address',true);
	if($st_date){
		echo "<p>";
		_e('Start date',DOMAIN); echo ": <b>". $st_date." ".$st_time."</b>"; 
		echo "</p>";
	}
	if($end_date){
		echo "<p>";
			_e('End date',DOMAIN); echo ": <b>".$end_date." ".$end_time."</b>";
		echo "</p>";
	}
	if($address){
		echo "<p>";
			_e('Address',DOMAIN); echo ": <b>".$address."</b>";
		echo "</p>";
	}
}
/*
Name : tmpl_is_parent
Description : return true if post have parent post
*/
function tmpl_is_parent($post){
	if($post->post_parent){
		return true;
	}else{
		return false;
	}
}

/*
Name :tmpl_the_title_trim
Desc : remove the title trim from post title when post is recurring
*/
function tmpl_the_title_trim($title) {
	$title = esc_attr($title);
	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);
	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);
	
	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
/*
 * add action for recurring event to reinsert if when start or end date is changed
 */
add_action('admin_init','event_add_old_st_date');
function event_add_old_st_date()
{
	add_action('tmpl_custom_fields_st_date_after','admin_event_old_date');
}
function admin_event_old_date()
{
	$post_id = $_REQUEST['post'];
	echo  '<input  type="hidden" value="'.get_post_meta($post_id,'st_date',true).'" name="old_st_date" id="old_st_date" />'."\n";
	echo  '<input  type="hidden" value="'.get_post_meta($post_id,'end_date',true).'" name="old_end_date" id="old_end_date" />'."\n";
}
add_action('init','tmpl_single_page_title',11); // remove Private text form recurring post 
function tmpl_single_page_title(){
	add_filter('the_title', 'tmpl_the_title_trim');
	
	/* upgrade old database querries */
	
	if(isset($_REQUEST['recurring_update']) && $_REQUEST['recurring_update'] == 'true'){
		global $wpdb,$post;
		/* to delete the old recurrences BOF */
		$args =	array( 
					'post_type' => 'event',
					'posts_per_page' => -1	,
					'post_status' => array('publish'),
					'meta_query' => array(
					'relation' => 'AND',
						array(
								'key' => 'event_type',
								'value' => 'Recurring event',
								'compare' => 'LIKE',
								'type'=> 'text'
							),
						)
					);
		$rec_query = null;
		$rec_query = new WP_Query($args);
		
		if($rec_query){
			while ($rec_query->have_posts()) : $rec_query->the_post();
			
				$post_data = get_post($post->ID);
				$postt = $post->post_title;
				templ_save_recurrence_events($post_data,$post->ID);
			endwhile;
			wp_reset_query();
		}
		add_option('tmpl_recurring_updates','completed');
	}
}
function tmpl_showMessage($message, $errormsg = false)
{
	if ($errormsg) {
		echo '<div id="tmessage" class="error" style="color:#2A6AA0; position:relative; padding:0px;">';
	}
	else {
		echo '<div id="message" class="updated fade">';
	}

	echo "<p><strong>$message</strong><a class='templatic-dismiss' style='margin-right:10px;' href='".site_url()."/wp-admin/themes.php?dismiss_update=yes"."' >Dismiss</a></p></div>";
}    
function tmpl_show_admin_recurring()
{
	$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');

	$nightlife_version = $theme_data['Version'];
	
    // Shows as an error message. You could add a link to the right page if you wanted.
	if(get_option('tmpl_recurring_updates') ==''  && !get_option('dismiss_update')){
		tmpl_showMessage("Events has been updated with a new system for handling recurring events. To make your existing events compatible with the new system please  <a href='".site_url()."/wp-admin/edit.php?post_type=event&recurring_update=true'>Click Here</a>.", true);
	}
  
}

/*
	Call showAdminMessages() when showing other admin messages. 
*/
add_action('admin_notices', 'tmpl_show_admin_recurring'); 
if(isset($_REQUEST['dismiss_update']) && $_REQUEST['dismiss_update']!=''){
	update_option('dismiss_update','yes');
}

// Display any errors
	function admin_notice_handler($post) {
		global $post;

		$errors = __('Modification in this event will be applied to all other occurrences of this recurring event.',T_DOMAIN);
	
		if(isset($_REQUEST['post']) && $_REQUEST['post'] != '') {
			
			$post_type = get_post_type($_REQUEST['post']);
			
			$event_type = get_post_meta($_REQUEST['post'],'event_type',true);
			
			$_event_id = get_post_meta($_REQUEST['post'],'_event_id',true);
			
			if($post_type == 'event' && trim(strtolower($event_type)) == trim(strtolower('Recurring Event')) )
			{
	
				echo '<div class="error"><p>' . $errors . '</p></div>';
				
			}	
			elseif($post_type == 'event' && trim(strtolower($event_type)) == trim(strtolower('Regular event'))  && $_event_id == $post->post_parent)
			{
				$errors = __('As this is an occurrence, you can edit only the description of this event. To edit other fields go to main event of <a target="_blank" href="'.site_url("/wp-admin/post.php?post=".$post->post_parent."&action=edit").'">this</a>  occurrence .',T_DOMAIN);

				echo '<div class="error"><p>' . $errors . '</p></div>';
				
			}	
		}   
	
	}
	function recurring_notices($post) {
		global $post;

		$errors = __('Modification in this event will be applied to all other occurrences of this recurring event.',T_DOMAIN);
	
		if(isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') {
			
			$post_type = get_post_type($_REQUEST['pid']);
			
			$event_type = get_post_meta($_REQUEST['pid'],'event_type',true);
			
			if($post_type == 'event' && trim(strtolower($event_type)) == trim(strtolower('Recurring Event')) )
			{
	
				echo '<div class="error"><p>' . $errors . '</p></div>';
				
			}	
		}   
	}
	add_action( 'admin_notices', 'admin_notice_handler' );
	add_action( 'submit_form_before_content', 'recurring_notices' );
?>