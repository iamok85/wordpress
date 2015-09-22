<?php

class v8supercars_field_select extends v8supercars_field
{
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'select';
		$this->label = __("Select",'v8supercars');
		$this->category = __("Choice",'v8supercars');
		$this->defaults = array(
			'multiple' 		=>	0,
			'allow_null' 	=>	0,
			'choices'		=>	array(),
			'default_value'	=>	''
		);
				
		// do not delete!
    	parent::__construct();
    	
    	
    	// extra
		//add_filter('v8supercars/update_field/type=select', array($this, 'update_field'), 5, 2);
		add_filter('v8supercars/update_field/type=checkbox', array($this, 'update_field'), 5, 2);
		add_filter('v8supercars/update_field/type=radio', array($this, 'update_field'), 5, 2);
	}

	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	function create_field($field){
		
		if(isset($field['ajax'])&&$field['ajax']){
			
			$this->create_ajax_field($field);
		}else{
			$this->create_normal_field($field);
			
		}
	}
	function create_ajax_field( $field )
	{
		
		
		
		$choices=array();
		
		if(is_array($field['value'])){
			
			foreach($field['value'] as $one_value){
					
				//$one_value=urlencode($one_value);
				
															
				$choices[$one_value]=$one_value;
				
			}							
		}else{
				
			//$field['value']=urlencode($field['value']);		
			$choices[$field['value']]=$field['value'];						
		}
		
		
		$choices=array_filter($choices);		
				// vars
		$optgroup = false;
				
		// determin if choices are grouped (2 levels of array)
		if( is_array($choices) )
		{
			foreach( $choices as $k => $v )
			{
				if( is_array($v) )
				{
					$optgroup = true;
				}
			}
		}
		
		
		// value must be array
		if( !is_array($field['value']) )
		{
			// perhaps this is a default value with new lines in it?
			if( strpos($field['value'], "\n") !== false )
			{
				// found multiple lines, explode it
				$field['value'] = explode("\n", $field['value']);
			}
			else
			{
				$field['value'] = array( $field['value'] );
			}
		}
		
		
		// trim value
		$field['value'] = array_map('trim', $field['value']);
		
				
		if(isset($field['multi'])&&$field['multi'])
		{
			
			$field['name'] .= '[]';
		} 
		
		
		if(isset($field['required'])&&$field['required']){
			
			echo '<select style="width:'.$field['width'].'" required id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" >';
			
		}else{
		
			echo '<select style="width:'.$field['width'].'" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" >';	
		}								
		// null
		
		
	//	error_log(print_r($relation_data[0],true));
		if(!(isset($field['multi'])&&$field['multi']))
			echo '<option value="">- ' . __("Select",'v8supercars') . ' -</option>';		
		
		if( is_array($choices)&!empty($choices) )
		{
			foreach( $choices as $key => $value )
			{

					$selected = '';
					
					echo '<option value="'.$key.'" >'.$value.'</option>';	
			}
		}

		echo '</select>';
		
		?>
		
							
		<?if(isset($field['multi'])&&$field['multi']){?>			
			
			<script type="text/javascript">				

			(function($) {												
				
			
				jQuery("select[name='<?=$field['name']?>']").select2({
					
					multiple:true	,
						ajax: {
						    url: general.ajaxurl,
						    dataType: 'json',
						    method: "POST",	
						    placeholder:"Please Typeing",													    
						    data: function (params) {
						      return {
						        q: params.term, // search term														         
								action : "render_select_options",
								post_type : "<?=$field['post_type']?>",
								logic_field: "<?=$field['key']?>",
						      };
						     },
							 processResults: function (data, page) {
							 			
							 															 															 											
						      return {
						        
						        results: data
						        
						      };
						    },
						    cache: true
						  }													
					});
				
			
				temp=[];
				i=0;
				<?
			
					 if(!empty($choices)){
					 	
						foreach($choices as $key=>$value){
							
							?>
				               item="<?echo $key?>";
				               
				               temp[i]=item;
				               i++; 
							<?
							
						}	
					 }
				      
				?>
				
				if(temp.length>0){
																		
					jQuery("select[name='<?=$field['name']?>']").select2('val',temp);
						
				}
				
				
							
			})(jQuery);
			
			
					
		</script>

												
		<?}else{?>
			
			<script type="text/javascript">
		

			(function($) {	
				
								
				
				jQuery("select[name='<?=$field['name']?>']").select2({
					
					
						ajax: {
						    url: general.ajaxurl,
						    dataType: 'json',
						    method: "POST",
						    placeholder:"Please Typeing",														    
						    data: function (params) {
						      return {
						        q: params.term, // search term						         
								action : "render_select_options",
								post_type : "<?=$field['post_type']?>",
								logic_field: "<?=$field['key']?>",
						      };
						     },
							 processResults: function (data, page) {											
						      return {
						        results: data
						      };
						    },
						    cache: true
						  }
																
					
				});
				
				
				temp=[];
			
				<?	 if(!empty($choices)){
					 	
						foreach($choices as $key=>$value){
								
							?>
				               item="<?echo $key?>";
				       
							<?
							echo "temp.push(item);";
						}	
					 }
				      
				?>
				//console.log(temp);
				if(temp.length>0){
					
					jQuery("select[name='<?=$field['name']?>']").select2('val',temp);
						
				}
				
							
			})(jQuery);
			

					
		</script>

			
		<?}?>
										
		
	<?
	}
	
	function create_normal_field( $field )
	{
		// vars
		$optgroup = false;
		
		
		// determin if choices are grouped (2 levels of array)
		if( is_array($field['choices']) )
		{
			foreach( $field['choices'] as $k => $v )
			{
				
				$field['choices'][$k]=$v;				
				if( is_array($v) )
				{
					$optgroup = true;
				}
			}
		}
		
		//debug($field['choices']);
		// value must be array
		if( !is_array($field['value']) )
		{
			// perhaps this is a default value with new lines in it?
			if( strpos($field['value'], "\n") !== false )
			{
				// found multiple lines, explode it
				$field['value'] = explode("\n", $field['value']);
			}
			else
			{
				$field['value'] = array( $field['value'] );
			}
		}
		
		
		// trim value
		$field['value'] = array_map('trim', $field['value']);
		
		
		// multiple select
		$multiple = '';
		if(isset($field['multi'])&&$field['multi'] )
		{
						
			$field['name'] .= '[]';
		} 
		
		
		if(isset($field['required'])&&$field['required']){
			
			echo '<select style="width:'.$field['width'].'" required id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';
			
		}else{
		
			echo '<select style="width:'.$field['width'].'" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';	
		}				
						
		
		    $choice_values=array_keys($field['choices']);
			
			if(!(isset($field['multi'])&&$field['multi'] )){
				
				
				if(!in_array('Select',$choice_values)){
				
					echo '<option value="">- ' . __("Select",'v8supercars') . ' -</option>';
				}	
			}
			
			
		
		if( is_array($field['choices']) )
		{
			foreach( $field['choices'] as $key => $value )
			{
				if( $optgroup )
				{
					// this select is grouped with optgroup
					if($key != '') echo '<optgroup label="'.$key.'">';
					
					if( is_array($value) )
					{
						foreach($value as $id => $label)
						{
							$selected = in_array($id, $field['value']) ? 'selected="selected"' : '';
														
							echo '<option value="'.$id.'" '.$selected.'>'.$label.'</option>';
						}
					}
					
					if($key != '') echo '</optgroup>';
				}
				else
				{
					$selected = in_array($key, $field['value']) ? 'selected="selected"' : '';
					
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					//error_log('<option value="'.$key.'" '.$selected.'>'.$value.'</option>'."\n");
				}
			}
		}

		echo '</select>';
		
		?>
												
										<?if(isset($field['multi'])&&$field['multi']){?>
											
											
											<script type="text/javascript">
										
				
											(function($) {												
												
												jQuery("select[name='<?=$field['name']?>']").select2({multiple:true});
												
												//temp = jQuery("select[name='<?=$field['name']?>']").select2('val');
												temp=[];
												
												<?
												//	error_log(print_r($,true));
													 if(is_array($field['value'])){
													 	
														foreach($field['value'] as $item){
															
															//error_log("temp.push(".$item.");");
															echo "temp.push('".$item."');";
														}	
													 }
												      
												?>
												
												jQuery("select[name='<?=$field['name']?>']").select2('val',temp);
												
															
											})(jQuery);
											
											
													
										</script>
				
																				
										<?}else{?>
											
											<script type="text/javascript">
										
				
											(function($) {												
												
												jQuery("select[name='<?=$field['name']?>']").select2();
															
											})(jQuery);
											
											
													
										</script>
				
											
										<?}?>
										
		
	<?
	}

	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		$key = $field['name'];


		// implode choices so they work in a textarea
		if( is_array($field['choices']) )
		{		
			foreach( $field['choices'] as $k => $v )
			{
				$field['choices'][ $k ] = $k . ' : ' . $v;
			}
			$field['choices'] = implode("\n", $field['choices']);
		}

		?>
		
		
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label for=""><?php _e("Subject to entity",'v8supercars'); ?></label>
		<p><?php _e("Please select a post type.",'v8supercars'); ?></p>		
	</td>
	<td>
		<?php
		
		if(isset($field['post_type'])){
			
			do_action('v8supercars/create_field', array(
			'type'	=>	'select',
			'class' => 	'select field_option-post_type',
			'name'	=>	'fields['.$key.'][post_type]',
			'value'	=>	$field['post_type'],
			'choices' => array('Teams'=>"Teams","Drivers"=>"Drivers")
			));	
			
		}		
		
		?>
	</td>
