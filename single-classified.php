<?php
/**
 * Classified single custom post type template
 *
 * */
get_header();
/* do action for display the breadcrumb in between header and container. */
do_action('classified_before_container_breadcrumb');

do_action('tmpl_before_frontend_edit_container');

$is_edit = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit') {
          $is_edit = 1;
}

// Add css for detail page slider Verticle
$theme_name = wp_get_theme();
if ($theme_name != 'Classifieds') {
          ?>
          <style type="text/css" media="screen">
               .more_photos.slides {transform: none !important;}
          </style>
          <?php
}
?>
<!-- start content part-->
<div id="content" class="large-9 small-12 columns" role="main"> 

     <?php
     global $htmlvar_name, $wpdb, $tmpl_flds_varname;
     /* Get heading type to display the custom fields as per selected section.  */
     if (function_exists('tmpl_fetch_heading_post_type')) {

               $heading_type = tmpl_fetch_heading_post_type(CUSTOM_POST_TYPE_CLASSIFIED);
     }

     /* get all the custom fields which select as " Show field on detail page" from back end */

     if (function_exists('tmpl_single_page_custom_field')) {
               $htmlvar_name = tmpl_single_page_custom_field(CUSTOM_POST_TYPE_CLASSIFIED);
     } else {
               global $htmlvar_name;
     }


     /* to get the common/context custom fields display by default with current post type */
     if (function_exists('tmpl_single_page_default_custom_field')) {
               $tmpl_flds_varname = tmpl_single_page_default_custom_field(CUSTOM_POST_TYPE_CLASSIFIED);
     }
     /* do action for display the breadcrumb  inside the container. */
     do_action('classified_inside_container_breadcrumb');

     /* Loads the sidebar-before-content. */

     if (function_exists('supreme_sidebar_before_content'))
               apply_filters('tmpl_before-content', supreme_sidebar_before_content());

     while (have_posts()) : the_post();
               do_action('classified_before_post_loop');
               ?>
               <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
                    <?php /* do action for before the post title. */

                    do_action('classified_before_post_title');
                    ?>

                    <!-- Title and details start -->
                    <header class="entry-header clearfix">
          <?php do_action('classified_open_entry_header'); ?>
                         <div class="entry-header-title clearfix">
                              <div class="entry-header-left">
                                   <div class="spt-left">
                                        <h1 class="entry-title <?php if ($is_edit == 1): ?>frontend-entry-title <?php endif; ?>" <?php if ($is_edit == 1): ?> contenteditable="true"<?php endif; ?>>
                                             <?php
                                             do_action('before_title_h1');
                                             the_title();
                                             do_action('after_title_h1');
                                             ?>							
                                        </h1>
                                        <?php
                                        /* Display meta info like categories, date and all */
                                        do_action('classified_after_title');
                                        ?>
                                   </div>
                                   <div class="spt-right">
          <?php /*  Display the Post rating */
          do_action('classified_title_right', get_the_ID());
          ?>
                                   </div>
                              </div>
                              <!-- Show Property type -->
                              <div class="entry-header-right">
                         <?php /* Here to display the classified price */
                         do_action('classified_header_right');
                         ?>
                              </div> 
                         </div>
                    <?php do_action('classified_close_entry_header'); ?>
                    </header>
                    <!-- Title and details end -->
                    <?php
                    /* do action for after the post title. */
                    do_action('classified_after_post_title');

                    /* Here to display bedrooms,bathrooms, area buttons  */
                    do_action('classified_details_display', get_the_ID());
                    ?>
                    <div class="entry-content">
                         <?php
                         /* do action for before the post content. */
                         do_action('classified_before_entry_content');
                         /* get the images of classified */

                         /* to check the image is attached or not */
                         if (function_exists('bdw_get_images_plugin')) {
                                   $post_img = bdw_get_images_plugin($post->ID, 'large');
                         }
                         ?>
                         <script type="text/javascript">
                                   jQuery(function () {
                                        jQuery('#classified_image_gallery .classified_image a').lightBox();
                                   });
                         </script>
                         <!-- Slider and classified informations start -->
                         <div class='above-content-tabs clearfix'>
                              <?php
                              /* Here it will display the slider */
                              do_action('tmpl_classified_info_left');

                              /* Here it will display the slider */
                              ?>
                              <?php
                              /* Here it will display the default custom fields */
                              do_action('tmpl_classified_info_right');

                              /* Here it will display the classified informations  */
                              ?>


                         </div>
                         <!-- Slider and classified informations end -->
                         <?php
                         global $post, $htmlvar_name;
                         $templatic_settings = get_option('templatic_settings');
                         $googlemap_setting = get_option('city_googlemap_setting');
                         $post_id = get_the_ID();
                         $count_post_id = get_the_ID();
                         if (get_post_meta($post_id, '_classified_id', true)) {
                                   $post_id = get_post_meta($post_id, '_classified_id', true);
                         }

                         $tmpdata = get_option('templatic_settings');
                         $special_offer = get_post_meta($post_id, 'proprty_feature', true);
                         $facebook = get_post_meta($post_id, 'facebook', true);
                         $google_plus = get_post_meta($post_id, 'google_plus', true);
                         $twitter = get_post_meta($post_id, 'twitter', true);
                         $additional_features = get_post_meta($post_id, 'additional_features', true);
                         ?>

                         <ul class="tabs" data-tab role="tablist">
                              <?php
                              do_action('dir_before_tabs');
                              do_action('dir_start_tabs');
                              ?>
                              <li class="tab-title active" role="presentational"><a href="#classified_details"><?php _e('Info', CDOMAIN); ?></a></li>

                              <?php if ($video != "" && $tmpl_flds_varname['video'] && $tmpl_flds_varname['video']): ?>
                                        <li class="tab-title" role="presentational"><a href="#classified_video"><?php _e('Video', CDOMAIN); ?></a></li>
                              <?php endif; ?>

                              <?php if ($templatic_settings['direction_map'] == 'yes'): ?>
                                        <li class="tab-title" role="presentational"><a href="#locations_map"><?php _e('Map', CDOMAIN); ?></a></li>
                              <?php
                              endif;
                              if ((comments_open() || have_comments()) && (pings_open() || have_comments())) {
                                        ?>

                                        <li class="tab-title" role="presentational"><a href="#classified_reviews"><?php _e('Reviews', CDOMAIN); ?></a></li> 
                                   <?php }
                                   do_action('dir_end_tabs');
                                   ?>
                         </ul>

                         <div class="tabs-content">	
                                        <?php do_action('show_listing_classified_detail'); ?>
                              <!-- Other Property details -->
                              <section role="tabpanel" aria-hidden="false" class="content active entry-content" id="classified_details">
                                   <?php
                                   /* do action for before the post content. */
                                   do_action('classified_before_post_content');

                                   do_action('classified_detail_informations');
                                   ?>
                                   <div id="overview" class="entry-content">
                                   <?php do_action('templ_post_single_content');       /* do action for single post content */ ?>
                                   </div><!-- end .entry-content -->
          <?php
          do_action('classified_custom_fields_collection', array('ad_id', 'owner_name', 'post_city_id', 'price_type', 'price', 'classified_tag', 'google', 'web_site', 'zipcode', 'zip_code'));


          do_action('classified_after_post_content');

          /* Here to display all pop up forms  */
          do_action('classified_popup_links', get_the_ID());
          ?>
                                   <div class="classified-page-end clearfix">
                                        <!-- Property Social Media Coding Start -->
                              <?php if (function_exists('tevolution_socialmedia_sharelink'))
                                        tevolution_socialmedia_sharelink($post);
                              ?>

                                        <!-- Property Social Media Coding End -->

                              <?php /* Here to show view counter */
                              do_action('classified_after_post_loop');
                              ?>
                                   </div>
                              </section>
                              <!-- End Property details -->
          <?php if ($video != "" && $htmlvar_name['basic_inf']['video'] && $htmlvar_name['basic_inf']['video']): ?>
                                        <!--Video Code Start -->
                                        <section role="tabpanel" aria-hidden="false" class="content" id="classified_video">
                                        <?php echo stripslashes($video); ?>
                                        </section>
                                        <!--Video code End -->
                                   <?php endif;
                                   if ($templatic_settings['direction_map'] == 'yes'):
                                             ?>
                                        <!--Map Section Start -->
                                        <section role="tabpanel" aria-hidden="false" class="content" id="locations_map">
                                             <?php do_action('classified_single_page_map') ?>
                                        </section>
                                        <!--Map Section End -->
                                   <?php
                                   endif;
                                   if ((comments_open() || have_comments()) && (pings_open() || have_comments())) {
                                             ?>
                                        <!-- reviews tabs content start-->
                                        <section role="tabpanel" aria-hidden="false" class="content" id="classified_reviews" class="reviews-cls">
                                        <?php
                                        /* add action for display before the post comments. */
                                        do_action('tmpl_classified_before_comments');
                                        /* add action for display before the post comments. */
                                        do_action('tmpl_before_comments');
                                        do_action('for_comments');

                                        /* Add action for display after the post comments. */
                                        do_action('tmpl_after_comments');
                                        ?>
                                        </section>

          <?php }
          do_action('listing_extra_details');
          ?>
                              <!-- reviews tabs content end-->
                         </div>
                    </div>
                    <!--Finish the listing Content -->


                    <!--Custom field collection do action -->
               <?php do_action('classified_edit_link'); ?>
               </div>

               <div class="post-meta" >                              
               <?php echo tmpl_get_the_posttype_tags(CUSTOM_MENU_CLASSIFIED_TAG_LABEL, CUSTOM_TAG_TYPE_CLASSIFIED); ?>
               </div>

               <?php
     endwhile; /* end of the loop. */
     wp_reset_query();

     /* add action for display the next previous pagination */
     do_action('tmpl_single_post_pagination');

     do_action('after_entry');


     global $post;

     if (function_exists('supreme_sidebar_after_content'))
               apply_filters('tmpl_after-content', supreme_sidebar_after_content()); /* after-content-sidebar use remove filter to dont display it. */
     ?>

