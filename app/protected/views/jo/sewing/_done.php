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
            'name'=>'delivery_receipt',
            'header'=>'DR'
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
        'delivery_receipt',*/

    	array(
        'header' => '',
        'visible'=>	Yii::app()->user->isProductionHead,
        'value' => function($data)
        {
            $this->widget('booster.widgets.TbButton', array(
			//'buttonType'=>'ajaxSubmit',
				'context'=>'primary',
				'label'=>'',
				//'url' => Yii::app()->createUrl( 'joSewing/addNew'),
				'icon'=>'refresh',
            	'size'=>'extra_small',
            	'htmlOptions'=>array(
            		'id' => 'confirm-revert'
				)
                
            ));
            
        }
    ),
            
    		
    ),
    
    'htmlOptions' => array(        
    	'id' => 'gridview-done-sewing',
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
<?php $this->renderPartial('application.views.jo.sewing.modal._revert',array('model'=>$model),false,false); ?>





<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jo_module/done_jo.js');
//$cs->registerScriptFile($baseUrl.'/js/jo_module/after_sortable.js');
//$cs->registerCssFile($baseUrl.'/css/jo_module/main.css');
?>
