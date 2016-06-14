<?php
/* @var $this SewingController */
/* @var $model JoSewing */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'jo-sewing-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'priority'); ?>
		<?php echo $form->textField($model,'priority'); ?>
		<?php echo $form->error($model,'priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jo'); ?>
		<?php echo $form->textField($model,'jo',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'jo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brand'); ?>
		<?php echo $form->textField($model,'brand',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'brand'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity'); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'color'); ?>
		<?php echo $form->textField($model,'color',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data_received'); ?>
		<?php echo $form->textField($model,'data_received'); ?>
		<?php echo $form->error($model,'data_received'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'days_needed'); ?>
		<?php echo $form->textField($model,'days_needed',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'days_needed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'days_allotted'); ?>
		<?php echo $form->textField($model,'days_allotted',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'days_allotted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allowance'); ?>
		<?php echo $form->textField($model,'allowance',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'allowance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'target_end_date'); ?>
		<?php echo $form->textField($model,'target_end_date'); ?>
		<?php echo $form->error($model,'target_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_date'); ?>
		<?php echo $form->textField($model,'delivery_date'); ?>
		<?php echo $form->error($model,'delivery_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'line'); ?>
		<?php echo $form->textField($model,'line'); ?>
		<?php echo $form->error($model,'line'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'output'); ?>
		<?php echo $form->textField($model,'output'); ?>
		<?php echo $form->error($model,'output'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'balance'); ?>
		<?php echo $form->textField($model,'balance'); ?>
		<?php echo $form->error($model,'balance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'washing_info'); ?>
		<?php echo $form->textField($model,'washing_info',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'washing_info'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_receipt'); ?>
		<?php echo $form->textField($model,'delivery_receipt',array('size'=>7,'maxlength'=>7)); ?>
		<?php echo $form->error($model,'delivery_receipt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_added'); ?>
		<?php echo $form->textField($model,'date_added'); ?>
		<?php echo $form->error($model,'date_added'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datetime_created'); ?>
		<?php echo $form->textField($model,'datetime_created'); ?>
		<?php echo $form->error($model,'datetime_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jo_updated'); ?>
		<?php echo $form->textField($model,'jo_updated'); ?>
		<?php echo $form->error($model,'jo_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_id'); ?>
		<?php echo $form->textField($model,'admin_id'); ?>
		<?php echo $form->error($model,'admin_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->