<?php

class v8supercars_field_color_picker extends v8supercars_field
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
		$this->name = 'color_picker';
		$this->label = __("Color Picker",'v8supercars');
		$this->category = __("jQuery",'v8supercars');
		$this->defaults = array(
			'default_value'	=>	'',
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
		$o = array( 'id', 'class', 'name', 'value' );
		$e = '';
		
		
		$e .= '<div class="v8supercars-color_picker">';
		$e .= '<input type="text"';
		
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
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'			=>	'text',
			'name'			=>	'fields[' .$key.'][default_value]',
			'value'			=>	$field['default_value'],
			'placeholder'	=>	'#ffffff'
		));
		?>
	</td>
</tr>
		<?php
		
	}
	
}

new v8supercars_field_color_picker();

?>