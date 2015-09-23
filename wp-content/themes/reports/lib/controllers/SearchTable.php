<?php 

class SearchTable{
		
	protected $table;
	
	protected  $all_field_list;
	
	protected $default_field_list;
											
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
	
  	protected $post_table=array("drivers","sessions");		
	
	public function SearchTable($filters_groups=null,$field_list=null,$options=null){
		
		
		$this->default_options=array('count'=>25);	
					
		
		
			
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
					
		
	}
	
		
	public function get_table(){
		
		return $this->table;
	}
	public function get_all_field_list(){
		
		return $this->all_field_list;
	}
	public function get_main_model(){
		
		return $this->main_model;
	}		

	
	public function get_total_count(){
		
			
		global $wpdb;
		
		$this->sql_constructor=new SQLConstructor($this->main_model,$this->filters_groups,$this->options,$this->field_list,$this->all_field_list);
		
		$count=$wpdb->get_results($this->sql_constructor->get_count_sql(),ARRAY_A);
			

		return $count[0]['count'];	
	}
	
	
	public function get_result_set(){
	
		
		$this->sql_constructor=new SQLConstructor($this->main_model,$this->filters_groups,$this->options,$this->field_list,$this->all_field_list);				
		
		$this->sql=$this->sql_constructor->get_sql();
			
		global $wpdb;
		
		//debug($this->sql);die;
		$records=$wpdb->get_results($this->sql,ARRAY_A);		
		
		//$records=$this->postParseFieldList($records);
		
		$this->result_set=$records;
		
		return $this->result_set; 
	}
	
	public function get_sql(){
		
		
		return $this->sql; 
	}
	
	public function debugHtml(){
		
		$this->get_result_set();
		$html_str='';
		
		if(!empty($this->result_set)){
			
			
			$records=$this->result_set;
		
			$headers=array_keys($records[0]);
			
			$html_str.='<table>';		
			$html_str.= '<tr>';
			foreach($headers as $head){
				
				$html_str.= '<th>'.$head.'</th>';
			}
			$html_str.= '</tr>';
			
			foreach($records as $record){
				$html_str.='<tr>';
				 foreach($record as $key=>$value){
				 	
					$html_str.= '<td>'.$value.'</td>';
				 }
				$html_str.= '</tr>';
			}
			$html_str.= '</table>';
			
		}		
			
		 return $html_str;
	}
	
	
	
	public function prePasrseFieldList($field_list){
		
		
	}
	public function postParseFieldList($records){
		
			
		  $join_str="";

			foreach($this->field_list as $one_field){
					
				
					if(is_array($one_field)){
						
					debug($one_field);	
					$one_field_keys=array_keys($one_field);
					//debug($one_field_keys);die;
					
					
					if(!is_numeric($one_field_keys[0])){
						
					  		 // 
		  
		 	
							  
					//	$keys=array_keys($one_field[0]);																
						$this_field=$one_field_keys[0];
						
				        
						if(isset($this->all_field_list[$this_field])){
							
														
							$field_setting=$this->all_field_list[$this_field];
							
							$relations=$this->get_relations();
							
							$entity=$relations[$this_field][1];
							
							$join_fields=$relations[$this_field][2];
														
							
	                        if(in_array($entity,$this->post_table)){
	                        	
	                        	$field_setting=$this->all_field_list[$this_field];
						
								$this_db_field=$field_setting['column'];																
								
								$i=0;
								$new_records=array();
								
								if(!empty($new_records)){
									
									$records=$new_records;
								}
								
								foreach($records as $record){																			
									if(isset($record[$this_db_field])){
										
										$parts=explode(' ', $record[$this_db_field]);
									
									$i=0;
									$one_group=array(array('post_status','=','publish'));
									
									foreach($join_fields as $field){
										
										array_push($one_group,array($field,'=',$parts[$i]));										
										
										$i++;
									}
									
									
									$field_list=$one_field[$this_field][0];
									
									$condition_groups=array($one_group);
									
									$instance_class=ucfirst($entity).'SearchPost';
												
									//debug($field_list);
									//debug($condition_groups);
									
									$searchpost=new $instance_class("",$field_list,$condition_groups,array('limit'=>'0,100'));
									
									$sub_records=$searchpost->get_result_set();
									//debug($this_field);
									
									$record[$this_field]=$sub_records;
									//debug($searchpost->request);
									//debug($sub_records);
									//$records[$i]=$record;
									$i++;
									array_push($new_records,$record);	
										
									}
										
									
								}

							
	                        }else{
	                        	
								
	                        }
	                        
	                       																			
											
			             
																	
						}
						
					}
						
					}
					
					
				}
	
		
		return $records;
	}
		
}

?>