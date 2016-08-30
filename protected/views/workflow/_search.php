<?php
/* @var $this WorkflowController */
/* @var $model Workflow */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'w_id'); ?>
		<?php echo $form->textField($model,'w_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'w_name'); ?>
		<?php echo $form->textField($model,'w_name',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'w_type'); ?>
		<?php echo $form->textField($model,'w_type',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'w_desc'); ?>
		<?php echo $form->textArea($model,'w_desc',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'w_data'); ?>
		<?php echo $form->textArea($model,'w_data',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'w_date'); ?>
		<?php echo $form->textField($model,'w_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->