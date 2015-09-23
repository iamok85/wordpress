<?php 

namespace lib\controllers;

class SearchPost extends \WP_Query{
	
	protected $post_type='';	
	protected $wp_args=array();
	protected $result_set=array();
	protected $field_list=array();
	protected $search_title;
	protected $search_fields=array();
	protected $start_index;
	protected $count_per_search;
	protected $total_count;
	protected $full_result_set=array();
	protected $options;
	protected $condition_groups;
	protected $custom_join_model_list=array();
	private $external_models=array('ResultSearchTable','ResultDriverSearchTable');
	public function __construct($search_title,$post_type,$field_list,$conditions_groups=array(),$options=array()){
		
		//wp_reset_query();
		
		$this->search_title=$search_title;

		$this->set_field_list($field_list);
		

		$this->post_type=$post_type;					
		$this->wp_args = array(	'post_type'	=> $post_type);
		
		$this->options=$options; 
		$this->parseOptions($options);
		$this->condition_groups=$conditions_groups;
		
	}
	
	public function get_total_count(){
				
		
		
		$save_options=$this->options;
		
		$this->options['limit']="";
		
		$this->parseOptions($this->options);		
				
		$result=$this->custom_query_count();
		
		$this->parseOptions($save_options);
					 		
		return $result;					  
		
	}
	
	
	public function get_result_set(){
		
		$this->result_set=array();
		
		$this->custom_query();
					
		return $this->result_set;
		
	}
	public function get_wp_args(){
		
		return $this->wp_args;
	}
	public function get_default_field_list(){
		
		return $this->default_field_list;
	}	
	

   public function get_field_list(){
   	
	 return $this->field_list;
   }
	public function custom_query_count(){
				
		
		$this->parseConditions($this->condition_groups);
				 					
		debug($this->wp_args);												
		$this->query($this->wp_args);
										
		return $this->post_count;
	}

	public function parseJoin(){
				
		  $join_str="";
		  
			foreach($this->field_list	as $one_field){
					
					if(!is_array($one_field[0])){
						
						
						if(isset($this->all_field_list[$one_field[0]])){
							
							$field_setting=$this->all_field_list[$one_field[0]];
														
							$entity_type="post";
							
							if(isset($field_setting['entity_type']))
								
									$entity_type=$field_setting['entity_type'];
							
									if($entity_type=="table"){
										
										
										$relations=$this->get_relations();																				
										$main_search_model=$relations[$one_field[0]][1];
										$filters_groups=$relations[$one_field[0]][4];
										$field_list=$relations[$one_field[0]][3];
										$join_field_right=$relations[$one_field[0]][2];
										
										 if(!in_array($main_search_model, $this->custom_join_model_list)){
											
											
											$sqlconstructor=new SQLConstructor($main_search_model,$filters_groups,$options=null,$field_list);
																		
											$join_str.= $sqlconstructor-> get_join_str('wp_posts.ID',$join_field_right).' ';
											
											array_push($this->custom_join_model_list,$main_search_model); 	
										 }
																																																			
									
									}																		
														
							
						}
						
					}
					
				}
	
		return $join_str;
	}

	function mam_posts_join ($join) {
		
		$join_Str=$this->parseJoin();
	   	$join .= " $join_Str";
	   
	   return $join;
	}
	
