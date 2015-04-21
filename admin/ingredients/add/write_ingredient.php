<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../config/config.php');
	include('../../../text/recipe/manageingredient_text.php');
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
	
	if(ingredientexists($bdd)){
		?>
		<h3> <?php echo($errorIngredientExists);?><br/>
		</h3>
		<a href="add_ingredient.php"> <?php echo($previouspage);?> </a>
		<a href="../managerecipe.php"> <?php echo($menu);?></a>
		<?php
	}
	else{
		print_r($_POST);
		saveAll($bdd);
	?>
	<a href="add_recipe.php"><?php echo($previouspage)?></a>
	
</body>
</html>
	<?php
	
	}
}
	function ingredientexists($bdd){
		$req=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Name=?');
		$req->execute(array($_POST['nom']));
		$reponse=$req->fetch();
		return ($reponse[0]!=0);
	}
	
	function saveAll($bdd){
		$id=getId($bdd,1, $_POST['Name']);
		$req = $bdd->prepare('INSERT INTO ingredient(Name, Description, Idingredient) VALUES(:name, :description, :idingredient)');
		$req->execute(array(
			'name' => $tablines[$i],
			'description' => "spicy",
			'idingredient' => substr($tablines[$i],0,3)."1"
		));
		$req->closeCursor();
	}
	
	//We are using cpt as identifier 
	function getId($bdd, $cpt, $str){
		$id=substr($str,0,3).$cpt;
		$req=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Idingredient=?');
		$req->execute(array($id));
		$reponse=$req->fetch();
		$req->closeCursor();
		print_r($reponse);
		
		if($reponse[0]==0){
			return $id;
		}
		else{
			$cpt=$cpt+1;
			return getId($bdd,$cpt,$str);
		}
	}

?>