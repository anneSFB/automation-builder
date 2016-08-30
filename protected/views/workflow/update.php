<?php
/* @var $this WorkflowController */
/* @var $model Workflow */

$this->breadcrumbs=array(
	'Workflows'=>array('index'),
	$model->w_id=>array('view','id'=>$model->w_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Workflow', 'url'=>array('index')),
	array('label'=>'Create Workflow', 'url'=>array('create')),
	array('label'=>'View Workflow', 'url'=>array('view', 'id'=>$model->w_id)),
	array('label'=>'Manage Workflow', 'url'=>array('admin')),
);
?>

<h1>Update Workflow <?php echo $model->w_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>