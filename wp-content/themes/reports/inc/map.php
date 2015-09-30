<style>
 html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
    }
</style>


	<?php
	
		$sub_tab_filters_groups=$report_report['sub_tab_filters_groups'];
		$compare_result=$report_report['compare_result'];
		//debug($compare_result);
		$mapping_logicfield_displayfield =$report_report['mapping_logicfield_displayfield'];
		$options['render_type']='table';
		$options_str=urlencode(json_encode($options));
		$sql=$report_report['sql'];
		$filter_groups_str=$report_report['filter_groups_str'];
		$group_value_match_array=$report_report['group_value_match_array'];
		$url=$report_report['url'];
		$sid=$report_report['sid'];
	?>

<?if(!(isset($options['show_sql_only'])&&!empty($options['show_sql_only']))){?>
	
<strong>Click the map marker to see data slice </strong>
<?
$options['render_type']='table';
$options_str=urlencode(json_encode($options));
?>
<div class="graph">	
	
	<?
		//debug($compare_result);
		//debug($all_places);
		if(!(empty($compare_result))){?>
           	
			<?$empty_flag=true;?>  
			<?//debug($group_value_match_array);die;?>
		    <?foreach($compare_result as $logicfield=>$item){
				
				
			?>
				<?if(!isset($item['total'])){
					$empty_flag=false;
				}?>
				<input type="hidden" value="<?=$mapping_logicfield_displayfield[$logicfield]?>" class="graph_title <?=$logicfield?>" />							  
				<div class="statistics_store <?=$logicfield?>">
					<?$i=0;?>
					<?foreach($item as $field=>$count){?>					
						<?if(isset($group_value_match_array[$field])){?>
						  <input type="hidden" class="label <?=$i?> <?=$logicfield?> <?=$options['view_type']?>" value="<?=$field?>"/>						  
						  <input type="hidden" class="geolocation <?=$i?> <?=$logicfield?> <?=$options['view_type']?>" value="<?=$group_value_match_array[$field]?>"/>
						  <input type="hidden" class="location_stats <?=$i?> <?=$logicfield?> <?=$options['view_type']?>" value="<?=$count?>"/>
						  <?$sfg=$sub_tab_filters_groups[$logicfield][$field]?>
						  <input type="hidden" class="data_slice_link <?=$i?> <?=$logicfield?>" value="<?='search_query_get_data'.'?url='.$url.'&sid='.$sid.'&filters_groups='.$sfg.'&options='.$options_str?>"/>
						<?}?>
					<?$i++;?>
					<?}?>
				</div>
			<?}?>
			<?
		
			?>
			<?if(!$empty_flag){?>
			 <div style="height:100%; width: 100%;"> 
				<div class="map-canvas <?=$logicfield?>" style="width:900px;height:500px">
				  
				</div>
			</div>
			<?}?>
		<?}?>
		  
</div>
<?}?>
 <?if(!(isset($options['show_sql_only'])&&!empty($options['show_sql_only']))){?>
	<div class="total_sql_display_div" style="display:none;">
			
				<?foreach($sql as $logic_field=>$one_sql){					
					echo '<pre>';					
					echo $one_sql;	
					echo '</pre>';
				 }?>
		
	</div>	
 <?}else{?>
	 <div class="total_sql_display_div">
	 
			     <?
					if(isset($sql)){			
					  foreach($sql as $one_sql){											
						echo '<pre>';					
						echo $one_sql;	
						echo '</pre>';
					 }
				 }?>
		
	</div>	
 <?}?>

 <div class="modal_data_slice"> </div>
 
<input type="hidden" class="options_str" value="<?=$options_str?>"/>
<input type="hidden" class="filter_groups_str" value="<?=$filter_groups_str?>" />


