<?php
$baseUrl = Yii::app()->baseUrl; 
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/form_validation.js');
?>
<?php

$this->menu=array(
	array('label'=>'List All Dropdowns', 'url'=>array('index')),
);
?>

<h1><?php echo $model->name; ?></h1>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'form-dropdown-form',
	'type' => 'horizontal',
	//'id'=>'verticalForm',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'well')
)); ?>

<div id="dropdown_div">
	<?php 
	echo $form->hiddenField($model,'name',array('id'=>'dropdown_name')); 
	if(empty($model->values)):?>
		<div class="errorMessage">Values cannot be empty.</div>
	<?php else: ?>
		<?php 
			$values = json_decode($model->values);
			$ctr = 0;
		foreach($values as $value):
			$ctr = $ctr + 1;
		?>
	<div id="per_dropdown" class="form-actions">
 		<input type="button" class="close" id="remove-value-<?php echo $ctr;?>" onclick="removeValue(this)" value="&times;"/>
 		<input type="text" class="form-control" id="dropdown_value" name="FormDropdown[value][]" value="<?php echo $value;?>"/> 
 		<input type="hidden" class="input" id="dropdown_value_original_<?php echo $ctr;?>" value="<?php echo $value;?>"/>		
 		<div id="dropdown_value_error_<?php echo $ctr;?>" class="errorMessage"></div>
 	</div>
 	
	<?php
	 	endforeach; 
	 endif;	
	?>
</div>
<br>
	<div class="form-actions">
		<input type="button" class="btn btn-default" id="add-new-value" value="Add new value"/>
		<?php $this->widget(
			'booster.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'context' => 'primary',
				'label' => 'Save',
				'id'=>'submit-form-1'
			)
		); ?>
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
