<?php
/**
 * Directory search page
 *
**/
get_header(); //Header Portion
$tmpdata = get_option('templatic_settings');
?>
<script type="text/javascript">
	var category_map = '<?php echo $tmpdata['category_map'];?>';
	<?php if($_COOKIE['display_view']=='event_map' && $tmpdata['category_map']=='yes'):?>
	jQuery(function() {			
		jQuery('#listpagi').hide();
	});
	<?php endif;?>
</script>
<?php do_action('after_directory_header'); 
/* get all the custom fields which select as " Show field on listing page" from back end */
	global $htmlvar_name;
	if(is_array($_REQUEST['post_type']) && count($_REQUEST['post_type']) ==1){
		$post_type = $_REQUEST['post_type'][0];
	}else{
		$post_type=get_query_var('post_type');	
	}
	
	/* Left content side bar for all pages */
	
	if(function_exists('tmpl_get_category_list_customfields')){
		$htmlvar_name = tmpl_get_category_list_customfields($post_type);
	}else{
		global $htmlvar_name;
	}
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
	$taxonomy_name=$wp_query->queried_object->taxonomy;
	if ( is_active_sidebar('listingcategory_listing_above_content') ) : ?>
		<div class="filters">
			<div id="sidebar-primary" class="sidebar">
				<?php dynamic_sidebar('listingcategory_listing_above_content'); ?>
			</div>
		</div>
	<?php  endif; ?>
	<!--end taxonomy sidebar -->
  
  	
	
		<?php 
		/* do action for display the breadcrumb  inside the container. */ 
		do_action('directory_inside_container_breadcrumb'); 
		
		do_action('directory_before_search_title');//do action for display before categories title
		global $current_cityinfo;
		if((isset($_REQUEST['radius']) && $_REQUEST['radius']!='') || (isset($_REQUEST['location']) && $_REQUEST['location']!='')){
			if(isset($_REQUEST['radius']) && $_REQUEST['radius']==1){
				$radius_type=(isset($_REQUEST['radius_type']) && $_REQUEST['radius_type']=='kilometer')? 'kilometer': 'mile';
			}
			if(isset($_REQUEST['radius']) && $_REQUEST['radius']!=1 && $_REQUEST['radius']!=""){
				$radius_type=(isset($_REQUEST['radius_type']) && $_REQUEST['radius_type']=='kilometer')? 'kilometers': 'miles';
			}
			$radius=(isset($_REQUEST['location']) && $_REQUEST['location']!='')?  $_REQUEST['radius'].' '.$radius_type.' '.__('around',TDOMAIN).' "'.$_REQUEST['location'].'"' : $_REQUEST['radius'].' '.$radius_type.' '.__('around',TDOMAIN).' "'.$current_cityinfo['cityname'].'"';
		}	
		?>
		 <!--Start loop search page--> 
		
			
		<div class="view_type_wrap extra-search-criteria-title">
			<h1 class="page-title"><?php printf( _e( 'Search Results for: ', TDOMAIN ). '<span>' . get_search_query() . '</span><span>' . $radius. '</span>'); ?></h1>
			
			<?php if(have_posts())
			do_action('directory_after_search_title'); 
			
			do_action('after_search_result_label'); ?>
			
			<?php
			/* Hooks for category title */
			do_action('directory_before_search_title'); ?>

			<h1 class="loop-title"><?php single_cat_title(); ?></h1>

			<?php 
			/* Hooks for category title end */ ?>
		</div>
		 <?php do_action('directory_before_loop_search');?> 
		 
		 <div id="content" class="contentarea large-9 small-12 columns <?php directory_class();?>">
		 <div id="loop_listing_archive" class="search_result_listing list">
			<?php if (have_posts()) : 
					
					do_action('directory_before_loop_start'); 
					while (have_posts()) : the_post();
					  
					do_action('directory_before_post_loop');
			?>
					 
						<div class="post <?php templ_post_class();?>" >  
						<?php 
						/* Hook to display before image */	
						do_action('directory_before_category_page_image');
					   
						/* Hook to display before image */	
						do_action('directory_before_category_page_image');
							
						/* Hook to Display Listing Image  */
						do_action('directory_category_page_image');
						 
						/* Hook to Display After Image  */						 
						do_action('directory_after_category_page_image'); 
						   
						/* Before Entry Div  */	
						do_action('directory_before_post_entry');?> 
						
						<!-- Entry Start -->
						<div class="entry"> 
						   
							  <!--start post type title -->
							   <?php do_action('directory_before_post_title');         /* do action for before the post title.*/ ?>
							   
							   <div class="listing-title">                                 
								 <?php do_action('templ_post_title');                /* do action for display the single post title */?>
							   </div>
							   
							   <?php  /* do action for after the post title. - fetch all information like address,phone number etc */
							   echo "<div class='directory_info'>"; 
									do_action('directory_after_post_title'); 
								?>
									<a class="listing_more_btn" href="<?php echo get_permalink($post->ID); ?>"><?php _e('View More Details',TDOMAIN);?></a>
								<?php
								echo "</div>";
							   
							  /* end post type title */
							  do_action('listing_post_info');                 /*do action for display the post info */     
							   
							   
							  /* Start Post Content */
							  do_action('directory_before_post_content');       /* do action for before the post content. */ 

							  do_action('templ_taxonomy_content');	

							  do_action('directory_after_post_content');        /* do action for after the post content. */?>
							   <!-- End Post Content -->
							   
							   <!-- Show custom fields where show on listing = yes -->
							   <?php do_action('directory_listing_custom_field');/*add action for display the listing page custom field */ 

							   do_action('templ_the_taxonomies');   
							   
							   do_action('directory_after_taxonomies');?>
						</div>
						<!-- Entry End -->
						<?php 
						if(!is_author())
						{
							apply_filters( 'tmpl-after-entry',supreme_sidebar_entry() ); // Loads the sidebar-entry
						}
						do_action('directory_after_post_entry'); ?>
						</div>
						<?php
						do_action('directory_after_post_loop'); 
				endwhile; 
				wp_reset_query();
				else: ?>
					<p class='nodata_msg'><?php _e( 'Sorry! No results were found for the requested search. Try searching with some different keywords', TDOMAIN ); ?></p>
				   
					<?php get_template_part( 'directory-listing','search-form' ); 
					
				endif;?>
                
				<?php if($wp_query->max_num_pages !=1):?>
                <div id="listpagi">
                    <div class="pagination pagination-position">
                    <?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
                    </div>
                </div>
                <?php endif;?>
		 </div>
		 
		 <?php do_action('directory_after_loop_search');?>		 
		 
		  <!--End loop search page -->
	</div>
</div>
<?php	get_footer(); ?>