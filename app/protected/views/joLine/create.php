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
	array('label'=>'Manage Line', 'url'=>array('admin')),
);
?>

<h1>Add New Line</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>