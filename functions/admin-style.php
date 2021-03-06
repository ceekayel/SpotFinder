<?php 
/*
    File contain the code for color options in customizer 
*/

ob_start();
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	//require($file . "/wp-load.php");
	global $wpdb;
	if(function_exists('supreme_get_setting')){
		$color1 = supreme_get_setting( 'color_picker_color1' );
		$color2 = supreme_get_setting( 'color_picker_color2' );
		$color3 = supreme_get_setting( 'color_picker_color3' );
		$color4 = supreme_get_setting( 'color_picker_color4' );
		$color4 = supreme_get_setting( 'color_picker_color5' );
		$color6 = supreme_get_setting( 'color_picker_color6' );
	}else{
		$supreme_theme_settings = get_option(supreme_prefix().'_theme_settings');
		if(isset($supreme_theme_settings[ 'color_picker_color1' ]) && $supreme_theme_settings[ 'color_picker_color1' ] !=''):
			$color1 = $supreme_theme_settings[ 'color_picker_color1' ];
		else:
			$color1 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color2' ]) && $supreme_theme_settings[ 'color_picker_color2' ] !=''):
			$color2 = $supreme_theme_settings[ 'color_picker_color2' ];
		else:
			$color2 = '';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color3' ]) && $supreme_theme_settings[ 'color_picker_color3' ] !=''):
			$color3 = $supreme_theme_settings[ 'color_picker_color3' ];
		else:
			$color3 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color4' ]) && $supreme_theme_settings[ 'color_picker_color4' ] !=''):
			$color4 = $supreme_theme_settings[ 'color_picker_color4' ];
		else:
			$color4 = '';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color5' ]) && $supreme_theme_settings[ 'color_picker_color5' ] !=''):
			$color5 = $supreme_theme_settings[ 'color_picker_color5' ];
		else:
			$color5 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color6' ]) && $supreme_theme_settings[ 'color_picker_color6' ] !=''):
			$color6 = $supreme_theme_settings[ 'color_picker_color6' ];
		else:
			$color6 ='';
		endif;
	}

//Background Color - White
if($color1 != "#" || $color1 != ""){?>
	

	.uploadfilebutton, button, input[type="button"], input[type="reset"], input[type="submit"],.published_box form input[type="button"],.btn-white,
	.uploadfilebutton:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover,.published_box form input[type="button"]:hover,.btn-white:hover,
	body .pos_navigation .post_left a,body .pos_navigation .post_right a,
	body .pos_navigation .post_left a:hover,body.singular .pos_navigation .post_right a:hover,
	.header_strip,.tab-bar,
	body .toggle_handler #directorytab,
	.nav_bg .widget-nav-menu ul ul, div#menu-secondary .menu ul ul, div#menu-secondary1 .menu ul ul, div#menu-subsidiary .menu ul ul,
	.tab-bar,
	body .mega-menu ul.mega li ul.sub-menu,
	.page-back-link,
	body .filters #propery-price-range .ui-slider-handle,body .filters #searchfilterform .ui-slider .ui-slider-handle,
	body.directory-single-page .hentry .entry-header-logo,
	#content .claim-post-wraper > ul > li > a,#content .claim-post-wraper ul li a.calendar_show,
	#content .claim-post-wraper > ul > li > a:hover,#content .claim-post-wraper ul li a.calendar_show:hover,
	body .share_link a,
	body #content .peoplelisting li .peopleinfo-wrap .links .profile a,
	body #content .peoplelisting li .peopleinfo-wrap .people_info,
	.author_cont .author_photo,
	#main .sidebar > .widget,
	body .directory_manager_tab #directory_sorting #directory_sortby,body .event_manager_tab #event_sorting #event_sortby,
	body .post .entry,
	body .comment-pagination .page-numbers,body .pagination .page-numbers,body .loop-nav span.next,body .loop-nav span.previous,
	.bbp-pagination .page-numbers:hover, .comment-pagination .page-numbers:hover, .pagination .page-numbers:hover,body .loop-nav span.next:hover,body .loop-nav span.previous:hover,
	.realated_post .related_post_grid_view li,
	.select-wrap span.select,
	body #main.home_page_wrapper .wrap > section.white-bg,
	.widget ul.community-grid li figure figcaption a,
	.widget .custom-content-widget-wrap .custom-content-widget i,
	body .upload_box,
	blockquote,
	body #content .claim-post-wraper ul li.claim_ownership p.claimed,
	.not-found,
	body .all_category_list_widget .category_list h3,
	body .all_category_list_widget .category_list ul li,
	body .social-media-share li a .count,
	.ui-tabs > div.ui-widget-content,.ui-tabs-nav ~ div,
	.tab-bar-section.middle {
		background:<?php echo $color1;?>;
	}

	body .event_manager_tab ul.view_mode li a, body .directory_manager_tab ul.view_mode li a,
	body .list .post.featured_c, body .list .hentry.featured_c,body .list .post.featured_post, body .list .hentry.featured_post,
	body .list .post, .list .hentry, body .user #content .hentry, body .user #content .author_cont div[id*="post"],
	body .social-media-share li a {
		background:<?php echo $color1;?> !important;
	}

	body .filters input[type='checkbox'] + label:before,
	body .loading_results:after,
	.hr_input_radio input[type='radio'] + label:before,
	body .package label,
	.d_location_type_navigation,
	body.mobile-view .right-medium > .templatic_text a.submit-small-button:hover {
		background-color:<?php echo $color1;?>;
	}

	.button,a.button,input.button,input[type="submit"].button,#footer .subscriber_container input[type="submit"],.home_page_banner .search_location .widget-wrap .search_nearby_widget #searchform input[type="submit"],.button-primary[type="submit"],#searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce a.button, body.woocommerce a.button.alt, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button,.uploadfilebutton, input[type="submit"],.published_box form input[type="submit"],
	.button:hover,a.button:hover,input.button:hover,input[type="submit"].button:hover,.button:active,a.button:active,input.button:active,input[type="submit"].button:active,#footer .subscriber_container input[type="submit"]:hover,#footer .subscriber_container input[type="submit"]:active,#content input.button:hover, #searchform input[type="submit"]:hover, .upload:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce #content input.button:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #respond input#submit:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover, body.woocommerce a.button.alt:hover, body.woocommerce a.button:hover, body.woocommerce button.button.alt:hover, body.woocommerce button.button:hover, body.woocommerce input.button.alt:hover, body.woocommerce input.button:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce-page #content input.button:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page a.button:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page button.button:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page input.button:hover, div.woocommerce form.track_order input.button:hover,.home_page_banner .search_location .widget-wrap .search_nearby_widget #searchform input[type="submit"]:hover,.button-primary[type="submit"]:hover,.uploadfilebutton:hover, input[type="button"]:hover, input[type="submit"]:hover,.published_box form input[type="submit"]:hover,
	.header_strip .submit-small-button,
	.page-title-header h1,.page-header .breadcrumb a,.page-header .breadcrumb span,
	body #content .peoplelisting li .peopleinfo-wrap .links .profile a:hover,
	body #content .peoplelisting li .peopleinfo-wrap .people_info .peoplelink span:before,
	.author_social_networks.social_media .social_media_list li a i,
	.rev_pin li a:before,
	body #content .peoplelisting li .peopleinfo-wrap .links .email a, body #content .peoplelisting li .links .phone{
      color: <?php echo $color1;?>;
    }


    .author_social_networks.social_media .social_media_list li a i,
    .hover-caption-image figure figcaption,
    body .author_social_networks.social_media .social_media_list li a i,
    body.tevolution-directory .ui-widget-header .ui-state-active a:link, body.tevolution-directory .ui-widget-header .ui-state-active a:visited, body.tevolution-event-manager .ui-widget-header .ui-state-active a, body.single-property #tabs ul.ui-tabs-nav li.ui-tabs-active a,body.singular-property #tabs ul.ui-tabs-nav li.ui-tabs-active a,
    body .filters #propery-price-range,body .filters #searchfilterform .ui-slider {
    	border-color:<?php echo $color1;?>;
	}

