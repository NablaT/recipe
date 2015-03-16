<?php
/* @var $this RecipeController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Name'); ?>
		<?php echo $form->textArea($model,'Name',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Idingredient'); ?>
		<?php echo $form->textArea($model,'Idingredient',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Quantity'); ?>
		<?php echo $form->textField($model,'Quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Action'); ?>
		<?php echo $form->textArea($model,'Action',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Step'); ?>
		<?php echo $form->textField($model,'Step'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Idrecipe'); ?>
		<?php echo $form->textArea($model,'Idrecipe',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->