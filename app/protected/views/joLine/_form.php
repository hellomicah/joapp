<?php
/* @var $this JoLineController */
/* @var $model JoLine */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'jo-line-form',
	'type' => 'horizontal',
	//'id'=>'verticalForm',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'well')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldGroup($model,'name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->dropDownListGroup(
			$model,
			'working_days',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' =>$model->workingDays(),
					'htmlOptions' => array(),
				)
			)
		); ?> 
		<?php echo $form->datePickerGroup(
			$model,
			'start_date',
			array(
				'widgetOptions' => array(
					'options' => array(
						'language' => 'en',
						'mode'=>'focus',
									  'format'=>'yyyy-mm-dd',
									  'showAnim' => 'slideDown',
									  'changeMonth'=>true,
									  'changeYear'=>true,
									  //'yearRange'=>'1920:2013',
									  'readonly'=>'readonly'
					),
				),
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				//'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			)
		); ?>

		<?php echo $form->textFieldGroup($model,'standard_average_output',array('onkeypress'=>'return numbersOnly(this, event);')); ?>
		<?php $this->widget(
    		'booster.widgets.TbButton',
    		array('buttonType' => 'submit', 'label' => $model->isNewRecord ? 'Add New Line' : 'Update')
		);?>

<?php $this->endWidget(); ?>

</div><!-- form -->