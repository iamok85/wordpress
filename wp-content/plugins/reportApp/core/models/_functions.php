<?php

/*
*  Field Functions
*
*  @description: The API for all fields
*  @since: 3.6
*  @created: 23/01/13
*/

class entity_functions
{
		
	var $search_keyword;
	var $post_type;	
	function __construct()
	{
		//value			
		// field
		//error_log("add filters\n");
			
		add_filter( 'posts_groupby', array($this,'my_posts_groupby') );
		//add_action( 'pre_get_posts', array($this,'my_pre_get_posts'));			
		add_filter('posts_where', array($this,'search_where'),10,2 );
		add_filter('posts_join', array($this,'plugin_join'));
		
		add_filter('v8supercars/model/load_field', array($this, 'load_field'), 5, 2);
		add_action('save_post', array($this, 'save_post'), 5, 2);		
		add_action('v8supercars/model/update_field', array($this, 'update_field'), 5, 2);
		add_action('v8supercars/model/delete_field', array($this, 'delete_field'), 5, 2);
		add_action('v8supercars/model/populate_fields', array($this, 'populate_fields'), 5, 1);
		
		//error_log("register v8supercars/model/get_choices\n");
		add_filter('v8supercars/model/get_choices', array($this, 'get_choices'), 5, 3);
		
		add_filter('v8supercars/model/get_choices_by_search_str', array($this, 'get_choices_by_search_str'), 5, 3);
		
				
		add_action('v8supercars/model/create_field_options', array($this, 'create_field_options'), 5, 1);
				
		// extra
		add_filter('v8supercars/model/update_field_defaults', array($this, 'load_field_defaults'), 5, 1);
		
		//error_log("register ajax wp_ajax_render_relation_options\n");
		
		add_action('wp_ajax_render_relation_options', array($this, 'ajax_render_options'));
		
		add_action('wp_ajax_render_select_options', array($this, 'ajax_render_select_options'));
		
		// add_filter('single_template', array($this,'my_custom_template'),10,1);
		// add_filter( "archive_template", array($this,"da_custom_post_type_template"));
		
	}
	
	function da_custom_post_type_template( $template ) {
	    global $wp_query;
		
	    if ($wp_query->post->post_type == 'include') {
	      $template = PLUGIN_PATH . '/template/custom_template.php';
	    }
	    return $template ;
	}

	function my_custom_template($single) {
	    global $wp_query, $post;	
	/* Checks for single template by post type */
		
		if ($post->post_type == "events"){
			die;
		}
	    return $single;
	}

function plugin_join($join) {
	
    global $wp_query, $wpdb;     
	 //$join
	 if ( is_admin()){
	 	
		if(strpos($join, 'wp_postmeta')===false){
			
			
			if (!empty($wp_query->query_vars['search_terms'])&&!isset($_GET['paged'])) {
			
				$join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";			
			
			}	
		}
				
	 }
	//error_log($join."\n");
    return $join;
}


	function my_posts_groupby($groupby) {
	    global $wpdb;
	    $groupby = "{$wpdb->posts}.ID";
	    return $groupby;
	}
	
