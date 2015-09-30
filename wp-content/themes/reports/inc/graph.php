
<?
	
	$sub_tab_filters_groups=$report_report['sub_tab_filters_groups'];
	$compare_result=$report_report['compare_result'];
	$compare_fields_array =$report_report['compare_fields_array'];
	$mapping_logicfield_displayfield =$report_report['mapping_logicfield_displayfield'];
	$options['render_type']='table';
	$options_str=urlencode(json_encode($options));
	$sql=$report_report['sql'];
    $filter_groups_str=$report_report['filter_groups_str'];
	$url=$report_report['url'];
	$sid=$report_report['sid'];
if(isset($sub_tab_filters_groups)){
	foreach($sub_tab_filters_groups as $logic_field=>$sub_filters_groups){?>
		<?$i=0;foreach($sub_filters_groups as $field=>$sfg){?>	
			<input type="hidden" class="data_slice_link <?=$i?> <?=$logic_field?>" value="<?='search_query_get_data'.'?url='.$url.'&sid='.$sid.'&filters_groups='.$sfg.'&options='.$options_str?>"/>
		<?$i++;}?>
	<?}
	}
?>

<?if(!(isset($options['show_sql_only'])&&!empty($options['show_sql_only']))){?>

	
<strong>Click the chart to see data slice </strong>
<?//debug($compare_result)?>
<div class="graph">	
	
	<?	if(!(empty($compare_result))){?>
           		  
		    <?foreach($compare_result as $logicfield=>$item){?>
				
				<?if(isset($mapping_logicfield_displayfield[$logicfield])){?>
					<input type="hidden" value="<?=$mapping_logicfield_displayfield[$logicfield]?>" class="graph_title <?=$logicfield?> <?=$one_report['ID']?>" />							  
				<?}else{
						$display_name='';
						foreach($compare_fields_array as $one_logic_field){
						
							$display_name.=$mapping_logicfield_displayfield[$one_logic_field].',';
						}
						$display_name=trim($display_name,',');
					?>
				<input type="hidden" value="<?=$display_name?>" class="graph_title <?=$logicfield?> <?=$one_report['ID']?>" />							  	
				<?}?>
				<div class="statistics_store <?=$logicfield?> <?=$one_report['ID']?>">
					<?$i=0;?>
					<?foreach($item as $field=>$count){?>			
					  <input type="hidden" class="label <?=$i?> <?=$logicfield?> <?=$one_report['ID']?>" value="<?=$field?>"/>
					  <input type="hidden" class="group_stats <?=$i?> <?=$logicfield?> <?=$one_report['ID']?>" value="<?=$count?>"/>
					  <?$i++;?>
					<?}?>
				</div>
			<?}?>
		<?}?>
	
	<?if(!(empty($compare_result))){?>	
	
		<?//debug($options['compare_with'][0]);?>
		<?if($options['combine']==0){?>
			<?$i=0;?>
			<?foreach($compare_result as $logicfield=>$item){?>

	
			  <div id="chartContainer_<?=$logicfield?>_<?=$options['view_type']?>" class="chartContainer <?=$logicfield?> <?=$one_report['ID']?>" style="height: 300px; width: 100%;">
			  
			  </div>
			<?$i++;}?> 
		<?}else{?>
			
			<div id="chartContainer_<?=$options['view_type']?>" class="chartContainer <?=$one_report['ID']?>" style="height: 300px; width: 100%;">
			  
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
		<?//debug($sql);die;?>
				
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
 
<input type="hidden" class="options_str <?=$one_report['ID']?>" value="<?=$options_str?>"/>
<input type="hidden" class="filter_groups_str <?=$one_report['ID']?>" value="<?=$filter_groups_str?>" />
 
