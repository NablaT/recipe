

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
		include('../../../config/config.php');
		include('../../../text/recipe/managerecipe_text.php');
		?>
		<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title><?php echo($titleadd);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

</head>
<body>
		
		<?php
		$saveingredients=array();
		$savequantity=array();
		$savetype=array();
		$savesteps=array();
		$size=count($_POST);
		$sizemin=count($_POST)/3;
		
		for($i=0;$i<((count($_POST)/3)-1);$i++){
			array_push($saveingredients,$_POST['ingredient'.$i]);
			array_push($savequantity,$_POST['quantity'.$i]);
			array_push($savetype,$_POST['type'.$i]);
			array_push($savesteps,$_POST['steps'.$i]);
		}
		
		if(!goodData($savequantity,$savetype)){
			?>
			<h2> <?php echo($errorquantity);?><br/> <?php echo($fillthemagain);?></h2>
			<?php
		}
		$badingredients=goodIngredients($saveingredients, $bdd);
		?> <br/>
		<?php
			saveall($saveingredients, $savequantity,$savetype,$savesteps,$bdd);
			
			?>
			<h2> <?php echo($recipe);?> <?php echo($_GET['name'])?>
			<?php echo($confirmation);?><br/></h2>
			<a href="add_recipe.php"> <?php echo($addrecipe)?></a><br/>
			<a href="../../manageRecipe.php"> <?php echo($menu)?></a>
			<?php
}
		function goodIngredients($saveingredients,$bdd){
			$savebadingredients=array();
			for($i=0;$i<count($saveingredients);$i++){
				$reponse=$bdd->prepare('SELECT COUNT(*) FROM ingredient WHERE Name=?');
				$reponse->execute(array($saveingredients[$i]));
				$cpt=$reponse->fetch();
				if($cpt[0]==0){
					array_push($savebadingredients,$saveingredients[$i]);
				}
				$reponse->closeCursor();
			}
			return $savebadingredients;
		}
		
		
		function goodData($savequantity){
			for($i=0;$i<count($savequantity)/4;$i++){
				if($savequantity[$i]<=0){
						return false;
				}
			}
			return true;
		}
		
		function getID($bdd,$cpt){
			$id=substr($_GET['name'],0,3).$cpt;
			$req=$bdd->prepare('SELECT COUNT(*) FROM recipe WHERE Idrecipe=?');
			$req->execute(array($id));
			$reponse=$req->fetch();
			$req->closeCursor();
			if($reponse[0]==0){
				return $id;
			}
			else{
				$cpt=$cpt+1;
				return getId($bdd,$cpt);
			}
		}
		
		function saveAll($saveingredients, $savequantity,$savetype,$savesteps,$bdd){
			
			$id=getID($bdd,1);
			
			for($i=0; $i<count($saveingredients);$i++){
				$req = $bdd->prepare('INSERT INTO recipe(Name, Idingredient, Quantity,Idrecipe, Measure,Category) VALUES(:name, :idingredient, :quantity, :idrecipe,:measure,:category)');
				$req->execute(array(
				'name' => $_GET['name'],
				'idingredient' => $saveingredients[$i],
				'quantity' => $savequantity[$i],
				'idrecipe' => $id,
				'measure'=>$savetype[$i],
				'category'=>$_GET['code']
				));
				$req->closeCursor();
			}
			for($i=0; $i<count($savesteps);$i++){
				$req = $bdd->prepare('INSERT INTO recipestep(Idrecipe, Name, Step) VALUES(:idrecipe,:name, :step)');
				$req->execute(array(
				'idrecipe' => $id,
				'name' => $_GET['name'],
				'step' => $savesteps[$i]
				));
				$req->closeCursor();
			}
			
	
	}


?>

</body>
</html>