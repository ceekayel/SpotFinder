<?php
/**
 * Search Template
 *
 * The search template is loaded when a visitor uses the search form to search for something
 * on the site.
 */
get_header(); // Loads the header.php template.

   do_action( 'before_content' ); // supreme_before_content  // supreme_before_content  
     
   
   /* get all the custom fields which select as " Show field on listing page" from back end */
	
	if(function_exists('tmpl_get_category_list_customfields')){
		$post_type = (is_array($_REQUEST['post_type'])) ? $_REQUEST['post_type'][0] : $_REQUEST['post_type'];
		$htmlvar_name = tmpl_get_category_list_customfields(@$post_type);
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
<div class="content-sidebar">
	<?php do_action( 'templ_before_container_breadcrumb' ); // supreme_before_content  // supreme_before_content ?>
	<div class="view_type_wrap extra-search-criteria-title">
		<h1 class="page-title"><?php printf( _e( 'Search Results for: ', DIR_DOMAIN ). '<span>' . get_search_query() . '</span><span>' . $radius. '</span>'); ?></h1>
		
		<?php 
		if(have_posts())
			do_action('directory_after_search_title'); ?>
		
		<?php do_action('after_search_result_label'); ?>
		<div class="twp_search_cont">
				<?php get_template_part('searchform');  ?>
		</div>
		<?php

		/* Hooks for category title end */ ?>
	</div>
	<section id="content" class="search_result_listing">
	  <?php do_action( 'templ_inside_container_breadcrumb' );	
	  do_action( 'open_content' ); 
	  ?>
	   <div class="hfeed">

		<?php 
    		global $wp_query,$htmlvar_name;

			$cus_post_type = (is_array($_REQUEST['post_type'])) ? $_REQUEST['post_type'][0] : $_REQUEST['post_type'];
			if(function_exists('tmpl_get_category_list_customfields') && function_exists('tmpl_get_category_list_customfields'))
			{
						$heading_type = tmpl_fetch_heading_post_type($cus_post_type);
						
						/* custom fields for custom post type.. */
						$htmlvar_name = tmpl_get_category_list_customfields($cus_post_type,$heading,$key);

			} 
			/* Loads the sidebar-before-content. */
			apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); 
			
			/* Loads the loop.php template. */
			get_template_part( 'loop','search' ); 
			
			/* after-content-sidebar use remove filter to don't display it */
			apply_filters('tmpl_after-content',supreme_sidebar_after_content());  ?>
	  </div>
	  <!-- hfeed -->
	  <?php do_action( 'close_content' ); 
		/* Loads the loop-navigation */ 
		apply_filters('supreme_search_loop_navigation',supreme_loop_navigation($post)); ?>
	</section>
</div>
<!-- #content -->
<?php do_action( 'after_content' ); 
	get_footer();  ?>