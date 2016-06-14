<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/jo_module/main.css');
$cs->scriptMap=array(
/* 'select2.min.js'=>false,
 'select2-bootstrap.css'=>false,
 'select2.css'=>false
 'jquery.js'=>false,
 'jquery.min.js'=>false*/
);

?>
<input type="hidden" value ="<?php echo Yii::app()->session['access_role'];?>" id="access" />
<script src="<?php
echo Yii::app()->request->baseUrl;
?>/js/jquery.ui.touch-punch.min.js"></script>
<div style="margin-top:60px;">

	<!--Labels-->
	<div>
		<?php
			$box = $this->beginWidget(
    			'booster.widgets.TbPanel',
    			array(
        			'title' => 'Menu',
        			'headerIcon' => 'cog',
        			'padContent' => false,
        			'headerButtons' => array(
           				 
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Show Done Jo's",
            				'context' => 'link',
            				'buttonType' => 'link',
        					'url' => Yii::app()->baseUrl.'/jo/done',
            				'size'=>'small',
            				'htmlOptions'=> array(
            					'onclick' => 'js:(function(){
                    				 	var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    					$("body").append(div_val);
                    				
            					 })();'
            				),
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Add New JO",
            				'context' => 'primary',
            				'icon'=>'plus',
            				'size'=>'small',
            				'visible'=>	Yii::app()->user->isProductionHead,
            				'htmlOptions'=> array(
            					
                    			'data-toggle' => 'modal',
                    			'data-target' => '#add_new_jo_modal',  
                    			'onclick' => 'js:(function(){
                    				console.log("deleting...");
									
									var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
									$("body").append(div_val);
                    			
                    				//jQuery.noConflict();
                    				//START --- Custom Reset Codes for Add New Form Modal
                    				
                					//remove error 	red outline to input boxes
                          			$("#add_new_jo_form").children().removeClass("error");
                    				$(".error").removeClass("error");
                    				
                    				//remove error message
                    				$("[id$=_error]").children().remove();
                    				
                    				//reset form values
                    				document.getElementById("add_new_jo_form").reset();
                    				
                    				//custom reset fo SELECT2 element (bootstrap)
                    				//$("select").select2("val", "");
                    				
                    				//END --- Custom Reset Codes for Add New Form Modal
                    				
            					 })();'
            				),
        					
						),
						
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
            			array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "Toggle Edit Mode",
        					'buttonType' => 'link',
        					//'url' => Yii::app()->baseUrl.'/jo/edit',
            				//'context' => 'link',
            				'icon'=>'resize-vertical',
            				'size'=>'small',
            				'htmlOptions'=> array(
            					'onclick' => 'js:(function(){
                    				 	var div_val = "<div id=\"loading_div\" class=\"modal-backdrop fade in\"><img src=\"http://192.241.245.46/jo_manager/images/loading.gif\" style=\"position: absolute; left: 0; top: 0; right: 0; bottom: 0; margin: auto;\"/></div>";
                    					$("body").append(div_val);
                    					
                    					var access_role = document.getElementById("access").value;
                    					
                    					var user_access = "";
                    					
                    					var params = "";
                    					
                    					if(access_role=="Sewing Output & Status Controller"){
                    						user_access="Sewing";
                    					}else if(access_role=="Finishing Output & Status Controller"){
                    						user_access="Finishing";
                    					
                    					}else if(access_role=="Line Head" || access_role=="Global Viewer" || access_role=="Production Head"){
                    						user_access="All";
                    					
                    					}
                    					
                    					if(user_access=="Sewing" || user_access=="All"){
										   var sewing_priority = document.getElementById("JoSewing_priority").value;
										   var sewing_jo = document.getElementById("JoSewing_jo").value;
										   var sewing_brand = document.getElementById("JoSewing_brand").value;
										   var sewing_quantity = document.getElementById("JoSewing_quantity").value;
										   var sewing_category = document.getElementById("JoSewing_category").value;
										   var sewing_color = document.getElementById("JoSewing_color").value;
										   var sewing_date_received = document.getElementById("JoSewing_date_received").value;
										   var sewing_days_needed = document.getElementById("JoSewing_days_needed").value;
										   var sewing_days_allotted = document.getElementById("JoSewing_days_allotted").value;
										   var sewing_allowance = document.getElementById("JoSewing_allowance").value;
										   var sewing_target_end_date = document.getElementById("JoSewing_target_end_date").value;
										   var sewing_delivery_date = document.getElementById("JoSewing_delivery_date").value;
										   var sewing_line = document.getElementById("JoSewing_line").value;
										   var sewing_status = document.getElementById("JoSewing_status").value;
										   var sewing_output = document.getElementById("JoSewing_output").value;
										   var sewing_balance = document.getElementById("JoSewing_balance").value;
										   var sewing_comments = document.getElementById("JoSewing_comments").value;
										   var sewing_washing_info= document.getElementById("JoSewing_washing_info").value;
										   var sewing_delivery_receipt = document.getElementById("JoSewing_delivery_receipt").value;
										   
											params += "JoSewing[priority]="+sewing_priority+
                    					             "&JoSewing[jo]="+sewing_jo+
                    					             "&JoSewing[brand]="+sewing_brand+
                    					             "&JoSewing[quantity]="+sewing_quantity+
                    					             "&JoSewing[category]="+sewing_category+
                    					             "&JoSewing[color]="+sewing_color+
                    					             "&JoSewing[date_received]="+sewing_date_received+
                    					             "&JoSewing[days_needed]="+sewing_days_needed+
                    					             "&JoSewing[days_allotted]="+sewing_days_allotted+
                    					             "&JoSewing[allowance]="+sewing_allowance+
                    					             "&JoSewing[target_end_date]="+sewing_target_end_date+
                    					             "&JoSewing[delivery_date]="+sewing_delivery_date+
                    					             "&JoSewing[line]="+sewing_line+
                    					             "&JoSewing[status]="+sewing_status+
                    					             "&JoSewing[output]="+sewing_output+
                    					             "&JoSewing[balance]="+sewing_balance+
                    					             "&JoSewing[comments]="+sewing_comments+
                    					             "&JoSewing[washing_info]="+sewing_washing_info+
                    					             "&JoSewing[delivery_receipt]="+sewing_delivery_receipt;
                    					}
                    					
                    					if(user_access=="Finishing" || user_access=="All"){
											var finishing_priority = document.getElementById("JoFinishing_priority").value;
											var finishing_jo = document.getElementById("JoFinishing_jo").value;
											var finishing_brand = document.getElementById("JoFinishing_brand").value;
											var finishing_quantity = document.getElementById("JoFinishing_quantity").value;
											var finishing_category = document.getElementById("JoFinishing_category").value;
											var finishing_color = document.getElementById("JoFinishing_color").value;
											var finishing_date_received = document.getElementById("JoFinishing_date_received").value;
											var finishing_days_needed = document.getElementById("JoFinishing_days_needed").value;
											var finishing_days_allotted = document.getElementById("JoFinishing_days_allotted").value;
											var finishing_allowance = document.getElementById("JoFinishing_allowance").value;
											var finishing_target_end_date = document.getElementById("JoFinishing_target_end_date").value;
											var finishing_delivery_date = document.getElementById("JoFinishing_delivery_date").value;
											var finishing_line = document.getElementById("JoFinishing_line").value;
											var finishing_status = document.getElementById("JoFinishing_status").value;
											var finishing_output = document.getElementById("JoFinishing_output").value;
											var finishing_balance = document.getElementById("JoFinishing_balance").value;
											var finishing_comments = document.getElementById("JoFinishing_comments").value;
											var finishing_washing_info= document.getElementById("JoFinishing_washing_info").value;
											var finishing_audit_date= document.getElementById("JoFinishing_audit_date").value;
											var finishing_total_delivered= document.getElementById("JoFinishing_total_delivered").value;
											var finishing_salesman_sample= document.getElementById("JoFinishing_salesman_sample").value;
											var finishing_delivery_1= document.getElementById("JoFinishing_delivery_1").value;
											var finishing_delivery_2= document.getElementById("JoFinishing_delivery_2").value;
											var finishing_delivery_3= document.getElementById("JoFinishing_delivery_3").value;
											var finishing_delivery_4= document.getElementById("JoFinishing_delivery_4").value;
											var finishing_delivery_5= document.getElementById("JoFinishing_delivery_5").value;
											var finishing_second_quality= document.getElementById("JoFinishing_second_quality").value;
											var finishing_unfinished= document.getElementById("JoFinishing_unfinished").value;
											var finishing_lacking= document.getElementById("JoFinishing_lacking").value;
											var finishing_closed= document.getElementById("JoFinishing_closed").value;
											
											if(access="All"){
												params += "&";
											}
											
											
											params += "JoFinishing[priority]="+finishing_priority+
                    					             "&JoFinishing[jo]="+finishing_jo+
                    					             "&JoFinishing[brand]="+finishing_brand+
                    					             "&JoFinishing[quantity]="+finishing_quantity+
                    					             "&JoFinishing[category]="+finishing_category+
                    					             "&JoFinishing[color]="+finishing_color+
                    					             "&JoFinishing[date_received]="+finishing_date_received+
                    					             "&JoFinishing[days_needed]="+finishing_days_needed+
                    					             "&JoFinishing[days_allotted]="+finishing_days_allotted+
                    					             "&JoFinishing[allowance]="+finishing_allowance+
                    					             "&JoFinishing[target_end_date]="+finishing_target_end_date+
                    					             "&JoFinishing[delivery_date]="+finishing_delivery_date+
                    					             "&JoFinishing[line]="+finishing_line+
                    					             "&JoFinishing[status]="+finishing_status+
                    					             "&JoFinishing[output]="+finishing_output+
                    					             "&JoFinishing[balance]="+finishing_balance+
                    					             "&JoFinishing[comments]="+finishing_comments+
                    					             "&JoFinishing[washing_info]="+finishing_washing_info+
                    					             "&JoFinishing[audit_date]="+finishing_audit_date+
                    					             "&JoFinishing[total_delivered]="+finishing_total_delivered+
                    					             "&JoFinishing[salesman_sample]="+finishing_salesman_sample+
                    					             "&JoFinishing[delivery_1]="+finishing_delivery_1+
                    					             "&JoFinishing[delivery_2]="+finishing_delivery_2+
                    					             "&JoFinishing[delivery_3]="+finishing_delivery_3+
                    					             "&JoFinishing[delivery_4]="+finishing_delivery_4+
                    					             "&JoFinishing[delivery_5]="+finishing_delivery_5+
                    					             "&JoFinishing[second_quality]="+finishing_second_quality+
                    					             "&JoFinishing[unfinished]="+finishing_unfinished+
                    					             "&JoFinishing[lacking]="+finishing_lacking+
                    					             "&JoFinishing[closed]="+finishing_closed;
                    					}
                    					
                    					
                    					
                    					             
                    					
                    				 
                    				 
                    				 window.location = window.location.origin+"/jo_manager_live/jo/edit?"+ params;
                    					
            					 })();'
            				),
        					
						),
						/*array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => " ",
            				'context' => 'link',
            				'size'=>'small',
        					
						),
						array(
        					'class' => 'booster.widgets.TbButton',
        					'label' => "",
            				//'context' => 'info',
            				'icon'=>'refresh',
            				'size'=>'default',
            				'id'=>'refresh-button'
        					
						),
						*/
						//<button id="refresh-button">Refresh!</button>
						
						
        			),
        			//'content'=>
        			//'Start Date: '.$startDate.'<br/>Average Output: '.$avgOutput
        			'htmlOptions' => array('class' => 'bootstrap-widget-table')
    			)
			);
		?>
		
		<table class="table" style="display:none;">
        	<thead>
			
        	</thead>
        	<tbody>

        		<tr class="even">
            		
            		<td>Start Date: <?php echo $startDate; ?></td>
            		<td>Average Output: <?php echo $avgOutput; ?></td>
        		</tr>

        	</tbody>
    	</table>
    <?php $this->endWidget(); ?>
	</div>
	
	<!--Gridview Tabs-->
	<div>
		<?php

    		$this->widget(
        		'booster.widgets.TbTabs',
        		array(
            		'type' => 'tabs', // 'tabs' or 'pills'
            		'justified' => true,
            		'tabs' => array(
            		
                				array(
                    				'label' => 'Sewing',
                    				'visible'=>!Yii::app()->user->isFinishingController,
                    				'content' =>  $this->renderPartial('application.views.jo.sewing._index', array(
                    					'model'=>$model,
										'dataProvider'=>$dataProvider,
            							'options' => $options,
            							'lines' => $lines
                    				), true),
                    				'active' => !Yii::app()->user->isFinishingController
                				),
                				
                				array(
                    				'label' => 'Finishing',
                    				'visible'=>!Yii::app()->user->isSewingController,
                    				'content' =>  //'test'
                    					$this->renderPartial('../jo/finishing/_index', array(
                    					 		'model'=>$model2,
										 		'dataProvider'=>$dataProvider2,
            									'options' => $options,
            									'lines' => $lines
                    						), true
                    					),
                    				'active' => Yii::app()->user->isFinishingController
                				),
               
            		),
        			'htmlOptions'=>array(
						//'live'=>false,
    				//'id' => uniqid()
					),
        		)
    		);
    
    	?>
    
    </div>
    
</div>

<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; ?>
<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._addNewJo',array('model'=>$model,'options'=>$options,'lines'=>$lines)); ?>

