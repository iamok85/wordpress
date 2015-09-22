<?php

class v8supercars_field_video extends v8supercars_field
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
		$this->name = 'video';
		$this->label = __("Video",'v8supercars');
		$this->category = __("Content",'v8supercars');
		$this->defaults = array(
			'save_format'	=>	'object',
			'preview_size'	=>	'thumbnail',
			'library'		=>	'all'
		);
		$this->l10n = array(
			'select'		=>	__("Select Video",'v8supercars'),
			'edit'			=>	__("Edit Video",'v8supercars'),
			'update'		=>	__("Update Video",'v8supercars'),
			'uploadedTo'	=>	__("uploaded to this post",'v8supercars'),
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
		// filters
		add_filter('get_media_item_args', array($this, 'get_media_item_args'));
		add_filter('wp_prepare_attachment_for_js', array($this, 'wp_prepare_attachment_for_js'), 10, 3);
		
		
		// JSON
		add_action('wp_ajax_v8supercars/fields/video/get_videos', array($this, 'ajax_get_videos'), 10, 1);
		add_action('wp_ajax_nopriv_v8supercars/fields/video/get_videos', array($this, 'ajax_get_videos'), 10, 1);
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
		$o = array(
			'type',
		    'value',
			'name',
			'class',
				
		);
		

		$e='';
			if(isset($field['required'])&&$field['required']){
				
				$e .= '<input style="width:300px" required type="text"';
				
			}else{
			
				$e .= '<input style="width:300px" type="text"';	
			}				
		
			 
			foreach( $o as $k )
			{
				
				if(isset($field[ $k ]))
					$e .= ' ' . $k . '="' . esc_attr( $field[ $k ] ) . '"';	
			}
			
			$e .= ' />';
						
		 	echo $e;
		?>
		   	
		  
		 <?if($field['video_type']=="Youtube"||$field['video_type']=="Vimeo"){?>  		
    	     	 
    									
				<?if(isset($field['value'])){?>
					
					    <div class="video_frame <?=$field['name']?>">					
						
							<?echo wp_video_shortcode( array("src"=>$field['value']) );?>
						
						</div>
						  					
				<?}?>
				
			<?php }else{?>			  		 							
				
			<!-- Start of Brightcove Player -->
			<div style="margin-top:10px">
			<div style="display:none">
			</div>
			<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
			<object id="myExp" class="BrightcoveExperience">
			<param name="wmode" value="transparent" />
			<param name="bgcolor" value="#FFFFFF" />
			<param name="width" value="770" />
			<param name="height" value="433" />
			<param name="playerID" value="2183072329001" />
			<param name="playerKey" value="AQ~~,AAAB-0j8Ytk~,iRabUhLPo6EsRgWQQgA3g_giBsF81BLB" />
			<param name="autoStart" value="false">
			<param name="isVid" value="true" />
			<param name="isUI" value="true" />
			<param name="dynamicStreaming" value="true" />			
			<param name="@videoPlayer" value="<?=$field['value']?>" />
			<param name="includeAPI" value="true" />
			<param name="templateLoadHandler" value="onTemplateLoad" />
			<param name="templateReadyHandler" value="onTemplateReady" />
			</object>
			<script type="text/javascript">brightcove.createExperiences();</script>
			<!-- End of Brightcove Player -->
			</div>								    
			 <?php }?>	
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
		<label><?php _e("Return Value",'v8supercars'); ?></label>
		<p><?php _e("Specify the returned value on front end",'v8supercars') ?></p>
	</td>
	<td>
		<?php
		do_action('v8supercars/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][save_format]',
			'value'		=>	$field['save_format'],
			'layout'	=>	'horizontal',
			'choices'	=> array(
				'object'	=>	__("Video Object",'v8supercars'),
				'url'		=>	__("Video URL",'v8supercars'),
				'id'		=>	__("Video ID",'v8supercars')
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Preview Size",'v8supercars'); ?></label>
		<p><?php _e("Shown when entering data",'v8supercars') ?></p>
	</td>
	<td>
		<?php
		
		do_action('v8supercars/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][preview_size]',
			'value'		=>	$field['preview_size'],
			'layout'	=>	'horizontal',
			'choices' 	=>	apply_filters('v8supercars/get_video_sizes', array())
		));

		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Library",'v8supercars'); ?></label>
		<p><?php _e("Limit the media library choice",'v8supercars') ?></p>
	</td>
	<td>
		<?php
		
		do_action('v8supercars/create_field', array(
			'type'		=>	'radio',
			'name'		=>	'fields['.$key.'][library]',
			'value'		=>	$field['library'],
			'layout'	=>	'horizontal',
			'choices' 	=>	array(
				'all' => __('All', 'v8supercars'),
				'uploadedTo' => __('Uploaded to post', 'v8supercars')
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
		
		// validate
		if( !$value )
		{
			return false;
		}
		
		
		// format
		if( $field['save_format'] == 'url' )
		{
			$value = wp_get_attachment_url( $value );
		}
		elseif( $field['save_format'] == 'object' )
		{
			$attachment = get_post( $value );
			
			
			// validate
			if( !$attachment )
			{
				return false;	
			}
			
			
			// create array to hold value data
			$src = wp_get_attachment_video_src( $attachment->ID, 'full' );
			
			$value = array(
				'id' => $attachment->ID,
				'alt' => get_post_meta($attachment->ID, '_wp_attachment_video_alt', true),
				'title' => $attachment->post_title,
				'caption' => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'mime_type'	=> $attachment->post_mime_type,
				'url' => $src[0],
				'width' => $src[1],
				'height' => $src[2],
				'sizes' => array(),
			);
			
			
			// find all video sizes
			$video_sizes = get_intermediate_video_sizes();
			
			if( $video_sizes )
			{
				foreach( $video_sizes as $video_size )
				{
					// find src
					$src = wp_get_attachment_video_src( $attachment->ID, $video_size );
					
					// add src
					$value[ 'sizes' ][ $video_size ] = $src[0];
					$value[ 'sizes' ][ $video_size . '-width' ] = $src[1];
					$value[ 'sizes' ][ $video_size . '-height' ] = $src[2];
				}
				// foreach( $video_sizes as $video_size )
			}
			// if( $video_sizes )
			
		}
		
		return $value;
		
	}
	
	
	/*
	*  get_media_item_args
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 27/01/13
	*/
	
	function get_media_item_args( $vars )
	{
	    $vars['send'] = true;
	    return($vars);
	}
	
	
	/*
   	*  ajax_get_videos
   	*
   	*  @description: 
   	*  @since: 3.5.7
   	*  @created: 13/01/13
   	*/
	
   	function ajax_get_videos()
   	{
   		// vars
		$options = array(
			'nonce' => '',
			'videos' => array(),
			'preview_size' => 'thumbnail'
		);
		$return = array();
		
		
		// load post options
		$options = array_merge($options, $_POST);
		
		
		// verify nonce
		if( ! wp_verify_nonce($options['nonce'], 'v8supercars_nonce') )
		{
			die(0);
		}
		
		
		if( $options['videos'] )
		{
			foreach( $options['videos'] as $id )
			{
				$url = wp_get_attachment_video_src( $id, $options['preview_size'] );
				
				
				$return[] = array(
					'id' => $id,
					'url' => $url[0],
				);
			}
		}
		
		
		// return json
		echo json_encode( $return );
		die;
		
   	}
   		
	
	/*
	*  video_size_names_choose
	*
	*  @description: 
	*  @since: 3.5.7
	*  @created: 13/01/13
	*/
	
	function video_size_names_choose( $sizes )
	{
		global $_wp_additional_video_sizes;
			
		if( $_wp_additional_video_sizes )
		{
			foreach( $_wp_additional_video_sizes as $k => $v )
			{
				$title = $k;
				$title = str_replace('-', ' ', $title);
				$title = str_replace('_', ' ', $title);
				$title = ucwords( $title );
				
				$sizes[ $k ] = $title;
			}
			// foreach( $video_sizes as $video_size )
		}
		
        return $sizes;
	}
	
	
	/*
	*  wp_prepare_attachment_for_js
	*
	*  @description: This sneaky hook adds the missing sizes to each attachment in the 3.5 uploader. It would be a lot easier to add all the sizes to the 'video_size_names_choose' filter but then it will show up on the normal the_content editor
	*  @since: 3.5.7
	*  @created: 13/01/13
	*/
	
	function wp_prepare_attachment_for_js( $response, $attachment, $meta )
	{
		// only for video
		if( $response['type'] != 'video' )
		{
			return $response;
		}
		
		
		// make sure sizes exist. Perhaps they dont?
		if( !isset($meta['sizes']) )
		{
			return $response;
		}
		
		
		$attachment_url = $response['url'];
		$base_url = str_replace( wp_basename( $attachment_url ), '', $attachment_url );
		
		if( isset($meta['sizes']) && is_array($meta['sizes']) )
		{
			foreach( $meta['sizes'] as $k => $v )
			{
				if( !isset($response['sizes'][ $k ]) )
				{
					$response['sizes'][ $k ] = array(
						'height'      =>  $v['height'],
						'width'       =>  $v['width'],
						'url'         => $base_url .  $v['file'],
						'orientation' => $v['height'] > $v['width'] ? 'portrait' : 'landscape',
					);
				}
			}
		}

		return $response;
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
	
	function update_value( $value, $post_id, $field )
	{
		// array?
		if( is_array($value) && isset($value['id']) )
		{
			$value = $value['id'];	
		}
		
		// object?
		if( is_object($value) && isset($value->ID) )
		{
			$value = $value->ID;
		}
		
		return $value;
	}
	
	
}

new v8supercars_field_video();

?>