<?php }


//Primary color - Red
if($color2 != "#" || $color2 != ""){?>

	.button,a.button,input.button,input[type="submit"].button,#footer .subscriber_container input[type="submit"],.home_page_banner .search_location .widget-wrap .search_nearby_widget #searchform input[type="submit"],.button-primary[type="submit"],#searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce a.button, body.woocommerce a.button.alt, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button,.uploadfilebutton, input[type="submit"],.published_box form input[type="submit"],
	.left-off-canvas-menu,
	body .filters #propery-price-range .ui-slider-range,body .filters #searchfilterform .ui-slider .ui-slider-range,
	#silde_gallery .flex-direction-nav li a:hover,
	body .sort_order_alphabetical ul li a:hover, body .sort_order_alphabetical ul li.active a, body .sort_order_alphabetical ul li.nav-author-post-tab-active a,
	body .list .post .entry .date, body .list .tmpl_event_block .entry .date, body .user .hfeed .date,
	.widget .custom-content-widget-wrap .custom-content-widget:hover i,
	.full-width-map .togler_handler_wrap,
	body .supreme_wrapper div#loop_property_taxonomy .post .entry .property-title .property-price .prop-price, body .supreme_wrapper div#tmpl-search-results .post .entry .property-title .property-price .prop-price,.singular-property .supreme_wrapper .entry-header-custom-wrap ul li i,
	#uploadimage:hover, .upload.button:hover,

	.button, a.button, input.button, input.button[type="submit"], #footer .subscriber_container input[type="submit"], .home_page_banner .search_key .widget-wrap .search_nearby_widget #searchform input[type="submit"], .button-primary[type="submit"], #searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce a.button, body.woocommerce a.button.alt, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button, .uploadfilebutton, input[type="submit"], .published_box form input[type="submit"], .edit-btn, #frontend_edit_video, #panel .set_address_map, #panel input[type="button"], #directory_location_map .btn_input_normal, body .directory_google_map #panel input[type="button"], .frontend_oembed_video.button, .frontend_editor .directory_google_map #panel input[type="button"], .frontend_editor #panel input[type="button"], .frontend_editor #uploadimage, .frontend_editor .upload.button,

	.button:hover,a.button:hover,input.button:hover,input[type="submit"].button:hover,.button:active,a.button:active,input.button:active,input[type="submit"].button:active,#footer .subscriber_container input[type="submit"]:hover,#footer .subscriber_container input[type="submit"]:active,#content input.button:hover, #searchform input[type="submit"]:hover, .upload:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce #content input.button:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #respond input#submit:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover, body.woocommerce a.button.alt:hover, body.woocommerce a.button:hover, body.woocommerce button.button.alt:hover, body.woocommerce button.button:hover, body.woocommerce input.button.alt:hover, body.woocommerce input.button:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce-page #content input.button:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page a.button:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page button.button:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page input.button:hover, div.woocommerce form.track_order input.button:hover,.home_page_banner .search_location .widget-wrap .search_nearby_widget #searchform input[type="submit"]:hover,.button-primary[type="submit"]:hover,.uploadfilebutton:hover, input[type="button"]:hover, input[type="submit"]:hover,.published_box form input[type="submit"]:hover,
	body .form_row .ui-datepicker-trigger, body .form_row .ui-datepicker-trigger:hover,.home_page_banner form input[type="submit"]:hover,
	.button:hover, a.button:hover, input.button:hover, input.button[type="submit"]:hover, .button:active, a.button:active, input.button:active, input.button[type="submit"]:active, #footer .subscriber_container input[type="submit"]:hover, #footer .subscriber_container input[type="submit"]:active, #content input.button:hover, #searchform input[type="submit"]:hover, .upload:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce #content input.button:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #respond input#submit:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover, body.woocommerce a.button.alt:hover, body.woocommerce a.button:hover, body.woocommerce button.button.alt:hover, body.woocommerce button.button:hover, body.woocommerce input.button.alt:hover, body.woocommerce input.button:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce-page #content input.button:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page a.button:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page button.button:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page input.button:hover, div.woocommerce form.track_order input.button:hover, .home_page_banner .search_key .widget-wrap .search_nearby_widget #searchform input[type="submit"]:hover, .button-primary[type="submit"]:hover, .uploadfilebutton:hover, input[type="button"]:hover, input[type="submit"]:hover, .published_box form input[type="submit"]:hover, .frontend_editor #uploadimage:hover, .frontend_editor .upload.button:hover,
	.button, a.button, input.button, input.button[type="submit"], #footer .subscriber_container input[type="submit"], .home_page_banner .search_key .widget-wrap .search_nearby_widget #searchform input[type="submit"], .button-primary[type="submit"], #searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce a.button, body.woocommerce a.button.alt, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button, .uploadfilebutton, input[type="submit"], .published_box form input[type="submit"], .edit-btn, #frontend_edit_video, #panel .set_address_map, #panel input[type="button"], #directory_location_map .btn_input_normal, body .directory_google_map #panel input[type="button"], .frontend_oembed_video.button, .frontend_editor .directory_google_map #panel input[type="button"], .frontend_editor #panel input[type="button"], .frontend_editor #uploadimage, .frontend_editor .upload.button,
	.mobile-view .comment-pagination .page-numbers:hover, .mobile-view .loop-nav span.next:hover, .mobile-view .loop-nav span.previous:hover, .mobile-view .pagination .page-numbers:hover, body.mobile-view .pos_navigation .post_left a:hover, body.mobile-view .pos_navigation .post_right a:hover, .pagination .page-numbers.next:hover:before, .pagination .page-numbers.previous:hover:before, .pagination .page-numbers.prev:hover:before,
	footer,.widget #wp-calendar caption
	{
		background: <?php echo $color2;?>;
	}

	body .upload_box #uploadimage:hover, body .upload_box .upload.button:hover,body .ajax-file-upload:hover span:first-child, body .ajax-file-upload > span:hover,
    .button:hover, a.button:hover, input.button:hover, input.button[type="submit"]:hover, .button:active, a.button:active, input.button:active, input.button[type="submit"]:active, #footer .subscriber_container input[type="submit"]:hover, #footer .subscriber_container input[type="submit"]:active, #content input.button:hover, #searchform input[type="submit"]:hover, .upload:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce #content input.button:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #respond input#submit:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover, body.woocommerce a.button.alt:hover, body.woocommerce a.button:hover, body.woocommerce button.button.alt:hover, body.woocommerce button.button:hover, body.woocommerce input.button.alt:hover, body.woocommerce input.button:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce-page #content input.button:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page a.button:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page button.button:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page input.button:hover, div.woocommerce form.track_order input.button:hover, .home_page_banner .search_key .widget-wrap .search_nearby_widget #searchform input[type="submit"]:hover, .button-primary[type="submit"]:hover, .uploadfilebutton:hover, input[type="button"]:hover, input[type="submit"]:hover, .published_box form input[type="submit"]:hover, .frontend_editor #uploadimage:hover, .frontend_editor .upload.button:hover,
    .post .entry .property-title .property-price .prop-price, .post .entry .entry-title-wrapper .property-price .prop-price,
    #sidebar-header #searchform input[type="submit"]:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce .quantity .plus, body.woocommerce-page .quantity .plus, body.woocommerce #content .quantity .plus, body.woocommerce-page #content .quantity .plus, body.woocommerce .quantity .minus, body.woocommerce-page .quantity .minus, body.woocommerce #content .quantity .minus, body.woocommerce-page #content .quantity .minus,
    body.frontend_editor .entry-header-image #uploadimage, body.frontend_editor .entry-header-image .uploadfilebutton, body .frontend_editor #uploadimage, .frontend_editor .upload.button, .frontend_editor .directory_google_map #panel input[type="button"], .frontend_editor #panel input[type="button"],
    body .left-off-canvas-menu .mega-menu .mega_menu_wrap,
	.left-off-canvas-menu,
	.upload, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button, body.woocommerce #respond input#submit, body.woocommerce #content input.button, body.woocommerce-page a.button, body.woocommerce-page button.button, body.woocommerce-page input.button, body.woocommerce-page #respond input#submit, body.woocommerce-page #content input.button, #searchform input[type="submit"], body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce-page .widget_layered_nav_filters ul li a, div.woocommerce form.track_order input.button, #special_offer a.button,
	#submit_form .upload.button, #userform .upload.button,
	#sidebar-header #searchform input[type="submit"]:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce .quantity .plus, body.woocommerce-page .quantity .plus, body.woocommerce #content .quantity .plus, body.woocommerce-page #content .quantity .plus, body.woocommerce .quantity .minus, body.woocommerce-page .quantity .minus, body.woocommerce #content .quantity .minus, body.woocommerce-page #content .quantity .minus,
	button, input[type="reset"], input[type="submit"], input[type="button"], a.button, .button, .uploadfilebutton, body button.ui-datepicker-trigger,
	body.frontend_editor .directory_google_map .map_customizer_wrap  #panel input[type="button"],
	footer,
	.mobile-view .comment-pagination .page-numbers:hover, .mobile-view .loop-nav span.next:hover, .mobile-view .loop-nav span.previous:hover, .mobile-view .pagination .page-numbers:hover, body.mobile-view .pos_navigation .post_left a:hover, body.mobile-view .pos_navigation .post_right a:hover,
	.pagination .page-numbers.next:hover:before, .pagination .page-numbers.previous:hover:before, .pagination .page-numbers.prev:hover:before	{
		background-color: <?php echo $color2;?>;
	}
	body.singular-property.layout-default .entry-header-custom-wrap ul li i {
		background-color: <?php echo $color2;?> !important;
	}

	a,.listing_post .hentry h2 a,body .all_category_list_widget .category_list ul li a,.byline a:hover, .entry-meta a:hover,.entry-meta .category a:hover, .entry-meta .post_tag a:hover,.arclist ul li a:hover,.post_info_meta a:hover,a:hover, ol li a, ul li a,.templatic_twitter_widget .twit_time,body.tevolution-directory .post-meta a:hover,.user_dsb_cf span a:hover,#content .peoplelisting li .peopleinfo-wrap:hover  .people_info h3 a,.ratings span:hover,.ratings span:hover a,body .tevolution_author_listing .featured_agent_list li p a:hover,.popular_post ul li .post_data h3 a:hover,.arclist ul li .arclist_date a:hover,.twitter_title_link:hover,body.singular-property .supreme_wrapper .property .entry-header-right .property-price,body .author_custom_post_wrapper ul li a:hover,.event_type li a:hover,body.tevolution-directory .ui-widget-header li a:hover,.all_category_list_widget .category_list h3 a:hover,body #main.home_page_wrapper .section-row .widget-title a.more:hover,.sidebar .listing_post .hentry h2 a:hover,
	.widget a:hover, .widget-small a:hover,.attending_event span.fav span.span_msg a:hover,
	body #sidebar-header .search_nearby_widget #searchform input[type="submit"],
	.nav_bg .widget-nav-menu li a:hover, div#menu-secondary .menu li a:hover, div#menu-secondary1 .menu li a:hover, div#menu-subsidiary .menu li a:hover,div#menu-secondary .menu li a:hover, div#menu-secondary .menu li.current-menu-item > a, div#menu-secondary .menu li:hover > a, div#menu-secondary1 .menu li a:hover, div#menu-secondary1 .menu li.current-menu-item > a, div#menu-secondary1 .menu li:hover > a, div#menu-subsidiary .menu li.current-menu-item > a,body .mega-menu ul.mega li:hover > a,body .mega-menu ul.mega li.current-menu-item > a,
	div#menu-primary .menu li a:hover,
	.mega-menu ul.mega li .sub li.mega-hdr a.mega-hdr-a:hover,body .mega-menu ul.mega .sub li.mega-hdr li a:hover,body .mega-menu ul.mega li .sub-container.non-mega .sub a:hover, body .mega-menu ul.mega li .sub-container.non-mega li a:hover, body .mega-menu ul.mega li .sub-container.non-mega li.current-menu-item a,
	.page-title-header .breadcrumb span.trail-end,
	.page-back-link:hover,
	body .filters input[type='checkbox'] + label:before,
	body .ui-widget-content a,
	.entry-header-custom-wrap a:hover span,
	#content .claim-post-wraper > ul > li > a.added,
	body .share_link a:hover:before,
	#breadcrumb a:hover, .breadcrumb a:hover,
	body.tevolution-directory .ui-widget-header .ui-state-active a:link, body.tevolution-directory .ui-widget-header .ui-state-active a:visited, body.tevolution-event-manager .ui-widget-header .ui-state-active a, body.single-property #tabs ul.ui-tabs-nav li.ui-tabs-active a,body.singular-property #tabs ul.ui-tabs-nav li.ui-tabs-active a,
	body .event_manager_tab ul.event_type li a:hover,
	body .event_manager_tab ul.event_type li a.active,
	body .author_custom_post_wrapper ul li a.nav-author-post-tab-active,.event_type li a.active,
	body #content .peoplelisting li .peopleinfo-wrap .links .profile a,
	body #content .peoplelisting li .peopleinfo-wrap .people_info .peoplelink span:hover:before,body #content .peoplelisting li .peopleinfo-wrap .people_info .peoplelink span:hover a,
	.author_social_networks.social_media .social_media_list li a:hover i,
	#loginwidgetform .forgot_link a:hover,
	body .event_manager_tab ul.view_mode li a:hover:before, body .directory_manager_tab ul.view_mode li a:hover:before,body .event_manager_tab ul.view_mode li a.active:before,body .directory_manager_tab ul.view_mode li a.active:before,body .event_manager_tab ul.view_mode li a.active, body .directory_manager_tab ul.view_mode li a.active,body .event_manager_tab ul.view_mode li a:hover, body .directory_manager_tab ul.view_mode li a:hover,
	#sub_listing_categories ul li a,#sub_event_categories ul li a,
	.post:hover .entry h2.entry-title a,h2.entry-title a:hover,body .related_post_grid_view li:hover h3 a,
	.rev_pin li a:hover:before,#content .rev_pin li span a.small_btn.addtofav:hover:before, .fav .addtofav:hover:before, .fav .removefromfav:hover:before,
	.rev_pin li a.removefromfav:before,
	body .post .entry p.pinpoint:before,
	body .grid .post .entry .date, body .grid .tmpl_event_block .entry .date,
	body .comment-pagination .page-numbers,body .pagination .page-numbers,body .loop-nav span.next,body .loop-nav span.previous,
	.bbp-pagination .page-numbers:hover, .comment-pagination .page-numbers:hover, .pagination .page-numbers:hover,body .loop-nav span.next:hover,body .loop-nav span.previous:hover,
	.pagination .next:before, .pagination .prev:before,body .loop-nav span.next:before,body .loop-nav span.previous:before,
	.tmpl_property_agent .tmpl-agent-details #contact_frm .form_row span.message_error,
	.sidebar .form_row label span#ftrhome, .sidebar .form_row label span#ftrcat, .sidebar .form_row .required, .sidebar .form_row label span,
	.hover-caption-image h1,
	.hover-caption-image h3,
	.widget ul.community-grid li.red figure figcaption a,
	.widget .custom-content-widget-wrap .custom-content-widget i,
	.widget .custom-content-widget-wrap .custom-content-widget:hover h3 a,
	.error_404 h4,
	.sidebar ul li a:hover,#recentcomments a:hover,#recentcomments li a:last-child:hover,
	body .widget #wp-calendar .calendar_tooltip .event_title,
	.widget_rss ul li a.rsswidget:hover,
	#footer a:hover,#footer .footer_bottom a:hover,
	#footer .social_media ul li a:hover i,
	body .social-media-share li .pinit_share a .share,
	.social_media ul li a i,
	.cities_names a:hover,
	.comment-pagination .page-numbers, .loop-nav span.next, .loop-nav span.previous, .pagination .page-numbers, body .pos_navigation .post_left a, body .pos_navigation .post_right a,
	body.tevolution-directory .ui-widget-header li a, body.tevolution-event-manager .ui-widget-header li a, body.singular-property .ui-widget-header li a,
	.comment-author cite a:hover,
	.widget .event_calendar_wrap a.more_events,
	a, .listing_post .hentry h2 a, body .all_category_list_widget .category_list ul li a, .byline a:hover, .entry-meta a:hover, .entry-meta .category a:hover, .entry-meta .post_tag a:hover, .arclist ul li a:hover, .post_info_meta a:hover, a:hover, ol li a, ul li a, .templatic_twitter_widget .twit_time, body.tevolution-directory .post-meta a:hover, .user_dsb_cf span a:hover, #content .peoplelisting li .peopleinfo-wrap:hover .people_info h3 a, .ratings span:hover, .ratings span:hover a, body .tevolution_author_listing .featured_agent_list li p a:hover, .popular_post ul li .post_data h3 a:hover, .arclist ul li .arclist_date a:hover, .twitter_title_link:hover, body.singular-property .supreme_wrapper .property .entry-header-right .property-price, body .author_custom_post_wrapper ul li a:hover, .event_type li a:hover, body.tevolution-directory .ui-widget-header li a:hover, .all_category_list_widget .category_list h3 a:hover, body #main.home_page_wrapper .section-row .widget-title a.more:hover, .sidebar .listing_post .hentry h2 a:hover, .widget a:hover, .widget-small a:hover, .attending_event span.fav span.span_msg a:hover, body .widget_supreme_banner_slider .slider_carousel .flex-direction-nav li a:hover, body .post .entry-header h2 a:hover, .cities_names a:hover, .comment-author cite a:hover, body .all_category_list_widget .category_list ul li a:hover, .tevolution-event-manager .post-meta a, #content ul.products li.product:hover h3, #content ul.products li.product .price .from, #content ul.products li.product .price del, #post-listing .complete .step-heading,

	body .mega-menu ul.mega li a:hover, body .mega-menu ul.mega li.current-menu-item a, body .mega-menu ul.mega li.current-page-item a, body .mega-menu ul.mega li:hover a, body .nav_bg .widget-nav-menu li a:hover, body div#menu-secondary .menu li a:hover, body div#menu-secondary1 .menu li a:hover, body div#menu-subsidiary .menu li a:hover, .nav_bg .widget-nav-menu li a:hover, div#menu-secondary .menu li a:hover, div#menu-secondary1 .menu li a:hover, div#menu-subsidiary .menu li a:hover, div#menu-secondary .menu li a:hover, div#menu-secondary .menu li.current-menu-item > a, div#menu-secondary .menu li:hover > a, div#menu-secondary1 .menu li a:hover, div#menu-secondary1 .menu li.current-menu-item > a, div#menu-secondary1 .menu li:hover > a, div#menu-subsidiary .menu li.current-menu-item > a, body .mega-menu ul.mega li:hover > a, body .mega-menu ul.mega li.current-menu-item > a,
	a, ol li a, ul li a, .byline a, #tev_sub_categories ul li a, #sub_event_categories ul li a, #sub_listing_categories ul li a, .templatic_twitter_widget .twit_time, .mobile-view .list .entry h2.entry-title, .mobile-view .grid .entry h2.entry-title, .mobile-view .entry h2.entry-title, .mobile-view .list .entry h2.entry-title a, .mobile-view .grid .entry h2.entry-title a, .mobile-view .entry h2.entry-title a, .mobile-view #content .peopleinfo-wrap h3 .fl a,
	.wordpress .tabs dd > a, .wordpress .tabs .tab-title.active > a,.wordpress .tabs dd a:hover, .wordpress .tabs .tab-title a:hover,body #breadcrumb a:hover, body .breadcrumb a:hover,#content .claim-post-wraper ul li a:hover, #content .claim-post-wraper > ul > li > a.added,
	.comment-pagination .page-numbers strong, .pagination .page-numbers strong, strong.prev, strong.next, .expand.page-numbers, a.page-numbers[title~="Last"], a.page-numbers[title~="First"], span.page-numbers.dots, .loop-nav span.next, .loop-nav span.previous, body .pos_navigation .post_left a, body .pos_navigation .post_right a, body.woocommerce #content nav.woocommerce-pagination ul li a, body.woocommerce nav.woocommerce-pagination ul li a, body.woocommerce-page #content nav.woocommerce-pagination ul li a, body.woocommerce-page nav.woocommerce-pagination ul li a,
	body #menu-secondary .menu li[class*="current-menu"] > a, body #menu_secondary_mega_menu .mega li[class*="current-menu"] > a, body .menu li[class*="current-menu"] > a,
	.list .entry .bottom_line a:hover,.social_media ul li a:hover i,
     .list .entry .bottom_line a:hover,.comment-meta a:hover, #respond #cancel-comment-reply-link,
     body .mega-menu .mega_menu_wrap .nav_bg > ul.reg_login_links > li a:hover
	{
		color: <?php echo $color2;?>;
	}

	body #map_canvas .google-map-info .map-inner-wrapper .map-item-info a:hover {
		color: <?php echo $color2;?> !important;
	}

	body .share_link a:hover,
	body #content .peoplelisting li .peopleinfo-wrap .people_info .peoplelink span:hover:before,body #content .peoplelisting li .peopleinfo-wrap .people_info .peoplelink span:hover a,
	.author_social_networks.social_media .social_media_list li a:hover i,
	body .event_manager_tab ul.view_mode li a:hover:before, body .directory_manager_tab ul.view_mode li a:hover:before,body .event_manager_tab ul.view_mode li a.active:before,body .directory_manager_tab ul.view_mode li a.active:before,body .event_manager_tab ul.view_mode li a.active, body .directory_manager_tab ul.view_mode li a.active,body .event_manager_tab ul.view_mode li a:hover, body .directory_manager_tab ul.view_mode li a:hover,
	.browse_by_tag a:hover, .tagcloud a:hover, .tags a:hover,
	body table.calendar_widget td.date_n div span.calendar_tooltip,
	body .all_category_list_widget .category_list h3,
	#footer .social_media ul li a:hover i,
	.social_media ul li a:hover i  {
		border-color:<?php echo $color2;?>;
	}

	.tab-bar .menu-icon span {
		box-shadow: 0 0 0 1px <?php echo $color2;?>, 0 7px 0 1px <?php echo $color2;?>, 0 14px 0 1px <?php echo $color2;?>;
	}



