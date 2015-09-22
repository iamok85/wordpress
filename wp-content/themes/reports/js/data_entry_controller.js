jQuery(document).ready(function(){
	sid_schema=jQuery('.sid_schema').val();
	jQuery('.add_block').live('click',function(){				
		all_fields_str=jQuery('.all_fields_str').val();
		jQuery.data_entry_block({all_fields_str:all_fields_str,sid_schema:sid_schema,container:'.block_container',block:[]});   			
	});

	blocks=[];
	jQuery('.save_block').live('click',function(){
		blocks=[];
		jQuery('div.block_instance').each(function(index){							
			block=jQuery(this).block_seralize();									   
			blocks[index]=block;
			index++;
		});
		blocks_str=encodeURIComponent(JSON.stringify(blocks));
		data_entry_name=jQuery('.data_entry_name').val();
		if(jQuery('.de_id').length>0){
			de_id=jQuery('.de_id').val();
			data="sid_schema="+sid_schema+"&blocks_str="+blocks_str+"&data_entry_name="+data_entry_name+"&de_id="+de_id;
		}else{
			data="sid_schema="+sid_schema+"&blocks_str="+blocks_str+"&data_entry_name="+data_entry_name;
		}
		
		jQuery.ajax({
			type: "get",
			url: appWebRoot+'DataEntrySchema/SaveDataEntry',
			data: data,
			timeout: 90000,
			success: function(return_data, textStatus ){ 			
			   if(return_data=="success"){
				 sid_schema=jQuery('.sid_schema').val();	
				 location=appWebRoot+'DataEntrySchema/DataEntryDashboard?sid_schema='+sid_schema;
				 
			   }
			}
		});						
	});
	
	if(jQuery('.blocks_str').length>0){
	
		blocks_str=jQuery('.blocks_str').val();	
		sid_schema=jQuery('.sid_schema').val();	
		all_fields_str=jQuery('.all_fields_str').val();	
		blocks=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(blocks_str)));		
		
		jQuery.each(blocks,function(index){
			block=blocks[index];
			if(jQuery('.report_id').length>0){
				jQuery.data_entry_block({all_fields_str:all_fields_str,sid_schema:sid_schema,container:'.block_container',block:block,lock:true});   			
			}else{
				jQuery.data_entry_block({all_fields_str:all_fields_str,sid_schema:sid_schema,container:'.block_container',block:block});   			
			}			
		});
	}
});
