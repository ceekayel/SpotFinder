<?php global $post,$tmpl_flds_varname;
$is_edit='';
if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
	$is_edit=1;
}
$tmpdata = get_option('templatic_settings');	
$googlemap_setting=get_option('city_googlemap_setting');
$special_offer=get_post_meta(get_the_ID(),'proprty_feature',true);
$video=get_post_meta(get_the_ID(),'video',true);
$facebook=get_post_meta(get_the_ID(),'facebook',true);
$google_plus=get_post_meta(get_the_ID(),'google_plus',true);
$twitter=get_post_meta(get_the_ID(),'twitter',true);
$listing_address=get_post_meta(get_the_ID(),'address',true);
if(function_exists('bdw_get_images_plugin'))
{
	$post_img = bdw_get_images_plugin(get_the_ID(),'directory-single-image');
	$postimg_thumbnail = bdw_get_images_plugin(get_the_ID(),'thumbnail');
	$more_listing_img = bdw_get_images_plugin(get_the_ID(),'directory-single-thumb');
	$thumb_img = @$post_img[0]['file'];
	$attachment_id = @$post_img[0]['id'];
	$image_attributes = wp_get_attachment_image_src( $attachment_id ,'large');
	$attach_data = get_post($attachment_id);
	$img_title = $attach_data->post_title;
	$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
}
?>
<script type="text/javascript">
jQuery(function() {
	jQuery('.listing-image a.listing_img').lightBox();
});
</script>

<?php
if(isset($post)){
	$post_img = bdw_get_images_plugin($post->ID,'thumb');
	$post_images = @$post_img[0]['file'];
	$title=urlencode($post->post_title);
	$url=urlencode(get_permalink($post->ID));
	$summary=urlencode(htmlspecialchars($post->post_content));
	$image=$post_images;
}
global $htmlvar_name;
?>

	 <ul class="tabs" data-tab role="tablist">
     <?php do_action('dir_before_tabs');
	        do_action('dir_start_tabs');
	             	        
			if($listing_address || $special_offer!="" || $video!=""):?>	
			<li class="tab-title active" role="presentational"><a href="#listing_description" role="tab" tabindex="0" aria-selected="false" controls="listing_description"><?php _e('Overview',TDOMAIN);?></a></li>

			<?php if(($special_offer!="" && $tmpl_flds_varname['proprty_feature']) || ($is_edit==1 && $tmpl_flds_varname['proprty_feature'])): ?>
				<li class="tab-title" role="presentational"><a href="#special_offer" role="tab" tabindex="0" aria-selected="false" controls="special_offer"><?php echo $tmpl_flds_varname['proprty_feature']['label'];?></a></li>
			<?php endif;

			if($video!="" && $tmpl_flds_varname['video'] || ($is_edit==1 && $tmpl_flds_varname['video'])):?>
				<li class="tab-title" role="presentational"><a href="#listing_video" role="tab" tabindex="0" aria-selected="false" controls="listing_video"><?php echo $tmpl_flds_varname['video']['label'];?></a></li>
			<?php endif;
			
			$event_for_listing = get_post_meta($post->ID,'event_for_listing',true);		
			/* Recurring Event  */
			if(!empty($event_for_listing))
			{
			  $event_for_list = explode(',',$event_for_listing);
			  $args = array( 'posts_per_page'   => -1,
					'offset'           => 0,
					'post_status'         => array('publish','private'),
					'orderby'          => 'meta_value',
					'order'            => 'ASC',
					'include'          => $event_for_list,
					'exclude'          => '',
					'post_type'        => 'event',
					'post_mime_type'   => '',
					'post_parent'      => '',
					'post_status'      => 'publish',
					'meta_query'      => array('relation' => 'OR',
										array('key'     => 'st_date',
										'value'   => date('Y-m-d'),
										'compare' => '>='),
										array('key'     => 'end_date',
										'value'   => date('Y-m-d'),
										'compare' => '>=')),
					'suppress_filters' => true );
					
				$events_list = get_posts($args); 
	
				if(!empty($events_list)){
				?><li class='tab-title'><a href="#listing_event"><?php _e('Events',TDOMAIN);?></a></li><?php
				}
			}
		  ?>
     <?php endif;
     
			do_action('dir_end_tabs');
	 ?>
			
     </ul>
