<?php
/* @var $this RecipeController */
/* @var $model Recipe */

$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'List Recipe', 'url'=>array('index')),
	array('label'=>'Create Recipe', 'url'=>array('create')),
	array('label'=>'Update Recipe', 'url'=>array('update', 'id'=>$model->Idingredients)),
	array('label'=>'Delete Recipe', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Idingredient),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Recipe', 'url'=>array('admin')),
);
?>

<h1>View Recipe #<?php echo $model->ingredient->Name; ?></h1>

<?php 
//After View Recipe : old version: $model->Idingredient

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Name',
		'ingredient.Name',
		'Quantity',
		'Action',
		'Step',
	),
));

/* Previous version 

//$model->ingredient->name
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Name',
		'Idingredient',
		'Quantity',
		'Action',
		'Step',
		'Idrecipe',
	),
));

*/
 ?>