<?php }
	
//Secondary Color - Black color
if($color3 != "#" || $color3 != ""){?>
	
	a:hover,
	div#menu-primary .menu li a,
	div.neighborhood_widget ul li .nearby_content a,
	.tmpl_property_agent .agent-top_wrapper .tmpl-agent-detail-rt p.title strong,
	body .user_dsb_cf span,body .user_dsb_cf span a,body .user_dsb_cf span b,
	.hover-caption-image p,
	ol li a:hover, ul li a:hover,
	input.input-text, input[type="date"], input[type="datetime-local"], input[type="datetime"], input[type="email"], input[type="month"], input[type="number"], input[type="password"], input[type="search"], input[type="tel"], input[type="text"], input[type="time"], input[type="url"], input[type="week"], select, textarea,
	body #sidebar-header .search_nearby_widget #searchform input[type="text"],
	body .mega-menu ul.mega li .sub li.mega-hdr a.mega-hdr-a,
	body .event-organizer .event-organizer-right label,body.event-single-page .hentry .entry-header-title .entry-header-custom-wrap p label,
	.sidebar .tmpl_property_agent .tmpl-agent-details p label,
	body .tevolution_author_listing .featured_agent_list li p a,.popular_post ul li .post_data h3 a,.recent_comments li a.title,.sidebar .listing_post .hentry h2 a,.textwidget h4,.textwidget h4 strong,.comment-author cite a,.comment-author cite,
	.templatic_twitter_widget li a,
	.arclist ul li a,
	input.input-text, input[type="date"], input[type="datetime-local"], input[type="datetime"], input[type="email"], input[type="month"], input[type="number"], input[type="password"], input[type="search"], input[type="tel"], input[type="text"], input[type="time"], input[type="url"], input[type="week"], select, textarea,.button, .uploadfilebutton, a.button, button, input[type="button"], input[type="reset"], input[type="submit"],body #content .claim-post-wraper ul li a,#ui-datepicker-div .ui-widget-header, body .ui-widget, body .ui-widget-content,body.tevolution-directory .get_direction #from-input,
	input.input-text:focus, input[type="date"]:focus, input[type="datetime-local"]:focus, input[type="datetime"]:focus, input[type="email"]:focus, input[type="month"]:focus, input[type="number"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="text"]:focus, input[type="time"]:focus, input[type="url"]:focus, input[type="week"]:focus, select:focus, textarea:focus,
	.uploadfilebutton, button, input[type="button"], input[type="reset"], input[type="submit"],.published_box form input[type="button"],.btn-white,
	.uploadfilebutton:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover,.published_box form input[type="button"]:hover,.btn-white:hover,
	body .pos_navigation .post_left a:hover,body.singular .pos_navigation .post_right a:hover,
	.cities_names a,
	.page-back-link,
	.entry-header-custom-wrap label,.entry-header-custom-wrap span,.entry_address span,
	.entry-header-custom-wrap i,.entry_address i,
	#content .claim-post-wraper > ul > li > a,#content .claim-post-wraper ul li a.calendar_show,
	#content .claim-post-wraper > ul > li > a:hover,#content .claim-post-wraper ul li a.calendar_show:hover,
	#breadcrumb .trail-end, .breadcrumb .trail-end,
	body .event_manager_tab ul.event_type li a,
	body .author_custom_post_wrapper ul li a,.event_type li a,
	body .list .post .entry p,body .grid .post .entry > p,
	body .pagination .current,body .pagination .current:hover,
	.entry_address ul li i,
	.entry_address ul li span,
	.social_media ul li a:hover i,
	.widget .custom-content-widget-wrap .custom-content-widget p,
	body .hentry .entry-header-title .entry-header-custom-wrap p label, p.custom_header_field label, body .listing_custom_field p label,body.tevolution-directory .post-meta a,
	body .tmpl_search_property #tmpl_find_property h4,
	 .widget .event_calendar_wrap a.more_events:hover,
	 .accordion .accordion-navigation > a, .accordion dd > a,
	 body, body.wordpress, body .ui-widget-content,
	 h1, h2, h3, h4, h5, h6,
	 a:hover,ol li a:hover, ul li a:hover, .byline a:hover, #sub_listing_categories ul li a:hover, #sub_event_categories ul li a:hover,
	 .middle.tab-bar-section a,.mobile-view .toggle_handler #directorytab, .mobile-view .mobile-search, .mobile-view .mobile-search:hover,
	 body.mobile-view .right-medium > .templatic_text a.submit-small-button,
	 .tmpl-accordion .tmpl-accordion-navigation > a,
	 .comment-meta a,
	 body.mobile-view .right-medium > .templatic_text a.submit-small-button:hover  {
		color: <?php echo $color3;?>;
	}

	<!-- .mobile-view .tab-bar .menu-icon span {
	    box-shadow: 0 0 0 1px <?php echo $color3;?>, 0 7px 0 1px <?php echo $color3;?>, 0 14px 0 1px <?php echo $color3;?>;
	} -->

	.post .entry .entry-details > p,.list .post .entry .phone, 
	.grid .post .entry .phone, .list .hentry .phone,
	body #loop_event_archive .post .entry p, 
	body #loop_event_taxonomy .post .entry p,
	body .list .post .entry p, body .grid .post .entry > p {
		color: <?php echo $color3;?> !important;
	}

	#footer,
	body .upload_box #uploadimage, body .upload_box .upload.button,body .upload_box .ajax-file-upload,
	.upload:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover, body.woocommerce #respond input#submit:hover, body.woocommerce #content input.button:hover, body.woocommerce-page a.button:hover, body.woocommerce-page button.button:hover, body.woocommerce-page input.button:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page #content input.button:hover, #content input.button:hover, #searchform input[type="submit"]:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, div.woocommerce form.track_order input.button:hover, #special_offer a.button:hover,#content .claim-post-wraper ul li a:hover,
	#submit_form .upload.button:hover, #userform .upload.button, body.woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt, body.woocommerce #respond input#submit.alt, body.woocommerce #content input.button.alt, body.woocommerce-page a.button.alt, body.woocommerce-page button.button.alt, body.woocommerce-page input.button.alt, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page #content input.button.alt,
	body.woocommerce .quantity .plus:hover, body.woocommerce-page .quantity .plus:hover, body.woocommerce #content .quantity .plus:hover, body.woocommerce-page #content .quantity .plus:hover, body.woocommerce .quantity .minus:hover, body.woocommerce-page .quantity .minus:hover, body.woocommerce #content .quantity .minus:hover, body.woocommerce-page #content .quantity .minus:hover,
	button:hover, input[type="reset"]:hover, input[type="submit"]:hover, input[type="button"]:hover, a.button:hover, .button:hover, .uploadfilebutton:hover, body button.ui-datepicker-trigger:hover, body.frontend_editor .directory_google_map .map_customizer_wrap  #panel input[type="button"]:hover,
.upload.button.secondary_btn:hover,
#footer .footer_bottom,
.mobile-view .comment-pagination .page-numbers, .mobile-view .loop-nav span.next, .mobile-view .loop-nav span.previous, .mobile-view .pagination .page-numbers, body.mobile-view .pos_navigation .post_left a, body.mobile-view .pos_navigation .post_right a,
.pagination .page-numbers.next:before, .pagination .page-numbers.previous:before, .pagination .page-numbers.prev:before,
.mobile-view .button:hover, .mobile-view .uploadfilebutton:hover, .mobile-view a.button:hover, .mobile-view button:hover, .mobile-view input[type="button"]:hover, .mobile-view input[type="reset"]:hover, .mobile-view input[type="submit"]:hover {
		background-color: <?php echo $color3;?>;
	}

	.social_media ul li a:hover i,
	.mobile-view .button:hover, .mobile-view .uploadfilebutton:hover, .mobile-view a.button:hover, .mobile-view button:hover, .mobile-view input[type="button"]:hover, .mobile-view input[type="reset"]:hover, .mobile-view input[type="submit"]:hover {
		border-color: <?php echo $color3;?>;
	}

<?php }


