(function($) {	

	var this_group;
	var this_group_classes=[];
	var this_filter_group_index;
	var last_filter;	
	var opts={};
	var options;
    var default_arg={};
	var url_list={};
	//var appWebRoot='http://localhost/search_template.new/index.php/';
	$.filters=function(arg){			
        options=arg["options"];
		url_list=arg["url_list"];
		if(arg['container']!=undefined&&jQuery(arg['container'])!=undefined){
			container_el=jQuery(arg['container']);
			numberOfGroup=container_el.find('.filters_groups_instance').length;
			this_filter_group_index=numberOfGroup;
			html_str='';
			html_str+='<div class="filters_groups_instance '+this_filter_group_index+'" style="background:#FFFFFF;" data-original-title="" title="">';			
			if(this_filter_group_index>0){
				html_str+='<span style="text-align:center;font-size:14px;padding:0px;background-color:#F0F0F0"><strong>OR</strong></span>';
				html_str+='<a class="delete_or_filter filters_groups_instance '+this_filter_group_index+'" align="left" style="margin:3px;background-color:transparent;cursor:pointer;float:right" data-original-title="" title=""><i title=""  class="icon-trash" data-original-title="Click to delete this filter group"></i></a>';
			}			
			html_str+='<div href="#" style="width:20px;height:20px;margin-top:5px" class="filters_groups_add_filter '+this_filter_group_index+' add_and_filter" title="" data-original-title="Click here to add a filter"></div>( And )';
			html_str+='</div>';			
			last_filter=undefined;		
			container_el.append(html_str);				
			this_group=container_el.find('.filters_groups_instance.'+this_filter_group_index);
			
			bindDeleteORFilter();
			bindAddFilter();
			
			if(default_arg)
				opts= $.extend({},default_arg,arg||{});		
		
			new_filters=[];
			actual_index=0;
			jQuery(opts['filters']).each(function(index){
				
				flag=merge_fields(new_filters,opts['filters'][index]);			
				if(!flag){
					
					new_filters[actual_index]=opts['filters'][index];
					actual_index++;
				}
			});
			
			opts['filters']=new_filters;
					
			return $.fn.filters.dispatcher['_create'](opts);
		}
	}
	$.fn.filters = function(cmd, arg) {
		//address command requests
		
		this_group		=this;
		this_group_class=this_group.attr('class').split(' ');
		this_filter_group_index=this_group_class[1];						
		var opts = $.extend({},default_arg,arg||{});		
		//console.log(opts['filters']);
		last_filter=(this_group.children('div.filter_instance').length?this_group.children('div.filter_instance').last():undefined);
		if (typeof cmd == 'string') {			
			return $.fn.filters.dispatcher[cmd](opts);
		}		
		//return the command dispatcher		
		return $.fn.filters.dispatcher['_create'](opts);
	};

	//create the command dispatcher
	$.fn.filters.dispatcher = {		
		//initialized with options
		_create : function( opts) {		
			creatFilterGroup(opts);
			
			jQuery.unblockUI();
		},
		//toggle the element's display
		add_filter: function(opts) {
			
		    jQuery.each(opts['filters'],function(index){										
				jQuery.each(opts['filters'][index],function(key,value){            				
				   
					add_filter(key,value,this_filter_group_index);												
				});				
			});					         			
		},
		add_multiple_filters:function(opts){	
		
		    jQuery.each(opts['filters'],function(index){						
				
				
				jQuery.each(opts['filters'][index],function(key,value){            				
					add_filter(key,value,this_filter_group_index);												
				});				
			});		
		}		
	};
	
$.fn.filter_seralize=function(cmd,arg){
			this_group		=this;
			this_group_class=this_group.attr('class').split(' ');
			filter_group_index=this_group_class[1];
	
			prefix="div.filters_groups_instance."+filter_group_index+" div ";
			filters=[];
			//console.log(jQuery('[name=status]:checked').val());							
			jQuery(prefix+".search_field.filter_by_field:visible").each(function( general_filter_index){
			this_filter={};
			classes=jQuery(this).attr("class").split(" ");
			filter_index=classes[2];										
			type=jQuery(prefix+".search_field.filter_by_field."+filter_index+" option:selected").attr('class');															
			classes=jQuery(this).attr('class').split(" ");
			filter_fieldname=jQuery(prefix+".search_field.filter_by_field."+filter_index+" option:selected").val();
			    filters[general_filter_index]={};
				this_filter={};
				switch(type){
					
					case 'long_text':
					case 'autocomplete_multi':
					case "autocomplete":														
					case "selector":
						
						filter_fieldvalue=jQuery(prefix+".search_field.filter_by_value."+filter_index).select2('data');
						if(filter_fieldvalue){
							//value_array=filter_fieldvalue.split(/\\|\"/); // some free text have special character need to be escape							
							var i=0;
							var len=0;
							//search for the longest value
							value_array=[];
							jQuery(filter_fieldvalue).each(function(index,one_value){
								
								value_array[index]=one_value.id;
							});															
							
							this_filter[filter_fieldname]=value_array;
							
						}else{
							this_filter[filter_fieldname]="";
						}						
						
						break;
					case "date":
						operator=jQuery(".date_link."+filter_index+":visible").val();																							
					
							if(operator=="be"){								
								filter_fieldvalue1=jQuery(prefix+" input.filter_by_value.datepicker1."+filter_index+":visible").val();
								filter_fieldvalue2=jQuery(prefix+" input.filter_by_value.datepicker2."+filter_index+":visible").val();
								this_filter[filter_fieldname]={operator:operator,value1:filter_fieldvalue1,value2:filter_fieldvalue2};
							}else{
								
								filter_fieldvalue=jQuery(prefix+" input.filter_by_value."+filter_index+":visible").val();								
								this_filter[filter_fieldname]={operator:operator,value:filter_fieldvalue};
							}
						
						break;
					case 'time_frame':					
							time_unit=jQuery(prefix+".time_unit."+filter_index+":visible").val();
							value=jQuery(prefix+".filter_by_value."+filter_index+":visible").val();
							this_filter[filter_fieldname]={value:value,time_unit:time_unit};					
						break;
					
				}
							
				//console.log(filters);
				//alert(1);
				flag=merge_fields(filters,this_filter);			
				if(!flag)
					filters[general_filter_index]=this_filter;
	});	
//	console.log(filters);
	//alert(filters);
	return filters;
	}
	
	function merge_fields(filters,this_filter){
		
		flag=false;
		jQuery(filters).each(function(index,one_filter){
				
			a=JSON.stringify(one_filter);
			b=JSON.stringify(this_filter);
			if(a==b){
				console.log(a+"=="+b);
				flag = true;				
				return false;
				
			}
			//console.log(diff);
		});
		return flag;
	}
	
	
  
	function creatFilterGroup(opts){	
			//console.log(opts['filters']);
			 jQuery.each(opts['filters'],function(index){
               //console.log(index);			 
				jQuery.each(opts['filters'][index],function(key,value){            				
					//value=encodeURIComponent(value);
					add_filter(key,value,this_filter_group_index);												
				});				
			});	
		
	};
	
	// get a filter to filters group
	function add_filter(filter_key,filter_value,filter_group_index){		
		
		jQuery.blockUI();			
		var params={};						
		filter_key=decodeURIComponent(filter_key);
		
		if(!(typeof filter_value == 'object')){
		   // alert(filter_value);
			filter_value=decodeURIComponent(filter_value);							
		}	
		
		filter_group=jQuery('.filters_groups_instance.'+filter_group_index);
		number_of_filters=filter_group.find('.filter_instance').length;
		params['last_index']=number_of_filters-1;		
		params['view_type']=options['view_type'];
		//console.log(options);
		//params['nid_status']=jQuery('[name=nid_status]:checked').val();
		params['filter_group_index']=filter_group_index;
		//console.log(params);
		//the status field of expert view is different from other view .				
		if(filter_key){
			params['default_field']=filter_key;
			if(!(typeof filter_value == 'object')){	
				params['default_value']=filter_value;
			}else{				
				jQuery.each(filter_value,function(key,value){
					if(key=="value")
						params['default_value']=value;
					else	
						params[key]=value;
				});
			}
		}		
		filter_adder=filter_group.find('.filters_groups_add_filter');					
		filter_adder.before('<div class="filter_instance filter'+number_of_filters+' '+filter_group_index+'" style="background:#FFFFFF"></div>');			
		
		var params = JSON.stringify(params);	
		var params=encodeURIComponent(params);
		jQuery.ajax({
				type: "POST",
				url: appWebRoot+url_list["get_new_filter"],
				data: "params="+params,
				dataType: "jsonp",
				timeout: 90000,
				success: function(data, textStatus ){    
					console.log(data);
					html_str=build_template(data);
					if(html_str!='field_invalid'&&jQuery.trim(html_str)!=""){																				    						
						
						//classes=jQuery(html_str).filter('.field').attr('class').split(' ');	
						
						filter_group_index=data.filter_group_index;
						filter_index=data.new_index;						
						filter_group=jQuery('.filters_groups_instance.'+filter_group_index)
						this_filter_instance=filter_group.find('.filter_instance.'+filter_index+'.'+filter_group_index);																		
						this_filter_instance.html(html_str);						
						bindNewFilter(this_filter_instance);					
						
						filter_group.parent().css("height",'auto');									
						filter_field=this_filter_instance.find(".field "+'.search_field.filter_by_field:visible');
						
						option=filter_field.find('option:selected');
						
						classes=option.attr('class');
						class_list=[];
						if(classes!=undefined)
							class_list=classes.split(' ');
						
						//console.log(class_list);
						if(jQuery.inArray('long_text',class_list)>-1){
								
							view_type=options['view_type'];
							bindInstance(filter_field,filter_value);	
							
						}else if(jQuery.inArray('selector',class_list)>-1||jQuery.inArray('autocomplete',class_list)>-1){
							
							//alert(filter_value);
							bindInstance(filter_field,filter_value);		
									
														
						}else if(jQuery.inArray('date',class_list)>-1){
																
							filter_value_field=this_filter_instance.find('.value .filter_by_value:visible');												
							class_list=filter_value_field.attr('class').split(' ');												
							filter_value_field.datepicker({
								dateFormat: "dd M yy",
								changeMonth: true,
								changeYear: true
							});
							bindOperator(this_filter_instance);
						}									
							bindDeleteAndFilter(this_filter_instance);
							jQuery.unblockUI();						
							//apply_tooltip();	
					}else{
						jQuery.unblockUI();	
						jQuery('.filter_instance.filter'+number_of_filters+'.'+filter_group_index).remove();
					}					
				},
				error: function(xhr, textStatus, errorThrown){
					 //warning(xhr['responseText'],false);
				}
		});	
			
		
		
	}
	function build_template(data){
	
		//console.log(data);
	html_str='';	
	if(data.new_index!='filter0'){

		html_str+='<div style="display:inline-block;background-color:lightgray;width:200px;">';
			
			html_str+='<div title="Click to delete this filter" style="cursor:pointer;width:20px;height:20px;" class="delete_filter '+data.new_index+' '+data.filter_group_index+'">';							
			html_str+='</div>';
			
		html_str+='</div>';
	}


	html_str+='<div class="field '+data.new_index+' '+data.filter_group_index+'">';
	search_fields_keys=Object.keys(data.search_fields);
	html_str+='<select id="filter_by_field"  class="search_field filter_by_field '+data.new_index+' '+((data.default_field)?data.default_field:search_fields_keys[0])+'">';
			
			jQuery.map(data.search_fields,function(value,key){
				
				if(data.default_field){
					if(key==data.default_field){
						if(jQuery.isArray(data.search_fields[key])){					 					   
							html_str+= '<option selected class="'+data.search_fields_types[key][0]+'" value="'+key+'">'+data.search_fields[key][0]+'</option>';
						}else
							html_str+= '<option selected class="'+data.search_fields_types[key][0]+'" value="'+key+'">'+data.search_fields[key]+'</option>';
					}else{					
						 if(jQuery.isArray(data.search_fields[key])){					 
							
							 html_str+= '<option class="'+data.search_fields_types[key][0]+'" value="'+key+'">'+data.search_fields[key][0]+'</option>';
						}else
							//debug($search_fields);die;
							//debug($search_fields_types);die;
							if(data.search_fields_types[key]){
								
								html_str+='<option class="'+data.search_fields_types[key][0]+'" value="'+key+'">'+data.search_fields[key]+'</option>';								
							}
							
						}
						
							
				
				}else{
				
					 html_str+='<option class="'+data.search_fields_types[key][0]+'" value="'+key+'">'+data.search_fields[key]+'</option>';
				}
			});
				
	html_str+='</select>';
	html_str+='</div>';

	html_str+='<div class="value '+data.new_index+' '+data.filter_group_index+'">';    
	 	 
	 if(!data.default_field){
		
		search_fields_keys=Object.keys(data.search_fields);
		key=search_fields_keys[0];
		value="";
	 }else{
		key=data.default_field;
		if(data.default_value){
			value=urldecode(data.default_value);		
		}
			
	 }	 	 
	 //debug($search_fields_types[$key][0]);
	 
	 if(data.search_fields_types[key][0]){
		   switch(data.search_fields_types[key][0]){
		    
			case "date":				
			
				 selector_options={"eq":"At",">":"After","<":"Before","be":"Between"};					
				 html_str+='<select  class="date_link search_field filter_by_value '+data.new_index+'">';
				 
				 jQuery.map(selector_options,function(option_text,option_value){
					
						if(data.operator&&(option_value==data.operator))
						
							 html_str+='<option selected="selected" value="'+option_value+'">'+option_text+'</option>';				
						else	
							 html_str+='<option  value="'+option_value+'">'+option_text+'</option>';
							
				 });
		
				html_str+='</select>';
				
				if(data.operator&&data.operator=="be"){
					html_str+= "<input type='text' class='search_field filter_by_value date datepicker1 "+data.new_index+"' value='"+((data.value1)?data.value1:"")+"'/> ";						
					html_str+= "<input type='text' class='search_field filter_by_value date datepicker2 "+data.new_index+"' value='"+((data.value2)?data.value2:"")+"'/> ";						
				}else{
					html_str+= "<input type='text' class='search_field filter_by_value date datepicker1 "+data.new_index+"' value='"+((data.value)?data.value:"")+"'/> ";						
				}				
				break;
			
				
			case 'time_frame':				
			
				html_str+=  "<input type='text' class='search_field filter_by_value time_frame "+data.new_index+"' value='"+((data.value)?data.value:"")+"'>";
				
				selector_options={"days":"Days","weeks":"Weeks","months":"Months"};					
				html_str+= '<select class="time_unit '+data.new_index+' search_field filter_by_value">';

				jQuery.map(selector_options,function(text,key){
				
					if(data.time_unit==key)
						html_str+= '<option selected value="'+key+'">'+text+'</option>';				
					else	
						html_str+='<option  value="'+key+'">'+text+'</option>';				
				
				});
		
				html_str+= '</select>';
				break;
		   }
	  }
	  
		html_str+="</div>";
		return html_str;
	}
	
	function bindDeleteORFilter(){	
		delete_filter_button=this_group.find('.delete_or_filter');
		delete_filter_button.unbind('click');
		delete_filter_button.bind('click',function(){
			classes=jQuery(this).attr('class').split(' ');
			filter_group_index=classes[2];
			jQuery(this).parent().fadeOut(200, function(){jQuery('.filters_groups_instance.'+filter_group_index).remove();});
		});				
		jQuery('.filter_area:visible').css("height",'auto');		
	}
	function bindDeleteAndFilter(this_filter_instance){	
		classes=this_filter_instance.attr('class').split(' ');
		filter_index=classes[1];
		group_index=classes[2];
		filter_group=jQuery('.filters_groups_instance.'+group_index);
		delete_filter_button=filter_group.find('.delete_filter.'+filter_index);		
		delete_filter_button.unbind('click');
		delete_filter_button.bind('click',function(){	
			classes=jQuery(this).attr('class').split(' ');			
			filter_index=classes[1];		
			filter_group_index=classes[2];		
			jQuery(this).parent().fadeOut(200, function(){jQuery('.filter_instance.'+filter_index+'.'+filter_group_index).remove();});
		});				
		jQuery('.filter_area:visible').css("height",'auto');
		
	}
	
	function bindOperator(this_filter_instance){
			operator=this_filter_instance.find("select.date_link");			
			operator.unbind("change");
			operator.bind("change",function(){											
				classes=jQuery(this).attr('class').split(" ");				
				filter_index=classes[3];		
				this_filter_instance=jQuery(this).parent().parent();				
				if(jQuery(this).val()=='be'){						
					this_filter_instance.find('div.value').append("<input type='text' class='search_field filter_by_value date "+filter_index+" datepicker2' /> ").children('.search_field.filter_by_value.'+filter_index).hide().fadeIn(500);			
					this_filter_instance.find("input.filter_by_value.date."+filter_index).datepicker({
										dateFormat: "dd M yy",
										changeMonth: true,
										changeYear: true
								});
					
				}else{
					this_filter_instance.find("input.filter_by_value.datepicker2."+filter_index ).remove();
				}
			});
	}
	
	function bindAddFilter(){		
		/*Add a new And Filter to a filter group*/
		classes=this_group.attr('class').split(' ');
		filter_index=classes[1];
		jQuery('.add_and_filter.'+filter_index).unbind('click');				
		jQuery('.add_and_filter.'+filter_index).bind('click',function(){									
			
			classes=jQuery(this).attr('class').split(' ');
						
			filter_index=classes[1];
			//console.log(options);			
			jQuery('.filters_groups_instance.'+filter_index).filters('add_filter',{filters:[{name:''}]});			
			
		});		
	}
	
	
	// bind events to the new filter
	function bindNewFilter(this_filter_instance){
	
	   filter_by_field=this_filter_instance.find('.filter_by_field');
	 
	   filter_by_field.bind('change',function(event){		   				   	   	   		   
		   
			classes=jQuery(this).attr("class").split(" ");
			filter_index=classes[2];
			//alert(jQuery(this).attr("class"));
			jQuery('div.'+filter_index+'.value').html('');
			bindInstance(jQuery(this),"");
			
	   });	
	}	
	
	function bindInstance(instance,filter_value){	
	
			//console.log(filter_value);
			//filter_value=decodeURIComponent(filter_value);
		   var classes=instance.parent().attr('class').split(" ");
		   var selector=instance;		   
		   filter_index=classes[1];	 			
		   group_index=classes[2];	 			
		   jQuery.blockUI();		   
		   field_name=instance.val();	  			   		   
		   
		   var this_id=instance.attr('id');
		   var option = instance.find('option:selected');		  	   
		   opt_class=option.attr('class');	  	  
		   this_filter_instance=jQuery('div.filter_instance.'+filter_index+'.'+group_index)
		   div_field_by_value=this_filter_instance.find("div.value");
		   
		  switch(opt_class){	
		  
		    case 'long_text':
			
				if(div_field_by_value.find('.filter_by_value').length==0){
					div_field_by_value.html("<select  class='search_field filter_by_value text "+filter_index+' '+field_name+"' ></select> ").children('.search_field.filter_by_value.'+filter_index).hide().fadeIn(200);			 
				}
				div_field_by_value_select=div_field_by_value.find('select.filter_by_value');
				div_field_by_value_select.select2({				
					multiple: true,
					tags:true,
					width: 'resolve'
				});
				if(filter_value!=""){
					//console.log(filter_value);
					jQuery(filter_value).each(function(index,value){
					
					    div_field_by_value_select.append('<option value="'+value+'">'+value+'</option>'); 
					});
					div_field_by_value_select.select2('val',filter_value);
					    
				}
				jQuery.unblockUI();
				break;
			case "text":
				 div_field_by_value.html("<input  type='text'  class='search_field filter_by_value text "+filter_index+' '+field_name+"' /> ").children('.search_field.filter_by_value.'+filter_index).hide().fadeIn(200);			 
				 div_field_by_value.children('input.'+filter_index+":visible").val("");	
				 jQuery.unblockUI();
				break;
			case "autocomplete":	
			case "selector":			 
				 
				// jQuery(prefix+':visible:nth-child(2) input.filter_by_value'+filter_index+":visible").val(" ");	 
				 					
					view_type=options['view_type'];		
					
					if(div_field_by_value.find('.filter_by_value').length==0){
						div_field_by_value.html('<select class="search_field filter_by_value selector '+filter_index+' '+field_name+'">');
						
					}
					
					div_field_by_value_select=div_field_by_value.find('select.filter_by_value.'+field_name);
					
					//console.log(div_field_by_value_select.attr('class')+"--"+field_name);
					
					div_field_by_value_select.select2({
						multiple: true,
						width: 'resolve',
						ajax: {
						  url: appWebRoot+url_list["get_options"]+"?field_name="+field_name+"&filter_index="+filter_index+"&filters_groups_index="+this_filter_group_index,
						  dataType: 'jsonp',	
						  method:'POST',			  
						  data: function (param) {
							
							return {
							  q: param.term,
							 // field_name:field_name,
							  //filter_index:filter_index,
							  //filters_groups_index:this_filter_group_index,
							  view_type:view_type,
							  data_type:'json'
							};
						  },			
						  processResults: function (data, page) {																								
							var result = jQuery.each(data, function (i,k) {										
								return { id: k.id,text:k.keyword,value: k.keyword };
							});														
							return { results: result};
						  },
						  initSelection: function(element, callback) {
						  
							console.log(element);
						  }
						  
						}
					});
					
					if(!$.isArray(filter_value)){
					   //console.log(filter_value);
					   filter_value=[filter_value];
					   
					 }
					if(filter_value!=""){
					
						jQuery(filter_value).each(function(index,value){					
							div_field_by_value_select.append('<option value="'+value+'">'+value+'</option>'); 
						});
						
						div_field_by_value_select.select2('val',filter_value);
						
						
					}else{
						div_field_by_value_select.select2('val',[]);
					}
					//console.log(div_field_by_value_select.attr('class'));    
					jQuery.unblockUI();			
					break;
				
			case "date":	
				 comp_string='<select class="search_field filter_by_value date '+filter_index+' '+field_name+' date_link"><option selected="selected" value="eq">At</option><option value="&gt;">After</option><option value="&lt;">Before</option><option value="be">Between</option></select>'
				 div_field_by_value.html(comp_string).children('.search_field.filter_by_value.'+filter_index).hide().fadeIn(500);
				 div_field_by_value.append("<input type='text'  class='search_field filter_by_value date "+filter_index+' '+field_name+" datepicker1' /> ").children('.search_field.filter_by_value.'+filter_index).hide().fadeIn(500);			 
				 div_field_by_value.find("input.filter_by_value.date."+filter_index+":visible").datepicker({
									dateFormat: "dd M yy",
									changeMonth: true,
									changeYear: true
							});
		        bindOperator(this_filter_instance);
				jQuery.unblockUI();			
				break;

			case 'time_frame':
				div_field_by_value.html("<input  type='text' class='search_field filter_by_value time_frame "+filter_index+' '+field_name+"'/>").children('.search_field.filter_by_value.'+filter_index);			
				time_string='<select  class="search_field filter_by_value time_unit '+filter_index+'"><option selected="selected" value="days">Days</option><option value="weeks">Weeks</option><option value="months">Months</option></select>';
				div_field_by_value.append(time_string).children('.search_field.filter_by_value.'+filter_index);			 
				jQuery.unblockUI();		
				break;
				
			default:
				jQuery.unblockUI();
				break;				
		  }	
	}
		
})(jQuery);

