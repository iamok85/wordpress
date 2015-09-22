jQuery(document).ready(function(){	
	//jQuery('.search_options.collapsible:visible').collapsible();
	
	jQuery('.delete_or_filter')	.live('click',function(){
		classes=jQuery(this).attr('class').split(' ');
		filters_groups_index=classes[2];
		jQuery('tr.filters_groups.'+filters_groups_index).fadeOut(1000, function(){jQuery(this).remove();});	
	});
	
	if(jQuery('.add_or_filter').length>0){
	//alert(jQuery('.add_or_filter'));
		jQuery('.add_or_filter').live('click',function(){
				//alert(1);
				options_str=jQuery('.options_str').val();
				options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(options_str)));				
				//options=jQuery.parseJSON(options_str);	
				url_list={};
				url_list['get_autocomplete']='meta/get_autocomplete';
				url_list['get_new_filter']='meta/get_new_filter';
				url_list['get_options']='meta/get_options';			
				jQuery.filters({container:'.filters_groups_container',filters:[{name:''}],options:options,url_list:url_list});   			
		});		
	}
});
