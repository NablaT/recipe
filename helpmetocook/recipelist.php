 <?php
 
 include("../config/config.php");
 printPage($bdd);
 
 function printPage($bdd){
	 $ingredients=getBackIngredient();
	 $recipe=lookForRecipes($bdd, $ingredients)
 }
 
 function getBackIngredient(){
	include('../assets/ingredients.php');
	$lang="english"; //TOCHANGE
	$ingredients= new SimpleXMLElement($xmlstr);
	$input=explode(" ",$_POST['textarea']);
	print_r($ingredients->ingredients);
	echo($ingredients->id->count());
	$ingredientlist=array();
	for($i=0;$i<count($input); $i++){
		foreach($ingredients as $curIngredient){
			//$curIngredient=$ingredients->ingredients;
			//print_r($curIngredient['name']);
			if(strcmp($curIngredient, $input[$i])==0){
				array_push($ingredientlist, $curIngredient); 
			}
			echo($curIngredient['name']);
			echo(" bler");
		}	
	}
	return $ingredientlist; 
	//print_r($ingredientlist);
	//echo($ingredients->ingredients->{'Ban1'}->french);
 }
 ?>