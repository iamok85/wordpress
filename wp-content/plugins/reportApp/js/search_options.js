(function($) {	
	
	var url="metaJson/set_search_options";			
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
				dataType: "jsonp",
				jsonpCallback: 'callback',
				data: "options_str="+optionsStr,
				timeout: 90000,
				success: function(data, textStatus ){           																	    
					//alert(1);
					html_str=build_template(data);	
					//console.log(html_str);
					jQuery('#search_display_options').html(html_str);
					sid=data.options.view_type;
					select2_list_by=initialize_list_by(sid);
					selectedValues=[];				    
					options=select2_list_by.find('option');
					jQuery(options).each(function(index){					
						selectedValues[index]=jQuery(this).val();
					});
					select2_compare_with=initialize_compare_with(sid);
					selectedValues=[];
					options=select2_compare_with.find('option');
					jQuery(options).each(function(index){					
						selectedValues[index]=jQuery(this).val();
					});
					select2_compare_with.select2('val',selectedValues);
				},
				
				error: function(xhr, textStatus, errorThrown){
					alert('Search Option setting goes wrong!');
				}
		});		
	}
		
	function build_template(data){
		
		html_str='';
		html_str+='<h4 class="field-label">Display Options</h4>';		
		html_str+='<div class="option_unit controls">';
		
		html_str+='<label class="control-label" for="inputListResultsBy"><strong>Group by</strong></label>';
		html_str+='<div >';
						
		html_str+='<select class="list_by search_options"  name="list_by" style="width: 230px;" >';
			
			if(data.options.list_by){
				 
				jQuery(data.options.list_by).each(function(index,list_by){
				
					html_str+='<option value="'+list_by+'">'+data.listby_options[list_by]+'</option>';
				});				
			}
			 
		html_str+='</select>';
		html_str+='</div>';
		html_str+='</div>';
		
		
		html_str+='<div class="option_unit controls" >';
		html_str+='<label class="control-label" ><strong>View Detail of</strong></label>';
		html_str+='<div class="controls">';
			
		html_str+='<select class="compare_with search_options"  name="compare_with" style="width: 230px;" >';
			
			    if(data.options.compare_with){
					
					jQuery(data.options.compare_with).each(function(index,compare_field){
						
						html_str+='<option value="'+compare_field.logic_field+'">'+data.comparewith_options[compare_field.logic_field]+'</option>';
					});
					  	
				}										
				 
		html_str+='</select>';
		html_str+='</div>';
		html_str+='</div>'
		
		html_str+='<div class="option_unit_render_type controls" data-original-title="" title="" >';
		
		html_str+='<label class="control-label" for="pagination"><strong>Render Type</strong></label>';
					
		if(!data.options.render_type){
			
			data.options.render_type="table";
		}
		
		html_str+='<select style="width: 230px;" id="render_type" class="search_options render_type width-auto margin-zero" name="render_type" data-original-title="" title="">';
		html_str+='<option '+((data.options.render_type=="graph")? "selected":"")+' value="graph">Graph</option>';
		html_str+='<option '+((data.options.render_type=="table")? "selected":"")+'  value="table">Table</option>';
		html_str+='<option '+((data.options.render_type=="cluster")? "selected":"")+' value="cluster">Cluster</option>';
		html_str+='<option '+((data.options.render_type=="map")? "selected":"")+' value="map">Map</option>';
		html_str+='</select>';
		html_str+='</div>';
		
		html_str+='<div class="option_unit controls">';
		html_str+='<label class="control-label" for="inputOrderResultsBy"><strong>Order by</strong></label>';
		html_str+='<div>';
			
			
		html_str+='<select name="order_by" class="search_options order_by " style="width:130px;" title="Order the search result by one of these fields">';
		
		html_str+='<option></option>';
		//console.log(data.orderby_options[data.options.view_type]);
		jQuery.map(data.orderby_options[data.options.view_type],function(value, key){
		
				
				if(data.options.order_by&&key==data.options.order_by) {
				
					html_str+='<option value="'+key+'" selected>'+value+'</option>';
					
				}else{
				
					html_str+='<option value="'+key+'">'+value+'</option>';
				}	
									
		}); 
		html_str+='</select>';
		html_str+='</div>';
		html_str+='</div>';
	
	
		html_str+='<div class="option_unit controls">';
		order_seq_options={'':'','asc':'Ascend','desc':'Descend'};
		html_str+='<select name="order_by_seq" class="search_options order_by_seq " style="width:90px;" title="Order Ascendantly or Descendantly">';
			
		jQuery.map(order_seq_options,function(value, key){
			
			if(data.options.order_by_seq&&key==data.options.order_by_seq) {
			
				html_str+='<option value="'+key+'" selected>'+value+'</option>';
				
			}else{
			
				html_str+='<option value="'+key+'">'+value+'</option>';
				
			}
			
		});
		html_str+='</select>';
		html_str+='</div>';
	
		
		
		display="";
		if(data.options.render_type=='graph'){
			display="display:none";
		}
		
		html_str+='<div style="'+display+'" class="option_unit controls" data-original-title="" title="" >';
		
		html_str+='<label class="control-label" for="pagination"><strong>Results Per Page</strong></label>';

		html_str+='<select style="width:70px" id="pagination" class="search_options pagination width-auto margin-zero" name="pagination" data-original-title="" title="">';
		
		pagination_type=[20,40,60];
		
		jQuery(pagination_type).each(function(index,value){
		
			if(data.options.pagination==value){
			
				html_str+='<option selected="selected" value="'+value+'">'+value+'</option>';
			}else{
				html_str+='<option value="'+value+'">'+value+'</option>';
			}

		});
	html_str+='</select>';
	html_str+='</div><br/>';
	
	html_str+='<div class="option_unit_show_sql_only controls" data-original-title="" title="" >';
	html_str+='<label class="control-label" for="pagination"><strong>Show SQL Only</strong></label>';
	
	if(data.options.show_sql_only){
	
		html_str+='<input type="checkbox" id="show_sql_only" checked class="search_options show_sql_only width-auto margin-zero" name="show_sql_only" data-original-title="" title="">';
	}else{
		
		html_str+='<input type="checkbox" id="show_sql_only" class="search_options show_sql_only width-auto margin-zero" name="show_sql_only" data-original-title="" title="">';
	}
	
	html_str+='</div>';

	html_str+='<div class="option_unit_user_sub_query controls" data-original-title="" title="" >';
	html_str+='<label class="control-label" for="pagination"><strong>Use Sub query</strong></label>';
	if(data.options.use_sub_query){
		
		html_str+='<input type="checkbox" id="use_sub_query" checked class="search_options use_sub_query width-auto margin-zero" name="use_sub_query" data-original-title="" title="">';
		
	}else{
		
		html_str+='<input type="checkbox" id="use_sub_query" class="search_options use_sub_query width-auto margin-zero" name="use_sub_query" data-original-title="" title="">';
	}		
	html_str+='</div>';


	if(data.options.render_type=='graph'){

		if((data.options.compare_with)&&data.options.compare_with.length>1){
			
			html_str+='<div class="option_unit controls" data-original-title="" title="" >';
			
			html_str+='<label class="control-label"><strong>Combine Diagrams<strong></label>';
				
				if(isset(data.options.combine)){
					html_str+='<input type="checkbox" id="combine" checked class="search_options combine width-auto margin-zero" name="combine" data-original-title="" title=""/>';
				}else{		
					html_str+='<input type="checkbox" id="combine" class="search_options combine width-auto margin-zero" name="combine" data-original-title="" title=""/>';
				}		
			html_str+='</div>';
			
		}else{
			
			html_str+='<div style="display:none" class="option_unit controls" data-original-title="" title="" >';
			html_str+='<label class="control-label"><strong>Combine Diagrams<strong></label>';
			html_str+='<input type="checkbox" id="combine" class="search_options combine width-auto margin-zero" name="combine" data-original-title="" title=""/>';
			html_str+='</div>';
		
		}
	}else{

		html_str+='<div style="display:none" class="option_unit controls" data-original-title="" title="" >	';
		html_str+='<label class="control-label"><strong>Combine Diagrams<strong></label>';
		html_str+='<input type="checkbox" id="combine" class="search_options combine width-auto margin-zero" name="combine" data-original-title="" title=""/>';
		html_str+='</div>';
	}					
		html_str+='<div class="option_unit" data-original-title="" title="" >';
		html_str+='<input type="hidden" value="'+data.options.view_type+'" name="view_type" class="search_options view_type" />';
		html_str+='</div>';		
		return html_str;
		
	}	
		
	function initialize_compare_with(sid){
	
		select2_compare_with=jQuery('select.compare_with');
		select2_compare_with.select2({
			placeholder: 'Enter Compare With Field Name',
			multiple: true,
			width: 'resolve',
			ajax: {
			  url: appWebRoot+"metaJson/get_autocomplete?sid="+sid+"&field_name=search_compare_with&format=json&view_type="+sid,
			  dataType: 'jsonp',								  
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
			  url: appWebRoot+"metaJson/get_autocomplete?sid="+sid+"&field_name=search_list_by&format=json&view_type="+sid,
			  dataType: 'jsonp',
			  
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
			//setting_check(jQuery(this));			
		});	


})(jQuery);

