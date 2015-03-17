<?php
/* @var $this IngredientController */
/* @var $model Ingredient */

$this->breadcrumbs=array(
	'Ingredients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ingredient', 'url'=>array('index')),
	array('label'=>'Manage Ingredient', 'url'=>array('admin')),
);
?>

<h1>Create Ingredient</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>