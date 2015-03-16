<?php
/* @var $this RecipeController */
/* @var $model Recipe */

$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->Name=>array('view','id'=>$model->Idingredient),
	'Update',
);

$this->menu=array(
	array('label'=>'List Recipe', 'url'=>array('index')),
	array('label'=>'Create Recipe', 'url'=>array('create')),
	array('label'=>'View Recipe', 'url'=>array('view', 'id'=>$model->Idingredient)),
	array('label'=>'Manage Recipe', 'url'=>array('admin')),
);
?>

<h1>Update Recipe <?php echo $model->Idingredient; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>