 

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../config/config.php');
	include('../../../text/recipe/managerecipe_text.php');

	if(!recipeexists($bdd)){
		?>
		<!DOCTYPE>
			<html lang="en">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
				<title> <?php echo($deleterecipe);?></title>
				<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

			</head>
		<h2> <?php echo($errorrecipe1);?> <?php echo($_POST['nom']);?> <?php echo($errorrecipe2);?> <br/>
		<?php echo($fillitagain);?></h2>
		<a href="delete_recipe.php"> <?php echo($previouspage);?> </a>
		<a href="../../manageRecipe.php"> <?php echo($menu);?></a>
		<?php
	}
	else {
		
		$savesteps=getSteps($bdd);
		$infos=getInfoRecipe($bdd);
		$saveingredients=$infos[0];
		$savequantity=$infos[1];
		$savemeasure=$infos[2];
	
		?> 
		<!DOCTYPE>
		<html lang="en">
		<head>
			<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
			<title> <?php echo($deleterecipe);?></title>
			<link rel="stylesheet" type="text/css" href="../../../css/admin/add.css">
		</head>
		<h3> <?php echo($name);?>: <?php echo($_POST['nom']) ?><br/></h3>
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
		}
	?>
	</tbody>
	</table><p>
	<a href="confirm_delete.php?confirm=yes&name=<?php echo($_POST['nom']) ?>"><?php echo($deleterecipe)?></a>
	<a href="delete_recipe.php"><?php echo($previouspage)?></a>
	<?php
	}
	
	/*
		This function look for the name of the recipe in database
		and return true if the recipe already exists
		@return boolean. 
	*/
	function recipeexists($bdd){
		$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Name=?');
		$req->execute(array($_POST['nom']));
		$reponse=$req->fetch();
		return ($reponse[0]!=0);
	}
	
	/*
		This function returns the list of steps for the recipe
		@return array 
	*/
	function getSteps($bdd){
		$steps=array();
		$req=$bdd->prepare('SELECT * FROM recipestep WHERE Name=?');
		$req->execute(array($_POST['nom']));
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
	function getInfoRecipe($bdd){
		$res=array();
		$ingredients=array();
		$quantity=array();
		$measure=array();
		$req=$bdd->prepare('SELECT * FROM recipe WHERE Name=?');
		$req->execute(array($_POST['nom']));
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