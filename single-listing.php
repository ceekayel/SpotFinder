<?php
/*
 * Tevolution single custom post type template
 */

get_header(); //Header Portion
$tmpdata = get_option('templatic_settings');
$googlemap_setting = get_option('city_googlemap_setting');
$is_edit = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
          $is_edit = 1;
}
$listing_address = get_post_meta(get_the_ID(), 'address', true);
$facebook = get_post_meta(get_the_ID(), 'facebook', true);
$google_plus = get_post_meta(get_the_ID(), 'google_plus', true);
$twitter = get_post_meta(get_the_ID(), 'twitter', true);
if (function_exists('bdw_get_images_plugin')) {
          $post_img = bdw_get_images_plugin(get_the_ID(), 'directory-single-image');
          $postimg_thumbnail = bdw_get_images_plugin(get_the_ID(), 'thumbnail');
          $more_listing_img = bdw_get_images_plugin(get_the_ID(), 'directory-single-thumb');
          $thumb_img = @$post_img[0]['file'];
          $attachment_id = @$post_img[0]['id'];
          $image_attributes = wp_get_attachment_image_src($attachment_id, 'large');
          $attach_data = get_post($attachment_id);
          $img_title = $attach_data->post_title;
          $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
}
global $tmpl_flds_varname, $htmlvar_name;
/* to get the common/context custom fields display by default with current post type */
if (function_exists('tmpl_single_page_default_custom_field')) {
          $tmpl_flds_varname = tmpl_single_page_default_custom_field(get_post_type());
}
if ($tmpdata['direction_map'] == 'yes' && $listing_address):
          ?>
          <div class="map-sidebar">
               <!--Map Section Start -->
               <?php do_action('directory_single_page_map') ?>
               <!--Map Section End -->

          </div>
