<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins.
 */
 do_action( 'close_main' ); // supreme_close_main
 ?>
</div>
<!-- .wrap -->
<?php do_action( 'after_wrapper' ); // supreme_after_main ?>
</div>
<!-- #main -->
<?php do_action( 'after_main' ); // supreme_after_main ?>
</div>
<!-- #container -->

<a class="exit-off-canvas"></a> <!-- exit-off-canvas - overlay to exit offcanvas -->
<a class="exit-selection"></a>
<div class="exit-sorting"></div>
  </div> <!-- inner-wrap start -->
</div> <!-- off-canvas-wrap end -->


<?php do_action( 'close_body' ); // supreme_close_body

	/* Show home page above footer widget */
	if(is_home() || is_front_page())
		apply_filters('tmpl-above-footer',tmpl_above_footer_theme_sidebar() ); // Loads the sidebar-subsidiary
	do_action( 'before_footer' ); // supreme_before_footer ?>
<footer id="footer" class="clearfix">
  <?php
	if ( tmpl_wp_is_mobile()) {
		include_once(get_template_directory().'/mobile-templates/mobile-footer.php');
	}else{

	do_action( 'open_footer' ); // supreme_open_footer
	if(is_active_sidebar('footer')):
  ?>
  <div class="footer_top clearfix">
	<?php do_action('open_footer_widget'); ?>
    <div class="footer-wrap clearfix row">
      <div class="columns">
        <div class="footer_widget_wrap">
          <?php apply_filters('tmpl_supreme_footer_widgets' ,supreme_footer_widgets()); //load footer widgets ?>
        </div>
      </div>
    </div>
	<?php do_action('close_footer_widget'); ?>
  </div>
  <?php endif; ?>
  <div class="footer_bottom clearfix">
    <div class="footer-wrap clearfix row">
      <div class="columns">
            <?php
      		/* before footer menu */
      		do_action( 'before-footer-nav' );
      		apply_filters('tmpl_supreme_footer_nav',supreme_footer_navigation()); // Loads the menu-footer.
      		 /* before footer content */
      		do_action( 'before-footer-content' );
                  if(supreme_get_settings('footer_insert')){
					  $footer_insert=supreme_get_settings( 'footer_insert' ) ;
					   if (function_exists('icl_register_string')) {
							icl_register_string('supreme-footer_insert', 'footer_insert',$footer_insert);
							$footer_insert = icl_t('supreme-footer_insert', 'footer_insert',$footer_insert);
					   }
                  ?>
            <div class="footer-content"> <?php echo apply_atomic_shortcode( 'footer_content', $footer_insert ); ?> </div>
            <!-- .footer-content -->
            <?php }else{
                  if(!is_active_sidebar('footer')):
                  ?>
      	<div class="footer-content">
      		<?php echo '<p class="copyright">&copy; '.date('Y').' <a href="http://templatic.com/demos/directory">Directory</a>. &nbsp;Designed by <a href="http://templatic.com">Templatic</a></p>'; ?>

                </div>
            <!-- .footer-content -->
            <?php	endif; }

              do_action( 'footer' ); // supreme_footer ?>
        </div>
    </div>
    <!-- .wrap -->
  </div>
  <?php do_action( 'close_footer' ); // supreme_close_footer
	}  ?>
