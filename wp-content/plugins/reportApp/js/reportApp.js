jQuery(document).ready(function($){
		
(function($){
		
		
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
		
	
})(jQuery);
		
   var form = $("form[name='post']");
   
    jQuery(form).find("input[type='submit']").click(function(e){  
			e.preventDefault();
			filters_groups_str=get_filters();
			//alert(filters_groups_str);
			var input_filters_groups = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "fields[reports][reports_filters_groups]").val(encodeURIComponent(filters_groups_str));
			jQuery(form).append($(input_filters_groups));
			
			options_str=get_options();
			var input_options = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "fields[reports][reports_options]").val(encodeURIComponent(options_str));
			jQuery(form).append($(input_options));
			
			jQuery(form).submit();
    });
    
	
	
});