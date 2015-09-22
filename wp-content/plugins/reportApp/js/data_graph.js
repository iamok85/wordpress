

(function($) {	
		
	data_list=[];
	$.draw_graph=function(arg){
		opts=arg['graph_options'];
		options=arg['options'];
		diagram_type=opts['diagram_type'];
		whole_data_list=opts['whole_data_list'];
		title_list=opts['title'].split(':');
		//console.log(whole_data_list);
		data_list=[];
		jQuery.each(whole_data_list,function(index){					
			if(options['combine']==1){
				color="#"+((1<<24)*Math.random()|3).toString(16);
			}else{
				color='#33CC33';
			}
			    
			//console.log(color);	
			compare_logic_field=whole_data_list[index][0]['compare_logic_field'];															
			one_data={     
				click: function(e){
					compare_array=[];
					jQuery(options['compare_with']).each(function(index,value){
						compare_array[index]=value['logic_field'];
					});
					;
					index=e.dataPoint.link;
					link_index=e.dataPoint.dataslice_link_index;
					link=jQuery('input.'+link_index+'.'+e.dataPoint.compare_logic_field+'.data_slice_link').val();
					link+="&compare_logic_field="+JSON.stringify(compare_array)+"&from=graph";					
					url=appWebRoot+'/search/'+link;				
					window.open(url, '_blank');
				},
				type: diagram_type,
                name: "companies",
				axisYType: "secondary",
				color: color,	
				showInLegend: true,
                legendText: title_list[index],
				dataPoints: whole_data_list[index]
			};
			data_list[index]=one_data;		
		});
		
        creatChart(opts);		
	}

	$.fn.draw_graph = function(cmd, arg) {
		return $.fn.draw_graph.dispatcher['_create'](opts);
	};

	//create the command dispatcher
	$.fn.draw_graph.dispatcher = {		
		//initialized with options
		_create : function( opts) {		
			creatChart(opts);
		},
							         		
		add_graph: function(opts) {
		}
		
	};
		
	function creatChart(opts){			
					
		
		container=opts['container'];
		console.log(data_list);
		var chart = new CanvasJS.Chart(container, {

			title:{				
				text:""
			},
            animationEnabled: true,
			axisX:{
				interval: 1,
				gridThickness: 0,
				labelFontSize: 10,
				labelFontStyle: "normal",
				labelFontWeight: "normal",
				labelFontFamily: "Lucida Sans Unicode"

			},
			axisY2:{
				interlacedColor: "rgba(1,77,101,.2)",
				gridColor: "rgba(1,77,101,.1)"

			},
			data: data_list
		});
        
		chart.render();
	}
			 
		
	
})(jQuery);


