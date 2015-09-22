(function($) {	
	
	var url="meta/set_search_options";			
	var params=[];
	var options_str="";
	var options={};
	var hide_elements;
	var instant_update=false;
	$.search_options=function(arg){			
		options=arg['options'];			
		hide_elements=arg['hide_elements'];
		//console.log(hide_elements);
		if(arg['instant_update']!=undefined)
			instant_update=arg['instant_update'];			
		update_options(options);
	}				
   $.fn.serialized_options=function(){	     
		var options={};
			jQuery('.search_options').each(function(){					
				if(jQuery(this).hasClass('view_type')){			
				   	
					options['view_type']=jQuery('input[name=view_type]').val();				   			
				}
				if(jQuery(this).hasClass('show_sql_only')){			
				   if(jQuery('input[name=show_sql_only]').attr('checked')){
						options['show_sql_only']=1;
				   }else{
						options['show_sql_only']=0;
				   }				
				}				
				if(jQuery(this).hasClass('use_sub_query')){			
				   if(jQuery('input[name=use_sub_query]').attr('checked')){
						options['use_sub_query']=1;
				   }else{
						options['use_sub_query']=0;
				   }				
				}
				
				if(jQuery(this).hasClass('combine')){			
				
				   if(jQuery('input[name=combine]').attr('checked')){				   
						options['combine']=1;						
				   }else{				   
						options['combine']=0;						
				   }				
				}
											
				options['render_type']=jQuery('select[name=render_type] option:selected').val();
				
				if(jQuery(this).hasClass('pagination')){			
				 
					options['pagination']=jQuery(this).val();
								
				}
								
				if(jQuery(this).hasClass('order_by'))
					if(jQuery('select[name=order_by]').val()!="")			
						options['order_by']=jQuery('select[name=order_by]').val();				
				
				if(jQuery(this).hasClass('order_by_seq'))
					if(jQuery('select[name=order_by_seq]').val()!="")			
						options['order_by_seq']=jQuery('select[name=order_by_seq]').val();	
					
				if(jQuery(this).hasClass('list_by')){
					options['list_by']=[];
					select2_list_by=jQuery('select.search_options.list_by');
					
					data=select2_list_by.select2('data');					
					
					index=0;
					while(index<data.length){
						if(data[index]['id']&&data[index]['id']!=""){						
							options['list_by'][index]=data[index]['id'];						
						}
						index++;
					}
					//console.log(options['list_by']);
				}											
				
				if(jQuery(this).hasClass('compare_with')){					
					options['compare_with']=[];
					select2_compare_with=jQuery('.search_options.compare_with');
					data=select2_compare_with.select2('data');										
					index=0;
				//	console.log(data);
					while(index<data.length){						
						//console.log(data[index]['id']);
						if(data[index]['id']&&data[index]['id']!=""){												
							options['compare_with'][index]={};																				
							function_name=jQuery('div.function_name.'+data[index]['id']).find('select').val();														
							options['compare_with'][index]['logic_field']=data[index]['id'];							
							diagram_type=jQuery('.diagram_type.'+data[index]['id']+'.'+function_name).val();
							options['compare_with'][index]['compare_function']={"function_name":function_name,'diagram_type':diagram_type};							
						}
						index++;
					}					
				}
					
				if(jQuery(this).hasClass('view_type')){	
					//console.log(jQuery(this).val());
					options['view_type']=jQuery(this).val();						
				}
				if(jQuery(this).hasClass('inactive_position')){
					//console.log(jQuery('input[name=inactive_position]').attr('checked'));
					if(jQuery('input[name=inactive_position]').attr('checked')){
						options['inactive_position']=jQuery(this).val();
					}
				}						
			});		
			
			//console.log(options['compare_with']);
			var optionsStr = JSON.stringify(options);			
			//console.log(optionsStr);
		return 	optionsStr;

	}   
	
	function update_options(options){
		var optionsStr = JSON.stringify(options);			
		
		jQuery.ajax({
				type: "POST",
				url: appWebRoot+url,
				data: "options_str="+optionsStr,
				timeout: 90000,
				success: function(data, textStatus ){           																	    
					//alert(1);
					sid=options['view_type'];
					jQuery('#search_display_options').html(data);
					select2_list_by=initialize_list_by(sid);				
				    selectedValues=[];				    
					other_options=select2_list_by.find('option');
					jQuery(other_options).each(function(index){					
						selectedValues[index]=jQuery(this).val();
					});
					//select2_list_by.select2('val',selectedValues);																
					select2_compare_with=initialize_compare_with(sid);					
					selectedValues=[];
					other_options=select2_compare_with.find('option');
					jQuery(other_options).each(function(index){					
						selectedValues[index]=jQuery(this).val();
					});
					select2_compare_with.select2('val',selectedValues);
			  
					render_type=jQuery('select.render_type').val();
					/*if(render_type=="graph")
						rebuild_compare_option_section(selectedValues);
					*/	
					selectedValues=[];
					other_options=select2_list_by.find('option');
					jQuery(other_options).each(function(index){					
						selectedValues[index]=jQuery(this).val();
					});			  
					select2_list_by.select2('val',selectedValues);					
					jQuery('#add_or_filter').show();	
				},
				
				error: function(xhr, textStatus, errorThrown){
					alert('Search Option setting goes wrong!');
				}
		});		
	}
							
		
	function initialize_compare_with(sid){
	
		select2_compare_with=jQuery('select.compare_with');
		select2_compare_with.select2({
			placeholder: 'Enter Compare With Field Name',
			multiple: true,
			width: 'resolve',
			ajax: {
			  url: appWebRoot+"meta/get_autocomplete?sid="+sid+"&field_name=search_compare_with&format=json&view_type="+sid,
			  dataType: 'json',								  
			  data: function (term, page) {
				return {
				  q: term
				};
			  },			
			  processResults: function (data, page) {																								
				var result = jQuery.each(data, function (i,k) {										
					return { id: k.id,text:k.keyword,value: k.keyword };
				});														
				return { results: result};
			  }
			}
		});
		//alert(12);
		jQuery('select.compare_with').on("change", function (e) {		   
			values=e.val;					
			render_type=jQuery('select.render_type').val();
			/*if(render_type=="graph")
				rebuild_compare_option_section(values);						*/
		});
		
		return select2_compare_with;
	}
	
	function rebuild_compare_option_section(values){
		
		    compare_field_functions=[];
			jQuery(values).each(function(index){
			  
					compare_function={};
					if(jQuery('div.'+values[index]+'.function_name').length>0){						
						function_name=jQuery('div.'+values[index]+'.function_name select option:selected').val();					
						diagram_type=jQuery('select.'+function_name+".diagram_type"+"."+values[index]).val();																		
						compare_function['function_name']=function_name;
						compare_function['diagram_type']=diagram_type;
					}
					compare_field_functions[index]={'logic_field':values[index],'compare_function':compare_function};			
			  });			
		  
				compare_field_functions_str=encodeURIComponent(JSON.stringify(compare_field_functions));		  
				sid=jQuery('.sid').val();				
				url=appWebRoot+"report/get_added_function_names?sid="+sid+"&compare_field_functions_str="+compare_field_functions_str+'&view_type='+sid;
				jQuery.ajax({
						type: "GET",
						url:url,
						timeout: 1000*60*5,
						success: function(data, textStatus ){								
							jQuery('div.function').html(data).hide().fadeIn(1000);																																				
						},
						error: function(xhr, textStatus, errorThrown){
							 
						}
			    });
					if(hide_elements.length>0){
						
						jQuery(hide_elements).each(function(index,value){
						
							jQuery("."+value).hide();
						});
					}
		
	}
	
	function initialize_list_by(sid){
		
		select2_list_by=jQuery('select.list_by');
		select2_list_by.select2({
			placeholder: 'Enter List By Field Name',
			minimumInputLength: 0,
			multiple: true,
			width: 'resolve',
			ajax: {
			  url: appWebRoot+"meta/get_autocomplete?sid="+sid+"&field_name=search_list_by&format=json&view_type="+sid,
			  dataType: 'json',
			  
			  data: function (term, page) {
				return {
				  q: term
				};
			  },															 
			  processResults: function (data, page) {																				
				var result = jQuery.each(data, function (i,k) {										
					return { id: k.id,text:k.keyword,value: k.keyword };
				});										
				return { results: result };
			  }
			}
		});
		return select2_list_by;
	}
	
		
		setting_check=function(element){	
           classes=element.attr('class').split(" ");
		   if(classes[1]!=undefined)
				option_type=classes[1];
			else
				option_type="";
			
			if(option_type=="render_type"||option_type=="show_sql_only"){
				
				select2_compare_with=jQuery('select.search_options.compare_with');							
				values=select2_compare_with.select2('val');										
				rebuild_compare_option_section(values);		
			}
		   
		   var optionsStr = jQuery(this).serialized_options();		   		   
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));						   		     
		   	if(options['render_type']=='table'){		
						
				select2_compare_with=jQuery('select.search_options.compare_with');															
				values=select2_compare_with.select2('data');														
				if(values.length>0){					
					index=values.length-1;
					select2_compare_with.select2('data',values[index]);																
				}														
				jQuery('input[name=combine]').parent().hide();															
				
				jQuery('.search_options.diagram_type').each(function(){					
					jQuery(this).hide();
				});
				//jQuery('.diagram_setting').hide();
			}else{				
				if(options['compare_with'].length>1){							
					jQuery('input[name=combine]').parent().show();									
				}else{
					jQuery('input[name=combine]').parent().hide();
				}								
				//jQuery('.diagram_setting').show();		
				jQuery('.search_options.diagram_type').each(function(){					
					jQuery(this).show();
				});
				jQuery('input[name=combine]').parent().show();															
				
			}
			
			if(options['show_sql_only']==0){			
			
				
				if(options['render_type']=='graph'){			
					if(options['compare_with'].length>1){
						jQuery('input[name=combine]').parent().show();							
					}else{
						jQuery('input[name=combine]').parent().hide();									
					}
					jQuery('.search_options.diagram_type').each(function(){					
						jQuery(this).show();
					});
				}else{
					jQuery('input[name=combine]').parent().hide();
					jQuery('.search_options.diagram_type').each(function(){					
						jQuery(this).hide();
					});
				}				
				jQuery('select[name=render_type]').parent().show();				
		   }else{		
		   
				jQuery('input[name=combine]').parent().hide();
				jQuery('select[name=render_type]').parent().hide();
				jQuery('.search_options.diagram_type').each(function(){					
					jQuery(this).hide();
				});
		   }
			
			
		}
	
		jQuery('div.function_name select').live('change',function(){
			
			select2_compare_with=jQuery('select.search_options.compare_with');							
			values=select2_compare_with.select2('val');										
			rebuild_compare_option_section(values);			
		});
	
		jQuery('.search_options').live('change',function(){													
			setting_check(jQuery(this));			
		});	


})(jQuery);

