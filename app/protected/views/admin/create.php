<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this AdminController */
/* @var $model Admin */

/*$this->breadcrumbs=array(
	'Admins'=>array('index'),
	'Create',
);*/

$this->menu=array(
	//array('label'=>'List Admin', 'url'=>array('index')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,
	'single_div_display' => $single_div_display,
	'div_display' => $div_display,
	'line_list_data' => $line_list_data,
	'selected_line_data'=>$selected_line_data
)); ?>