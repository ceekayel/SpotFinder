<?php
/**
 * Tevolution single custom post type template
 *
**/
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-tabs');
$cur_post_type = get_post_meta($cur_post_id,'submit_post_type',true);
$tmpdata = get_option('templatic_settings');	
$address=$_REQUEST['address'];
$geo_latitude =$_REQUEST['geo_latitude'];
$geo_longitude = $_REQUEST['geo_longitude'];
$map_type =$_REQUEST['map_view'];
$website=$_REQUEST['website'];
$phone=$_REQUEST['phone'];
$listing_logo=$_REQUEST['listing_logo'];
$listing_timing=$_REQUEST['listing_timing'];
$email=$_REQUEST['email'];
$special_offer=$_REQUEST['proprty_feature'];
$video=$_REQUEST['video'];
$facebook=$_REQUEST['facebook'];
$google_plus=$_REQUEST['google_plus'];
$twitter=$_REQUEST['twitter'];
$zooming_factor=$_POST['zooming_factor'];
$_REQUEST['imgarr'] = explode(",",$_REQUEST['imgarr']);
/* Set curent language in cookie */
if(is_plugin_active('wpml-translation-management/plugin.php')){
	global $sitepress;
	$_COOKIE['_icl_current_language'] = $sitepress->get_current_language();
}
//condition for captcha inserted properly or not.
$tmpdata = get_option('templatic_settings');
if(isset($tmpdata['user_verification_page']) && $tmpdata['user_verification_page'] != "")
{
	$display = $tmpdata['user_verification_page'];
}
else
{
	$display = "";	
}
$id = $_REQUEST['cur_post_id'];

