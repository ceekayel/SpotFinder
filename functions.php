<?php
ob_start();
define('TDOMAIN', 'templatic');
if (!defined('ADMINDOMAIN'))
          define('ADMINDOMAIN', 'templatic-admin'); /* tevolution* deprecated */
if (defined('WP_DEBUG') and WP_DEBUG == true) {
          error_reporting(E_ALL ^ E_NOTICE);
} else {
          error_reporting(0);
}
global $pagenow, $page;
if (is_admin() && ($pagenow == 'themes.php' || $pagenow == 'update-core.php' || $pagenow == 'post.php' || $pagenow == 'edit.php' || trim($page) == trim('tmpl_theme_update'))) {
          require_once('wp-updates-theme.php');
          new WPUpdatesSpotFinderUpdater('http://templatic.com/updates/api/', basename(get_stylesheet_directory()));
}
add_action('after_setup_theme', 'spotfinder_theme_setup', 12);
add_action('init', 'spotfinder_remove_sidebar', 10);
add_action('admin_init', 'spotfinder_wp_admin');

/* theme settings */

function spotfinder_theme_setup() {

          /* localization */
          $locale = get_locale();

          if (is_admin()) {
                    if (file_exists(get_stylesheet_directory() . '/languages/admin-' . $locale . '.mo')) {
                              load_textdomain(ADMINDOMAIN, get_stylesheet_directory() . '/languages/admin-' . $locale . '.mo');
                    } else {
                              load_textdomain(ADMINDOMAIN, get_template_directory() . '/languages/admin-' . $locale . '.mo');
                    }
          } else {
                    if (file_exists(get_stylesheet_directory() . '/languages/' . $locale . '.mo')) {
                              load_textdomain(TDOMAIN, get_stylesheet_directory() . '/languages/' . $locale . '.mo');
                    } else {
                              load_textdomain(TDOMAIN, get_template_directory() . '/languages/' . $locale . '.mo');
                    }
          }
          /* category pages map */

          /* to remove default rating comes from tevolution, implement in child theme with pinpoint in catgory pages */
          remove_action('templ_post_title', 'tevolution_listing_after_title', 12);
          add_action('listing_post_info', 'spotfinder_listing_after_title', 99);
          add_action('event_post_info', 'spotfinder_listing_after_title', 99);

          /* for property category */
          add_action('property_before_post_content', 'spotfinder_listing_after_title', 99);
          remove_action('wp_head', 'directory_script_style');
          add_action('wp_head', 'spotfinder_script_style');
          remove_action('directory_after_loop_taxonomy', 'directory_categories_google_map');
          remove_action('directory_after_loop_archive', 'directory_categories_google_map');
          remove_action('directory_before_loop_search', 'directory_categories_google_map');
          remove_action('before_listing_page_setting', 'directory_before_listing_page_setting_callback');
          /* remove address related yellow box action */
          remove_action('directory_after_address', 'frontend_editor_directory_after_address');

          remove_action('init', 'directory_init_function');
          add_action('init', 'spotfinder_init_function');
          /* remove map view option */
          remove_action('tmpl_page_view_option', 'dir_page_view_options', 10);
          remove_action('after_listing_page_setting', 'google_map_listing_map_setting');
          /* remove deault city navigation after body tag */
          remove_action('after_body', 'location_header_navigation', 10);

          /* remove pinpoint,comments, and reviews link */
          remove_action('directory_after_taxonomies', 'directory_after_taxonomies_content', 10);
          /* just add comments and reviews icon */
          add_action('directory_after_taxonomies', 'dtheme_after_taxonomies_content', 10);

          /* Add the support for theme specific menus. */
          add_theme_support('supreme-core-menus', array('secondary'));

          /*  Add Action for Customizer Controls Settings Start */
          add_action('customize_register', 'spotfinder_register_customizer_settings', 100);

          /* carousal slider compatibility */
          add_theme_support('show_carousel_slider');
          add_theme_support('map_with_noresultsfound');
          remove_theme_support('slider-post-inslider');

          /* remove this option for full for map and instasearch always show in full width */
          remove_theme_support('map_fullwidth_support');

          /* widget areas */
          add_theme_support('supreme-core-sidebars', array(// Add sidebars or widget areas.
                    'header',
                    'mega_menu',
                    'menu-right',
                    'home-page-banner',
                    'below_theme_header',
                    'above_homepage_content',
                    'home-page-content',
                    'home-page-above-footer',
                    'before-content',
                    'after-content',
                    'front-page-sidebar',
                    'listings_left_content',
                    'author-page-sidebar',
                    'post-listing-sidebar',
                    'post-detail-sidebar',
                    'primary-sidebar',
                    'after-singular',
                    'contact_page_widget',
                    'contact_page_sidebar',
                    'supreme_woocommerce',
                    'advance_search_sidebar',
                    'footer'));
          /* un register menu */
          unregister_nav_menu('primary');
          $predata = get_option('tmpl_spotfinder_predata');
          if (isset($predata) && $predata != 'save') {

                    $category_googlemap_widget = get_option('city_googlemap_setting');
                    $tmpdata1['category_googlemap_widget'] = 'No';

                    if ($tmpdata1)
                              $category_googlemap_widget = array_merge($category_googlemap_widget, $tmpdata1);
                    update_option('category_googlemap_widget', $category_googlemap_widget);

                    update_option('tmpl_spotfinder_predata', 'save');
          }
          $predata_map = get_option('tmpl_spotfinder_map_setting');

          add_filter('wp_nav_menu_items', 'tmpl_filter_ctheme_nav_bars', 10, 2);
          add_filter('show_secondary_navigation_right', 'tmpl_filter_ctheme_nav_bars_megamenu');
          /* remove map view option from category page settings from tevolution */
          remove_action('tmpl_other_page_view_option', 'dir_page_view_options');
          /* hide listing dummy install strip from backend in plugin section */
          update_option('hide_listing_ajax_notification', true);
}

add_action('admin_init', 'spotfinder_setting_add_page_menu', 99);

