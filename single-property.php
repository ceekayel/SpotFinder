<?php
/**
 * Detail page of property post type
 *
**/
get_header();
//do_action('tmpl_before_frontend_edit_container'); 
$is_edit='';
if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
	$is_edit=1;
}
global $htmlvar_name,$tmpl_flds_varname;
/* to get the common/context custom fields display by default with current post type */
if(function_exists('tmpl_single_page_default_custom_field')){
	$tmpl_flds_varname = tmpl_single_page_default_custom_field(CUSTOM_POST_TYPE_PROPERTY);
}
?>

<!--Map Section Start -->
<div class="map-sidebar">
   <?php do_action('property_single_page_map') ?>
</div>

<div class="content-sidebar">
	<div class="page-head">
		<?php tmpl_back_link();
		do_action('directory_before_container_breadcrumb'); /*do action for display the breadcrumb in between header and container. */ ?>
	</div>
	
	
	<!-- start content part-->
	<div id="content" role="main">	
		<?php 
		/*do action for display the breadcrumb  inside the container. */ 
		do_action('directory_inside_container_breadcrumb');
		
		global $htmlvar_name,$tmpl_flds_varname;
		/* Get heading type to display the custom fields as per selected section.  */
		if(function_exists('tmpl_fetch_heading_post_type')){
		
			$heading_type = tmpl_fetch_heading_post_type(CUSTOM_POST_TYPE_PROPERTY);
		}
		
		/* get all the custom fields which select as " Show field on detail page" from back end */
			global $htmlvar_name;
		if(function_exists('tmpl_single_page_custom_field')){
			$htmlvar_name = tmpl_single_page_custom_field(CUSTOM_POST_TYPE_PROPERTY);
		}else{
			global $htmlvar_name;
		}
		
		
		/*do action for display the breadcrumb  inside the container. */ 
		do_action('property_inside_container_breadcrumb'); 
		
		/* Load the sidebar-before-content. */

			if(function_exists('supreme_sidebar_before_content'))
				apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); 
			
			while ( have_posts() ) : the_post(); 
			do_action('property_before_post_loop'); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
				<?php /* do action for before the post title.*/
				
				do_action('property_before_post_title');          ?>
			  
				<!-- Title and details start -->
				<header class="entry-header clearfix">
					<?php do_action('property_open_entry_header'); ?>
					<div class="entry-header-title clearfix">
						<div class="entry-header-left">
							<div class="spt-left">
								<h1 class="entry-title <?php if($is_edit==1):?>frontend-entry-title <?php endif;?>" <?php if($is_edit==1):?> contenteditable="true"<?php endif;?>><?php the_title(); ?></h1>
								<?php /* Display address */
									do_action('property_after_title');
								?>
							</div>
							<div class="spt-right">
								<?php /*  Display the Post rating */				
								do_action('property_title_right',get_the_ID()); ?>
							</div>
						</div>
						<!-- Show Property type -->
						<div class="entry-header-right">
							<?php /* Here to display the property price */ 
							do_action('property_header_right'); ?>
						</div> 
					</div>
					<?php do_action('property_close_entry_header'); ?>
				</header>
				<!-- Title and details end -->
				
				<div class="entry-content">
						<?php
						/* do action for after the post title.*/
						do_action('property_after_post_title');  
						
						/* Here to display bedrooms,bathrooms, area buttons  */ 
						do_action('property_details_display',get_the_ID()); 
						
						/* Here to display all pop up forms  */ 
						do_action('property_popup_links',get_the_ID());
						
						?>
						
					   <?php 
						/* do action for before the post content. */
						do_action('property_before_post_content');     
						/* get the images of property */
						
						/* to check the image is attached or not */
						if(function_exists('bdw_get_images_plugin'))
						{
							$post_img = bdw_get_images_plugin($post->ID,'large');
						} ?>
						<script type="text/javascript">
						jQuery(function() {
							jQuery('#property_image_gallery .property_image a').lightBox();
						});
						</script>
						
						<?php if(!empty($post_img) && $is_edit==''):?>
				
						<!--Image gallery Section Start -->
						<div id="property_image_gallery">
							<div class="property_image flexslider">
								<h2><?php if(count($post_img) <= 1){ echo count($post_img); echo " "; _e('Photo',PDOMAIN); }else{ echo count($post_img); echo " "; _e('Photos',PDOMAIN); } ?></h2>
								<ul class="photos clearfix">
								<?php 
									$main_post_img = bdw_get_images_plugin($post->ID,'property_detail-thumb');
									foreach($main_post_img as $key=>$value):
										$attachment_id = $value['id'];
										$attach_data = get_post($attachment_id);
										$image_attributes = wp_get_attachment_image_src( $attachment_id ,'large'); // returns an array							
										$img_title = $attach_data->post_title; ?>
										<li style="float:left; list-style:none; margin-right:10px;">
											<a itemprop="image" href="<?php echo $image_attributes['0'];?>" title="<?php echo $img_title; ?>"  class="listing_img" >		
												<img src="<?php echo $value['file'];?>" alt="<?php echo $img_title;; ?>"/>
											</a>
										</li>											
								  <?php endforeach;?>
								</ul>						 
							</div>					  
						</div>
						<!--Image gallery Section End -->
					 <?php endif;
					 if($is_edit=="1"):?>
						<!-- Frontend edit upload image-->                   
							<div id="slider" class="listing-image flexslider frontend_edit_image flex-viewport">
								  <h2><?php _e('Photos',PDOMAIN); ?></h2>                      
								<div id="uploadimage" class="upload button secondary_btn clearfix">
									<span><?php _e("Upload Images", PDOMAIN); ?></span>					
								</div>
							</div>
							<div id="frontend_images_gallery_container" class="clearfix flex-viewport">
								<div id="property_image_gallery" class="property_image flexslider">
								<ul class="frontend_images_gallery photos">
									<?php
									if(!empty($post_img)):                				
									foreach($post_img as $key=>$value):
										echo "<li class='image' data-attachment_id='".basename($value['file'])."' data-attachment_src='".$value['file']."'><img src='".$value['file']."' alt='".$img_title."' /><span>
			<a class='delete' title='Delete image' href='#' id='".$value['id']."' ><i class='fa fa-times-circle redcross'></i></a></span></li>";
									endforeach;
									endif;	
									?>
								</ul>
								</div>
								<input type="hidden" id="fontend_image_gallery" name="fontend_image_gallery" value="<?php echo esc_attr( substr(@$image_gallery,0,-1) ); ?>" />
								<span id="forntend_status" class="message_error2 clearfix"></span>
							</div>
							<!--finish editing post images -->                   
					<?php endif;
				 
							global $post,$htmlvar_name;
							$templatic_settings=get_option('templatic_settings');
							$googlemap_setting=get_option('city_googlemap_setting');
							$post_id = get_the_ID();
							$count_post_id = get_the_ID();
							if(get_post_meta($post_id,'_property_id',true)){
								$post_id=get_post_meta($post_id,'_property_id',true);
							}

							$tmpdata = get_option('templatic_settings');	
							$special_offer=get_post_meta($post_id,'proprty_feature',true);
							$video=get_post_meta($post_id,'video',true);
							$facebook=get_post_meta($post_id,'facebook',true);
							$google_plus=get_post_meta($post_id,'google_plus',true);
							$twitter=get_post_meta($post_id,'twitter',true);
							$additional_features=get_post_meta($post_id,'additional_features',true);
							?>
							
								<ul class="tabs" data-tab role="tablist">
								<?php
									do_action('dir_before_tabs');
									do_action('dir_start_tabs'); ?>
										<li class="tab-title active" role="presentational"><a href="#property_details" role="tab" tabindex="0" aria-selected="false" controls="property_details"><?php _e('Property Info',PDOMAIN);?></a></li>
									  <?php
									  if($additional_features!="" && $tmpl_flds_varname['additional_features'] && $tmpl_flds_varname['additional_features'] || ($is_edit==1  && $tmpl_flds_varname['additional_features'])):?>
										<li class="tab-title" role="presentational"><a href="#property_features" role="tab" tabindex="0" aria-selected="false" controls="property_features"><?php _e('Features',PDOMAIN);?></a></li>
									  <?php endif;
									   
									  if($video!="" && $tmpl_flds_varname['video'] && $tmpl_flds_varname['video'] || ($is_edit==1  && $tmpl_flds_varname['video'])):?>
										<li class="tab-title" role="presentational"><a href="#property_video" role="tab" tabindex="0" aria-selected="false" controls="property_video"><?php echo $tmpl_flds_varname['video']['label'];?></a></li>
									  <?php endif;
									  
									 do_action('dir_end_tabs'); ?>
								</ul>
								
								<div class="tabs-content">
								<?php do_action('show_listing_property_detail');
								?>
								
								<?php
								 if($video!="" && $tmpl_flds_varname['video'] && $tmpl_flds_varname['video'] || ($is_edit==1  && $tmpl_flds_varname['video'])):?>
								<!--Video Code Start -->
								<section role="tabpanel" aria-hidden="false" class="content" id="property_video">
									<?php if($is_edit==1):?>
										<div class="frontedit_video_info yellow-panel">
										<?php _e('Embed your video using direct link to your video, see this <a href="https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F"> list of websites</a> from where you can embed video.',PDOMAIN);?>
										</div>
										<span id="frontend_edit_video" class="frontend_oembed_video button" ><?php _e('Edit Video',PDOMAIN);?></span>
										<input type="hidden" class="frontend_video" name="frontend_edit_video" value='<?php echo $video;?>' />
									<?php endif;?>								
									 <div class="frontend_edit_video"><?php             
										$embed_video= wp_oembed_get( $video);            
										if($embed_video!=""){
											echo $embed_video;
										}else{
											echo stripslashes($video);
										}
										?></div>
								</section>
								<!--Video code End -->
								<?php endif; ?>
									 
									<!-- Other Property details -->
									<section role="tabpanel" aria-hidden="false" class="content active" id="property_details">
										<?php do_action('property_detail_informations'); ?>
										<div id="overview" class="entry-content">
											<?php do_action('templ_post_single_content');       /*do action for single post content */?>
										</div><!-- end .entry-content -->
									</section>
									<!-- End Property details -->
									<?php if($additional_features!="" && $tmpl_flds_varname['additional_features'] && $tmpl_flds_varname['additional_features'] || ($is_edit==1  && $tmpl_flds_varname['additional_features'])){ ?>
									<section role="tabpanel" aria-hidden="false" class="content" id="property_features">
										<div class="entry-proprty_feature frontend_additional_features <?php if($is_edit==1):?>editblock <?php endif;?>">
										<?php echo get_post_meta($post->ID,'additional_features',true);?>
										</div>
									</section>
									<?php } 
										do_action('listing_extra_details');
									?>
									</div>
							
							
						<?php	/* do action for after the post content. */
						do_action('property_after_post_content');       ?>
				   </div>
				   <!--Finish the listing Content -->
				  
					
				<!--Custom field collection do action -->
				<?php 
				do_action('property_custom_fields_collection');  
				
				do_action('property_edit_link'); ?>
				</div>
							
				<div class="post-meta clearfix" >                              
					<?php 
					if( @$tmpl_flds_varname['category'] && @$tmpl_flds_varname['category'])
					{
						echo tmpl_get_the_posttype_taxonomies(CUSTOM_MENU_PROPERTY_CAT_LABEL,CUSTOM_CATEGORY_TYPE_PROPERTY);
					}?>
					 <?php echo tmpl_get_the_posttype_tags(CUSTOM_MENU_PROPERTY_TAG_LABEL,CUSTOM_TAG_TYPE_PROPERTY); ?>
				</div>
				
				<div class="property-page-end clearfix">
					<!-- Property Social Media Coding Start -->
					<?php if(function_exists('tevolution_socialmedia_sharelink')) 
							tevolution_socialmedia_sharelink($post); ?>

					<!-- Property Social Media Coding End -->

					<?php  /* Here to show view counter */
					do_action('property_after_post_loop'); ?>
				</div>
				<?php
			endwhile; // end of the loop.
		wp_reset_query(); 
		
		/* add action for display the next previous pagination */ 
		do_action('tmpl_single_post_pagination'); 
		
		/* add action for display before the post comments. */ 
		do_action('tmpl_before_comments'); 
		
		do_action( 'after_entry' ); 
		do_action( 'for_comments' );
		
		/*Add action for display after the post comments. */
		do_action('tmpl_after_comments');
		
		global $post;
		
		/*add action for display the related post list. */
		echo "<div id='loop_property_taxonomy' class='grid'>";
			do_action('tmpl_related_properties');
		echo "</div>"; 
		 
		if(function_exists('supreme_sidebar_after_content'))
				apply_filters('tmpl_after-content',supreme_sidebar_after_content()); /* after-content-sidebar use remove filter to dont display it. */ ?>
		
	</div><!-- #content -->