// Grey 1
if($color4 != "#" || $color4 != ""){?>	
	

	#footer .subscriber_container input.input-text,#footer .subscriber_container input[type="text"],
	body #content .peoplelisting li .peopleinfo-wrap > a {
		background: <?php echo $color4;?>;
	}
	body .social-media-share li a,
	#sidebar-header #searchform input[type="submit"], body.woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt, body.woocommerce #respond input#submit.alt, body.woocommerce #content input.button.alt, body.woocommerce-page a.button.alt, body.woocommerce-page button.button.alt, body.woocommerce-page input.button.alt, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page #content input.button.alt {
		background-color: <?php echo $color4;?>;
	}


	body,
	.tevolution-event-manager.event-single-page .entry-content h2, .single-property .entry-content h2, .singular-property .entry-content h2,
	.widget h3,.widget h3 a,.widget-search .widget-title, .widget-title, .widget.title,
	body h1,body h2,body h3,body h4,body h5,body h6,.arclist h2,
	.togler_handler_wrap .toggle_handler #directorytab,
	body #content .peoplelisting .people_info h3 a,
	#comments-number, #reply-title,
	.widget a, .widget-small a,
	body .post .entry h2.entry-title a,body h2.entry-title a,body .related_post_grid_view li h3 a,
	body .list .post .entry p, body .grid .post .entry p, body .list .hentry p, body .entry-details p,
	.widget_rss ul li a.rsswidget,
	.arclist ul li a,
	body #map_canvas .google-map-info .map-inner-wrapper .map-item-info p,
	body #map_canvas .google-map-info .map-inner-wrapper .map-item-info a,
	body.singular-property .property .entry-header-right strong,
	body.single-property #tabs .property_custom_field p strong, .singular-property #tabs .property_custom_field p strong,
	body .all_category_list_widget .category_list h3 a,
	body .attending_event span.fav span.span_msg,
	body .toggle_handler #directorytab,
	.nav_bg .widget-nav-menu li a, div#menu-secondary .menu li a, div#menu-secondary1 .menu li a, div#menu-subsidiary .menu li a,
	body .mega-menu ul.mega li a,body .mega-menu ul.mega li ul.sub-menu ul li a,body .mega-menu ul.mega li .sub a,
	.arclist ul li .arclist_date a,
	body .user_dsb_cf label,
	.browse_by_tag a, .tagcloud a, .tags a,
	.d_location_type_navigation .d_location_navigation_right .horizontal_city_name,
	.all_category_list_widget .category_list ul li a:hover,
	#content .about_author,
	body .post .entry-header h2 a,
	.post_info_meta a {
		color: <?php echo $color4;?>;
	}

	body .filters input[type='checkbox'] + label:before {
		border-color: <?php echo $color4;?>;
	}

