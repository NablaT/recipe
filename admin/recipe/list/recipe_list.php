  

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../config/config.php');
	include('../../../text/recipe/managerecipe_text.php');7
	?>
	<!DOCTYPE>
	<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<title> <?php echo($titlelist);?></title>
		<link rel="stylesheet" type="text/css" href="../../../css/admin/add.css">
	</head>
	<?php
	//Array with the id and name list for each recipe
	$res=getIdRecipe($bdd);
	$idrecipe=$res[0];
	$names=$res[1];
	// print_r($idrecipe);
	// echo("Count :".count($idrecipe));
	for($i=0;$i<count($idrecipe);$i++){
		//echo("Je rentre ".$i);
		$savesteps=getSteps($bdd,$idrecipe[$i]);
		//print_r($savesteps);
		$infos=getInfoRecipe($bdd,$idrecipe[$i]);
		$saveingredients=$infos[0];
		$savequantity=$infos[1];
		$savemeasure=$infos[2];
		?>
		<h3> <?php echo($name);?>: <?php echo($names[$i]) ?><br/></h3>
		<table id="pricetable">
		<thead>
			<tr>
				<th class="choiceA"><?php echo($ingredient);?>  </th>
				<th class="choiceC on"><?php echo($quantity);?> </th>
				<th class="choiceD"><?php echo($type)?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0;$i<count($saveingredients);$i++){
		?>
		<tr>
			<td class="ingredient"><?php echo($saveingredients[$i])?></td>
			<td class="quantity"><?php echo($savequantity[$i])?></td>
			<td class="measure"><?php echo($savemeasure[$i])?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table><p>
		<table id="pricetable2">
		<thead>
			<tr>
				<th class="choiceA"><?php echo($steps);?>  </th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0;$i<count($savesteps);$i++){
		?>
			<tr>
				<td class="steps"><?php echo($savesteps[$i])?></td>
			</tr>
		<?php		
		}
		?>
		</tbody>
		</table><p>
		<?php
	
	}
	?>
	<a href="confirm_delete.php?confirm=yes&name=<?php echo($_POST['nom']) ?>"><?php echo($deleterecipe)?></a>
	<a href="delete_recipe.php"><?php echo($previouspage)?></a>
	<?php
}
	
	/*
		This function returns ids and name for each recipe. 
		@return array. 
	*/
	function getIdRecipe($bdd){
		$id=array();
		$name=array();
		$res=array();
		$req=$bdd->query('SELECT * FROM recipe');
		while($reponse=$req->fetch()){
			if(!in_array($reponse['Idrecipe'],$id)){
				array_push($id,$reponse['Idrecipe']);
				array_push($name,$reponse['Name']);
			}
		}
		array_push($res,$id);
		array_push($res,$name);
		$req->closeCursor();
		return $res;
	}
	
	/*
		This function returns the list of steps for the recipe
		@return array 
	*/
	function getSteps($bdd,$idrecipe){
		$steps=array();
		$req=$bdd->prepare('SELECT * FROM recipestep WHERE Idrecipe=?');
		$req->execute(array($idrecipe));
		while($reponse=$req->fetch()){
			array_push($steps,$reponse['Step']);
		}
		return $steps;
	}
	
	/*
		This function returns the list of ingredients for the recipe with 
		the quantity and the measure for each ingredients.
		@return array 
	*/
	function getInfoRecipe($bdd,$idrecipe){
		$res=array();
		$ingredients=array();
		$quantity=array();
		$measure=array();
		$req=$bdd->prepare('SELECT * FROM recipe WHERE Idrecipe=?');
		$req->execute(array($idrecipe));
		while($reponse=$req->fetch()){
			array_push($ingredients,$reponse['Idingredient']);
			array_push($quantity,$reponse['Quantity']);
			array_push($measure,$reponse['Measure']);
		}
		array_push($res,$ingredients);
		array_push($res,$quantity);
		array_push($res,$measure);
		return $res;
	}

?>
</body>
</html>