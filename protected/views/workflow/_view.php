<?php
/* @var $this WorkflowController */
/* @var $data Workflow */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('w_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->w_id), array('view', 'id'=>$data->w_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w_name')); ?>:</b>
	<?php echo CHtml::encode($data->w_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w_type')); ?>:</b>
	<?php echo CHtml::encode($data->w_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w_desc')); ?>:</b>
	<?php echo CHtml::encode($data->w_desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w_data')); ?>:</b>
	<?php echo CHtml::encode($data->w_data); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('w_date')); ?>:</b>
	<?php echo CHtml::encode($data->w_date); ?>
	<br />


</div>