	public function custom_query(){
			
						
		$this->parseConditions($this->condition_groups);
		 			
		$sub_result_set=array();	

		//add_filter( 'get_meta_sql', 'filter_meta_query' );
		
		// debug($this->wp_args);
		$this->query($this->wp_args);
		// debug($this->request);
		// remove it after the query.
		//remove_filter( 'get_meta_sql', 'filter_meta_query' );
							
		//debug($this->have_posts());
		if($this->have_posts()) {
			 
			
			while($this->have_posts()) {
				  
				 $this->the_post();
				 
				 $post_id=get_the_id();
				 
				 $new_row=array();
				//debug($this->field_list);die;
				foreach($this->field_list	as $one_field){
					
	
					 $one_field_keys=array_keys($one_field);
					
					if(is_numeric($one_field_keys[0])){
						
						
						if(isset($this->all_field_list[$one_field[0]])){
							
							$field_setting=$this->all_field_list[$one_field[0]];
							
							//error_log(print_r($field_setting,true));die;
							$entity_type="post";
							
							if(isset($field_setting['entity_type'])){
								
								$entity_type=$field_setting['entity_type'];	
							}								
							
							if($entity_type=="post"){
																
								$new_row=$this->get_wp_fieldvalue($post_id,$one_field,$field_setting, $new_row);
									
							}else if($entity_type=="self_define"){
								
								switch($one_field[0]){
								
									case 'age':			
										if(isset($one_field[1])){
																				
											if(isset($new_row[$one_field[1]])){
												
												$age=$this->get_age($new_row[$one_field[1]]);
																																									
												$new_row[$one_field[0]]=$age;
											}																			
																	
										}
										break;
									case 'count_down':
										
										if(isset($one_field[1])){									
																		
											$new_row[$one_field[0]]="<div class='count_down'><input class='time_value' type='hidden' value='".$new_row[$one_field[1]]."'/></div>";						
										}		
										break;								
									
								}
									
							}
							else{
								
								$new_row=$this->get_exteneral_fieldvalue($post_id,$one_field,$field_setting, $new_row);
							}							
							
						}
						
					}else{
					
		
				
						$keys=array_keys($one_field);																
						$this_field=$keys[0];							
						$field_setting=$this->all_field_list[$this_field];													
						$entity_type="post";							
						if(isset($field_setting['entity_type']))
							$entity_type=$field_setting['entity_type'];
						
						 if($entity_type=="post"){
						 	
							$new_row=$this->wp_sub_search($one_field,$post_id,$new_row);
							 
						 }else{
						 	
							$new_row=$this->external_sub_search($one_field,$post_id,$new_row);
							
				
						 }
													
						
						
								  					
				}
					
				}
				array_push($sub_result_set,$new_row);
				
			}
		 }
		
		//debug($sub_result_set);
		
		$this->result_set=$sub_result_set;
		
		return $this->result_set;
	}
	
	
   private function external_sub_search($one_field,$post_id,$new_row){
   	
		
		$keys=array_keys($one_field);																
		$this_field=$keys[0];		
		$relations=$this->get_relations();
		$this_relation=$relations[$this_field];							
	//$result=get_post_meta($post_id,$this_field);
		
		$related_table=$this_relation[1];	
		$join_field=$this_relation[2][0];
		
		$filters_groups=array(array(array($join_field=>$post_id)));
				
		if(isset($one_field[$this_field])){
			
			$field_list=$one_field[$this_field][0];
			
		}else{
			
			$field_list=$relations[$this_field][3];
			
		}		
		
		if(isset($relations[$this_field][4])){
			
			$filters_groups=$this->AndConditionOperator($filters_groups, $this_relation[4]);
		}		
		
			//debug($related_table);die;
		$table=new $related_table($filters_groups,$field_list,array());
				
		$records=$table->get_result_set();
		 	
		$new_row[$this_field]=$records;													
						
		return $new_row;
		
	
   }	
   private function wp_sub_search($one_field,$post_id=-1,$new_row=array()){
   	
			 	$keys=array_keys($one_field);																
				$this_field=$keys[0];		
			    $relations=$this->get_relations();	
																						
				$post_type=$relations[$this_field][1];							
				$join_fields=$relations[$this_field][2];							
				
				$relation_type=$relations[$this_field][0];


				if($relation_type!="has_many"){
					
					$result=get_post_meta($post_id,$this_field);
													
					if(!empty($result)){
						
						//error_log(print_r($result,true));
															
						$sub_condition;
						
						if(isset($result[0])){
							
							$parts=explode(';', $result[0]);
							
							if(count($parts)==1)
								$sub_condition=$parts[0];
							else{
								
								$sub_condition=$parts;
							}								
						}
												
						else	
							
						$sub_condition="";	
						
						$values=array_values($one_field);
						
					
						
						$field_list=$values[0][0];
						
				
			
		
						if(isset($values[2])&&!empty($values[2])){
							
								
						}
						
	
						if($this->all_field_list[$keys[0]]['type']=="relationship"){
							
							$operator='in';
								
							$conditions=array(array(	
																							
								array('ID',$operator,$sub_condition,'')
																											
							));
				
							
						}else{
							
							
							
							foreach($join_fields as $one_join_field){
								
								$conditions=$this->generalSearchCondition(array(array($one_join_field,'=')),array($sub_condition));	
								
							}
																						
						}
						
						//debug($conditions);die;		
																											
						if(isset($values[2]))
							$options=$values[2];
						else
							$options=array('limit'=>'0,10');	
								
	
										
						$search_class=ucfirst($post_type).'SearchPost';
													
						$search_post=new $search_class('',$field_list,$conditions,$options);
						
						$sub_value=$search_post->get_result_set();
													
						$new_row[$keys[0]]=$sub_value;
	
						
					}else{
						
						$new_row[$keys[0]]='';
						
					}
					
				}else{
					
									
					// debug($post_id);
					// debug($this_field);
					// debug($relations[$this_field]);
					
						$this_relation=$relations[$this_field];
					
						$post_type=$this_relation[1];
					
						if(in_array($post_type,$this->external_models)){
							
					
							$new_row=$this->external_sub_search($one_field,$post_id,$new_row);
							
						}else{
							
							
							$join_fields=$this_relation[2];						
							$search_class=ucfirst($post_type).'SearchPost';							
							$sub_search_fields=array();							
							foreach($join_fields as $sub_one_field){
								
								array_push($sub_search_fields,array($sub_one_field));
								
							}
							$conditions=$this->generalSearchCondition($sub_search_fields,array($post_id));							
							$field_list=$one_field[$this_field][0];																										
							$search_post=new $search_class('',$field_list,$conditions,array('limit'=>'0,10000'));							
							$sub_result=$search_post->get_result_set();							
							$new_row[$this_field]=$sub_result;
								
						}
					
						
				}									
				
						
		return $new_row;
   }
   private function get_exteneral_fieldvalue($post_id,$one_field,$field_setting,$new_row){
   	
// 		
//               
			 $relations=$this->get_relations();
			 																				
			 $main_search_model=$relations[$one_field[0]][1];
			 if(isset($relations[$one_field[0]][4]))
			 	$filters_groups=$relations[$one_field[0]][4];
			 else
			 	$filters_groups=array();
			 
			 $field_list=$relations[$one_field[0]][3];
			 
			  $join_field_right=$relations[$one_field[0]][2][0];
// 			
              $filters_groups2=array(array(array($join_field_right=>$post_id)));
			  
			  $filters_groups=$this->AndConditionOperator($filters_groups, $filters_groups2);
			 
				$sqlconstructor=new SQLConstructor($main_search_model,$filters_groups,$options=null,$field_list);
				
				$sql=$sqlconstructor->get_sql();
				
				global $wpdb;
				$result=$wpdb->get_results($sql,ARRAY_A);
								
				$all_values=array();
				
				foreach($result as $one_record){
																
					array_push($all_values,$one_record);								
				}	
				
				
				$new_row[$one_field[0]]=$all_values;	
									

		return $new_row;
   }
   