<?php }


// Grey 2 - Light
if($color5 != "#" || $color5 != ""){?>	
	

	.arclist ul li .arclist_date, 
	.arclist ul li .arclist_date a,
	body .list .post .entry p:before,
	body .grid .post .entry p:before,
	.widget .place-reviews li .short-content .address,
	body .tevolution_author_listing .featured_agent_list li .author_info .post-count,
	.sidebar .popular_post ul li p,
	.popular_post ul li .post_data p .date, 
	.popular_post ul li .post_data p .views,
	#recentcomments li a:last-child,
	#breadcrumb a, 
	.breadcrumb a,
	#breadcrumb .sep, 
	.breadcrumb .sep,
	#breadcrumb span, 
	.breadcrumb span,
	body .form_row .description, 
	body .form_row span.message_note, 
	body .message_note,
	.widget_rss ul li .rss-date,
	.widget_rss ul li .rss-date ~ cite,
	body .share_link a:before,
	.comment-meta .published,
	.list .post p.phone:before, .grid .post p.phone:before, .list .post p.address:before, .grid .post p.address:before, .list .post p.time:before, .grid .post p.time:before, .list .post p.event_date:before, .grid .post p.event_date:before, .list .post p.address:before, .grid .post p.address:before, .list .post p.time:before, .grid .post p.time:before, .peoplelink .website:before, .peoplelink .facebook:before, .peoplelink .twitter:before, .peoplelink .linkedin:before, .links .email:before, .links .phone:before, .post .rev_pin ul li.pinpoint:before, .post .rev_pin ul li.review:before,
	.directory-single-page .hentry .entry-header-title .listing_rating .single_rating span,
	.byline,
	.mobile-view p.org_description:before, .mobile-view p.email:before, .mobile-view p.entry_address:before, .mobile-view p.address:before, .mobile-view p.website:before, .mobile-view p.phone:before, .mobile-view p.time:before, .mobile-view p.org_name:before, .mobile-view p.address:before, .mobile-view p.date:before, .mobile-view p.fees:before, .mobile-view p.property-price:before, .mobile-view p.bedrooms:before, .mobile-view p.bathrooms:before, .mobile-view p.area:before {
		color: <?php echo $color5;?>;
	}

	body .social-media-share li a .count {
		color: <?php echo $color5;?> !important;
	}
	

<?php }


