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
	'Create',
);

$this->menu=array(
	array('label'=>'List FormDropdown', 'url'=>array('index')),
	array('label'=>'Manage FormDropdown', 'url'=>array('admin')),
);
?>

<h1>Create FormDropdown</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>