<?php

class v8supercars_field_textarea extends v8supercars_field
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
		$this->name = 'textarea';
		$this->label = __("Text Area",'v8supercars');
		$this->defaults = array(
			'default_value'	=> '',
			'formatting' 	=> 'br',
			'maxlength'		=> '',
			'placeholder'	=> '',
			'rows'			=> ''
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
		$o = array( 'id', 'class', 'name', 'placeholder', 'rows','cols');
		$e = '';
		
		
		// maxlength
		if( $field['maxlength'] !== "" )
		{
			$o[] = 'maxlength';
		}
		
		
		// rows
		if( empty($field['rows']) )
		{
			$field['rows'] = 8;
		}


		if(isset($field['required'])&&$field['required']){
			
			$e .= '<textarea required';
			
		}else{
		
			$e .= '<textarea';	
		}						
		
		
		
		
		foreach( $o as $k )
		{
			$e .= ' ' . $k . '="' . esc_attr( $field[ $k ] ) . '"';	
		}
		
		$e .= '>';
		$e .= esc_textarea($field['value']);
		$e .= '</textarea>';
		
		// return
		echo $e;
		
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
		<label><?php _e("Default Value",'v8supercars'); ?></label>
		<p><?php _e("Appears when creating a new post",'v8supercars') ?></p>
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
		<label><?php _e("Placeholder Text",'v8supercars'); ?></label>
		<p><?php _e("Appears within the input",'v8supercars') ?></p>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][placeholder]',
			'value'	=>	$field['placeholder'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Character Limit",'v8supercars'); ?></label>
		<p><?php _e("Leave blank for no limit",'v8supercars') ?></p>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'number',
			'name'	=>	'fields[' .$key.'][maxlength]',
			'value'	=>	$field['maxlength'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Rows",'v8supercars'); ?></label>
		<p><?php _e("Sets the textarea height",'v8supercars') ?></p>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'			=> 'number',
			'name'			=> 'fields[' .$key.'][rows]',
			'value'			=> $field['rows'],
			'placeholder'	=> 8
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Formatting",'v8supercars'); ?></label>
		<p><?php _e("Effects value on front end",'v8supercars') ?></p>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'select',
			'name'	=>	'fields['.$key.'][formatting]',
			'value'	=>	$field['formatting'],
			'choices' => array(
				'none'	=>	__("No formatting",'v8supercars'),
				'br'	=>	__("Convert new lines into &lt;br /&gt; tags",'v8supercars'),
				'html'	=>	__("Convert HTML into tags",'v8supercars')
			)
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
			//$value = html_entity_decode($value);
			//$value = nl2br($value);
		}
		elseif( $field['formatting'] == 'br' )
		{
			$value = htmlspecialchars($value, ENT_QUOTES);
			$value = nl2br($value);
		}
		
		
		return $value;
	}
	
}

new v8supercars_field_textarea();

?>