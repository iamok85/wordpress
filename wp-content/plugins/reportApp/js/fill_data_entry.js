jQuery(document).ready(function(){



  jQuery('#link_pager a').each(function(){
	jQuery('.popover').remove();						
	jQuery(this).unbind('click');
	jQuery(this).click(function(ev){
			ev.preventDefault();
			
			optionsStr=jQuery('input.options_str').val();
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));				
			jQuery.get(this.href,{ajax:true},function(html){																							
			if(options['show_graph_only']==1){
				container='div.modal_data_slice';
			}else{
				container='.ui-widget-content[aria-expanded="true"]';				
			}						
			  jQuery(container).html(html);
			});
		});
    });
	/*jQuery('.field_input.date').datepicker({
										dateFormat: "dd M yy",
										changeMonth: true,
										changeYear: true
								});
	*/
	jQuery('.save').live('click',function(){
		
		data={};
		jQuery('.field_input').each(function(index){
		    one_data={};
			classes=jQuery(this).attr('class').split(' ');						
			data[classes[1]]=jQuery(this).val();			
		});
		sid_schema=jQuery('.sid_schema').val();
		data=encodeURIComponent(JSON.stringify(data));
		jQuery.ajax({
			type: "get",
			url: appWebRoot+'DataEntrySchema/SaveData',
			data: "data="+data+"&sid_schema="+sid_schema,
			timeout: 90000,
			success: function(return_data, textStatus ){ 			
			   if(return_data=="success"){
				 sid_schema=jQuery('.sid_schema').val();	
				 location=appWebRoot+'DataEntrySchema/DataEntryDashboard?sid_schema='+sid_schema;
			   }
			}
		});
		
	});
	
	jQuery('.save_from_report').live('click',function(){
	
		record_list=[];
	records=jQuery.find('.edit_record');
	//console.log(records.length);
	jQuery(records).each(function(record_index){
		 table_list=[];
		 tables=jQuery(this).find('.primary_logic_key');
		 console.log(tables.length);
		 jQuery(tables).each(function(table_index){
			field_list=[];
			one_field={};
			//console.log(tables[table_index].attr('class'));
			
			classes=jQuery(tables[table_index]).attr('class').split(' ');				
			one_field[classes[1]]=classes[2];
			field_list[0]=one_field;
			fields=jQuery(tables[table_index]).find('.edit_field');
			jQuery(fields).each(function(field_index){
				one_field={};
				classes=jQuery(fields[field_index]).attr('class').split(' ');
				one_field[classes[1]]=jQuery(fields[field_index]).val();	
				
				field_list[field_index+1]=one_field;	
			});
			table_list[table_index]=field_list;
		 });
		record_list[record_index]=table_list;	
	});
	 str=encodeURIComponent(JSON.stringify(record_list));
	 
	 jQuery.ajax({
			type: "get",
			url: appWebRoot+'DataEntrySchema/SaveDataFromReport',
			data: "data="+str,
			timeout: 90000,
			success: function(return_data, textStatus ){ 			
			   if(return_data=="success"){
					options_str=jQuery('.options_str').val();
					filters_groups_str=jQuery('.filters_groups_str').val();
					sid=jQuery('.sid').val();
					//console.log(options_str);
					//console.log(filters_groups_str);
					location=appWebRoot+"search/search?sid="+sid+"&filters_groups="+filters_groups_str+"&options="+options_str;
				}else{
				 alert(return_data);
				}
			}
	});
	
	});
	
	
});