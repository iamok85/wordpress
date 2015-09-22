<?php

class v8supercars_field_google_map extends v8supercars_field
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
		$this->name = 'google_map';
		$this->label = __("Google Map",'v8supercars');
		$this->category = __("jQuery",'v8supercars');
		$this->defaults = array(
			'height'		=> '',
			'center_lat'	=> '',
			'center_lng'	=> '',
			'zoom'			=> ''
		);
		$this->default_values = array(
			'height'		=> '400',
			'center_lat'	=> '-37.81411',
			'center_lng'	=> '144.96328',
			'zoom'			=> '14'
		);
		$this->l10n = array(
			'locating'			=>	__("Locating",'v8supercars'),
			'browser_support'	=>	__("Sorry, this browser does not support geolocation",'v8supercars'),
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
		// require the googlemaps JS ( this script is now lazy loaded via JS )
		//wp_enqueue_script('v8supercars-googlemaps');
		
		
		// default value
		if( !is_array($field['value']) )
		{
			$field['value'] = array();
		}
		
		$field['value'] = wp_parse_args($field['value'], array(
			'address'	=> '',
			'lat'		=> '',
			'lng'		=> ''
		));
		
		
		// default options
		foreach( $this->default_values as $k => $v )
		{
			if( ! $field[ $k ] )
			{
				$field[ $k ] = $v;
			}	
		}
		
		
		// vars
		$o = array(
			'class'		=>	'',
		);
		
		if( $field['value']['address'] )
		{
			$o['class'] = 'active';
		}
		
		
		$atts = '';
		$keys = array( 
			'data-id'	=> 'id', 
			'data-lat'	=> 'center_lat',
			'data-lng'	=> 'center_lng',
			'data-zoom'	=> 'zoom'
		);
		
		foreach( $keys as $k => $v )
		{
			$atts .= ' ' . $k . '="' . esc_attr( $field[ $v ] ) . '"';	
		}
		
		?>
		<div class="v8supercars-google-map <?php echo $o['class']; ?>" <?php echo $atts; ?>>
			
			<div style="display:none;">
				<?php foreach( $field['value'] as $k => $v ): ?>
					<input type="hidden" class="input-<?php echo $k; ?>" name="<?php echo esc_attr($field['name']); ?>[<?php echo $k; ?>]" value="<?php echo esc_attr( $v ); ?>" />
				<?php endforeach; ?>
			</div>
			
			<div class="title">
				
				<div class="has-value">
					<a href="#" class="v8supercars-sprite-remove ir" title="<?php _e("Clear location",'v8supercars'); ?>">Remove</a>
					<h4><?php echo $field['value']['address']; ?></h4>
				</div>
				
				<div class="no-value">
					<a href="#" class="v8supercars-sprite-locate ir" title="<?php _e("Find current location",'v8supercars'); ?>">Locate</a>
					<input type="text" placeholder="<?php _e("Search for address...",'v8supercars'); ?>" class="search" />
				</div>
				
			</div>
			
			<div class="canvas" style="height: <?php echo $field['height']; ?>px">
				
			</div>
			
		</div>
		<?php
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
		<label><?php _e("Center",'v8supercars'); ?></label>
		<p class="description"><?php _e('Center the initial map','v8supercars'); ?></p>
	</td>
	<td>
		<ul class="hl clearfix">
			<li style="width:48%;">
				<?php 
			
				do_action('v8supercars/create_field', array(
					'type'			=> 'text',
					'name'			=> 'fields['.$key.'][center_lat]',
					'value'			=> $field['center_lat'],
					'prepend'		=> 'lat',
					'placeholder'	=> $this->default_values['center_lat']
				));
				
				?>
			</li>
			<li style="width:48%; margin-left:4%;">
				<?php 
			
				do_action('v8supercars/create_field', array(
					'type'			=> 'text',
					'name'			=> 'fields['.$key.'][center_lng]',
					'value'			=> $field['center_lng'],
					'prepend'		=> 'lng',
					'placeholder'	=> $this->default_values['center_lng']
				));
				
				?>
			</li>
		</ul>
		
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Zoom",'v8supercars'); ?></label>
		<p class="description"><?php _e('Set the initial zoom level','v8supercars'); ?></p>
	</td>
	<td>
		<?php 
		
		do_action('v8supercars/create_field', array(
			'type'			=> 'number',
			'name'			=> 'fields['.$key.'][zoom]',
			'value'			=> $field['zoom'],
			'placeholder'	=> $this->default_values['zoom']
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Height",'v8supercars'); ?></label>
		<p class="description"><?php _e('Customise the map height','v8supercars'); ?></p>
	</td>
	<td>
		<?php 
		
		do_action('v8supercars/create_field', array(
			'type'			=> 'number',
			'name'			=> 'fields['.$key.'][height]',
			'value'			=> $field['height'],
			'append'		=> 'px',
			'placeholder'	=> $this->default_values['height']
		));
		
		?>
	</td>
</tr>
		<?php
		
	}
	
	
	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field ) {
	
		if( empty($value) || empty($value['lat']) || empty($value['lng']) ) {
			
			return false;
			
		}
		
		
		// return
		return $value;
	}
	
}

new v8supercars_field_google_map();

?>