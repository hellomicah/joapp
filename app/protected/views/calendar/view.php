<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this CalendarController */
/* @var $model Calendar */

$this->breadcrumbs=array(
	'Calendars'=>array('index'),
	$model->calendar_id,
);

$this->menu=array(
	array('label'=>'List Calendar', 'url'=>array('index')),
	array('label'=>'Create Calendar', 'url'=>array('create')),
	array('label'=>'Update Calendar', 'url'=>array('update', 'id'=>$model->calendar_id)),
	array('label'=>'Delete Calendar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->calendar_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Calendar', 'url'=>array('admin')),
);
?>

<h1>View Calendar #<?php echo $model->calendar_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'calendar_id',
		'event',
		'date',
		'date_added',
		'datetime_created',
		'date_updated',
		'admin_id',
	),
)); ?>
