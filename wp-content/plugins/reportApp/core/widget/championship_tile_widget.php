<?php

class championship_tile_widget extends WP_Widget {
 
	/**
	 * Register widget with WordPress.
	 */
	var $field_prefix='championship_tile_widget_';
	
public function __construct() {
		parent::__construct(
	 		'championship_tile_widget', // Base ID
			'Championship Tile Widget', // Name 
			array( 'description' => __( 'championship_tiles Widget', 'iuw' ), ) // Args
		);
	}
 
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
			
		extract( $args );	
		echo $before_widget;		
		$label = isset($instance[$this->field_prefix.'label'])?$instance[$this->field_prefix.'label']:"";		
		$image_uri = isset($instance[$this->field_prefix.'image'])?$instance[$this->field_prefix.'label']:"";
		$link = isset($instance['link'])?$instance[$this->field_prefix.'link']:"" ;		
		?>
		 <?echo $label?>
        	<a href="<?php echo esc_url($label); ?>"><img src="<?php echo esc_url($image)?>" /><img src="<?php echo esc_url($link);?>" /></a>        
    	 <?php
    	 echo $after_widget;
		 
		}
		
	
 
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance[$this->field_prefix.'label'] = ( ! empty( $new_instance[$this->field_prefix.'label'] ) ) ? strip_tags( $new_instance[$this->field_prefix.'label'] ) : '';
		$instance[$this->field_prefix.'image'] = ( ! empty( $new_instance[$this->field_prefix.'image'] ) ) ? strip_tags( $new_instance[$this->field_prefix.'image'] ) : '';
		$instance[$this->field_prefix.'link'] = ( ! empty( $new_instance[$this->field_prefix.'link'] ) ) ? strip_tags( $new_instance[$this->field_prefix.'link'] ) : '';
		return $instance;
	}
 
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		//debug($instance);
        if ( isset( $instance[ $this->field_prefix.'label' ] ) ) {
			$label = $instance[ $this->field_prefix.'label' ];
		}
		else {
			$label = __( '', 'iuw' );
		}
		if ( isset( $instance[ $this->field_prefix.'image' ] ) ) {
			$image = $instance[ $this->field_prefix.'image' ];
		}
		else {
			$image = __( '', 'iuw' );
		}
		
		if ( isset( $instance[ $this->field_prefix.'link' ] ) ) {
			
			$link = $instance[ $this->field_prefix.'link' ];
			
		}
		else {
			$link = __( '', 'iuw' );
		}
		
		?>
		<p>
      <label for="<?php echo $this->get_field_id($this->field_prefix.'label'); ?>"><?php _e('label', 'iuw'); ?>: </label><br />
      <input type="text" name="<?php echo $this->get_field_name($this->field_prefix.'label'); ?>" id="<?php echo $this->get_field_id($this->field_prefix.'label'); ?>" value="<?php echo $label; ?>" class="widefat" />
    </p>
    
		<p>
        <label for="<?php echo $this->get_field_id($this->field_prefix.'image'); ?>">Image: </label><br />
        <img class="custom_media_image" src="<?php echo $image; ?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
        <input type="text" class="custom_media_url <?php echo $this->field_prefix?>image" name="<?php echo $this->get_field_name($this->field_prefix.'image'); ?>" id="<?php echo $this->get_field_id($this->field_prefix.'image'); ?>" value="<?php echo $image; ?>">
       </p>
       <p>
        <input type="button" value="<?php _e( 'Upload Image', 'iuw' ); ?>" class="button custom_media_upload <?php echo $this->field_prefix?>image" id="custom_image_uploader_image"/>
	   </p>
	   
    	<p>
    		<label for="<?php echo $this->get_field_id($this->field_prefix.'link'); ?>">Link: </label><br />
    		<input type="text" class="link" name="<?php echo $this->get_field_name($this->field_prefix.'link'); ?>" id="<?php echo $this->get_field_id($this->field_prefix.'link'); ?>" value="<?php echo $link; ?>"></p>
	   
	   
		<?php 
	}
	
}
add_action( 'widgets_init', create_function( '', 'register_widget( "championship_tile_widget" );' ) );
function championship_tile_widget_iuw_wdScript(){
	
  wp_enqueue_media();
  $dir = apply_filters('v8supercars/get_info', 'dir');
  echo "<script>";
  	
  	echo "var field_prefix='championship_tile_widget_';";
	
  echo "</script>";
  wp_enqueue_script('championship_tile_widget',  $dir.'/js/championship_tile_widget.js');
  
  
}
add_action('admin_enqueue_scripts', 'championship_tile_widget_iuw_wdScript');