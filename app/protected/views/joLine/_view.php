<?php
/* @var $this JoLineController */
/* @var $data JoLine */
?>

<div class="view">

<!--	<b><?php echo CHtml::encode($data->getAttributeLabel('line_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->line_id), array('view', 'id'=>$data->line_id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('working_days')); ?>:</b>
	<?php echo CHtml::encode($data->working_days); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('standard_average_output')); ?>:</b>
	<?php echo CHtml::encode($data->standard_average_output); ?>
	<br />
<!--
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo CHtml::encode($data->date_added); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime_created')); ?>:</b>
	<?php echo CHtml::encode($data->datetime_created); ?>
	<br />

	<?php
	<b><?php echo CHtml::encode($data->getAttributeLabel('line_updated')); ?>:</b>
	<?php echo CHtml::encode($data->line_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->admin_id); ?>
	<br />
-->
	 ?>

</div>