</div><!-- #content -->
<!--single post type sidebar -->
<?php if (is_active_sidebar(get_post_type() . '_detail_sidebar')) : ?> 
          <aside id="sidebar-primary" class="sidebar large-3 small-12 columns"> 

          <?php dynamic_sidebar(get_post_type() . '_detail_sidebar'); ?>		
          </aside>
          <?php elseif (is_active_sidebar('primary-sidebar')) :
          ?>
          <aside id="sidebar-primary" class="sidebar large-3 small-12 columns"> 

          <?php dynamic_sidebar('primary-sidebar'); ?>
          </aside>
          <?php elseif (is_active_sidebar('sidebar-1')) :
          ?>
          <aside id="secondary" class="widget-area" role="complementary">
          <?php dynamic_sidebar('sidebar-1'); ?>
          </aside><!-- #secondary -->
<?php endif; ?>

<!--end single post type sidebar -->
<!-- end  content part-->
<?php
/* Add Gallery Script */
add_action('wp_footer', 'add_single_slider_script');

function add_single_slider_script() {
          $post_id = get_the_ID();
          if (get_post_meta($post_id, '_classified_id', true)) {
                    $post_id = get_post_meta($post_id, '_classified_id', true);
          }
          $slider_more_listing_img = bdw_get_images_plugin($post_id, 'tevolution_thumbnail');
          ?>
          <script type="text/javascript">

                    jQuery(function () {
                         jQuery('.listing-image a.listing_img').lightBox();
                    });

                    jQuery(window).load(function ()
                    {
                         jQuery('#silde_gallery').flexslider({
                         animation: "slide",
          <?php if (!empty($slider_more_listing_img) && count($slider_more_listing_img) > 11): ?>
                                   controlNav: true,
                                           directionNav: true,
                                           prevText: '<i class="fa fa-chevron-left"></i>',
                                           nextText: '<i class="fa fa-chevron-right"></i>',
                    <?php else:
                    ?>
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
                            start: function (slider)
                            {
                                 jQuery('body').removeClass('loading');
                            }
                    });
                    });
                            jQuery(function () {
                                 jQuery("#tabs").tabs();
                            });

                    jQuery(function () {
                              var n = jQuery("ul.tabs li a").attr("href");
                              if (n == "#locations_map") {
                                        Demo.init();
                              }
                    })

                    jQuery(function () {
                              jQuery("ul.tabs li a").live('click', function () {
                              var n = jQuery(this).attr("href");
                                        if (n == "#locations_map") {
                                                  Demo.init();
                                        }
                         })
                    });
          </script>
          <?php
}

get_footer();
?>