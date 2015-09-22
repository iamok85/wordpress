<?php

class reportApp_field_text extends reportApp_field
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
		$this->name = 'text';
		$this->label = __("Text",'reportApp');
		$this->defaults = array(
			'default_value'	=>	'',
			'formatting' 	=>	'html',
			'maxlength'		=>	'',
			'placeholder'	=>	'',
			'prepend'		=>	'',
			'append'		=>	''
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
		
	
		if(isset($field['integer'])&&$field['integer']){
						
			$field['class']=$field['class'].' number';
		}
		
		if(isset($field['url'])&&$field['url']){
						
			$field['class']=$field['class'].' url';
		}
		
		// vars
		$o = array( 'name', 'value', 'width' );
		$e = '';
		
		

		
	
		if(isset($field['required'])&&$field['required']){
			
			$e .= '<input required type="text"';
			
		}else{
		
			$e .= '<input  type="text"';	
		}
		
	
		
		 
		foreach( $o as $k )
		{
			$e .= ' ' . $k . '="' . esc_attr( $field[ $k ] ) . '"';	
		}
		
		$e .= ' />';
		$e .= '</div>';
		
		
		// return
		// return
		echo $e;
		
		if(isset($field['integer'])&&$field['integer'])
		{
			$name=$field['name'];		
		}
	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @param	$field	- an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_options( $field )
	{
		// vars
		$key = $field['name'];
		
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Default Value",'reportApp'); ?></label>
		<p><?php _e("Appears when creating a new post",'reportApp') ?></p>
	</td>
	<td>
		<?php 
		do_action('reportApp/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][default_value]',
			'value'	=>	$field['default_value'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Placeholder Text",'reportApp'); ?></label>
		<p><?php _e("Appears within the input",'reportApp') ?></p>
	</td>
	<td>
		<?php 
		do_action('reportApp/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][placeholder]',
			'value'	=>	$field['placeholder'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Prepend",'reportApp'); ?></label>
		<p><?php _e("Appears before the input",'reportApp') ?></p>
	</td>
	<td>
		<?php 
		do_action('reportApp/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][prepend]',
			'value'	=>	$field['prepend'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Append",'reportApp'); ?></label>
		<p><?php _e("Appears after the input",'reportApp') ?></p>
	</td>
	<td>
		<?php 
		do_action('reportApp/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][append]',
			'value'	=>	$field['append'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Formatting",'reportApp'); ?></label>
		<p><?php _e("Effects value on front end",'reportApp') ?></p>
	</td>
	<td>
		<?php 
		do_action('reportApp/create_field', array(
			'type'	=>	'select',
			'name'	=>	'fields['.$key.'][formatting]',
			'value'	=>	$field['formatting'],
			'choices' => array(
				'none'	=>	__("No formatting",'reportApp'),
				'html'	=>	__("Convert HTML into tags",'reportApp')
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Character Limit",'reportApp'); ?></label>
		<p><?php _e("Leave blank for no limit",'reportApp') ?></p>
	</td>
	<td>
		<?php 
		do_action('reportApp/create_field', array(
			'type'	=>	'number',
			'name'	=>	'fields[' .$key.'][maxlength]',
			'value'	=>	$field['maxlength'],
		));
		?>
	</td>
</tr>
		<?php
		
	}
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
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
	
	function format_value( $value, $post_id, $field )
	{
		$value = htmlspecialchars($value, ENT_QUOTES);
		
		return $value;
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
		// validate type
		if( !is_string($value) )
		{
			return $value;
		}
		
		
		if( $field['formatting'] == 'none' )
		{
			$value = htmlspecialchars($value, ENT_QUOTES);
		}
		elseif( $field['formatting'] == 'html' )
		{
			$value = nl2br($value);
		}
		
		
		return $value;
	}
	
}

new reportApp_field_text();

?>