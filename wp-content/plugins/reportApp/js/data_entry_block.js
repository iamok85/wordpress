(function($) {	
	var this_block;
	var this_block_classes=[];
	var this_block_index;
	var last_filter;	
	var opts={};
	var options;
    var default_arg={'lock':false};
	var all_fields;
	$.data_entry_block=function(arg){			
		if(default_arg)
			opts= $.extend({},default_arg,arg||{});			
		all_fields_str=arg["all_fields_str"];	
		if(arg['container']!=undefined&&jQuery(arg['container'])!=undefined){
			container_el=jQuery(arg['container']);
			//console.log(container_el);
			numberOfGroup=container_el.find('.block_instance').length;
			this_block_index=numberOfGroup;
			
			html_str='';
			html_str+='<div class="block_instance '+this_block_index+'" style="padding:5px;border:sold;margin-bottom:15px;background:#FFFF99;" data-original-title="" title="">';									
			
			html_str+='<input type="hidden" class="all_fields_str '+this_block_index+'" value="'+all_fields_str+'"></input>';
			
			if(arg['block']['block_label']){
				console.log(opts['lock']);
				if(opts['lock'])
					html_str+='<span style="margin:5px"><strong>Block Label</strong></span><input readonly type="text" value="'+decodeURIComponent(arg['block']['block_label'].replace(/\+/g, " "))+'" class="block_label '+this_block_index+'"/>';
				else
					html_str+='<span style="margin:5px"><strong>Block Label</strong></span><input type="text" value="'+decodeURIComponent(arg['block']['block_label'].replace(/\+/g, " "))+'" class="block_label '+this_block_index+'"/>';
			}else{
				html_str+='<span style="margin:5px"><strong>Block Label</strong></span><input type="text" class="block_label '+this_block_index+'"/>';
			}
			if(this_block_index>0){
				html_str+='<a class="delete_block '+this_block_index+'"  style="float:right;margin-right:3px;background-color:transparent;cursor:pointer;float:right" data-original-title="" title=""><i title=""  class="icon-trash icon-2x" data-original-title="Click to delete this filter group"></i></a>';
			}
			
			if(!opts['lock'])
				html_str+='<div href="#" style="width:20px;height:20px;margin-top:5px" class="add_field '+this_block_index+'" title=""></div>';
			
			
			html_str+='</div>';			
			last_filter=undefined;		
			container_el.append(html_str);				
			this_block=container_el.find('.block_instance.'+this_block_index);			
			bindAddField();
			bindDeleteField();
			bindDeleteBlock();
		
			return $.fn.data_entry_block.dispatcher['_create'](opts);
		}
	}
	$.fn.data_entry_block = function(cmd, arg) {
		this_block		=this;
		this_block_class=this_block.attr('class').split(' ');
		this_block_index=this_block_class[1];						
		var opts = $.extend({},default_arg,arg||{});		
		last_field=(this_block.children('div.field_instance').length?this_block.children('div.block_instance').last():undefined);
		if (typeof cmd == 'string') {			
			return $.fn.block.dispatcher[cmd](opts);
		}		
		//return the command dispatcher		
		return $.fn.block.dispatcher['_create'](opts);
	};

	//create the command dispatcher
	$.fn.data_entry_block.dispatcher = {		
		//initialized with options
		_create : function( opts) {		
			creatBlock(opts);
			jQuery.unblockUI();
		},
		//toggle the element's display
		add_block: function(opts) {
						         			
		}			
	}
	
	$.fn.block_seralize=function(cmd,arg){
		this_block		=this;
		this_block_class=this_block.attr('class').split(' ');
		block_index=this_block_class[1];
		prefix="div.block_instance."+block_index;
		fields=[];
		block={};
		block_label=jQuery(prefix+" .block_label").val();		
		jQuery(prefix+" .field").each(function(index){
			classes=jQuery(this).attr("class").split(" ");
			field_index=classes[1];	
			logicField=jQuery(this).find('.data_field.'+field_index+'.'+block_index).find('option:selected').val();
			fieldType=jQuery(this).find('.field_type.'+field_index+'.'+block_index).find('option:selected').val();
			fields[index]={'logicField':logicField,'fieldType':fieldType};
		});	
		block['fields']=fields;
		block['block_label']=block_label;
		//console.log(blockblock_index);
		return block;
	}
	
	function creatBlock(opts){	
		//console.log(opts['block']);
		if(opts['block']['fields']&&opts['block']['fields'].length>0){
			jQuery.each(opts['block']['fields'],function(key,value){
				
				if(opts['lock']){
					add_field(key,value,this_block_index,true);												
				}else{
					add_field(key,value,this_block_index,false);												
				}	
			});							
		}else{
			add_field(0,"",this_block_index);												
		}
	};
	
	// get a filter to filters group
	function add_field(field_index,field,block_index,lock){		
		html="";
		
		logicField_passed=field['logicField'];
		//console.log(logicField_passed);
		fieldType=field['fieldType'];
	
		all_fields_str=jQuery('.all_fields_str.'+block_index).val();
		//console.log(all_fields_str);
		//console.log(decodeURIComponent(all_fields_str.replace(/\+/g, " ")));
		all_fields=jQuery.parseJSON(decodeURIComponent(all_fields_str.replace(/\+/g, " ")));
		
		html+="<div class='field "+field_index+" "+block_index+"'><table><tr><td>";
		
		if(lock){
			
			jQuery.each(all_fields,function(index){					
				logicField=all_fields[index]['logicField'];
				displayName=all_fields[index]['displayName'];
				if(logicField_passed==logicField){
					html+="<input readonly value='"+displayName+"'/>";			
					html+="<input type='hidden' class='data_field "+field_index+" "+block_index+"'/>";		
					//break;
				}					
			});
			
			
		}else{
			html+="<select class='data_field "+field_index+" "+block_index+"'>";		
			jQuery.each(all_fields,function(index){					
				logicField=all_fields[index]['logicField'];
				displayName=all_fields[index]['displayName'];
				if(logicField_passed==logicField)
					html+="<option selected value='"+logicField+"'>"+displayName+"</option>"
				else	
					html+="<option value='"+logicField+"'>"+displayName+"</option>"
			});
			html+="</select>";
		}
		
		html+="</td>";
		
		
		html+='<td><select class="field_type '+field_index+' '+this_block_index+'">';
		
		if(fieldType=='Free+Text')
			html+='<option selected class="free_text">Free Text</option>';
		else
			html+='<option class="free_text">Free Text</option>';
		if(fieldType=='Date')
			html+='<option selected class="date">Date</option>';
		else
			html+='<option class="date">Date</option>';
			
		html+='</select></td>';
		if(!lock)
			html+="<td><div href='#' style='width:20px;height:20px;margin-top:5px' class='delete_field "+field_index+" "+this_block_index+"' ></div><td>";
	    
		html+="</tr></table></div>";
		jQuery('.block_instance.'+block_index).append(html);		
	}
	function bindDeleteField(){
		jQuery('.delete_field').live('click',function(){
			classes=jQuery(this).attr('class').split(' ');
			field_index=classes[1];
			block_index=classes[2];
			//console.log(field_index+':'+block_index);
			jQuery(this).parent().parent().parent().parent().parent().remove();
		});
	}
	function bindDeleteBlock(){	
		
		jQuery('.delete_block').bind('click',function(){
			classes=jQuery(this).attr('class').split(' ');
			block_index=classes[1];
			
			jQuery('.block_instance.'+block_index).fadeOut(200, function(){jQuery('.block_instance.'+block_index).remove();});
		});				
		//jQuery('.filter_area:visible').css("height",'auto');		
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
	
	function bindAddField(){		
		/*Add a new And Filter to a filter group*/
		
		jQuery('.add_field').unbind('click');				
		jQuery('.add_field').bind('click',function(){
			classes=jQuery(this).attr('class').split(' ');
			this_block_index=classes[1];
			fields=jQuery('.block_instance.'+this_block_index).find('.field');
			fields_length=fields.length;
			new_index=0;
			if(fields_length>0){
				classes=jQuery(fields[fields_length-1]).attr('class').split(' ');
				new_index=parseInt(classes[1])+1;
			}
			add_field(new_index,"",this_block_index);												
		});		
	}
	

	
		
})(jQuery);

