 <?php
/* @var $this RecipeController */
/* @var $data Recipe */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Name')); ?>:</b>
	<?php echo CHtml::encode($data->Name); ?>
	<br />
<?php /** OLD VERSION echo CHtml::encode($data->getAttributeLabel('Idingredient')); */?>	
	<b>Ingredient:</b>
	<?php echo CHtml::link(CHtml::encode($data->ingredient->Name), array('ingredient/view', 'id'=>$data->Name)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Quantity')); ?>:</b>
	<?php echo CHtml::encode($data->Quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Action')); ?>:</b>
	<?php echo CHtml::encode($data->Action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Step')); ?>:</b>
	<?php echo CHtml::encode($data->Step); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Idrecipe')); ?>:</b>
	<?php echo CHtml::encode($data->Idrecipe); ?>
	<br />


</div>