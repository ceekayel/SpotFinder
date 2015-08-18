<?php
/**
 * Event single custom post type template
 *
**/
get_header(); //Header Portation
	global $htmlvar_name,$tmpl_flds_varname;
$is_edit='';
if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
	$is_edit=1;
}
/* to get the common/context custom fields display by default with current post type */
if(function_exists('tmpl_single_page_default_custom_field')){
	$tmpl_flds_varname = tmpl_single_page_default_custom_field(CUSTOM_POST_TYPE_EVENT);
}
?>

<div class="map-sidebar">
    <!--Map Section Start -->
    <?php do_action('event_single_page_map') ?>
    <!--Map Section End -->
</div>

<div class="content-sidebar">
	<?php tmpl_back_link();
	do_action('event_before_container_breadcrumb'); /*do action for display the bradcrumb in between header and container. */ ?>
	
	<div id="content" role="main">	
		<?php do_action('event_inside_container_breadcrumb'); /*do action for display the bradcrumn  inside the container. */ ?>
		 
		<?php 
			if(function_exists('supreme_sidebar_before_content'))
				apply_filters('tmpl_before-content',supreme_sidebar_before_content() ); // Loads the sidebar-before-content.?>
		 
		<?php while ( have_posts() ) : the_post(); ?>
			<?php do_action('event_before_post_loop');?>
			  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
				<?php do_action('event_before_post_title');         /* do action for before the post title.*/ ?>
			  
				<!--start post type title -->
					<header class="entry-header">
					<div class="entry-header-title">
						  <h1 itemprop="name" class="entry-title <?php if($is_edit==1):?>frontend-entry-title <?php endif;?>" <?php if($is_edit==1):?> contenteditable="true"<?php endif;?>><?php the_title(); ?></h1>
						<?php					
						$tmpdata = get_option('templatic_settings');
						if($tmpdata['templatin_rating']=='yes'):
							$total=get_post_total_rating(get_the_ID());
							$total=($total=='')? 0: $total;
							$review_text=($total==1)? '<a href="#comments">'.$total.' '.__('Review',EDOMAIN).'</a>': '<a href="#comments">'.$total.' '.__('Reviews',EDOMAIN).'</a>';
						?>
								<div class="event_rating">
								<div class="event_rating_row"><span class="single_rating"> <?php echo draw_rating_star_plugin(get_post_average_rating(get_the_ID()));?> <span><?php echo $review_text?></span></span></div>
								  </div>
						<?php endif;
						do_action('event_display_rating',get_the_ID());
						
						?>
							 <div class="entry-header-custom-wrap">
							<?php do_action('event_date_display',get_the_ID());?>
							<?php do_action('directory_display_custom_fields_default'); ?>
							 </div>
						  </div>
				   </header>
				   
				<?php do_action('event_after_post_title');          /* do action for after the post title.*/?>
				   
				<?php do_action('event_user_attend');          /* do action for after the post title.*/?>              
				   
				   <div class="claim-post-wraper">
				<ul>
				<?php       if(function_exists('tevolution_dir_popupfrms')) tevolution_dir_popupfrms($post); // show sent to friend and send inquiry form popup
							 if(!isset($link)){ $link=''; } 
							 if(current_theme_supports('tevolution_my_favourites') && ($post->post_status == 'publish' || $post->post_status == 'recurring' )){
								global $current_user;
								$user_id = $current_user->ID;
								//$link.= eventmngr_favourite_html($user_id,$post);
							}
							 if(function_exists('add_to_my_calendar')){
								 add_to_my_calendar();
							 }
							 ?>                        
						</ul>
				   </div>
				  <!--end post type title -->
				
					 <!--Code start for single captcha -->
					 <?php 
						  $tmpdata = get_option('templatic_settings');
						  $display = (isset($tmpdata['user_verification_page']))?$tmpdata['user_verification_page']:array();
						  $captcha_set = array();
						  $captcha_dis = '';
						  if(!empty($display))
						   {
							   foreach($display as $_display)
								{
									if($_display == 'claim' || $_display == 'emaitofrd')
									 { 
										$captcha_set[] = $_display;
										$captcha_dis = $_display;
									 }
								}
						   }
						 $recaptcha = get_option("recaptcha_options");
					   global $current_user;
					 ?>
					   
					<div id="myrecap" style="display:none;"><?php if($recaptcha['show_in_comments']!= 1 || $current_user->ID != ''){ templ_captcha_integrate($captcha_dis); }?></div> 
					<input type="hidden" id="owner_frm" name="owner_frm" value=""  />
					<div id="claim_ship"></div>
					<script type="text/javascript">
					var RECAPTCHA_COMMENT = '';
						<?php
						
						if($recaptcha['show_in_comments']!= 1 || $current_user->ID != ''){ ?>
							jQuery('#owner_frm').val(jQuery('#myrecap').html());
					<?php 	} else{ ?> RECAPTCHA_COMMENT = <?php echo $recaptcha['show_in_comments']; ?>; <?php } ?>
					</script>
				
				<!--Code end for single captcha -->
					<!-- event content-->
				   <div class="entry-content">
				  
				   
				   <?php get_template_part( 'event-listing','single-content' ); ?>
				   
					
				   </div>
				   <!--Finish the listing Content -->
				  
					
				<!--Custom field collection do action -->
				<?php do_action('event_custom_fields_collection');  ?>
				   
				   <?php do_action('event_edit_link');?>
				</div>
				   <?php do_action('event_after_post_loop');?> 
		<?php endwhile; // end of the loop. ?>
		
		<?php wp_reset_query(); // reset the wp query?>
     
		<?php do_action('tmpl_single_post_pagination'); /* add action for display the next previous pagination */ ?>
        
        <?php do_action('tmpl_before_comments'); /* add action for display before the post comments. */ ?>
         
        <?php do_action( 'after_entry' ); ?>	
          
        <?php do_action( 'for_comments' );?>
         
        <?php do_action('tmpl_after_comments'); /*Add action for display after the post comments. */
        global $post;
    
        do_action('tmpl_related_events'); /*add action for display the related post list. */
         
                if(function_exists('supreme_sidebar_after_content'))
                apply_filters('tmpl_after-content',supreme_sidebar_after_content()); // afetr-content-sidebar use remove filter to dont display it ?>
		
	</div><!-- #content -->
</div>




<!-- end  content part-->
<?php get_footer(); ?>
