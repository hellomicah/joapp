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
	$model->calendar_id=>array('view','id'=>$model->calendar_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Calendar', 'url'=>array('index')),
	array('label'=>'Create Calendar', 'url'=>array('create')),
	array('label'=>'View Calendar', 'url'=>array('view', 'id'=>$model->calendar_id)),
	array('label'=>'Manage Calendar', 'url'=>array('admin')),
);
?>

<h1>Update Calendar <?php echo $model->calendar_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>