<?php endif; ?>
<div class="content-sidebar">
     <!-- start content part-->
     <?php
     tmpl_back_link();
     do_action('directory_before_container_breadcrumb'); /* do action for display the breadcrumb in between header and container. */
     ?>
     <div id="content" role="main">	
          <?php
          do_action('directory_inside_container_breadcrumb'); /* do action for display the breadcrumb  inside the container. */

          if (function_exists('supreme_sidebar_before_content'))
                    apply_filters('tmpl_before-content', supreme_sidebar_before_content()); // Loads the sidebar-before-content.
          ?>
          <?php while (have_posts()) : the_post(); ?>
          <?php do_action('directory_before_post_loop'); ?>
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
                         <!--start post type title -->
          <?php do_action('directory_before_post_title');         /* do action for before the post title. */ ?>

                         <header class="entry-header">
                              <?php $listing_logo = get_post_meta(get_the_ID(), 'listing_logo', true); ?>
                              <!-- Start Image Upload -->
          <?php if (($listing_logo != "" && $tmpl_flds_varname['listing_logo']) && ($is_edit == "")): ?>
                                        <div class="entry-header-logo">
                                             <img src="<?php echo $listing_logo ?>" alt="<?php echo $tmpl_flds_varname['listing_logo']['label']; ?>" />
                                        </div>
          <?php elseif ($is_edit == 1): ?>
                                        <div class="entry-header-logo" >
                                             <div style="display:none;" class="frontend_listing_logo"><?php echo $listing_logo ?></div>
                                             <!--input id="fronted_files_listing_logo" class="fronted_files" type="file" multiple="true" accept="image/*" /-->
                                             <div id="fronted_upload_listing_logo" class="frontend_uploader button" data-src="<?php echo $listing_logo ?>">	                 	
                                                  <span><?php echo __('Upload ', ADMINDOMAIN) . $tmpl_flds_varname['listing_logo']['label']; ?></span>						
                                             </div>
                                        </div>
          <?php endif; do_action('tmpl_after_logo'); ?>
                              <!-- End Image Upload -->


                              <div class="entry-header-title">
                                   <h1 itemprop="name" class="entry-title <?php if ($is_edit == 1): ?>frontend-entry-title <?php endif; ?>" <?php if ($is_edit == 1): ?> contenteditable="true"<?php endif; ?> ><?php the_title(); ?></h1>
                                   <?php
                                   if ($tmpdata['templatin_rating'] == 'yes'):
                                             $total = get_post_total_rating(get_the_ID());
                                             $total = ($total == '') ? 0 : $total;
                                             $review_text = ($total == 1 ) ? '<a href="#comments">' . $total . ' ' . __('Review', TDOMAIN) . '</a>' : '<a href="#comments">' . $total . ' ' . __('Reviews', TDOMAIN) . '</a>';
                                             ?>
                                             <div class="listing_rating">
                                                  <div class="directory_rating_row"><span class="single_rating"><?php echo draw_rating_star_plugin(get_post_average_rating(get_the_ID())); ?> <span><?php echo $review_text ?></span></span></div>
                                             </div>
                                   <?php endif;
                                   do_action('directory_display_rating', get_the_ID());
                                   
                                   if(!empty($listing_address) && $tmpl_flds_varname['address']):
                                   ?>
                                        
                                   <div class="entry_address">
                                        <p class="<?php echo $tmpl_flds_varname['address']['style_class']; ?>"><i class="sf-icon"></i><span id="frontend_address" class="listing_custom frontend_address" <?php if ($is_edit == 1): ?>contenteditable="true"<?php endif; ?>><?php echo get_post_meta(get_the_ID(), 'address', true); ?></span></p>
                                   </div>
                                   <?php endif; ?>

                              </div>
          <?php do_action('directory_after_post_title');         /* do action for before the post title. */ ?>   

                         </header>

                         <div class="contact-info">
                              <div class="entry-header-custom-wrap">
                                   <?php
                                   global $htmlvar_name;
                                   $address = get_post_meta(get_the_ID(), 'address', true);
                                   $website = get_post_meta(get_the_ID(), 'website', true);
                                   $phone = get_post_meta(get_the_ID(), 'phone', true);
                                   $listing_timing = get_post_meta(get_the_ID(), 'listing_timing', true);
                                   $email = get_post_meta(get_the_ID(), 'email', true);
                                   if ($address != "" && $tmpl_flds_varname['address']):
                                             ?>

                                             <?php do_action('directory_after_address'); ?>
                                   <?php endif; ?>
                                   <?php
                                   if ($website != "" && $tmpl_flds_varname['website'] || ($is_edit == 1)):
                                             if (!strstr($website, 'http'))
                                                       $website = 'http://' . $website;
                                             ?>
                                             <p class="<?php echo $tmpl_flds_varname['website']['style_class']; ?>"><a target="_blank" id="website" class="frontend_website <?php if ($is_edit == 1): ?>frontend_link<?php endif; ?>" href="<?php echo $website; ?>" ><i class="sf-icon"></i><span><?php echo $tmpl_flds_varname['website']['label']; ?></span></a></p>
                                   <?php
                                   endif;
                                   if ($phone != "" && $tmpl_flds_varname['phone'] || ($is_edit == 1 && $tmpl_flds_varname['phone'])):
                                             ?>
                                             <p class="1phone <?php echo $tmpl_flds_varname['phone']['style_class']; ?>">
                                                  <i class="sf-icon"></i>
                                                  <label><?php echo $tmpl_flds_varname['phone']['label']; ?>: </label>
                                                  <span class="entry-phone frontend_phone listing_custom" <?php if ($is_edit == 1): ?>contenteditable="true" <?php endif; ?>><?php echo $phone; ?></span>
                                             </p>
          <?php endif; ?>

          <?php if ($listing_timing != "" && $tmpl_flds_varname['listing_timing'] || ($is_edit == 1 && $tmpl_flds_varname['listing_timing'])): ?>
                                             <p class="time <?php echo $tmpl_flds_varname['listing_timing']['style_class']; ?>">
                                                  <i class="sf-icon">}</i>
                                                  <label><?php echo $tmpl_flds_varname['listing_timing']['label']; ?>: </label>
                                                  <span class="entry-listing_timing frontend_listing_timing listing_custom" <?php if ($is_edit == 1): ?>contenteditable="true" <?php endif; ?>><?php echo $listing_timing; ?></span>
                                             </p>
          <?php endif; ?>

          <?php if (@$email != "" && @$tmpl_flds_varname['email'] || ($is_edit == 1 && @$tmpl_flds_varname['email'])): ?>
                                             <p class="email  <?php echo $tmpl_flds_varname['email']['style_class']; ?>">
                                                  <i class="sf-icon"></i>
                                                  <label><?php echo $tmpl_flds_varname['email']['label']; ?>: </label>
                                                  <span class="entry-email frontend_email listing_custom" <?php if ($is_edit == 1): ?>contenteditable="true"<?php endif; ?>><?php echo antispambot($email); ?></span>
                                             </p>
                                             <?php
                                   endif;
                                   do_action('directory_display_custom_fields');
                                   ?>
                              </div>

                              <!--Directory Share Link Coding Start -->
                                   <?php tevolution_socialpost_link($post); // to show the link of current post in social media   ?>
                              <!--Directory Share Link Coding End -->
                              <?php do_action('directory_display_after_custom_fields_default'); ?>
                              
                              <div class="claim-post-wraper">
          <?php echo '<div style="display: none; opacity: 0.5;" id="lean_overlay"></div>'; ?>
                                   <ul>
          <?php tevolution_dir_popupfrms($post); // show sent to friend and send inquiry form pop-up   ?>
                                   </ul>
                              </div>

                         </div>

                         <div class="content-img-gallery">
                              <!-- Image Gallery Div --> 
                                   <?php if ($thumb_img && $is_edit == ''): ?>		
                                        <div id="directory_detail_img" class="entry-header-image">

                    <?php do_action('directory_before_post_image'); ?>
                                                       <?php if ($is_edit == ""): ?>
                                                       <div id="slider" class="listing-image flexslider frontend_edit_image">    

                                                            <ul class="slides">
                                                                 <?php
                                                                 if (!empty($post_img) && $tmpl_flds_varname['post_images']):
                                                                           foreach ($post_img as $key => $value):
                                                                                     $attachment_id = $value['id'];
                                                                                     $attach_data = get_post($attachment_id);
                                                                                     $image_attributes = wp_get_attachment_image_src($attachment_id, 'large'); // returns an array							
                                                                                     $img_title = $attach_data->post_title;
                                                                                     $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                                                                                     ?>
                                                                                     <li>
                                                                                          <a href="<?php echo $image_attributes['0']; ?>" title="<?php echo $img_title; ?>" class="listing_img" >		
                                                                                               <img src="<?php echo $value['file']; ?>" alt="<?php echo $img_title; ?>"/>
                                                                                          </a>
                                                                                     </li>

                                        <?php endforeach; ?>
                              <?php endif; ?>
                                                            </ul>

                                                       </div>
                                                       <!-- More Image gallery -->
                                                       <div id="silde_gallery" class="flexslider<?php
                                                                 if (!empty($more_listing_img) && count($more_listing_img) > 4) {
                                                                           echo ' slider_padding_class';
                                                                 }
                                                                 ?>">
                                                            <ul class="more_photos slides">
                                                                 <?php if (!empty($more_listing_img) && count($more_listing_img) > 1): ?>
                                                                           <?php
                                                                           foreach ($more_listing_img as $key => $value):
                                                                                     $attachment_id = $value['id'];
                                                                                     $attach_data = get_post($attachment_id);
                                                                                     $image_attributes = wp_get_attachment_image_src($attachment_id, 'large'); // returns an array							
                                                                                     $img_title = $attach_data->post_title;
                                                                                     $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                                                                                     ?>
                                                                                     <li>				          	
                                                                                          <img src="<?php echo $value['file']; ?>"alt="<?php echo $img_title; ?>"  />				            
                                                                                     </li>

                                                                 <?php endforeach; ?>
                                                       <?php endif; ?>
                                                            </ul>
                                                       </div>
                                                       <!-- Finish More Image gallery -->
                                        <?php endif; ?>
                    <?php do_action('directory_after_post_image'); ?>
                                        </div><!-- .entry-header-image -->
          <?php endif; ?>

                                             <?php if ($is_edit == "1"): ?>
                                        <!-- Frontend edit upload image-->
                                        <div id="directory_detail_img" class="entry-header-image">
                                             <!--editing post images -->
                                             <div id="slider" class="listing-image flexslider frontend_edit_image flex-viewport">
                                                  <ul class="frontend_edit_images_ul">
                                                       <?php
                                                       $post_img = bdw_get_images_plugin($post->ID, 'large');
                                                       if (!empty($post_img)):
                                                                 foreach ($post_img as $key => $value):
                                                                           echo "<li class='image' data-attachment_id='" . basename($value['file']) . "' data-attachment_src='" . $value['file'] . "'><img src='" . $value['file'] . "' alt='" . $img_title . "' /></li>";
                                                                           break;
                                                                 endforeach;
                                                       endif;
                                                       ?>
                                                  </ul>
                                                  <div id="uploadimage" class="upload button secondary_btn clearfix">
                                                       <span><?php _e("Upload Images", TDOMAIN); ?></span>					
                                                  </div>
                                             </div>

                                             <div id="frontend_images_gallery_container" class="clearfix flex-viewport">
                                                  <ul class="frontend_images_gallery more_photos slides">
                                                       <?php
                                                       if (!empty($post_img)):
                                                                 foreach ($post_img as $key => $value):
                                                                           echo "<li class='image' data-attachment_id='" . basename($value['file']) . "' data-attachment_src='" . $value['file'] . "'><img src='" . $value['file'] . "' alt='" . $img_title . "' /><span>
