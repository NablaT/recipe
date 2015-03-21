
<a href="Recipe_View.php"> blurf </a>
<?php echo CHtml::button('Title', array('onclick' => 'document.location.href="site/Recipe_View"'));
 ?>


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
//$recipe= Recipe::model()->findAll("t.Idrecipe=\'Smo1\'");

//$recipe= Recipe::model()->findAll(array('condition'=>"Idrecipe=\'Smo1\'"));
/*
$id="Smo1";
$controller=new RecipeController;
$recipe= $controller->getRecipe($id);

//print_r($recipe[0]);
echo($recipe[0]->Name);
/*
Recipe Object ( [_new:CActiveRecord:private] => [_attributes:CActiveRecord:private] => 
Array ( [Name] => Smoothie 
[Idingredient] => Ban1 
[Quantity] => 2.00 
[Action] => Put the [Step] => 1 
[Idrecipe] => Smo1 ) 
[_related:CActiveRecord:private] => Array ( ) [
_c:CActiveRecord:private] => 
[_pk:CActiveRecord:private] => Ban1 
[_alias:CActiveRecord:private] => t 
[_errors:CModel:private] => Array ( ) 
[_validators:CModel:private] =>
 [_scenario:CModel:private] => update 
 [_e:CComponent:private] => [_m:CComponent:private] => )
echo("///////////////////////////////////:");

echo();
*/
//echo ($recipe[0]->ingredient->Name);


?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
