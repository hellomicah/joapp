<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this FormDropdownController */
/* @var $model FormDropdown */

$this->breadcrumbs=array(
	'Form Dropdowns'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FormDropdown', 'url'=>array('index')),
	array('label'=>'Create FormDropdown', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#form-dropdown-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Form Dropdowns</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'form-dropdown-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'dropdown_id',
		'name',
		'values',
		'date_added',
		'datetime_created',
		'form_updated',
		/*
		'admin_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
