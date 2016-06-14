<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php
/* @var $this JoLineController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Jo Lines',
);

$this->menu=array(
	array('label'=>'Create JoLine', 'url'=>array('create')),
	array('label'=>'Manage JoLine', 'url'=>array('admin')),
);
?>

<h1>Jo Lines</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
