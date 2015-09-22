jQuery(document).ready(function(){
	
	
	 var queries = {};
			  $.each(document.location.search.substr(1).split('&'),function(c,q){
				var i = q.split('=');
				if(i.length==2){
					queries[i[0].toString()] = i[1].toString();						
				}
			  });				  				  				 						
	
			filters_groups=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(queries["filters_groups"])));																						
			options_str=jQuery('.options_str').val();
	options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(options_str)));	
			jQuery('.filters_groups_container').html('');
			jQuery.each(filters_groups,function(index){							    
				filters=filters_groups[index];																
				//console.log(filters);
				url_list={};
				url_list['get_autocomplete']='meta/get_autocomplete';
				url_list['get_new_filter']='meta/get_new_filter';
				url_list['get_options']='meta/get_options';				
				jQuery.filters({container:'.filters_groups_container',filters:filters,options:options,url_list:url_list});																	
			});	
			
	
				
	hide_elements=['option_unit_user_sub_query','option_unit_show_sql_only','option_unit_render_type'];
	jQuery.search_options({options:options,hide_elements:hide_elements});
	
	//jQuery('.compare_with.search_options').hide();
	/*fire a search request*/
		fire=function(search_button,output){					
				//console.log(111111111111);
				var classes=search_button.attr('class').split(" ");
				var url=classes[1];														
				filters_groups_Str=get_filters();
				optionsStr=get_options();					
                sid=jQuery('.sid').val();				
				//alert(1);
				location=appWebRoot+"sqlPg/fire?sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output='+output;
				
		};
		
		get_options=function(){		
			optionsStr=jQuery('.search_display_options').serialized_options();								
			
			return optionsStr;
		};
 get_filters=function(){
		
			var filters={};
			var filters_groups=[];
		    var iindex=0;
			jQuery('div.filters_groups_instance').each(function(iindex){							
				filters=jQuery(this).filter_seralize();						
			   // console.log(filters);
			    filters_groups[iindex]=filters;
				iindex++;
			});		
			
			var filters_groups_Str = JSON.stringify(filters_groups);					  		
		  return filters_groups_Str;		
		};
		
	if(jQuery('.fire_button').length>0){
		jQuery('.fire_button').live('click',function(){
				jQuery.blockUI();
				fire(jQuery(this),'web');	
		});
	}	
	main_table=jQuery('.main_table').val();
	
	draw_schema_graph=jQuery.draw_schema_graph({container_id:'schema_graph',
	                                         color_node:true,
											 main_node:main_table,
											 nodes_container:'graph_nodes',
											 node_click_event:function(e){
												  
												  var ele = e.cyTarget;	   
												   sid=jQuery('.sid').val();		
												   step=jQuery('.step').val();	
												   main_table=ele.id();												  
												   data={};
												   data["sid"]=sid;
												   data["main_table"]=main_table;
												   data["current_step"]=step;
												   data["next_step"]=step;   				   			;
												   data_json=encodeURIComponent(JSON.stringify(data));
												   location=appWebRoot+"schema/schema_setup?data="+data_json;		  
												}
											});
});
