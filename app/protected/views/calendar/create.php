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
	'Create',
);

$this->menu=array(
	array('label'=>'List Calendar', 'url'=>array('index')),
	array('label'=>'Manage Calendar', 'url'=>array('admin')),
);
?>

<h1>Create Calendar</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>