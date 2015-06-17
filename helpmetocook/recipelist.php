 <?php
 include ('../config/isconnected.php');
 include("../config/config.php");
 printPage($bdd);
 
 function printPage($bdd){
	include('../text/menuhelpme_text.php');
	 ?>
	<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<title> <?php echo($title);?></title>
		<link rel="stylesheet" type="text/css" href="../css/admin/add.css">

	</head>
	<body>
	<?php
	$ingredients=getBackIngredient($bdd);
	$recipe=lookForRecipes($bdd, $ingredients,$_POST['radio']);
	if(count($recipe)==0){
	?>
		<h2> <?php echo($errorRecipes);?><br/>
		</h2>
		<a href="index.php"> <?php echo($previousPage);?> </a>
		<a href="../menu.php"> <?php echo($home);?></a>
	<?php	 
	}
	else{
		$missingIngredient=array();
		$stringMissingIngredient=array();
		for($i=0;$i<count($recipe);$i++){
			array_push($missingIngredient,getMissingIngredients($bdd, $recipe[$i],$ingredients));
			array_push($stringMissingIngredient,buildStringMissingIngredients($missingIngredient,$i));
		}
		?>
		<table id="table">
		<thead>
			<tr>
				<th class="choiceA"><?php echo($name);?>  </th>
				<th class="choiceC on"><?php echo($missingIngredients);?> </th>
				<th class="choiceD"><?php echo($nbSteps)?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0;$i<count($recipe);$i++){
			$nameRecipe=getNameRecipe($bdd,$recipe[$i]);
			$getNbSteps=getNumberSteps($bdd, $recipe[$i]);
		?>
		
		<tr>
			<td class="ingredient"><?php echo($nameRecipe);?></td>
			<td class="quantity"><?php echo($stringMissingIngredient[$i]);?></td>
			<td class="measure"><?php echo($getNbSteps);?></td>
		</tr>
		
		<?php
		}
		?>
			</tbody>
			</table>
			<a href="#"><?php echo($validate);?></a>
			<script src="../js/selection.js"></script>
			<a href="index.php"><?php echo($previousPage);?></a>
		<?php
	}
 }
/**
 * Function getNumberSteps returns the number of step for the recipe specified in parameter.
 **/
 function getNumberSteps($bdd,$Idrecipe){
	$req=$bdd->prepare('SELECT COUNT(*) FROM recipestep WHERE Idrecipe=?');
	$req->execute(array($Idrecipe));
	$donnes=$req->fetch(); 
	return $donnes[0];
 }
 
 /**
 * Function getNameRecipe returns the name of a recipe thanks to recipe id in parameter.
 **/
 function getNameRecipe($bdd,$Idrecipe){
	$req=$bdd->prepare('SELECT * FROM recipe WHERE Idrecipe=?');
	$req->execute(array($Idrecipe));
	$donnes=$req->fetch(); 
	return $donnes['Name'];
 }
 
 /**
 * Function buidlStringMissingIngredients returns the string which will be 
 * displayed to users. 
 **/
 function buildStringMissingIngredients($missingIngredients,$pos){
	 $result="";
	 for($i=0; $i<count($missingIngredients[$pos]);$i++){
		 $result=$result."<br/>".$missingIngredients[$pos][$i];
	 }
	 return $result;
 }
 /**
 * Function getMissingIngredients returns the ingredients which miss in the recipe.
 **/
 function getMissingIngredients($bdd, $recipe, $ingredients){
	$missingIngredient=array();
	$req=$bdd->prepare('SELECT * FROM recipe WHERE Idrecipe=?');
	$req->execute(array($recipe));
	while($donnes=$req->fetch()){		
		if(!in_array($donnes['Idingredient'],$ingredients)){
			
			array_push($missingIngredient, $donnes['Idingredient']);
		}
	}
	if(count($missingIngredient)==0){
		array_push($missingIngredient, "None");
	}
	return $missingIngredient;
 }
 
 /**
 * Function getBackIngredient cleans the input given by user and extract all ingredients.
 **/
 function getBackIngredient($bdd){
	 
	$ingredientlist=array();
	$input=explode(" ",$_POST['user']);
	for($i=0;$i<count($input); $i++){
		$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Idingredient=?');
		$req->execute(array($input[$i]));
		$donnes=$req->fetch();
		if($donnes[0]>0){
			array_push($ingredientlist,$input[$i]);
		}
	}
	/*include('../assets/ingredients.php');
	$lang="english"; //TOCHANGE
	$ingredients= new SimpleXMLElement($xmlstr);
	$input=explode(" ",$_POST['textarea']);
	//print_r($ingredients->ingredients);
	//echo($ingredients->id->count());
	$ingredientlist=array();
	for($i=0;$i<count($input); $i++){
		foreach($ingredients as $curIngredient){
			//$curIngredient=$ingredients->ingredients;
			//print_r($curIngredient['name']);
			if(strcmp($curIngredient, $input[$i])==0){
				array_push($ingredientlist, $curIngredient); 
			}
			//echo($curIngredient['name']);
			//echo(" bler");
		}	
	}*/
	
	return $ingredientlist; 
 }
 
/**
* Function lookForRecipes returns the recipe list according to ingredients 
* given by users and the number of missing ingredients.
**/
function lookForRecipes($bdd, $ingredients,$nbMissing){
	 $recipes=array();
	 $count=array();
	 for($i=0;$i<count($ingredients);$i++){
		$req=$bdd->prepare('SELECT * FROM recipe WHERE Idingredient=?');
		$req->execute(array($ingredients[$i]));
		while($donnes =$req->fetch()){
			if(in_array($donnes['Idrecipe'],$recipes)){
				$position=array_search($donnes['Idrecipe'],$recipes);
				$count[$position]=$count[$position]+1;
			}
			else{
				array_push($recipes,$donnes['Idrecipe']);
				array_push($count,1);
			}
		}
	 }
	 $recipes=getRecipes($recipes, $count, $nbMissing,$bdd);
	 return $recipes;
}
	/**
	* Function getRecipes returns the cleaning recipe list.
	**/
	function getRecipes($recipes,$count, $nbMissing,$bdd){
		$finalRecipes=array();
		for($i=0;$i<count($recipes);$i++){
			$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Idrecipe=?');
			$req->execute(array($recipes[$i]));
			$donnes=$req->fetch();
			if(($donnes[0]-$count[$i])==$nbMissing){
				array_push($finalRecipes,$recipes[$i]);
			}
		}
		return $finalRecipes;
	}
 ?>