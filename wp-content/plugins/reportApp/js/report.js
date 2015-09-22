
jQuery(document).ready(function(){
	
(function($){
	get_options=function(){
		options_str=jQuery('.options_str').val();
		return options_str;
	}
})(jQuery);


  jQuery('.navigate_report').live('click',function(){	
	 current_step=jQuery('input.current_step').val();
	 classes=jQuery(this).attr('class').split(' ');	 	 	 
	 next_step=classes[1];
	 get_steps(current_step,next_step);
	});	   
	
	function get_steps(current_step,next_step){
		sid=jQuery('.sid').val();	 	
		data="current_step="+current_step+"&next_step="+next_step+'&sid='+sid;	
       switch(current_step)	{
	        case '0':	
				initial_filters_str=get_filters();		    
				data="current_step="+current_step+"&next_step="+next_step+'&sid='+sid+"&initial_filters_str="+initial_filters_str;				
				break;
			case '1':				
				break;
			case '2':
				//console.log(data);		
				options_str=jQuery('.search_display_options').serialized_options()+"";												
				data="options_str="+encodeURIComponent(options_str)+"&current_step="+current_step+"&next_step="+next_step+'&sid='+sid;
				break;
			case '3':
				field_map={};
          		jQuery('table.table').each(function(index){
					checked_fields=jQuery(this).find("input.field:checked");
					field_classes=jQuery(this).attr('class').split(" ");
					table=field_classes[0];
					fields=[];
					jQuery(checked_fields).each(function(index){
						classes=jQuery(this).attr('class').split(' ');
						fields[index]=next_step;
					});
					field_map[table]=fields;					
				});	
				fields_map_str=encodeURIComponent(JSON.stringify(field_map));	
				data=data+"&fields_map_str="+fields_map_str;
				break;
				   
	   }
	   //console.log(data); return;
	   location=appWebRoot+"report/report_setup?"+data;
		
	}
  
	function create_filter(initial_filters_str){	
		options={};
		url_list={};
		url_list['get_autocomplete']='meta/get_autocomplete';
		url_list['get_new_filter']='meta/get_new_filter';
		url_list['get_options']='meta/get_options';			
		options['view_type']=jQuery('.sid').val();	 
		
		filters=[];
		filter_field=jQuery('.search_field option:selected').val();
		filters[0]={}
		filters[0][filter_field]="";		
		
		if(initial_filters_str!=""){
			filters_groups=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(initial_filters_str)));				
			jQuery(filters_groups).each(function(index){		
				jQuery.filters({container:'.filters_groups_container',filters:filters_groups[index],options:options,url_list:url_list});																			
			});
		}else{
			
			filters=[];
			filter_field=jQuery('.search_field option:selected').val();
			filters[0]={}
			filters[0][filter_field]="";
			jQuery.filters({container:'.filters_groups_container',filters:filters,options:options,url_list:url_list});																			
		}
		

		
	}
  
	function get_fields(table,pclass){
		
		 records_map={};
		 jQuery('table.table.'+table).each(function(index){	   
          	classes=jQuery(this).attr('class').split(" ");	 
			table=classes[0];
			selected_fields=jQuery(this).find(pclass);
			records=[];			
			jQuery(selected_fields).each(function(new_index){				
				field_list=jQuery(this).find('.field_list');
				filter_type=jQuery(this).find('.filter_types');
				operator_type=jQuery(this).find('.operator_types');				
				record={};
				if(field_list.is("select")){
					field_selected=field_list.find('option:selected').val();
					type_selected=filter_type.find('option:selected').val();
					operator_selected=operator_type.find('option:selected').val();
				}else if(field_list.is("input")){
					field_selected=field_list.val();
					type_selected=filter_type.val();
					operator_selected=operator_type.val();
				}
				record['field_selected']=field_selected;
				record['type_selected']=type_selected;
				record['operator_selected']=operator_selected;				
				records[new_index]=record;
			});
			//console.log(records.length);
			//alert(1);
			records_map[table]=records;
		
		 });	
        	 
		 records_map_str=encodeURIComponent(JSON.stringify(records_map));
		 return records_map_str;
	}
	 
  jQuery('.add_filter_field').live('click',function(){
	    
		
			field_list=jQuery('tr.filter_field.new').find('.field_list');
			filter_type=jQuery('tr.filter_field.new').find('.filter_types');
			operator_type=jQuery('tr.filter_field.new').find('.operator_types');				
			record={};
			
			field_selected=field_list.find('option:selected').val();
			type_selected=filter_type.find('option:selected').val();
			operator_selected=operator_type.find('option:selected').val();
		
			record['field_selected']=field_selected;
			record['type_selected']=type_selected;
			record['operator_selected']=operator_selected;				
			sid=jQuery('.sid').val();	  
			record_str=encodeURIComponent(JSON.stringify(record));
		    data="record_str="+record_str+"&current_step=0"+"&next_step=0"+'&sid='+sid+"&action=add_filter_field";		
	 
			location=appWebRoot+"report/report_setup?"+data;
  });

  jQuery('.delete_filter_field').live('click',function(){
	 
	 classes=jQuery(this).attr('class').split(" ");	 
	 filter_field=classes[1];     	
	 sid=jQuery('.sid').val();	  	 
	 initial_filters_str=get_filters();
	 
	 data="filter_field="+filter_field+"&current_step=0"+"&next_step=0"+'&sid='+sid+"&action=delete_filter_field&initial_filters_str="+initial_filters_str;		
	 location=appWebRoot+"report/report_setup?"+data;
  });  
  
  jQuery('input.initialize').live('click',function(){
  
	classes=jQuery(this).attr('class').split(' ');
	type=classes[1];
	logic_field=classes[2];
	sid=jQuery('.sid').val();	 
	current_step=jQuery('input.current_step').val();	 	 	 
	 attributes={};
	 attributes['logic_field']=logic_field;	 
	 if(jQuery(this).attr('checked'))
		attributes['initialize']=1;
	 else
	 	attributes['initialize']=0;
		attributes_str=encodeURIComponent(JSON.stringify(attributes));	 	 	 		
		data="attributes="+attributes_str+"&current_step="+current_step+"&next_step="+current_step+'&sid='+sid+"&action=initialize_field&type="+type;			 
		location=appWebRoot+"report/report_setup?"+data;
  });
  
   jQuery('.add_function_type').live('click',function(){
		
		classes=jQuery(this).attr('class').split(' ');	
		compare_field=classes[1];
		function_name=jQuery('select.new_function_type option:selected').val();
		current_step=jQuery('input.current_step').val();	 	 	 
		data="current_step="+current_step+"&next_step=1"+'&sid='+sid+"&action=add_function_type&function_name="+function_name+"&compare_field="+compare_field;			 
		location=appWebRoot+"report/report_setup?"+data;
			
   });
   
   jQuery('.edit_function').live('click',function(){	
   
		classes=jQuery(this).attr('class').split(' ');	
		function_name=classes[1];		
		compare_field=classes[2];		
		sid=jQuery('input.sid').val();
		current_step=jQuery('input.current_step').val();		
		parameter='';
		parameter+="function_name="+function_name;
		parameter+="&compare_field="+compare_field;
		parameter+="&sid="+sid;		
		parameter+="&current_step="+current_step;		
		parameter+="&action=list";	
		location=appWebRoot+'/report/edit_function?'+parameter;					
   });
   
   jQuery('.add_diagram_type').live('click',function(){	
   
		
		function_name=jQuery('.edit_function.function_name').val();		
		compare_field=jQuery('.edit_function.compare_field').val();				
		sid=jQuery('input.sid').val();		
		current_step=jQuery('input.current_step').val();		
		new_diagram_type=jQuery('select.new_diagram_type option:selected').val();
		parameter='';
		parameter+="function_name="+function_name;
		parameter+="&compare_field="+compare_field;
		parameter+="&sid="+sid;				
		parameter+="&diagram_type="+new_diagram_type;						
		parameter+="&current_step="+current_step;		
		parameter+="&action=add";	
		location=appWebRoot+'/report/edit_function?'+parameter;					
   });
   
   jQuery('.delete_diagram_type').live('click',function(){	
		
		classes=jQuery(this).attr('class').split(' ');
		diagram_type=classes[1];		
		function_name=jQuery('.edit_function.function_name').val();		
		compare_field=jQuery('.edit_function.compare_field').val();				
		sid=jQuery('input.sid').val();		
		current_step=jQuery('input.current_step').val();		
		new_diagram_type=jQuery('select.new_diagram_type option:selected').val();
		parameter='';
		parameter+="function_name="+function_name;
		parameter+="&compare_field="+compare_field;
		parameter+="&sid="+sid;				
		parameter+="&diagram_type="+diagram_type;						
		parameter+="&current_step="+current_step;		
		parameter+="&action=delete";	
		location=appWebRoot+'/report/edit_function?'+parameter;					
   });
   
   jQuery('.delete_function_type').live('click',function(){
		
		classes=jQuery(this).attr('class').split(' ');	
		function_name=classes[1];		
		compare_field=classes[2];		
		current_step=jQuery('input.current_step').val();	 	 	 
		data="current_step="+current_step+"&next_step=1"+'&sid='+sid+"&action=delete_function_type&function_name="+function_name+"&compare_field="+compare_field;			 
		location=appWebRoot+"report/report_setup?"+data;
			
   });
   
   jQuery('.add_button').live('click',function(){
     data="";
	 classes=jQuery(this).attr('class').split(" ");	 
	 type=classes[1];
	 if(type=="display"||type=="export"){	 	 		
		compare_field=classes[2];		
		data="compare_field="+compare_field+"&";
		field=jQuery('select.new_'+type+'_field.'+compare_field+' option:selected').val();	 
	 }else{
		field=jQuery('select.new_'+type+'_field option:selected').val();	 
	 }
	 sid=jQuery('.sid').val();	 
	 current_step=jQuery('input.current_step').val();	 	 	 	 
	 attributes={};
	 attributes['logic_field']=field;	 
	 attributes['initialize']=0;
	 attributes_str=encodeURIComponent(JSON.stringify(attributes));	 
	 
	 data+="attributes="+attributes_str+"&current_step="+current_step+"&next_step=1"+'&sid='+sid+"&action=add_field&type="+type;			 
	 location=appWebRoot+"report/report_setup?"+data;
  });

  jQuery('.delete_button').live('click',function(){
	 data="";
	 classes=jQuery(this).attr('class').split(" ");
	 field=classes[1];     
	 type=classes[2];     
	 if(type=="display"||type=="export"){
		compare_field=classes[3];     				
		data="compare_field="+compare_field+"&";		
	 }
	 sid=jQuery('.sid').val();	  
	 current_step=jQuery('input.current_step').val();	 
	 data+="field="+field+"&current_step="+current_step+"&next_step=1"+'&sid='+sid+"&action=delete_field&type="+type;			
	 location=appWebRoot+"report/report_setup?"+data;
  });
  
  
  jQuery('.edit_button').live('click',function(){
	 classes=jQuery(this).attr('class').split(" ");
	 field=classes[1];     
	 type=classes[2];     
	 sid=jQuery('.sid').val();	  
	 current_step=jQuery('input.current_step').val();	 
	 data="field="+field+"&current_step="+current_step+"&next_step=1"+'&sid='+sid+"&action=edit_field&type="+type;			
	 location=appWebRoot+"report/report_setup?"+data;
  });
  
  
  jQuery('select.table_list').live('change',function(){
		jQuery.blockUI();				
		main_table=jQuery(this).find("option:selected").val();				
		sid=jQuery('.sid').val();
		data="current_step=0&next_step=0&sid="+sid+"&action=edit&main_table="+main_table;
		location=appWebRoot+"schema/setup?"+data;		
		
  });
  jQuery('.edit_associated_table').live('click',function(){
  
		jQuery.blockUI();
		tr_edit=jQuery(this).parent().parent();					
		main_table=tr_edit.find('.associated_table input').val();
		sid=jQuery('.sid').val();
		data="current_step=0&next_step=0&sid="+sid+"&action=edit&main_table="+main_table;
		location=appWebRoot+"schema/setup?"+data;		
  });
  
  jQuery('.delete_associated_table').live('click',function(){
	
		jQuery.blockUI();
		tr_delete=jQuery(this).parent().parent();	
		this_table=jQuery(this).parent().parent().parent();	
		//console.log(tr_delete.html());
		item={};
		item['associated_table']=tr_delete.find('.associated_table input').val();
		item['associated_field']=tr_delete.find('.associated_field input').val();
		item['main_search_field']=tr_delete.find('.main_search_field input').val();
	
		classes=this_table.find('tr.relation_type').attr('class').split(" ");	
		relation_type=classes[1];	
		main_table=jQuery('select.table_list option:selected').val();
		structure={};
		structure[main_table]={};
		structure[main_table][relation_type]=[];
		
		sid=jQuery('.sid').val();
		data="current_step=0&next_step=0&sid="+sid+"&action=delete&main_table="+main_table;	
	
		array=structure[main_table][relation_type];
		structure[main_table][relation_type][array.length]=item;				
		structure=encodeURIComponent(JSON.stringify(structure));	

		data=data+'&structure='+structure;
		location=appWebRoot+"schema/setup?"+data;
  });
  
  jQuery('.add_associated_table').live('click',function(){
        jQuery.blockUI();
		sid=jQuery('.sid').val();
				
		associated_list=[];		
		main_table=jQuery('select.table_list option:selected').val();
		data="current_step=0&next_step=0&sid="+sid+"&main_table="+main_table;		
		structure={};
		structure[main_table]={};
		structure[main_table]["self::BELONGS_TO"]=[];
		structure[main_table]["self::HAS_MANY"]=[];
		
		
		item={};
		associated_table_selector=jQuery('td.associated_table_selector select option:selected').val();		
		associated_field_selector=jQuery('td.associated_field_selector select option:selected').val();		
		main_field_selector=jQuery('td.main_field_selector select option:selected').val();	
		
		relation_type=jQuery('td.relation_type select option:selected').val();		
		
		item['associated_table']=associated_table_selector;
		item['associated_field']=associated_field_selector;
		item['main_search_field']=main_field_selector;
	
		array=structure[main_table][relation_type];
		structure[main_table][relation_type][array.length]=item;		
		
		//console.log(structure[main_table]);
		//console.log(relation_type);
		//console.log(array);
		structure=encodeURIComponent(JSON.stringify(structure));
		data=data+'&structure='+structure;
		//console.log(structure);
		//alert(1);
		if(associated_table_selector!="undefined"&&associated_table_selector!="undefined"){
			location=appWebRoot+"schema/setup?"+data;
		}else{
		    alert("Please select associated table and field");
		}
		
  });
  
  jQuery('td.associated_table_selector').live('change',function(){
		container= jQuery('td.associated_field_selector');
		table=jQuery(this).find('select option:selected').val();		
		url="associated_select_table";
		jQuery.blockUI();
		
		jQuery.ajax({
			type: "Get",
			url: url,
			data:"selected_associated_table="+table,
			timeout: 1000*60*10,
			success: function(data, textStatus ){					
				container.html(data);
				jQuery.unblockUI();						
			},
			error: function(xhr, textStatus, errorThrown){
				 warning("Fail to get fields...",false);					 
			}
			
		});
		
  });
  
  jQuery('input.edit_filter_field').live('click',function(){
		classes=jQuery(this).attr('class').split(" ");
		sid=jQuery('.sid').val();	  				
		record={};
		filter_field=classes[1];
		main_table=jQuery('select.main_search_table').find('option:selected').val();
		data="filter_field="+filter_field+"&current_step=0"+"&next_step=0"+'&sid='+sid+"&action=edit_filter_field";
		location=appWebRoot+"report/report_setup?"+data;
  });
  
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
		
		
  jQuery('input.save_initial_filter').live('click',function(){  
	   initial_filters_str=get_filters();
	   data="initial_filters_str="+initial_filters_str+"&current_step=0"+"&next_step=0"+'&sid='+sid+"&action=save_initial_filters";			 	
	   location=appWebRoot+"report/report_setup?"+data;	   
  });
  jQuery('input.save_filter_field').live('click',function(){
		
		classes=jQuery(this).attr('class').split(" ");
		sid=jQuery('.sid').val();	  		
		field_order=classes[1];
		record={};
		filter_field=jQuery('input.field_name').val();
		filter_types=jQuery('select.filter_types option:selected').val();
		operator_types=jQuery('select.operator_types option:selected').val();
		additional_value=jQuery('select.additional_value').val();
		initial_value=jQuery('input.initial_value').val();		
		
		record['field_selected']=filter_field;
		record['type_selected']=filter_types;		
		record['additional_value']={};						
		record['additional_value'][additional_value]=additional_value;				
		record['operator_selected']=operator_types;
		
		if(jQuery('input.wildcard').attr('checked')){
			record['wildcard']=true;
		}else{
			record['wildcard']=false;
		}						
		record_str=encodeURIComponent(JSON.stringify(record));		
		data="record_str="+record_str+"&current_step=0"+"&next_step=0"+'&sid='+sid+"&action=save_filter_field";			 	
		location=appWebRoot+"report/report_setup?"+data;
  });
  
  jQuery('.delete_report').live('click',function(){	
	classes=jQuery(this).attr('class').split(" ");
	sid=classes[1];
	sid_schema=classes[2];
	data={};
	data['sid']=sid;
	data['sid_schema']=sid_schema;
	data=encodeURIComponent(JSON.stringify(data));			
	location=appWebRoot+"report/delete_report?data="+data;	
  });

  jQuery('.save_report_name').live('click',function(){
		sid=jQuery('.sid').val();	  		
		report_name=jQuery('.report_name').val();	  		
		data="report_name="+report_name+"&current_step=0"+"&next_step=0"+'&sid='+sid;
		location=appWebRoot+"report/report_setup?"+data;
  });
  
  jQuery('select.main_search_table').live('change',function(){		
		step=jQuery('.current_step').val();
		get_steps(step,step);		
  });
	
	step=jQuery('.current_step').val();     
	switch(step){
		case '0':
			
			if((jQuery('.filters_groups_container').length)>0){
				
				initial_filters_str=jQuery('input.initial_filters_str').val();				
				create_filter(initial_filters_str);
			}
			break;		
		case '2':
		    options_str=jQuery('.options_str').val();
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(options_str)));				
			jQuery.search_options({options:options});
			
			break;						
	}

  logic_field=jQuery('input.field_name').val();
  sid=jQuery('input.sid').val();
  jQuery('input.initial_value').autocomplete({
		source: appWebRoot+"report/get_autocomplete?sid="+sid+"&logic_field="+logic_field
  });  

	//console.log(jQuery('.add_or_filter').length);
  if(jQuery('.add_or_filter').length>0){

	jQuery('.add_or_filter').live('click',function(){	
		create_filter('');
	});		
	}

	if(jQuery('select.additional_value').length>0){
		items=[];
		jQuery('input.additional_value').each(function(index){
			value=jQuery(this).val()
			new_data={id:index,text:value,value:value};
			items.push(value);
		});
		select2_compare_with=jQuery('select.additional_value');	
		//console.log(items);
		select2_compare_with.select2({		
			placeholder: 'Enter Compare With Field Name',
			//minimumInputLength: 0,
			multiple: true,
			tags: true,
	        data:items,
			
			width: 'resolve'
		});
		
		select2_compare_with.select2('val',items);
	}
});
