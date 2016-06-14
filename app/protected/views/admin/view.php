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
	$model->user_id,
);*/

$this->menu=array(
	//array('label'=>'List Admin', 'url'=>array('index')),
	array('label'=>'Add New User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->username; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'user_id',
		'username',
		'first_name',
		'last_name',
		'user_role',
		'user_status',
		'date_registered',
	),
)); ?>
