<?php error_reporting(0);

global $theme_name;
$theme_name = basename(get_stylesheet_directory_uri());


if( !class_exists('WPUpdatesSpotFinderUpdater') ) {
    class WPUpdatesSpotFinderUpdater {
    
		var $api_url;		
		var $theme_slug;
		function supreme_child_clear_update_transient() {

			delete_transient( $theme_name.'-update' );
		}
		function __construct( $api_url,  $theme_slug ) {
			global $theme_name;
			$this->api_url = $api_url;    		
			$this->theme_slug = $theme_slug;
			if(is_multisite())
			{
				add_action( 'load-themes.php', 'wp_update_themes' );	
			}
			
			add_filter( 'pre_set_site_transient_update_themes', array(&$this, 'spotfinder_check_for_update_') );
			add_action( 'after_theme_row_'.$theme_name, array(&$this, 'spotfinder_child_theme_row') );
			// This is for testing only!
			//set_site_transient('update_themes', null);
			if(!strstr($_SERVER['REQUEST_URI'],'plugin-install.php') && !strstr($_SERVER['REQUEST_URI'],'update.php'))
			{
				add_filter( 'plugins_api_result', array(&$this, 'debug_result'), 10, 3 );
				add_action( 'load-update-core.php', array(&$this,'supreme_child_clear_update_transient') );
				add_action( 'load-themes.php', array(&$this, 'supreme_child_clear_update_transient') );
				if(!strstr($_SERVER['REQUEST_URI'],'/network/')){
					add_action( 'admin_notices', array(&$this, 'supreme_child_update_nag') );
				}
				delete_transient( $theme_name.'-update' );
			}
		}
    	
		function supreme_child_update_nag($transient) {
			global $theme_response,$wp_version;			
			
			$update_themes=get_option('_site_transient_update_themes');
			$theme_name = basename(get_stylesheet_directory());
    			$theme_data = templatic_get_theme_data(get_stylesheet_directory().'/style.css');			
			$theme_version = $theme_data['Version'];
			$remote_version = (!empty($update_themes) && $update_themes!="" && !empty($update_themes->response))?$update_themes->response[$theme_name]['new_version']:$theme_response[$theme_name]['new_version'];			
			//compare theme version				
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
				echo '<div id="update-nag">';
				 $new_version = version_compare($theme_version, $remote_version, '<') ? __('There is a new version of SpotFinder available.', ADMINDOMAIN) .' <a class="thickbox" title="spotfinder Forms" href="http://templatic.com/members/mydownloads/SpotFinder/theme/change_log.txt">'. sprintf(__('View version %s Details', ADMINDOMAIN), $remote_version) . '</a>. ' : '';		  			
			          $theme_name = basename(get_stylesheet_directory_uri());
					//$ajax_url = esc_url( add_query_arg( array( 'slug' => $theme_name, 'action' => $theme_name , '_ajax_nonce' => wp_create_nonce( $theme_name ), 'TB_iframe' => true ,'width'=>500,'height'=>400), admin_url( 'admin-ajax.php' ) ) );
					$ajax_url=site_url('/wp-admin/admin.php?page=child_tmpl_theme_update');
					$download= wp_nonce_url( self_admin_url('update.php?action=upgrade-theme&theme=').$theme_name, 'upgrade-theme_' . $theme_name);
					echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . $new_version .' '. __('or',ADMINDOMAIN).' <a href="'.$ajax_url.'" title="spotfinder Update">'.__('update now',ADMINDOMAIN).'</a></div></td>';
				echo '</div>';
			}

		}

	
		function spotfinder_check_for_update_( $transient ) {
			global $theme_response,$wp_version;
			/*Unset theme transient if same theme name also available in wordpress repository  */
			if(!empty($transient->response[$this->theme_slug]) && strpos($transient->response[$this->theme_slug]['url'],'wordpress.org') !== false){
				unset($transient->response[$this->theme_slug]);			
			}
			if (empty($transient->checked)) return $transient;
			
			$request_args = array(
				'slug' => $this->theme_slug,
				'version' => $transient->checked[$this->theme_slug]
				);
			$request_string = $this->prepare_request( 'templatic_theme_update', $request_args );
			$raw_response = wp_remote_post( $this->api_url, $request_string );			
			$response = null;
			if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) )
				$response = json_decode($raw_response['body']);
			
			if( !empty($response) ) {// Feed the update data into WP updater
				$transient->response[$this->theme_slug] = (array)$response; 
				$theme_response[$this->theme_slug] = (array)$response; 			
				update_option($this->theme_slug.'_theme_version',$theme_response);
			}	
			return $transient;
		}        
		
		
		/*
		 * add action for set the auto update for tevolution plugin
		 * Functio Name: spotfinder_plugin_row
		 * Return : Display the plugin new version update message
		 */
		function spotfinder_child_theme_row()
		{
			global $theme_response,$wp_version;			
			
			$update_themes=get_option('_site_transient_update_themes');
			$theme_name = basename(get_stylesheet_directory());
    		$theme_data = templatic_get_theme_data(get_stylesheet_directory().'/style.css');			
			$theme_version = $theme_data['Version'];
			$theme_name=$theme_data['Name'];
			$remote_version = (!empty($update_themes) && $update_themes!="")?$update_themes->response[$theme_name]['new_version']:$theme_response[$theme_name]['new_version'];			
			//compare theme version			
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
			   	echo '<div id="update-nag">';
				 $new_version = version_compare($theme_version, $remote_version, '<') ? __('There is a new version of spotfinder available.', ADMINDOMAIN) .' <a class="thickbox" title="spotfinder Forms" href="http://templatic.com/members/mydownloads/SpotFinder/theme/change_log.txt">'. sprintf(__('View version %s Details', ADMINDOMAIN), $remote_version) . '</a>. ' : '';		  			
			          $theme_name = basename(get_stylesheet_directory_uri());
					//$ajax_url = esc_url( add_query_arg( array( 'slug' => $theme_name, 'action' => $theme_name , '_ajax_nonce' => wp_create_nonce( $theme_name ), 'TB_iframe' => true ,'width'=>500,'height'=>400), admin_url( 'admin-ajax.php' ) ) );
					$ajax_url=site_url('/wp-admin/admin.php?page=child_tmpl_theme_update');
					$download= wp_nonce_url( self_admin_url('update.php?action=upgrade-theme&theme=').$theme_name, 'upgrade-theme_' . $theme_name);
					echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . $new_version . __( 'or',ADMINDOMAIN).' <a href="'.$ajax_url.'" title="SpotFinder Update">'.__('update now',ADMINDOMAIN).'</a></div></td>';
				echo '</div>';
	
			}
		}
		
		function prepare_request( $action, $args ) {
			global $wp_version;
			
			return array(
				'body' => array(
					'action' => $action, 
					'request' => serialize($args),
					'api-key' => md5(get_bloginfo('url'))
				),
				'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
			);	
		}//finish the prepare requst function

    }
}

?>