<div class="tabs-content">  
	 <?php do_action('dir_after_tabs');
	 	add_action('wp_footer','add_single_slider_script');
		if(!function_exists('add_single_slider_script')){
		function add_single_slider_script()
		{
			$slider_more_listing_img = bdw_get_images_plugin(get_the_ID(),'directory-single-thumb');
			$supreme2_theme_settings = get_option(supreme_prefix().'_theme_settings');
			do_action('tmpl_before_single_slider');
			?>
			<script type="text/javascript">
				jQuery(window).load(function()
				{
					jQuery('#silde_gallery').flexslider({
						animation: "slide",
						<?php if(!empty($slider_more_listing_img) && count($slider_more_listing_img)>4):?>
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
						itemWidth: 60,
						itemMargin: 13,
						<?php if($supreme2_theme_settings['rtlcss'] ==1){ ?>
						rtl: true,
						<?php } ?>
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
						<?php if($supreme2_theme_settings['rtlcss'] ==1){ ?>
						,rtl: true,
						<?php } ?>
					});
				});
				//FlexSlider: Default Settings
			</script>
			<?php
		}
		}
	 ?>
     <!--Overview Section Start -->
     <section role="tabpanel" aria-hidden="false" class="content active" id="listing_description" class="clearfix">     
          <div class="entry-content frontend-entry-content <?php if($is_edit==1):?>editblock listing_content <?php endif; if(!$thumb_img):?>content_listing<?php else:?>listing_content <?php endif;?>">
     	<?php
			do_action('directory_before_post_content'); 
					the_content();
			do_action('directory_after_post_content'); 
		?>
          
        </div>        
       
			
     </section>
     <!--Overview Section End -->

     <?php if(($special_offer!="" && $tmpl_flds_varname['proprty_feature'] ) || ($is_edit==1 && $tmpl_flds_varname['proprty_feature']) ):?>
          <!--Special Offer Start -->
          <section role="tabpanel" aria-hidden="false" class="content" id="special_offer" class="clearfix">
               <div class="entry-proprty_feature frontend_proprty_feature <?php if($is_edit==1):?>editblock <?php endif;?>">
               <?php
			    $special_offer = apply_filters( 'the_content', $special_offer );
				$special_offer = str_replace( ']]>', ']]&gt;', $special_offer );
				echo $special_offer;
			   ?>
			   </div>
          </section>
          <!--Special Offer End -->
	<?php endif;
	
	if(($video!="" && $tmpl_flds_varname['video'] ) || ($is_edit==1 && $tmpl_flds_varname['video']) ):?>
        <!--Video Code Start -->
        <section role="tabpanel" aria-hidden="false" class="content" id="listing_video">        	
        	<?php if($is_edit==1):?>
            	<?php do_action('oembed_video_description');?>        		
        		<span id="frontend_edit_video" class="frontend_oembed_video button" ><?php _e('Edit Video',TDOMAIN);?></span>
        		<input type="hidden" class="frontend_video" name="frontend_edit_video" value='<?php echo $video;?>' />
        	<?php endif;?>
            <div class="frontend_edit_video"><?php             
            $embed_video= wp_oembed_get( $video);            
            if($embed_video!=""){
            	echo $embed_video;
            }else{
            	echo $video;
            }
            ?></div>
        </section>
        <!--Video code End -->
	<?php endif;
	do_action('listing_extra_details');
	
	if(is_single() && get_post_type()=='listing'){
	$event_for_listing = get_post_meta($post->ID,'event_for_listing',true);		
		/* Recurring Event  */
		if($event_for_listing !='')
		{
			if(!empty($events_list)){
		?>
          <!--Video Code Start -->
          <section role="tabpanel" aria-hidden="false" class="content" id="listing_event">
               <?php 
				foreach($events_list as $event_detail) { 
				if($event_detail->post_status =='publish' ){
				?>
			<div class="listed_events clearfix"> 
				<?php 
				  if ( has_post_thumbnail($event_detail->ID)){
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($event_detail->ID), 'tevolution_thumbnail' );
					$post_image=($thumb[0])? $thumb[0] :TEVOLUTION_DIRECTORY_URL.'images/noimage-150x150.jpg';
					
				  }else{
						$post_image = bdw_get_images_plugin($event_detail->ID,'tevolution_thumbnail');
						$post_image=($post_image[0]['file'])? $post_image[0]['file'] :TEVOLUTION_DIRECTORY_URL.'images/noimage-150x150.jpg';
				  } 
				
				$e_id = $event_detail->ID;
				$e_title = $event_detail->post_title;
				if(get_post_meta($e_id,'st_date',true) !='' && get_post_meta($e_id,'end_date',true) !='' ){
					$date = "<strong>".__('From',TDOMAIN)."</strong>".' '.get_post_meta($e_id,'st_date',true)." ".get_post_meta($e_id,'st_time',true)." <strong>".__('To',TDOMAIN)."</strong> ".get_post_meta($e_id,'end_date',true)." ".get_post_meta($e_id,'end_time',true);
				}elseif(get_post_meta($e_id,'st_date',true) !='' && get_post_meta($e_id,'end_date',true) =='' ){ 
					$date = "<strong>".__('From',TDOMAIN)."</strong>".' '.get_post_meta($e_id,'st_date',true)." ".get_post_meta($e_id,'st_time',true);
				} ?>
				<a class="event_img" href="<?php echo get_permalink($e_id); ?>"><img src="<?php echo $post_image; ?>" width="60" height="60" alt="<?php echo $e_title; ?>"/></a>
				<div class="event_detail">
					<a class="event_title" href="<?php echo get_permalink($e_id); ?>"><strong><?php echo $e_title; ?></strong></a><br/>
					<?php $address=get_post_meta($e_id,'address',true);
					$phone=get_post_meta($e_id,'phone',true);	
					$date_formate=get_option('date_format');
					$time_formate=get_option('time_format');
					$st_date=date($date_formate,strtotime(get_post_meta($e_id,'st_date',true)));
					$end_date=date($date_formate,strtotime(get_post_meta($e_id,'end_date',true)));
					
					$date=$st_date.' '. __('To',TDOMAIN).' '.$end_date;
					
					$st_time=date($time_formate,strtotime(get_post_meta($e_id,'st_time',true)));
					$end_time=date($time_formate,strtotime(get_post_meta($e_id,'end_time',true)));	
					if($address){
						echo '<p class="address" >'.$address.'</p>';
					}
					if($date)
					{
						echo '<p class="event_date"><strong>'.__('Date:',TDOMAIN).'&nbsp;</strong><span>'.$date.'</span></p>';
					}
					if($st_time || $end_time)
					{
						echo '<p class="time"><strong>'.__('Timing:',TDOMAIN).'&nbsp;</strong><span>'.$st_time.' '.__('To',TDOMAIN).' '.$end_time.'</span></p>';
					}?>
				</div>
			</div>  
			<?php } 
			} /* end froeach */
					?>
          </section>
          <!--Video code End -->
			
	<?php }
	} }?>
	
	
