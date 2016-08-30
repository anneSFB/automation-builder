<?php
/* @var $this WorkflowController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Workflows',
);

$this->menu=array(
	array('label'=>'Create Workflow', 'url'=>array('create')),
	array('label'=>'Manage Workflow', 'url'=>array('admin')),
);
?>

<h1>Workflows</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
