jQuery(document).ready(function(){

if(isScriptAlreadyIncluded('page.js')){
	console.log('included');
	return;
}
	
function isScriptAlreadyIncluded(src){
    var scripts = document.getElementsByTagName("script");
    for(var i = 0; i < scripts.length; i++) {
		filepath=scripts[i].getAttribute('src')
	   if(filepath!=null){
		filepath=scripts[i].getAttribute('src').split('/');
		if(filepath.length>0){
		
		filename=filepath[filepath.length-1];
		console.log(filename);
		if(filename == src) 
		   return true;
		}	  
	}
	}
    return false;
}

jQuery.unblockUI();
	
if(jQuery('.exporter_type:visible').length>0){
	jQuery('.exporter_type:visible').unbind('click');
	jQuery('.exporter_type:visible').live('click',function(){

		jQuery.blockUI();
		classes=jQuery(this).attr('class').split(' ');
		id=classes[1];
		jQuery.ajax({
				type: "Get",
				url:appWebRoot+"meta/list_export_headers?id="+id+"&view_type="+options['view_type'],
				timeout: 1000*60*5,
				success: function(data, textStatus ){					
					jQuery('.export_field_header_td').html(data);				
					jQuery.unblockUI();
				},
				error: function(xhr, textStatus, errorThrown){
					 warning(message+' failed!',false);					 
				}
		});	  
	  });   
  }

 jQuery('.excel_export:visible').unbind('click');
  jQuery('.excel_export:visible').live('click',function(){		
		
		jQuery.blockUI();
		optionsStr=jQuery('input.options_str').val();
		options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));					
		compare_field=jQuery('.compare_logic_field').val();
		jQuery.ajax({
				type: "Get",
				url:appWebRoot+"meta/list_export_headers?compare_field="+compare_field+"&view_type="+options['view_type'],
				timeout: 1000*60*5,
				success: function(data, textStatus ){																			
			
					jQuery('.excel_export:visible').data('popover', null).popover({'container':'general_layout_table','title':'SQL','placement':'bottom','content':data,'html':true});																							
					jQuery('.excel_export:visible').popover('show');						
				//	jQuery('.popover').css('top',parseInt($('.popover').css('top')) + 122 + 'px');
					jQuery.unblockUI();
				},
				error: function(xhr, textStatus, errorThrown){
					 warning(message+' failed!',false);					 
				}
		});	  
  });


jQuery('.sql_display').unbind('click');
  jQuery('.sql_display').live('click',function(event){
	
		jQuery(this).popover('destroy');
		sql_display_div=jQuery('div.one_page:visible').find('div.sql_display_div');
		data=sql_display_div.html();		
		sql_display_div.css('width','500px');
		width=sql_display_div.css('width');
		height=sql_display_div.css('height');
		height=height.substring(0,height.length-2);
		//console.log(height);
		top=jQuery(this).attr('top');
		left=jQuery(this).attr('left');
		jQuery(this).data('popover', null).popover({'container':'general_layout_table','title':'SQL','placement':'bottom','content':data,'html':true});		
		jQuery(this).popover('show');	
		jQuery('.popover').css('width',width);	
		jQuery('.popover').css('height','auto');	
		//console.log(top.x+" "+left);
	});


 jQuery('.exporters_setting').unbind('click');
  jQuery('.exporters_setting').live('click',function(){
	    paramsStr='';
		message='';
		classes=jQuery(this).attr('class').split(' ');
		action_type=classes[1];
		id=classes[2];
		has_post=true;		
		set_export_header(action_type,id,has_post);
		
	});	
  
jQuery('.export_confirm:visible').unbind('click');
jQuery('.export_confirm:visible').live('click',function(){
	
	filters_groups_Str=jQuery('input.filter_groups_str').val();		
	optionsStr=jQuery('input.options_str').val();
	options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));																				
	export_fields=[];
	jQuery('input.export_field:checked').each(function(index){
		export_fields[index]=jQuery(this).val();		
	});
	
	export_fields=encodeURIComponent(JSON.stringify(export_fields));		

	var url='search';
	sid=jQuery('.sid').val();
	
	if(options['show_graph_only']==1){	
		compare_logic_field=jQuery('.compare_logic_field').val();	
		filters_groups_Str=jQuery('input.page.filter_group_str').val();		
		url=appWebRoot+url+"/export_excel?compare_logic_field="+compare_logic_field+"&sid="+sid+"&filters_groups="+filters_groups_Str+'&options='+encodeURIComponent(optionsStr)+'&output=excel&export_fields='+export_fields+'&view_type='+options['view_type'];		
	}else{
		compare_logic_field=jQuery('.compare_logic_field').val();
		url=appWebRoot+url+"/export_excel?compare_logic_field="+compare_logic_field+"&sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output=excel&export_fields='+export_fields+'&view_type='+options['view_type'];		
	}

	jQuery.blockUI({messageText:"Generating Excel File"});
	jQuery.ajax({	
			type: "POST",
			url: url,								
			timeout: 1000*60*10,
			success: function(data, textStatus ){	
			if(data.toLowerCase().indexOf(".xlsx") >= 0){									
				
					location=appWebRoot+'search'+'/download_excel?filename='+data;						
					jQuery.unblockUI();							
				}																
			},
			error: function(xhr, textStatus, errorThrown){
				 warning("Exporting fail...",false);					 
			}
	});
	
});

	jQuery(this).unbind('body');
	jQuery('body').on('click', function (e) {
		jQuery('.popover-link').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!jQuery(this).is(e.target) && jQuery(this).has(e.target).length === 0 && jQuery('.popover').has(e.target).length === 0) {
				jQuery(this).popover('hide');
			}
		});
	});
	

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
	
});