	function search_where($where,$query){
	
		if ( is_admin()){
			
			$custom_search_model=array('tvschedules','events','drivers','teams','news','v8videos','jobs','circuits','sponsors','sessions');
			
						
			if(!empty($search_word)&&in_array($this->post_type,$custom_search_model)){
			
				$search_word="";			
				if(isset($query->query['s']))
	        		$search_word = $query->query['s'];  				
				$this->post_type=$query->query['post_type'];							
				$entity_class=$this->post_type.'_entity';
			    $entity=new $entity_class;	   
				$where=" and (wp_posts.post_type = '".$this->post_type."' AND ((wp_posts.post_status = 'publish' or wp_posts.post_status = 'future' or wp_posts.post_status = 'private')))";			
				$search_keyfield=$entity->get_search_keyfield();
				
				if(is_array($search_keyfield)){
					
					$i=0;
					$sub_where='';
					foreach($search_keyfield as $one_field){
					
						
						if($i==0){
							
							$sub_where.= "(wp_postmeta.meta_key = '".$one_field."' AND CAST(wp_postmeta.meta_value AS CHAR) LIKE '%$search_word%')";
								
						}else{
								
							$sub_where.= " or (wp_postmeta.meta_key = '".$one_field."' AND CAST(wp_postmeta.meta_value AS CHAR) LIKE '%$search_word%')";
						}
						
						
						$i++;	
					}
					
					//debug($sub_where);
					$where.= " and (".$sub_where.")";
						
				}else{
					   	   
				   	$where.= " and (wp_postmeta.meta_key = '".$search_keyfield."' AND CAST(wp_postmeta.meta_value AS CHAR) LIKE '%$search_word%')";
		
				}			
			} 

			// error_log("++++++++++++++++++\n");
			// error_log($this->post_type."\n");
			// error_log($where."\n");
			// error_log("++++++++++++++++++\n");
		}			 	  		
		return $where;
	}

	
	function save_post($post_id,$post)
	{
						
		// //die;		
		//do not save if this is an auto save routine
	
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		{
			return $post_id;
		}
		
		// only save once! WordPress save's a revision as well.
		if( wp_is_post_revision($post_id) )
		{
	    	return $post_id;
        }
				
		/*
		*  save fields
		*/	
		if( isset($_POST['fields']) && is_array($_POST['fields']) )
		{						
			foreach( $_POST['fields']['reports'] as $key => $field )
			{											
							
				//$field['post_type']=$_POST['fields']['post_type'];
				//debug($field);					
				update_post_meta( $post_id, $key, $field );
						
				$entity_class='reports_entity';					
				$entity =new $entity_class;		
				$name_field=$entity->get_name_field();
				$title_field=$entity->get_title_field();
				//debug($key.'==='.$name_field[0]);
				if($key==$name_field[0])
					$post->post_name= $field;
				if($key==$title_field[0])
					$post->post_title= $field;
				
			}	
			
		
		}	
		// remove_action('save_post', array($this,'save_post'), 5, 2);
// 		
// 		
 		// wp_update_post( $post );
// 		
		// add_action('save_post', array($this, 'save_post'), 5, 2);	
			
	    if ( 'trash' !== $post->post_status ) //adjust the condition
	    {
	    	remove_action('save_post', array($this,'save_post'), 5, 2);
								
				
			if(isset($_POST['save'])&&!empty($_POST['save'])){
	        	//$post->post_status = 'publish'; // use any post status
	        	
			}else{
														
				if(isset($_POST['original_publish'])&&$_POST['original_publish']=="Publish"){
					
					$post->post_status = 'publish';
				}		
															
			}	        		       
	        wp_update_post( $post );
			add_action('save_post', array($this, 'save_post'), 5, 2);	
	    }
// 		
	}
	
	
	
	
	function load_field($field,$post_id = false )
	{
		// apply filters
		//$field = apply_filters('v8supercars/model/update_field_defaults', $field);				
		// apply filters
		
			// run filters

		foreach($field as $logicField=>$field_data){
			
			
			if(isset($field_data['type'])&&$field_data['type']=='tag'){
				
				$field_values=apply_filters('v8supercars/model/get_choices',$field_data['post_type'],array($logicField));
				
			
									
				if(isset($field_values[$logicField])&&!empty($field_values[$logicField])){
					
					foreach($field_values[$logicField] as $one_value){
						
						$value_list=explode(';',$one_value);
						
						foreach($value_list as $element){
							
							$field[$logicField]['choices'][$element]=$element;	
						}
						
					}
				}
				
			}					
			
		}		
	
//		 error_log(print_r($field_values,true));
		 			
		if( isset($post_id))
		{
				// vars
				
				$entity_class=$field['post_type'].'_entity';
				
				$entity=new $entity_class;
				global $wpdb;
												
				$rows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE post_id = %d and meta_key like %s", $post_id,"%".$entity->get_prefix()."%"), ARRAY_A);
             					
				if( !empty($rows) )
				{
				    //error_log(print_r($rows,true));
					$new_rows=array();
					foreach($rows as $item){								
						//error_log("meta_key=".$item['meta_key']."\n");
						//error_log(strpos($item['meta_key'],$this->prefix));
						if(strpos($item['meta_key'],$entity->get_prefix())!==false){							
							//error_log($this->field_list[$item['meta_key']]['multi']."\n");
							$relations=$entity->relations();
							if(
							  isset($entity->field_list[$item['meta_key']])&&((
							  isset($entity->field_list[$item['meta_key']]['multi'])
							  &&$entity->field_list[$item['meta_key']]['multi']) 
									||(isset($relations[$item['meta_key']]))||isset($entity->field_list[$item['meta_key']]['type'])&&$entity->field_list[$item['meta_key']]['type']=="tag")){
								
								$new_value=explode(';',$item['meta_value'] );															
								$new_rows[$item['meta_key']]=$new_value;
								
							}else{
								 $meta_key=trim($item['meta_key']);
								$new_rows[$meta_key]=$item['meta_value'];	
							}
						}
																			
					}		
					//debug($new_rows);
					if(is_array($field)){
						$i=0;
						foreach($field as $item_logicfield=>$item_data){
							$item_logicfield=trim($item_logicfield);
							if(isset($new_rows[$item_logicfield])){
								$item_data['value']=$new_rows[$item_logicfield];
								$field[$item_logicfield]=$item_data;							
							}														
																						
						}						
						
					}						
														                   											
				}
		}					
			
		//debug($field);die;										
		wp_cache_set( 'load_field/key=' . $field['post_type'], $field, 'v8supercars' );
		
		return $field;
						
	}
	