   private function get_wp_fieldvalue($post_id,$one_field,$field_setting,$new_row){
   		
				$relations=$this->get_relations();
				
				if(!is_array($relations)){
					
					$instance_class=ucfirst($this->post_type).'SearchPost';			
					$searchpost=new $instance_class();			
					$relations=$searchpost->get_relations();	
					
				}	
				$field_table_type='post';
											
				if(!is_array($one_field[0])){
									
					if(isset($field_setting['field_table_type'])){
													
						$field_table_type=$field_setting['field_table_type']; 
					}
	
					switch($field_table_type){
						
						case 'post':
							
							$post = get_post( $post_id );							 																
							$new_row[$one_field[0]]=$post->$one_field[0];
																																								
							break;
						case 'post_meta':
													
							if(!is_array($one_field[0])){
																											
								$result=get_post_meta($post_id,$one_field[0]);	
																				
								if(isset($result[0])){
																																				
											
										if($this->all_field_list[$one_field[0]]['type']=="relationship"){
																							
											$relation_keys=array_keys($relations);
											
											if(!in_array($one_field[0],$relation_keys)){
																						
												$new_row[$one_field[0]]=$result[0];
																							
											}else{
												
												if(isset($one_field[1])){
														
													//debug($result[0]); 
													$new_row[$one_field[0]]=$result[0];
													
													
												}else{	
													$post_type=$relations[$one_field[0]][1];
													
													$related_fields=$relations[$one_field[0]][2];										
													
													$sub_ids=explode(';', $result[0]);
													
													$sub_ids=array_unique($sub_ids);																						
													
													$result_str='';
													
													foreach($sub_ids as $sub_id){
														
														$sub_result_str='';														
														
														if(count($related_fields)>1){
															
															$sub_result=$this->get_multi_meta_field_values($related_fields,$sub_id,$one_field[0]);
															
															//debug($sub_result);die;
																
														}else{
															
																																																		
															$sub_result=get_post_meta($sub_id,$related_fields[0]);
															
														}
																																																				
													}																												
													
													$new_row[$one_field[0]]=$sub_result;
												}
											}
												
										}else{
											
											$new_row[$one_field[0]]=$result[0];
											
										}																						
																													
																				
														
								}else	
									$new_row[$one_field[0]]="";		
								
							}
							
							 break;	 
				
					}

				}
	
		return $new_row;
   }
	
	
	protected function get_multi_meta_field_values($fields,$post_id,$field_name){
		
		if(!empty($post_id)){
			
			$post_type = get_post_type( $post_id );
			$select_str="select p.ID,CONCAT(";
			$join_str="";
			$where_str="p.post_status = 'publish' AND p.post_type = '$post_type' AND  p.ID=".$post_id.' AND ';
			$i=1;
			foreach($fields as $one_field){
			
				$select_str.="pm$i.meta_value,' ',";	
				$join_str.="INNER JOIN wp_postmeta pm$i ON p.ID=pm$i.post_id AND pm$i.meta_key='$one_field' ";
				$where_str.="pm$i.meta_key='$one_field' AND ";	
				$i++;
			}
			
			$select_str=trim($select_str,",' ',").') as '.$field_name;
				
	        $where_str=trim($where_str," AND ");
	        
			$query=$select_str.'  FROM wp_posts p '.$join_str.' where '.$where_str;
		    global $wpdb;
			$r = $wpdb->get_results($query,ARRAY_A);
			return $r;
			
		}else{
			//debug($field_name);die;
			return "";	
		}		
				
	}
	protected function get_age($datetime){
		

				
		$date1=date_create($datetime);
		$date2=date_create(date('Y-m-d h:m:s'));
		$diff=date_diff($date1,$date2);		
		$diff_value="";	
		if($diff->days==0){
			if($diff->h>1)
				$diff_value=$diff->h.' Hours ago';
			else
				$diff_value=$diff->h.' Hour ago';
				
		}else if($diff->days<=7){
			
			if($diff->days>1)	
				$diff_value=$diff->days.' Days ago';
			else
				$diff_value=$diff->days.' Day ago';
			
		}else{
			
		}

		return $diff_value;
	}
	
