<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; 
//Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;

?>

<input type="hidden" value ='' id="chosen_line" />
<input type="hidden" value ='' id="active_lines" />

<input type="hidden" value ='' id="changed_id" />
<input type="hidden" value ='' id="changed_index" />


<input type="hidden" value ='' id="row_priority" />
<input type="hidden" value ='' id="row_priority_ids" />

<script>

	$(document).ready(function(){
	/*$("ul.pagination li a").click(function(){
		//alert("yo");
		console.log(document.getElementById("gridview-val").rows);
		console.log("paginated");
	});

	$("table#gridview-val").change(function(){
		alert("yo");
		//document.getElementById("myTable").rows.item(0).innerHTML
	});
	*/
	//Load function that fills out temp holder for table row order
		window.onload = fillHolder();

		function fillHolder() {
			var rows = [];
			var ids	 =[];
    		var active_tab = getActiveTab();
		
			$("#gridview-val"+active_tab.input_id+" tr[id*=_]").each(function(i, val) {

				rows.push(this.firstChild.firstChild.innerHTML);
				ids.push(this.id);
			});

			//console.log(rows);
			document.getElementById("row_priority").value = JSON.stringify(rows);
			document.getElementById("row_priority_ids").value = JSON.stringify(ids);
		}
	});
</script>

<?php

