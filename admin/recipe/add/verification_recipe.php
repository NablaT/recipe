<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title>Ajout d'une formulation</title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

</head>
<body>

<?php 
session_cache_limiter('private_no_expire, must-revalidate');
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
		print_r($_POST);
		include('../../../config/config.php');
		include('../../../text/recipe/managerecipe_text.php');
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
		
		print_r($saveingredients);
		if(!goodData($savequantity,$savetype)){
			?>
			<h2> <?php echo($errorquantity);?><br/> <?php echo($fillthemagain);?></h2>
			<?php
		}
		$badingredients=goodIngredients($saveingredients, $bdd);
		?> <br/>
		<?php
		if(count($badingredients)>0){
				?> <h2> <?php echo($ingredients);?>:</h2> <?php
				for($i=0;$i<count($badingredients);$i++){
					?>
					<h2> <br/><?php echo($badingredients[$i])?> </h2>
					<?php
				}	
				
			?>
			<h3> <br/><?php echo($erroringredient);?><br/>
			<?php echo($fillthemagain);?></h3>
			<?php
		}
				
		
		else{
			saveall($saveingredients, $savequantity,$savetype,$savesteps,$bdd);
			
			?>
			<h2> <?php echo($recipe);?>: <?php echo($_GET['name'])?>
			<br/></h2>
			<a href="add_recipe.php"> <?php echo($first)?></a><br/>
			<a href="../../manageRecipe.php"> <?php echo($menu)?></a>
			<?php
		}
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
		
		function save_and_densite($saveingredients,$savequantity,$savetype,$bdd){
			$req=$bdd->prepare('SELECT COUNT(*) FROM tmpformu WHERE RefVrac=?');
			$req->execute(array($_GET['refvrac']));
			$reponse=$req->fetch();
			$req->closeCursor();
			if($reponse[0]==0){
				for($i=0; $i<count($saveingredients);$i++){
					$req = $bdd->prepare('INSERT INTO tmpformu(RefVrac, Matiere, Pourcentage, Type, Id) VALUES(:refvrac, :matiere, :pourcentage, :type, :id)');
					$req->execute(array(
					'refvrac' => $_GET['refvrac'],
					'matiere' => $saveingredients[$i],
					'pourcentage' => $savequantity[$i],
					'type' => $savetype[$i],
					'id' => $_GET['refvrac'].''.$i
					));
					$req->closeCursor();
				}
			}
			else{
				$reponse=$bdd->prepare('DELETE FROM tmpformu WHERE RefVrac = ?');
				$reponse->execute(array($_GET['refvrac']));
				$reponse->closeCursor();
				for($i=0; $i<count($saveingredients);$i++){
					$req = $bdd->prepare('INSERT INTO tmpformu(RefVrac, Matiere, Pourcentage, Type, Id) VALUES(:refvrac, :matiere, :pourcentage, :type, :id)');
					$req->execute(array(
					'refvrac' => $_GET['refvrac'],
					'matiere' => $saveingredients[$i],
					'pourcentage' => $savequantity[$i],
					'type' => $savetype[$i],
					'id' => $_GET['refvrac'].''.$i
					));
					$req->closeCursor();
				}
			}
			$densite=0.0;
			$savedensite=array();
			for($i=0;$i<count($saveingredients);$i++){
				if(strcmp($savetype[$i],"additifs")==0){
					array_push($savedensite,0);
				}
				else{
					$reponse=$bdd->prepare('SELECT * FROM matierepremiere WHERE Nom=?');
					$reponse->execute(array($saveingredients[$i]));
					$donnes=$reponse->fetch();
					array_push($savedensite,$donnes['Densite']);
				}
			}
			for($i=0;$i<count($saveingredients);$i++){
				if(strcmp($savetype[$i],"additifs")==0){
					$densite=$densite+$savequantity[$i];
				}
				else{
					$densite=$densite+$savedensite[$i]*$savequantity[$i]/100;
				}
			}
			return $densite;
		}
		
			function saveAll($bdd){
		$req=$bdd->prepare('SELECT COUNT(*) FROM corpsrecette WHERE RefVrac=?');
		$req->execute(array($_GET['refvrac']));
		$reponse=$req->fetch();
		$req->closeCursor();
		if($reponse[0]!=0){
			$reponse=$bdd->prepare('DELETE FROM corpsrecette WHERE RefVrac = ?');
			$reponse->execute(array($_GET['refvrac']));
			$reponse->closeCursor();
		}
		$reponse=$bdd->prepare('SELECT * FROM tmpformu WHERE RefVrac=?');
		$reponse->execute(array($_GET['refvrac']));
		$savematiere=array();
		$savepourcentage=array();
		$savetypematiere=array();
		while($donnes=$reponse->fetch()){
			array_push($savematiere,$donnes['Matiere']);
			array_push($savepourcentage,$donnes['Pourcentage']);
			array_push($savetypematiere,$donnes['Type']);
		}
		$reponse->closeCursor();
		for($i=0; $i<count($savematiere);$i++){
			$req = $bdd->prepare('INSERT INTO corpsrecette(RefVrac, Matiere, Pourcentage, Type,Densitevrac,Idref,Typeref) VALUES(:refvrac, :matiere, :pourcentage, :type,:densitevrac,:idref,:typeref)');
			$req->execute(array(
			'refvrac' => $_GET['refvrac'],
			'matiere' => $savematiere[$i],
			'pourcentage' => $savepourcentage[$i],
			'type' => $savetypematiere[$i],
			'densitevrac'=>$_GET['densite'],
			'idref'=>$_GET['refvrac'],
			'typeref'=>"ofi"
			));
			$req->closeCursor();
		}
		
		$req=$bdd->prepare('DELETE FROM tmpformu WHERE RefVrac = ?');
		$req->execute(array($_GET['refvrac']));
		$req->closeCursor();
	
	}


?>

</body>
</html>