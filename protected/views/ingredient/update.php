<?php
/* @var $this IngredientController */
/* @var $model Ingredient */

$this->breadcrumbs=array(
	'Ingredients'=>array('index'),
	$model->Name=>array('view','id'=>$model->Idingredient),
	'Update',
);

$this->menu=array(
	array('label'=>'List Ingredient', 'url'=>array('index')),
	array('label'=>'Create Ingredient', 'url'=>array('create')),
	array('label'=>'View Ingredient', 'url'=>array('view', 'id'=>$model->Idingredient)),
	array('label'=>'Manage Ingredient', 'url'=>array('admin')),
);
?>

<h1>Update Ingredient <?php echo $model->Idingredient; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>