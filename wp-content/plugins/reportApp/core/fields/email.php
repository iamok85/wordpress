<?php

class v8supercars_field_email extends v8supercars_field
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
		$this->name = 'email';
		$this->label = __("Email",'v8supercars');
		$this->defaults = array(
			'default_value'	=>	'',
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
		// vars
		$o = array( 'id', 'class', 'name', 'value', 'placeholder' );
		$e = '';
		
		
		// prepend
		if( $field['prepend'] !== "" )
		{
			$field['class'] .= ' v8supercars-is-prepended';
			$e .= '<div class="v8supercars-input-prepend">' . $field['prepend'] . '</div>';
		}
		
		
		// append
		if( $field['append'] !== "" )
		{
			$field['class'] .= ' v8supercars-is-appended';
			$e .= '<div class="v8supercars-input-append">' . $field['append'] . '</div>';
		}
		
		
		$e .= '<div class="v8supercars-input-wrap">';
		$e .= '<input type="email"';
		
		foreach( $o as $k )
		{
			$e .= ' ' . $k . '="' . esc_attr( $field[ $k ] ) . '"';	
		}
		
		$e .= ' />';
		$e .= '</div>';
		
		
		// return
		echo $e;
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
			'type'	=>	'text',
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
		<label><?php _e("Prepend",'v8supercars'); ?></label>
		<p><?php _e("Appears before the input",'v8supercars') ?></p>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][prepend]',
			'value'	=>	$field['prepend'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Append",'v8supercars'); ?></label>
		<p><?php _e("Appears after the input",'v8supercars') ?></p>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields[' .$key.'][append]',
			'value'	=>	$field['append'],
		));
		?>
	</td>
</tr>
		<?php
	}	
	
}

new v8supercars_field_email();

?>