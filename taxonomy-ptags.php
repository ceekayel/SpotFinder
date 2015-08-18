<?php
/**
 * Property Category taxonomy page
 *
**/
get_header();
$tmpdata = get_option('templatic_settings');

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
		<?php if($_COOKIE['display_view']=='property_map' && $tmpdata['category_map']=='yes'):?>
			jQuery(function() {			
				jQuery('#listpagi').hide();
			});
		<?php endif;?>
    </script>
    
    <div class="page-head">
    <?php do_action('after_property_header');
         /*do action for display the breadcrumb in between header and container. */
        do_action('directory_before_container_breadcrumb'); 
    ?>
    </div>
    
	<!--taxonomy  sidebar -->
	<?php 
	if ( is_active_sidebar('pcategory_listing_above_content') ) : ?>
		<div class="filters">
			<div id="sidebar-primary" class="sidebar">
				<?php dynamic_sidebar('pcategory_listing_above_content'); ?>
			</div>
		</div>
	<?php  endif; ?>
	<!--end taxonomy sidebar -->
    
    <div class="view_type_wrap">
    	 <h1 class="loop-title"><?php single_cat_title(); ?></h1>
         
         <?php 
		 	do_action('property_after_subcategory');
			
            /* do action for display after categories title */
            do_action('property_after_categories_title'); 
            
            /* do action for display after categories title */
            do_action('property_before_categories_description'); 
            
            /* Show an optional category description */
            if ( category_description() ) :  
        ?>
        <div class="archive-meta"><?php echo category_description(); ?></div>
         <?php endif;
            /* do action for display after categories title */ 
            do_action('property_after_categories_description');
        
            //do_action('property_before_subcategory');
            
            do_action('property_subcategory');
            
            /* remove ratings from below title */
            remove_action('templ_post_title','tevolution_listing_after_title',12);
            
            /* remove add to favorite from below title */
            remove_action('templ_post_title','tevolution_favourite_html',11);
            if(function_exists('supreme_sidebar_before_content'))
                apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); /* Loads the sidebar-before-content. */
           
        ?>
         
    </div>
	
    <div id="content" class="contentarea large-9 small-12 columns <?php //property_class();?>">
		<?php 
            /*do action for display the breadcrumb  inside the container. */ 
            do_action('directory_inside_container_breadcrumb');
            
            global $htmlvar_name;
            
            /* Get heading type to display the custom fields as per selected section.  */
            if(function_exists('tmpl_fetch_heading_post_type')){
            
                $heading_type = tmpl_fetch_heading_post_type(CUSTOM_POST_TYPE_PROPERTY);
            }
            
            /* get all the custom fields which select as " Show field on listing page" from back end */
            
            if(function_exists('tmpl_get_category_list_customfields')){
                $htmlvar_name = tmpl_get_category_list_customfields(CUSTOM_POST_TYPE_PROPERTY);
            }else{
                global $htmlvar_name;
            }
            
            /*do action for display the breadcrumb  inside the container. */ 
            do_action('property_inside_container_breadcrumb'); 
            /* do action for display before categories title */
            do_action('property_before_categories_title'); 
        ?>
         
        
        
        
        
         <!--Start loop taxonomy page-->
         <?php do_action('property_before_loop_taxonomy');?>
          
         <div id="loop_property_taxonomy" class="search_result_listing <?php if(isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="gridview"){echo 'grid';}else{echo 'list';}?>" <?php if( is_plugin_active('Tevolution-RealEstate/property.php') && isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="mapview"){ echo 'style="display: none;"';}?>>
            <?php if (have_posts()) : 
                    while (have_posts()) : the_post(); ?>	
                            <?php do_action('property_before_post_loop');?>
                            <div class="post <?php templ_post_class();?>">  
                            <?php 
                                /*do_action before the post image */
                                do_action('property_before_category_page_image');           
                                
                                /* Here to fetch the image */
                                do_action('property_category_page_image');
                                
                                /*do action after the post image */
                                do_action('property_after_category_page_image'); 
                                
                                do_action('property_before_post_entry');?>
                                <div class="entry"> 
                                       <!--start post type title -->
                                       <?php do_action('property_before_post_title');         /* do action for before the post title.*/ ?>
                                       
                                       <div class="property-title">
                                       
                                        <?php /* do action for display the single post title */
                                        do_action('templ_post_title');                
                                      
                                       /* do action for display the single post title */
                                       do_action('tevolution_title_text');                ?>
                                       
                                       </div>
                                       <?php 
                                       /* do action for after the post title.*/
                                       do_action('property_after_post_title');         
                                     
                                        /*do action for display the post info */ 
                                       do_action('property_post_info');                 
                                      
                                        /* do action for before the post content. */								  
                                       do_action('property_before_post_content');      
                                       
                                       do_action('templ_taxonomy_content');	
                                       
                                       /* do action for after the post content. */
                                       do_action('property_after_post_content');       ?>
                                       <!-- End Post Content -->
                                       
                                       <!-- Show custom fields where show on listing = yes -->
                                       <?php 
                                       /*add action for display the listing page custom field */
                                       do_action('property_listing_custom_field');
                                       
                                       do_action('templ_the_taxonomies');   
                                       
                                       do_action('property_after_taxonomies');
                                       
                                       /* Here to show the add to favorites,comments and pinpoint  */
                                        do_action('property_after_post_entry');?>
                                </div>
                                 
                            </div>
                            <?php do_action('property_after_post_loop');
                        endwhile;
                    wp_reset_query(); 
                else:?>
                <p class='nodata_msg'><?php _e( 'Apologies, but no results were found for the requested archive.', PDOMAIN ); ?></p>              
              <?php endif;
              if($wp_query->max_num_pages !=1):?>
             <div id="listpagi">
                  <div class="pagination pagination-position">
                        <?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
                  </div>
             </div>	
             <?php endif;
			 
			  do_action('property_after_loop_taxonomy');
			 ?>
              
         </div>
         
          <!--End loop taxonomy page -->
          
    </div>
    
</div>
<?php get_footer(); ?>