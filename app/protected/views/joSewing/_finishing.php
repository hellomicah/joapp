<?php
//Yii::app()->booster->registerAssetCss('booster-datepicker.css');
//Yii::app()->booster->registerAssetJs('booster.datepicker.js');
?>
<script src="<?php
echo Yii::app()->request->baseUrl;
?>/js/jquery.ui.touch-punch.min.js"></script>



<input type="text" value ='' id="row_priority" />
<input type="text" value ='' id="row_priority_ids" />
<input type="text" value ='' id="chosen_line" />

<?php
	$options=JoSewing::model()->getOptions();
	$lines=JoSewing::model()->getLines();

$gridWidget = $this->widget('booster.widgets.TbExtendedGridView', array(
    
    //'fixedHeader' => true,
    
    'sortableRows' => true,
    
    //'sortableAttribute' => 'sort_order',
    //'sortableAjaxSave' => 'true',
    //'sortableAction' => 'joSewing/sortable',
    'afterAjaxUpdate'=>'js:function(tr,rowid,data){
 
     	
		
     }',
     //'afterSortableUpdate' => 'js:function(data){afterSortProcess();}',
    //'responsiveTable' => true,
    
    'type' => 'striped',
    'headerOffset' => 40,
    // 40px is the height of the main navigation at bootstrap
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{pager}{items}{pager}",
    
    //GRIDVIEW Columns:
    'columns' => array(
		//Priority Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'priority',
            'sortable' => true,
            
            'htmlOptions' => array('id'=>'priority',),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
                /*'options' => array(
                	'params' => array('target_end_date'=>"js: function(data){
                			console.log(data);
                		  var row_id = $(this).closest('tr').attr('id');
  						  //var row_id = $(row).attr('id');
  						  
  							var target_end_date = $('#'+row_id).children('td#target_end_date').html();
  							console.log(target_end_date);
  							console.log(row_id);
                		return target_end_date;
                
                	}"),
                ),
                */
                                        
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
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
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
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                'mode' => 'inline',
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
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'quantity',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'attribute'=>'quantity',
                'mode' => 'inline',
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
            )
        ),
        //Category Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'category',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'washing_info',
                'mode' => 'inline',
                'type' => 'select2',
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
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'text',
                'success' => 'js: function(response, newValue) {
                				//console.log(response.oldValue);
  								if (!response.success) {
    								return response.msg;
    								
    								}
    							console.log(response.msg);
					}',
                'validate' => 'js: function(value) {
  							
    							var rx = new RegExp(/^[a-zA-Z]+$/);
    							if(!rx.test(value)){
    								return "Invalid Input.";
    							}
    							
    						
					}'
            )
        ),
        //Date Received Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'date_received',
            'header'=>'Date Received',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'type'=>'date',
                
                
            ),
            'htmlOptions' => array('id'=>'date_received',),
        ),
        //Days_needed Field
        array(
            'name' => 'days_needed',
            'header'=>'Days Needed',
            'value' => '$data->days_needed',
            'htmlOptions' => array('id'=>'days_needed',),
        ),
        //Days_allotted Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'days_allotted',
            'header'=>'Days Allotted',
            'sortable' => true,
            'htmlOptions' => array('id'=>'days_allotted',),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'days_allotted',
                'mode' => 'inline',
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
            )
        ),
        //Allowance
        array(
            'name' => 'allowance',
            'value' => '$data->allowance',
            'htmlOptions' => array('id'=>'allowance'),
        ),
        //Target End Date Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'target_end_date',
            'header'=>'Target End Date',
            'sortable' => true,
            'htmlOptions' => array('id'=>'target_end_date',),
        ),
        //Delivery Date Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'delivery_date',
            'header'=>'Delivery Date',
            'htmlOptions' => array('id'=>'delivery_date',),
           
        ),
        //Line Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'line',
            'sortable' => true,
            'htmlOptions' => array('id'=>'line',),
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'brand',
                'mode' => 'inline',
                'type' => 'select2',
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
            'sortable' => true,
            'id' => 'status',
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'emptytext' => 'For Loading',
                'mode' => 'inline',
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
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'output',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
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
            )
        ),
       //Balance Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'balance',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                //'inputclass' => null,
                //'attribute'=>'balance',
                'mode' => 'inline',
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
            )
        ),
        //Comments Field
        array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'comments',
            'sortable' => true,
         	'value'=>'$data->comments==null ? "none" : $data->comments',
           'htmlOptions' => array('id'=>'comments',),
        ),
        //Washing_info Field
         array(
            'class' => 'booster.widgets.TbEditableColumn',
            'name' => 'washing_info',
            'header'=>'Washing<br/>Info',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'select2',
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
            'header'=>'Delivery<br/>Receipt',
            'sortable' => true,
            'editable' => array(
                'url' => $this->createUrl('joSewing/edit/'),
                'placement' => 'right',
                'mode' => 'inline',
                'type' => 'select2',
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
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results', array(
    'class' => 'btn btn-info pull-right'
));

?>


<!-- EDIT Line Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._lineSelect'); ?>



<!-- EDIT Comments Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._updateComments',array('model'=>$model)); ?>


<!-- EDIT Date Received Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._updateDateReceived',array('model'=>$model)); ?>


<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._updateDeliveryDate',array('model'=>$model)); ?>




<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.sewing.modal._addNewJo',array('model'=>$model,'options'=>$options,'lines'=>$lines)); ?>



<script>
/*window.onbeforeunload = confirmExit;
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
  */
  $('#viewModal').on('hidden.bs.modal', function () {
    // do something…
    //alert("hi");
    console.log("MODAL - EXIT");
});
  $('#date_delivery_modal').on('hidden.bs.modal', function () {
    // do something…
    //alert("hi");
    console.log("MODAL datepicker - EXIT");
});
</script> 


<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jo_module/main.js');
$cs->registerScriptFile($baseUrl.'/js/jo_module/after_sortable.js');
$cs->registerCssFile($baseUrl.'/css/jo_module/main.css');
?>