<script type="text/javascript">



	 jQuery( document ).ready(function() {



      jQuery( ".left-off-canvas-toggle" ).click(function() {
        jQuery( "#show_togglebox_wrap" ).addClass( "offcanvas-open" );
      });
      jQuery( ".exit-off-canvas" ).click(function() {
        jQuery( "#show_togglebox_wrap" ).removeClass( "offcanvas-open" );
      });


      // var strip_height = jQuery('.header_strip').height() + 32;
      // jQuery('html').css('padding-top',strip_height+'px');

      // jQuery('.supreme_wrapper').css('height', '100%').css('height', '-='+top_strip_height+'px');

      jQuery('.home_page_banner input[type="text"]').on('click', function( e ) {
        if($j('.ui-autocomplete').css('display') == 'none')
        {
          $j('html').addClass('customclass');
        }
      });
      jQuery('html .exit-selection').on('click', function( e ) {
        $j('html').removeClass('customclass');
      });

    <?php global $current_user;
      // Logout
      if($current_user->ID == '' && (is_tax() || is_single() || is_archive() || is_search()))
        { ?>
          if (jQuery(window).width() >= 1200)
          {
            var top_strip_height = jQuery('.header_strip,#wpadminbar').height() + 27;
            jQuery(document).ready(function(){
              resizeDiv_();
            });
            window.onresize = function(event) {
              resizeDiv();
            }
            function resizeDiv_() {
              var theHeight = jQuery(window).height() - top_strip_height;
              jQuery('.map-sidebar,.content-sidebar').css({'height': theHeight + 'px'/*,'margin-top': top_strip_height + 'px'*/});
              jQuery('.supreme_wrapper').css({'margin-top': top_strip_height + 'px'});
            }
          }
          if (jQuery(window).width() <= 1200){
            var tab_bar_height = jQuery('.tab-bar').height();
            jQuery(document).ready(function(){
              resizeDiv();
            });
            window.onresize = function(event) {
              resizeDiv();
            }
            function resizeDiv() {
              var theHeight = jQuery(window).height() - tab_bar_height;
              jQuery('.map-sidebar,.content-sidebar').css({'height': theHeight + 'px'});
              jQuery('.supreme_wrapper').css({'margin-top': top_strip_height + 'px'});
            }
          }
       <?php  }
       // Login
      if($current_user->ID != ''  && (is_tax() || is_single() || is_archive() || is_search()))
        { ?>
            if (jQuery(window).width() >= 1200){
              var top_strip_height = jQuery('.header_strip').height() + 22;
              var adminbar_height = jQuery('#wpadminbar').height();
              var top_space = top_strip_height + adminbar_height;
              jQuery(document).ready(function(){
                resize_Div();
              });
              window.onresize = function(event) {
                resize_Div();
              }
              function resize_Div() {
                var theHeight = jQuery(window).height() - top_space;
                jQuery('.map-sidebar,.content-sidebar').css({'height': theHeight + 'px'/*,'margin-top': top_strip_height + 'px'*/});
                jQuery('.supreme_wrapper').css({'margin-top': top_space + 'px'});
              }
            }
            if (jQuery(window).width() <= 1200){
              var tab_bar_height = jQuery('.tab-bar').height() + 32;
              var adminbar_height = jQuery('#wpadminbar').height();
              jQuery(document).ready(function(){
                resizeDiv();
              });
              window.onresize = function(event) {
                resizeDiv();
              }
              function resizeDiv() {
                var theHeight = jQuery(window).height() - tab_bar_height;
                jQuery('.map-sidebar,.content-sidebar').css({'height': theHeight + 'px'});
                jQuery('.supreme_wrapper').css({'margin-top': 'top_strip_height' + 'px'});
              }
            }
      <?php  } ?>

      <?php global $current_user;
        // Logout
        if($current_user->ID == '' && (is_page() || isset($_REQUEST['ptype'])))
        { ?>
            if (jQuery(window).width() >= 1200)
            {
            var strip_height = jQuery('.header_strip,#wpadminbar').height() + 21;
            jQuery(document).ready(function(){
              resizeDiv_();
            });
            window.onresize = function(event) {
              resizeDiv();
            }
            function resizeDiv_() {
              jQuery('.supreme_wrapper').css({'margin-top': strip_height + 'px'});
            }
            }
            if (jQuery(window).width() <= 1200){
            var tab_bar_height = jQuery('.tab-bar').height();
            jQuery(document).ready(function(){
              resizeDiv();
            });
            window.onresize = function(event) {
              resizeDiv();
            }
            function resizeDiv() {
              jQuery('.supreme_wrapper').css({'margin-top': strip_height + 'px'});
            }
            }
        <?php  }

        // Login
        if($current_user->ID != '' && (is_page() || isset($_REQUEST['ptype'])))
        { ?>
            if (jQuery(window).width() >= 1200)
              {
                var strip_height = jQuery('.header_strip,#wpadminbar').height() + 53;
                jQuery(document).ready(function(){
                  resizeDiv_();
                });
                window.onresize = function(event) {
                  resizeDiv();
                }

                function resizeDiv_() {
                  jQuery('.supreme_wrapper').css({'margin-top': strip_height + 'px'});
                }
              }
              if (jQuery(window).width() <= 1200){
                var tab_bar_height = jQuery('.tab-bar').height();
                jQuery(document).ready(function(){
                  resizeDiv();
                });
                window.onresize = function(event) {
                  resizeDiv();
                }
                function resizeDiv() {
                  jQuery('.supreme_wrapper').css({'margin-top': strip_height + 'px'});
                }
              }
    <?php  } ?>
    // Hide Adminbar And Add logout Class for remove blank space
    <?php 
	$profile_id=get_option('tevolution_profile');
	if(!is_admin_bar_showing() || $post->ID == $profile_id){ ?>
        jQuery('body').addClass('logged-out');
    <?php } ?>
    

    });
</script>
</footer>
<!-- #footer -->

</div>
<?php do_action( 'after_footer' ); // supreme_after_footer
	wp_footer(); // wp_footer
	do_action('before_body_end',10); ?>

</body>
</html>