</div>
<?php
global $htmlvar_name,$heading_title;
$j=0;
if(!empty($htmlvar_name)){
	echo '<div class="listing_custom_field">';
	foreach($htmlvar_name as $key=>$value){
		$i=0;
		foreach($value as $k=>$val){			
			$heading_key = ($key=='basic_inf')? __('Listing Information',TDOMAIN): @$heading_title[$key];			
			if($k!='category' && $k!='post_title' && $k!='post_content' && $k!='post_excerpt' && $k!='post_images' && $k!='post_city_id' && $k!='listing_timing' && $k!='address' && $k!='listing_logo' && $k!='post_coupons' && $k!='video' && $k!='post_tags' && $k!='map_view' && $k!='proprty_feature' && $k!='phone' && $k!='email' && $k!='website' && $k!='twitter' && $k!='facebook' && $k!='google_plus' && $k!='contact_info')
			{	
				//display heading type
				$field= get_post_meta(get_the_ID(),$k,true);
				if($i==0 && $field!='' ){echo '<h2 class="custom_field_headding">'.$heading_key.'</h2>';$i++;}
				if($val['type'] == 'multicheckbox' &&  ($field!="" || $is_edit==1)):
				$checkbox_value = '';				
					$option_values = explode(",",$val['option_values']);				
					$option_titles = explode(",",$val['option_title']);
					for($i=0;$i<count($option_values);$i++){
						if(in_array($option_values[$i],$field)){
							if($option_titles[$i]!=""){
								$checkbox_value .= $option_titles[$i].',';
							}else{
								$checkbox_value .= $option_values[$i].',';
							}
						}
					}
				?>
     	<p class='<?php echo $k;?>'><label><?php echo $val['label']; ?>:&nbsp; </label> <span <?php if($is_edit==1):?>id="frontend_multicheckbox_<?php echo $k;?>" <?php endif;?> class="multicheckbox"><?php echo substr($checkbox_value,0,-1);?></span></p>

     <?php 
				elseif($val['type']=='radio' && ($field || $is_edit==1)):
					$option_values = explode(",",$val['option_values']);				
					$option_titles = explode(",",$val['option_title']);
					for($i=0;$i<count($option_values);$i++){
						if($field == $option_values[$i]){
							if($option_titles[$i]!=""){
								$rado_value = $option_titles[$i];
							}else{
								$rado_value = $option_values[$i];
							}
						?>
       <p class='<?php echo $k;?>'><label><?php echo $val['label']; ?>:&nbsp; </label><span <?php if($is_edit==1):?>id="frontend_radio_<?php echo $k;?>" <?php endif;?>><?php echo $rado_value;?></span></p>
       <?php
						}
					}
				elseif($val['type']=='oembed_video' && ($field || $is_edit==1)):?>
					<p class='<?php echo $val['style_class'];?>'><label><?php echo $val['label']; ?>:&nbsp;</label>
				 		<?php if($is_edit==1):?>					
                        <span id="frontend_edit_<?php echo $k;?>" class="frontend_oembed_video button" ><?php _e('Edit Video',TDOMAIN);?></span>
                        <input type="hidden" class="frontend_<?php echo $k;?>" name="frontend_edit_<?php echo $k;?>" value='<?php echo $field;?>' />
                        <?php endif;?>
					<span class="frontend_edit_<?php echo $k;?>"><?php             
					$embed_video= wp_oembed_get( $field);            
					if($embed_video!=""){
						echo $embed_video;
					}else{
						echo $field;
					}
					?></span></p>
				<?php	
				endif;
				if($val['type']  == 'upload' || ($is_edit==1 && $val['type']  == 'upload'))
				{
					 $upload_file=strtolower(substr(strrchr($field,'.'),1));					 
					 if($is_edit==1):?>
	                    <p class="<?php echo $val['style_class'];?>"><label><?php echo $val['label']; ?>: </label>
                            <span class="entry-header-<?php echo $k;?> span_uploader" >
                            <span style="display:none;" class="frontend_<?php echo $k;?>"><?php echo $field?></span>                            
                            <span id="fronted_upload_<?php echo $k;?>" class="frontend_uploader button"  data-src="<?php echo $field?>">	                 	
                            	<span><?php echo __( 'Upload File', ADMINDOMAIN ); ?></span>
                            </span>
                            </span>
                        </p>
					<?php elseif($upload_file=='jpg' || $upload_file=='jpeg' || $upload_file=='gif' || $upload_file=='png' || $upload_file=='jpg' ):?>
                    	<p class="<?php echo $val['style_class'];?>"><img src="<?php echo $field; ?>" /></p>
                    <?php else:?>
                    	<p class="<?php echo $val['style_class'];?>"><label><?php echo $val['label']; ?>: </label><a href="<?php echo $field; ?>" target="_blank"><?php echo basename($field); ?></a></p>
                    <?php endif;
				}
				if(($val['type'] != 'multicheckbox' && $val['type'] != 'radio' && $val['type']  != 'upload' && $val['type'] !='oembed_video') && ($field!='' || $is_edit==1)):	

					if($val['type'] =='date'){ ?>
						<p class='<?php echo $val['style_class'];?>'>
							<label><?php echo $val['label']; ?>:&nbsp;</label>
							
							<span <?php if($is_edit==1):?>id="frontend_<?php echo $val['type'].'_'.$k;?>" contenteditable="true" class="frontend_<?php echo $k;?>" <?php endif;?>>
								<?php echo date(get_option('date_format'),strtotime($field));?>
							</span>
							
						</p>
					
					<?php }else{
						?>
						<p class='<?php echo $val['style_class'];?>'>
							<label><?php echo $val['label']; ?>:&nbsp;</label>
							<?php if($val['type']=='texteditor'):?>
								<span <?php if($is_edit==1):?>id="frontend_<?php echo $val['type'].'_'.$k;?>" class="frontend_<?php echo $k; if($val['type']=='texteditor'){ echo ' editblock';} ?>" <?php endif;?>>
									<?php echo $field;?>
								</span>
							<?php else:?>
							<span <?php if($is_edit==1):?>id="frontend_<?php echo $val['type'].'_'.$k;?>" contenteditable="true" class="frontend_<?php echo $k;?>" <?php endif;?>>
								<?php echo $field;?>
							</span>
							<?php endif;?>
						</p>
				<?php }
				endif;
			}// End If condition
			
			$j++;
		}// End second foreach
	}// END First foreach
	echo '</div>';
}
?>
<div class="post-meta">    
	<?php 
		if( @$tmpl_flds_varname['category'] )
		{
			echo get_the_directory_taxonomies();
		}
	?>                          
     <?php echo get_the_directory_tag();?>
