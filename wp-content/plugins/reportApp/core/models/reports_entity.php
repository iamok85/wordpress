<?php
include_once('entity.php');
class reports_entity extends entity
{
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	protected $prefix='report';
	private $prefix_label='report';
	
	private $post_type='reports';
		
	private $firstName;
	private $lastName;
	private $reportName;
	private $origins;
	private $reside;
	private $status;
	
	protected $search_keyfield="reports_titles";	
	protected $field_for_title=array('reports_titles');
	protected $field_for_name=array('reports_titles');
	
	 var $field_list=array(
	 		
	 		'reports_titles'=>array('label'=>'Report Title','type'=>'text','post_type'=>'reports'),
	 		'reports_sid'=>array('label'=>'Report ID', 'value'=>'','type'=>'text','post_type'=>'reports'),
			//'reports_sid'=>array('label'=>'Report ID','type'=>'text','post_type'=>'reports'),
			'reports_filters_groups'=>array('label'=>'Filters Groups','type'=>'hidden','post_type'=>'reports'),
			'reports_options'=>array('label'=>'Options','type'=>'hidden','post_type'=>'reports')			
		);
		
	
		
	function __construct()
	{
		// vars
		$this->name = 'reports';
		$this->label = __("reports",'reportApp');
		$this->category = __("reportApp");		
		$this->defaults = array(			
		);						
    	parent::__construct();  
	}
	
		public function relations(){
	
		$relations=array(		
					
		);
		return $relations;
	}
	public function get_field_list(){
		
		return $this->field_list;
	}		
	
}

new reports_entity();
//

//error_log("loadding report entity\n");

?>