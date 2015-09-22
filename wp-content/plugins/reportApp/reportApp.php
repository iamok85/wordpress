<?php
/*
Plugin Name: reportApps
Plugin URI: http://www.reportApps.com.au/
Version: 1.0
Author: Dean Ding
License: GPLhttp://www.reportApps.com.au/
*/

if( !class_exists('reportApp') ):

class reportApp
{
	// vars
	var  $_settings;
	var $_scripts;
	var $_styles;	
	
	
	function __construct()
	{
	
		// vars
		//error_log("construct\n");
		add_filter('reportApp/helpers/get_path', array($this, 'helpers_get_path'), 1, 1);
		add_filter('reportApp/helpers/get_dir', array($this, 'helpers_get_dir'), 1, 1);
		
		$this->_settings = array(
			'path'				=> apply_filters('reportApp/helpers/get_path', __FILE__),
			'dir'				=> apply_filters('reportApp/helpers/get_dir', __FILE__),
			'hook'				=> basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ),
			'version'			=> '1.0',			
			'include_3rd_party'	=> false
		);					

		add_filter('reportApp/create_field', array($this, 'create_field'), 1, 1);
		add_filter('reportApp/get_info', array($this, 'get_info'), 1, 1);
		add_action('init', array($this, 'init'), 1);	
	}
	
	/*
	*  helpers_get_path
	*
	*  This function will calculate the path to a file
	*
	*  @type	function
	*  @date	30/01/13
	*  @since	3.6.0
	*
	*  @param	$file (file) a reference to the file
	*  @return	(string)
	*/
    
    function helpers_get_path( $file )
    {
        return trailingslashit(dirname($file));
    }
    
	function create_field($field){
		debug('reportApp/create_field/type='.$field['type']);
		do_action('reportApp/create_field/type='.$field['type'],$field);
		
	}
    
    /*
	*  helpers_get_dir
	*
	*  This function will calculate the directory (URL) to a file
	*
	*  @type	function
	*  @date	30/01/13
	*  @since	3.6.0
	*
	*  @param	$file (file) a reference to the file
	*  @return	(string)
	*/
    
    function helpers_get_dir( $file )
    {
        $dir = trailingslashit(dirname($file));
        $count = 0;
        
        
        // sanitize for Win32 installs
        $dir = str_replace('\\' ,'/', $dir); 
        
        
        // if file is in plugins folder
        $wp_plugin_dir = str_replace('\\' ,'/', WP_PLUGIN_DIR); 
        $dir = str_replace($wp_plugin_dir, plugins_url(), $dir, $count);
        
        
        if( $count < 1 )
        {
	        // if file is in wp-content folder
	        $wp_content_dir = str_replace('\\' ,'/', WP_CONTENT_DIR); 
	        $dir = str_replace($wp_content_dir, content_url(), $dir, $count);
        }
        
        
        if( $count < 1 )
        {
	        // if file is in ??? folder
	        $wp_dir = str_replace('\\' ,'/', ABSPATH); 
	        $dir = str_replace($wp_dir, site_url('/'), $dir);
        }
        

        return $dir;
    }

	/*
	*  get_info
	*
	*  This function will return a setting from the _settings array
	*
	*  @type	function
	*  @date	24/01/13
	*  @since	3.6.0
	*
	*  @param	$i (string) the setting to get
	*  @return	(mixed)
	*/
	
	function get_info( $i )
	{
		// vars
		$return = false;
		
		
		// specific
		if( isset($this->_settings[ $i ]) )
		{
			$return = $this->_settings[ $i ];
		}
		
		
		// all
		if( $i == 'all' )
		{
			$return = $this->_settings;
		}
		
		
		// return
		return $return;
	}
	

	/*
	*  include_before_theme
	*
	*  This function will include core files before the theme's functions.php file has been excecuted.
	*  
	*  @type	action (plugins_loaded)
	*  @date	3/09/13
	*  @since	4.3.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	function include_before_theme()
	{
	 
	 include_once('core/models/entity.php');
	 include_once('core/models/reports_entity.php');
	  include_once('core/controllers/controller.php');	
	  include_once('core/controllers/reports.php');
	  include_once('core/fields/_base.php');
	  include_once('core/fields/text.php');
	  include_once('core/fields/hidden.php'); 
	  include_once('core/models/_functions.php');
	    
	   
	}
	
	
	function include_after_theme() {
		
		// bail early if user has defined LITE_MODE as true
		if( defined('ACF_LITE') && ACF_LITE )
		{
			return;
		}
			
		
	}
	
	
	
	function init()
	{
			
		$labels = array(
		    'name' => __( 'V8', 'reportApp' ),
			'singular_name' => __( 'V8', 'reportApp' ),		   
		);
		
		register_post_type('reportApp', array(
			
			'labels' => $labels,
			'public' => false,
			'show_ui' => true,
			'_builtin' =>  false,
			'capability_type' => 'page',
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => "reportApp",
			'supports' => array(''				
			),
			'show_in_menu'	=> false,
		));
		
							
		
		$this->_scripts = array(
			'jquery-1.7.1' => $this->_settings['dir'] . "js/jquery-1.7.1.min.js",
			'jquery-ui-1.10.1' => $this->_settings['dir'].'js/jquery-ui-1.10.1.custom.min.js',
			'jquery.blockUI' =>$this->_settings['dir'] . "js/jquery.blockUI.js",
			'filter_instance'=> $this->_settings['dir'] . "js/filter_instance.js",
			'filters'=> $this->_settings['dir'] . "js/filters.js",
			'canvasjs'=>$this->_settings['dir'] . "js/canvasjs-1.6.0/canvasjs.min.js",
			'bootstrap'=>$this->_settings['dir'] ."js/bootstrap.min.js",
			'select2'=>$this->_settings['dir'] ."js/select2-4/select2.js",
			'reportApp'=>$this->_settings['dir'] ."js/reportApp.js",
			'search_options'=>$this->_settings['dir'] ."js/search_options.js",
			
		);
		  
		  //wp_enqueue_media();      	
			
		foreach( $this->_scripts as $k => $v )
		{
			wp_register_script( $k, $v, false, $this->_settings['version'] );
		}
		
		$this->_styles = array(
			'mycss'				=> $this->_settings['dir'] . 'css/mycss.css',
			'search2'				=> $this->_settings['dir'] . 'css/search2.css',
			'bootstrap'				=> $this->_settings['dir'] . 'css/bootstrap.min.css',
			'jquery-ui-1.10'        => $this->_settings['dir'].'css/jquery-ui-1.10.1.custom.min.css',
			'select2'        => $this->_settings['dir'].'css/select2-4/select2.css'
		);
		
		foreach( $this->_styles as $k => $v )
		{
			wp_register_style( $k, $v, false, $this->_settings['version'] ); 
		}
				
		// admin only
		if( is_admin() )
		{		
			add_action('admin_head', array($this,'admin_head'));
			add_action('admin_enqueue_scripts', array($this,'reportApp_admin_scripts'));						
		}
	
		$this->include_before_theme();
	}
	

	function reportApp_admin_scripts(){
	
        $scripts_handle=array_keys($this->_scripts);
	    $styles_handle=array_keys($this->_styles);	   	
		wp_enqueue_script($scripts_handle);				
		wp_enqueue_style($styles_handle);
						
	}	


	
	/*--------------------------------------------------------------------------------------
	*
	*	admin_head
	*
	*	@author Elliot Condon
	*	@since 1.0.0
	* 
	*-------------------------------------------------------------------------------------*/
	
	function admin_head()
	{
		
		//remove_menu_page('upload.php');
		//error_log(111);	
		add_menu_page(__("reportApp",'reportApp'), __("Report App",'reportApp'), '', 'edit.php?post_type=reportApp', false, false, '85.025');
		//add_submenu_page( 'edit.php?post_type=reportApp', 'Media', 'Media', 'manage_options', 'upload.php', FALSE);				
		$l10n = array(
			'move_to_trash'		=>	__("Move to trash. Are you sure?",'reportApp'),
			'checked'			=>	__("checked",'reportApp'),
			'no_fields'			=>	__("No toggle fields available",'reportApp'),			
			'copy'				=>	__("copy",'reportApp'),
			'or'				=>	__("or",'reportApp'),
			'fields'			=>	__("Fields",'acf'),
			'parent_fields'		=>	__("Parent fields",'reportApp'),
			'sibling_fields'	=>	__("Sibling fields",'reportApp'),
			'hide_show_all'		=>	__("Hide / Show All",'reportApp')
		);

	}	
}


function reportAppFun()
{
	global $reportApp;
	
	if( !isset($reportApp) )
	{
		$reportApp = new reportApp();
	}
	
	return $reportApp;
}


// initialize
reportAppFun();

endif; // class_exists check

?>