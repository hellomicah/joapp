<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this FormDropdownController */
/* @var $dataProvider CActiveDataProvider */

/*$this->breadcrumbs=array(
	'Form Dropdowns',
);

$this->menu=array(
	array('label'=>'Create FormDropdown', 'url'=>array('create')),
	array('label'=>'Manage FormDropdown', 'url'=>array('admin')),
);*/
?>

<h1>Form Dropdowns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
