

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../config/config.php');
	include('../../../text/recipe/managerecipe_text.php');
	//print_r($_POST);
?>
<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> <?php echo($titleadd);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/add.css">

</head>
<?php
	if($_POST['steps']<=0){
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
		<a href="../../manageRecipe.php"> <?php echo($menu);?></a>
		<?php
	}
	
	else{
		//print_r($_POST);
		?> <h3> <?php echo($name);?>: <?php echo($_POST['nom']) ?><br/></h3>
		<form method="post" action="verification_recipe.php?name=<?php echo($_POST['nom'])?>&code=<?php echo($_POST['code'])?>" onsubmit="return verifier(this);">
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
				for($i=0;$i<$_POST['number'];$i++){
					$ingredient="ingredient".$i;
					$quantity="quantity".$i;
					$type="type".$i;
	
				?>
				<tr>
					<td class="ingredient"><input type="text" name="<?php echo($ingredient)?>" id="<?php echo($matiere)?>"/></td>
					<td class="quantity"><input type="text" name="<?php echo($quantity)?>" id="<?php echo($pourcentage)?>" /></td>
					<td class="typematiere">
					<select name="<?php echo($type)?>" id="<?php echo($type)?>">
						<option value="solid"><?php echo($solid)?></option> 
						<option value="liquid"> <?php echo($liquid)?></option>
						<option value="unity"> <?php echo($unity)?></option>
					</select>
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
				for($i=0;$i<$_POST['steps'];$i++){
					$steps="steps".$i;	
				?>
				<tr>
					<td class="steps"><input type="textarea" name="<?php echo($steps)?>" id="<?php echo($steps)?>"/></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table><p>
	<input type="submit" value="<?php echo($save)?>" /></p>
	</form>
	<a href="add_recipe.php"><?php echo($previouspage)?></a>
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