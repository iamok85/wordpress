jQuery(document).ready(function(){
	var draw_schema_graph;
	jQuery('.navigate_schema').live('click',function(){	
	 
	 classes=jQuery(this).attr('class').split(' ');
	 current_step=jQuery('input.current_step_schema').val();
	 classes=jQuery(this).attr('class').split(' ');	 
	 sid=jQuery('.sid').val();
	 next_step=classes[1];
	 
	 data={};
	 data["sid"]=sid;
	 data["next_step"]=next_step;
	 data["current_step"]=current_step;

	 switch(current_step)	{
			case '0':
				db_schema_name=jQuery('input.db_schema_name').val();
				data["db_schema_name"]=db_schema_name;	
				selected_table=jQuery('select.table_list option:selected').val();
				data["selected_table"]=selected_table;	
				break;
			case '1':				
				break;
			case '2':
				
	  }
	  data_json=encodeURIComponent(JSON.stringify(data));
	  location=appWebRoot+"schema/schema_setup?data="+data_json;
	});	   
	
  jQuery('select.table_list').live('change',function(){
		jQuery.blockUI();				
		main_table=jQuery(this).find("option:selected").val();						
		sid=jQuery('.sid').val();		
		data={};
		data['sid']=sid;
		data['acton']='edit';
		data['main_table']=main_table;
		data['current_step']=-1;
		data['next_step']=0;
		data_json=encodeURIComponent(JSON.stringify(data));
		location=appWebRoot+"schema/schema_setup?data="+data_json;
  });
  
  jQuery('.edit_associated_table').live('click',function(){  
		jQuery.blockUI();
		tr_edit=jQuery(this).parent().parent();					
		main_table=tr_edit.find('.associated_table input').val();
		sid=jQuery('.sid').val();
		data="sid="+sid+"&action=edit&main_table="+main_table+"&current_step=-1&next_step=0";
		data={};
		data['sid']=sid;
		data['action']='edit';
		data['main_table']=main_table;
		data['current_step']=-1;
		data['next_step']=0;
		data_json=encodeURIComponent(JSON.stringify(data));
		location=appWebRoot+"schema/schema_setup?data="+data_json;
  });
  
  jQuery('.delete_associated_table').live('click',function(){
	
		
		tr_delete=jQuery(this).parent().parent();	
		this_table=jQuery(this).parent().parent().parent();			
		main_table=jQuery('select.table_list option:selected').val();
		classes=this_table.find('tr.relation_type').attr('class').split(" ");	
		relation_type=classes[1];		
		item={};
		item['main_table']=main_table;
		item['associated_table']=tr_delete.find('.associated_table input').val();
		item['associated_field']=tr_delete.find('.associated_field input').val();
		item['main_search_field']=tr_delete.find('.main_search_field input').val();
		item['relation_type']=relation_type;	
		sid=jQuery('.sid').val();
		//data="sid="+sid+"&action=delete_associated_table&main_table="+main_table+"&current_step=0&next_step=0";									
		//item=encodeURIComponent(JSON.stringify(item));	
		data={};
		data['item']=item;
		data['sid']=sid;
		data['action']='delete_associated_table';
		data['main_table']=main_table;
		data['current_step']=0;
		data['next_step']=0;
		data_json=encodeURIComponent(JSON.stringify(data));
		location=appWebRoot+"schema/schema_setup?data="+data_json;
  });
  
  jQuery('.add_associated_table').live('click',function(){
        
		sid=jQuery('.sid').val();
				
		associated_list=[];		
		main_table=jQuery('select.table_list option:selected').val();
		//data="sid="+sid+"&main_table="+main_table+"&action=save_associated_table&current_step=0&next_step=0";		
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
		
		//structure=encodeURIComponent(JSON.stringify(structure));
		
		if(associated_table_selector!="undefined"&&associated_table_selector!="undefined"){
			data={};
			data['structure']=structure;
			data['main_table']=main_table;
			data['sid']=sid;
			data['current_step']=0;
			data['next_step']=0;
			data['action']='save_associated_table';
			data_json=encodeURIComponent(JSON.stringify(data));
			location=appWebRoot+"schema/schema_setup?data="+data_json;
		}else{
		    alert("Please select associated table and field");
		}
		
  });
  
  jQuery('td.associated_table_selector').live('change',function(){
		jQuery.blockUI();
		container= jQuery('td.associated_field_selector select');
		table=jQuery(this).find('select option:selected').val();		
		url="associated_select_table";
		sid=jQuery('.sid').val();
		data={};
		data["selected_associated_table"]=table;
		data["sid"]=sid;
		data_json=encodeURIComponent(JSON.stringify(data));
		//location=appWebRoot+"schema/schema_setup";
		jQuery.ajax({
			type: "Get",
			url: url,
			data:"data="+data_json,
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
  
  jQuery('input.edit_field').live('click',function(){
		classes=jQuery(this).attr('class').split(" ");
		sid=jQuery('.sid').val();	  
		current_step=jQuery('input.current_step').val();
		data={};
		data['table']=classes[2];
		data['field']=classes[3];
		data['type']=classes[4];
		data['sid']=sid;
		data['current_step']=current_step;			
		data=encodeURIComponent(JSON.stringify(data));		
		location=appWebRoot+"schema/edit_field?data="+data;	
  });
  
  jQuery('input.save_field').live('click',function(){
			
		classes=jQuery(this).attr('class').split(" ");
		sid=jQuery('.sid').val();	  
		current_step=jQuery('input.current_step').val();
		data={};
		data['table']=classes[1];		
		data['type']=classes[2];
		data['sid']=sid;
		data['current_step']=current_step;			
		field_name=jQuery('input.field_name').val();
		filter_type=jQuery('select.filter_types option:selected').val();
		operator_type=jQuery('select.operator_types option:selected').val();
		additional_value=jQuery('select.additional_values option:selected').val();		
		record={};	
		if(jQuery('input.wildcard').attr('checked')){
			record['wildcard']=true;
		}else{
			record['wildcard']=false;
		}		
					
		record['field_selected']=field_name;
		record['type_selected']=filter_type;
		record['operator_selected']=operator_type;		
		record['additional_value']={};						
		record['additional_value'][additional_value]=additional_value;
		data['record']=record;
		console.log(record);		
		data_json=encodeURIComponent(JSON.stringify(data));			
		location=appWebRoot+"schema/save_field?data="+data_json;	
  });
  
  jQuery('.delete_db_schema').live('click',function(){	
	classes=jQuery(this).attr('class').split(" ");
	sid=classes[1];
	data={};
	data["sid"]=sid;
	data_json=encodeURIComponent(JSON.stringify(data));
	location=appWebRoot+"schema/delete_schema?data="+data_json;
  });
  
  jQuery('.import_schema').live('click',function(){
	data={};
	db_schema_name=jQuery('.db_schema_name').val();  
	data['db_schema_name']=db_schema_name;	
	jQuery.blockUI();
	if(jQuery('.sid')!=undefined&&jQuery('.sid')!=""){
		sid=jQuery('.sid').val();	  	
		if(sid!=undefined)
			data['sid']=sid;
	}	
	data_json=encodeURIComponent(JSON.stringify(data));
	location=appWebRoot+"schema/import_schema?data="+data_json;		  
  });
	
	jQuery('.table_schema_step1').live('change',function(){		 
		 main_table=jQuery(this).val();
		 sid=jQuery('.sid').val();	  			 		 
		 //data="sid="+sid+"&current_step=1&next_step=1&main_table="+main_table;
		 data={};
		 data['main_table']=main_table;
		 data['sid']=sid;
		 data['current_step']=1;
		 data['next_step']=1;
		 data_json=encodeURIComponent(JSON.stringify(data));
		 location=appWebRoot+"schema/schema_setup?data="+data_json;		  
		 
	});
	
	jQuery('.add_display_name_schema').live('click',function(){
				
		 table=jQuery('.table_schema_step1').val();
		 field=jQuery('.field_schema_step1').val();		 
		 display_name=jQuery('.display_name').val();
		 sid=jQuery('.sid').val();	  	
		 main_table=jQuery('select.table_schema_step1').find('option:selected').val();
		 data={};
		 data['table']=table;
		 data['field']=field;
		 data['sid']=sid;
		 data['display_name']=display_name;
		 data['current_step']=1;
		 data['next_step']=1;
		 data['action']='add_display_field';
		 data['main_table']=main_table;
		 data_json=encodeURIComponent(JSON.stringify(data));
		 location=appWebRoot+"schema/schema_setup?data="+data_json;		  
	});
	
	jQuery('.delete_display_field').live('click',function(){	
		jQuery.blockUI();		
		classes=jQuery(this).attr('class').split(" ");	
		field=classes[1];	
		main_table=jQuery('select.table_schema_step1').find('option:selected').val();
		sid=jQuery('.sid').val();
		 data={};
		 data["sid"]=sid;
		 data["action"]='delete_display_field';
		 data["main_table"]=main_table;
		 data["current_step"]=1;
		 data["next_step"]=1;	
		 data["field"]=field;	
		 data_json=encodeURIComponent(JSON.stringify(data));
		 location=appWebRoot+"schema/schema_setup?data="+data_json;		  
	});
	
	jQuery('.edit_display_field').live('click',function(){	
		jQuery.blockUI();		
		classes=jQuery(this).attr('class').split(" ");	
		field=classes[1];	
		main_table=jQuery('select.table_schema_step1').find('option:selected').val();
		sid=jQuery('.sid').val();
		
		data={};
		data["sid"]=sid;
		data["action"]="edit_display_field";
		data["main_table"]=main_table;
		data["current_step"]=1;
		data["next_step"]=1;	
		data["field"]=field;
		data_json=encodeURIComponent(JSON.stringify(data));
		location=appWebRoot+"schema/schema_setup?data="+data_json;		  
	});
  
  jQuery('.save_edit_display_field').live('click',function(){	
		jQuery.blockUI();		
		data={};
		classes=jQuery(this).attr('class').split(" ");	
		logic_field=jQuery('.logic_field').val();			
		sid=jQuery('.sid').val();
		data["sid"]=sid;
		data["action"]="save_edit_display_field";
		data["current_step"]=1;
		data["next_step"]=1;	
		data['logic_field']=logic_field;
		
		if(jQuery('.geolocation').attr('checked')){
			
			data['geolocation']=1;
		}
		if(jQuery('.solr_index').attr('checked')){
			
			data['solr_index']=1;
		}
		data_json=encodeURIComponent(JSON.stringify(data));
		location=appWebRoot+"schema/schema_setup?data="+data_json;		  
	});
	
  jQuery('td.relation_type select').live('change',function(index){
 
		relation_type=jQuery(this).find('option:selected').val();		
		/*if(relation_type=="self::HAS_MANY"){
			jQuery('td.main_field_selector select').attr('disabled',true);
			jQuery('td.associated_field_selector select').attr('disabled',false);
		}else if(relation_type=="self::BELONGS_TO"){
			jQuery('td.main_field_selector select').attr('disabled',false);
			jQuery('td.associated_field_selector select').attr('disabled',true);
		}*/
  });
 
		step=jQuery('.step').val();
		switch(step){
			case '0':
				
			  if(jQuery('select.table_list').length>0){
			  
				main_table=jQuery('select.table_list').find('option:selected').val();	
				
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
				}else{
					
				}											
				break;
			case '1':
				main_table=jQuery('select.table_schema_step1').find('option:selected').val();
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
												   data["next_step"]=step;					   			
												   
												   data_json=encodeURIComponent(JSON.stringify(data));
												   location=appWebRoot+"schema/schema_setup?data="+data_json;		  
												}
											});
				break;						
		} 
	
	
	jQuery('input.to_add_join_condition').live('click',function(){
		classes=jQuery(this).attr('class').split(" ");
		order=classes[1];
		associated_table=jQuery(this).parent().parent().find('td.associated_table.'+order+' input').val();
		main_table=jQuery('select.table_list').find('option:selected').val();	
		relation_type=classes[2];
		step=jQuery('.step').val();	
		sid=jQuery('.sid').val();		
		data={};
		data["sid"]=sid;
		data["main_table"]=main_table;
		data["current_step"]=step;
		data["next_step"]=step;
		data["associated_table"]=associated_table;
		data["action"]="to_add_join_condition";
		data["relation_type"]=relation_type;
		data_json=encodeURIComponent(JSON.stringify(data));
		location=appWebRoot+"schema/schema_setup?data="+data_json;		  
	});
	
	jQuery('input.save_join_condition').live('click',function(){
		
		main_table=jQuery('input.main_table').val();
		associated_table=jQuery('input.associated_table').val();
		relation_type=jQuery('input.relation_type').val();
		value_type=jQuery('select.value_type').val();
		condition_table=jQuery(".table_add_join_condition").find("option:selected").val();
		condition_field=jQuery(".field_add_join_condition").find("option:selected").val();
		operator_type=jQuery(".operator_type").find("option:selected").val();		
		sid=jQuery('.sid').val();
		step=jQuery('.step').val();		
		join_condition_value=jQuery(".join_condition_value").val();
		data={};
		data["join_condition_value"]=join_condition_value;
		data["operator_type"]=operator_type;
		data["value_type"]=value_type;
		data["condition_field"]=condition_field;
		data["condition_table"]=condition_table;
		data["sid"]=sid;
		data["main_table"]=main_table;
		data["current_step"]=step;
		data["next_step"]=step;
		data["associated_table"]=associated_table;
		data["action"]="add_join_condition";
		data["relation_type"]=relation_type;
		data_json=encodeURIComponent(JSON.stringify(data));
		
		location=appWebRoot+"schema/schema_setup?data="+data_json;		  
		
	});
	
	jQuery('.table_add_join_condition').live('change',function(){
	
		container= jQuery('.field_add_join_condition');
		table=jQuery(this).find('option:selected').val();		
		url="get_fields";
		sid=jQuery('.sid').val();
		jQuery.blockUI();		
		data={};
		data["sid"]=sid;
		table=jQuery('.table_add_join_condition').find('option:selected').val();			
		data["table"]=table;		
		data_json=encodeURIComponent(JSON.stringify(data));
		//location=appWebRoot+"schema/import_schema?data="+data_json;		  
		
		jQuery.ajax({
			type: "Get",
			url: url,
			data:"data="+data_json,
			timeout: 1000*60*10,			
			success: function(data, textStatus ){					
				container.html(data);
				value_field=jQuery(".join_condition_value");				
				table=jQuery('.table_add_join_condition').find('option:selected').val();
				//alert(table);
				field=jQuery('.field_add_join_condition').find('option:selected').val();
				data={};				
				if(jQuery('select.join_condition_value').length>1){
				
					build_join_value_field(table,field);
				}
				
				jQuery.unblockUI();						
			},
			error: function(xhr, textStatus, errorThrown){
				 //warning("Fail to get fields...",false);					 
			}
			
		});
	});
	
	
				
	jQuery('.table_add_join_condition,.field_add_join_condition').live('change',function(){		
	
		table=jQuery('.table_add_join_condition').find('option:selected').val();
		field=jQuery('.field_add_join_condition').find('option:selected').val();
		data={};
		data["field"]=field;
		data["table"]=table;
		data_json=encodeURIComponent(JSON.stringify(data));				
		build_join_value_field(table,field);
		
	});
	
	
	table=jQuery('.table_add_join_condition').find('option:selected').val();
	field=jQuery('.field_add_join_condition').find('option:selected').val();		
	build_join_value_field(table,field);
	
	function build_join_value_field(table,field){
	   
		//console.log(jQuery('select.join_condition_value').length);
		if(jQuery('select.join_condition_value').length>0){
		
			jQuery('select.join_condition_value').select2({
			multiple: true,
			width: 'resolve',
			ajax: {
			  url: appWebRoot+"schema/get_options",
			  dataType: 'json',								  
			  data: function (term, page) {
				return {
				  q: term,
				  field:field,
				  table:table
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
		}
		
	}
	
	jQuery('.delete_join_condition_value').live('click',function(){
		main_table=jQuery('input.main_table').val();
		associated_table=jQuery('input.associated_table').val();
		relation_type=jQuery('input.relation_type').val();				
		classes=jQuery(this).attr('class').split(' ');
		condition_logicfield=classes[1];
		sid=jQuery('.sid').val();
		step=jQuery('.step').val();		
		data={};
		data["condition_logicfield"]=condition_logicfield;
		data["sid"]=sid;
		data["main_table"]=main_table;
		data["current_step"]=step;
		data["next_step"]=step;
		data["associated_table"]=associated_table;
		data["action"]="delete_join_condition";
		data["relation_type"]=relation_type;
		data_json=encodeURIComponent(JSON.stringify(data));		
		location=appWebRoot+"schema/schema_setup?data="+data_json;					
		
	});
	

	jQuery('i.fa').live('click',function(){
	
		jQuery('div.panel-collapse').each(function(index){		
		
			classes=jQuery(this).attr('class').split(' ');	
			if(jQuery(this).hasClass('in')){		
				
				jQuery(this).parent().find('i.compress').hide();			
				jQuery(this).parent().find('i.expand').show();
			}else{			
				jQuery(this).parent().find('i.compress').show();			
				jQuery(this).parent().find('i.expand').hide();
			}
		});		
	});
	
	if(jQuery('.makeup_field_list').length>0){
		
		jQuery('select.logicfields.select').select2({
			multiple:true
		});
		jQuery('select.logicfields.select').select2('val',[]);
		
		jQuery('.save_makeup').live('click',function(){
			
			jQuery.blockUI();		
			data={};
			
			data['makeup_field_name']=jQuery('.makeup_field_name').val();
			data['logicfields']=jQuery('select.logicfields.select').select2('val');
			data['sid']=jQuery('.sid').val();
			data['step']=jQuery('.step').val();
			data['action']='save_makeup_field';			
			data['current_step']=2;
			data['next_step']=2;
			container=jQuery('.makeup_container');
			console.log(data);
			data_json=encodeURIComponent(JSON.stringify(data));			
			location=appWebRoot+"schema/schema_setup?data="+data_json;					
			
		
		});
	}
	
});
