<?php
/**
 * The Header for our theme.
 *
 * The header template is generally used on every page of your site. Nearly all other templates call it 
 * somewhere near the top of the file. It is used mostly as an opening wrapper, which is closed with the 
 * footer.php file. It also executes key functions needed by the theme, child themes, and plugins. 
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->  
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->  
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->  
<!--[if IE 9 ]>    <html class="ie9"> <![endif]--> 
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->  
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Specially to make clustering work in IE -->
<title>
	<?php wp_title();?>
</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php 
$supreme2_theme_settings = get_option(supreme_prefix().'_theme_settings');
if(function_exists('supreme_get_favicon')){
	if(supreme_get_favicon()){ 
		echo '<link rel="shortcut icon" href="'.supreme_get_favicon().'" />';
	}
}
wp_head(); // wp_head 
do_action('supreme_enqueue_script');
if(isset($supreme2_theme_settings['enable_sticky_header_menu']) && $supreme2_theme_settings['enable_sticky_header_menu']==1){
  wp_enqueue_script('header-sticky-menu',get_template_directory_uri().'/js/sticky_menu.js',array( 'jquery' ));
}
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri()."/css/admin_style.css"; ?>" type="text/css" media="all" />
<?php
if ( file_exists(get_template_directory()."/custom.css") && file_get_contents(get_template_directory()."/custom.css") !='' ) {
  echo '<link href="'.get_template_directory_uri().'/custom.css" rel="stylesheet" type="text/css" />';    
}
?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<style>
    body{word-wrap:inherit!important;}
</style>
<![endif]-->
<script type="text/javascript">
  jQuery( document ).ready(function() {
    jQuery('strong.prev.page-numbers,span.previous').html( "<i class='fa fa-angle-left'></i>" );
    jQuery('strong.next.page-numbers,span.next').html( "<i class='fa fa-angle-right'></i>" );
    jQuery('.woocommerce-pagination li a.prev.page-numbers').html( "<i class='fa fa-angle-left'></i>" );
    jQuery('.woocommerce-pagination li a.next.page-numbers').html( "<i class='fa fa-angle-right'></i>" );
  });
  
</script>


</head>
<body class="<?php supreme_body_class(); ?>">

<?php do_action('after_body');

/* add class to change the scroll of main content when left sidebar is not there  */
if(!is_active_sidebar("listings_left_content")){
	$class="single-wrapper";
}else{
	$class="";	
}
?>
<div class="supreme_wrapper <?php echo $class; ?>">
<?php do_action( 'open_body' ); // supreme_open_body 
	 $theme_name = get_option('stylesheet');
	 $nav_menu = get_option('theme_mods_'.strtolower($theme_name));
	 remove_action('pre_get_posts', 'home_page_feature_listing');
?>
<div class="off-canvas-wrap" data-offcanvas> <!-- off-canvas-wrap start -->
  <div class="inner-wrap"> <!-- inner-wrap start -->
    <nav class="tab-bar hide-for-large-up">
      <section class="left-small">
        <a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a> <!-- offcanvas icon -->
      </section>
	  
	  <section class="middle tab-bar-section">
        <a href="<?php echo home_url(); ?>/" title="<?php echo bloginfo( 'name' ); ?>" rel="Home">
		  <img class="logo" src="<?php echo supreme_get_settings( 'supreme_logo_url' ); ?>" alt="<?php echo bloginfo( 'name' ); ?>" />
		</a>
      </section>

      <section class="right-medium">
    		<?php if(is_active_sidebar('menu-right')){ 
    				dynamic_sidebar('menu-right');
    		} ?>
      </section>
    </nav>

    <aside class="left-off-canvas-menu"> <!-- off canvas side menu -->
    <?php
		apply_filters('tmpl_supreme_header_primary',supreme_header_primary_navigation()); // Loads the menu-primary template. 
		if(isset($nav_menu['nav_menu_locations'])  && @$nav_menu['nav_menu_locations']['secondary'] != 0){
				echo '<div id="nav" class="nav_bg">';		
					apply_filters('tmpl_supreme_header_secondary',supreme_header_secondary_mobile_navigation()); // Loads the menu-secondary template.
				echo "</div>";		
			}elseif(is_active_sidebar('mega_menu')){
				if(function_exists('dynamic_sidebar')){
					echo '<div id="nav" class="nav_bg">
							<div id="menu-mobi-secondary" class="menu-container">
								<nav role="navigation" class="wrap">
									<div id="menu-mobi-secondary-title">';
										_e( 'Menu', TDOMAIN );
						   echo '</div>';
								dynamic_sidebar('mega_menu'); // jQuery mega menu
					echo "</nav></div></div>";		
				} 
			}else{
		?>
      <ul class="off-canvas-list">
       <?php wp_list_pages('title_li=&depth=0&child_of=0&number=5&show_home=1&sort_column=ID&sort_order=DESC');?>
      </ul>
      <?php } 
       // if ( is_active_sidebar( 'header' ) ) : 
       //  apply_filters( 'tmpl-header',supreme_header_sidebar() ); // Loads the sidebar-header. 
       // endif; 
       // do_action( 'header' );
       ?>
    </aside>


