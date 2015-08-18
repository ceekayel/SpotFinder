<?php
/**
 * Event Search page
 *
**/
get_header(); //Header Portation
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
<?php do_action('after_event_header'); 
	
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
            do_action('event_before_container_breadcrumb');
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
	
	<div id="content" class="contentarea large-9 small-12 columns <?php //event_class();?>">
		<?php do_action('event_inside_container_breadcrumb'); /*do action for display the bradcrumn  inside the container. */ ?>
		 
		<?php do_action('event_before_search_title');//do action for display before categories title
		
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
			  <h1 class="page-title"><?php printf( __( 'Search Results for: %s %s', EDOMAIN ), '<span>"' . get_search_query() . '"</span>','<span>' . $radius . '</span>' ); ?></h1>
		 </header>
		 
		<?php  do_action('event_after_search_title');// do action for display after categories title ?>
		  <!--Start loop search page-->    
		<div class="view_type_wrap">
			<?php
			/* Hooks for category title */
			do_action('directory_before_search_title'); 
			/* Hooks for category title end */ ?>
		</div>
		
		 
		 <!--Start loop search page-->   
		 <?php do_action('event_before_loop_search');?> 
		 
		 <div id="loop_event_archive" class="list">
			<?php if (have_posts()) : 
					while (have_posts()) : the_post(); ?>	
						<?php do_action('event_before_post_loop');?>
						<div class="post <?php templ_post_class();?>">  
								<?php do_action('event_before_category_page_image');           /*do_action before the post image */
								
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
							<?php do_action('event_after_post_loop');
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
					<p class='nodata_msg'><?php echo sprintf(__( 'Sorry! No results were found in %s events for the requested search or its may be in %s events. Try searching with some different keywords', EDOMAIN ),$_REQUEST['etype'],$seach_tab); ?></p>
				   
				   <?php get_template_part( 'event-listing','search-form' ); ?>
			  <?php endif;?>
		 </div>
		 
		  <?php do_action('event_after_loop_search');?>
		 
		 <?php if($wp_query->max_num_pages !=1):?> 
		 <div id="listpagi">
			  <div class="pagination pagination-position">
					<?php if(function_exists('pagenavi_plugin')) { pagenavi_plugin(); } ?>
			  </div>
		 </div>    	 
		 <?php endif;?>
		  <!--End loop search page -->
	</div>
</div>
<!--search sidebar -->
<?php get_footer(); ?>