<a class='delete' title='Delete image' href='#' id='" . $value['id'] . "' ><i class='fa fa-times-circle redcross'></i></a></span></li>";
                                                                 endforeach;
                                                       endif;
                                                       ?>
                                                  </ul>
                                                  <input type="hidden" id="fontend_image_gallery" name="fontend_image_gallery" value="<?php echo esc_attr(substr(@$image_gallery, 0, -1)); ?>" />		
                                             </div>
                                             <span id="forntend_status" class="message_error2 clearfix"></span>
                                             <!--finsh editing post images -->
                                        </div>
          <?php endif; ?>

                              <!-- Finish Image Gallery Div -->
                         </div>


                         <!--Code start for single captcha -->   
                         <?php
                         $display = (isset($tmpdata['user_verification_page'])) ? $tmpdata['user_verification_page'] : array();
                         $captcha_set = array();
                         $captcha_dis = '';
                         if (count($display) > 0 && !empty($display)) {
                                   foreach ($display as $_display) {
                                             if ($_display == 'claim' || $_display == 'emaitofrd') {
                                                       $captcha_set[] = $_display;
                                                       $captcha_dis = $_display;
                                             }
                                   }
                         }
                         $recaptcha = get_option("recaptcha_options");
                         global $current_user;
                         ?>

                         <div id="myrecap" style="display:none;"><?php
                         if ($recaptcha['show_in_comments'] != 1 || $current_user->ID != '') {
                                   templ_captcha_integrate($captcha_dis);
                         }
                         ?></div> 
                         <input type="hidden" id="owner_frm" name="owner_frm" value=""  />
                         <div id="claim_ship"></div>
                         <script type="text/javascript">
                                   var RECAPTCHA_COMMENT = '';
          <?php if ($recaptcha['show_in_comments'] != 1 || $current_user->ID != '') { ?>
                                             jQuery('#owner_frm').val(jQuery('#myrecap').html());
                              <?php } else { ?> RECAPTCHA_COMMENT = <?php echo $recaptcha['show_in_comments']; ?>;
                              <?php } ?>
                         </script>

                         <!--Code end for single captcha -->
                         <!-- listing content-->
                         <div class="entry-content">
          <?php do_action('directory_before_entry_content'); ?>

                         <?php get_template_part('directory-listing', 'single-content'); ?>

                         <?php do_action('directory_after_entry_content'); ?>
                         </div>
                         <!--Finish the listing Content -->

                         <!--Custom field collection do action -->
                    <?php do_action('directory_custom_fields_collection'); ?>

                    <?php do_action('directory_extra_single_content'); ?>               

                    </div>
                    <?php do_action('directory_after_post_loop'); ?>

                    <?php do_action('directory_edit_link'); ?>
          <?php endwhile; // end of the loop. ?>

          <?php
          wp_reset_query(); // reset the wp query

          do_action('tmpl_single_post_pagination'); /* add action for display the next previous pagination */

          do_action('tmpl_before_comments'); /* add action for display before the post comments. */

          do_action('after_entry');

          do_action('for_comments');

          do_action('tmpl_after_comments'); /* Add action for display after the post comments. */

          do_action('tmpl_related_listings'); /* add action for display the related post list. */

          if (function_exists('supreme_sidebar_after_content'))
                    apply_filters('tmpl_after-content', supreme_sidebar_after_content()); // after-content-sidebar use remove filter to don't display it 
          ?>
     </div>
     <!-- #content -->


</div>




<!-- end  content part-->
<?php get_footer(); ?>
