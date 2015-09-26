<?php 

namespace lib\controllers;
use lib\controllers\SearchPost;

class ReportsSearchPost extends SearchPost{
		
	var $post_type="reports";
		 
	protected  $all_field_list=array(
		'ID'=>array('label'=>'ID','data_type'=>'VARCHAR','type'=>'text','entity_type'=>'post','field_table_type'=>'post'),
		'reports_titles'=>array('label'=>'Title','data_type'=>'VARCHAR','type'=>'text','entity_type'=>'post','field_table_type'=>'post'),
		'reports_filters_groups'=>array('label'=>'Filters Groups','data_type'=>'VARCHAR','type'=>'text','entity_type'=>'post','field_table_type'=>'post_meta','validate'=>array('required'=>true)),			
		'reports_options'=>array('label'=>'Options','data_type'=>'VARCHAR','type'=>'text','entity_type'=>'post','field_table_type'=>'post_meta','validate'=>array('required'=>true)),					
	);
	
	private $default_field_list=array(
									array('reports_titles'),
									array('reports_filters_groups'),
									array('reports_options')
								);				
	

	private $default_conditions;
	private $default_options;
		
	public function __construct($search_title="",$field_list=null,$conditions_groups=null,$options=null){
		
	//debug(11111111111111111111111);
	$this->default_conditions=array(array(

		array('post','post_status','=','publish'),
		
		
		));
		
		$this->default_options=array('order by'=>array('ID','DESC'),'limit'=>'0,1000');
		
		$this->search_fields=array(array('ID'));
			
		
		if(!isset($conditions_groups)){
				
			$conditions_groups=$this->default_conditions;
		}
		
		if(!isset($field_list)){
				
			$field_list=$this->default_field_list;
		}
		
		if(!isset($options)){
				
			$options=$this->default_options;
		}			
		
		parent::__construct($search_title,'reports',$field_list,$conditions_groups,$options);					
		
	}
	
	public function get_relations(){
	
		
		$relations=array(							
			
		);
		return $relations;
	}
	
	
	public function generalSearch($values){
		
		
		$conditions=$this->generalSearchCondition($this->search_fields,$values);
		
		$condition_groups=$this->AndConditionOperator($conditions,$this->default_conditions);
				
		$this->condition_groups=$condition_groups;							
	}
	

	public function allFilter(){
						
		//$conditions=$this->generalSearchCondition(array(array('p','=')),$ids);		
				
		$this->default_conditions=array(array(

			array('post','post_status','=','publish'),
		
		
		));
		
		//$conditions=$this->AndConditionOperator($this->default_conditions,$conditions);
		
		$this->default_options=array('order by'=>array('ID','DESC'),'limit'=>'0,1000');
		
		//$this->search_fields=array(array('ID'));
			
		
		if(!isset($conditions_groups)){
				
			$conditions_groups=$this->default_conditions;
		}
		
		if(!isset($field_list)){
				
			$field_list=$this->default_field_list;
		}
		
		if(!isset($options)){
				
			$options=$this->default_options;
		}			
		
		//debug($conditions);			
		$this->condition_groups=$this->default_conditions;
		
		//$this->parseConditions($conditions);				
		//error_log(print_r($conditions,true));			
	}
		
	public function idFilter($ids=array()){
						
		$conditions=$this->generalSearchCondition(array(array('p','=')),$ids);		
				
		$this->default_conditions=array(array(

			array('post','post_status','=','publish'),
		
		
		));
		
		$conditions=$this->AndConditionOperator($this->default_conditions,$conditions);
		
		$this->default_options=array('order by'=>array('ID','DESC'),'limit'=>'0,1000');
		
		$this->search_fields=array(array('ID'));
			
		
		if(!isset($conditions_groups)){
				
			$conditions_groups=$this->default_conditions;
		}
		
		if(!isset($field_list)){
				
			$field_list=$this->default_field_list;
		}
		
		if(!isset($options)){
				
			$options=$this->default_options;
		}			
		
		//debug($conditions);			
		$this->condition_groups=$conditions;
		
		//$this->parseConditions($conditions);				
		//error_log(print_r($conditions,true));			
	}
	
}

?>