<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jo_module/index.js');
?>

<style>
#delivery_date, #date_received, #comments, #quantity, #output, #days_allotted,
#delivery_1, #delivery_2, #delivery_3, #delivery_4, #delivery_5, #second_quality, #unfinished, #lacking,
 #salesman_sample, #audit_date
{
cursor: default;
}
</style>

<input type="hidden" value ='' id="chosen_line" />

<input type="hidden" value ='' id="changed_id" />
<input type="hidden" value ='' id="changed_index" />


<input type="hidden" value ='' id="row_priority" />
<input type="hidden" value ='' id="row_priority_ids" />
<?php

$gridWidget = $this->widget('booster.widgets.TbExtendedGridView', array(
    
    //'fixedHeader' => true,
    
    //'sortableRows' => true,
    
    //'sortableAttribute' => 'sort_order',
    //'sortableAjaxSave' => 'true',
    //'sortableAction' => 'joSewing/sortable',
    'afterAjaxUpdate'=>'js:function(tr,rowid,data){
 
     	var status_val_index = $("tbody").find("tr");
     	$(status_val_index).each(function(i, val) {
     		var status_value = $(this).find("td[id*=status]").html();
     		if(status_value  == "" || status_value  == "For Loading"){
     			$(this).find("td[id*=status]").html("For Loading");
     			var color = "red";
     		}else{
     			var color = "#24CE3E";
     		}
     	
     		$(this).find("td[id*=jo]").attr("style", "color: "+color+" !important");
     		$(this).find("td[id*=brand]").attr("style", "color: "+color+" !important");
     		
     		
     		//for date
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
     //'afterSortableUpdate' => 'js:function(data){afterSortProcess();}',
    //'responsiveTable' => true,
    
    'type' => 'striped',
    'id' => 'sewing-grid',
    'headerOffset' => 40,
    // 40px is the height of the main navigation at bootstrap
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{pager}{items}{pager}",
    
    //GRIDVIEW Columns:
    'columns' => array(
		/*'priority',
        'jo',
        'brand',
        
        'quantity',
        'category',
        'color',
        'date_received',
        'days_needed',
        'days_allotted',
        'allowance',
        'target_end_date',
        'delivery_date',
        'line',
        'status',
        
        'output',
        'balance',
        
        'comments',
        'washing_info',
		'delivery_receipt',*/
		array(
            'name'=>'priority',
            'header'=>'P',
            'htmlOptions' => array('id'=>'priority','class'=>'Sewing_priority')
        ),
        array(
            'name'=>'jo',
            'header'=>'JO',
            'htmlOptions' => array('id'=>'jo','class'=>'JoSewing_jo')
        ),
        array(
            'name'=>'brand',
            'header'=>'Br',
            'htmlOptions' => array('id'=>'brands','class'=>'JoSewing_brands')
        ),
        array(
            'name'=>'quantity',
            'header'=>'Q',
            'htmlOptions' => array('id'=>'quantity','class'=>'JoSewing_quantity')
        ),
        array(
            'name'=>'category',
            'header'=>'Cat',
            'htmlOptions' => array('id'=>'category','class'=>'JoSewing_category')
        ),
        array(
            'name'=>'color',
            'header'=>'Clr',
            'htmlOptions' => array('id'=>'color','class'=>'JoSewing_color')
        ),
        array(
            'name'=>'date_received',
            'header'=>'DRcv',
            'htmlOptions' => array('id'=>'date_received','class'=>'JoSewing_date_received')
        ),
        array(
            'name'=>'days_needed',
            'header'=>'DN',
            'htmlOptions' => array('id'=>'days_needed','class'=>'JoSewing_days_needed')
        ),
        array(
            'name'=>'days_allotted',
            'header'=>'DA',
            'htmlOptions' => array('style'=>'font-size:11px;','id'=>'days_allotted','class'=>'JoSewing_days_allotted')
        ),
        array(
            'name'=>'allowance',
            'header'=>'A',
            'htmlOptions' => array('id'=>'allowance','class'=>'JoSewing_allowance')
        ),
        array(
            'name'=>'target_end_date',
            'header'=>'TED',
           'htmlOptions' => array('id'=>'target_end_date','class'=>'JoSewing_target_end_date')
        ),
        array(
            'name'=>'delivery_date',
            'header'=>'DD',
            'htmlOptions' => array('id'=>'delivery_date','class'=>'JoSewing_delivery_date')
        ),
        array(
            'name'=>'line',
            'header'=>'L',
            'value' => 'JoLine::model()->LineName($data->line)',
            'htmlOptions' => array('id'=>'line','class'=>'JoSewing_line')
        ),
        array(
            'name'=>'status',
            'header'=>'Stat',
            'htmlOptions' => array('id'=>'status','class'=>'JoSewing_status')
        ),
        array(
            'name'=>'output',
            'header'=>'O',
           'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'output',
					'class'=>'JoSewing_output'
    		)
        ),
        array(
            'name'=>'balance',
            'header'=>'Bal',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'balance',
					'class'=>'JoSewing_balance'
    			)
        ),
        array(
            'name'=>'comments',
            'header'=>'Cmt',
           'htmlOptions' => array('id'=>'comments','class'=>'JoSewing_comments')
        ),
		array(
            'name'=>'washing_info',
            'header'=>'WI',
            'htmlOptions' => array('id'=>'washing_info','class'=>'JoSewing_washing_info')
        ),
        array(
            'name'=>'delivery_receipt',
            'header'=>'DR',
             'htmlOptions' => array('id'=>'audit_date','class'=>'JoSewing_audit_date')
        ),
    ),
    
    'htmlOptions' => array(        
    	'id' => 'index-gridview-val',
    	'style'=>'font-size: 10px !important;'
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results Finishing', array(
    'class' => 'btn btn-info pull-right'
));

if(Yii::app()->user->isGlobalViewer){
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jo_module/after_sortable.js');
}
?>