function spotfinder_setting_add_page_menu() {
          $predata = get_option('tmpl_spotfinder_predata_map');
          if ($predata != 'save') {
                    /* auto populate the options */
                    $templatic_settings = get_option('templatic_settings');
                    $tmpdata['default_page_view'] = 'gridview';
                    $tmpdata['pippoint_effects'] = 'hover';
                    $tmpdata['direction_map'] = 'yes';
                    $templatic_settings = array_merge($templatic_settings, $tmpdata);
                    if ($templatic_settings['direction_map'] != 'yes') {
                              update_option('templatic_settings', array_merge($templatic_settings, $tmpdata));
                    }
                    $googlemap_setting = get_option('city_googlemap_setting');
                    $gmap_data['direction_map'] = 'yes';
                    if (!empty($googlemap_setting))
                              $googlemap_setting = array_merge($googlemap_setting, $gmap_data);
                    else
                              $googlemap_setting = $gmap_data;

                    update_option('city_googlemap_setting', $googlemap_setting);

                    update_option('tmpl_spotfinder_map_setting', 'yes');

                    update_option('tmpl_spotfinder_predata_map', 'save');
          }

          /* to display direction map on detail page, this option should set always as we are not providing then the option to disable/enable the map on detail page in backend settins */
          $templatic_settings = get_option('templatic_settings');
          $tmpdata['direction_map'] = 'yes';
          if ($templatic_settings['direction_map'] != 'yes') {
                    update_option('templatic_settings', array_merge($templatic_settings, $tmpdata));
          }
}

/* Add login register link in secondary navigation */

function tmpl_filter_ctheme_nav_bars($items, $args) {
          global $current_user;

          if (function_exists('get_tevolution_login_permalink'))
                    $login_url = get_tevolution_login_permalink();

          if (function_exists('get_tevolution_register_permalink'))
                    $register_url = get_tevolution_register_permalink();

          $theme_locations = apply_filters('tmpl_logreg_links', array('secondary'));

          /* Primary Menu location */
          /* Check the condition for theme menu location prompt, footer and secondory */
          if (in_array($args->theme_location, $theme_locations)) {
                    if ($current_user->ID) {
                              $loginlink = '<li class="tmpl-login' . ((is_home()) ? ' ' : '') . '"><a href="' . wp_logout_url(home_url()) . '">' . __('Log out', DOMAIN) . '</a></li>';
                    } else {
                              $loginlink = '<li class="tmpl-login' . (($_REQUEST['ptype'] == 'login') ? ' current_page_item' : '') . '" ><a data-reveal-id="tmpl_reg_login_container" href="javascript:void(0);" onClick="tmpl_login_frm();">' . __('Login', DOMAIN) . '</a></li>';
                    }
                    if ($current_user->ID) {
                              $reglink = '<li class="tmpl-login' . ((is_home()) ? ' ' : '') . '"><a href="' . get_author_posts_url($current_user->ID) . '">' . $current_user->display_name . '</a></li>';
                    } else {
                              $users_can_register = get_option('users_can_register');
                              if ($users_can_register) {
                                        $reglink = '<li class="tmpl-login' . (($_REQUEST['ptype'] == 'register') ? ' current_page_item' : '') . '"><a data-reveal-id="tmpl_reg_login_container" href="javascript:void(0);" onClick="tmpl_registretion_frm();">' . __('Register', DOMAIN) . '</a></li>';
                              }
                    }
                    $items = $items . $loginlink . $reglink;
          }
          return $items;
}

/* Add login register link in secondary navigation with megamenu */

function tmpl_filter_ctheme_nav_bars_megamenu() {
          global $current_user;

          $login_url = get_tevolution_login_permalink();

          $register_url = get_tevolution_register_permalink();

          $theme_locations = apply_filters('tmpl_logreg_links', array('secondary'));

          /* Primary Menu location */
          /* Check the condition for theme menu location prompt, footer and secondory */
          //if(in_array($args->theme_location,$theme_locations))
          {
                    if ($current_user->ID) {
                              $loginlink = '<li class="tmpl-login' . ((is_home()) ? ' ' : '') . '"><a href="' . wp_logout_url(home_url()) . '">' . __('Log out', DOMAIN) . '</a></li>';
                    } else {
                              $loginlink = '<li class="tmpl-login' . (($_REQUEST['ptype'] == 'login') ? ' current_page_item' : '') . '" ><a data-reveal-id="tmpl_reg_login_container" href="javascript:void(0);" onClick="tmpl_login_frm();">' . __('Login', DOMAIN) . '</a></li>';
                    }
                    if ($current_user->ID) {
                              $reglink = '<li class="tmpl-login' . ((is_home()) ? ' ' : '') . '"><a href="' . get_author_posts_url($current_user->ID) . '">' . $current_user->display_name . '</a></li>';
                    } else {
                              $users_can_register = get_option('users_can_register');
                              if ($users_can_register) {
                                        $reglink = '<li class="tmpl-login' . (($_REQUEST['ptype'] == 'register') ? ' current_page_item' : '') . '"><a data-reveal-id="tmpl_reg_login_container" href="javascript:void(0);" onClick="tmpl_registretion_frm();">' . __('Register', DOMAIN) . '</a></li>';
                              }
                    }
                    $items = "<ul class='reg_login_links'>" . $loginlink . $reglink . "</ul>";
          }
          echo $items;
}

/* remove admin site options */

function spotfinder_wp_admin() {
          /* Hide category page settings of tevolution general settings */
          remove_action('after_listing_page_setting', 'directory_listing_map_setting');
          /* Hide Detail page settings of tevolution general settings */
          remove_action('before_related_post', 'tmpl_detailpage_direction_map');
}

/* Register new widget areas */

/* new widget areas */
global $theme_sidebars;

$theme_sidebars = array(
          'below_theme_header' => array(
                    'name' => apply_filters('tmpl_home_page_bheader_title', __('Homepage - Below Slider', TDOMAIN)),
                    'description' => __("Display widgets below the home page slider widget on home page.", TDOMAIN),
          ),
          'above_homepage_content' => array(
                    'name' => apply_filters('tmpl_above_homepage_content_title', __('Homepage - Above Content', TDOMAIN)),
                    'description' => __("Display widgets above the home page content area.", TDOMAIN),
          ),
          'menu-right' => array(
                    'name' => apply_filters('tmpl_above_homepage_content_title', __('Navigation Right', TDOMAIN)),
                    'description' => __("Widgets placed inside this area will appear on the right side of your secondary navigation bar.", TDOMAIN),
          ),
          'home-page-above-footer' => array(
                    'name' => apply_filters('tmpl_above_homepage_footer', __('Homepage - Above footer', TDOMAIN)),
                    'description' => __("Display widget above the footer on home page.", TDOMAIN),
          ),
          'listings_left_content' => array(
                    'name' => apply_filters('tmpl_listings_left_content', __('All Pages - Left Content', TDOMAIN)),
                    'description' => __("Widgets placed inside this area will appear on the left side of all pages.", TDOMAIN),
          )
);

