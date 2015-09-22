v8supercars<?php

class v8supercars_field_tab extends v8supercars_field
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
		$this->name = 'tab';
		$this->label = __("Tab",'v8supercars');
		$this->category = __("Layout",'v8supercars');
		
		
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
		echo '<div class="v8supercars-tab">' . $field['label'] . '</div>';
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
		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Instructions",'v8supercars'); ?></label>
			</td>
			<td>
				<p><?php _e("Use \"Tab Fields\" to better organize your edit screen by grouping your fields together under separate tab headings.",'v8supercars'); ?></p>
				<p><?php _e("All the fields following this \"tab field\" (or until another \"tab field\" is defined) will be grouped together.",'v8supercars'); ?></p>
				<p><?php _e("Use multiple tabs to divide your fields into sections.",'v8supercars'); ?></p>
			</td>
		</tr>
		<?php
		
	}
	
}

new v8supercars_field_tab();

?>