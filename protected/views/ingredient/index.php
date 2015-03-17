<?php
/* @var $this IngredientController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ingredients',
);

$this->menu=array(
	array('label'=>'Create Ingredient', 'url'=>array('create')),
	array('label'=>'Manage Ingredient', 'url'=>array('admin')),
);
?>

<h1>Ingredients</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
