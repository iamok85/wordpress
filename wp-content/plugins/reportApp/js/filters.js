jQuery(document).ready(function(){	
	//jQuery('.search_options.collapsible:visible').collapsible();
	
	
	if(jQuery('input.reports_filters_groups').length>0){
		reports_filters_groups=jQuery('input.reports_filters_groups').val();
		//alert(reports_filters_groups);
		if(reports_filters_groups.length>0)
			filters_groups_str=reports_filters_groups;
	}
	
	if(typeof filters_groups_str=='undefined'){	
		filters_groups_str=encodeURIComponent('[[{"customers_customerNumber":[]}]]');
	}
	
	if(jQuery('input.reports_options').length>0){
		reports_options=jQuery('input.reports_options').val();
		//alert(reports_filters_groups);
		if(reports_options.length>0)
			options_str=reports_options;
	}
	//alert(filters_groups_str);
	if(typeof options_str =='undefined'){	
		options_str='{"list_by"%3A%5B"makeup_Customer_Address"%5D%2C"group_by_field_value"%3A"Total"%2C"view_type"%3A"557e71b1719f9"%2C"pagination"%3A"20"%2C"order_by"%3A"products_productName"%2C"order_by_seq"%3A"desc"%2C"show_sql_only"%3A"0"%2C"render_type"%3A"map"%2C"combine"%3A"0"%2C"compare_with"%3A%5B%7B"logic_field"%3A"products_productName"%2C"compare_function"%3A%7B"function_name"%3A"count"%2C"diagram_type"%3A"bar"%7D%7D%5D}';
		options_str=encodeURIComponent(options_str);
	}
	//alert(options_str);
	filters_groups=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(filters_groups_str)));																					
	//console.log(filters_groups);
	options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(options_str)));		
	jQuery.search_options({options:options,instant_update:true});
	jQuery('.filters_groups_container').html('');
	jQuery.each(filters_groups,function(index){							    
		filters=filters_groups[index];																
		//console.log(filters);
		url_list={};
		url_list['get_autocomplete']='metaJson/get_autocomplete';
		url_list['get_new_filter']='metaJson/get_new_filter';
		url_list['get_options']='metaJson/get_options';				
		jQuery.filters({container:'.filters_groups_container',filters:filters,options:options,url_list:url_list});																	
	});
	
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
				url_list['get_autocomplete']='metaJson/get_autocomplete';
				url_list['get_new_filter']='metaJson/get_new_filter';
				url_list['get_options']='metaJson/get_options';			
				jQuery.filters({container:'.filters_groups_container',filters:[{name:''}],options:options,url_list:url_list});   			
		});		
	}
});
