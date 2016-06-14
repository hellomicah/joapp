<?php
/* @var $this SewingController */
/* @var $model JoSewing */

$this->breadcrumbs=array(
	'Jo Sewings'=>array('index'),
	$model->jo_id,
);

$this->menu=array(
	array('label'=>'List JoSewing', 'url'=>array('index')),
	array('label'=>'Create JoSewing', 'url'=>array('create')),
	array('label'=>'Update JoSewing', 'url'=>array('update', 'id'=>$model->jo_id)),
	array('label'=>'Delete JoSewing', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->jo_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JoSewing', 'url'=>array('admin')),
);
?>

<h1>View JoSewing #<?php echo $model->jo_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'jo_id',
		'priority',
		'jo',
		'brand',
		'quantity',
		'category',
		'color',
		'data_received',
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
		'delivery_receipt',
		'date_added',
		'datetime_created',
		'jo_updated',
		'admin_id',
	),
)); ?>
