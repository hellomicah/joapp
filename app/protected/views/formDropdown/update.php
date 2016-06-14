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
	$model->name=>array('view','id'=>$model->dropdown_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FormDropdown', 'url'=>array('index')),
	array('label'=>'Create FormDropdown', 'url'=>array('create')),
	array('label'=>'View FormDropdown', 'url'=>array('view', 'id'=>$model->dropdown_id)),
	array('label'=>'Manage FormDropdown', 'url'=>array('admin')),
);
?>

<h1>Update FormDropdown <?php echo $model->dropdown_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>