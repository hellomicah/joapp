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
	array('label'=>'Add New Line', 'url'=>array('create')),
	array('label'=>'Update Line', 'url'=>array('update', 'id'=>$model->line_id)),
	//array('label'=>'Delete Line', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->line_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Line', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'line_id',
		'name',
		'working_days',
		'start_date',
		'standard_average_output',
		/*'date_added',
		'datetime_created',
		'line_updated',
		'admin_id',*/
	),
)); ?>
