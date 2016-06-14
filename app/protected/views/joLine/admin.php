<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this JoLineController */
/* @var $model JoLine */


$this->menu=array(
	//array('label'=>'List JoLine', 'url'=>array('index')),
	array('label'=>'Add New Line', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#jo-line-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lines</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div id="statusMsg"></div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'jo-line-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'line_id',
		'name',
		'working_days',
		'start_date',
		'standard_average_output',
		//'date_added',
		/*
		'datetime_created',
		'line_updated',
		'admin_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'afterDelete'=>'function(link,success,data){ if(success) $("#statusMsg").html(data); else $("#statusMsg").html(data); }',
		),
	),
)); ?>
