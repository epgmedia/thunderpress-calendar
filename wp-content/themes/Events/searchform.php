<div class="searchform">
  <form method="get" id="searchform" action="<?php echo home_url(); ?>">
    <input type="text" value="<?php echo get_option('ptthemes_search_name'); ?>" name="s" id="s" class="s" onfocus="if (this.value == '<?php echo get_option('ptthemes_search_name'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo get_option('ptthemes_search_name'); ?>';}" />
    <input type="submit" class="b_search" value=""  />
  </form>
</div>
