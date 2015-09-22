jQuery(document).ready(function(){

var tour = new Tour({
  //storage:false,
  steps:[
  {
    element: ".filters_groups_container",
    title: "Filters",
    content: "filters to filter data"
  },
  {
    element: ".add_and_filter",
    title: "Add a 'and' logic filter",
    content: "Add a 'and' logic filter"
  },{
    element: ".add_or_filter",
    title: "Add a 'or' logic filter",
    content: "Add a 'or' logic filter"
  },
  {
    element: ".list_by.search_options.select2-container",
    title: "Grouping results",
    content: "able to group by multiple fields combination."
  },
  {
    element: "ul.ui-tabs-nav",
    title: "Navigation Tabs",
    content: " click each tab to navigate each set of result of each group by field."
  },
  {
    element: "i.icon-external-link",
    title: "Split a Tab",
    content: " Click this button to split this tab, and a new filter condition would be added to the filter list according to the group field vlaue."
  }

]});

//tour.init();
//tour.start();

if(jQuery('.add_or_filter').length>0){

	jQuery('.add_or_filter').live('click',function(){	
			options=jQuery.parseJSON(get_options());	
			url_list={};
			url_list['get_autocomplete']='meta/get_autocomplete';
			url_list['get_new_filter']='meta/get_new_filter';
			url_list['get_options']='meta/get_options';			
			jQuery.filters({container:'.filters_groups_container',filters:[{name:''}],options:options,url_list:url_list});   			
	});		
}
// for search click function

if(jQuery('.search_button').length>0){
	jQuery('.search_button').live('click',function(){
			jQuery.blockUI();
			search(jQuery(this),'web');	
	});
}

if(jQuery('.json_button').length>0){
	jQuery('.json_button').live('click',function(){
			jQuery.blockUI();
			search_json(jQuery(this),'json');	
	});
}


if(jQuery('.save_button').length>0){
	jQuery('.save_button').live('click',function(){
			jQuery.blockUI();
			save_result(jQuery(this));	
	});
}



(function($){
		
		reset_page=function(){
		apply_tooltip();
			 /* show additional info*/		
			 var queries = {};
			  $.each(document.location.search.substr(1).split('&'),function(c,q){
				var i = q.split('=');
				if(i.length==2){
					queries[i[0].toString()] = i[1].toString();						
				}
			  });				  				  				 						
			  //console.log(queries);
			/*default setting of filters and options*/	
			filter_group=jQuery('div.filters_groups_instance.0');												
			jQuery(filter_group).children('div.filter_instance.filter0').children('div.field').children('select').val('name');
			jQuery(filter_group).children('div.filter_instance.filter0').children('div.value').children('.search_field.filter_by_value').val('');																																														
		//	console.log(queries["filters_groups"]);
			filters_groups=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(queries["filters_groups"])));																					
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(queries["options"])));																									
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
			jQuery.search_options({options:options,instant_update:true});		
			jQuery.unblockUI();
		}
		warning=function(msg,status){
			var timeOut;
			if(status){
				timeOut=700;
				//jQuery.blockUI({ message:'<div><span style="font-size:12pt">'+msg+'</span></div>',css:{color:'red',background:'lightyellow',width:'500px'}}); 
			}else{
				timeOut=4000;				
				//jQuery.blockUI({ message:'<div><img width="25px" height="25px" src="'+appWebRoot+'/img/warning.png"/><span style="font-size:12pt">'+msg+'</span></div>',css:{color:'red',background:'lightyellow',width:'500px'}}); 
			}	
			  setTimeout(
				  function() 
				  {  
					 
				  }, timeOut);
				  
			return false;
		}
		
	
	
	apply_tooltip=function(){
		
		jQuery('li').tooltip({delay: 1000,'container': 'body'});
		jQuery('i').tooltip({delay: 1000,'container': 'body'});
		jQuery('a').tooltip({delay: 1000,'container': 'body'});
		jQuery('div').tooltip({delay: 1000,'container': 'body'});
		jQuery('input').tooltip({delay: 1000,'container': 'body'});
		jQuery('select').tooltip({delay: 1000,'container': 'body'});
		jQuery('img').tooltip({delay: 1000,'container': 'body'});
		jQuery('tr').tooltip({delay: 1000,'container': 'body'});
		
	}
	 /*get filters from filter setting*/
	     /*get filters from filter setting*/
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
		
		/*get search option*/
		get_options=function(){		
			optionsStr=jQuery('.search_display_options').serialized_options();								
			
			return optionsStr;
		};
		
		/*fire a save request*/
		save_result=function(save_button){
		
			var classes=save_button.attr('class').split(" ");
				var url=classes[1];														
				filters_groups_Str=get_filters();
				optionsStr=get_options();					
                sid=jQuery('.sid').val();				
				url=appWebRoot+url+"/save_ajax?sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output=web';
				jQuery.ajax({
						type: "GET",
						url:url,
						timeout: 1000*60*5,
						success: function(data, textStatus ){	
							jQuery.unblockUI();							
							jQuery('div.file_list_container').html(data).hide().fadeIn(1000);																																				
						},
						error: function(xhr, textStatus, errorThrown){
							 jQuery.unblockUI();							
						}
			    });						
		}		
		
		
		search_json=function(search_button,output){					
				console.log(optionsStr);
				var classes=search_button.attr('class').split(" ");
				var url=classes[1];														
				filters_groups_Str=get_filters();
				optionsStr=get_options();					
				
				
				sid=jQuery('.sid').val();				
				location=appWebRoot+url+"/search?sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output='+output;
		};
		
	    /*fire a search request*/
		search=function(search_button,output){					
				//console.log(111111111111);
				var classes=search_button.attr('class').split(" ");
				var url=classes[1];														
				filters_groups_Str=get_filters();
				optionsStr=get_options();					
				console.log(optionsStr);
                sid=jQuery('.sid').val();				
				//alert(1);
				location=appWebRoot+url+"/search?sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output='+output;
				
				/*jQuery.ajax({
						type: "POST",
						url:url,
						timeout: 1000*60*5,
						success: function(data, textStatus ){	
						    
							var classes=search_button.attr('class').split(" ");
							var button_type=classes[0];														
				
							if(button_type=="search_button"){							
								jQuery.unblockUI();
								var optionsStr = get_options();		 
								options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));															
								jQuery('.result_list').html(data).hide().fadeIn(1000);																															
							}							
						},
						error: function(xhr, textStatus, errorThrown){
							 jQuery.unblockUI();							
						}
				});*/
				
		};
		
		
		set_filter=function(action_type, filter_id,has_post){
			
			switch(action_type){			
				case 'save':
						filters_groups_Str=get_filters();
						optionsStr=get_options();
						paramsStr='filters_groups='+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr);
						message="Filter saved";
					break;			
				case 'delete':
						paramsStr="id="+filter_id;
						message="Filter deleted";
					break;					
				case 'rename':										
						has_post=false;										
						jQuery('.saved_filter_div.'+filter_id+' .view').hide();
						jQuery('.saved_filter_div.'+filter_id+' .edit').fadeIn(1000);
					break;						
				case 'save_rename':											
						paramsStr="id="+filter_id+'&name='+jQuery('input.filter_rename.'+filter_id).val();					
						message="Filter renamed";
					break;
			}
			var optionsStr = get_options();		 
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)))			
			paramsStr+="&action="+action_type+'&view_type='+options['view_type'];
			if(has_post){
				jQuery.ajax({
						type: "POST",
						url:appWebRoot+"meta/set_user_filters?"+paramsStr,
						timeout: 1000*60*5,
						success: function(data, textStatus ){									    
							jQuery('#saved_search_filters').html(data).hide().fadeIn(1000);
							warning(message+' successfully!',true);					 
						},
						error: function(xhr, textStatus, errorThrown){
							 warning(message+' failed!',false);					 
						}
				});			
			}
		
		}
	})(jQuery);
	
	jQuery(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){		 
			 if(jQuery('.search_button:visible').length > 0){			
			 	if(jQuery(document.activeElement).hasClass('filter_rename')){					
					classes=jQuery(document.activeElement).attr('class').split(' ');			
					set_filter('save_rename',classes[1],true);					
					
				}else if(jQuery(document.activeElement).hasClass('exporter_rename')){					
					classes=jQuery(document.activeElement).attr('class').split(' ');
			
					set_export_header('save_rename',classes[1],true);					
					
				}else{			
					search(jQuery('.search_button:visible'),'web');
					return false;					
				}
								
			}
			
			//alert(11);	
			
		}  
	});
	

	
		jQuery('.delete_file').live('click',function(){			
			var classes=jQuery(this).attr('class').split(" ");
			var file=classes[1];
			url=appWebRoot+"search/delete_file?filename="+file;
			jQuery.ajax({
					type: "Get",
					url: url,								
					timeout: 1000*60*10,
					success: function(data, textStatus ){												
					
						jQuery.unblockUI();							
						jQuery('div.file_list_container').html(data).hide().fadeIn(1000);																																										
					},
					error: function(xhr, textStatus, errorThrown){
						
					}					
			});
		});   	
	
	
	jQuery('input.render_type_change').on('click',function(e){	
		render_type=jQuery(this).val();
		filters_groups_Str=get_filters();
		optionsStr=get_options();					
		options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)))			
        options['render_type']=render_type;
		optionsStr=encodeURIComponent(JSON.stringify(options));
		sid=jQuery('.sid').val();				
		location=appWebRoot+"search/search?sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output=web';
	});

	jQuery('body').on('click', function (e) {
		jQuery('.popover-link').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!jQuery(this).is(e.target) && jQuery(this).has(e.target).length === 0 && jQuery('.popover').has(e.target).length === 0) {
				jQuery(this).popover('hide');
			}
		});
	});

	reset_page();
	
});