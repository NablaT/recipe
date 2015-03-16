<?php
/* @var $this RecipeController */
/* @var $model Recipe */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recipe-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Name'); ?>
		<?php echo $form->textArea($model,'Name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Idingredient'); ?>
		<?php echo $form->textArea($model,'Idingredient',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Idingredient'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Quantity'); ?>
		<?php echo $form->textField($model,'Quantity'); ?>
		<?php echo $form->error($model,'Quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Action'); ?>
		<?php echo $form->textArea($model,'Action',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Step'); ?>
		<?php echo $form->textField($model,'Step'); ?>
		<?php echo $form->error($model,'Step'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Idrecipe'); ?>
		<?php echo $form->textArea($model,'Idrecipe',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Idrecipe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->