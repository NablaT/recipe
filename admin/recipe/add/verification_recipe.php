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
		for($i=0;$i<count($_POST)/3;$i++){
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
		$res=goodMatiere($saveingredients,$savetype,$bdd);
		?> <br/>
		<?php
		$matierepremiere=$res[0];
		$additif=$res[1];
		if(count($additif)>0 || count($matierepremiere)>0){
			if(count($additif)>0 && count($matierepremiere)>0){
				?> <h2> <?php echo($ingredients);?>:</h2> <?php
				for($i=0;$i<count($matierepremiere);$i++){
					?>
					<h2> <br/><?php echo($matierepremiere[$i])?> </h2>
					<?php
				}
				?> <br/><h2> Additifs :</h2> <?php
				for($i=0;$i<count($additif);$i++){
					?>
					<h3> <br/><?php echo($additif[$i])?> </h2>
					<?php
				}
				
			}
			else if(count($additif)>0){
				?> <br/><h2> Additifs :</h2> <?php
				for($i=0;$i<count($additif);$i++){
					?>
					<h3> <br/><?php echo($additif[$i])?> </h3>
					<?php
				}
				
				
			}
			else if(count($matierepremiere>0)){
				?> <h2> Matieres :</h3> <?php
				for($i=0;$i<count($matierepremiere);$i++){
					?>
					<h3> <br/><?php echo($matierepremiere[$i])?> </h3>
					<?php
				}
				
			}
			?>
			<h3> <br/>N'existe(nt) pas dans la base de données.
			Veuillez les renseigner.</h3>
			<?php
		}
		else{
			$densite=save_and_densite($saveingredients, $savequantity,$savetype,$bdd);
			
			?>
			<h2> Formule: <?php echo($_GET['refvrac'])?>
			<br/>La densité est de: <?php echo($densite)?><br/></h2>
			<a href="confirmation.php?refvrac=<?php echo($_GET['refvrac'])?>&densite=<?php echo($densite)?>"> Valider la formulation </a>
			<?php
		}
}
		function goodMatiere($saveingredients,$savetype,$bdd){
			$savebadmatiere=array();
			$savebadadditif=array();
			for($i=0;$i<count($saveingredients);$i++){
				if(strcmp($savetype[$i],"additifs")==0){
					$reponse=$bdd->prepare('SELECT COUNT(*) FROM additif WHERE Nom=?');
					$reponse->execute(array($saveingredients[$i]));
					$cpt=$reponse->fetch();
					if($cpt[0]==0){
						array_push($savebadadditif,$saveingredients[$i]);
					}
					$reponse->closeCursor();
				}
				else{
					$reponse=$bdd->prepare('SELECT COUNT(*) FROM matierepremiere WHERE Nom=?');
					$reponse->execute(array($saveingredients[$i]));
					$cpt=$reponse->fetch();
					if($cpt[0]==0){
						array_push($savebadmatiere,$saveingredients[$i]);
					}
					$reponse->closeCursor();
				}
			}
			$finalarray=array();
			array_push($finalarray,$savebadmatiere);
			array_push($finalarray,$savebadadditif);
			return $finalarray;
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
		

?>

</body>
</html>