	public function construct_condition($search_fields,$values){
		
	$condition_group=array();
		
	foreach($search_fields as $search_field){
		
		if(is_array($values)){
									
					foreach($values as $one_value){
							
						$one_group=array();
							
						if(isset($search_field[3])&&$search_field[3]=='wildcard'){
							$one_value='%'.$one_value.'%';
						}
						
						if(isset($search_field[2]))
							
							array_push($one_group,array($search_field[0],$search_field[1],$search_field[2],$one_value));
						else
							array_push($one_group,array($search_field[0],$search_field[1],'like',$one_value));
						
						array_push($condition_group,$one_group);	
						
					}			
				}else{
					
					$one_group=array();	
					if(isset($search_field[3])&&$search_field[3]=='wildcard'){
						$values='%'.$one_value.'%';
					}
						
					if(isset($search_field[2]))
							array_push($one_group,array($search_field[0],$search_field[1],$search_field[2],$values));
						else
							array_push($one_group,array($search_field[0],$search_field[1],'like',$values));
						
							array_push($condition_group,$one_group);					
				}	
			}
		return $condition_group;
	}
	

	public function ajax_render_select_options(){
				
		$post_type_str=$_POST['post_type'];
		
		//error_log($post_type);die;
		
		$logic_field=$_POST['logic_field'];
		
		if(isset($_POST['q']))
			$query=$_POST['q'];
		else
			$query='';
		
		$condition_group=$this->construct_condition(array(array('post_meta',$logic_field,'like')),array($query));
				
		$meta_query=$this->parseConditions($condition_group);
		
		
		$choices=$this->get_choices($post_type_str,array($logic_field),$meta_query);
			
	   
		header('Content-Type: application/json');		
	
		$output=array();
		
		if(isset($choices[$logic_field])){
			
			foreach($choices[$logic_field]  as $key=>$text){
			 
				array_push($output,array('id'=>$text,'text'=>$text));
			}
		
		echo json_encode($output);	
			
		}
		
		die;
	}


	public function ajax_render_options(){
				
		$post_type_str=$_POST['post_type'];
		
		//error_log($post_type);die;
		
		$logic_field=$_POST['logic_field'];
		
		if(isset($_POST['q']))
			$query=$_POST['q'];
		else
			$query='';
		
		$choices=$this->get_choices_by_search_str($post_type_str,$logic_field,$query);	
	
		header('Content-Type: application/json');
		
	
		$output=array();
					
		foreach($choices  as $key=>$text){
			 
			array_push($output,array('id'=>$key,'text'=>$text));
		}
		echo json_encode($output);
		die;
	}
	
	public function get_choices_by_search_str($post_type_str,$logic_field,$query){
		
		
				
		$choices=array();
		$entity_class=$post_type_str.'_entity';
		$entity=new $entity_class;
		 		
		$relations=$entity->relations();
		
		$relation_data=$relations[$logic_field];
				
		array_push($relation_data[2],'post_id');
		
		$condition_group=$this->construct_condition(array(array('post_meta',$relation_data[2][0],'like')),array($query));
		
		$meta_query=$this->parseConditions($condition_group);
		
		//error_log(print_r($meta_query,true));
		
		$field_values=$this->get_choices($relation_data[1],$relation_data[2],$meta_query);
			
			if(is_array($relation_data[2])){
			
				//error_log(print_r($field_values,true));			
				$i=0;
				if(isset($field_values[$relation_data[2][0]])){
					
				while($i<count($field_values[$relation_data[2][0]])){
					$one_value='';
					
					$post_id_index=count($relation_data[2])-1;
					
					foreach($relation_data[2] as $related_sub_field){
							
						if($related_sub_field!='post_id'){
							
							$one_value.=$field_values[$related_sub_field][$i].' ';
								
						}	
																		
					}													
					$one_value=trim($one_value);
										
					
					if(isset($field_values['post_id'][$i]))
						$choices[$field_values['post_id'][$i]]=$one_value;					
																		
					$i++;
				}
					
					
				}
												
		}
		
		return $choices;
	} 
	
