<?php

class Controller
{

	protected  $entity;
	protected $scripts=array();
	protected $supports=array(
		'custom_fields',
		'revisions',
		'post-formats'
	);

	function __construct()
	{
		$this->init();
	}

	public function get_entity(){

		return new $this->entity();
	}
	function init(){

		$dir = apply_filters('reportApp/get_info', 'dir');
		$path = apply_filters('reportApp/get_info', 'path');
		$version = apply_filters('reportApp/get_info', 'version');

		register_post_type(	$this->name, array(
			'labels' => $this->labels,
			'public' => true,
			'show_ui' => true,
			'_builtin' =>  false,
			'capability_type' => 'page',
			'hierarchical' => false,
			'query_var' =>$this->name,
			'supports' => array(
				''
				//'custom_fields',
				//'revisions',
				//'post-formats'
				
			),
			'show_in_menu'	=> false
			
		));

		flush_rewrite_rules();

		$this->settings = apply_filters('reportApp/get_info', 'all');

		add_action('admin_head', array($this,'admin_head'));

		if( is_admin() )
		{
			add_action('admin_menu', array($this,'admin_menu'));
			add_filter('post_updated_messages', array($this, 'post_updated_messages'));

			foreach( $this->scripts as $handle=>$script )
			{
				$jscript=array();

				$jscript['handle']=$handle;
				$jscript['src']=$this->settings['dir'] . "js/".$script;
				$jscript['deps']=array('jquery');
				wp_register_script( $jscript['handle'], $jscript['src'], $jscript['deps'], $this->settings['version'] );
			}

			add_action('admin_enqueue_scripts', array($this,'reportApp_register_entity_script'));
			
			
			add_filter( "manage_edit-".$this->name."_sortable_columns", array($this,"sortable_columns"),10,1 );
			add_filter("request", array($this,"column_orderby"));
			
			//add_filter( 'tiny_mce_before_init', array($this,'my_format_TinyMCE') );
			
			add_filter('tinymce_templates_enable_media_buttons', function(){
			
				 return true; // Displays insert template button on all visual editors
		 
			});
						
		}
		
	}


// function my_format_TinyMCE( $in ) {
// 	
	// $in['remove_linebreaks'] = false;
	// $in['gecko_spellcheck'] = false;
	// $in['keep_styles'] = true;
	// $in['accessibility_focus'] = true;	
	// $in['tabfocus_elements'] = 'major-publishing-actions';
	// $in['media_strict'] = true;
	// $in['paste_remove_styles'] = false;
	// $in['paste_remove_spans'] = false;
	// $in['paste_strip_class_attributes'] = 'none';
	// $in['paste_text_use_dialog'] = true;
	// $in['wpeditimage_disable_captions'] = true;
	// $in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
	// $in['content_css'] = get_template_directory_uri() . "/editor-style.css";
	// $in['wpautop'] = true;
	// $in['apply_source_formatting'] = false;
       // // $in['block_formats'] = "Paragraph=p; Heading 3=h3; Heading 4=h4";
	// $in['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ';
	// $in['toolbar2'] = 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
	// $in['toolbar3'] = '';
	// $in['toolbar4'] = '';
	// //die;
	// return $in;
// }

	function column_orderby( $vars) {

		if(isset($vars['orderby'])){
			
			$entity_class=$this->name.'_entity';
			$entity=new $entity_class;
			$field_list=$entity->field_list;
			
			if(isset($field_list[$vars['orderby']])){
				
				switch($field_list[$vars['orderby']]['type']){
				
					case 'datetime':
					 $vars = array_merge( $vars,
			            array(
			                'meta_key'  => $vars['orderby'],
			                'orderby'   => 'meta_value_datetime',
			                'order'     =>$vars['order']
			            )
			        );
						break;
						
					default:
						
						$vars = array_merge( $vars,
				            array(
				                'meta_key'  => $vars['orderby'],
				                'orderby'   => 'meta_value',
				                'order'     =>$vars['order']
				            )
			        	);	
						break;	
				}
				
			}
				
		}
		
		
		
    	return $vars;
	}

	function sortable_columns() {
		
		$sort_col=array();
		
		foreach($this->columns as $key=>$label){
			
			$sort_col[$key]=$key;
		} 
	  
	  return $sort_col; 
	}
	
	function reportApp_register_entity_script(){

		//error_log(print_r($this->scripts,true));

		foreach( $this->scripts as $handle=>$script ){

			wp_enqueue_script(
				array(
					$handle
				)
			);
		}

	}

	function post_updated_messages( $messages )
	{

		$messages[$this->name] =$this->messages[$this->name];

		return $messages;
	}

	function admin_head()
	{
		global $post;

		$l10n = array(
			'move_to_trash'		=>	__("Move to trash. Are you sure?",$this->name),
			'checked'			=>	__("checked",$this->name),
			'no_fields'			=>	__("No toggle fields available",$this->name),
			'copy'				=>	__("copy",$this->name),
			'or'				=>	__("or",$this->name),
			'fields'			=>	__("Fields",$this->name),
			'parent_fields'		=>	__("Parent fields",$this->name),
			'sibling_fields'	=>	__("Sibling fields",$this->name),
			'hide_show_all'		=>	__("Hide / Show All",$this->name)
		);

		do_action('reportApp/'.$this->name.'/admin_head');
		// add metaboxes
		add_meta_box($this->name.'_fields', __($this->label." Detail",$this->name), array($this, 'html_fields'), $this->name, 'normal', 'high');

	}


	/*
	*  html_fields
	*
	*  @description: 
	*  @since 1.0.0
	*  @created: 23/06/12
	*/

	function html_fields()
	{

		global $post;
		$entity_instance=$this->get_entity();
		$entity_field_list=$entity_instance->get_field_list();
		$entity_field_list['post_type']=$this->name;
		$field = apply_filters('reportApp/model/load_field',$entity_field_list,$post->ID);
		$field_list=$field;
		$path = apply_filters('reportApp/get_info','path');
		include( $path. 'core/views/general_meta_box_fields.php' );
	}

	function admin_menu(){

		add_submenu_page( 'edit.php?post_type=reportApp', $this->label, $this->label, 'manage_options', 'edit.php?post_type='.$this->name, FALSE);
		add_filter( 'manage_edit-'.$this->name.'_columns', array($this,'edit_columns'), 10, 1 );
		add_action( "manage_posts_custom_column", array($this,"custom_columns"), 10, 2 );
	}

	function edit_columns( $columns )
	{

		return $this->columns;
	}

	function output_column_logo_image($column,$post_id){

		echo "<div width='50px' height='50px'>";

		$value = get_post_meta( $post_id, $column, true);

		echo '<img src="' . $value . '" width="50px" height="50px"  class ="alignleft post_thumbnail" />';

		echo '</div>';

	}

	function output_column_value($column,$post_id){

		$entity_name=$this->name.'_entity';
		$entity=new $entity_name;
		$relations=$entity->relations();
		$value = get_post_meta( $post_id, $column, true);
				
		if(isset($relations[$column])){

			$parts=explode(';', $value);
			$post_type=$relations[$column][1];
			$related_fields=$relations[$column][2];
			$result_str='';
			foreach($related_fields as $sub_one_field){
				foreach($parts as $one_part){
					$sub_result=get_post_meta($one_part,$sub_one_field);
					if(isset($sub_result[0]))
						$result_str.=$sub_result[0].' ';
				}
					
			}
			$result_str=trim($result_str);

			echo $result_str;


		}else{

			echo  $value;

		}

	}

}
?>