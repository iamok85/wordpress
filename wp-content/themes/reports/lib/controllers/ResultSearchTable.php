<?php 

class ResultSearchTable extends SearchTable{
		
	protected $table="v8_results";
	
	protected  $all_field_list=array(
		
		'ID'=>array('label'=>'ID','data_type'=>'numeric','table'=>'ResultSearchTable','column'=>'id'),
		'resultSessionID'=>array('label'=>'Session ID','data_type'=>'numeric','table'=>'ResultSearchTable','column'=>'session_id'),
		'resultSessFastestTime'=>array('label'=>'Session Fast Time','data_type'=>'varchar','table'=>'ResultSearchTable','column'=>'sess_fastest_time'),
		'resultSessLaps'=>array('label'=>'Session Laps','data_type'=>'numeric','table'=>'ResultSearchTable','column'=>'sess_laps'),
		'resultDriverString'=>array('label'=>'Driver','data_type'=>'varchar','table'=>'ResultSearchTable','column'=>'driverString'),
		'resultSessPosStart'=>array('label'=>'Start Position','data_type'=>'numeric','table'=>'ResultSearchTable','column'=>'sess_pos_start'),
		'resultSessPosEnd'=>array('label'=>'End Position','data_type'=>'numeric','table'=>'ResultSearchTable','column'=>'sess_pos_finish'),
		'resultSessRaceTime'=>array('label'=>'Race Time','data_type'=>'numeric','table'=>'ResultSearchTable','column'=>'sess_racetime'),
		'resultCarID'=>array('label'=>'Car ID','data_type'=>'varchar','table'=>'ResultSearchTable','column'=>'carID'),
		'resultTeamID'=>array('label'=>'Team ID','data_type'=>'varchar','table'=>'ResultSearchTable','column'=>'team_id'),
		'resultSessPoints'=>array('label'=>'Team ID','data_type'=>'varchar','table'=>'ResultSearchTable','column'=>'sess_points'),		
	);
		
	protected $default_field_list=array('resultSessFastestTime','resultSessLaps','resultDriverString','resultCarID','resultSessPosStart','resultSessPosEnd');
											
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
	public function ResultSearchTable($filters_groups=null,$field_list=null,$options=null){
				
		$this->default_options=array('count'=>25);						
		
		$this->main_model='ResultSearchTable';
			
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
		
	}
		
	public function get_relations(){
			
		$relations=array(	
												
			'resultSessionID'=>array('belongs_to','sessions',array('ID')),			
			'resultDriverString'=>array('belongs_to','drivers',array('driverFirstName','driverLastName')),
			'ID'=>array('has_many','ResultDriverSearchTable',array('resultID')),			
		);
		return $relations;
	}
	
	
	
	public function sessionIDFilter($ids=array()){
									
		$this->filters_groups=array(array(array('resultSessionID'=>$ids)));						
											

												
	}
	
	public function carNumberFilter($ids=array()){
							
		$this->filters_groups=array(array(array('resultCarID'=>$ids)));						
											
							
															
	}
	
	public function carIDFilter($ids=array()){
					
		$carsearch=new CarsSearchPost;
				
		$carsearch->idFilter($ids);
		
		$result_set=$carsearch->get_result_set();
			
		
		$new_ids=array();
		
		if(!empty($result_set)){
			
			foreach($result_set as $record){
			
				array_push($new_ids,$record['carNumber']);			
			}							
			
			$this->carNumberFilter($new_ids);			
		}
															
	}
	

	public function eventIDFilter($ids=array()){
	
		$session_search=new SessionsSearchPost;		
		
		$session_search->eventFilter($ids,array('ID'));
					
		$records=$session_search->get_result_set();
		
		$new_ids=array();
		
		foreach($records as $record){
			
			array_push($new_ids,$record['ID']);
		}
			
		//print_r($new_ids,true);	die;
		if(empty($new_ids))
			$new_ids=array(-1);
		
			$this->sessionIDFilter($new_ids);
	}

	public function seriesIDFilter($ids=array()){
	
		$session_search=new SessionsSearchPost;		
		
		$session_search->eventFilter($ids,array('ID'));
					
		$records=$session_search->get_result_set();
		
		$new_ids=array();
		//error_log(print_r($records,true));
		foreach($records as $record){
			
			array_push($new_ids,$record['ID']);
		}
			
		//print_r($new_ids,true);	die;
		$this->sessionIDFilter($new_ids);
	}

		
}

?>