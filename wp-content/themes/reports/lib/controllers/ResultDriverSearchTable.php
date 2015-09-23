<?php 

class ResultDriverSearchTable extends SearchTable{
		
	protected $table="v8_results_adrivers";
	
	protected  $all_field_list=array(
	
		'ID'=>array('label'=>'ID','data_type'=>'numeric','table'=>'ResultDriverSearchTable','column'=>'id'),
		
		'resultID'=>array('label'=>'Session ID','data_type'=>'numeric','table'=>'ResultDriverSearchTable','column'=>'parentId'),
		
		'resultDriverID'=>array('label'=>'Driver ID','data_type'=>'numeric','table'=>'ResultDriverSearchTable','column'=>'data'),
				
	);
		
	protected $default_field_list=array('ID','resultID','resultDriverID');
											
	protected $default_conditions=array();
	protected $default_options;
	
	protected $search_fields_types;
	protected $search_fields_data;	
	protected $default_field_options;
	protected $main_model;
	protected $result_set;
	protected $total_count;
	protected $filters_groups=array();
	protected $field_list;	
	protected $sql_constructor;
	protected $custom_join_model_list=array();
	
	public function ResultDriverSearchTable($filters_groups=null,$field_list=null,$options=null){
		
		
		$this->default_options=array('count'=>25);	
					
		
		$this->main_model='ResultDriverSearchTable';
			
		if(!isset($filters_groups)){
				
			$this->filters_groups=$this->default_conditions;
			
		}else{
			
			$this->filters_groups=$filters_groups;
			
		}
		
		if(!isset($field_list)){
				
			$this->field_list=$this->default_field_list;
			
		}else{
			
			$this->field_list=$field_list;
		}
		
		if(!isset($options)){
				
			$this->options=$this->default_options;
			
		}else{
			
			$this->options=$options;
		}			
		
		parent::__construct($this->filters_groups,$this->field_list,$options);			
	
	//	$this->sql_constructor=new SQLConstructor('ResultSearchTable',$this->filters_groups,$this->options,$this->field_list,$this->all_field_list);
		
	}
	
				
	public function get_relations(){
			
		$relations=array(											
			'resultID'=>array('belongs_to','ResultSearchTable',array('ID'),array('ID')),			
			'resultDriverID'=>array('belongs_to','drivers',array('ID'),array('driverFirstName','driverLastName'))			
		);
		
		return $relations;
	}
	
		
		
}

?>