

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){

	include('../../text/recipe/managerecipe_text.php');
?>
<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> <?php echo($titleadd);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/add.css">

</head>
<?php
	if($_POST['step']<=0){
		?>
		<h3> <?php echo($errornbsteps);?> <br/>
		<?php echo($fillitagain);?></h3>
		<?php echo($redirection);?>
		<meta http-equiv="refresh" content="4; URL=add_recipe.php">
		<?php
	}
	else if(recipeexists($bdd)){
		?>
		<h3> <?php echo($errorRecipeExist);?><br/>
		</h3>
		<a href="add_recipe.php"> <?php echo($previouspage);?> </a>
		<a href="../manageRecipe.php"> <?php echo($menu);?></a>
		<?php
	}
	else{
		?> <h3> <?php echo($name);?>: <?php echo($_POST['nom']) ?><br/></h3>
		<form method="post" action="verification_formu.php?refvrac=<?php echo($_POST['nom'])?>" onsubmit="return verifier(this);">
		<table id="pricetable">
			<thead>
				<tr>
					<th class="choiceA">Matiere </th>
					<th class="choiceC on">Pourcentage <br/>Quantité (kg/m3)</th>
					<th class="choiceD">Type de matiere</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for($i=0;$i<$_POST['step'];$i++){
					$matiere="matiere".$i;
					$pourcentage="pourcentage".$i;
					$typematiere="typematiere".$i;
	
				?>
				<tr>
					<td class="matiere"><input type="text" name="<?php echo($matiere)?>" id="<?php echo($matiere)?>"/></td>
					<td class="pourcentage"><input type="text" name="<?php echo($pourcentage)?>" id="<?php echo($pourcentage)?>" /></td>
					<td class="typematiere">
					<select name="<?php echo($typematiere)?>" id="<?php echo($typematiere)?>">
						<option value="matierepremiere">Matiere premiere</option> 
						<option value="additifs"> Additif</option>
					</select>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table><p>
	<input type="submit" value="Enregistrer" /></p>
	</form>
	<a href="add_formu.php"> Page précédente</a>
	<?php
	}
}
	function recipeexists($bdd){
		$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Name=?');
		$req->execute(array($_POST['nom']));
		$reponse=$req->fetch();
		return ($reponse[0]!=0);
	}

?>
</body>
</html>