<div id="container" class="container-wrap">
<div class="header_container clearfix">
  <div class="header_strip">
    <div class="primary_menu_wrapper clearfix">
	<?php if(is_active_sidebar('menu-right')){ 
				dynamic_sidebar('menu-right');
		} 
		supreme_primary_navigation();
		do_action( 'after_menu_primary' ); // supreme_before_header ?>
        
    </div>
    <?php do_action( 'before_header' ); // supreme_before_header 
	
		if(function_exists('get_header_image_location')){
			$header_image_location = get_header_image_location(); // 0 = before secondary navigation menu, 1 = after secondary navigation menu
		}else{
			$header_image_location = 1;
		} ?>
     <div id="header" class="clearfix">
		<?php do_action( 'open_header' ); // supreme_open_header ?>
          <div class="header-wrap">
               <div id="branding">
                    <hgroup>
					<?php if ( supreme_get_settings( 'supreme_logo_url' ) ) : ?>
                         <div id="site-title">
                         	<a href="<?php echo home_url(); ?>/" title="<?php echo bloginfo( 'name' ); ?>" rel="Home">
                              	<img class="logo" src="<?php echo supreme_get_settings( 'supreme_logo_url' ); ?>" alt="<?php echo bloginfo( 'name' ); ?>" />
                              </a>
                         </div>
						 
                         <?php else :
                        		 supreme_site_title();
                         endif; 
                         if ( supreme_get_settings( 'supreme_site_description' ) )  : // If hide description setting is un-checked, display the site description. 
                         	supreme_site_description(); 
                         endif; ?>
						
                    </hgroup>
                    <?php do_action('before_desk_menu_primary'); ?>

               </div>
               <!-- #branding -->
               
               <?php 
               if ( is_active_sidebar( 'header' ) ) : 
               	apply_filters( 'tmpl-header',supreme_header_sidebar() ); // Loads the sidebar-header. 
               endif; 
               do_action( 'header' ); // supreme_header
			   
			   /* Secondary navigation menu for desk top */
			   supreme_secondary_navigation(); 			   
			   ?>
			
          </div>
          <!-- .wrap -->
         <?php
		
          do_action( 'close_header' ); // supreme_close_header 
          ?>
     </div>
    <!-- #header -->
  </div>
</div>

<?php 
$tmpdata = get_option('city_googlemap_setting');					
/* set background none when map widget is set in homepage banner widget area */

if(is_active_sidebar('home-page-banner')){
	$sidebars_widgets = get_option('sidebars_widgets');
	for($i=0;$i<count($sidebars_widgets['home-page-banner']);$i++)
	{
		if(strstr($sidebars_widgets['home-page-banner'][$i],'googlemap_homepage'))
		{
                                                            $style = ' style="background:none repeat scroll 0 0 rgba(0, 0, 0, 0)"';
                                                  }
	}	
}

if((!is_page() && !is_author() && !is_404() && !is_singular() && !is_tax()) || (is_front_page() && !is_home()) ):?>
     <div class="home_page_banner clear clearfix ap_full_width" <?php if(!empty($style))echo $style; ?>>
       <?php if(!empty($header_image) && $header_image_location == 1){ ?>
          <div class="templatic_header_image"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></div>
       <?php } 
	   if(!is_home()){
       do_action( 'before_main' ); // supreme_before_main 
	   }?>
     </div>
<?php endif;

	$args = get_option('templatic_custom_taxonomy');
	$args1 = get_option('templatic_custom_post');
	$exclude_array =  apply_filters('spf_taxcategory_posttypes',array('event','listing','property'));
	if($args):
		foreach($args as $key=> $_args)
		{
			if($_args['post_type'] == get_post_type() && (!in_array($_args['post_type'],$exclude_array) || !file_exists(get_stylesheet_directory()."/taxonomy-".$_args["labels"]["singular_name"].".php"))){
					?>
					<div class="home_page_banner clear clearfix map_full_width" <?php if(!empty($style))echo $style; ?>>
					   <?php if(!empty($header_image) && $header_image_location == 1){ ?>
						  <div class="templatic_header_image"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></div>
					   <?php } 
					   if(!is_home()){
                                                                                                                                            do_action( 'before_main' ); // supreme_before_main 
					   }?>
					 </div>
					<?php
			}
			/*Add sidebar for listing page below header */
		}
	endif;
if((is_singular() && !is_page()) || (isset($_REQUEST['page']) && $_REQUEST['page'] =='preview')){
 do_action( 'before_opening_main' ); 
}

if(is_front_page()){
	$class = "home_page_wrapper";
}else{
	$class = "";
}
?>
<div id="main" class="clearfix <?php echo $class; ?>">
<?php 
	do_action('tmpl_before_open_main'); 
	do_action('tmpl_open_main'); 
	do_action('tmpl_after_open_main'); 
?>
<div class="wrap ">
<?php do_action( 'open_main' ); // supreme_open_main ?>
