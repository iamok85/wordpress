<?php

/*
*  reportApp_field
*
*  @description: This is the base class for entities
*  @since: 3.
*  @created: 30/01/13
*/
 
class entity
{
	/*
	*  Vars
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 30/01/13
	*/
	
	var $name,
		$title,
		$category,
		$defaults,
		$l10n;
	  protected $field_list;	
	
	/*
	*  __construct()
	*
	*  Adds neccessary Actions / Filters
	*
	*  @since	3.6
	*  @date	30/01/13
	*/
	
	function __construct()
	{
		// register field
		add_filter('reportApp/model/registered_fields', array($this, 'registered_fields'), 10, 1);
		//add_filter('reportApp/load_field_defaults/type=' . $this->name, array($this, 'load_field_defaults'), 10, 1);
		
		
		// value
		$this->add_filter('reportApp/model/load_value/type=' . $this->name, array($this, 'load_value'), 10, 3);
		$this->add_filter('reportApp/model/update_value/type=' . $this->name, array($this, 'update_value'), 10, 3);
		$this->add_filter('reportApp/model/format_value/type=' . $this->name, array($this, 'format_value'), 10, 3);
		$this->add_filter('reportApp/model/format_value_for_api/type=' . $this->name, array($this, 'format_value_for_api'), 10, 3);
		
		//error_log('registering reportApp/model/update_field/type='.$this->name);
		//$this->add_filter('reportApp/model/save_post/type=' . $this->name, array($this, 'save_post'), 5, 1);		

		//error_log('registering reportApp/model/load_field/type='.$this->name."\n");
		
		$this->add_filter('reportApp/model/load_field/type=' . $this->name, array($this, 'load_field'), 10, 2);		

		//error_log('registering reportApp/model/update_field/type='.$this->name."\n");
								
		$this->add_filter('reportApp/model/update_field/type=' . $this->name, array($this, 'update_field'), 10, 2);
				
		$this->add_action('reportApp/model/populate_fields/type=' . $this->name, array($this, 'populate_fields'), 10, 1);
		
		//error_log('reportApp/create_field/type=' . $this->name."\n");
		
		$this->add_action('reportApp/model/create_field_options/type=' . $this->name, array($this, 'create_options'), 10, 1);
		
		$this->add_filter('reportApp/input/admin_l10n', array($this, 'input_admin_l10n'), 10, 1);
		
	}
	
	
	/*
	*  add_filter
	*
	*  @description: checks if the function is_callable before adding the filter
	*  @since: 3.6
	*  @created: 30/01/13
	*/
	
	function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		if( is_callable($function_to_add) )
		{
			//error_log('registering reportApp/model/update_field/type='.$this->name."\n");
			add_filter($tag, $function_to_add, $priority, $accepted_args);
		}
	}
	
	
	/*
	*  add_action
	*
	*  @description: checks if the function is_callable before adding the action
	*  @since: 3.6
	*  @created: 30/01/13
	*/
	
	function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1)
	{
		if( is_callable($function_to_add) )
		{
			add_action($tag, $function_to_add, $priority, $accepted_args);
		}
	}
	
	
	/*
	*  registered_fields()
	*
	*  Adds this field to the select list when creating a new field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$fields	- the array of all registered fields
	*
	*  @return	$fields - the array of all registered fields
	*/
	
	function registered_fields( $fields )
	{
		// defaults
		if( !$this->category )
		{
			$this->category = __('Basic', 'reportApp');
		}
		
		
		// add to array
		$fields[ $this->category ][ $this->name ] = $this->label;
		
		//error_log(print_r($field_types,true));
		// return array
		return $fields;
	}
	
	
	/*
	*  load_field_defaults
	*
	*  action called when rendering the head of an admin screen. Used primarily for passing PHP to JS
	*
	*  @type	filer
	*  @date	1/06/13
	*
	*  @param	$field	{array}
	*  @return	$field	{array}
	*/
	
	function load_field_defaults( $field )
	{
		if( !empty($this->defaults) )
		{
			foreach( $this->defaults as $k => $v )
			{
				if( !isset($field[ $k ]) )
				{
					$field[ $k ] = $v;
				}
			}
		}
		
		return $field;
	}
	
	
	/*
	*  admin_l10n
	*
	*  filter is called to load all l10n text translations into the admin head script tag
	*
	*  @type	filer
	*  @date	1/06/13
	*
	*  @param	$field	{array}
	*  @return	$field	{array}
	*/
	
	function input_admin_l10n( $l10n )
	{
		if( !empty($this->l10n) )
		{
			$l10n[ $this->name ] = $this->l10n;
		}		
		return $l10n;
	}
		
	function validate($fields){
		
		$flag=true;
		//error_log("validating.......\n");
		foreach($this->field_list as $logicField=>$item){
			
			$validate=$item['validate'];
						
			if(isset($validate['required'])){
				
				if($validate['required']){
					
					if(empty($fields[$logicField])){
						
											
						$flag=false;
					}
					
				}
				
			}
			
		}		
		return $flag;
	}	



	
	function show_error($error_msg) {
        echo '<div class="error">
       <p>'.$error_msg.'</p>
       </div>';
    }
    
    function update_option($val) {
        update_option('display_my_admin_message', $val);
    }


    function add_plugin_notice() {
        
        	error_log("display message\n");     
              
            update_option('display_my_admin_message', 0);         
    }
	
	public function get_prefix(){
		
		return  $this->prefix;
	}
	
	function get_search_keyfield(){
		
		return $this->search_keyfield;
	}
	function get_title_field(){
		
		return $this->field_for_title;
	}
	function get_name_field(){
		
		return $this->field_for_name;
	}
	
}

?>