</div>


<!--Map Section End -->
<?php 
/* Add Gallery Script */
add_action('wp_footer','add_single_slider_script');
function add_single_slider_script()
{
	$post_id = get_the_ID();
	if(get_post_meta($post_id,'_property_id',true)){
		$post_id=get_post_meta($post_id,'_property_id',true);
	}
	$slider_more_listing_img = bdw_get_images_plugin($post_id,'event-single-thumb');
	?>
	<script type="text/javascript">
		jQuery(window).load(function()
		{
			jQuery('#silde_gallery').flexslider({
				animation: "slide",
				<?php if(!empty($slider_more_listing_img) && count($slider_more_listing_img)>11):?>
				controlNav: true,
				directionNav: true,
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				<?php 
				else: ?>
				controlNav: false,
				directionNav: false,
				<?php endif; ?>
				animationLoop: false,
				slideshow: false,
				itemWidth: 70,
				itemMargin: 5,
				asNavFor: '#slider'
			  });
			jQuery('#slider').flexslider(
			{
				animation: 'slide',
				slideshow: false,
				direction: "horizontal",
				slideshowSpeed: 7000,
				animationLoop: true,
				startAt: 0,
				smoothHeight: true,
				easing: "swing",
				pauseOnHover: true,
				video: true,
				controlNav: false,
				directionNav: false,
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				start: function(slider)
				{
					jQuery('body').removeClass('loading');
				}
			});
		});
		jQuery(function() {
			jQuery( "#tabs" ).tabs();
		});

		jQuery('#tabs').bind('tabsshow', function(event, ui) {			
					if (ui.panel.id == "property_map") {	    
						google.maps.event.trigger(Demo.map, 'resize');
						Demo.map.setCenter(Demo.map.center); // be sure to reset the map center as well
						Demo.init();
					}
		});
		jQuery(function() {
			jQuery('#tabs').tabs({
				activate: function(event ,ui){
					//console.log(event);
					var panel=jQuery(".ui-state-active a").attr("href");  
					if(panel=='#property_map'){
						google.maps.event.trigger(Demo.map, 'resize');
						Demo.map.setCenter(Demo.map.center); // be sure to reset the map center as well
						Demo.init();
					}
				}
			});
		});
	</script>
	<?php
}
get_footer(); ?>
