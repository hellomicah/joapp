<?php
/* @var $this SewingController */
/* @var $model JoSewing */

$this->breadcrumbs=array(
	'Jo Sewings'=>array('index'),
	$model->jo_id=>array('view','id'=>$model->jo_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JoSewing', 'url'=>array('index')),
	array('label'=>'Create JoSewing', 'url'=>array('create')),
	array('label'=>'View JoSewing', 'url'=>array('view', 'id'=>$model->jo_id)),
	array('label'=>'Manage JoSewing', 'url'=>array('admin')),
);
?>

<h1>Update JoSewing <?php echo $model->jo_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>