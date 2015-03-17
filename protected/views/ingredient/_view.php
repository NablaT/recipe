<?php
/* @var $this IngredientController */
/* @var $data Ingredient */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Idingredient')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Idingredient), array('view', 'id'=>$data->Idingredient)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Description')); ?>:</b>
	<?php echo CHtml::encode($data->Description); ?>
	<br />


</div>