<?php
$custom_post_type = CUSTOM_POST_TYPE1;
//======================================
/* Displays a list or dropdown of Post or Events Categories or tags widget. */
class wp_widget_custom_taxonomy extends WP_Widget {

	function wp_widget_custom_taxonomy() {
		$widget_ops = array('classname' => 'widget_taxonomy', 'description' => 'Displays a list or dropdown of Post/Events Categories/tags. ' );		
		$this->WP_Widget('widget_taxonomy', 'T &rarr; Category and Tags', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base);
		$c = $instance['count'] ? '1' : '0';
		$h = $instance['hierarchical'] ? '1' : '0';
		$d = $instance['dropdown'] ? '1' : '0';
		$tn = $instance['taxonomy'] ? $instance['taxonomy'] : 'category';
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy'=>$tn, );
		if ( $d ) {
			$cat_args['show_option_none'] = __('Select Category');
			wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
			
?>
<input type="hidden" name="category_count" id="category_count" value="<?php echo $c;?>" />
<input type="hidden" name="category_name" id="category_name" value="<?php echo $instance['taxonomy'];?>" />
<script type='text/javascript'>
/* <![CDATA[ */
	var tn = document.getElementById("category_name").value;
	var dropdown = document.getElementById("cat");
	function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0) {	
			if (tn == 'category' ){
				
			location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
			}
			else if (tn == 'post_tag' ) { 
				if(document.getElementById("category_count").value == "" || document.getElementById("category_count").value == 0)
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var tag = str.replace(/ /gi,"-");
				}
				else
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var arr = str.split("(");
					arr[0] = arr[0].replace(/ /gi,"-");
					var tag = trim(arr[0]);
				}
				location.href = "<?php echo home_url(); ?>/?tag="+tag;
			}
			else if (tn == 'eventcategory' ) {
if(document.getElementById("category_count").value == "" || document.getElementById("category_count").value == 0)
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var tag = str.replace(/ /gi,"-");
				}
				else
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var arr = str.split("(");
					arr[0] = arr[0].replace(" ","-");
					var tag = trim(arr[0]);
				}
				location.href = "<?php echo home_url(); ?>/?eventcategory="+tag;			}
			else if (tn == 'eventtags' ) {
				if(document.getElementById("category_count").value == "" || document.getElementById("category_count").value == 0)
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var tag = str.replace(/ /gi,"-");
					
				}
				else
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var arr = str.split("(");
					arr[0] = arr[0].replace(/ /gi,"-");
					var tag = trim(arr[0]);
				}
			location.href = "<?php echo home_url(); ?>/?eventtags="+tag;
			}
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>
<?php
		} else {
?>	<ul>
<?php
		$cat_args['title_li'] = '';
		wp_list_categories(apply_filters('widget_categories_args', $cat_args));
?>
	</ul>
<?php
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$current_taxonomy = esc_attr( @$instance['taxonomy'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		global $custom_post_type;
?>
		<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title','templatic' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
       <p>
       <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Select Taxonomy'); ?>:</label>
		<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
        <?php foreach ( get_object_taxonomies('post') as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
		?>
			<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
		<?php endforeach; ?>
		<?php foreach ( get_object_taxonomies($custom_post_type) as $taxonomy ) :
					$tax = get_taxonomy($taxonomy);
					if ( !$tax->show_tagcloud || empty($tax->labels->name) )
						continue;
		?>
			<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
		<?php endforeach; ?>
        </select>
        </p>

		<p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Show as dropdown','templatic' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts','templatic' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy','templatic' ); ?></label>
        </p>
<?php
	}

}
register_widget('wp_widget_custom_taxonomy');


// Custom Tag Widget // ------------------------------------------------------------------------------------------------------------------------------------------------------------ //

class WP_Widget_Custom_Tag_Cloud extends WP_Widget {

	function WP_Widget_Custom_Tag_Cloud() {
		$widget_ops = array('classname' => 'widget_custom_tag_cloud', 'description' => 'Displays a cloud of Post/Event Categories or Tags.' );		
		$this->WP_Widget('widget_custom_tag_cloud', 'T &rarr; Categories/Tag Cloud', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div>';
		wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy) ) );
		echo "</div>\n";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}

	function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		global $custom_post_type;
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic') ?>:</label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy','templatic') ?>:</label>
	<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
	<?php foreach ( get_object_taxonomies('post') as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
    <?php foreach ( get_object_taxonomies($custom_post_type) as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
    
	</select></p><?php
	}

	function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}
register_widget('WP_Widget_Custom_Tag_Cloud');
?>