$gridWidget = $this->widget('booster.widgets.TbExtendedGridView', array(

    'ajaxUpdate'=>false, 

    'afterAjaxUpdate'=>'js:function(tr,rowid,data){

    	console.log("afterAjaxUpdate");
    	
    	var active_tab = getActiveTab();
	

    	var rows = [];
    	
    	$("#gridview-val"+active_tab.input_id+" tr[id*=_]").each(function(i,val) {
    	
    		rows.push(this.firstChild.firstChild.innerHTML);
    	});

    	
    	document.getElementById("row_priority").value=JSON.stringify(rows);
    	
    	
    	var status_val_index = $("tbody").find("tr");
     	$(status_val_index).each(function(i, val) {
     		ted_value = $(this).find("td[id*=target_end_date]").html();
     		dd_value = $(this).find("td[id*=delivery_date]").html();
     	
     		var _MS_PER_DAY = 1000 * 60 * 60 * 24;
			var start = new Date(ted_value);
			var end = new Date(dd_value);
			var y = start.getFullYear();
  // Discard the time and time-zone information.
  			var utc1 = Date.UTC(start.getFullYear(), start.getMonth(), start.getDate());
  			var utc2 = Date.UTC(end.getFullYear(), end.getMonth(), end.getDate());

  //return utc2+utc1;
  			var date_diff =  Math.floor((utc2 - utc1) / _MS_PER_DAY);
     		
     		if(ted_value != null){
     			if(date_diff > 0 && date_diff < 7){
     				$(this).find("td[id*=target_end_date]").attr("style", "color: red !important");
     			}
     		}
     	});
     	
    }',

    'type' => 'striped',
    'headerOffset' => 40,
    
    'dataProvider' => $model->search(),
    
    'template' => "{pager}{items}{pager}",
    
    //GRIDVIEW Columns:
    'columns' => array(
		//Priority Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'priority',
            'header' => 'P',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'priority','class'=>'JoSewing_priority'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                
                //'mode' => 'inline',
                'type' => 'text',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	/*'params' => array('target_end_date'=>"js: function(data){
                			console.log(data);
                		  var row_id = $(this).closest('tr').attr('id');
  						  //var row_id = $(row).attr('id');
  						  
  							var target_end_date = $('#'+row_id).children('td#target_end_date').html();
  							console.log(target_end_date);
  							console.log(row_id);
                		return target_end_date;
                
                	}"),
                	*/
                ),
                
                                        
                'success' => 'js: function(response, newValue) {
                				//console.log(response.data_params);
  								response=JSON.parse(response);
  								if (!response.success) {
    								console.log("nope"); 
    								
    								return response.msg;
    							}else{
    								console.log("success"); 
    								var row_id = $(this).closest("tr").attr("id");

									var n = row_id.indexOf("_");

									var date_id = row_id.substr(0, n);
								
    								var current_line=	response.data_params["line"];
        							//var line_jos	=	getSameLineJos(current_line);
    				console.log("current -- "+current_line);
    								//SKIPPING Days Allotted to be updated to prevent being overriden
    									
											data_updated = {};
											data_updated["name"] = {};
											data_updated["jo_id"] = {};
											data_updated["name"] = "priority";
											data_updated["jo_id"] = date_id;
    							
    				console.log(data_updated);
    				
    								//Update Target End Dates of the same Line to reflect new dates based on new QTY value
        							updateJoTargetEndDates(current_line,data_updated /*TO-SKIP-EDIT-OF-DA*/);
    							
    							}
    							//console.log(response.msg);
    						
    						
				}',
				
				'onShown' => 'js: function(event) {
					var row_id = $(this).closest("tr").attr("id");
					var row_priority_val = document.getElementById(row_id).firstChild.firstChild.innerHTML;
					
  					var tip = $(this).data("editableContainer").tip();
  					tip.find("input").val(row_priority_val);
  					
  					//console.log($(this).closest("tr").attr("id"));
  				}',
  				
                'validate' => 'js: function(value) {
                
                			value = $.trim(parseInt(value));
                
  							if (value == "") {
  							    return "This field is required";
  							} else if (value == "0" || value == 0) {
  							    return "Input must be greater than 0.";
  							} else if (value > 0) {
  							
  								
								var row = $(this).closest("tr");
								var row_id = $(row).attr("id");
								var n = row_id.indexOf("_");

								var data_id = row_id.substr(0, n);
        						var current_line = row_id.substr((n + 1), (row_id.length));
  								
  								var min_max_p_num = getMinMaxPriorityNumber(current_line);
  										
  								console.log("MAX P_NUM: "+min_max_p_num["max_priority"]);
  										
  								if(value <= min_max_p_num["max_priority"])	{
  										
									updatePriorityRow(this,value);
								}else{
									return "Input must be less than or equal to max priority number which is "+max_p_num;	
								}
  							} else {
							
								return "Input must be greater than 0.";			
							
							} //END of else
							
							
  				}'
            )
        ),
        //JO Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jo',
            'header' => 'JO',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'jo','class'=>'JoSewing_jo'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'mode' => 'inline',
                'type' => 'text',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") 
    							return "This field is required";
					}'
            )
        ),
        //Brand Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'brand',
            'header' => 'Br',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'brand','class'=>'JoSewing_brand'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                //'mode' => 'inline',
                'type' => 'select2',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'source' => $options['Brand'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
				
            )
        ),
        //Quantity Field
        array(
            'name' => 'quantity',
            'header' => 'Qty',
            //'sortable' => true,
            
            'htmlOptions' => array('id'=>'quantity','class'=>'JoSewing_quantity'),
          
        ),
        //Category Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'category',
            'header' => 'Cat',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'category','class'=>'JoSewing_category'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                //'mode' => 'inline',
                'type' => 'select2',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'source' => $options['Category'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
				
            )
        ),
        //Color Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'color',
            'header' => 'Clr',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'color','class'=>'JoSewing_color'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'mode' => 'inline',
                'type' => 'text',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							
    							var rx = new RegExp(/^[a-zA-Z]+$/);
    							//console.log(rx.test(value));
    							if(rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						
					}'
            )
        ),
        //Date Received Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'date_received',
            'header'=>'DR',
            //'sortable' => true,
            /*
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'type'=>'date',
                
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                
            ),*/
            'htmlOptions' => array('id'=>'date_received','class'=>'JoSewing_date_received'),
        ),
        //Days_needed Field
        array(
            'name' => 'days_needed',
            'header'=>'DN',
            'htmlOptions' => array('id'=>'days_needed','class'=>'JoSewing_days_needed'),
        ),
        //Days_allotted Field
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'days_allotted',
            'header'=>'DA',
            //'sortable' => true,
            'htmlOptions' => array('style'=>'font-size:11px;','id'=>'days_allotted','class'=>'JoSewing_days_allotted'),
        ),
        //Allowance
        array(
            'name' => 'allowance',
            'value' => '$data->allowance',
            'header' => 'A',
            'htmlOptions' => array('id'=>'allowance','class'=>'JoSewing_allowance'),
        ),
        //Target End Date Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'target_end_date',
            'header'=>'TED',
            //'sortable' => true,
           'htmlOptions' => array('id'=>'target_end_date','class'=>'JoSewing_target_end_date'),
        ),
        //Delivery Date Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_date',
            'header'=>'DD',
            'htmlOptions' => array('id'=>'delivery_date','class'=>'JoSewing_delivery_date'),
           
        ),
        //Line Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'line',
            'header' => 'L',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'line','class'=>'JoSewing_line'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'brand',
                //'mode' => 'inline',
                'emptytext' => 'For Loading',
                'type' => 'select2',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'source' => $lines,
                'onShown' => 'js: function(event) {
					
					var tip = $(this).data("editableContainer").tip();
  					
  					//Retrieves the actual row data value and auto-fill the input/select field on popover editable
  					tip.find("span.select2-chosen").html($(this).select2("data").text());
  					tip.find("input.select2-offscreen").val($(this).select2("data").attr("id"))

  					
  				}',
  				
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}'
            )
        ),
        //Status Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'status',
            'header' => 'Stat',
            //'sortable' => true,
            //'id' => 'status',
            
            'htmlOptions' => array('id'=>'status','class'=>'JoSewing_status'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'left',
                'emptytext' => 'None',
                //'mode' => 'inline',
                'type' => 'select2',
                'options' => array(
                
            		'disabled' => Yii::app()->user->isGlobalViewer,
                	
                ),
                'source' => $options['Status'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}'
            )
        ),
        //Output Field
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'output',
            'header' => 'O',
            //'sortable' => true,
           'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'output',
					'class'=>'JoSewing_output'
    		),
        ),
       //Balance Field
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'balance',
            'header' => 'Bal',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'balance',
					'class'=>'JoSewing_balance'
    			),
        ),
        //Comments Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'comments',
            'header' => 'Cmt',
            //'sortable' => true,
         	'value'=>'$data->comments==null ? "none" : $data->comments',
           'htmlOptions' => array('id'=>'comments','class'=>'JoSewing_comments'),
        ),
        //Washing_info Field
         array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'washing_info',
            'header'=>'WI',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'washing_info','class'=>'JoSewing_washing_info'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'left',
                //'mode' => 'inline',
                'type' => 'select2',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'source' => $options['Washing_Info'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
				'htmlOptions' => array(
        			'options' => array( 
        				'placeholder' => 'for loading',
        			)
    			),
            )
        ),
         //Delivery Receipt
         array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_receipt',
            'header'=>'DR',
            //'sortable' => true,
             'htmlOptions' => array('id'=>'audit_date','class'=>'JoSewing_audit_date'),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'left',
                //'mode' => 'inline',
                'type' => 'select2',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'source' => $options['Delivery_Receipt'],
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}'
            )
        ),

    ),
    
    'htmlOptions' => array(        
    	'id' => 'gridview-val',
    	'style'=>'font-size: 10px !important;'
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results', array(
    'class' => 'btn btn-info pull-right'
));

?>




<!-- EDIT Comments Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._updateComments',array('model'=>$model)); ?>


<!-- EDIT Date Received Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._updateDateReceived',array('model'=>$model)); ?>


<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._updateDeliveryDate',array('model'=>$model)); ?>




<!-- EDIT Delivery Date Popup  -->
<?php //$this->renderPartial('application.views.jo.sewing.modal._addNewJo',array('model'=>$model,'options'=>$options,'lines'=>$lines)); ?>




<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCoreScript('jquery');
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jo_module/manual_edit.js');
$cs->registerScriptFile($baseUrl.'/js/jo_module/main.js');
$cs->registerScriptFile($baseUrl.'/js/jo_module/after_sortable.js');
//Yii::app()->booster->registerAssetCss('booster-datepicker.css');
//Yii::app()->booster->registerAssetJs('booster.datepicker.js');
?>