</tr>
		
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label for=""><?php _e("Choices",'v8supercars'); ?></label>
		<p><?php _e("Enter each choice on a new line.",'v8supercars'); ?></p>
		<p><?php _e("For more control, you may specify both a value and label like this:",'v8supercars'); ?></p>
		<p><?php _e("red : Red",'v8supercars'); ?><br /><?php _e("blue : Blue",'v8supercars'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('v8supercars/create_field', array(
			'type'	=>	'textarea',
			'class' => 	'textarea field_option-choices',
			'name'	=>	'fields['.$key.'][choices]',
			'value'	=>	$field['choices'],
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Default Value",'v8supercars'); ?></label>
		<p class="description"><?php _e("Enter each default value on a new line",'v8supercars'); ?></p>
	</td>
	<td>
		<?php
		
		do_action('v8supercars/create_field', array(
			'type'	=>	'textarea',
			'name'	=>	'fields['.$key.'][default_value]',
			'value'	=>	$field['default_value'],
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Allow Null?",'v8supercars'); ?></label>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][allow_null]',
			'value'	=>	$field['allow_null'],
			'choices'	=>	array(
				1	=>	__("Yes",'v8supercars'),
				0	=>	__("No",'v8supercars'),
			),
			'layout'	=>	'horizontal',
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Select multiple values?",'v8supercars'); ?></label>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][multiple]',
			'value'	=>	$field['multiple'],
			'choices'	=>	array(
				1	=>	__("Yes",'v8supercars'),
				0	=>	__("No",'v8supercars'),
			),
			'layout'	=>	'horizontal',
		));
		?>
	</td>
</tr>
<?php
		
	}
	
	
	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/
	
	function format_value_for_api( $value, $post_id, $field )
	{
		if( $value == 'null' )
		{
			$value = false;
		}
		
		
		return $value;
	}
	
	
	/*
	*  update_field()
	*
	*  This filter is appied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = v8supercars)
	*
	*  @return	$field - the modified field
	*/

	function update_field( $field, $post_id )
	{
		
		// check if is array. Normal back end edit posts a textarea, but a user might use update_field from the front end
		if( is_array( $field['choices'] ))
		{
		    return $field;
		}

		
		// vars
		$new_choices = array();
		
		
		// explode choices from each line
		if( $field['choices'] )
		{
			// stripslashes ("")
			$field['choices'] = stripslashes_deep($field['choices']);
		
			if(strpos($field['choices'], "\n") !== false)
			{
				// found multiple lines, explode it
				$field['choices'] = explode("\n", $field['choices']);
			}
			else
			{
				// no multiple lines! 
				$field['choices'] = array($field['choices']);
			}
			
			
			// key => value
			foreach($field['choices'] as $choice)
			{
				if(strpos($choice, ' : ') !== false)
				{
					$choice = explode(' : ', $choice);
					$new_choices[ trim($choice[0]) ] = trim($choice[1]);
				}
				else
				{
					$new_choices[ trim($choice) ] = trim($choice);
				}
			}
		}
		
		
		// update choices
		$field['choices'] = $new_choices;
		
		
		return $field;
	}
	
}

new v8supercars_field_select();

?>