	public function  parseOptions($options){
		
		$this->options=$options;
		
		if(!empty($options)){
	

			foreach($options as $one_option_key=>$one_option_value){
				
				switch($one_option_key){
					
					case 'order by':												
						
						$field_table_type='post';						
						$field_setting=array();
						
						if(isset($this->all_field_list[$one_option_value[0]])){
							
							$field_setting=$this->all_field_list[$one_option_value[0]];														
							
							$field_table_type=$field_setting['field_table_type'];
						}						
						
						if($field_table_type=="post_meta"){
							
							
							if(!isset($field_setting['data_type'])){
								
								$field_type="VARCHAR";
								
							}else{
								
								$field_type=$field_setting['data_type'];
							}
								
							
								switch(strtoupper($field_type)){
									
									case 'DATETIME':																					
									$this->wp_args=array_merge($this->wp_args,array(
										'orderby'	=> 'meta_value_datetime',
										'meta_key' 	=> $one_option_value[0],
										'order'=>$one_option_value[1],
										
									));
									
									break;
									
									case 'NUMBER':
										
									$this->wp_args=array_merge($this->wp_args,array(
										'orderby'	=> 'meta_value_number',
										'meta_key' 	=> $one_option_value[0],
										'order'=>$one_option_value[1],										
									));
									break;
									
									default:
										
									if(!isset($one_option_value[1])){									
										$one_option_value[1]='DESC';												
									}
									$this->wp_args=array_merge($this->wp_args,array(
										'orderby'	=> 'meta_value',
										'meta_key' 	=> $one_option_value[0],
										'order'=>$one_option_value[1],										
									));
										
										break;
									
								}								
						
						}else if($field_table_type=="post"){
							
							if(!isset($field_setting['data_type'])){
								
								$field_type="VARCHAR";
							}else{
								
								$field_type=$field_setting['data_type'];
							}
							
							
							if(!isset($one_option_value[1])){
									
								$one_option_value[1]='DESC';
											
							}
							$this->wp_args=array_merge($this->wp_args,array(																								
									'orderby'	=> $one_option_value[0]	,							
									'order'=>$one_option_value[1],
									'type'	=>$field_type	
							));
						}
						
						
						break;
						
			
					
					case 'limit':				
						 
						   // error_log($one_option_value."\n");
						
							if(!empty($one_option_value)){
								
									$numbers=explode(',',$one_option_value);										
									$this->start_index=$numbers[0];
									$this->count_per_search=$numbers[1];
									$this->wp_args=array_merge($this->wp_args,array('offset' => $numbers[0],'posts_per_page' => $numbers[1]));						 						
							}else{
								
								$this->wp_args=array_merge($this->wp_args,array('offset' => 0,'posts_per_page' => 10000));
							}
							
						
						break;
						
				}
				
			}
		}
		
	}


