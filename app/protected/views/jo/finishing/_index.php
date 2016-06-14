<?php //Yii::app()->clientscript->scriptMap['*.js'] = false; 
//Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;?>

<!--script src="<?php
echo Yii::app()->request->baseUrl;
?>/js/jquery.ui.touch-punch.min.js"></script-->



<input type="hidden" value ='' id="chosen_line" />

<input type="hidden" value ='' id="changed_id" />
<input type="hidden" value ='' id="changed_index" />


<input type="hidden" value ='' id="row_priority" />
<input type="hidden" value ='' id="row_priority_ids" />

<?php

$gridWidget = $this->widget('booster.widgets.TbExtendedGridView', array(
    
    //'fixedHeader' => true,
    
   // 'sortableRows' => true,
    
    //'sortableAttribute' => 'sort_order',
    //'sortableAjaxSave' => 'true',
    //'sortableAction' => 'joFinishing/sortable',
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
		'audit_date',
		
        'total_delivered',
        'salesman_sample',
        'delivery_1',
        'delivery_2',
        'delivery_3',
        'delivery_4',
        'delivery_5',
        'second_quality',
        'unfinished',
        'lacking',
        'closed',*/
        array(
            'name'=>'priority',
            'header'=>'P',
            'htmlOptions' => array('id'=>'priority','class'=>'JoFinishing_priority')
        ),
        array(
            'name'=>'jo',
            'header'=>'JO',
            'htmlOptions' => array('id'=>'jo','class'=>'JoFinishing_jo')
        ),
        array(
            'name'=>'brand',
            'header'=>'Br',
            'htmlOptions' => array('id'=>'brand','class'=>'JoFinishing_brand')
        ),
        array(
            'name'=>'quantity',
            'header'=>'Q',
            'htmlOptions' => array('id'=>'quantity','class'=>'JoFinishing_quantity')
        ),
        array(
            'name'=>'category',
            'header'=>'Cat',
            'htmlOptions' => array('id'=>'category','class'=>'JoFinishing_category')
        ),
        array(
            'name'=>'color',
            'header'=>'Clr',
            'htmlOptions' => array('id'=>'color','class'=>'JoFinishing_color')
        ),
       array(
            'name'=>'date_received',
            'header'=>'DRcv',
            'htmlOptions' => array('id'=>'date_received','class'=>'JoFinishing_date_received')
        ),
        array(
            'name'=>'days_needed',
            'header'=>'DN',
            'htmlOptions' => array('id'=>'days_needed','class'=>'JoFinishing_days_needed'),
        ),
        array(
            'name'=>'days_allotted',
            'header'=>'DA',
            'htmlOptions' => array('style'=>'font-size:11px;','id'=>'days_allotted','class'=>'JoFinishing_days_allotted')
        ),
        array(
            'name'=>'allowance',
            'header'=>'A',
            'htmlOptions' => array('id'=>'allowance','class'=>'JoFinishing_allowance')
        ),
        array(
            'name'=>'target_end_date',
            'header'=>'TED',
            'htmlOptions' => array('id'=>'target_end_date','class'=>'JoFinishing_target_end_date')
        ),
         array(
            'name'=>'delivery_date',
            'header'=>'DD',
            'htmlOptions' => array('id'=>'delivery_date','class'=>'JoFinishing_delivery_date')
        ),
        array(
            'name'=>'line',
            'header'=>'L',
            'value' => 'JoLine::model()->LineName($data->line)',
            'htmlOptions' => array('id'=>'line','class'=>'JoFinishing_line')
        ),
        array(
            'name'=>'status',
            'header'=>'Stat',
            'htmlOptions' => array('id'=>'status','class'=>'JoFinishing_status')
        ),
        array(
            'name'=>'output',
            'header'=>'O',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'output',
					'class'=>'JoFinishing_output'
    		)
        ),
        array(
            'name'=>'balance',
            'header'=>'Bal',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'balance',
					'class'=>'JoFinishing_balance'
    			)
        ),
        array(
            'name'=>'comments',
            'header'=>'Cmt',
           'htmlOptions' => array('id'=>'comments','class'=>'JoFinishing_comments')
        ),
		array(
            'name'=>'washing_info',
            'header'=>'WI',
            'htmlOptions' => array('id'=>'washing_info','class'=>'JoFinishing_washing_info'),
        ),
       array(
            'name'=>'audit_date',
            'header'=>'AD',
            'htmlOptions' => array('id'=>'audit_date','class'=>'JoFinishing_audit_date')
        ),
        array(
            'name'=>'total_delivered',
            'header'=>'TD',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'total_delivered',
					'class'=>'JoFinishing_total_delivered'
    			)
        ),
        array(
            'name'=>'salesman_sample',
            'header'=>'SS',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'salesman_sample',
					'class'=>'JoFinishing_salesman_sample'
    			)
        ),
        array(
            'name'=>'delivery_1',
            'header'=>'D1',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_1',
					'class'=>'JoFinishing_delivery_1'
    			)
        ),
        array(
            'name'=>'delivery_2',
            'header'=>'D2',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_2',
					'class'=>'JoFinishing_delivery_2'
    			)
        ),
        array(
            'name'=>'delivery_3',
            'header'=>'D3',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_3',
					'class'=>'JoFinishing_delivery_3'
    			)
        ),
        array(
            'name'=>'delivery_4',
            'header'=>'D4',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_4',
					'class'=>'JoFinishing_delivery_4'
    			)
        ),
        array(
            'name'=>'delivery_5',
            'header'=>'D5',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'delivery_5',
					'class'=>'JoFinishing_delivery_5'
    			)
        ),
        array(
            'name'=>'second_quality',
            'header'=>'SQ',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'second_quality',
					'class'=>'JoFinishing_second_quality'
    			)
        ),
        array(
            'name'=>'unfinished',
            'header'=>'UF',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'unfinished',
					'class'=>'JoFinishing_unfinished'
    			)
        ),
        array(
            'name'=>'lacking',
            'header'=>'LK',
            'htmlOptions' => array(
					'style'=>'font-size:11px;',
					'id'=>'lacking',
					'class'=>'JoFinishing_lacking'
    			)
        ),
        array(
            'name'=>'closed',
            'header'=>'Cl',
            'htmlOptions' => array(
					'id'=>'closed',
					'class'=>'JoFinishing_closed'
    			)
        ),
    ),
    
    'htmlOptions' => array(        
    	'id' => 'index-gridview-val-finishing',
    	'style'=>'font-size: 9px !important;'
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results', array(
    'class' => 'btn btn-info pull-right'
));

?>
