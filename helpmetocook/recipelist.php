 <?php
 
 include("../config/config.php");
 printPage($bdd);
 
 function printPage($bdd){
	 $ingredients=getBackIngredient();
	 $recipe=lookForRecipes($bdd, $ingredients);
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
 
 function lookForRecipes($bdd, $ingredients,$nbMissing){
	 $recipes=array();
	 $count=array();
	 for($i=0;$i<count($ingredients);$i++){
		$req=$bdd->prepare('SELECT * FROM recipe WHERE Idingredient=?');
		$req->execute(array($ingredients[$i]));
		while($donnes =$req->fetch()){
			if(in_array($donnes['Idrecipe'],$recipes)){
				$position=$array_search($donnes['Idrecipe'],$recipes);
				$count[$position]=$count[$position]+1;
			}
			else{
				array_push($recipes,$donnes['Idrecipe']);
				array_push($count,1);
			}
		}
	 }
	 $recipes=getRecipes($recipes, $count, $nbMissing);
	 return $recipes;
 }
 
	function getRecipes($recipes,$count, $nbMissing){
		$finalRecipes=array();
		for($i=0;$i<count($recipes);$i++){
			$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Idrecipe=?';
			$req->execute(array($recipes[$i]));
			$donnes=$req->fetch();
			if(($count[$i]-$donnes[0])==$nbMissing){
				array_push($finalRecipes,$recipes[$i]);
			}
		}
		return $finalRecipes;
	}
 ?>