	public function parseWPConditions($conditions_groups){
		
		$meta_query=array('relation' => 'OR');
		foreach($conditions_groups as $one_condition_group){
				

			
				
			$conditions_sub_str="";
			
			$meta_sub_query=array('relation' => 'AND');
			
			foreach($one_condition_group as $one_condition){
				
				
				$field_table_type='post';				
				$entity_type='post';			
				$field_setting=array();
				if(isset($this->all_field_list[$one_condition[0]])){
					
					$field_setting=$this->all_field_list[$one_condition[0]];										
					
					$field_table_type=$field_setting['field_table_type'];
					
					$entity_type=$field_setting['entity_type'];
					
				}									
				
				if($entity_type=="post"){
					
				
					 switch($field_table_type){
						 
						 case 'post':
						 	
					
						    switch($one_condition[0]){
						    	
								case 'Category':
									
									$condition_str='';
									
									if(is_array($one_condition[2])){
										
										$condition_str=trim(implode(',', $one_condition[2]),',');
										
									}else{
										
										$condition_str=$one_condition[2];	
									}
									
									$this->wp_args=array_merge($this->wp_args,array('category_name'=>$condition_str));
									
									break;
								case 'ID':
								case 'p':
									
									$condition_str='';
									
									if(is_array($one_condition[2])){
										
										$condition_str=trim(implode(',', $one_condition[2]),',');
										
									}else{
										
										$condition_str=$one_condition[2];	
									}
									
									
									if(!is_numeric($condition_str)){
											
										$condition_str=-1;
										
									}
									
									$this->wp_args=array_merge($this->wp_args,array('p'=>$condition_str));
										  
									break;
								case 'post_date':								  
									   
								    $this->wp_args=array_merge($this->wp_args,array(
								    		'date_query'=> array(
											        'column'  => 'post_date',
											         $one_condition[1]   => $one_condition[2]
									)));
									
									break;
									
								default:
									
									if(is_array($one_condition[2])){
									
										$condition_str=trim(implode(',', $one_condition[2]),',');
																
										$this->wp_args=array_merge($this->wp_args,array($one_condition[0]=> $condition_str));
										
									}else{
										
										$this->wp_args=array_merge($this->wp_args,array($one_condition[0]=> '"'.$one_condition[2].'"'));	
									}
									
									
									break;	
						    }
							
							
							break;
							
						 case 'post_meta_table':
						
							 
							 break;
						 case 'post_meta':
							 
							 
							 if(!is_array($one_condition[0])){
									
								if(!isset($field_setting['data_type'])){						
								
									$field_type="VARCHAR";
									
								}else{
									
									$field_type=$field_setting['data_type'];
									
								}
														
								if(!is_array($one_condition[2])){
									
									$condition=array('key'=>$one_condition[0],'value'=>$one_condition[2],'compare'=>$one_condition[1],'type'=>$field_type);
										
								}else{
									
									$condition=array('key'=>$one_condition[0],'value'=>$one_condition[2],'compare'=>'in','type'=>$field_type);
									
								}
								
								array_push($meta_sub_query,$condition);
								
								break;	
								
							}else{
								
								$this->parseMultiFieldCondition($one_condition);
								
							}	   				
							
					 }
				 }		 
				 
			}
			if(!empty($meta_sub_query)){
				
				array_push($meta_query,$meta_sub_query);
			}
				
		}

			
		$this->wp_args['meta_query']=$meta_query;
	}	

