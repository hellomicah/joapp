

<?php

	$gridWidget = $this->widget('booster.widgets.TbExtendedGridView', array(

    'type' => 'striped',
    'headerOffset' => 40,
    // 40px is the height of the main navigation at bootstrap
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{pager}{items}{pager}",
    
    //GRIDVIEW Columns:
    'columns' => array(
    array(
            'name'=>'jo',
            'header'=>'JO'
        ),
        array(
            'name'=>'brand',
            'header'=>'Br'
        ),
        array(
            'name'=>'quantity',
            'header'=>'Qty',
            'htmlOptions' => array('id'=>'quantity',),
        ),
        array(
            'name'=>'category',
            'header'=>'Cat'
        ),
        array(
            'name'=>'color',
            'header'=>'Clr'
        ),
        array(
            'name'=>'date_received',
            'header'=>'DRcv'
        ),
        array(
            'name'=>'days_needed',
            'header'=>'DN'
        ),
        array(
            'name'=>'days_allotted',
            'header'=>'DA'
        ),
        array(
            'name'=>'allowance',
            'header'=>'A'
        ),
        array(
            'name'=>'target_end_date',
            'header'=>'TED'
        ),
        array(
            'name'=>'delivery_date',
            'header'=>'DD'
        ),
        array(
            'name'=>'line',
            'header'=>'L'
        ),
        array(
            'name'=>'output',
            'header'=>'O',
            'htmlOptions' => array('id'=>'output',),
        ),
        array(
            'name'=>'balance',
            'header'=>'Bal'
        ),
        array(
            'name'=>'comments',
            'header'=>'Cmt',
            'value'=>'$data->comments==null ? "none" : $data->comments',
        ),
		array(
            'name'=>'washing_info',
            'header'=>'WI'
        ),
        array(
            'name'=>'audit_date',
            'header'=>'AD'
        ),
        array(
            'name'=>'total_delivered',
            'header'=>'TD'
        ),
        array(
            'name'=>'salesman_sample',
            'header'=>'SS'
        ),
        array(
            'name'=>'delivery_1',
            'header'=>'D1'
        ),
        array(
            'name'=>'delivery_2',
            'header'=>'D2'
        ),
        array(
            'name'=>'delivery_3',
            'header'=>'D3'
        ),
        array(
            'name'=>'delivery_4',
            'header'=>'D4'
        ),
        array(
            'name'=>'delivery_5',
            'header'=>'D5'
        ),
        array(
            'name'=>'second_quality',
            'header'=>'SQ'
        ),
        array(
            'name'=>'unfinished',
            'header'=>'UF'
        ),
        array(
            'name'=>'lacking',
            'header'=>'LK'
        ),
        array(
            'name'=>'closed',
            'header'=>'Cl'
        ),
		//'priority',
       /* 'jo',
        'brand',
        //Quantity Field
        array(
            'name' => 'quantity',
            'htmlOptions' => array('id'=>'quantity',),
        ),
        'category',
        'color',
        'date_received',
        'days_needed',
        'days_allotted',
        'allowance',
        'target_end_date',
        'delivery_date',
        'line',
        //'status',
        //Output Field
        array(
            'name' => 'output',
            'htmlOptions' => array('id'=>'output',),
        ),
        'balance',
        
        //Comments Field
        array(
            'name' => 'comments',
         	'value'=>'$data->comments==null ? "none" : $data->comments',
        ),
        'washing_info',
		'audit_date',*/
		/*
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
        'closed',
        */

    	array(
        'header' => '',
        'visible'=>	Yii::app()->user->isProductionHead,
        'value' => function($data)
        {
            $this->widget('booster.widgets.TbButton', array(
				'context'=>'primary',
				'label'=>'',
				'icon'=>'refresh',
            	'size'=>'extra_small',
            	'htmlOptions'=>array(
            		'id' => 'confirm-revert2'
				)
                
            ));
            
        }
    ),
            
    		
    ),
    
    'htmlOptions' => array(        
    	'id' => 'gridview-done-finishing',
    	'style'=>'font-size: 10px !important;'
    ),
    'rowHtmlOptionsExpression' => 'array("id"=>$data->jo_id."_".$data->line)'
));

//EXPORT Button
$this->renderExportGridButton($gridWidget, 'Export Grid Results', array(
    'class' => 'btn btn-info pull-right'
));

?>

<!-- EDIT Delivery Date Popup  -->
<?php $this->renderPartial('application.views.jo.finishing.modal._revert',array('model'=>$model),false,false); ?>




<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jo_module/done_jo.js');
//$cs->registerScriptFile($baseUrl.'/js/jo_module/after_sortable.js');
//$cs->registerCssFile($baseUrl.'/css/jo_module/main.css');
?>
