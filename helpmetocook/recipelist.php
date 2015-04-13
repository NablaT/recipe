 <?php
 
 include("../config/config.php");
 printPage($bdd);
 
 function printPage($bdd){
	 getBackIngredient($bdd);
	 
 }
 
 function getBackIngredient($bdd){
	include('../assets/ingredients.php');
	$lang="english"; //TOCHANGE
	$ingredients= new SimpleXMLElement($xmlstr);
	$ingredientlist=explode(" ",$_POST['textarea']);
	print_r($ingredients);
	echo(count($ingredients->ingredients));
	for($i=0;$i<count($ingredientlist); $i++){
		foreach($ingredients->ingredient as $ingredients->ingredient->{'Ban1'}){
			$curIngredient=$ingredients->ingredients;
			print_r($curIngredient);
			echo($curIngredient);
			echo(" bler");
		}	
	}
	//print_r($ingredientlist);
	//echo($ingredients->ingredients->{'Ban1'}->french);
 }
 ?>