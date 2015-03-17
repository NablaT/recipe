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


//$recipe= Recipe::model()->findall();
/*try
{
	$bdd = new PDO('mysql:host=localhost;dbname=recipe', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
$req=$bdd->execute('SELECT * FROM recipe WHERE Idrecipe=\'Smo1\'');*/
//$recipe= Recipe::model()->findAll("Idrecipe=\'Smo1\'");

$recipe= Recipe::model()->findAll(array('condition'=>"Idrecipe=\'Smo1\'"));

print_r($recipe);
echo ($recipe[0]->ingredient->Name);


?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
