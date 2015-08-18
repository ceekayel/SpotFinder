<?php
/**
 * Property Search page
 *
**/

get_header();
$tmpdata = get_option('templatic_settings');
?>
<script type="text/javascript">
var category_map = '<?php echo $tmpdata['category_map'];?>';
<?php if($_COOKIE['display_view']=='property_map' && $tmpdata['category_map']=='yes'):?>
jQuery(function() {			
	jQuery('#listpagi').hide();
});
<?php endif;?>
</script>
<?php do_action('after_property_header'); 

	
	/* get all the custom fields which select as " Show field on listing page" from back end */
	global $htmlvar_name;
	if(is_array($_REQUEST['post_type']) && count($_REQUEST['post_type']) ==1){
		$post_type = $_REQUEST['post_type'][0];
	}else{
		$post_type=get_query_var('post_type');	
	}
	
	
	if(function_exists('tmpl_get_category_list_customfields')){
		$htmlvar_name = tmpl_get_category_list_customfields($post_type);
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
	if ( is_active_sidebar($taxonomy_name.'_listing_above_content') ) : ?>
		<div class="filters">
			<div id="sidebar-primary" class="sidebar">
				<?php dynamic_sidebar($taxonomy_name.'_listing_above_content'); ?>
			</div>
		</div>
	<?php  endif; ?>
	<!--end taxonomy sidebar -->
	
	
	<div id="content" class="contentarea large-9 small-12 columns <?php //property_class();?>">
		<?php 
		
		global $htmlvar_name,$wp_query;
		/* remove action to show the listing custom fields on category pages */
		remove_action('pre_get_posts','tmpl_property_manager_pre_get_posts');
		
		remove_action('templ_post_title','tevolution_listing_after_title',12);
		/* remove add to favorite from below title */
		remove_action('templ_post_title','tevolution_favourite_html',11);
		
		
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

		do_action('property_inside_container_breadcrumb'); /*do action for display the bradcrumn  inside the container. */ 
		
		do_action('property_before_search_title');//do action for display before categories title
		
		//echo $wp_query->request;
		
		global $current_cityinfo;
		if((isset($_REQUEST['radius']) && $_REQUEST['radius']!='') || (isset($_REQUEST['location']) && $_REQUEST['location']!='')){
			if(isset($_REQUEST['radius']) && $_REQUEST['radius']==1){
				$radius_type=(isset($_REQUEST['radius_type']) && $_REQUEST['radius_type']=='kilometer')? 'kilometer': 'mile';
			}
			if(isset($_REQUEST['radius']) && $_REQUEST['radius']!=1 && $_REQUEST['radius']!=""){
				$radius_type=(isset($_REQUEST['radius_type']) && $_REQUEST['radius_type']=='kilometer')? 'kilometers': 'miles';
			}
			$radius=(isset($_REQUEST['location']) && $_REQUEST['location']!='')?  $_REQUEST['radius'].' '.$radius_type.' around "'.$_REQUEST['location'].'"' : $_REQUEST['radius'].' '.$radius_type.' around "'.$current_cityinfo['cityname'].'"';
		}
		?>
		<header class="page-header">
			  <h1 class="page-title">
				<?php _e( 'Search Results', PDOMAIN ); ?>
			   </h1>
			  <?php 
			  /* action for get search criteria listing on search result page */
			  do_action('after_search_result_label'); ?>
		</header>
		<div class="view_type_wrap">
			<?php
			/* Hooks for category title */
			do_action('directory_before_search_title'); 
			/* Hooks for category title end */ ?>
		</div>
		<?php
		if(function_exists('supreme_sidebar_before_content'))
			apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); /* Loads the sidebar-before-content. */

		do_action('property_after_subcategory');?>
		  
		 <!--Start loop taxonomy page-->
		<?php do_action('property_before_loop_search');?>
		 
		 <div id="tmpl-search-results" class="list">
			<?php global $wp_query; 
			if (have_posts()) : 
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
				else:
					if(isset($_REQUEST['etype']) && $_REQUEST['etype']=='current')
						$seach_tab='past or upcoming';
					elseif(isset($_REQUEST['etype']) && $_REQUEST['etype']=='past')
						$seach_tab='current or upcoming';
					elseif(isset($_REQUEST['etype']) && $_REQUEST['etype']=='upcoming')
						$seach_tab='past or cureent';
					?>
					<p class='nodata_msg'><?php echo sprintf(__( 'Sorry, searching did not return any results. Please modify your search keywords and try again.', PDOMAIN ),$_REQUEST['etype'],$seach_tab); ?></p>
				   
				   <?php get_template_part( 'property-listing','search-form' ); ?>
			  <?php endif;?>
		 </div>
		 
		  <?php do_action('property_after_loop_search');
		  
		  if($wp_query->max_num_pages !=1):?> 
		 <div id="listpagi">
			  <div class="pagination pagination-position">
					<?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
			  </div>
		 </div>    	 
		 <?php endif;?>
		  <!--End loop search page -->
	</div>
</div>
<?php get_footer(); ?>