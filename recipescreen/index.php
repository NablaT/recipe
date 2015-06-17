  <?php
 include ('../config/isconnected.php');
 include("../config/config.php");
 printPage($bdd);
 
 function printPage($bdd){
	include('../text/mainrecipe_text.php');
	 ?>
	<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<title> <?php echo($title);?></title>
		<link rel="stylesheet" type="text/css" href="../css/mainrecipe/table.css">

	</head>
	<body>
	<?php
	//print_r($_GET);
	if(recipeNotFound($bdd)){
		?>
		<h2> <?php echo($errorRecipesNotFound);?><br/>
		</h2>
		<a href="../menu.php"> <?php echo($menu);?></a>
		<?php
	}
	if(laststep($bdd,$_GET['step'],$_GET['recipe'])){
		?>
		<h2><title><?php echo($recipeFinished);?><br/>
		</h2>
		<a href="../menu.php"> <?php echo($menu);?></a>
		<?php
		/*
		?>
		<html>
				<head>
				<title><?php echo($recipeFinished);?><br/><?php echo($redirection);?></title>
					<meta http-equiv="refresh" content="5; URL=../menu.php">
				</head>
				<body>
				</body>
			</html> 
		<?php*/
	}
	else{
		//echo("Ici");
		$currentStep=$_GET['step']+1;
		$ingredients=getBackIngredient($bdd,$currentStep,$_GET['recipe']);
		$instructions=getStep($bdd,$currentStep,$_GET['recipe']);
		$lastStep=$_GET['step']-1;
		/*print_r($ingredients);
		echo($instructions);*/
		
		//$recipe=lookForRecipes($bdd, $ingredients,$_POST['radio']);
		
		//$stringIngredients=buildStringIngredients($missingIngredient,$i);
		
		?>
		<table id="table">
		<thead>
			<tr>
				<th class="choiceA"><?php echo($titleingredients);?>  </th>
				<th class="choiceC on"><?php echo($instruction);?> </th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td class="ingredient"><?php 
			for($i=0;$i<count($ingredients);$i++){
				?>
				<h2> -<?php echo($ingredients[$i]);?> </h2>
				<?php
			}
			?></td>
			<td class="quantity"><?php echo($instructions);?></td>
		</tr>
		
			</tbody>
			
			</table>
			<div class="container">
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			<h4>                                                       <h4>
			<a class="btn left" href="index.php?recipe=<?php echo($_GET['recipe'])?>&step=<?php echo($lastStep);?>">
			<span class="left icon icon-heart"><span class="arrow-left"></span></span>
			<span class="right title"><?php echo($previousPage);?></span>
			</a>
			
			<a class="btn right" href="index.php?recipe=<?php echo($_GET['recipe'])?>&step=<?php echo($currentStep);?>">
			<span class="left title"><?php echo($next);?></span>
			<span class="right icon icon-heart"><span class="arrow-right"></span></span>
			</a>
			
			
			
			</div>
			
		<?php
		
	}
 }
 
/**
* This function returns true if the previous step was the last step of the recipe.
**/
function laststep($bdd,$previousStep,$recipe){
	$req=$bdd->prepare('SELECT COUNT(*) FROM recipestep WHERE Name=?');
	$req->execute(array($recipe));
	$donnes=$req->fetch();
	//print_r($donnes);
	if($donnes[0]==$previousStep) return true;
	return false;
}

/**
*	This function returns true if we can't find the recipe, else false.
**/
function recipeNotFound($bdd){
	if((count($_GET)==0)) return true;
	if(recipeExists($bdd, $_GET['recipe'])==false) return true;
	return false; 
}

/**
*	This function returns true if the recipe exists. Else false.
**/
function recipeExists($bdd,$recipe){
	$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Name=?');
	$req->execute(array($recipe));
	$donnes=$req->fetch();
	if($donnes[0]==0) return false;
	return true;
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
 **//*
 function getNameRecipe($bdd,$Idrecipe){
	$req=$bdd->prepare('SELECT * FROM recipe WHERE Idrecipe=?');
	$req->execute(array($Idrecipe));
	$donnes=$req->fetch(); 
	return $donnes['Name'];
 }
 */
 /**
 * Function buidlStringMissingIngredients returns the string which will be 
 * displayed to users. 
 **/
 function buildStringMissingIngredients($ingredients){
	 $result="";
	 for($i=0; $i<count($missingIngredients[$pos]);$i++){
		 $result=$result."<br/>".$missingIngredients[$pos][$i];
	 }
	 return $result;
 }
 /**
 * Function getMissingIngredients returns the ingredients which miss in the recipe.
 **//*
 function getMissingIngredients($bdd, $recipe, $ingredients){
	$missingIngredient=array();
	$req=$bdd->prepare('SELECT * FROM recipe WHERE Idrecipe=?');
	$req->execute(array($recipe));
	while($donnes=$req->fetch()){		
		if(!in_array($donnes['Idingredient'],$ingredients)){
			
			array_push($missingIngredient, $donnes['Idingredient']);
		}
	}
	return $missingIngredient;
 }
 /**
 * Function getStep returns the current step according to the step number and the name of the recipe
 **/ 
 function getStep($bdd, $step,$recipe){
	$req=$bdd->prepare('SELECT * FROM recipestep WHERE Number=? AND Name=?');
	$req->execute(array($step,$recipe));
	$donnes=$req->fetch();
	return $donnes['Step'];
 }
 /**
 * Function getBackIngredient cleans the current step and extract all ingredients.
 **/
 function getBackIngredient($bdd, $step,$recipe){
	$ingredientlist=array();
	$req=$bdd->prepare('SELECT * FROM recipestep WHERE Number=? AND Name=?');
	$req->execute(array($step,$recipe));
	$donnes=$req->fetch();
	$input=explode(" ",$donnes['Step']);
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
* Function lookForRecipes returns the recipe list according to ingredients 
* given by users and the number of missing ingredients.
**//*
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
	 $recipes=getRecipes($recipes, $count, $nbMissing,$bdd);
	 return $recipes;
}
	/**
	* Function getRecipes returns the cleaning recipe list.
	**//*
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
	}*/
 ?>