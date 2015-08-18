<?php
/**
 * preview page of property post type
 *
**/

global $upload_folder_path;
$current_user = wp_get_current_user();
$cur_post_id = $_REQUEST['cur_post_id'];
$cur_post_type = get_post_meta($cur_post_id,'submit_post_type',true);
$tmpdata = get_option('templatic_settings');	
$date_formate=get_option('date_format');
$time_formate=get_option('time_format');

$address=$_REQUEST['address'];
$geo_latitude =$_REQUEST['geo_latitude'];
$geo_longitude = $_REQUEST['geo_longitude'];
$map_type =$_REQUEST['map_view'];
$website=$_REQUEST['website'];
$phone=$_REQUEST['phone'];
$listing_logo=$_SESSION['upload_file']['listing_logo'];
$listing_timing=$_REQUEST['listing_timing'];
$email=$_REQUEST['email'];
$special_offer=$_REQUEST['proprty_feature'];
$video=$_REQUEST['video'];
$facebook=$_REQUEST['facebook'];
$google_plus=$_REQUEST['google_plus'];
$twitter=$_REQUEST['twitter'];
$_GET['page']=$_REQUEST['page'] ='preview';
$post_img=$_REQUEST['imgarr'] = explode(",",$_REQUEST['imgarr']);
/* Set curent language in cookie */
if(is_plugin_active('wpml-translation-management/plugin.php')){
	global $sitepress;
	$_COOKIE['_icl_current_language'] = $sitepress->get_current_language();
}

wp_enqueue_script('jquery-ui-tabs');
global $htmlvar_name,$heading_type,$tmpl_flds_varname;
/* Get heading type to display the custom fields as per selected section.  */
if(function_exists('tmpl_fetch_heading_post_type')){

	$heading_type = tmpl_fetch_heading_post_type(CUSTOM_POST_TYPE_PROPERTY);
}

/* get all the custom fields which select as " Show field on detail page" from back end */

if(function_exists('tmpl_single_page_custom_field')){
	$htmlvar_name = tmpl_single_page_custom_field(CUSTOM_POST_TYPE_PROPERTY);
}else{
	global $htmlvar_name;
}

/* to get the common/context custom fields display by default with current post type */
if(function_exists('tmpl_single_page_default_custom_field')){	
	$tmpl_flds_varname = tmpl_single_page_default_custom_field(CUSTOM_POST_TYPE_PROPERTY);
}
if(function_exists('bdw_get_images_plugin') && (isset($_REQUEST['pid']) && $_REQUEST['pid']!=''))

{

	$post_img = bdw_get_images_plugin($_REQUEST['pid'],'directory-single-image');

	$postimg_thumbnail = bdw_get_images_plugin($_REQUEST['pid'],'thumbnail');

	$more_listing_img = bdw_get_images_plugin($_REQUEST['pid'],'tevolution_thumbnail');

	$thumb_img = $post_img[0]['file'];

	$attachment_id = $post_img[0]['id'];

	$attach_data = get_post($attachment_id);

	$img_title = $attach_data->post_title;

	$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

}
do_action('fetch_property_preview_field');?>
<!-- start content part-->
<div class="map-sidebar">
<?php if($address!=''):?>
      <!--Map Section Start -->
      <div id="event_map">
           <div id="event_location_map" style="width:100%;">
                <div class="event_google_map" id="event_google_map_id" style="width:100%;"> 
                <?php 
				$post = '';
				if(file_exists(TEMPL_MONETIZE_FOLDER_PATH.'templatic-custom_fields/google_map_detail.php')){
						include_once (TEMPL_MONETIZE_FOLDER_PATH.'templatic-custom_fields/google_map_detail.php');
					}?> 
                </div>  <!-- google map #end -->
           </div>
      </div>
      <!--Map Section End -->
 <?php endif; ?> 
</div>
<script id="tmpl-foudation" src="<?php echo TEMPL_PLUGIN_URL; ?>js/foundation.min.js"> </script>

<div class="content-sidebar">

	<div class="page-header"><?php tmpl_back_link(); ?>
		<div class="breadcrumb breadcrumbs"></div>
    </div>

