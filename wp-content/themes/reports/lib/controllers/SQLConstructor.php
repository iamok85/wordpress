<?php

 class SQLConstructor{
 	
	private $filters_groups=array();	
	private $field_list=array();
	private $all_field_list=array();
	private $default_field_options=array('operator'=>'=','search_type'=>'selector');	
	private $options=array('count'=>25);
	private $search_fields_data;
	private $main_search_model;
	private $main_model;
	private $table;
	private $external_table_list=array('ResultSearchTable','ResultDriverSearchTable');
	private $model_instance;
	private $join_str;
	private $join_select_str;
	public function SQLConstructor($main_search_model,$filters_groups=null,$options=null,$field_list=null,$all_field_list=null){
		
		$this->filters_groups=$filters_groups;
			
		$this->options=$options;
		
		$this->field_list=$field_list;
		
		$this->model_instance=new $main_search_model();		
		
		if(!isset($all_field_list)){
			
			
			$this->all_field_list=$model_instance->get_all_field_list();
			$this->table=$model_instance->get_table();
			$this->main_model=$model_instance->get_main_model();
			
		}else{
			
			$this->all_field_list=$all_field_list;	
		}
		
		$this->table=$this->model_instance->get_table();
		
		$this->main_model=$main_search_model;		
		$this->main_search_model=$main_search_model;
		
		$this->generate_config($this->default_field_options);
		$this->prePasrseFieldList();
	}
	
	public function prePasrseFieldList(){
		
		foreach($this->field_list as $one_field){
					
					
					if(is_array($one_field)){
						
						$one_field_keys=array_keys($one_field);
					
					if(!is_numeric($one_field_keys[0])){
						
					  	
						$keys=array_keys($one_field);																
						$this_field=$keys[0];
						

						if(isset($this->all_field_list[$this_field])){
							
							$field_setting=$this->all_field_list[$this_field];
							
							$relations=$this->model_instance->get_relations();
							if(isset($relations[$this_field])){
								
								$entity=$relations[$this_field][1];
							
								$join_fields=$relations[$this_field][2];
								
								if(in_array($entity,$this->external_table_list)){
									
									
									$join_str=$this->parseJoin($this_field,$relations[$this_field]);
									
									$this->join_str=$join_str;
									
									$field_list=$one_field[$this_field][0];
									
									debug($field_list);
									
									$right_model=$relations[$this_field][1];
			
									$right_table_instance=new $right_model();
									
									$join_select_str=$this->get_select($field_list,$right_table_instance->get_all_field_list());
									
									$this->join_select_str=$join_select_str;
									//debug($select_str);die;
									
								}	
							}
							
																														
					
						}
					
				}
					
				}
				
				
			}
		
	}
	
	private function parseJoin($this_field,$this_relation){
		
		$field_setting=$this->all_field_list[$this_field];
		
		$left_field=$this->main_model.'.'.$field_setting['column'];
		
		$right_model=$this_relation[1];
		$right_logic_field=$this_relation[2][0];
		
		$right_table_instance=new $right_model();
		
		
		
		$right_all_field_list=$right_table_instance->get_all_field_list();
	
		$join_str='Inner Join ';
		
		
		$right_data_field=$right_all_field_list[$right_logic_field]['column'];
		
		$right_data_table=$right_table_instance->get_table();
		
		$right_field=$right_model.'.'.$right_data_field;
		
		$join_str.=$right_data_table.' '.$right_model.' ';
		
		$join_str.=	'ON '.$left_field.' = '.$right_field;
		
		return $join_str;
		
	}
	
	public function get_table(){
		
		return $this->table;
		
	}
	public function get_main_model(){
		
			
		return $this->main_model;
		
	}
	public function generate_config($field_options){
			
			$search_fields_data=array();
			
			foreach($this->all_field_list as $field=>$the_field){
								
				
				$search_fields_data[$field]=array($this->main_model,$the_field['column'],$field_options);
								
			}
			$this->search_fields_data=$search_fields_data;
					
	}
	
	private function get_select($field_list,$all_field_list=array()){
		//debug($field_list);die;	
		

		if(empty($all_field_list)){
			
			$all_field_list=$this->all_field_list;			
		}
		
		$select_str="";
		
		foreach($field_list as $field){
			
			
		
			
			if(isset($field[0])&&!is_array($field[0])){
				
				if(isset($all_field_list[$field[0]])){
										
					$the_field=$all_field_list[$field[0]];
						
					 $model_class= $the_field['table'];

					 $select_str.=$model_class.'.'.$the_field['column'].' as '.$field[0].',';	
				}
					
				
			}else{
					
				$keys=array_keys($field);
				
				$field_name=$keys[0];
				
				if(isset($all_field_list[$field_name])){
									
					$the_field=$all_field_list[$field_name];
					
					 $model_class= $the_field['table'];

					//debug($field);die;
					$select_str.=$model_class.'.'.$the_field['column'].' as '.$keys[0].',';
				}
				
			}
									
		}
		
		if(!empty($this->join_select_str)){
			
			$select_str=$select_str.$this->join_select_str;
						
		}	
		
		$select_str=trim($select_str,',');
		
		if(empty($select_str)){
			
			return ' * ';
		}
		
	
		
		
		return $select_str;		
	}
	
	public function get_sql(){
		
		$select_str=$this->get_select($this->field_list);
		
		//error_log(print_r($this->filters_groups,true));die;
		
		$this_condtion=$this->get_conditions_by_filters($this->filters_groups);
		
		//debug($this_condtion);die;
				
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;	
		
		//error_log($paged."\n");
		
		if(!empty($this->options)){
			
			if(isset($this->options['count'])){
				
				$limit_str=' limit '.($this->options['count']*$paged).','.$this->options['count'];
			}
			
		}
		
		$model_class=new $this->main_search_model();
		
				
		
		$sql='select '.$select_str.' from '.$model_class->get_table().' '.$model_class->get_main_model().' '.$this->join_str.' where '.$this_condtion;
		
		if(isset($limit_str)){
			
			$sql=$sql.$limit_str;				
		}	
		

		
		//debug($sql);die;
		return $sql;
	}
	
		
	public function get_count_sql(){
		
		$model_class=new $this->main_search_model();
		
		$select_str=$this->get_select($this->field_list);
		
		$this_condtion=$this->get_conditions_by_filters($this->filters_groups);
		
		$sql='select count(*) as count from '.$model_class->get_table().' '.$this->main_model.' where '.$this_condtion;
		
		return $sql;
	}
	
	public function get_join_str($field_left,$field_right){
			
		$column=$this->all_field_list[$field_right]['column'];
				
		$field_right=$this->get_main_model().'.'.$column;
		
		$condition_str=$this->get_conditions_by_filters($this->filters_groups);																				
		$join_str='INNER JOIN '.$this->get_table().' '.$this->get_main_model().' ON '.$condition_str.' AND '.$field_left.'='.$field_right;
		
		return $join_str;
	}
	
	public function get_conditions_groups($filters_groups) {
		
		$conditions = array();
		
		$conditions_groups = array();	
		
		foreach ($filters_groups as $index => $filters) {
			try {
						
				$conditions = $this -> get_conditions($filters);
				
			} catch(Exception $e) {
				
			}
			array_push($conditions_groups, $conditions);
		}
		
		return $conditions_groups;
	}
	
	public function conditions_parse($conditions, $operator = 'AND') {
			
			$conditions_str = "";
			
			if (is_string($conditions)) {
					
				return $conditions_str = $conditions;
				
			} else if (is_array($conditions)) {
				
				$i = 0;
				
				foreach ($conditions as $key => $value) {
					
					if (is_string($key) && $key == 'OR') {
						
						if ($i < count($conditions) - 1) {
							
							$conditions_str .= '(' . $this -> conditions_parse($value, 'OR') . ') ' . $operator . ' ';
													
						} else {
							
							$conditions_str .= '' . $this -> conditions_parse($value, 'OR');
							
						}
					} else {
						if ($i < count($conditions) - 1) {
								
							$conditions_str .= '(' . $this -> conditions_parse($value, 'AND') . ') ' . $operator . ' ';
							
						} else
							$conditions_str .= $this -> conditions_parse($value, 'AND');
					}
					$i++;
				}
			}
			if (!empty($conditions_str))
			
				return $conditions_str;
			else
				return 'true';
	}


	public function get_conditions( $or_filters) {
				
				
			//error_log(print_r($or_filters,true));
	
			//array('resultSessFastestTime'=>array('label'=>'Session Fast Time','type'=>'text','table'=>'v8_results','column'=>'sess_fastest_time'));
			
			$conditions = array();			
			
			$condition_field = '';
			$conditions_models = array();
			$group_models = array();					
			$search_data_fields = $this->search_fields_data;															
			$condition_type = "AND";
			$addition_condition = array();
			foreach ($or_filters as $filters)
			
				foreach ($filters as $key => $value) {
					
					
					
					$data_type = $this->all_field_list[$key]['data_type'];
					//echo $data_type; 
					$operator = "";
					if (isset($search_data_fields[$key][2]['operator'])) {
						$operator = $search_data_fields[$key][2]['operator'];
					}								
					
					//error_log(print_r($search_data_fields[$key],true));
					if (isset($search_data_fields[$key])) {
						
					   //error_log(print_r($value,true));
						
						if (!is_array($value)) {
							$value = trim($value);
						}
					
						if ((!is_array($value) && $value != "ignore" && $value != "" && $value != "Restricted") OR (is_array($value) && !empty($value))) {
							$tmp_group = array();
						
							if (isset($search_data_fields[$key][2])) {
								if (isset($search_data_fields[$key][2]['delimeter'])) {
									$delimeter = $search_data_fields[$key][2]['delimeter'][0];
									$index = $search_data_fields[$key][2]['delimeter'][1];
									$parts = explode($delimeter, $value);
									$value = $parts[$index];
								}
								
								if (isset($search_data_fields[$key][2]['string_pro'])) {
									foreach ($search_data_fields[$key][2]['string_pro'] as $method => $string_val) {
										if ($method == "pre_add") {
											$value = $string_val . $value;
										}
									}
								}
							}
							if ($search_data_fields[$key][0] != 'group_value' && $search_data_fields[$key][0] != 'group_field') {
								$condition_field_name_list = array();
								$modelName = $search_data_fields[$key][0];
								if (is_array($search_data_fields[$key][1])) {
									$field1 = $search_data_fields[$key][1];
									if (isset($search_data_fields[$key][2]['join_str'])) {
										$join_str = $search_data_fields[$key][2]['join_str'];
										//debug($join_str);
									}
									if (isset($search_data_fields[$key][2]['condition_type'])) {
										$condition_type = $search_data_fields[$key][2]['condition_type'];
									}
									$field_str1 = '';
									foreach ($field1 as $ele) {
										$field_str1 = $modelName . '.' . $ele;
										array_push($condition_field_name_list, $field_str1);
									}
									if ($condition_type == "OR") {
										if (!isset($join_str))
											$link_str = '" "';
										else
											$link_str = $join_str;
										$field_str1 = '';
										foreach ($field1 as $ele) {
											$field_str1 .= $modelName . '.' . $ele . ',"' . $link_str . '",';
										}
										$field_str1 = trim($field_str1, ',"' . $link_str . '",');
										$field_str1 = 'CONCAT(' . $field_str1 . ') ';
										array_push($condition_field_name_list, $field_str1);
									}
									if (isset($join_str) && $condition_type == "AND")
										$value = explode($join_str, $value);
								} else {
									array_push($condition_field_name_list, $modelName . '.' . $search_data_fields[$key][1]);
								}
								$or_tmp_conditions = array($condition_type => array());
								$condition_index = 0;
						
								//debug($condition_field_name_list);
								foreach ($condition_field_name_list as $condition_field_name) {
									$tmp_conditions = array();
									//debug($search_fields_types);die;
									switch($search_data_fields[$key][2]['search_type']) {
										case 'selector' :										
											if ($value == 'Undefined') {
												if (strpos($data_type, 'numeric') !== false)
													$tmp_conditions = array($condition_field_name . ' LIKE "" OR ' . $condition_field_name . ' is NULL OR ' . $condition_field_name . '=0');
												else {
													$tmp_conditions = array($condition_field_name . ' LIKE "" OR ' . $condition_field_name . ' is NULL');
												}
											} else {
												if (is_array($value)) {
													if (!isset($join_str)) {
														
														  $new_value=array();
														
														if (strpos($data_type, 'numeric') !== false){
																														
															foreach($value as $ele){
															  		
															  	array_push($new_value,$ele);																
															}
															
															
														}else if(strpos($data_type, 'varchar') !== false){
																
															foreach($value as $ele){
															  		
															  	array_push($new_value,'"'.$ele.'"');																
															}	
															
														}														  
														
														  //$new_value=array_map('',$value);																  
														  array_push($tmp_conditions, $condition_field_name . ' in ' . '('.trim(implode(',', $new_value),',').')');
														
														
													} else {
														if (isset($value[$condition_index])) {
															if ($value[$condition_index] === "Undefined") {
																array_push($tmp_conditions, $condition_field_name . ' like "" OR ' . $condition_field_name . ' is NULL OR ' . $condition_field_name . '=0');
															} else {
																if ($value[$condition_index] == '!') {
																	$value[$condition_index] = substr($value[$condition_index], 1);
																	array_push($tmp_conditions, $condition_field_name . ' Not like "' . $value[$condition_index] . '"');
																} else {
																	if (empty($operator)) {
																		if (is_string($ele))
																			array_push($tmp_conditions, $condition_field_name . ' like "%' . $value[$condition_index] . '%"');
																		else if (is_int($ele)) {
																			array_push($tmp_conditions, $condition_field_name . ' = ' . $value[$condition_index] . '');
																		}
																	} else {
																		if (isset($search_data_fields[$key][2]['wildcard']))
																		
																			array_push($tmp_conditions, $condition_field_name . ' ' . $operator . ' "%' . $value[$condition_index] . '%"');
																		else
																			array_push($tmp_conditions, $condition_field_name . ' ' . $operator . ' "' . $value[$condition_index] . '"');
																	}
																}
															}
															//debug($tmp_conditions);
														}
													}
												} else {
													if ($value == '!') {
														$value = substr($value, 1);
														array_push($tmp_conditions, $condition_field_name . ' Not like "' . $value . '"');
													} else {
														if (empty($operator)) {
															if (is_string($value))
																array_push($tmp_conditions, $condition_field_name . ' like "%' . $value . '%"');
															else if (is_int($value)) {
																array_push($tmp_conditions, $condition_field_name . ' = ' . $value . '');
															}
														} else {
															if (isset($search_data_fields[$key][2]['wildcard']))
															
																array_push($tmp_conditions, $condition_field_name . ' ' . $operator . ' "%' . $value . '%"');
															else
																array_push($tmp_conditions, $condition_field_name . ' ' . $operator . ' "' . $value . '"');
														}
													}
												}
											}
											//debug($tmp_conditions);
											break;
										case 'date' :
																			
											switch($value['operator']) {
												case 'eq' :
													$value['operator'] = '=';
												case '>' :
												case'<' :
													if(!empty($value['value']))
														array_push($tmp_conditions, ' date('.$condition_field_name . ') ' . $value['operator'] . '"' . date('Y-m-d', strtotime($value['value'])) . '"');
													break;
												case 'be' :
													if(!empty($value['value1']))
														array_push($tmp_conditions, ' date('.$condition_field_name . ') >=' . '"' . date('Y-m-d', strtotime($value['value1'])) . '"');
													if(!empty($value['value2']))
														array_push($tmp_conditions, ' date('.$condition_field_name . ') <' . '"' . date('Y-m-d', strtotime($value['value2'])) . '"');
													break;
											}
											break;
									 	
									}
									if (!empty($tmp_conditions))
										array_push($or_tmp_conditions[$condition_type], $tmp_conditions);
									
									$condition_index++;
								}
							} else {
								foreach ($value['value'] as $sub_field) {
									$tmp_conditions = array();
									$sub_conditions_models = $this -> get_conditions( array(0 => $sub_field));
									$tmp_conditions_models = $conditions_models;
									foreach ($sub_conditions_models['conditions_models'] as $one_model_name => $conditions_array) {
										if (!isset($conditions_models[$one_model_name])) {
											$conditions_models[$one_model_name] = array();
										}
										array_push($conditions_models[$one_model_name], $conditions_array);
									}
								}
							}
							//		debug($or_tmp_conditions);
							if ($search_data_fields[$key][0] != 'group_value' && $search_data_fields[$key][0] != 'group_field') {
								if (count($or_tmp_conditions) > 0) {
									if (!isset($conditions_models[$modelName])) {
										$conditions_models[$modelName] = array();
									}
									//debug($or_tmp_conditions);
									array_push($conditions_models[$modelName], $or_tmp_conditions);
								}
							}
						}
					}
				}
			//
			//debug($conditions_models);die;
			return array('conditions_models' => $conditions_models);
		}
			
			
		public function get_conditions_by_filters($filters_groups) {
					
			$search_fields_data =$this->search_fields_data;
												 
			 									
			$conditions_groups=$this->get_conditions_groups($filters_groups);			
			
						
			$conditions['OR'] = array();
			
			$model_class=new $this->main_search_model();
			
			$relations = $model_class -> get_relations();

			foreach ($conditions_groups as $index => $con_flaw) {

				$one_conditions = array();
				$tmp_conditions = array();
				$one_group = array();
				if (isset($con_flaw['conditions_models'])) {
					foreach ($con_flaw['conditions_models'] as $con_model => $con_array) {
						$is_belongto = false;
						$is_hasmany = false;
						foreach ($relations as $rela_name => $rela_array) {
								
							$model_name=ucfirst($rela_array[1]);						
							if ($model_name == $con_model) {
								
								if ($rela_array[0] == 'belongs_to') {
									$is_belongto = true;
									
								} else if ($rela_array[0] == 'has_many') {
									
									$is_hasmany = true;
								}
								break;
							}
						}
						if (!$is_belongto && !$is_hasmany && $this->main_model != $con_model) {						
							array_push($tmp_conditions, $con_flaw['conditions_models'][$con_model]);		
						} else if ($this->main_model == $con_model) {
							array_push($tmp_conditions, $con_flaw['conditions_models'][$con_model]);
						} else {
							array_push($tmp_conditions, $con_array);							
						}
					}
				}
				if (!empty($tmp_conditions))
					array_push($conditions['OR'], $tmp_conditions);
			}
			
			//debug($conditions);die;
			$condition_str = "";
			if (!empty($this -> conditions_parse($conditions)))
				$condition_str = '(' . $this -> conditions_parse($conditions) . ')';
			//debug($condition_str);
			
		return $condition_str;
	}	
 }

?>