jQuery(document).ready(function(){
	
	if(is_result_loaded!=undefined)
	return;
	var is_result_loaded=true;

	jQuery('body').on('click', function (e) {
		jQuery('.popover-link').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!jQuery(this).is(e.target) && jQuery(this).has(e.target).length === 0 && jQuery('.popover').has(e.target).length === 0) {
				jQuery(this).popover('hide');
			}
		});
	});
  
  jQuery('.total_sql_display').live('click',function(){
		
		jQuery(this).popover('destroy');
		sql_display_div=jQuery('div.total_sql_display_div');
		data=sql_display_div.html();		
		sql_display_div.css('width','500px');
		width=sql_display_div.css('width');
		height=sql_display_div.css('height');
		
		jQuery(this).data('popover', null).popover({'container':'general_layout_table','title':'SQL','placement':'bottom','content':data,'html':true});		
		jQuery(this).popover('show');	
			
		jQuery('.popover').css('width',width);	
		jQuery('.popover').css('height','auto');	
		
	});

	
jQuery('.excel_export_graph_data:visible').live('click',function(){
	
	var url='search';
    return_data=construct_graph_data(options);
			//console.log(return_data);
	whole_data_list=return_data["whole_data_list"];
	all_label=return_data["all_label"];		
	whole_data_list=reconstruct_data_list(whole_data_list,all_label);
    whole_data_list_str=encodeURIComponent(JSON.stringify(whole_data_list));
	all_label_str=encodeURIComponent(JSON.stringify(all_label));
	
	filters_groups_Str=jQuery('input.filter_groups_str').val();
	optionsStr =jQuery('input.options_str').val();
	sid =jQuery('input.sid').val();
	url=appWebRoot+url+"/export_excel_graph_data?sid="+sid+"&filters_groups="+encodeURIComponent(filters_groups_Str)+'&options='+encodeURIComponent(optionsStr)+'&output=excel_graph_data';	
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
	
(function($){
	
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
		
		set_export_header=function(action_type,id,has_post){
		
			switch(action_type){			
				case 'save':
						export_fields=[];
						jQuery('input.export_field:checked').each(function(index){
							export_fields[index]=jQuery(this).val();
							//console.log(jQuery(this).val());		
						});					
						export_fields=encodeURIComponent(JSON.stringify(export_fields));
						paramsStr='export_fields='+export_fields;
						message="Exporter saved";
					break;			
				case 'delete':
						paramsStr="id="+id;
						message="Exporter deleted";
					break;					
				case 'rename':										
						has_post=false;										
						jQuery('.saved_exporter_div.'+id+' .view').hide();
						jQuery('.saved_exporter_div.'+id+' .edit').fadeIn(1000);
					break;						
				case 'save_rename':			
						
						paramsStr="id="+id+'&name='+jQuery('input.exporter_rename.'+id).val();					
						message="Exporter renamed";
					break;
			}
			var optionsStr = get_options();		 
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)))			
			paramsStr+="&action="+action_type+'&view_type='+options['view_type'];
			if(has_post){
				jQuery.ajax({
						type: "POST",
						url:appWebRoot+"meta/set_export_headers?"+paramsStr,
						timeout: 1000*60*5,
						success: function(data, textStatus ){									    
							jQuery('.exporter_type_buttons_td').html(data).hide().fadeIn(1000);
							warning(message+' successfully!',true);					 
						},
						error: function(xhr, textStatus, errorThrown){
							 warning(message+' failed!',false);					 
						}
				});			
			}					
		}
		
	find_data_item=function (data_list,label){
		item={};
		item['label']=label;
		item['compare_logic_field']='';
		item['y']=0;
		jQuery(data_list).each(function(index){
			data_item=data_list[index];
			if(data_item['label']==label){			    
				item['compare_logic_field']=data_item['compare_logic_field'];				
				item['y']=data_item['y'];
				item['dataslice_link_index']=data_item['dataslice_link_index'];
			}
		});
		return item;
	}

	 reconstruct_data_list=function(whole_data_list,all_label){
	    new_whole_data_list=[];
		i=0;
		//console.log(all_label);
		while(i<whole_data_list.length){
			 one_data_list=[];
			jQuery(all_label).each(function(index){
				
				data_item=find_data_item(whole_data_list[i],all_label[index]);
				data_item['link']=index;
				data_item['x']=index;
				//data_item['dataslice_link_index']=index;
				one_data_list[index]=data_item;		
			});
			new_whole_data_list[i]=one_data_list;
			i++;
		}		
		return new_whole_data_list;
	}
	
	construct_graph_data=function(options){
		whole_data_list=[];
		
		all_diagram_type=[];
		all_data_type_class=[];
		all_logic_field=[];
		all_title=[];
		all_label=[];
		jQuery('div.statistics_store.'+options['view_type']).each(function(whole_index){			
			dataPoints_list=[];
			
			classes=jQuery(this).attr('class').split(" ");								
			if(classes[1]!=undefined){
				logic_field=classes[1];
				data_type_class='.'+logic_field;
			}else{
				logic_field="";
				data_type_class=logic_field;							
			}	
			all_logic_field[whole_index]=logic_field;
			all_data_type_class[whole_index]=data_type_class;			
			title=jQuery('input.graph_title'+data_type_class+"."+options['view_type']).val();					
			all_title[whole_index]=title;			
			whole_title+=title+':';								
			
			
			jQuery('input.group_stats'+data_type_class+"."+options['view_type']).each(function(index){
				label=jQuery('input.label.'+index+data_type_class+"."+options['view_type']).val();					
				if(jQuery.inArray(label,all_label)==-1){
					all_label[all_label.length]=label;									
				}
				dataPoint_item={}; 									
				value=jQuery(this).val();	
				dataPoint_item['label']=label;
				active_tab_index=jQuery('ul.ui-tabs-nav').find('li.ui-tabs-active').index();					
				dataPoint_item['compare_logic_field']=logic_field;
				dataPoint_item['dataslice_link_index']=index;
				dataPoint_item['link']=index;			
				dataPoint_item['y']=parseFloat(value);
				dataPoint_item['x']=index;
				dataPoints_list[index]=dataPoint_item;																
				
			});
		
				
			all_diagram_type[whole_index]=jQuery('select.'+logic_field+".diagram_type").val();
			//console.log(jQuery('select.'+logic_field+".diagram_type").html());
			if(all_diagram_type[whole_index]==undefined){
				
				all_diagram_type[whole_index]='spline';
			}
			whole_data_list[whole_index]=dataPoints_list;
			//alert(whole_index);
		});	
		return_data={"all_title":all_title,"all_logic_field":all_logic_field,"all_data_type_class":all_data_type_class,"whole_title":whole_title,"whole_data_list":whole_data_list,"all_diagram_type":all_diagram_type,"all_label":all_label};		
		return return_data;
	}
	
	draw_data_diagram=function(){		
			
			var optionsStr =jQuery('input.options_str').val();			
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));
			whole_data_list=[];
			whole_title="";
			graph_count=0;																
			all_label=[];			
            return_data=construct_graph_data(options);
			//console.log(return_data);
			whole_data_list=return_data["whole_data_list"];
			all_diagram_type=return_data["all_diagram_type"];
			all_label=return_data["all_label"];
			//console.log(all_label);
			whole_title=return_data["whole_title"];
			all_data_type_class=return_data["all_data_type_class"];
			all_logic_field=return_data["all_logic_field"];
			all_title=return_data["all_title"];
			
			if(options['combine']==0){			
				//console.log(whole_data_list);
				whole_data_list=reconstruct_data_list(whole_data_list,all_label);
				
				jQuery(whole_data_list).each(function(index,dataPoints_list){
					data_type_class=all_data_type_class[index];					
					//console.log(dataPoints_list);
					diagram_type=all_diagram_type[index];
					logic_field=all_logic_field[index];
					title=all_title[index];
					jQuery('div.chartContainer'+data_type_class).css('height',100+20*dataPoints_list.length);
					
					draw_graph(logic_field,title,[dataPoints_list],diagram_type);	
				});
				
			}else{
					
				jQuery('div.chartContainer').css('height',100+20*all_label.length*whole_data_list.length);													
				whole_data_list=reconstruct_data_list(whole_data_list,all_label);
				//console.log(whole_data_list);
				draw_graph('',whole_title,whole_data_list,'spline');
			}	   
			
		}
		
		function draw_graph(chart_type,title,whole_data_list,diagram_type){	
			var optionsStr =jQuery('input.options_str').val();			
			options=jQuery.parseJSON(decodeURIComponent(decodeURIComponent(optionsStr)));
			
			graph_options={};						
			graph_options['whole_data_list']=whole_data_list;							
			graph_options['diagram_type']=diagram_type;			
			if(chart_type!="")
				graph_options['container']="chartContainer_"+chart_type+"_"+options['view_type'];
			else	
				graph_options['container']="chartContainer_"+options['view_type'];			
			graph_options['title']=title;
			
			if(whole_data_list.length>0)
				jQuery.draw_graph({graph_options:graph_options,options:options});				
				
			jQuery('.canvasjs-chart-credit').hide();
		}
	})(jQuery);		
		
		function build_template(data){
			html_str="<table>";
			
			jQuery(data.data).each(function(index){
				html_str+="<tr>";
				
				jQuery.map(data.headers,function(value,key){
					
					html_str+="<td>"+data.data[index][data.header_field_mapping[key]]+"</td>";					
				});
					
				html_str+="</tr>";				
			});	
			html_str+="</table>";
			return html_str;
		}
		active_tab_index=jQuery('input.active_tab_index').val();		
		jQuery('.group_by_tabs').tabs({hide: { effect: "none", duration: 1000 } ,selected:active_tab_index, async: true,
		 beforeLoad: function (event, ui) {
				//alert(ui.ajaxSettings.url);
				if(jQuery('#masthead').length>0){
					parts=appWebRoot.split('index.php');
					
					webRoot=parts[0].slice(0,-1);
					var url = webRoot+ui.ajaxSettings.url+"&json=true";
					
					
					jQuery.ajax({
						type: "GET",
						url: url,
						
						dataType: "jsonp",
						timeout: 90000,
						success: function(data, textStatus ){ 
							html_str=build_template(data);
							jQuery('.ui-tabs-panel:visible').html(html_str);
						}
					});
					return false;
				}else{
					return true;
				}
            },
		  beforeActivate: function(event, ui){
			//jQuery.blockUI({messageText:'Loading Data'});
		},
		load: function(event, ui) {		
			
		},create: function(event, ui) {
			//jQuery.blockUI({messageText:'Loading Data'});		    			
		}		 
		}).addClass('ui-tabs-vertical ui-helper-clearfix');	 
	
		if(jQuery('div.one_cluster').length>0){
			var groups = jQuery('div.one_cluster').map(function(spec) {			  
			  this_cluster=jQuery('div.one_cluster.'+spec);
			  return {
				label: this_cluster.find('.label').val(),
				weight: this_cluster.find('.score').val(),
				groups: this_cluster.find("div.docs input.doc").map(function(index) {
					 this_doc=this_cluster.find("div.docs input.doc."+spec+"."+index);
				  return {
					label: this_doc.val()
				  };
				})
			  };
			});

			var foamtree = new CarrotSearchFoamTree({
			  id: "visualization",
			  dataObject: {
				groups: groups
			  }
			});
		}
			
});