	public function parseConditions($conditions_groups){
		
		$meta_query=array('relation' => 'OR');
		foreach($conditions_groups as $one_condition_group){
							
			$conditions_sub_str="";
			
			$meta_sub_query=array('relation' => 'AND');
			
			foreach($one_condition_group as $one_condition){

				
				 switch($one_condition[0]){
					 
					 case 'posts':
					 	
					    switch($one_condition[1]){
					    	
							case 'p':
								
								$this->wp_args=array_merge($this->wp_args,array('p'=>$one_condition[3]));
									  
								break;
							case 'post_date':								  
								   
							    $this->wp_args=array_merge($this->wp_args,array('date_query'=> array(
									        'column'  => 'post_date',
									         $one_condition[2]   => $one_condition[3]
									  )));
								//array_push($this->wp_args,$one_condition[1].' '.$one_condition[2].' "'.$one_condition[3].'"');
								break;
								
							default:
								$this->wp_args=array_merge($this->wp_args,array($one_condition[1]=> '"'.$one_condition[3].'"'));
								break;	
					    }
						
						
						break;
						
					 case 'post_meta_table':
					//array_push($this->wp_args,$one_condition[1].' '.$one_condition[2].' "'.intval($one_condition[3]).'"');
						 
						 break;
					 case 'post_meta':	
						
						if(!isset($one_condition[4])){						
							
							$type="VARCHAR";
						}else{
							
							$type=$one_condition[4];
							
						}
												
						$condition=array('key'=>$one_condition[1],'value'=>$one_condition[3],'compare'=>$one_condition[2],'type'=>$type);
						
						array_push($meta_sub_query,$condition);
						
						break;
						
				 }			 
				 
			}
			if(!empty($meta_sub_query)){
				
				array_push($meta_query,$meta_sub_query);
			}
				
		}
	

		return $meta_query;
		
	}				
	
	/*
	*  load_field_defaults
	*
	*  @description: applies default values to the field after it has been loaded
	*  @since 3.5.1
	*  @created: 14/10/12
	*/
	
	function get_choices($post_type,$field_list=array(),$meta_query=array()){
		
		//error_log('in_get_choices'."$post_type \n");
		
		
		$field_value=array();
				
		$args=array(
		  'post_type' => $post_type,
		  'posts_per_page'=>10,
		  'offset'=>0,
		  'status'=>'publish',
		    'meta_query' => $meta_query
		
		);
		
		$entity_class= $post_type.'_entity';		
		$entity=new $entity_class;		
		
		//error_log(print_r($args,TRUE));
		
		//error_log(print_r($field_list,TRUE));
		//error_log(print_r($conditions,TRUE));
		
		$my_query = null;
		$my_query = new WP_Query($args);
		
		//error_log($my_query->request."\n");
			//error_log($my_query->have_posts() );				
		if( $my_query->have_posts() ) {
		  while ($my_query->have_posts()) : $my_query->the_post();
			
			foreach($field_list as $one_field){
				
				if($one_field!='post_id'){
												
					$value=get_post_meta( get_the_ID(), $one_field);
										
					if(!isset($field_value[$one_field])){
						
						$field_value[$one_field]=array();
					}
									
					if($entity->field_list[$one_field]['type']=='tag'||(isset($entity->field_list[$one_field]['multi'])&&$entity->field_list[$one_field]['multi'])){
							
						//error_log(print_r($value,true));
							
						if(isset($value[0])&&!empty($value[0])){
													
							if(is_array($value[0])){
								
								foreach($value[0] as $one_value){
									
									$values=explode(';',$one_value);
																					
									$field_value[$one_field]=array_merge($field_value[$one_field],$values);	
								}
																	
							}else{
								
								$values=explode(';',$value[0]);																					
								$field_value[$one_field]=array_merge($field_value[$one_field],$values);
								
							}								
																											
						}						
							
					}else{
						
						if(isset($value[0])){
								
							if(!empty($value[0]))
								array_push($field_value[$one_field],$value[0]);
							
						}						
					}	
					
				}else{
					
					if(!isset($field_value[$one_field])){
						
						$field_value[$one_field]=array();
					}
					if(!empty(get_the_ID()))
						array_push($field_value[$one_field],get_the_ID());
				}
												
				
			}						
  				
  		  endwhile;
		}
		
		//error_log(print_r($field_value,true));		
		wp_reset_query();		
		
		$field_value=array_filter($field_value);
		
		
		return $field_value;
	}
	
