<?php
/* @var $this FormDropdownController */
/* @var $data FormDropdown */
?>

<div class="well">

	<b><?php //echo CHtml::encode($data->getAttributeLabel('name')); ?></b>
	<?php echo CHtml::link(CHtml::encode($data->name), array('add', 'id'=>$data->dropdown_id)); ?>
	<br />

	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('values')); ?>:</b>
	<?php echo CHtml::encode($data->values); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo CHtml::encode($data->date_added); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime_created')); ?>:</b>
	<?php echo CHtml::encode($data->datetime_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('form_updated')); ?>:</b>
	<?php echo CHtml::encode($data->form_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->admin_id); ?>
	<br />-->


</div>