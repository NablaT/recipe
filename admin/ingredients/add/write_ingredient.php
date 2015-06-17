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
	<title> <?php echo($titleadd);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

</head>
<?php
	
	if(ingredientexists($bdd)){
		?>
		<h2> <?php echo($errorIngredientExists);?><br/>
		</h2>
		<a href="add_ingredient.php"> <?php echo($previouspage);?> </a>
		<a href="../../managerecipe.php"> <?php echo($menu);?></a>
		<?php
	}
	else{

		saveAll($bdd);
	?>
	<h2> <?php echo($addmessage1.$_POST['name'].$addmessage2);?>
	</h2>
	<a href="add_ingredient.php"><?php echo($previouspage)?></a>
	<a href="managerecipe.php"><?php echo($menu)?></a>
</body>
</html>
	<?php
	
	}
}
	function ingredientexists($bdd){
		$req=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Name=?');
		$req->execute(array($_POST['name']));
		$reponse=$req->fetch();
		return ($reponse[0]!=0);
	}
	
	function saveAll($bdd){
		$id=getId($bdd,1, $_POST['name']);
		$req = $bdd->prepare('INSERT INTO ingredient(Name, Description, Idingredient) VALUES(:name, :description, :idingredient)');
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
		$req=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Idingredient=?');
		$req->execute(array($id));
		$reponse=$req->fetch();
		$req->closeCursor();
		
		if($reponse[0]==0){
			return $id;
		}
		else{
			$cpt=$cpt+1;
			return getId($bdd,$cpt,$str);
		}
	}

?>