<?php

class Reports extends Controller
{
	

	protected $post_setting=array();
	
	function __construct()
	{		
	
		$this->name = 'reports';
		$this->label = "Reports";														
		$this->entity=$this->name."_entity";	
		$this->labels=array(
		    'name' => __( $this->label, $this->name ),
			'singular_name' => __( $this->label, $this->name  ),
		    'add_Report' => __( 'Add Report' , $this->name ),
		    'add_Report_item' => __( 'Add a '.$this->label , $this->name  ),
		    'edit_item' =>  __( 'Edit a '.$this->label , $this->name  ),
		    'Report_item' => __( 'Report '.$this->label , $this->name  ),
		    'view_item' => __('View '.$this->label, $this->name ),
		    'search_items' => __('Search '.$this->label, $this->name ),
		    'not_found' =>  __('No '.$this->label.' found', $this->name ),
		    'not_found_in_trash' => __('No '.$this->label.' found in Trash', $this->name ), 
		);
		
			$this->post_setting= array(		
				'labels' => $this->labels,
				'public' => true,
				'show_ui' => true,
				'_builtin' =>  false,
				'capability_type' => 'page',
				'hierarchical' => false,
				'rewrite' => false,
				'query_var' =>$this->name,
				'supports' =>$this->supports ,
				'show_in_menu'	=> false
			
			);	
			
		$this->columns = array(	
		
			'reportsTitle' 	=> __("Title",'Reports'),
			'reportsEdit'=>__('Edit','Reports'),
			'reportsDelete'=>__('Trash','Reports')
			
		);
		
				
				
		$this->messages[$this->name] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __(' Detail updated.', 'reportApp'),
			2 => __(' Detail updated.', 'reportApp'),
			3 => __(' Detail deleted.', 'reportApp'),
			4 => __(' Detail updated.', 'reportApp'),			
			5 => isset($_GET['revision']) ? sprintf( __($this->label.' Detail restored to revision from %s', 'reportApp'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => __($this->label.' Detail published.', 'reportApp'),
			7 => __($this->label.' Detail saved.', 'reportApp'),
			8 => __($this->label.' Detail submitted.', 'reportApp'),
			9 => __($this->label.' Detail scheduled for.', 'reportApp'),
			10 => __($this->label.' Detail draft updated.', 'reportApp'),
		);
		parent::__construct();	
	}
	

	
	function custom_columns( $column, $post_id ) {		
		
		 //error_log($column,true);		
		  switch ( $column ) {
		  				
		  	case "reportsTitle":  			
				$this->output_column_value($column, $post_id);						 
		     break;
			case 'reportsEdit':
				echo '<a href="' . edit_post_link('Edit') . '"></a>';		  
				break; 
			case 'reportsDelete':
				echo '<a class="submitdelete" href="' . get_delete_post_link( $post_id ) . '">Trash</a>';
				break;	
			   
		  }
	}
	
	function html_fields()
	{
		
		global $post;
		

		$reports_instance=new reports_entity();		
		$reports_field_list=$reports_instance->get_field_list();
		//error_log(print_r($reports_field_list,true));		
		//$reports_field_list['post_type']=$this->name;
		$fields=array();
		foreach($reports_field_list as $field_key=>$field_data){
			
			$content=get_post_meta($post->ID,$field_key);
			if(isset($content[0]))
				$field_data['value']=$content[0];	
			
			$reports_field_list[$field_key]=$field_data;
		}		
		
		//error_log(print_r($fields,true));		
		
		
		$path = apply_filters('reportApp/get_info','path');
				
											
		include( $path. 'core/views/general_meta_box_fields.php' );
	}
	
}

new Reports();

?>
		


	
	