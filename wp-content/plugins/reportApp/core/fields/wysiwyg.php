<?php

// Create an v8supercars version of the_content filter (v8supercars_the_content)
if(	isset($GLOBALS['wp_embed']) )
{
	add_filter( 'v8supercars_the_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
	add_filter( 'v8supercars_the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
}

add_filter( 'v8supercars_the_content', 'capital_P_dangit', 11 );
add_filter( 'v8supercars_the_content', 'wptexturize' );
add_filter( 'v8supercars_the_content', 'convert_smilies' );
add_filter( 'v8supercars_the_content', 'convert_chars' );
add_filter( 'v8supercars_the_content', 'wpautop' );
add_filter( 'v8supercars_the_content', 'shortcode_unautop' );
//add_filter( 'v8supercars_the_content', 'prepend_attachment' ); *should only be for the_content (causes double image on attachment page)
add_filter( 'v8supercars_the_content', 'do_shortcode', 11);


class v8supercars_field_wysiwyg extends v8supercars_field
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
		$this->name = 'wysiwyg';
		$this->label = __("Wysiwyg Editor",'v8supercars');
		$this->category = __("Content",'v8supercars');
		$this->defaults = array(
			'toolbar'		=>	'full',
			'media_upload' 	=>	'yes',
			'default_value'	=>	'',
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// filters
    	add_filter( 'v8supercars/fields/wysiwyg/toolbars', array( $this, 'toolbars'), 1, 1 );
    	add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins'), 20, 1 );

	}
	
	
	/*
	*  mce_external_plugins
	*
	*  This filter will add in the tinyMCE 'code' plugin which is missing in WP 3.9
	*
	*  @type	function
	*  @date	18/04/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function mce_external_plugins( $plugins ){
		
		// global
   		global $wp_version;
   		
   		
   		// WP 3.9 an above
   		if( version_compare($wp_version, '3.9', '>=' ) ) {
			
			// add code
			$plugins['code'] = apply_filters('v8supercars/get_info', 'dir') . 'js/tinymce.code.min.js';
		
		}
		
		
		// return
		return $plugins;
		
	}
	
	
	/*
	*  toolbars()
	*
	*  This filter allowsyou to customize the WYSIWYG toolbars
	*
	*  @param	$toolbars - an array of toolbars
	*
	*  @return	$toolbars - the modified $toolbars
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*/
	
   	function toolbars( $toolbars ) {
   		
   		// global
   		global $wp_version;
   		
   		
   		// vars
   		$editor_id = 'v8supercars_settings';
   		
   		
   		if( version_compare($wp_version, '3.9', '>=' ) ) {
   		
   			// Full
	   		$toolbars['Full'] = array(
	   			
	   			1 => apply_filters( 'mce_buttons', array('bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'alignleft', 'aligncenter', 'alignright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 'wp_adv' ), $editor_id ),
	   			
	   			2 => apply_filters( 'mce_buttons_2', array( 'formatselect', 'underline', 'alignjustify', 'forecolor', 'pastetext', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help', 'code' ), $editor_id ),
	   			
	   			3 => apply_filters('mce_buttons_3', array(), $editor_id),
	   			
	   			4 => apply_filters('mce_buttons_4', array(), $editor_id),
	   			
	   		);
	   		
	   		
	   		// Basic
	   		$toolbars['Basic'] = array(
	   			
	   			1 => apply_filters( 'teeny_mce_buttons', array('bold', 'italic', 'underline', 'blockquote', 'strikethrough', 'bullist', 'numlist', 'alignleft', 'aligncenter', 'alignright', 'undo', 'redo', 'link', 'unlink', 'fullscreen'), $editor_id ),
	   			
	   		);
	   		  		
   		} else {
	   		
	   		// Full
	   		$toolbars['Full'] = array(
	   			
	   			1 => apply_filters( 'mce_buttons', array('bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 'wp_adv' ), $editor_id ),
	   			
	   			2 => apply_filters( 'mce_buttons_2', array( 'formatselect', 'underline', 'justifyfull', 'forecolor', 'pastetext', 'pasteword', 'removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help', 'code' ), $editor_id ),
	   			
	   			3 => apply_filters('mce_buttons_3', array(), $editor_id),
	   			
	   			4 => apply_filters('mce_buttons_4', array(), $editor_id),
	   			
	   		);

	   		
	   		// Basic
	   		$toolbars['Basic'] = array(
	   			
	   			1 => apply_filters( 'teeny_mce_buttons', array('bold', 'italic', 'underline', 'blockquote', 'strikethrough', 'bullist', 'numlist', 'justifyleft', 'justifycenter', 'justifyright', 'undo', 'redo', 'link', 'unlink', 'fullscreen'), $editor_id ),
	   			
	   		);
	   		
   		}
   		
   		
   		
   		// Custom - can be added with v8supercars/fields/wysiwyg/toolbars filter
   	
   		
	   	return $toolbars;
   	}
   	
   	
   	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add css and javascript to assist your create_field() action.
	*
	*  @info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
   	
   	function input_admin_head()
   	{
   		add_action( 'admin_footer', array( $this, 'admin_footer') );
   	}
   	
   	function admin_footer()
   	{
	   	?>
<div style="display:none;">
	<?php wp_editor( '', 'v8supercars_settings' ); ?>
</div>
	   	<?php
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
		global $wp_version;
		
		
		// vars
		$id = 'wysiwyg-' . $field['id'] . '-' . uniqid();
		
		
		?>
		
		<div id="wp-<?php echo $id; ?>-editor-container" class="wp-editor-container">
				
			<?$settings = array( 'media_buttons' => true,'textarea_rows'=>$field['rows'],'textarea_name'=>$field['name']);?>				
			
			<?if(isset($field['required'])&&$field['required']){
				
					$settings=array_merge($settings,array('editor_class'=>'required'));	
						
				}else{?>
									
					
			<?}?>			
										

			<?wp_editor( $field['value'], $id, $settings );?>				
					
		</div>		
		
		<?php
		
		//add_action( 'media_buttons', array( $this, 'media_buttons'), 11,$id );
		//die;
		
		
		
	}
	
	
		public function media_buttons( $editor_id = 'content' )
	{
		//debug($editor_id);
		
		$editors = apply_filters( 'tinymce_templates_editors', array( 'content' ), $editor_id );
		
		if ( apply_filters( 'tinymce_templates_enable_media_buttons', in_array( $editor_id, $editors ), $editor_id ) ) {
			$button_html = '<a id="%s" class="%s" href="#" data-editor="%s" title="%s">';
			$button_html .= '<span class="%s" style="%s"></span> %s';
			$button_html .= '</a>';
			printf(
				$button_html,
				'button-tinymce-templates',
				'button',
				esc_attr( $editor_id ),
				esc_attr( __( 'Insert Template', 'tinymce_templates' ) ),
				'dashicons dashicons-edit',
				'margin-top: 3px;',
				esc_html( __( 'Insert Template', 'tinymce_templates' ) )
			);
		}
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
			'type'	=>	'textarea',
			'name'	=>	'fields['.$key.'][default_value]',
			'value'	=>	$field['default_value'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Toolbar",'v8supercars'); ?></label>
	</td>
	<td>
		<?php
		
		$toolbars = apply_filters( 'v8supercars/fields/wysiwyg/toolbars', array() );
		$choices = array();
		
		if( is_array($toolbars) )
		{
			foreach( $toolbars as $k => $v )
			{
				$label = $k;
				$name = sanitize_title( $label );
				$name = str_replace('-', '_', $name);
				
				$choices[ $name ] = $label;
			}
		}
		
		do_action('v8supercars/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][toolbar]',
			'value'	=>	$field['toolbar'],
			'layout'	=>	'horizontal',
			'choices' => $choices
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Show Media Upload Buttons?",'v8supercars'); ?></label>
	</td>
	<td>
		<?php 
		do_action('v8supercars/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][media_upload]',
			'value'	=>	$field['media_upload'],
			'layout'	=>	'horizontal',
			'choices' => array(
				'yes'	=>	__("Yes",'v8supercars'),
				'no'	=>	__("No",'v8supercars'),
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
		// apply filters
		$value = apply_filters( 'v8supercars_the_content', $value );
		
		
		// follow the_content function in /wp-includes/post-template.php
		$value = str_replace(']]>', ']]&gt;', $value);
		
	
		return $value;
	}
	
}

new v8supercars_field_wysiwyg();

?>