<div id="content" role="main">	
	
     <div id="post-<?php the_ID(); ?>" class="property type-property property-type-preview hentry" >       		
          
				<header class="entry-header clearfix">
                    <div class="entry-header-title">
                        
						<div class="entry-header-left">
							<div class="spt-left">
							<h1 class="entry-title"><?php echo $_REQUEST['post_title']; ?></h1>
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
					
						<!-- Show Property type -->
						<div class="entry-header-right">
							<?php /* Here to display the property price */ 
							do_action('property_header_right'); ?>
						</div> 
					</div>
                </header>
        		<!-- listing content-->
				<?php
				/* do action for after the post title.*/
				do_action('property_after_post_title');  
				
				/* Here to display bedrooms,bathrooms, area buttons  */ 
				do_action('property_details_display',get_the_ID()); 
				
				/* Here to display all pop up forms  */ 
				do_action('property_popup_links',get_the_ID());
				
				?>
				<div class="entry-content">
				   <?php 
					/* do action for before the post content. */
					do_action('property_before_post_content');     
					/* get the images of property */
					
					/* to check the image is attached or not */				
					if(!empty($_SESSION['file_info']) || !empty($post_img)): ?>
					<!--Image gallery Section Start -->
					<div id="property_image_gallery">
						<div class="property_image flexslider">
							<h2><?php echo count($post_img); echo " "; _e('Photos',PDOMAIN); ?></h2>
							<ul class="photos clearfix">
							<?php 
								if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !=''){
									/* When come for edit the listing */
									foreach($more_listing_img as $key=>$value):
											$attachment_id = $value['id'];
											$attach_data = get_post($attachment_id);
											$image_attributes = wp_get_attachment_image_src( $attachment_id ,'large'); // returns an array							
											$img_title = $attach_data->post_title;
									?>
									   <li> 
											 <img src="<?php echo $value['file'];?>" />											 
									   </li>
											
								<?php endforeach;
								}else{
								 foreach($_REQUEST['imgarr'] as $image_id=>$val)
								 {
									$curry = date("Y");
									$currm = date("m");
									$src = get_template_directory().'/images/tmp/'.$val;
									$img_title = pathinfo($val);						
									if($val):
									if(file_exists($src)):
											 $thumb_image = get_template_directory_uri().'/images/tmp/'.$val; ?>
											 <li style="float:left; list-style:none; margin-right:10px;">												
												<img src="<?php echo $thumb_image;?>" alt="<?php echo $img_title['filename']; ?>"/>												
											</li>	
									<?php else: 
											if($largest_img_arr):
											foreach($largest_img_arr as $value):
												$name = end(explode("/",$value['file']));									
												if($val == $name):?>
												<li style="float:left; list-style:none; margin-right:10px;">												
													<img src="<?php echo $value['file'];?>" alt="<?php echo $img_title['filename']; ?>"/>												
												</li>	
									<?php	endif;
											endforeach;
										endif;
									endif; 
									else: 
										if($thumb_img_arr): 
									
										$thumb_img_counter = $thumb_img_counter+count($thumb_img_arr);
										for($i=0;$i<count($thumb_img_arr);$i++):
											$thumb_image = $large_img_arr[$i];
											
											if(!is_array($thumb_image)):
										?>
										  <li><a href="<?php echo $thumb_image;?>" title="<?php echo $img_title['filename']; ?>"><img src="<?php echo $thumb_image;?>" alt="" height="70" width="70" title="<?php echo $img_title['filename'] ?>" /></a></li>
										  <?php endif;
									  endfor; 
									  endif; 
									  endif; 
								$thumb_img_counter++;
								} 
								}	?>
							</ul>						 
						</div>					  
					</div>
					<!--Image gallery Section End -->
				<?php endif;
			 
						global $post,$htmlvar_name;
						$templatic_settings=get_option('templatic_settings');
						$googlemap_setting=get_option('city_googlemap_setting');
						
						if(isset($_REQUEST['page']) && $_REQUEST['page']=='preview' ){
							/* for preview page */
							
							$special_offer = $_REQUEST['proprty_feature'];
							$video = $_REQUEST['video'];
							$facebook = $_REQUEST['facebook'];
							$google_plus =  $_REQUEST['google_plus'];
							$twitte =  $_REQUEST['twitter'];
							$additional_features= $_REQUEST['additional_features'];
						}else{
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
						}
						?>
						
							<ul class="tabs" data-tab role="tablist">
							<?php
								do_action('dir_before_tabs');
								do_action('dir_start_tabs'); ?>
								  <li class="tab-title active"><a href="#property_details"><?php _e('Property Info',PDOMAIN);?></a></li>
								
								  <?php
								  if($additional_features!="" && ($htmlvar_name['basic_inf']['additional_features'] || $tmpl_flds_varname['additional_features'])  && ($htmlvar_name['basic_inf']['additional_features'] || $tmpl_flds_varname['additional_features'])):?>
								  <li class="tab-title"><a href="#property_features"><?php _e('Features',PDOMAIN);?></a></li>
								  <?php endif;
								 
								  
								  if($video!="" && ($htmlvar_name['basic_inf']['video'] || $tmpl_flds_varname['video'])):?>
									<li class="tab-title"><a href="#property_video"><?php _e('Video',TDOMAIN);?></a></li>
								  <?php endif;
								  
								 do_action('dir_end_tabs_preview'); ?>
							</ul>
						<div class="tabs-content"> 

							<?php do_action('show_listing_property_detail');
							 
							 if($video!="" && ($htmlvar_name['basic_inf']['video'] || $tmpl_flds_varname['video'])):?>
								<!--Video Code Start -->
								<section role="tabpanel" aria-hidden="false" class="content" id="property_video">
									<?php 
										$embed_video= wp_oembed_get( $video);            
										if($embed_video!=""){
											echo $embed_video;
										}else{
											echo stripslashes($video);
										} 
									?>
								</section>
								<!--Video code End -->
							<?php endif; ?>
								
								<!-- Other Property details -->
								<section role="tabpanel" aria-hidden="false" class="content active" id="property_details" class="entry-content">
									<?php do_action('property_detail_informations'); ?>
									<div id="overview" class="entry-content">
										<h2><?php _e('Property Description',PDOMAIN); ?></h2>
										 <?php 
										 if(isset($_REQUEST['page']) && $_REQUEST['page'] =='preview' && ($htmlvar_name['basic_inf']['post_content'] || $tmpl_flds_varname['post_content'])){
											echo $_REQUEST['post_content'];
										 }else{
											do_action('templ_post_single_content');       /*do action for single post content */
										 } ?>
									</div><!-- end .entry-content -->
								</section>
								<!-- End Property details -->
								<?php if($additional_features!="" && ($htmlvar_name['basic_inf']['additional_features'] || $tmpl_flds_varname['additional_features']) && @$_REQUEST['additional_features']){ ?>
								<section role="tabpanel" aria-hidden="false" class="content" id="property_features" class="entry-content">
									<?php echo $_REQUEST['additional_features'];?>
								</section>
								<?php } ?>
								<?php do_action('listing_end_preview');?>
						</div>
						
					<?php	/* do action for after the post content. */
					do_action('property_after_post_content');       ?>
               </div>
               <!--Finish the listing Content -->
			   
              
               <?php do_action('property_preview_page_fields_collection');?>
				<div class="post-meta" >                              
				<?php 
				if( @$htmlvar_name['basic_inf']['category'] || @$tmpl_flds_varname['category'])
				{
					echo tmpl_property_post_preview_categories_tags($_REQUEST['category'],$_REQUEST['post_tags']);
				}	?>
			 </div>
     </div>
</div>
</div>
<!--End content part -->
<script type="text/javascript">	
jQuery(function(){
	Demo.init();
	jQuery("ul.tabs li a").live('click',function(){
	var n=jQuery(this).attr("href");
	if(n=="#property_map")
	{
		Demo.init();
	}
 })});
</script>