	function load_field_defaults( $field )
	{
		// validate $field
		if( !is_array($field) )
		{
			$field = array();
		}
		
		
		// defaults
		$defaults = array(
			'key' => '',
			'label' => '',
			'name' => '',
			'_name' => '',
			'type' => 'text',
			'order_no' => 1,
			'instructions' => '',
			'required' => 0,
			'id' => '',
			'class' => '',
			'conditional_logic' => array(
				'status' => 0,
				'allorany' => 'all',
				'rules' => 0
			),
		);
		$field = array_merge($defaults, $field);
		
		
		// Parse Values
		$field = apply_filters( 'v8supercars/parse_types', $field );
		
		
		// field specific defaults
		$field = apply_filters('v8supercars/model/update_field_defaults/type=' . $field['type'] , $field);
				
		
		// class
		if( !$field['class'] )
		{
			$field['class'] = $field['type'];
		}
		
		
		// id
		if( !$field['id'] )
		{
			$id = $field['name'];
			$id = str_replace('][', '_', $id);
			$id = str_replace('fields[', '', $id);
			$id = str_replace('[', '-', $id); // location rules (select) does'nt have "fields[" in it
			$id = str_replace(']', '', $id);
			
			$field['id'] = 'v8supercars-field-' . $id;
		}
		
		
		// _name
		if( !$field['_name'] )
		{
			$field['_name'] = $field['name'];
		}
		
		
		// clean up conditional logic keys
		if( !empty($field['conditional_logic']['rules']) )
		{
			$field['conditional_logic']['rules'] = array_values($field['conditional_logic']['rules']);
		}
		
		
		// return
		return $field;
	}
	
	
	/*
	*  update_field
	*
	*  @description: updates a field in the database
	*  @since: 3.6
	*  @created: 24/01/13
	*/
	
	function update_field( $field, $post_id )
	{
		
		//error_log("post type============".$field['post_type']."\n");
		
		if(isset($field['post_type'])){
					
			//error_log("v8supercars/model/update_field/type=" . $field['post_type']."\n");	
			
			apply_filters('v8supercars/model/update_field/type=' . $field['post_type'], $field, $post_id ); // new filter
			//$field = apply_filters('v8supercars/model/update_field/type='.$field['type'], $field);
			
		}else{
			
			foreach($field as $element_key=>$element_value){			
			//error_log($post_id.' '.$element_key.' '.$element_value."\n");			
				update_post_meta( $post_id, $element_key, $element_value );	
			}	
			
		}		
		
		// foreach($field as $element_key=>$element_value){
		 	// $key1_values = get_post_custom_values($element_key, $post_id );
			// error_log(print_r($key1_values,true));
		// }
		// error_log(print_r($key1_values,true));
	}
	
	
	/*
	*  delete_field
	*
	*  @description: deletes a field in the database
	*  @since: 3.6
	*  @created: 24/01/13
	*/
	
	function delete_field( $post_id, $field_key )
	{
		// clear cache
		wp_cache_delete( 'load_field/key=' . $field_key, 'v8supercars' );
		
		
		// delete
		delete_post_meta($post_id, $field_key);
	}
	
	
	/*
	*  create_field
	*
	*  @description: renders a field into a HTML interface
	*  @since: 3.6
	*  @created: 23/01/13
	*/
	
	function populate_fields( $field )
	{
		// load defaults
		// if field was loaded from db, these default will already be appield
		// if field was written by hand, it may be missing keys
		$field = apply_filters('v8supercars/model/update_field_defaults', $field);
		
		
		// create field specific html
		//do_action('v8supercars/create_field/type=' . $field['type'], $field);
		
		//error_log("do_action ".'v8supercars/create_field/type=' . $field['type']."\n");
		
		
	}
	
	
	/*
	*  create_field_options
	*
	*  @description: renders a field into a HTML interface
	*  @since: 3.6
	*  @created: 23/01/13
	*/
	
	function create_field_options($field)
	{
		// load standard + field specific defaults
		$field = apply_filters('v8supercars/model/update_field_defaults', $field);
		
		// render HTML
		do_action('v8supercars/model/create_field_options/type=' . $field['type'], $field);
	}
	
}

new entity_functions();

?>