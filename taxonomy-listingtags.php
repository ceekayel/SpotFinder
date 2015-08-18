<?php
/**
 * Directory Category taxonomy page
 *
**/
get_header(); //Header Portion
$tmpdata = get_option('templatic_settings');
global $posts,$htmlvar_name;
	

	/* get all the custom fields which select as " Show field on listing page" from back end */

	if(function_exists('tmpl_get_category_list_customfields')){
		$htmlvar_name = tmpl_get_category_list_customfields(CUSTOM_POST_TYPE_LISTING);
	}else{
		global $htmlvar_name;
	}
	/* Left content side bar for all pages */
	if (!is_active_sidebar( 'tmpl_listings_left_content') ){
		$class="content-middle";
	}else{
		$class="";
	}
	
	/* Here we use for Show left content sidebar , it can be use for many other purpose too */
	do_action('tmpl_all_pages_left_content');
	?>
<div class="content-sidebar <?php echo $class; ?>">

	<script type="text/javascript">
		var category_map = '<?php echo $tmpdata['category_map'];?>';
		<?php if($_COOKIE['display_view']=='event_map' && $tmpdata['category_map']=='yes'):?>
			jQuery(function() {			
				jQuery('#listpagi').hide();
			});
		<?php endif;?>
    </script>

	<div class="page-head">
		<?php 
			/* back page link */
			tmpl_back_link();
            do_action('after_directory_header'); /*do action for display the breadcrumb in between header and container. */
            do_action('directory_before_container_breadcrumb');
        ?>
    </div>
    
    
	<!--taxonomy  sidebar -->
	<?php 
	if ( is_active_sidebar('listingtags_listing_above_content') ) : ?>
		<div class="filters">
			<div id="sidebar-primary" class="sidebar">
				<?php dynamic_sidebar('listingtags_listing_above_content'); ?>
			</div>
		</div>
	<?php  endif; ?>
	<!--end taxonomy sidebar -->
  
  
    <div class="view_type_wrap">
         <?php
         /* Hooks for category title */
         do_action('tmpl_directory_before_categories_title'); ?>
         
         <h1 class="loop-title"><?php single_cat_title(); ?></h1>
         
         <?php 
		 	do_action('directory_before_subcategory');
                if(function_exists('supreme_sidebar_before_content'))
               apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); 
            do_action('directory_after_subcategory');
         ?>
        
         <?php do_action('directory_after_categories_title'); 
         /* Hooks for category title end */
         
          /* Hooks for category description */
         do_action('directory_before_categories_description'); 
    
         if ( category_description() ) : /* Show an optional category description */ ?>
              <div class="archive-meta"><?php echo category_description(); ?></div>
         <?php endif; 
    
         do_action('directory_after_categories_description');
          /* Hooks for category description */
         ?>
         
         <?php 
		 	do_action('directory_subcategory');  /* Loads the sidebar-before-content. */
		 ?>
         
         
    </div>
        
	        
        
    <div id="content" class="contentarea large-9 small-12 columns <?php directory_class();?>">
        
        <?php do_action('directory_inside_container_breadcrumb'); /*do action for display the breadcrumb  inside the container. */ ?>
         
        
         <!--Start loop taxonomy page-->
       
       <?php do_action('directory_before_loop_taxonomy');?>
         
        <!--Start loop taxonomy page-->
        <div id="loop_listing_taxonomy" class="search_result_listing <?php if(isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="gridview"){echo 'grid';}else{echo 'list';}?>" <?php if( is_plugin_active('Tevolution-Directory/directory.php') && isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="mapview"){ echo 'style="display: none;"';}?>>
        <?php if (have_posts()) : 
                while (have_posts()) : the_post(); ?>
                    <?php do_action('directory_before_post_loop');?>
				 
				<div class="post <?php templ_post_class();?>" >  
					<?php 
					/* Hook to display before image */	
					do_action('tmpl_before_category_page_image');
						
					/* Hook to Display Listing Image  */
					do_action('directory_category_page_image');
					 
					/* Hook to Display After Image  */						 
					do_action('tmpl_after_category_page_image'); 
					   
					/* Before Entry Div  */	
					do_action('directory_before_post_entry');?> 
					
					<!-- Entry Start -->
					<div class="entry"> 
					   
						<?php  /* do action for before the post title.*/ 
						do_action('directory_before_post_title');         ?>
					   <div class="listing-wrapper">
						<!-- Entry title start -->
						<div class="entry-title">
					   
						<?php do_action('templ_post_title');                /* do action for display the single post title */?>
					   
						</div>
						
						<?php do_action('directory_after_post_title');          /* do action for after the post title.*/?>
					   
						<!-- Entry title end -->
						
						<!-- Entry details start -->
						<div class="entry-details">
						
						<?php  /* Hook to get Entry details - Like address,phone number or any static field  */  
						do_action('listing_post_info');   ?>     
						
						</div>
						<!-- Entry details end -->
					   </div>
						<!--Start Post Content -->
						<?php /* Hook for before post content . */ 
					   
						do_action('directory_before_post_content'); 
						
						/* Hook to display post content . */ 
						do_action('templ_taxonomy_content');
					   
						/* Hook for after the post content. */
						do_action('directory_after_post_content'); 
						?>
						<!-- End Post Content -->
					   <?php 
					    /* Hook for before listing categories     */
						do_action('directory_before_taxonomies');
					    
						/* Display listing categories     */
					    do_action('templ_the_taxonomies'); 

						/* Hook to display the listing comments, add to favorite and pinpoint   */						
						do_action('directory_after_taxonomies');?>
					</div>
					<!-- Entry End -->
					<?php do_action('directory_after_post_entry');?>
				</div>
			<?php do_action('directory_after_post_loop');
                endwhile;
                wp_reset_query(); 
            else:?>
                <p class='nodata_msg'><?php _e( 'Apologies, but no results were found for the requested archive.', TDOMAIN ); ?></p>              
            <?php endif; 
            
            /* pagination start */
            if($wp_query->max_num_pages !=1):?>
            <div id="listpagi">
                <div class="pagination pagination-position">
                    <?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
                </div>
            </div>
            <?php endif; /* pagination end */ ?>
            
      </div>
        <?php 
         
        if(function_exists('supreme_sidebar_after_content'))
            apply_filters('tmpl_after-content',supreme_sidebar_after_content());  /* after-content-sidebar - use remove filter to don't display it */
        
		 do_action('listing_after_loop_taxonomy');
		?>
          <!--End loop taxonomy page -->
    </div>
    
    	

</div>

<?php get_footer(); ?>