	public function parseMultiFieldCondition($one_condition){
		
		
		
		$concat_str="CONCAT(";
		$join_str="";
		$where_str="p.post_status = 'publish' AND p.post_type = '$post_type' AND  p.ID=".$post_id.' AND ';
		$i=1;
		foreach($fields as $one_field){
			
			if(in_array($one_field,$this->custom_join_field_list)){
				
				array_push($this->custom_join_field_list,$one_field);			
				$concat_str.="pm$i.meta_value,' ',";	
				$join_str.="INNER JOIN wp_postmeta pm$i ON p.ID=pm$i.post_id AND pm$i.meta_key='$one_field' ";
				$where_str.="pm$i.meta_key='$one_field' AND ";					
			}			
			$i++;
		}
		
		if(!empty($join_str)){
								
			$concat_str=trim($concat_str,",' ',").')';		
	        $where_str=$where_str.' AND '.$concat_str;
			$this->custom_query_join.=' '.$join_str;
			$this->custom_query_where.=' '.$where_str;
			
		}	
			
		
			
	}
	
	public function parseExternalTableConditions($conditions_groups){
	
				
		foreach($conditions_groups as $one_condition_group){
				
			$conditions_sub_str="";

			foreach($one_condition_group as $one_condition){
			
				$field_setting=array();	
				$entity_type='';		
				if(isset($this->all_field_list[$one_condition[0]])){
					
					$field_setting=$this->all_field_list[$one_condition[0]];										
					
					$field_table_type=$field_setting['field_table_type'];
					
					$entity_type=$field_setting['entity_type'];
					
				}									
				
				if($entity_type=="table"){
									
				 
				}			 
				 
			}
			
				
		}			
			
	}
	
