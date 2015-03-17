<?php
/* @var $this SiteController */
//include('config.php');

/*
$req = $bdd->prepare('INSERT INTO recipe(Name,Idingredient, Quantity, Action, Step) VALUES(:name,:ingredient, :quantity, :action, :step)');
$req->execute(array(
	'name' => "Smoothie",
	'Idingredient'=>"Str1",
	'quantity'=>"1",
	'action'=>"Put it in a bowl",
	'step'=>"1"
));
$req->closeCursor();
*/
//$this->pageTitle=Yii::app()->name;


$recipe= Recipe::model()->findall();
print_r($recipe);
echo ($recipe->ingredient->name);


?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
