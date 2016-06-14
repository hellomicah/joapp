<?php
$this->breadcrumbs=array(
	'Jo Sewings'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List JoSewing','url'=>array('index')),
array('label'=>'Manage JoSewing','url'=>array('admin')),
);
?>

<h1>Create JoSewing</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>