	public function parseConditions($conditions_groups){
		
		$this->parseWPConditions($conditions_groups);
		//error_log(print_r($this->get_wp_args(),true));
		$this->parseExternalTableConditions($conditions_groups);
		
	}
	
	protected function AndConditionOperator($condition_group2, $condition_group1){
		
		$new_condition_group=array();
		
		//error_log(print_r($condition_group2,true));
		
		if(empty($condition_group1))
			return $condition_group2;
		
		if(empty($condition_group2))
			return $condition_group1;
		
		foreach($condition_group1 as $one_group1){
			
			
			$new_one_group=array();
			
			foreach($condition_group2 as $one_group2){
					
				//error_log(print_r($one_group2,true));
				
				$new_one_group=array_merge($one_group1,$one_group2);
				
				array_push($new_condition_group,$new_one_group);
			}
			
		}
		
		return $new_condition_group;
	}
	
	protected function OrConditionOperator($condition_group1,$condition_group2){
		
		
	}
	
	public function setTitle($title){
		
		$this->search_title=$title;
	}
	public function set_field_list($field_list){			
		
		$new_field_list=array();
		
		if(!empty($field_list)){
			
			foreach($field_list as $field){
				
				
				if(is_array($field)){
					
					array_push($new_field_list,$field);
		
				}else{
					 										
					array_push($new_field_list,array($field)); 									
					
				}				
				
			}
										
		}
		$this->field_list=$new_field_list;
		
	}
	
	
	
	public function pagination(){
		
		$count=V8_PAGE_SIZE;
		$this->count_per_search=$count;
		$this->wp_args['post_type']=$this->post_type;		
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;	
		$this->start_index=$count*$paged;			
		$this->wp_args=array_merge($this->wp_args,array('paged' =>$paged,'posts_per_page' => $count));								
							
	}
	
	
	protected function generalSearchCondition($search_fields,$values){
		
		//$search_fields=$this->search_fields;
		$new_values=array();
		
		if(is_array($values)){
			
			foreach($values as $sub_value){
			
				array_push($new_values,urldecode($sub_value));
			}
			
			$values=$new_values;
								
		}else{
			
			
			$values=urldecode($values);
		}		
	
		
		$condition_group=array();
		
		foreach($search_fields as $search_field){
			
			
			//debug($search_field);die;
				
			$sub_keys=array_keys($search_field);
			

			
				
			if(is_numeric($sub_keys[0])){


				if(is_array($values)){
																					
					$one_group=array();												
					array_push($one_group,array($search_field[0],'in',$values));												
					array_push($condition_group,$one_group);							
					// error_log(print_r($search_field,true));die;			
				}else{
					
					$one_group=array();						
						
					if(isset($search_field[1]))
						array_push($one_group,array($search_field[0],$search_field[1],$values));
					else
						array_push($one_group,array($search_field[0],'like',$values));
						
					array_push($condition_group,$one_group);					
				}			
				
			
			}else{
				
				//debug($search_field);die;
				$keys=array_keys($search_field);
				
				$this_field=$keys[0];
				
				$this_relation=$this->get_relations();
				
				
				$join_fields=$this_relation[$this_field][2];
				
				$post_type=$this_relation[$this_field][1];
				
				if(isset($search_field[0])){
					
					$field_list=$search_field[0];
						
				}else{
					
					$field_list=$join_fields;	
				}
				
				
				
				$sub_condition_groups=$this->generalSearchCondition(array($join_fields),$values);									
					
				
				debug($sub_condition_groups);
				$search_class=ucfirst($post_type)."SearchPost";
				
				$sub_search_instance=new $search_class('',$field_list,$sub_condition_groups,array('limit'=>'0,10'));
				
				
				
				$sub_result_set=$sub_search_instance->get_result_set();					
				//debug($sub_search_instance->request);
				$sub_values=array();
				foreach($sub_result_set as $one_sub_record){
					
					foreach($field_list as $one_sub_field){
						
						array_push($sub_values,$one_sub_record[$one_sub_field]);	
					}
					
				}
				
				$condition_group=$this->generalSearchCondition(array(array($this_field)),$sub_values);
			}			
			
		}
		return $condition_group;
	}
	
