
<?
	
$sub_tab_filters_groups=$report_report['sub_tab_filters_groups'];
$clusters=$report_report['clusters'];
	
	//debug($clusters);die;
if(isset($sub_tab_filters_groups)){
	foreach($sub_tab_filters_groups as $logic_field=>$sub_filters_groups){?>
		<?$i=0;foreach($sub_filters_groups as $field=>$sfg){?>	
			<input type="hidden" class="data_slice_link <?=$i?> <?=$logic_field?>" value="<?='search_query_get_data'.'?url='.$url.'&sid='.$sid.'&filters_groups='.$sfg.'&options='.$options_str?>"/>
		<?$i++;}?>
	<?}
	}
?>

<?if(!(isset($options['show_sql_only'])&&!empty($options['show_sql_only']))){?>

	
<div id="visualization" style="width:800px;height:600px">		
	<?
	  $i=0;
	  foreach($clusters as $one_cluster){
	    ?>
		 <div class="one_cluster <?=$i?>">
			  <input type="hidden" class="label" value="<?=$one_cluster['labels'][0]?>"></input>
			  <input type="hidden" class="score" value="<?=$one_cluster['score']?>"></input>
			  <div class="docs">
				<?
				$j=0;
				foreach($one_cluster['docs'] as $doc){?>					
				 <input type="hidden" class="doc <?=$i?> <?=$j?>" value="<?=$doc?>"> </input>	
				<?
				$j++;
				}?>
			  </div>
		 </div>	
			
		<?			 
		$i++;
	  }
	
	?>	  
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
 
<input type="hidden" class="options_str" value="<?=$options_str?>"/>
<input type="hidden" class="filter_groups_str" value="<?=$filter_groups_str?>" />

