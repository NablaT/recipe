 <?php
 include ('../config/isconnected.php');
 include("../config/config.php");
 printPage($bdd);
 
 function printPage($bdd){
	include('../text/menufindme_text.php');
	 ?>
	<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<title> <?php echo($title);?></title>
		<link rel="stylesheet" type="text/css" href="../css/admin/add.css">

	</head>
	<body>
	<?php
	$recipe=lookForRecipes($bdd, $_GET['code']);
	if(count($recipe)==0){
		$recipe=LookForRecipesWrongCode($bdd,$_GET['code']);
	?>
		<h2> <?php echo($errorRecipes);?><br/>
		</h2>
		<a href="index.php"> <?php echo($previousPage);?> </a>
		<a href="../menu.php"> <?php echo($menu);?></a>
	<?php	 
	}
	else{
		$ingredientList=array();
		$stringMissingIngredient=array();
		for($i=0;$i<count($recipe);$i++){
			array_push($ingredientList,getIngredients($bdd, $recipe[$i]));
			array_push($stringMissingIngredient,buildStringIngredients($ingredientList,$i));
		}
		?>
		<table id="table">
		<thead>
			<tr>
				<th class="choiceA"><?php echo($name);?>  </th>
				<th class="choiceC on"><?php echo($ingredients);?> </th>
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
			<a href="../menu.php"> <?php echo($menu);?></a>
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
 
 function getIngredients($bdd, $recipe){
	$ingredients=array();
	$req=$bdd->prepare('SELECT * FROM recipe WHERE Idrecipe=?');
	$req->execute(array($recipe));
	while($donnes=$req->fetch()){
		array_push($ingredients, $donnes['Idingredient']);
	}
	return $ingredients;
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
 * Function getBackIngredient cleans the input given by user and extract all ingredients.
 **/
 function getBackIngredient($bdd){
	 
	$ingredientlist=array();
	$input=explode("-",$_POST['textarea']);
	for($i=0;$i<count($input); $i++){
		$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Idingredient=?');
		$req->execute(array($input[$i]));
		$donnes=$req->fetch();
		if($donnes[0]>0){
			array_push($ingredientlist,$input[$i]);
		}
	}
	return $ingredientlist; 
 }
 /**
 * Function BuildStringIngredients returns the string with ingredients which will be 
 * displayed to users. 
 **/
 function buildStringIngredients($missingIngredients,$pos){
	 $result="";
	 for($i=0; $i<count($missingIngredients);$i++){
		 $result=$result."<br/>".$missingIngredients[$pos][$i];
	 }
	 return $result;
 }
 
/**
* Each code as the same structure "category-category2-category3...Etc". 
* Function buildcode returns the same code in parameter without the last category. 
**/
function buildCode($codeRecipe){
	
}

/**
* Function lookForRecipesWrongCode returns the recipe list according to previous 
* users choices.
**/
function lookForRecipesWrongCode($bdd, $codeRecipe){
	$recipes=array();
	$saveCodes=array();
	//First we select all categories which contains our code
	$req=$bdd->query('SELECT * FROM category');
	while($donnes =$req->fetch()){
		if(strpos($donnes['Name'],$codeRecipe)==0){
			array_push($saveCodes,$donnes['Name']);
		}
	}
	$req->closeCursor();
	//Then we save all recipes which have previous codes. 
	for($i=0;$i<count($saveCodes);$i++){
		$req=$bdd->prepare('SELECT * FROM recipe WHERE Code=?');
		$req->execute(array($saveCodes[$i]));
		while($donnes=$req->fetch()){
			array_push($recipes, $donnes['Name']);
		}
		$req->closeCursor();
	}
	return $recipes;
}
 
/**
* Function lookForRecipes returns the recipe list according to ingredients 
* given by users and the number of missing ingredients.
**/
function lookForRecipes($bdd, $codeRecipe){
	$recipes=array();
	$count=array();
	$input=$_GET['code'];
	$req=$bdd->prepare('SELECT * FROM recipe WHERE Category=?');
	$req->execute(array($input));
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
	//$recipes=getRecipes($recipes, $count, $nbMissing,$bdd);
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