
(function($) {	
	
	var paired_node_list=[];
	var edge_list=[];
	var root_node;
	var graph;
	var container_id;
	var nodes_container;
	var node_click_function;
	$.draw_schema_graph=function(arg){
		container_id=opts=arg['container_id'];				
		nodes_container=arg['nodes_container'];
		node_click_event=arg['node_click_event'];
        creatGraph();		
		graph.viewport({
	      pan:{x:0,y:150}  
		});
		if(arg['color_node']){
			colorMainNode(arg['main_node']);	
		}
		graph.$('node').one('click',node_click_event);
		colorJoinNode();
		return this;
	}
	
	$.draw_schema_graph.colorMainNode=function(main_table){	
		colorMainNode(main_table);
	}
	$.fn.draw_schema_graph = function(cmd, arg) {		
		return $.fn.draw_schema_graph.dispatcher['_create']();
	};

	//create the command dispatcher
	$.fn.draw_schema_graph.dispatcher = {		
		//initialized with options
		_create : function( opts) {		
			container_id=opts=arg['container_id'];				
			nodes_container=arg['nodes_container'];
			node_click_event=arg['node_click_event'];
			creatGraph();
			graph.$('node').one('click',node_click_event);
		}					         		
	};
	
	function getNodeAndEdgeList(nodes_container){
		 nodes_container=jQuery("."+nodes_container);
		 nodes_container.find('.node').each(function(index){	      
			 classes=jQuery(this).attr('class').split(" ");
			 paired_node_list[index]={data:{id:classes[1]}};
		 });	 
		 
		 node_count={};
		 nodes_container.find('.edge').each(function(index){	     
			 classes=jQuery(this).attr('class').split(" ");
			 if((jQuery('.'+classes[1]+'.joined_table').length>0)&&(jQuery('.'+classes[3]+'.joined_table').length>0)){
				edge_list[index]={data:{id:classes[1],weight:1,label:'bt',source:classes[2],target:classes[3],'line-color':"#E39F0E"}};		 			 
			 }else{
				edge_list[index]={data:{id:classes[1],weight:1,label:'bt',source:classes[2],target:classes[3]}};		 			 
			}
			 if(classes[2] in node_count)
				node_count[classes[2]]++;
			 else	
				node_count[classes[2]]=1;
			
			 if(node_count[classes[3]])
				node_count[classes[3]]++;
			 else	
				node_count[classes[3]]=1;		
		 });
		 max=0;		 
		 jQuery.each(node_count,function(index,value){
			if(value>max){
				max=value;
				root_node=index;
			}			
		 });
	 
	}
	function colorJoinNode(){
		
		tables=jQuery('.joined_table');
		
		graph.$('#'+main_table).addClass('joined');
		
		i=0;
		while(i<tables.length){
			table1=jQuery(tables[i]).val();	
			
			graph.$('#'+table1).addClass('joined');
			i++;
		}
		
		
		
	}
	function colorMainNode(main_table){			
	
		var dijkstra = graph.elements().dijkstra('#'+main_table, function(){
		  return this.data('weight');
		});	

		root_node=graph.$('#'+main_table);
		
		root_node.addClass('highlighted');
		all_nodes=graph.nodes();
		jQuery(all_nodes).each(function(index){
			 
			if(all_nodes[index].id()!=root_node.id()){
				
				 pathToNode = dijkstra.pathTo(all_nodes[index]);
				 jQuery(pathToNode).each(function(index){					
					if(pathToNode[index].isEdge()){
						pathToNode[index].addClass('highlighted_neighboor');				 
					}
				 });				
			}			
		});		
		
		graph.forceRender();
	}
	function creatGraph(){				
		getNodeAndEdgeList(nodes_container);
		graph = cytoscape({
		  container: document.getElementById(container_id),		 
		  style: cytoscape.stylesheet()
			.selector('node')
			  .css({
				'content': 'data(id)',
				'font-size':'6px',
				'transition-property': 'background-color, line-color, target-arrow-color',
				'transition-duration': '0.5s',
				 "width":"5px",
				 "height":"5px"
			  })
			.selector('edge')
			  .css({
				'target-arrow-shape': 'triangle',
				'width': 1,
				'line-color': '#bbb',
				'target-arrow-color': '#bbb',
				'curve-style': 'bezier',
				 'content': 'data(label)',
				 'font-size':'8px'
			  })  
			  .selector('.highlighted')
			  .css({
				'background-color': '#61bffc',
				'line-color': '#61bffc',
				'target-arrow-color': '#61bffc',
				
				
			  })	 
			  .selector('.highlighted_neighboor')
			  .css({
				'background-color': '#E39F0E',
				'line-color': '#E39F0E',
				'target-arrow-color': '#E39F0E',
				
				
			  })
			 .selector('.joined')
			  .css({
				'background-color': 'blue',
				'line-color': 'blue',
				'target-arrow-color': 'blue',
				
				
			  }),
		  elements:{
			 nodes:paired_node_list,	  
			 edges:edge_list
		   },  
		  zoomingEnabled: false,
		  userZoomingEnabled:false,
		  userPanningEnabled:true
		  layout: {			 
			name: 'cose',		
			directed: false,			
			roots: '#'+root_node
		  }
		});
	}
			 		
})(jQuery);