// Grey 3 - Light
if($color6 != "#" || $color6 != ""){?>	
	

	body .event_manager_tab ul.view_mode li a, body .directory_manager_tab ul.view_mode li a,
	.star_normal,
	body .filters #propery-price-range .ui-slider-handle:before,body .filters #searchfilterform .ui-slider .ui-slider-handle:before,

	.list .featured_tag, .grid .featured_tag,
	.home_page_banner .widget-title,
	.widget ul.community-grid li figure figcaption h1,
	.widget ul.community-grid li figure figcaption p,
	.widget .custom-content-widget-wrap .custom-content-widget:hover i,
	.full-width-map .toggle_handler #directorytab,
	body #map_canvas .map_infoarrow>div:last-child:before,
	#footer .widget-title,
	#footer .contact-info li i.sf-icon:before,
	#footer .social_media ul li a i,
	.list .featured_tag, .grid .featured_tag,
	body .social-media-share li a,
	body .social-media-share li a:hover,
	body .social-media-share li a .count:after,
	body .author_social_networks.social_media .social_media_list li a i,
	body .ui-tabs-nav .ui-tabs-active a:before,.event_type li a.active:before,body .author_custom_post_wrapper ul li a.nav-author-post-tab-active:before,body.tevolution-event-manager .ui-widget-header li.ui-tabs-active a:before,
	.list .featured_tag, .grid .featured_tag,
	#footer,
	#footer a,
	#footer .subscriber_container input.input-text,#footer .subscriber_container input[type="text"] {
		color: <?php echo $color6;?>;
	}
	body .filters #propery-price-range,body .filters #searchfilterform .ui-slider,
	body,
	body .filter-panel-buttons,
	body .pagination .current,body .pagination .current:hover,
	body .ui-tabs-nav,body.tevolution-event-manager .ui-widget-header,body.tevolution-directory .ui-widget-header,.event_type,body .author_custom_post_wrapper ul {
		background: <?php echo $color6;?>;
	}
	.how_to_reg,
	.tmpl-accordion .tmpl-accordion-navigation > .content.active,
	.mobile-view #comments li, .mobile-view form#commentform {
		background-color: <?php echo $color6;?>;
	}

	body .filters,
	body .filter-panel-buttons,
	body .filters #propery-price-range .ui-slider-handle,body .filters #searchfilterform .ui-slider .ui-slider-handle {
		border-color: <?php echo $color6;?>;
	}

	body .event_manager_tab ul.event_type li a.active,
	body .author_custom_post_wrapper ul li a.nav-author-post-tab-active,.event_type li a.active {
		border-bottom-color: <?php echo $color6;?>;
	}

	.category_label .cf_checkbox,
	.overlay-dark .toggle_handler #directorytab,
	dialog, .reveal-modal,
	.packageblock .packagelistitems,
	#main > .wrap.row { background: <?php echo $color6;?> !important; }

	.d_location_type_navigation.horizontal_open { border-color: <?php echo $color6;?> !important; }
	

<?php }


$color_data = ob_get_contents();
ob_clean();
if(isset($color_data) && $color_data !=''){ 
    file_put_contents(trailingslashit(get_template_directory())."css/admin_style.css" , $color_data); 
}
?>
