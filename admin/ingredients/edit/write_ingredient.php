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
	<title> <?php echo($titleedit);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

</head>
<?php
	$id=getId($bdd,1, $_POST['name']);
	?>
	<h2> <?php echo("Id: ".$id);?> </h2>
	<?php
	if(ingredientexists($bdd)){
		updateIngredient($bdd);
		?>
		<h2> <?php echo($addmessage1.$_POST['name'].$addmessage2);?>
		</h2>
		<a href="add_ingredient.php"><?php echo($previouspage)?></a>
		<a href="managerecipe.php"><?php echo($menu)?></a>
		</body>
		</html>
		<h2> 
		<?php
		
	}
	else{
		?><h2>
		<?php echo($errorIngredientNotExists);?><br/>
			</h2>
			<a href="../add/add_ingredient.php"> <?php echo($addit);?> </a>
			<a href="edit_ingredient.php"> <?php echo($previouspage);?> </a>
			<a href="../../manageRecipe.php"> <?php echo($menu);?></a>
		<?php	
	}
}
	function ingredientexists($bdd){
		// $id=getId($bdd,1, $_POST['name']);
		// $req=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Idingredient=?');
		// $req->execute(array($id));
		// $reponse=$req->fetch();
		// return ($reponse[0]!=0);
		$id=getId($bdd,1, $_POST['name']);
		$req=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Name=?');
		$req->execute(array($_POST['name']));
		$reponse=$req->fetch();
		return ($reponse[0]==1);
	}
	
	function updateIngredient($bdd){
		$id=getId($bdd,1, $_POST['name']);
		print_r($_POST);
		$req = $bdd->prepare('UPDATE ingredient SET Name=:name AND Description=:description WHERE Idingredient=:idingredient');
		$req->execute(array(
			'name' => $_POST['name'],
			'description' => $_POST['type'],
			'idingredient' => $id
		));
		$req->closeCursor();
	}
	
	//We are using cpt as identifier 
	function getId($bdd, $cpt, $str){
		$id=substr($str,0,3).$cpt;
		$req=$bdd->prepare('SELECT * FROM ingredient WHERE Idingredient=?');
		$req->execute(array($id));
		$reponse=$req->fetch();
		$req->closeCursor();
		
		if(strcmp($reponse['Idingredient'],$id)==0 && strcmp($reponse['Name'],$_POST['name'])==0){
			return $id;
		}
		else if(strcmp($reponse['Idingredient'],$id)==0){
			$cpt=$cpt+1;
			return getId($bdd,$cpt,$str);
		}
	}

?>