</div>

<!--Directory Social Media Coding Start -->
<?php if(function_exists('tevolution_socialmedia_sharelink')) 
		   tevolution_socialmedia_sharelink($post); ?>
<!--Directory Social Media Coding End -->

<?php
if(isset($tmpdata['templatic_view_counter']) && $tmpdata['templatic_view_counter']=='Yes')
{
	if(function_exists('view_counter_single_post')){
		view_counter_single_post(get_the_ID());
	}
	
	$post_visit_count=(get_post_meta(get_the_ID(),'viewed_count',true))? get_post_meta(get_the_ID(),'viewed_count',true): '0';
	$post_visit_daily_count=(get_post_meta(get_the_ID(),'viewed_count_daily',true))? get_post_meta(get_the_ID(),'viewed_count_daily',true): '0';
	$custom_content='';
	echo "<div class='view_counter'>";
	echo "<p>";
		_e('Visited',DIR_DOMAIN);
	echo " ".$post_visit_count." ";
		($post_visit_count == 1)?_e('time',DIR_DOMAIN):_e('times',DIR_DOMAIN);
	echo ', '.$post_visit_daily_count." ";
		($post_visit_daily_count == 1)?_e("Visit today",DIR_DOMAIN):_e("Visits today",DIR_DOMAIN);
	echo "</p>";
	echo '</div>';	
}
?>