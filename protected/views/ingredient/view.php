<?php
/* @var $this IngredientController */
/* @var $model Ingredient */

$this->breadcrumbs=array(
	'Ingredients'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List Ingredient', 'url'=>array('index')),
	array('label'=>'Create Ingredient', 'url'=>array('create')),
	array('label'=>'Update Ingredient', 'url'=>array('update', 'id'=>$model->Idingredient)),
	array('label'=>'Delete Ingredient', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Idingredient),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ingredient', 'url'=>array('admin')),
);
?>

<h1>View Ingredient #<?php echo $model->Idingredient; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Name',
		'Description',
		'Idingredient',
	),
)); ?>