/* Manage images and content */

function spotfinder_init_function() {

		if(get_option('tmpl_added_default_image_sizes') != 1){
		
			add_image_size( 'thumbnail', 350, 233, true );
		
			if(get_option('medium_size_w')!=0)
				update_option('medium_size_w',0);
			if(get_option('medium_size_h')!=0)
				update_option('medium_size_h',0);
				
			if(get_option('large_size_w')!=0)
				update_option('large_size_w',0);
			if(get_option('large_size_h')!=0)
				update_option('large_size_h',0);
			
			update_option('tmpl_added_default_image_sizes',1);
		}	
		
          add_image_size('directory-single-image', 500, 320, true);
          add_image_size('event-single-image', 500, 320, true);


          add_image_size('directory-listing-image', 350, 233, true);
          add_image_size('event-listing-image', 350, 233, true);

		   if(is_plugin_active('Tevolution-RealEstate/realestate.php')){
			add_image_size('property_detail-thumb', 135, 135, true);
			 add_image_size('property_listings-thumb', 250, 165, true);
		  }

          update_option('thumbnail_size_w', 350);
          update_option('thumbnail_size_h', 233);
          set_post_thumbnail_size(350, 233, $crop);

          add_image_size('property_detail-thumb', 135, 135, true);


          add_image_size('thumbnail', 350, 233, true);
          add_image_size('directory-single-image', 500, 320, true);
          add_image_size('directory-single-thumb', 60, 60, true);

          add_image_size('directory-neighbourhood-thumb', 60, 60, true);
          add_filter('thumbnail_size_h', 233);

          add_image_size('tevolution_thumbnail', 60, 60, true);
          add_image_size('popular_post-thumbnail', 60, 60, true);

          add_image_size('event-listing-image', 350, 233, true);
          add_image_size('event-single-image', 500, 320, true);
          add_image_size('event-single-thumb', 60, 60, true);

          add_image_size('event-neighbourhood-thumb', 60, 60, true);
          add_image_size('directory-single-thumb', 60, 60, true);
          add_image_size('popular_post-thumbnail', 60, 60, true);
          add_image_size('event-single-thumb', 60, 60, true);
          add_image_size('tevolution_thumbnail', 60, 60, true);

          remove_filter('the_content', 'view_sharing_buttons');
          remove_filter('the_content', 'view_count');
          remove_action('tmpl_before_comments', 'single_post_categories_tags');
}

/* add the js and css */

function spotfinder_script_style() {

          if (function_exists('tevolution_get_post_type'))
                    $custom_post_type = tevolution_get_post_type();

          if ((is_archive() && !is_author() && in_array(get_post_type(), $custom_post_type) && get_post_type() != 'event' ) || is_search()) {
                    wp_enqueue_script('directory-cookies-script', get_stylesheet_directory_uri() . '/js/jquery_cokies.js', array('jquery'), '', false);
          }

          if ((is_single() || is_singular()) && (in_array(get_post_type(), $custom_post_type) && get_post_type() != 'event' )) {
                    wp_enqueue_script('jquery-ui-tabs');
                    ?>
                    <script type="text/javascript">
                              jQuery(function () {
                                   jQuery('#image_gallery a').lightBox();
                              });

                              jQuery('.tabs').bind('tabsshow', function (event, ui) {
                                   if (ui.panel.id == "listing_map") {
                                        Demo.init();
                                   }
                              });
                              jQuery(function () {
                                   var n = jQuery("ul.tabs li a, .tmpl-accordion dd a").attr("href");
                                   if (n == "#listing_map") {
                                        Demo.init();
                                   }
                              })
                              jQuery(function () {
                                   jQuery("ul.tabs li a, .tmpl-accordion dd a").live('click', function () {
                                        var n = jQuery(this).attr("href");
                                        if (n == "#listing_map") {
                                             Demo.init();
                                        }
                                   })
                              });
                              jQuery(function () {
                                   jQuery('#tabs').tabs({
                                        activate: function (event, ui) {
                                             //console.log(event);
                                             var panel = jQuery(".ui-state-active a").attr("href");
                                             if (panel == '#listing_map') {
                                                  Demo.init();
                                             }
                                        }
                                   });
                              });
                    </script>
                    <?php
          }
}

/* ======================================================================== Home page ======================================================================== */

/* Pass the city header image and color in to home page banner widget */
add_action('after_body', 'tmpl_header_city_image', 11);

