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
    
        
    //'sortableRows' => true,
    'ajaxUpdate'=>false, 
    //'sortableAttribute' => 'sort_order',
    //'sortableAjaxSave' => 'true',
    //'sortableAction' => 'joFinishing/sortable',
    'afterAjaxUpdate'=>'js:function(tr,rowid,data){
    	//alert("yeess!");
    	console.log("afterAjaxUpdate");
    	//document.getElementById("change_status").value="not_changed";
    	//bootbox.alert("I have afterAjax events too! This will only happen once for row with id: "+position);
     	
    	var rows = [];
    	
    	$("tbody > tr[id*=_]").each(function(i,val) {
    	
    		rows.push(this.firstChild.firstChild.innerHTML);
    	});
    	
    	//console.log(rows);
    	
    	document.getElementById("row_priority").value=JSON.stringify(rows);
    }',
    'afterSortableUpdate' => 'js:function(data){
    
     }',
    
    'type' => 'striped',
    'headerOffset' => 40,
    // 40px is the height of the main navigation at bootstrap
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'template' => "{pager}{items}{pager}",
    
    //GRIDVIEW Columns:
    'columns' => array(
		//Priority Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'priority',
            'header' => 'P',
            //'sortable' => true,
            
            'htmlOptions' => array('id'=>'priority','class'=>'JoFinishing_priority'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'right',
                //'mode' => 'inline',
                'type' => 'text',
                
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                                        
                'success' => 'js: function(response, newValue) {
                				console.log(response.data_params);
  								if (!response.success) {
    								return response.msg;
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
  							if ($.trim(value) == "") {
  							    return "This field is required";
  							} else if ($.trim(value) == "0" || $.trim(value) == 0) {
  							    return "Input must be greater than 0.";
  							} else {
							}
  							}'
            )
        ),
        //JO Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'jo',
            'header' => 'JO',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'jo','class'=>'JoFinishing_jo'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
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
            'htmlOptions' => array('id'=>'brand','class'=>'JoFinishing_brand'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                //'mode' => 'inline',
                 'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                'type' => 'select2',
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
            
            'htmlOptions' => array('id'=>'quantity','class'=>'JoFinishing_quantity'),
          
        ),
        //Category Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'category',
            'header' => 'Cat',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'category','class'=>'JoFinishing_category'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
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
            'htmlOptions' => array('id'=>'color','class'=>'JoFinishing_color'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
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
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'date_received',
            'header'=>'DR',
            //'sortable' => true,
            /*
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'right',
                'type'=>'date',
                'options' => array(
                
            		'disabled' => !Yii::app()->user->isProductionHead,
                	
                ),
                
                
            ),*/
            'htmlOptions' => array('id'=>'date_received','class'=>'JoFinishing_date_received'),
        ),
        //Days_needed Field
        array(
            'name' => 'days_needed',
            'header'=>'DN',
            'htmlOptions' => array('id'=>'days_needed','class'=>'JoFinishing_days_needed'),
        ),
        //Days_allotted Field
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'days_allotted',
            'header'=>'DA',
            //'sortable' => true,
            'htmlOptions' => array('style'=>'font-size:11px;','id'=>'days_allotted','class'=>'JoFinishing_days_allotted'),
            /*'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'days_allotted',
                //'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )*/
        ),
        //Allowance
        array(
            'name' => 'allowance',
            'header' => 'A',
            'value' => '$data->allowance',
            'htmlOptions' => array('id'=>'allowance','class'=>'JoFinishing_allowance'),
        ),
        //Target End Date Field
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'target_end_date',
            'header'=>'TED',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'target_end_date','class'=>'JoFinishing_target_end_date'),
        ),
        //Delivery Date Field
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_date',
            'header'=>'DD',
            'htmlOptions' => array('id'=>'delivery_date','class'=>'JoFinishing_delivery_date'),
           
        ),
        //Line Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'line',
            'header' => 'L',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'line','class'=>'JoFinishing_line'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
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
            
            'htmlOptions' => array('id'=>'status','class'=>'JoFinishing_status'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'left',
                'emptytext' => 'None',
                 'options' => array(
                
            		'disabled' => Yii::app()->user->isGlobalViewer,
                	
                ),
                //'mode' => 'inline',
                'type' => 'select2',
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
					'class'=>'JoFinishing_output'
    		),/*
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'left',
                //'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )*/
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
					'class'=>'JoFinishing_balance'
    			),
    			/*
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'left',
                //'inputclass' => null,
                //'attribute'=>'balance',
                //'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							if ($.trim(value) == "") {
    							return "This field is required";
    						}else{
    							var rx = new RegExp(/^\d+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						}
					}'
            )*/
        ),
        //Comments Field
        array(
           // 'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'comments',
            'header' => 'Cmt',
            //'sortable' => true,
         	'value'=>'$data->comments==null ? "none" : $data->comments',
           'htmlOptions' => array('id'=>'comments','class'=>'JoFinishing_comments'),
        ),
        //Washing_info Field
         array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'washing_info',
            'header'=>'WI',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'washing_info','class'=>'JoFinishing_washing_info'),
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
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
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'audit_date',
            'header' => 'AD',
            //'sortable' => true,
            'htmlOptions' => array('id'=>'audit_date','class'=>'JoFinishing_audit_date'),
            /*'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'left',
                //'widgetOptions'=>array(
                	'options'=>array(
                		'autoclose'=>true,
               
            			'disabled' => (!Yii::app()->user->isProductionHead || Yii::app()->user->isSewingController),
                	
                 
                	)
                //)
            )*/
        ),
		
        //'total_delivered',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'total_delivered',
            'header' => 'TD',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'total_delivered',
					'class'=>'JoFinishing_total_delivered'
    			),
    	),
        //'salesman_sample',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'salesman_sample',
            'header' => 'SS',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'salesman_sample',
					'class'=>'JoFinishing_salesman_sample'
    			),
    	),
        //'delivery_1',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_1',
            'header' => 'D1',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_1',
					'class'=>'JoFinishing_delivery_1'
    			),
    	),
        //'delivery_2',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_2',
            'header' => 'D2',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_2',
					'class'=>'JoFinishing_delivery_2'
    			),
    	),
        //'delivery_3',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_3',
            'header' => 'D3',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_3',
					'class'=>'JoFinishing_delivery_3'
    			),
    	),
        //'delivery_4',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_4',
            'header' => 'D4',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_4',
					'class'=>'JoFinishing_delivery_4'
    			),
    	),
        //'delivery_5',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_5',
            'header' => 'D5',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_5',
					'class'=>'JoFinishing_delivery_5'
    			),
    	),
        //'second_quality',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'second_quality',
            'header' => 'SQ',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'second_quality',
					'class'=>'JoFinishing_second_quality'
    			),
    	),
        //'unfinished',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'unfinished',
            'header' => 'UF',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'unfinished',
					'class'=>'JoFinishing_unfinished'
    			),
    	),
       // 'lacking',
        array(
            //'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'lacking',
            'header' => 'Lk',
            //'sortable' => true,
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'lacking',
					'class'=>'JoFinishing_lacking'
    			),
    	),
        //'closed',
        
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'closed',
            'header' => 'Cl',
            'htmlOptions' => array(
					'id'=>'closed',
					'class'=>'JoFinishing_closed'
    			),
            //'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joFinishing/edit/'),
                'placement' => 'left',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                //'mode' => 'inline',
                'type' => 'select2',
                'source' => $options['Closed'],
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
				
            )
        ),
    ),
    
    'htmlOptions' => array(        
    	'id' => 'gridview-val-finishing',
    	'style'=>'font-size: 9px !important;'
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results', array(
    'class' => 'btn btn-info pull-right'
));

?>


<!-- EDIT Comments Popup  -->
<?php $this->renderPartial('application.views.jo.finishing.modal._updateComments',array('model'=>$model)); ?>


<!-- EDIT Date Received Popup  -->
<?php $this->renderPartial('application.views.jo.finishing.modal._updateDateReceived',array('model'=>$model)); ?>


<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.finishing.modal._updateDeliveryDate',array('model'=>$model)); ?>


<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.finishing.modal._updateAuditDate',array('model'=>$model)); ?>




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
