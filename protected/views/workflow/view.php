<?php
/* @var $this WorkflowController */
/* @var $model Workflow */

$this->breadcrumbs=array(
	'Workflows'=>array('index'),
	$model->w_id,
);

$this->menu=array(
	array('label'=>'List Workflow', 'url'=>array('index')),
	array('label'=>'Create Workflow', 'url'=>array('create')),
	array('label'=>'Update Workflow', 'url'=>array('update', 'id'=>$model->w_id)),
	array('label'=>'Delete Workflow', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->w_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Workflow', 'url'=>array('admin')),
);
?>

<h1>View Workflow #<?php echo $model->w_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'w_id',
		'w_name',
		'w_type',
		'w_desc',
		'w_data',
		'w_date',
	),
)); ?>
