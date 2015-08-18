<?php
/**
 * Event Category taxonomy page
 *
**/
get_header(); //Header Portation
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
		<?php if($_COOKIE['display_view']=='event_map' && $tmpdata['category_map']=='yes'):?>
			jQuery(function() {			
				jQuery('#listpagi').hide();
			});
		<?php endif;?>
    </script>
    <?php 
	/* back page link */
	tmpl_back_link();
	?>

	<!--taxonomy  sidebar -->
	<?php 
	$taxonomy_name=$wp_query->queried_object->taxonomy;
	if ( is_active_sidebar( $taxonomy_name.'_listing_above_content') ) : ?>
		<div class="filters">
			<div id="sidebar-primary" class="sidebar">
				<?php dynamic_sidebar($taxonomy_name.'_listing_above_content'); ?>
			</div>
		</div>
	<?php  endif; ?>
	<!--end taxonomy sidebar -->
	
    
	<?php
	do_action('after_event_header');
        global $htmlvar_name;
        if(function_exists('tmpl_get_category_list_customfields')){
            $htmlvar_name = tmpl_get_category_list_customfields(CUSTOM_POST_TYPE_EVENT);
        }else{
            global $htmlvar_name;
        }
         /*do action for display the bradcrumb in between header and container. */
        do_action('event_before_container_breadcrumb'); 
    ?>
    
    <div id="content" class="contentarea large-9 small-12 columns <?php //event_class();?>">
        <?php 
        /*do action for display the bradcrumn  inside the container. */ 
        do_action('event_inside_container_breadcrumb'); 
        /* do action for display before categories title */
        do_action('event_before_categories_title'); ?>
         
         <h1 class="loop-title"><?php single_cat_title(); ?></h1>
         
         <?php 
            if(function_exists('supreme_sidebar_before_content'))
                apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); /* Loads the sidebar-before-content. */
            do_action('event_after_subcategory');
        
            /* do action for display after categories title */
            do_action('event_after_categories_title'); 
            
            /* do action for display after categories title */
            do_action('event_before_categories_description'); 
            
            /* Show an optional category description */
            if ( category_description() ) :  ?>
                  <div class="archive-meta"><?php echo category_description(); ?></div>
             <?php endif;
            /* do action for display after categories title */ 
            do_action('event_after_categories_description');
            do_action('event_before_subcategory');
            do_action('event_subcategory');
			?>
          
         <!--Start loop taxonomy page-->
         <?php do_action('event_before_loop_taxonomy');?>
          
         <div id="loop_event_taxonomy" class="search_result_listing <?php if(isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="gridview"){echo 'grid';}else{echo 'list';}?>" <?php if( is_plugin_active('Tevolution-Directory/directory.php') && isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="mapview"){ echo 'style="display: none;"';}?>>
            <?php if (have_posts()) : 
                    while (have_posts()) : the_post(); ?>	
                            <?php do_action('event_before_post_loop');?>
                            <div class="post <?php templ_post_class();?>">  
                                <?php do_action('event_before_category_page_image');           /*do_action before the post image */
									do_action('tmpl_before_category_page_image');           /*do_action before the post image */
                                
                                    do_action('event_category_page_image');
                                  
                                    do_action('event_after_category_page_image');           /*do action after the post image */
                                    do_action('event_before_post_entry'); ?>
                                    <div class="entry"> 
                                        <!--start post type title -->
                                        <?php do_action('event_before_post_title');         /* do action for before the post title.*/ ?>
                                        <div class="event-wrapper">
                                        <div class="event-title">
                                       
                                            <?php do_action('templ_post_title');                /* do action for display the single post title */
                                             ?>
                                       
                                        </div>
                                        <?php do_action('event_after_post_title');          /* do action for after the post title.*/?>
                                        <!--end post type title -->
                                        <!-- Entry details start -->
                                        <div class="entry-details">
                                        
                                        <?php  /* Hook to get Entry details - Like address,phone number or any static field  */  
                                        do_action('event_post_info');   ?>     
                                        
                                        </div> 
                                        </div>
                                       
                                       <!--Start Post Content -->
                                       <?php do_action('event_before_post_content');       /* do action for before the post content. */ 
                                       
                                        do_action('templ_taxonomy_content');	
                                       
                                        do_action('event_after_post_content');        /* do action for after the post content. */
                                       
                                        do_action('templ_the_taxonomies');  
                                       
                                        do_action('event_after_taxonomies');?>
                                    </div>
                                <?php do_action('event_after_post_entry');?>
                             </div>
                            <?php do_action('event_after_post_loop');?>
                <?php endwhile;
                    wp_reset_query(); 
                else:?>
                <p class='nodata_msg'><?php _e( 'Apologies, but no results were found for the requested archive.', EDOMAIN ); ?></p>              
              <?php endif;
              if($wp_query->max_num_pages !=1):?>
                 <div id="listpagi">
                      <div class="pagination pagination-position">
                            <?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
                      </div>
                 </div>
             <?php endif; 
			 do_action('event_after_loop_taxonomy'); 
			
			?>
         </div>
        
          <!--End loop taxonomy page -->
    </div>
</div>
<?php 
get_footer(); ?>