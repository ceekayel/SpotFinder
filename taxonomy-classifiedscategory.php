<?php
/**
 * Classifieds Category taxonomy page
 *
**/
get_header();
$tmpdata = get_option('templatic_settings');
do_action('after_classified_header');
	
/*do action for display the breadcrumb in between header and container. */
if (!is_active_sidebar( 'tmpl_listings_left_content') ){
		$class="content-middle";
	}else{
		$class="";
	}
?>
<div class="classified-listing-wrap">
<?php
do_action('classified_before_container_breadcrumb'); ?>

<div id="content" class="contentarea large-9 small-12 columns">
	<?php 
	global $htmlvar_name;
	
	/* get all the custom fields which select as " Show field on listing page" from back end */
	
	if(function_exists('tmpl_get_category_list_customfields')){
		$htmlvar_name = tmpl_get_category_list_customfields(CUSTOM_POST_TYPE_CLASSIFIED);
	}else{
		global $htmlvar_name;
	}
	
	/*do action for display the breadcrumb  inside the container. */ 
	do_action('classified_inside_container_breadcrumb'); 
	/* do action for display before categories title */
	do_action('classified_before_categories_title'); ?>
     
     <h1 class="loop-title"><?php single_cat_title(); ?></h1>
    
	<?php 
	/* do action for display after categories title */
	do_action('classified_after_categories_title'); 
	
	
	
	/* Show an optional category description */
	if ( category_description() ) :  
		/* do action for display after categories title */
		do_action('classified_before_categories_description'); 
	
		?>
          <div class="archive-meta"><?php echo category_description(); ?></div>
     <?php 
	 
		/* do action for display after categories title */ 
		do_action('classified_after_categories_description');
	endif;
	

	do_action('classified_before_subcategory');
	
	do_action('classified_subcategory');
	
	/* remove ratings from below title */
	remove_action('templ_post_title','tevolution_listing_after_title',12);
	/* remove add to favourite from below title */
	remove_action('templ_post_title','tevolution_favourite_html',11);
	
	if(function_exists('supreme_sidebar_before_content'))
		apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); /* Loads the sidebar-before-content. */

	do_action('classified_after_subcategory');?>
      
     <!--Start loop taxonomy page-->
     <?php do_action('classified_before_loop_taxonomy');?>
      
     <section id="loop_classified_taxonomy" class="search_result_listing <?php if(isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="gridview"){echo 'grid';}else{echo 'list';}?>" <?php if( is_plugin_active('Tevolution-Classifieds/classifieds.php') && isset($tmpdata['default_page_view']) && $tmpdata['default_page_view']=="mapview"){ echo 'style="display: none;"';}?>>
     	<?php if (have_posts()) : 
				while (have_posts()) : the_post(); ?>	
                       	<?php do_action('classified_before_post_loop');?>
                    	<article class="post  <?php templ_post_class();?>">  
                        <?php 
							/*do_action before the post image */
							do_action('tmpl_before_category_page_image');           
							do_action('classified_before_category_page_image');           
							
							/* Here to fetch the image */
							do_action('classified_category_page_image');
							
							/*do action after the post image */
							do_action('classified_after_category_page_image'); 
							do_action('tmpl_after_category_page_image');    
							do_action('classified_before_post_entry');?>
                         	<div class="entry"> 
                               <div class="sort-title">
									<?php do_action('classified_before_post_title');         /* do action for before the post title.*/ ?>
									<div class="classified-title">
									<?php /* do action for display the single post title */ do_action('templ_post_title'); ?>
									<div class="show-mobile">
										<?php /* do action for display the price */ do_action('templ_classified_post_title'); ?>
										<?php /* do action for display the date */ do_action('templ_classified_post_date'); ?>
									</div>
								</div>

								<div class="classified-info">
									<?php /*do action for display the post info */ do_action('classified_post_info'); ?>
								</div>

								<!-- Start Post Content -->
								<?php
									/* do action for before the post content. */
								   do_action('classified_before_post_content');
								   do_action('templ_taxonomy_content');
								   /* do action for after the post content. */
								   do_action('classified_after_post_content');
								?>
								<!-- End Post Content -->

								<!-- Show custom fields where show on listing = yes -->
								<?php
									do_action('classified_after_taxonomies');
									/* Here to show the add to favourites,comments and pinpoint  */
									do_action('classified_after_post_entry');
								?>
								</div>
								<div class="sort-date show-desktop">
									<?php /* do action for display the date */ do_action('templ_classified_post_date'); ?>
								</div>
								<div class="sort-price show-desktop">
									<?php /* do action for display the price */ do_action('templ_classified_post_title'); ?>
								</div>
								<?php  /* do action for after the post title.*/ do_action('classified_after_post_title'); ?>
							</div>
                             
                        </article>
                        <?php do_action('classified_after_post_loop');
					endwhile;
				wp_reset_query(); 
			else:?>
          	<p class='nodata_msg'><?php _e( 'Apologies, but no results were found for the requested archive.', CDOMAIN ); ?></p>              
          <?php endif;
		  if($wp_query->max_num_pages !=1):?>
             <div id="listpagi">
                  <div class="pagination pagination-position">
                        <?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
                  </div>
             </div>
         <?php endif;?>
     </section>
     <?php do_action('classified_after_loop_taxonomy');
			/* after-content-sidebar use remove filter to don't display it */
			if(function_exists('supreme_sidebar_after_content'))
				apply_filters('tmpl_after-content',supreme_sidebar_after_content()); 

			?>
      <!--End loop taxonomy page -->
</div>
<!--taxonomy  sidebar -->
<?php if ( is_active_sidebar( 'classifiedscategory_listing_sidebar') ) : ?>
	<aside id="sidebar-primary" class="sidebar large-3 small-12 columns"> 

		<?php dynamic_sidebar('classifiedscategory_listing_sidebar'); ?>
	</aside>
<?php 
elseif ( is_active_sidebar( 'primary-sidebar') ) : ?>
	<aside id="sidebar-primary" class="sidebar large-3 small-12 columns"> 

		<?php dynamic_sidebar('primary-sidebar'); ?>
	</aside>
<?php 
elseif ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<aside id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?></div>
<!--end taxonomy sidebar -->
<?php get_footer(); ?>