function tmpl_header_city_image() {
          global $wpdb, $country_table, $zones_table, $multicity_table, $current_cityinfo, $wp_query;
          $supreme_theme_settings = get_option('directory_theme_settings');
          $header_image = $supreme_theme_settings ['header_image_url'];
          if (($current_cityinfo['color'] && $current_cityinfo['color'] != '#') || $current_cityinfo['images']):
                    ?>
                    <style type='text/css'>body{ <?php if ($current_cityinfo['color']): ?> background-color:<?php echo $current_cityinfo['color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['images']): ?> background-image:url('<?php echo $current_cityinfo['images']; ?>'); <?php endif; ?> }
                         div#header, header#header{ background:none; !important; }
                         .directory-front-page .home_page_banner{ <?php if ($current_cityinfo['header_color']): ?> background-color:<?php echo $current_cityinfo['header_color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['header_image']): ?>background-image:url('<?php echo $current_cityinfo['header_image']; ?>'); <?php endif; ?> <?php if ($current_cityinfo['header_color'] == '' && $current_cityinfo['header_image'] == ''): ?>background-image:url('<?php echo get_stylesheet_directory_uri() . "/images/home-banner-bg.jpg"; ?>'); <?php endif; ?> }</style>
               <?php elseif ($current_cityinfo['header_image']):
                         ?>
                    <style type='text/css'>body{ <?php if ($current_cityinfo['color']): ?> background-color:<?php echo $current_cityinfo['color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['images']): ?> background-image:url('<?php echo $current_cityinfo['images']; ?>'); <?php endif; ?> }
                         div#header, header#header{ background:none; !important; }
                         .directory-front-page .home_page_banner{ <?php if ($current_cityinfo['header_color']): ?> background-color:<?php echo $current_cityinfo['header_color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['header_image']): ?>background-image:url('<?php echo $current_cityinfo['header_image']; ?>'); <?php endif; ?> <?php if ($current_cityinfo['header_color'] == '' && $current_cityinfo['header_image'] == ''): ?>background-image:url('<?php echo get_stylesheet_directory_uri() . "/images/home-banner-bg.jpg"; ?>'); <?php endif; ?> } </style>
               <?php elseif ($header_image && $current_cityinfo['header_image'] == ''):
                         ?>
                    <style type='text/css'>body{ <?php if ($current_cityinfo['color']): ?> background-color:<?php echo $current_cityinfo['color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['images']): ?> background-image:url('<?php echo $current_cityinfo['images']; ?>'); <?php endif; ?> }
                         div#header, header#header{ background:none; !important;}
                         .directory-front-page .home_page_banner{ background-image:url('<?php echo $header_image; ?>'); }</style>
               <?php else: ?>
                    <style type='text/css'>body{ <?php if ($current_cityinfo['color']): ?> background-color:<?php echo $current_cityinfo['color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['images']): ?> background-image:url('<?php echo $current_cityinfo['images']; ?>'); <?php endif; ?> }
                         div#header, header#header{ background:none; !important; }
                         <?php if ($current_cityinfo['header_color'] && $current_cityinfo['color'] != ''): ?>
                                   .directory-front-page .home_page_banner{ background: url("") no-repeat scroll left top / 100% 100% <?php echo $current_cityinfo['header_color']; ?>; }
                         <?php else: ?>
                                   .directory-front-page .home_page_banner{ <?php if ($current_cityinfo['header_color']): ?> background-color:<?php echo $current_cityinfo['header_color']; ?>; <?php endif; ?> <?php if ($current_cityinfo['header_image']): ?>background-image:url('<?php echo $current_cityinfo['header_image']; ?>'); <?php endif; ?> <?php if ($current_cityinfo['header_color'] == '' && $current_cityinfo['header_image'] == ''): ?>background-image:url('<?php echo get_stylesheet_directory_uri() . "/images/home-banner-bg.jpg"; ?>'); <?php endif; ?> }
                         <?php endif; ?>
                    </style>
          <?php
          endif;
}

/* ======================================================================== Category page ======================================================================== */

/* return left content sidebar in all pages */
add_action('tmpl_all_pages_left_content', 'tmpl_return_all_pages_left_content');

function tmpl_return_all_pages_left_content() {
          if (is_active_sidebar('listings_left_content')) :
                    ?>
                    <div class="map-sidebar">
                         <?php dynamic_sidebar('listings_left_content'); ?>
                    </div>
                    <?php
          endif;
}

/* function will return the fields which we shows by default on detail page.
  we create the separate function because we needs want the variables name without heading type */

if (!function_exists('tmpl_single_page_default_custom_field')) {

          function tmpl_single_page_default_custom_field($post_type) {
                    $custom_post_type = tevolution_get_post_type();

                    /* check its detail page or preview page */
                    if ((is_single() || $_GET['page'] == 'preview') && $post_type != '') {
                              global $wpdb, $post, $tmpl_flds_varname, $pos_title;

                              $cus_post_type = $post_type;
                              $heading_type = tmpl_fetch_heading_post_type($post_type);
                              $tmpl_flds_varname = array();
                              global $wpdb, $post, $posttitle;
                              $cur_lang_code = (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) ? ICL_LANGUAGE_CODE : '';

                              remove_all_actions('posts_where');
                              $post_query = null;
                              remove_action('pre_get_posts', 'event_manager_pre_get_posts');
                              remove_action('pre_get_posts', 'directory_pre_get_posts', 12);
                              add_filter('posts_join', 'custom_field_posts_where_filter');


                              $args = array('post_type' => 'custom_fields',
                                        'posts_per_page' => -1,
                                        'post_status' => array('publish'),
                                        'meta_query' => array('relation' => 'AND',
                                                  array(
                                                            'key' => 'post_type_' . $post_type . '',
                                                            'value' => $post_type,
                                                            'compare' => '=',
                                                            'type' => 'text'
                                                  ),
                                                  array(
                                                            'key' => 'is_active',
                                                            'value' => '1',
                                                            'compare' => '='
                                                  ),
                                                  array(
                                                            'key' => 'show_on_detail',
                                                            'value' => '1',
                                                            'compare' => '='
                                                  )
                                        ),
                                        'meta_key' => 'sort_order',
                                        'orderby' => 'meta_value',
                                        'order' => 'ASC'
                              );

                              /* save the data on transient to get the fast results */
                              $post_query = get_transient('_tevolution_query_single' . trim($post_type) . trim($heading_key) . $cur_lang_code);
                              if (false === $post_query && get_option('tevolution_cache_disable') == 1) {
                                        $post_query = new WP_Query($args);
                                        set_transient('_tevolution_query_single' . trim($post_type) . trim($heading_key) . $cur_lang_code, $post_query, 12 * HOUR_IN_SECONDS);
                              } elseif (get_option('tevolution_cache_disable') == '') {
                                        $post_query = new WP_Query($args);
                              }



                              /* Join to make the custom fields WPML compatible */
                              remove_filter('posts_join', 'custom_field_posts_where_filter');

                              $tmpl_flds_varname = '';
                              if ($post_query->have_posts()) {
                                        while ($post_query->have_posts()) : $post_query->the_post();
                                                  $ctype = get_post_meta($post->ID, 'ctype', true);
                                                  $post_name = get_post_meta($post->ID, 'htmlvar_name', true);
                                                  $style_class = get_post_meta($post->ID, 'style_class', true);
                                                  $option_title = get_post_meta($post->ID, 'option_title', true);
                                                  $option_values = get_post_meta($post->ID, 'option_values', true);
                                                  $default_value = get_post_meta($post->ID, 'default_value', true);
                                                  $tmpl_flds_varname[$post_name] = array('type' => $ctype,
                                                            'label' => $post->post_title,
                                                            'style_class' => $style_class,
                                                            'option_title' => $option_title,
                                                            'option_values' => $option_values,
                                                            'default' => $default_value,
                                                  );
                                        endwhile;
                                        wp_reset_query();
                              }
                              return $tmpl_flds_varname;
                    }
          }

}

/* add reviews and link on images in category page and archive page */

function dtheme_after_taxonomies_content() {
          global $post, $htmlvar_name, $templatic_settings;
          $is_archive = get_query_var('is_ajax_archive');
          $is_related = get_query_var('is_related');
          $custom_post_type = apply_filters('directory_post_type_template', tevolution_get_post_type());
          //if((is_archive() || $is_archive == 1) && in_array(get_post_type(),$custom_post_type)  && get_post_type()!='event'){
          if (in_array(get_post_type(), $custom_post_type)) {
                    echo '<div class="rev_pin">';
                    echo '<ul>';
                    $post_id = get_the_ID();

                    $comment_count = count(get_comments(array('post_id' => $post_id, 'status' => 'approve')));
                    $review = ($comment_count <= 1 ) ? __('review', TDOMAIN) : __('reviews', TDOMAIN);
                    $review = apply_filters('tev_review_text', $review);

                    if (current_theme_supports('tevolution_my_favourites')):
                              ?> 
                              <li><?php tevolution_favourite_html(); ?></li>

                              <?php
                    endif;

                    if (get_option('default_comment_status') == 'open' || $post->comment_status == 'open') {
                              ?>               
                              <li class="review"> <?php echo '<a href="' . get_permalink($post_id) . '#comments">' . $comment_count . ' ' . $review . '</a>'; ?></li>
                              <?php
                    }

                    echo '</ul>';
                    echo '</div>';
          }
}

/* function will return back button link */
add_action('wp_footer', 'tmpl_add_sf_script');

function tmpl_back_link() {
          ?>
          <a  id="tmpl-back-link" style="display:none;" href="javascript:void(0);" onclick="window.history.back();" class="page-back-link"><i class="sf-icon">8</i> <?php _e('Back', TDOMAIN); ?></a>
          <?php
}

/* Script to check is back button history is exists or not */

function tmpl_add_sf_script() {
          ?>
          <script type="text/javascript">
                    if (history.length > 1) {
                         jQuery("#tmpl-back-link").show();
                    }
          </script>
          <?php
}

/* add pinpoint and star rating on category page */

function spotfinder_listing_after_title() {
          global $post, $htmlvar_name, $posttitle, $wp_query;

          $is_archive = get_query_var('is_ajax_archive');
          if ((is_archive() || $is_archive == 1) || is_tax() || is_search()) {


                    $post_id = get_the_ID();
                    $tmpdata = get_option('templatic_settings');
                    if ($tmpdata['templatin_rating'] == 'yes' && get_post_average_rating($post_id) != ''):
                              ?>
                              <div class="listing_rating">
                                   <div class="directory_rating_row"><span class="single_rating"> <?php echo draw_rating_star_plugin(get_post_average_rating($post_id)); ?> </span></div>
                              </div>
                    <?php elseif (is_plugin_active('Templatic-MultiRating/multiple_rating.php') && function_exists('get_single_average_rating_image') && get_single_average_rating_image($post_id) != ''): ?>
                              <div class="listing_rating">
                                   <div class="directory_rating_row"><span class="single_rating"> <?php echo get_single_average_rating_image($post_id); ?> </span></div>
                              </div>	
                              <?php
                    endif;
                    $googlemap_setting = get_option('city_googlemap_setting');
                    /* Show pinpoint icon */
                    if (!is_author() && !$is_related && !is_front_page()):
                              ?> 
                              <p class='pinpoint'><a id="pinpoint_<?php echo $post_id; ?>" class="ping" href="#map_canvas"><?php _e('Pinpoint', TDOMAIN); ?></a></p>
                              <?php
                    endif;
          }
}

/* property category page */

/* Map on search page - when search for multiple post types */
remove_filter('tmpl_map_after_address_fields', 'tmpl_map_property_custom_fields', 10, 2);

/* Script for detail page - get direction Map
  With this script we add the class on div when click on get direction button - to add scroll bar
 */

add_action('wp_footer', 'tmpl_detail_page_js');

function tmpl_detail_page_js() {
          global $wp_query;
          if (is_single()) {
                    ?>
                    <script type="text/javascript">

                              jQuery(".b_getdirection").click(function () {
                                   jQuery(".map-sidebar > div").addClass('directions-results');
                              });
                              jQuery(".google-map-directory #from-input").on('keyup', function (e) {
                                   if (e.keyCode == 13)
                                   {
                                        jQuery(".map-sidebar > div").addClass('directions-results');
                                   }
                              });
                    </script>

                    <?php
          }
}

/* ======================================================================== Manage Widgets and widget areas  ======================================================================== */

/* un register the detail page and category page sidebars */

function spotfinder_remove_sidebar() {

          /* un register the category page and detail page sidebar */
          $args = get_option('templatic_custom_taxonomy');
          $args1 = get_option('templatic_custom_post');
          $exclude_array = array('event', 'listing', 'property');
          if ($args):
                    foreach ($args as $key => $_args) {
                              if ((in_array($_args['post_type'], $exclude_array) || file_exists(get_stylesheet_directory() . "/taxonomy-" . $_args["labels"]["singular_name"] . ".php")) && $_args['post_type'] != 'classified') {
                                        unregister_sidebar('after_' . $_args["labels"]["singular_name"] . '_header');
                                        /* Listing page Sidebar bar */
                                        $_name = @$args1[$_args["post_slug"]]['labels']['name'];
                                        unregister_sidebar($_args["labels"]["singular_name"] . '_listing_sidebar');

                                        register_sidebars(1, array('id' => '' . $_args["labels"]["singular_name"] . '_listing_above_content', 'name' => apply_filters('listing_page_sidebar_title', sprintf(__('%s Category - Above Content', TDOMAIN), ucfirst($_name)), $_name), 'description' => sprintf(__('Display widgets on %s category pages above content.', TDOMAIN), $_name), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>'));
                                        /* Single post Type Sidebar bar  */
                                        unregister_sidebar($_args["post_slug"] . '_detail_sidebar');
                              }
                              /* Add sidebar for listing page below header */
                    }
          endif;

          $args = get_option('templatic_custom_tags');
          $args1 = get_option('templatic_custom_post');
          if ($args):
                    foreach ($args as $key => $_args) {
                              $_name = @$args1[$_args["post_slug"]]['labels']['name'];
                              if ((in_array($_args['post_type'], $exclude_array) || file_exists(get_stylesheet_directory() . "/taxonomy-" . $_args["labels"]["singular_name"] . ".php")) && $_args['post_type'] != 'classified') {
                                        /* Listing page Sider bar */

                                        unregister_sidebar('' . $_args["labels"]["singular_name"] . '_tag_listing_sidebar');

                                        /* category page above content */
                                        register_sidebars(1, array('id' => '' . $_args["labels"]["singular_name"] . '_listing_above_content', 'name' => apply_filters('listing_page_sidebar_title', sprintf(__('%s Tags - Above Content', TDOMAIN), ucfirst($_name)), $_name), 'description' => sprintf(__('Display widgets on %s Tags pages above content.', TDOMAIN), $_name), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>'));
                              }
                    }
          endif;

          unregister_sidebar('after_event_header');
}

/* Change search template for search page template */
add_filter("single_template", "directory_get_single_template", 13);
/*
 * Search Page template for only tevolution custom post type
 *
 */
add_filter("search_template", 'tevolution_theme_get_search_template', 9);

function tevolution_theme_get_search_template($search_template) {
          global $wpdb, $wp_query, $post;

          if (is_array($_REQUEST['post_type']) && count($_REQUEST['post_type']) == 1) {
                    $post_type = $_REQUEST['post_type'][0];
          } elseif (!is_array($_REQUEST['post_type'])) {
                    $post_type = $_REQUEST['post_type'];
          } else {
                    $post_type = get_query_var('post_type');
          }

          if (count($post_type) == 1) {
                    //fetch the tevolution post type	
                    $custom_post_type = apply_filters('directory_post_type_template', tevolution_get_post_type());

                    if (file_exists(get_stylesheet_directory() . '/' . $post_type . '-search.php')) {

                              $search_template = get_stylesheet_directory() . '/' . $post_type . '-search.php';
                    } else if (file_exists(get_template_directory() . '/' . $post_type . '-search.php')) {

                              $search_template = get_template_directory() . '/' . $post_type . '-search.php';
                    } else {
                              $search_template = TEVOLUTION_DIRECTORY_DIR . 'templates/' . $post_type . '-search.php';
                    }
          }
          return $search_template;
}

/* above footer widget - we want different footers here */
if (!function_exists('tmpl_above_footer_theme_sidebar')) {

          function tmpl_above_footer_theme_sidebar() {

                    if (is_active_sidebar('home-page-above-footer')) :
                              do_action('before_footer'); // supreme_before_sidebar_primary 
                              dynamic_sidebar('home-page-above-footer');
                              do_action('after_footer'); // supreme_after_sidebar_primary 
                    endif;
          }

}

/*
 * Function Name: spotfinder_register_customizer_settings
 * Return: add image upload for header and footer image in customizer.
 */

function spotfinder_register_customizer_settings($wp_customize) {
          $wp_customize->get_control('color_picker_color1')->label = 'Widget Background / White Color';
          $wp_customize->get_control('color_picker_color2')->label = 'Primary Color / Pink Color';
          $wp_customize->get_control('color_picker_color3')->label = 'Secondary Color / Body Text Color';
          $wp_customize->get_control('color_picker_color4')->label = 'Sub Text Color / Grey Color 1';
          $wp_customize->get_control('color_picker_color5')->label = 'Sub Text Color / Grey Color 2';
          $wp_customize->get_control('color_picker_color6')->label = 'Body Background Color / Light Grey Color';
          $wp_customize->add_section('spotfinder_header_image_settings', array(
                    'title' => 'Header Image',
                    'priority' => 8
          ));
          $wp_customize->remove_section('background_image');
          $wp_customize->add_setting(supreme_prefix() . '_theme_settings[header_image_url]', array(
                    'default' => '',
                    'type' => 'option',
                    'capabilities' => 'edit_theme_options',
                    'sanitize_callback' => "spotfinder_customize_header_image_url",
                    'sanitize_js_callback' => "spotfinder_customize_header_image_url",
                    //'transport' => 'postMessage',
          ));
          $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, supreme_prefix() . '_theme_settings[header_image_url]', array(
                    'label' => __(' Upload image for header background', TDOMAIN),
                    'section' => 'spotfinder_header_image_settings',
                    'settings' => supreme_prefix() . '_theme_settings[header_image_url]',
          )));

          function spotfinder_customize_header_image_url($setting, $object) {

                    /* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
                    if (supreme_prefix() . "_theme_settings[header_image_url]" == $object->id && !current_user_can('unfiltered_html'))
                              $setting = stripslashes(wp_filter_post_kses(addslashes($setting)));
                    /* Return the sanitized setting and apply filters. */
                    return apply_filters("spotfinder_customize_header_image_url", $setting, $object);
          }

          $wp_customize->add_setting(supreme_prefix() . '_theme_settings[footer_image_url]', array(
                    'default' => '',
                    'type' => 'option',
                    'capabilities' => 'edit_theme_options',
                    'sanitize_callback' => "spotfinder_customize_footer_image_url",
                    'sanitize_js_callback' => "spotfinder_customize_footer_image_url",
                    //'transport' => 'postMessage',
          ));
          $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, supreme_prefix() . '_theme_settings[footer_image_url]', array(
                    'label' => __(' Upload image for footer background', TDOMAIN),
                    'section' => 'spotfinder_footer_image_settings',
                    'settings' => supreme_prefix() . '_theme_settings[footer_image_url]',
          )));

          function spotfinder_customize_footer_image_url($setting, $object) {

                    /* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
                    if (supreme_prefix() . "_theme_settings[footer_image_url]" == $object->id && !current_user_can('unfiltered_html'))
                              $setting = stripslashes(wp_filter_post_kses(addslashes($setting)));
                    /* Return the sanitized setting and apply filters. */
                    return apply_filters("spotfinder_customize_footer_image_url", $setting, $object);
          }

}

/*
 * add submenu for auto update theme
 */
add_action('admin_menu', 'spotfinder_templatic_menu', 20);
if (!function_exists('spotfinder_templatic_menu')) {

          function spotfinder_templatic_menu() {
                    if (is_tevolution_active()) {

                              add_submenu_page('templatic_system_menu', __('Child Theme Update', TDOMAIN), __('Child Theme Update', TDOMAIN), 'administrator', 'child_tmpl_theme_update', 'child_tmpl_theme_update', 27);
                    } else {

                              add_submenu_page('templatic_menu', __('Child Theme Update', TDOMAIN), __('Child Theme Update', TDOMAIN), 'administrator', 'child_tmpl_theme_update', 'child_tmpl_theme_update', 27);
                    }
          }

}
/*
 * include the auto update login file.
 */
if (!function_exists('child_tmpl_theme_update')) {

          function child_tmpl_theme_update() {
                    require_once(get_stylesheet_directory() . "/templatic_login.php");
          }

}

/* Hooks to add the divs in list filters widget */
add_action('tmpl_start_filters_3', 'tmpl_start_filters_return');
add_action('tmpl_last_filters_end', 'tmpl_last_filters_end_return');

/* Start Div Of More filters */

function tmpl_start_filters_return() {
          ?>
          <script type="text/javascript">
                    function tmpl_more_fld_div() {
                         if (document.getElementById('id-more-filters').style.display == 'none') {
                              document.getElementById('id-more-filters').style.display = 'block';
                         } else {
                              document.getElementById('id-more-filters').style.display = 'none';
                         }
                    }
          </script>
          <p class="more_filters_btn"><a href="javascript:void(0);" onClick="tmpl_more_fld_div();"><?php _e('More Filters', TDOMAIN); ?></a></p>
          <div id="id-more-filters" class="cls-more-filters" style="display:none;">
               <?php
     }

     /* End of filters more div */

     function tmpl_last_filters_end() {
               ?>
          </div>
          <?php
}

/* * ************ Detail page related listings ******************* */
/* get related listings */
remove_action('tmpl_related_listings', 'tmpl_get_dir_related_listings');
add_action('tmpl_related_listings', 'tmpl_get_related_listings');
if (!function_exists('tmpl_get_related_listings')) {

          function tmpl_get_related_listings() {

                    global $post, $htmlvar_name, $wpdb, $wp_query;
                    /* get all the custom fields which select as " Show field on listing page" from back end */

                    if (function_exists('tmpl_get_category_list_customfields')) {
                              $htmlvar_name = tmpl_get_category_list_customfields(CUSTOM_POST_TYPE_LISTING);
                    } else {
                              global $htmlvar_name;
                    }
                    $wp_query->set('is_related', 1);
                    $related_posts = tmpl_get_related_posts_query();
                    if (!empty($related_posts->posts)) {

                              echo "<h2>";
                              _e('Related Listings', TDOMAIN);
                              echo "</h2>";
                              echo "<div id='loop_listing_taxonomy' class='grid'>";
                              while ($related_posts->have_posts()) {
                                        global $post;
                                        $related_posts->the_post();

                                        /* remove ratings from below title */
                                        remove_action('templ_post_title', 'tevolution_listing_after_title', 12);
                                        /* remove add to favourite from below title */
                                        remove_action('templ_post_title', 'tevolution_favourite_html', 11);
                                        ?>

                                        <div class="post <?php templ_post_class(); ?>" >
                                             <?php
                                             /* Hook to display before image */
                                             do_action('tmpl_before_category_page_image');

                                             /* Hook to Display Listing Image  */
                                             do_action('directory_category_page_image');

                                             /* Hook to Display After Image  */
                                             do_action('tmpl_after_category_page_image');

                                             /* Before Entry Div  */
                                             do_action('directory_before_post_entry');
                                             ?> 

                                             <!-- Entry Start -->
                                             <div class="entry"> 

                                                  <div class="listing-wrapper">
                                                       <!-- Entry title start -->
                                                       <div class="entry-title">

                                                            <?php do_action('templ_post_title');                /* do action for display the single post title */ ?>

                                                       </div>

                                                     
                                                       <!-- Entry title end -->

                                                       <!-- Entry details start -->
                                                       <div class="entry-details">

                                                            <?php
                                                            /* Hook to get Entry details - Like address,phone number or any static field  */
                                                            do_action('listing_post_info');
                                                            ?>     

                                                       </div>
                                                       <!-- Entry details end -->
                                                  </div>
                                                  <!--Start Post Content -->
                                                  <?php
                                              
                                                  /* Hook to display post content . */
                                                  do_action('templ_taxonomy_content');

                                                  ?>
                                                  <!-- End Post Content -->
                                                  <?php
                                                  /* Hook for before listing categories     */
                                                  do_action('directory_before_taxonomies');

                                                  /* Display listing categories     */
                                                  do_action('templ_the_taxonomies');

                                                  /* Hook to display the listing comments, add to favorite and pinpoint   */
                                                  do_action('directory_after_taxonomies');
                                                  ?>
                                             </div>
                                             <!-- Entry End -->
                                             <?php do_action('directory_after_post_entry'); ?>
                                        </div>
                                        <?php
                              }
                              echo "</div>";
                              wp_reset_query();
                    } else {
                              _e('No related Listings available', TDOMAIN);
                    }
          }

}
/* * *** Author page ***************** */

/* Apply filter for header fields */

add_action('init', 'tmpl_add_classes');

function tmpl_add_classes() {
          add_filter('body_class', 'tpml_spot_finder_classes');
}

/*
 *  adds a class for theme to body tag
 * 
 */

function tpml_spot_finder_classes($classes) {
          global $wp_query, $post;
          wp_reset_query();
          if (is_tax() || is_archive() || is_single() || is_tag()) {
                    $post_type = get_post_type();
                    if ($post_type == '') {
                              $post_type = $post->post_type;
                    }

                    $exclude_array = apply_filters('spf_taxcategory_posttypes', array('event', 'listing', 'property'));
                    $template = get_stylesheet_directory() . "/single-" . $post_type . ".php";
                    if ((!in_array($post_type, $exclude_array) && $post_type != '') && !file_exists($template)) {
                              //$classes[] = 'custom-post-body';
                    }
          }
          /* add the class in all listings pages where we want map with listing */
          $post_type = get_post_type();
          $exclude_array1 = array('product');


          if ((is_tax() || is_tag || is_search()) && !is_single() && !is_category() && !is_page() && !is_author() && !in_array($post_type, $exclude_array1) && !empty($exclude_array) && in_array($post_type, $exclude_array) && !isset($_REQUEST['page']) && !isset($_REQUEST['pmethod']) && $wp_query->is_posts_page != 1) {
                    $classes[] = 'full-width-listings_map';
          }

          return $classes;
}

/* Add action get_template_part for listing template part */

/* removal of widgets on admin dashboard for non admins */
if (!current_user_can('manage_options')) {
          add_action('wp_dashboard_setup', 'remove_dashboard_widgets_from_subscribers', 99);
}

function remove_dashboard_widgets_from_subscribers() {

          global $wp_meta_boxes;
          unset($wp_meta_boxes['dashboard']['normal']['high']['templatic_dashboard_news_widget']); /* removal of news widget */
          unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
          unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
}

/* change default map icon on page */

add_filter('tmpl_default_map_icon', 'tmpl_default_map_icon_sp');

function tmpl_default_map_icon_sp() {
          $term_icon = get_stylesheet_directory_uri() . "/images/pin.png";
          return $term_icon;
}

add_filter('tmpl_searcg_button_val', 'tmpl_searcg_button_val_return');

function tmpl_searcg_button_val_return() {
          return "U";
}

/* Set search widget in spot finder theme */
if (get_option('directory_search_location_widget') != 'save_key_search_widget') {
          $sidebars_widgets = get_option('sidebars_widgets');
          $directory_search_location_widget = array();
          $directory_search_location_widget[1] = array(
                    "title" => '',
                    "post_type" => 'listing',
                    "show_address" => ''
          );
          $directory_search_location_widget['_multiwidget'] = '1';
          update_option('widget_directory_search_location', $directory_search_location_widget);
          $directory_search_location_widget = get_option('widget_directory_search_location');
          krsort($directory_search_location_widget);
          foreach ($directory_search_location_widget as $key1 => $val1) {
                    $directory_search_location_key = $key1;
                    if (is_int($directory_search_location_key)) {
                              break;
                    }
          }
          $sidebars_widgets["header"] = array_merge($sidebars_widgets["header"], array("directory_search_location-{$directory_search_location_key}"));


          $category_map = array();
          $category_map[1] = array("height" => '500');
          $category_map['_multiwidget'] = '1';
          update_option('widget_category_googlemap', $category_map);
          $category_map = get_option('widget_category_googlemap');
          krsort($category_map);
          foreach ($category_map as $key1 => $val1) {
                    $category_map_key1 = $key1;
                    if (is_int($category_map_key1)) {
                              break;
                    }
          }
          $sidebars_widgets["listings_left_content"] = array("category_googlemap-{$category_map_key1}");
          update_option('sidebars_widgets', $sidebars_widgets);  //save widget informations 
          update_option('directory_search_location_widget', 'save_key_search_widget');
}

add_filter('tmpl_banner_widget_description', 'tmpl_banner_widget_description_');

function tmpl_banner_widget_description_() {
          return __('Display custom images which can each be linked to an internal or external URL', ADMINDOMAIN);
}

add_filter('tmpl_detail_slider_options', 'tmpl_spotfinder_slider_thumb');
if (!function_exists('tmpl_spotfinder_slider_thumb')) {

          function tmpl_spotfinder_slider_thumb() {
                    $detail_page_slider = array('animation' => 'slide', 'slideshow' => 'false', 'direction' => 'horizontal', 'slideshowSpeed' => 7000, 'animationLoop' => 'true', 'startAt' => 0, 'smoothHeight' => 'true', 'easing' => "swing", 'pauseOnHover' => 'true', 'video' => 'true', 'controlNav' => 'true', 'directionNav' => 'true', 'prevText' => '', 'nextText' => '', 'animationLoop' => 'true', 'itemWidth' => '61', 'itemMargin' => '10');
                    return $detail_page_slider;
          }

}
/* templates for addition post type */
add_filter('template_include', 'tmpl_theme_default_templates');

function tmpl_theme_default_templates($template) {

          if (function_exists('tmpl_addon_name'))
                    $addons_posttype = tmpl_addon_name(); /* all tevolution addons' post type as key and folter name as a value */
          $current_post_type = get_post_type(); /* get current post type */

          $taxonomies = get_object_taxonomies((object) array('post_type' => $current_post_type, 'public' => true, '_builtin' => true));

          /* called a default template for additional post type */
          if (function_exists('tmpl_wp_is_mobile') && !tmpl_wp_is_mobile() && !empty($current_post_type) && !array_key_exists($current_post_type, $addons_posttype) && (!in_array($current_post_type, array('post', 'product', 'attachment')))) {
                    /* template for detail page */
                    if (is_single() && get_post_type() != 'post' && !file_exists(dirname(__FILE__) . '/single-' . $current_post_type . '.php')) {
                              if (file_exists(dirname(__FILE__) . '/single-listing.php'))
                                        $template = dirname(__FILE__) . '/single-listing.php';
                    }

                    /* template for category/archive/tags page */
                    if ((is_category() || is_tax()) && !file_exists(dirname(__FILE__) . '/taxonomy-' . $taxonomies[0] . '.php') && !empty($current_post_type) && $current_post_type != 'post') {
                              if (file_exists(dirname(__FILE__) . '/taxonomy-listingcategory.php'))
                                        $template = dirname(__FILE__) . '/taxonomy-listingcategory.php';
                    }elseif ((is_post_type_archive() && !file_exists(dirname(__FILE__) . '/archive-' . $taxonomies[0] . '.php')) && !empty($current_post_type) && $current_post_type != 'post') {
                              if (file_exists(dirname(__FILE__) . '/archive-listing.php'))
                                        $template = dirname(__FILE__) . '/archive-listing.php';
                    }

                    return $template;
          }else {

                    return $template;
          }
}

$mapdata = get_option('tmpl_spotfinder_mapcustom');
if (isset($mapdata) && $mapdata != 'yes') {
          update_option('google_map_customizer', '');
          update_option('tmpl_spotfinder_mapcustom', 'yes');
}
?>