	public function debugHtmlResultSet(){
		
		$records=$this->get_result_set();

		$html_result=$this->printHtml($records);

		return $html_result;
	}
	
	protected function printHtml($records=array(),$sub=false){
		$html_result='';
		
	if(!empty($records)){
		if(is_array($records[0])){
			
			
			$records_key=array_keys($records[0]);		
		$html_result="";
		$html_result.="<div>";
		
		if(!$sub)
			$html_result.="<h4>".$this->search_title."</h4>";
		
		$html_result.="<table>";
		
		$html_result.="<tr><th>NO.</th>";		
		foreach($records_key as $one_record_key){
				
			if(isset($this->all_field_list[$one_record_key]))
			
				$header=$this->all_field_list[$one_record_key]['label'];
			else
				$header=$one_record_key;
			
			$html_result.="<th>".$header.'</th>';			
		}
		
		$html_result.="</tr>";	
	//	$html_result="";
		$i=0;
		foreach($records as $record){
			
			$html_result.="<tr>";	
			$html_result.="<td>".($i+1)."</td>";	
			
			foreach($record as $one_record_key=>$one_record_value){
				
				
				if(is_array($one_record_value)){
						 
						$html_result.='<td>'.$this->printHtml($one_record_value,true).'</td>';
						
						//error_log($this->printHtml($one_record_value)."\n");
				}else{
														
					if(strpos(strtolower($one_record_key),'image')||strpos(strtolower($one_record_key),'media')||strpos(strtolower($one_record_key),'thumbnail')){
						
						$html_result.="<td><img width='50px' height='50px' src='".$one_record_value."' /></td>";				
						
					}else if(strpos(strtolower($one_record_key),'source')) {
						
							
							if(is_numeric($one_record_value)){
								
									$video_str='<div style="margin-top:10px">
										<div style="display:none">
										</div>
										<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
										<object id="myExp" class="BrightcoveExperience">
										<param name="wmode" value="transparent" />
										<param name="bgcolor" value="#FFFFFF" />
										<param name="width" value="100" />
										<param name="height" value="100" />
										<param name="playerID" value="2183072329001" />
										<param name="playerKey" value="AQ~~,AAAB-0j8Ytk~,iRabUhLPo6EsRgWQQgA3g_giBsF81BLB" />
										<param name="autoStart" value="false">
										<param name="isVid" value="true" />
										<param name="isUI" value="true" />
										<param name="dynamicStreaming" value="true" />			
										<param name="@videoPlayer" value="'.$one_record_value.'" />
										<param name="includeAPI" value="true" />
										<param name="templateLoadHandler" value="onTemplateLoad" />
										<param name="templateReadyHandler" value="onTemplateReady" />
										</object>
										<script type="text/javascript">brightcove.createExperiences();</script>
										<!-- End of Brightcove Player -->
										</div>';
										
								$html_result.="<td>".$video_str.'</td>';	
								
							}else{
									
								$html_result.="<td>".wp_video_shortcode( array('width'=>"100px",'height'=>'100px',"src"=>$one_record_value)).'</td>';				
							}
						
					}else if($one_record_key=='ID'){
						
						$link=get_site_url()."/?post_id=".$one_record_value;
						
						
						$html_result.="<td><a href='".$link."'>Detail</a></td>";				
						
						
					}else {
							
						$html_result.="<td>".$one_record_value.'</td>';				
					}
				
				}
				
			}
			$html_result.="</tr>";	
			
			$i++;
		}
		}								
		
				
		$html_result.="</table>";
		$html_result.="</div>";
		}
			
		return $html_result;
	}


	protected static $instance;
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}
	
}

?>