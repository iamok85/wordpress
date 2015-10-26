


<form id="search_form_557e71b1719f9">
	

<?php foreach($reports_field_list as $logicfield=>$field_data):?>

			 <?php debug($field_data);?>
	          <?if(is_array($field_data)&&isset($field_data['label'])){?>
				
						<tr class="field_label">
							<td class="label">
								
								<?php if($field_data['type']!='hidden'){?>
									
									<label><?php _e($field_data['label'],'reportApp'); ?>
										
										
										<?if(isset($field_data['validate']['required'])&&$field_data['validate']['required']===true){?>									
											
											<span style="color:red" class="required">*</span>
											
										<?}?>	
										
									</label>
									<p class="description"><?php _e("",'reportApp'); ?></p>
									
								<?php }?>								
							</td>
							<td>
								<?php 
								
								$options=array('key'=>$logicfield,'post_type'=>$field_data['post_type']);
																
								if(isset($field_data['validate'])){
									
								 	$options=array_merge($options,$field_data['validate']);
																		   
								 }
								 								
								if(isset($field_data['value'])){
								 		
								//	error_log('load value'."\n");
									//error_log(print_r($field_data['value'],true));	 
								 	$options=array_merge($options,array('value'	=>	$field_data['value']));
								}else{
									
									$options=array_merge($options,array('value'	=>	''));
								}
								 
								 
								switch($field_data['type']){
										
									case 'text':																			
										$options=array_merge($options,array(
											'width'=>'300px',
											'type'	=>	$field_data['type'],
											'name'	=>	'fields[' .$field_data['post_type']. ']['.$logicfield.']'
																																							
										));
										
										do_action('reportApp/create_field', $options);	
										break;	
										
									case 'hidden':																			
										$options=array_merge($options,array(
											
											'type'	=>	$field_data['type'],
											'name'	=>	'fields[' .$field_data['post_type']. ']['.$logicfield.']'
																																							
										));
										
										do_action('reportApp/create_field', $options);	
										break;											
																																	
								}																	
								?>
							</td>
		
						</tr>
		
			<?php }?>
		
	<?php endforeach; ?>
	
<div class="557e71b1719f9 filter_area well well-small background-white" >				
						
	<div>
		<div class="filters_groups_container" style="width:250px">
		
		</div>
	</div>																			
	
	<div class="text-center">
		<div class="add_or_filter" id="add_or_filter" href="#" title="Click to add a new filter group which has an OR relation with the previous filter(s)" style="cursor:pointer">
		
			<span style="color: green">
				<i class="icon-plus icon-2x"></i>									
			</span> 							
	
		</div>								
	</div>	
	
	<hr/>
	
	<div  class="well well-small background-white" style="width:250px" id="search_display_options">										
	
	</div>					
	
</div>





</form>