$permalink = get_permalink( $id );
if( is_plugin_active('wp-recaptcha/wp-recaptcha.php') && $tmpdata['recaptcha'] == 'recaptcha' && in_array('submit',$display) && 'preview' == @$_REQUEST['page'] && 'delete' != $_REQUEST['action'] ){
		require_once( WP_CONTENT_DIR.'/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
						$resp = recaptcha_check_answer ($privatekey,
								getenv("REMOTE_ADDR"),
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);
											
		if (!$resp->is_valid) {
			if($_REQUEST['pid'] != '')
			 {
				wp_redirect(get_permalink($cur_post_id).'/?ptype=post_listing&pid='.$_REQUEST['pid'].'&action=edit&backandedit=1&ecptcha=captch');
			 }
			 else
			 {
				wp_redirect(get_permalink($cur_post_id).'/?ptype=post_listing&backandedit=1&ecptcha=captch');	 
			 }
			exit;
		} 
	}
if(file_exists(get_tmpl_plugin_directory().'are-you-a-human/areyouahuman.php') && is_plugin_active('are-you-a-human/areyouahuman.php') && $tmpdata['recaptcha'] == 'playthru'  && in_array('submit',$display) && 'preview' == @$_REQUEST['page'] && 'delete' != $_REQUEST['action'] )
{
	require_once( get_tmpl_plugin_directory().'are-you-a-human/areyouahuman.php');
	require_once(get_tmpl_plugin_directory().'are-you-a-human/includes/ayah.php');
	$ayah = new AYAH();
	$score = $ayah->scoreResult();
	if(!$score)
	{
		wp_redirect(get_permalink($cur_post_id).'/?ptype=post_listing&backandedit=1&invalid=playthru');
		exit;
	}
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
?>
<link rel='stylesheet' id='directory_style-css'  href='<?php echo TEVOLUTION_DIRECTORY_URL; ?>css/directory.css?ver=3.5.2' type='text/css' media='all' />	
<script id="tmpl-foudation" src="<?php echo TEMPL_PLUGIN_URL; ?>js/foundation.min.js"> </script>
<?php do_action('fetch_directory_preview_field'); 

/* to get the common/context custom fields display by default with current post type */
if(function_exists('tmpl_single_page_default_custom_field')){
	$tmpl_flds_varname = tmpl_single_page_default_custom_field($_REQUEST['cur_post_type']);
}
?>
<!-- start content part-->

<div class="map-sidebar">
	<?php if($address!=''):?>
          <!--Map Section Start -->
          <div id="listing_map">
               <div id="directory_location_map" style="width:100%;">
                    <div class="directory_google_map" id="directory_google_map_id" style="width:100%;"> 
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

<div class="content-sidebar">
	
    <div class="page-header"><?php tmpl_back_link(); ?>
    <div class="breadcrumb breadcrumbs"></div>
    </div>
          
    <div id="content" role="main">	
		<div id="post-<?php the_ID(); ?>" class="listing type-listing listing-type-preview hentry" >  
          
				<header class="entry-header">

				<?php if($listing_logo!=""):?>
					<div class="entry-header-logo">
					<img src="<?php echo $listing_logo?>" alt="<?php _e('Logo',TDOMAIN);?>" />
					</div>
				<?php endif;?>

				<div class="entry-header-title">
					<h1 itemprop="name" class="entry-title"><?php echo stripslashes($_REQUEST['post_title']); ?></h1>
					<?php if($_REQUEST['address']!=""):?>
					<div class="entry_address">
					<p><i class="sf-icon"></i><?php echo $_REQUEST['address'];?></p>
					</div>
					<?php endif;?>
				</div>                    

				</header>
                              
				<div class="contact-info">
				<div class="entry-header-custom-wrap">
					<?php if($website!=""): if(!strstr($website,'http'))  $website = 'http://'.$website; ?>
					<p><a href="<?php echo $website;?>"><i class="sf-icon"></i><span><?php _e('Website',TDOMAIN);?></span></a></p>
					<?php endif;
					
					if($phone!=""):?>
					<p class="phone"><i class="sf-icon"></i><label><?php _e('Phone',TDOMAIN);?>: </label><span class="listing_custom"><?php echo $phone;?></span></p>
					<?php endif;
					
					if($listing_timing!=""):?>
					<p class="time"><i class="sf-icon">}</i><label><?php _e('Time',TDOMAIN);?>: </label><span class="listing_custom"><?php echo $listing_timing;?></span></p>
					<?php endif;
					
					if($email!=""):?>
					<p class="email"><i class="sf-icon"></i><label><?php _e('Email',TDOMAIN);?>: </label><span class="listing_custom"><?php echo antispambot($email);?></span></p>
					<?php endif;
					
					do_action('directory_display_custom_fields_preview'); ?>
				</div>
				<div class="share_link">  
					<?php if(is_ssl()){ $http = "https://"; }else{ $http ="http://"; } ?>			
					<script type="text/javascript" src="<?php echo $http; ?>s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
					<?php if($facebook!="" && $tmpl_flds_varname['facebook']):?>
					<a class="frontend_facebook " href="<?php echo $facebook;?>"><img src="<?php echo TEVOLUTION_DIRECTORY_URL; ?>images/i_facebook21.png" alt="Facebook"  /></a>
					<?php endif;

					if($twitter!="" && $tmpl_flds_varname['twitter']):?>
					<a class="frontend_twitter " href="<?php echo $twitter;?>"><img src="<?php echo TEVOLUTION_DIRECTORY_URL; ?>images/i_twitter2.png" alt="Twitter"  /></a>
					<?php endif;
					
					if($google_plus!="" && $tmpl_flds_varname['google_plus']):?>
					<a class="frontend_google_plus " href="<?php echo $google_plus;?>"><img src="<?php echo TEVOLUTION_DIRECTORY_URL; ?>images/i_googleplus.png" alt="Google Plus"  /></a>
					<?php endif;?>
				</div>
				</div>
                              
				<div class="content-img-gallery">
				      <?php if($_REQUEST['imgarr'][0]!='' ):?>
                      	<div id="directory_detail_img" class="entry-header-image">
                        	<?php do_action('directory_preview_before_post_image');
								$thumb_img_counter = 0;
								$thumb_img_counter = $thumb_img_counter+count($_REQUEST['imgarr']);
								$image_path = get_image_phy_destination_path_plugin();
								$tmppath = "/".$upload_folder_path."tmp/";
								
								foreach($_REQUEST['imgarr'] as $image_id=>$val):
									 $thumb_image = get_template_directory_uri().'/images/tmp/'.trim($val);
									break;
								endforeach;
							if(isset($_REQUEST['pid']) && $_REQUEST['pid']!="")
							{	/* execute when comes for edit the post */
								$large_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'directory-single-image');
								$thumb_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'tevolution_thumbnail');
								$largest_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'large');		
							}
						 ?>
                         	<div class="listing-image">
								 <?php $f=0; foreach($_REQUEST['imgarr'] as $image_id=>$val):
										$curry = date("Y");
										$currm = date("m");
										$src = get_template_directory().'/images/tmp/'.$val;
										$img_title = pathinfo($val);
										
								  ?>
									<?php if($largest_img_arr): ?>
											<?php  foreach($largest_img_arr as $value):
												$tmp_v = explode("/",$value['file']);
												 $name = end($tmp_v);
												  if($val == $name):	
											?>
												<img src="<?php echo  $value['file'];?>" alt="" width="300" height="230" class="Thumbnail thumbnail large post_imgimglistimg"/>
											<?php endif;
												endforeach;
										else: ?>								
										<img src="<?php echo $thumb_image;?>" alt="" width="300" height="230" class="Thumbnail thumbnail large post_imgimglistimg"/>
									<?php endif;
									if($f==0) break; endforeach;?>								 
							 </div>	
                             <?php  if(count(array_filter($_REQUEST['imgarr']))>1):?>					
							 <div id="gallery" class="image_title_space">
								<ul class="more_photos">
								 <?php foreach($_REQUEST['imgarr'] as $image_id=>$val)
									{
										$curry = date("Y");
										$currm = date("m");
										$src = get_template_directory().'/images/tmp/'.$val;
										$img_title = pathinfo($val);						
										if($val):
										if(file_exists($src)):
												 $thumb_image = get_template_directory_uri().'/images/tmp/'.$val; ?>
												 <li><img src="<?php echo $thumb_image;?>" alt="" height="50" width="50" title="<?php echo $img_title['filename'] ?>" /></li>
										<?php else: ?>
											<?php
												if($largest_img_arr):
												foreach($largest_img_arr as $value):	
													$tmpl = explode("/",$value['file']);
													$name = end($tmpl);									
													if($val == $name):?>
													<li><img src="<?php echo $value['file'];?>" alt="" height="50" width="50" title="<?php echo $img_title['filename'] ?>" /></li>
											<?php
													endif;
												endforeach;
												endif;
											?>
										<?php endif;
										
										else: 
											if($thumb_img_arr): ?>
											<?php 
											$thumb_img_counter = $thumb_img_counter+count($thumb_img_arr);
											for($i=0;$i<count($thumb_img_arr);$i++):
												$thumb_image = $large_img_arr[$i];
												
												if(!is_array($thumb_image)):
											?>
											  <li><img src="<?php echo $thumb_image;?>" alt="" height="50" width="50" title="<?php echo $img_title['filename'] ?>" /></li>
											  <?php endif;?>
										<?php endfor; ?>
										<?php endif; ?>	
										<?php endif; ?>
									<?php
									$thumb_img_counter++;
									} ?>
									
									</ul>
							 </div>                 
						   <?php endif;?>
                           <!-- -->                                   
                           <?php do_action('directory_preview_after_post_image');?>                              
                        </div>                      
                      
				
				<?php if(!empty($more_listing_img) && count($more_listing_img)>1):?>
                    <div id="gallery">
                        <ul class="more_photos">
                        <?php foreach($more_listing_img as $key=>$value):
                        $attachment_id = $value['id'];
                        $attach_data = get_post($attachment_id);
                        $image_attributes = wp_get_attachment_image_src( $attachment_id ,'large'); // returns an array							
                        $img_title = $attach_data->post_title;
                        ?>
                        <li>
                            <a href="<?php echo $image_attributes['0'];?>" title="<?php echo $img_title; ?>" alt="<?php echo $img_alt; ?>" >		
                            <img src="<?php echo $value['file'];?>" />
                            </a>
                        </li>
    
                        <?php endforeach;?>
                        </ul>
                    </div>
				<?php endif;
				
				do_action('directory_after_post_image');?>
				
				<?php endif;
				
				if($_REQUEST['file_info'] &&  @$_REQUEST['pid']==""):?>
                    <div id="directory_detail_img" class="entry-header-image">
                    <?php do_action('directory_preview_before_post_image');
                        
                        $thumb_img_counter = 0;
                        $thumb_img_counter = $thumb_img_counter+count($_REQUEST["file_info"]);
                        $image_path = get_image_phy_destination_path_plugin();
                        $tmppath = "/".$upload_folder_path."tmp/";						
                        foreach($_REQUEST["file_info"] as $image_id=>$val):
                            $thumb_image = get_template_directory_uri().'/images/tmp/'.trim($val);
                        break;
                        endforeach;	
    
                        if(isset($_REQUEST['pid']) && $_REQUEST['pid']!="")
                        {	/* execute when comes for edit the post */
                          $large_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'directory-single-image');
                          $thumb_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'tevolution_thumbnail');
                          $largest_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'directory-single-image');		
                        }
                    ?>							
                    <div class="listing-image">
                       <?php $f=0; 
                            foreach($_REQUEST["file_info"] as $image_id=>$val):
                                          $curry = date("Y");
                                          $currm = date("m");
                                          $src = get_template_directory().'/images/tmp/'.$val;
                                          $img_title = pathinfo($val);
                                          
                                if($largest_img_arr): ?>
                                    <?php  
                                    foreach($largest_img_arr as $value):
                                        $tmp_v = explode("/",$value['file']);
                                        $name = end($tmp_v);
                                        if($val == $name):	
                                        ?>
                                            <img src="<?php echo  $value['file'];?>" alt="" width="300" height="230" class="Thumbnail thumbnail large post_imgimglistimg"/>
                                        <?php endif;
                                    endforeach;
                                else: ?>								
                                    <img src="<?php echo $thumb_image;?>" alt="" width="300" height="230" class="Thumbnail thumbnail large post_imgimglistimg"/>
                                <?php endif;
                                if($f==0) break; 
                            endforeach;?>								 
                    </div>	
                    <?php  if(count(array_filter($_REQUEST["file_info"]))>1):?>					
                    <div id="gallery" class="image_title_space">
                        <ul class="more_photos">
                        <?php 
                        foreach($_REQUEST["file_info"] as $image_id=>$val)
                        {
                            $curry = date("Y");
                            $currm = date("m");
                            $src = get_template_directory().'/images/tmp/'.$val;
                            $img_title = pathinfo($val);						
                            if($val):
                                if(file_exists($src)):
                                    $thumb_image = get_template_directory_uri().'/images/tmp/'.$val; ?>
                                    <li><a href="<?php echo $thumb_image;?>" title="<?php echo $img_title['filename']; ?>"><img src="<?php echo $thumb_image;?>" alt="" height="50" width="50" title="<?php echo $img_title['filename'] ?>" /></a></li>
                                <?php 
                                else: 
                                    if($largest_img_arr):
                                        foreach($largest_img_arr as $value):	
                                            $tmpl = explode("/",$value['file']);
                                            $name = end($tmpl);									
                                            if($val == $name):?>
                                                <li><a href="<?php echo $value['file']; ?>" title="<?php echo $img_title['filename']; ?>"><img src="<?php echo $value['file'];?>" alt="" height="50" width="50" title="<?php echo $img_title['filename'] ?>" /></a></li>
                                            <?php
                                            endif;
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
                                        <li><a href="<?php echo $thumb_image;?>" title="<?php echo $img_title['filename']; ?>"><img src="<?php echo $thumb_image;?>" alt="" height="50" width="50" title="<?php echo $img_title['filename'] ?>" /></a></li>
                                        <?php endif;
                                        
                                    endfor; 
    
                                endif; 
                            
                            endif; 
                            
                            $thumb_img_counter++;
                        } ?>
    
                        </ul>
                    </div>                 
                    <?php endif;
                    
                    do_action('directory_preview_after_post_image');?> 
                    </div>                             
				<?php endif;?>
				</div>
                              
                              
                              
        		<!-- listing content-->
               <div class="entry-content">
				<?php do_action('directory_preview_before_post_content'); /*Add Action for after preview post content. */?>
               	
               
               	<div id="tabs">
					<ul>
						<li class="tab-title" role="presentational"><a href="#listing_description" role="tab" tabindex="1" aria-selected="false" controls="listing_description"><?php _e('Overview',TDOMAIN);?></a></li>

					<?php if($special_offer!=""):?>
						<li class="tab-title" role="presentational"><a href="#special_offer" role="tab" tabindex="2" aria-selected="false" controls="special_offer"><?php _e('Special Offer',TDOMAIN);?></a></li>
					<?php endif;
					
						if($video!=""):?>
						<li class="tab-title" role="presentational"><a href="#listing_video" role="tab" tabindex="2" aria-selected="false" controls="listing_video"><?php _e('Video',TDOMAIN);?></a></li>
					<?php endif;
					
					do_action('dir_end_tabs_preview'); ?>

					</ul>
					<!--Overview Section Start -->
					<section role="tabpanel" aria-hidden="false" class="content" id="listing_description">
						<div class="<?php if($thumb_img || $_REQUEST['file_info']!=''):?>listing_content<?php else:?>content_listing <?php endif;?>">

						<?php echo stripslashes($_REQUEST['post_content']);?>
						</div>
					</section>

					<?php if($special_offer!=""):?>
						<!--Special Offer Start -->
						<section role="tabpanel" aria-hidden="false" class="content" id="special_offer">
						<?php echo stripslashes($special_offer);?>
						</section>
						<!--Special Offer End -->
					<?php endif;
					
					
					if($video!=""):?>
						<!--Video Code Start -->
						<section role="tabpanel" aria-hidden="false" class="content" id="listing_video">
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
					<?php endif;

					do_action('listing_end_preview');?>
                         
                    </div>
               
        		<?php do_action('dir_preview_after_post_content'); /*Add Action for after preview post content. */?>
	          </div>
               <!--Finish the listing Content -->
				
               <?php do_action('directory_preview_page_fields_collection');?>
		  <div class="post-meta">  
		  <?php 
		  if(function_exists('directory_post_preview_categories_tags')){
			echo directory_post_preview_categories_tags($_REQUEST['category'],$_REQUEST['post_tags']);
		  } ?>
		  </div>
         
		</div>
	</div>          
</div>

<script type="text/javascript">
jQuery(function() {
	jQuery( "#tabs" ).tabs();
});
jQuery(function() {
	//jQuery('#image_gallery a').lightBox();
});
jQuery('#tabs').bind('tabsshow', function(event, ui) {	
    if (ui.panel.id == "listing_map") {	    
		google.maps.event.trigger(Demo.map, 'resize');
		Demo.map.setCenter(Demo.map.center); // be sure to reset the map center as well
		Demo.init();
    }
});
(function($) {
  
	Demo.init();
	
})(jQuery); 

</script>
<!-- end  content part-->
<?php 
$_REQUEST['file_info'] = (isset($_POST['imgarr']) && $_POST['imgarr']!="")?explode(",",$_POST['imgarr']) : ''; ?>