<?php get_header(); ?>


<div id="wrapper" class="clearfix">
     <div id="content" class="clearfix" >
    	
        <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
        <div class="breadcrumb clearfix">
            <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
        </div>
    <?php } ?>
      <h1><?php echo get_option('ptthemes_404error_name'); ?></h1>   
  
         
             
             
		 			<h4 style="text-align:center"><?php echo get_option('ptthemes_404solution_name'); ?></h4> 
                     
                     <img src="<?php bloginfo('template_directory'); ?>/images/404.png" alt=""  />
             
</div> <!-- content #end -->

    <?php get_sidebar(); ?>

</div> <!-- wrapper #end -->
<div id="bottom"></div>  
<?php get_footer(); ?>