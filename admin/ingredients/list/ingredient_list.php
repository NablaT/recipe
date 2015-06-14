  

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../config/config.php');
	include('../../../text/ingredients/manageingredient_text.php');
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
	$res=getIdIngredients($bdd);
	$idrecipe=$res[0];
	$names=$res[1];
	displayList($names);

	?>
	<a href="../../managerecipe.php"><?php echo($previouspage)?></a>
	<?php
}
	function displayList($names){
		include('../../../text/ingredients/manageingredient_text.php');
		?>
		<h3> <?php echo($titlelist);?><br/></h3>
		<table id="pricetable">
		<thead>
			<tr>
				<th class="choiceA"><?php echo($name);?>  </th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0;$i<count($names);$i++){
		?>
		<tr>
			<td class="ingredient"><?php echo($names[$i])?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table><p>
		<?php
	}

	/*
		This function returns ids and name for each recipe. 
		@return array. 
	*/
	function getIdIngredients($bdd){
		$id=array();
		$name=array();
		$res=array();
		$req=$bdd->query('SELECT * FROM ingredient');
		while($reponse=$req->fetch()){
			if(!in_array($reponse['Idingredient'],$id)){
				array_push($id,$reponse['Idingredient']);
				array_push($name,$reponse['Name']);
			}
		}
		array_push($res,$id);
		array_push($res,$name);
		$req->closeCursor();
		return $res;
	}
	
	/*
		This function returns the list of ingredients for the recipe with 
		the quantity and the measure for each ingredients.
		@return array 
	*/
	function getInfoIngredients($bdd,$idrecipe){
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