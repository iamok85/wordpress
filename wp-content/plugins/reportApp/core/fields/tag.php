<?php

class v8supercars_field_tag extends v8supercars_field
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
		$this->name = 'tag';
		$this->label = __("tag",'v8supercars');
		$this->category = __("Choice",'v8supercars');
		$this->defaults = array(
			'allow_null' 	=>	0,
			'default_value'	=>	''
		);
				
		// do not delete!
    	parent::__construct();
    	    	    	
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
	
	function create_field( $field )
	{
		// vars
		$optgroup = false;
		
		$field['name'] .= '[]';
		// determin if choices are grouped (2 levels of array)
		if( is_array($field['choices']) )
		{
			foreach( $field['choices'] as $k => $v )
			{
			
				$field['choices'][$v]=$v;
				
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
		foreach($field['value'] as $k=>$v){
							
			$field['choices'][$v]=$v;	
		}
		
		// trim value
		$field['value'] = array_map('trim', $field['value']);
		
		echo '<select style="width:500px" id="' . $field['id'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '"  >';

		if( is_array($field['choices']) )
		{
			foreach( $field['choices'] as $key => $value )
			{
								
				echo '<option value="'.$value.'" >'.$value.'</option>';
				
				error_log('<option value="'.$value.'" >'.$value.'</option>');
			}
		}
									
		echo '</select>';
		
		?>
												
				
			<script type="text/javascript">
			
			
				(function($) {												
					
					jQuery("select[name='<?=$field['name']?>']").select2({multiple:true,tags:true});
					
					temp=[];
					i=0;
					<?
				
						 if(!empty($field['value'])){
						 	
							foreach($field['value'] as $key=>$value){
								
								?>
					               item="<?echo $value?>";
					               
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
		
		do_action('v8supercars/create_field', array(
			'type'	=>	'select',
			'class' => 	'select field_option-post_type',
			'name'	=>	'fields['.$key.'][post_type]',
			'value'	=>	$field['post_type'],
			'choices' => array('Teams'=>"Teams","Drivers"=>"Drivers")
		));
		
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

new v8supercars_field_tag();

?>
