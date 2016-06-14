<?php
/* @var $this SewingController */
/* @var $data JoSewing */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jo_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jo_id), array('view', 'id'=>$data->jo_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('priority')); ?>:</b>
	<?php echo CHtml::encode($data->priority); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jo')); ?>:</b>
	<?php echo CHtml::encode($data->jo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brand')); ?>:</b>
	<?php echo CHtml::encode($data->brand); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php echo CHtml::encode($data->color); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('data_received')); ?>:</b>
	<?php echo CHtml::encode($data->data_received); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days_needed')); ?>:</b>
	<?php echo CHtml::encode($data->days_needed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days_allotted')); ?>:</b>
	<?php echo CHtml::encode($data->days_allotted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowance')); ?>:</b>
	<?php echo CHtml::encode($data->allowance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('target_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->target_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_date')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('line')); ?>:</b>
	<?php echo CHtml::encode($data->line); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('output')); ?>:</b>
	<?php echo CHtml::encode($data->output); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('balance')); ?>:</b>
	<?php echo CHtml::encode($data->balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo CHtml::encode($data->comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('washing_info')); ?>:</b>
	<?php echo CHtml::encode($data->washing_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_receipt')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_receipt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_added')); ?>:</b>
	<?php echo CHtml::encode($data->date_added); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime_created')); ?>:</b>
	<?php echo CHtml::encode($data->datetime_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jo_updated')); ?>:</b>
	<?php echo CHtml::encode($data->jo_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->admin_id); ?>
	<br />

	*/ ?>

</div>