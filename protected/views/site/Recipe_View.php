<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
	<title> Etapes formulation </title>
	<link rel="stylesheet" type="text/css" href="table.css">

</head> 
<body>
<?php

include 'isconnected.php';

if($isconnected){
	print_page();
}

function print_page(){

include 'config.php';
$refVrac="";
filltheDB($bdd);
build_frame($bdd);

}
/**
* Cette fonction permet de remplir une première fois la base de données avec la date de début de production,
* la commande "détaillée", le volume, le volume du godet.  
**/
function filltheDB($bdd){
	$refVrac="";
	if(strcmp($_GET['step'],"0-0")==0){
		$numcommande=$_GET['numcom'];
		$step="1-1";
		$listetouille=get_liste_touilles($_POST['volume']);
		$nbtouille=count($listetouille);
		//Recuperation de la date
		$date=date("y-m-d"); 
		//Enregistrement des données
		$req=$bdd->prepare('SELECT * FROM client WHERE Numcommande=?');
		$req->execute(array($_GET['numcom']));
		$donnes=$req->fetch();
		$refVrac=$donnes['RefVrac'];
		$req->closeCursor();
		$idref=$_GET['refvrac'];
		//on calcule la difference
		$difference=$_POST['volume']-$_GET['quantiteini'];
		if($difference<0) $difference=0;
		
		$req = $bdd->prepare('INSERT INTO productionencours(Quantite, Numcommande, Taillegodet,Date,Poste,Quantiterestante,Etape,Nbtouille,Referencevrac,Idref) VALUES(:quantite, :numcommande, :taillegodet,:date,:poste,:quantiterest,:etape,:nbtouille,:refvrac,:idref)');
		$req->execute(array(
		'quantite' => $_POST['volume'],
		'numcommande' => $_GET['numcom'],
		'taillegodet' => $_POST['godet'][5],
		'date' =>$date,
		'poste'=>$_POST['poste'][5],
		'quantiterest' => $difference,
		'etape'=>$step,
		'nbtouille'=>$nbtouille,
		'refvrac'=>$refVrac,
		'idref'=>$idref
		));
		$req->closeCursor();
		filltouillescourantes($bdd,$idref,$_POST['volume'],$_GET['numcom']);
		
		$req = $bdd->prepare('UPDATE touillescourantes SET Date=:date WHERE Etape=\'1-1\' AND Numcommande=:numcom');
		$req->execute(array('date'=>$date,'numcom'=>$_GET['numcom']));
		$req->closeCursor();
		
		if(strcmp($_GET['ofi'],"false")){
			saveinrecetteoficourante($bdd,$_GET['numcom']);
		}
		delete_command($_GET['numcom'],$bdd,$_POST['volume']);
		
		
	}
	else{
		updating($bdd);
		if(itsdone($bdd)){
			$numcommande=$_GET['numcom'];	
			$reponse=$bdd->prepare('SELECT * FROM productionencours WHERE Numcommande = ?');
			$reponse->execute(array($_GET['numcom']));
			$donnes =$reponse->fetch();
			$quantite=$donnes['Quantite'];
			$volumegodet=$donnes['Taillegodet'];
			$datedeb=$donnes['Date'];
			$poste=$donnes['Poste'];
			$refvrac=$donnes['Referencevrac'];
			$quantiterestante=$donnes['Quantiterestante'];
			$datevrac=recupdatevrac($datedeb);
			$numlotvrac="";
			if(numLotVracOuvert($bdd, $refvrac)){
				$numlotvrac=getNumLotVrac($bdd, $refvrac);
			}
			else{
				echo("LA JE RENTRE");
				$numlotvrac=$refvrac."".$datevrac;
			}
			$idref=$donnes['Idref'];
			//On vérifie si c'est une ofi ou non.
			$isofi=true;
			$stepanddate=array();
			//$listdate=get_list_date($bdd,$_GET['numcom']);
			$listof=array();
			$listof=get_list_of($_GET['numcom']);
			$referencevrac=$donnes['Referencevrac'];
			$idref=$donnes['Idref'];
			
			$quantiteproduite=0;
			
			
			if(strcmp($referencevrac,$idref)!=0){
				$isofi=false;
				$stepanddate=summaryStep($bdd,$_GET['numcom'],$idref);
				
				$etapeforall=$stepanddate[0];
				$fin=$stepanddate[1];
				$datefin=recupdatefin($bdd,$_GET['numcom'],$fin);
				
				insertfinprod($bdd,$quantite,$quantiterestante, $datedeb,$datefin,$_GET['numcom'],$volumegodet,$poste,$etapeforall,$numlotvrac,"Andre Laruelle",$idref);
				
				$req=$bdd->prepare('SELECT * FROM tolerance WHERE RefVrac=?');
				$req->execute(array($idref));
				$donnes=$req->fetch();
				$toleranceph="[".$donnes['Phmin']."-".$donnes['Phmax']."]";
				$toleranceec="[".$donnes['Ecmin']."-".$donnes['Ecmax']."]";
				$req->closeCursor();
				//echo("Date fin 1: ".$datefin."\n");

				$arraynumcom=array();
				$req = $bdd->prepare('INSERT INTO fichefabrication( Quantite, Date, Numcommande, Volumegodet,Poste,Etapes,Numlotvrac,Toleranceph,Toleranceec,typerecette,isofi, Datedebut) VALUES(:quantite, :date,:numcommande, :volumegodet,:poste,:etapes,:numlot,:toleranceph,:toleranceec,:typerecette,:isofi,:datedeb)');
				$req->execute(array(
				'quantite' => $quantite,
				'date' => $datefin,
				'numcommande' =>$_GET['numcom'],
				'volumegodet'=>$volumegodet,
				'poste' => $poste,
				'etapes'=>$etapeforall,
				'numlot'=>$numlotvrac,
				'toleranceph'=>$toleranceph,
				'toleranceec'=>$toleranceec,
				'typerecette'=>"touille",
				'isofi'=>$isofi,
				'datedeb'=>$datedeb
				));
				$req->closeCursor();
				$ladatefin=$datefin;
				$ladatedeb=$datefin;
				supresstouille($bdd,$_GET['numcom']); 
				filltouillescourantes($bdd,$refvrac,$quantite,$_GET['numcom']);
				
				updatevalidationtouilles($bdd,$_GET['numcom']);

			}
		
			$stepanddate=array();
			
			$stepanddate=summaryStep($bdd,$_GET['numcom'],$refvrac);

			$lesetapes=$stepanddate[0];
			$fin=$stepanddate[1];
			
			//$datefin=recupdatefin($bdd,$_GET['numcom'],$fin); 
			$touille="nontouille";
			$refVracOfi=substr($numlotvrac,0,strlen($numlotvrac)-6);
			
			if($isofi){
				$datefin=recupdatefin($bdd,$_GET['numcom'],$fin); 
				$touille="touille";
				$req = $bdd->prepare('INSERT INTO finproduction( Quantite,Quantiterestante, Datedebut,Datefin, Numcommande, Volumegodet,Poste,Etapes,Numlotvrac,Operateur,RefVracOfi, RefVrac, VracOuvert) VALUES(:quantite, :quantiterestante, :datedebut,:datefin,:numcommande, :volumegodet,:poste,:etapes,:numlot,:operateur, :refvracofi, :refvrac, :vracouvert)');
				$req->execute(array(
				'quantite' => $quantite,
				'quantiterestante' => $quantiterestante,
				'datedebut' => $datedeb,
				'datefin' => $datefin,
				'numcommande' =>$_GET['numcom'],
				'volumegodet'=>$volumegodet,
				'poste' => $poste,
				'etapes'=>$lesetapes,
				'numlot'=>$numlotvrac,
				'operateur'=>"Andre Laruelle", // TEMPORAIRE, A MODIFIER LORS DE L'INSERTION DES CESSIONS
				'refvracofi'=>$refVracOfi,
				'refvrac'=>$idref, 
				'vracouvert'=>true
				));
				$req->closeCursor();
				
			}
			
			$req=$bdd->prepare('SELECT * FROM tolerance WHERE RefVrac=?');
			$req->execute(array($idref));
			$donnes=$req->fetch();
			$toleranceph="[".$donnes['Phmin']."-".$donnes['Phmax']."]";
			$toleranceec="[".$donnes['Ecmin']."-".$donnes['Ecmax']."]";
			$req->closeCursor();
			
			$arraynumcom=array();
			//echo("Date fin 2: ".$datefin);
			$req = $bdd->prepare('INSERT INTO fichefabrication( Quantite, Date, Numcommande, Volumegodet,Poste,Etapes,Numlotvrac,Toleranceph,Toleranceec,typerecette,isofi, Datedebut) VALUES(:quantite, :date,:numcommande, :volumegodet,:poste,:etapes,:numlot,:toleranceph,:toleranceec,:typerecette,:isofi, :datedeb)');
			$req->execute(array(
			'quantite' => $quantite,
			'date' => $datefin,
			'numcommande' =>$_GET['numcom'],
			'volumegodet'=>$volumegodet,
			'poste' => $poste,
			'etapes'=>$lesetapes,
			'numlot'=>$numlotvrac,
			'toleranceph'=>$toleranceph,
			'toleranceec'=>$toleranceec,
			'typerecette'=>$touille,
			'isofi'=>true, 
			'datedeb'=>$datedeb
			));
			$req->closeCursor();
			
			supresstouille($bdd,$_GET['numcom']); 
			$listof=get_list_of($_GET['numcom']);
			$listmatiere=get_liste_matiere($bdd, $refvrac);
			
			for($i=0;$i<count($listof);$i++){
				$req = $bdd->prepare('SELECT * FROM ofcourants WHERE Numof=?');
				$req->execute(array($listof[$i]));
				$donnes=$req->fetch();
				$quantiteinit=$donnes['Quantite'];
				$produit=$donnes['Designation'];
				$ref=$donnes['Reference'];
				$refvrac=$donnes['RefVrac'];
				$req->closeCursor();
				
				filltouillescourantes($bdd,$refvrac,$quantiteinit,$_GET['numcom']);
				
				for($j=0;$j<count($listmatiere);$j++){
					$reponse = $bdd->prepare('UPDATE touillescourantes SET Validation=:validation WHERE Numcommande=:numcom AND Matierecourante=:matiere');
					$reponse->execute(array(
					'validation'=>'1', 
					'numcom'=>$listof[$i],
					'matiere'=>$listmatiere[$j]
					)); 
					$reponse->closeCursor();
				}
				
				$req->closeCursor();
				$stepdateforclient=summaryStep($bdd,$_GET['numcom'],$refvrac);
				$etapeforclient=$stepdateforclient[0];
				$finforclient=$stepdateforclient[1];
				
				$req = $bdd->prepare('INSERT INTO fichefabrication(Produit, Reference, Quantite, Date, Numcommande, Volumegodet,Poste,Etapes,Numlotvrac,Toleranceph,Toleranceec,typerecette,isofi, Datedebut) VALUES(:produit, :ref, :quantite, :date,:numcommande, :volumegodet,:poste,:etapes,:numlot,:toleranceph,:toleranceec,:typerecette,:isofi, :datedeb)');
				$req->execute(array(
				'produit' => $produit,
				'ref' => $ref,
				'quantite' => $quantiteinit,
				'date' => $datefin,
				'numcommande' =>$listof[$i],
				'volumegodet'=>$volumegodet,
				'poste' => $poste,
				'etapes'=>$etapeforclient,
				'numlot'=>$numlotvrac,
				'toleranceph'=>$toleranceph,
				'toleranceec'=>$toleranceec,
				'typerecette'=>"planning",
				'isofi'=>true, 
				'datedeb'=>$datedeb
				));
				
				$req->closeCursor();			
				supresstouille($bdd,$_GET['numcom']); 
			}
			
			supresscurrentprod($bdd);
			$_GET['numcom']=-1;
//										<meta http-equiv="refresh" content="0.00001; URL=./example01.php">
		
				
			?>
			<html>
				<head>
				<title>Redirection</title>
					<meta http-equiv="refresh" content="0.00001; URL=./example01.php">
				</head>
				<body>
				</body>

			</html> 
			<?php
			
		}
	}	
}

function getNumLotVrac($bdd, $refvrac){
	$req=$bdd->prepare('SELECT * FROM finproduction WHERE VracOuvert=? AND RefVracOfi=?');
	$req->execute(array(1, $refvrac));
	$donnes=$req->fetch(); 
	$req->closeCursor();
	return $donnes['Numlotvrac'];	
}
function numLotVracOuvert($bdd, $refvrac){
	
	$req=$bdd->prepare('SELECT COUNT(*) FROM finproduction WHERE VracOuvert=? AND RefVracOfi=?');
	$req->execute(array(1, $refvrac));
	$donnes=$req->fetch();
	if($donnes[0]>0){
		return true;
	}
	$req->closeCursor();
	return false;
}

function updatevalidationtouilles($bdd,$numcom){
	$reponse=$bdd->prepare('SELECT * FROM touillescourantes WHERE Numcommande=?');
	$reponse->execute(array($numcom));
	$listmatiere=array();
	while($donnes=$reponse->fetch()){
		array_push($listmatiere,$donnes['Matierecourante']);
	}
	$reponse->closeCursor(); 
	for($i=0;$i<count($listmatiere);$i++){
		$reponse = $bdd->prepare('UPDATE touillescourantes SET Validation=:validation WHERE Numcommande=:numcom AND Matierecourante=:matiere');
		$reponse->execute(array(
			'validation'=>'1', 
			'numcom'=>$numcom,
			'matiere'=>$listmatiere[$i]
		)); 
		$reponse->closeCursor();
	}
}
function recupdatefin($bdd,$numcom,$fin){
	$reponse=$bdd->prepare('SELECT * FROM touillescourantes WHERE Numcommande = ? AND Etape = ?');
	$reponse->execute(array($numcom,$fin));
	$datefin=$reponse->fetch(); 
	$reponse->closeCursor();
	return $datefin['Date'];
}

function insertfinprod($bdd,$quantite, $quantiterestante, $datedeb,$datefin,$numcom,$volumegodet,$poste,$etapeforall,$numlotvrac,$operateur,$idref){
	$refVracOfi=substr($numlotvrac,0,strlen($numlotvrac)-6);
	$req = $bdd->prepare('INSERT INTO finproduction( Quantite, Quantiterestante	, Datedebut,Datefin, Numcommande, Volumegodet,Poste,Etapes,Numlotvrac,Operateur,RefVracOfi,RefVrac, VracOuvert) VALUES(:quantite, :quantiterestante, :datedebut,:datefin,:numcommande, :volumegodet,:poste,:etapes,:numlot,:operateur,:refvracofi,:refvrac, :vracouvert)');
	$req->execute(array(
		'quantite' => $quantite,
		'quantiterestante' => $quantiterestante,
		'datedebut' => $datedeb,
		'datefin' => $datefin,
		'numcommande' =>$numcom,
		'volumegodet'=>$volumegodet,
		'poste' => $poste,
		'etapes'=>$etapeforall,
		'numlot'=>$numlotvrac,
		'operateur'=>$operateur, // TEMPORAIRE, A MODIFIER LORS DE L'INSERTION DES CESSIONS
		'refvracofi'=>$refVracOfi,
		'refvrac'=>$idref, 
		'vracouvert'=>true
	));
	$req->closeCursor();
}
function deleterecetteoficourante($bdd,$numcom){
	$reponse=$bdd->prepare('DELETE FROM recetteoficourante WHERE Numcommande = ?');
	$reponse->execute(array($numcom));
	$reponse->closeCursor();
}
function saveinrecetteoficourante($bdd,$numcom){
	$req=$bdd->prepare('SELECT * FROM client WHERE numcommande=?');
	$req->execute(array($numcom));
	$donnes=$req->fetch();
	$quantite=$_POST['volume'];
	$refvrac=$donnes['RefVrac'];
	$datetache=$donnes['Datetache'];
	$req->closeCursor();
	$req = $bdd->prepare('INSERT INTO recetteoficourante(Refvrac, Quantite, Numcommande, Datetache) VALUES(:refvrac, :quantite, :numcom, :datetache)');
	$req->execute(array(
		'refvrac' => $refvrac,
		'quantite' => $quantite,
		'numcom' => $numcom,
		'datetache' => $datetache
	));	
	$req->closeCursor();
}

function get_list_date($bdd, $numcom){
	$req=$bdd->prepare('SELECT Date FROM touillescourantes WHERE Numcommande=?');
	$req->execute(array($numcom));
	$listdate=array();
	$step=0;
	while($donnes=$req->fetch()){
		$currstep=substr($donnes['Etape'],0,1);
		//echo("current step: ".$currstep);
		if($step<$currstep){
			array_push($listdate,$donnes['Date']);
			$step++;
		}
	}
	return $listdate;
}

function giveTheOrder($bdd, $saveAllArray){
	//type matiere, matiere, densité, pourcentage
	$savetype=array();
	$savematiere=array();
	$savepourcentage=array();
	$saveAddi=array(); 
	$saveMatiereAddi=array();
	$savePourcentageAddi=array();
	$typeMatiere=$saveAllArray[0];
	$matiere=$saveAllArray[1];
	$pourcentage=$saveAllArray[3];

	$finalArray=array();
	//On sépare les additifs et les matières premières
	for($i=0;$i<count($typeMatiere); $i++){
		if(strcmp($typeMatiere[$i],"matierepremiere")==0){
			array_push($savetype,$typeMatiere[$i]); 
			array_push($savematiere,$matiere[$i]);
			array_push($savepourcentage,$pourcentage[$i]); 
		}
		else{
			array_push($saveAddi,$typeMatiere[$i]); 	
			array_push($saveMatiereAddi,$matiere[$i]);
			array_push($savePourcentageAddi,$pourcentage[$i]);
		}
	}
	//On range les matières premières par rapport au pourcentage dans l'ordre décroissant
	
	$cleanArray=array(); 
	for($i=0; $i<count($savematiere)-1; $i++){
		$posmaxi=$i;
		for($j=$i+1;$j<count($savematiere);$j++){
			if($savepourcentage[$j]>$savepourcentage[$posmaxi]){
				$posmaxi=$j;
			}
			$temppourcentage=$savepourcentage[$posmaxi];
			$tempmatiere=$savematiere[$posmaxi];
			$savepourcentage[$posmaxi]=$savepourcentage[$i];
			$savematiere[$posmaxi]=$savematiere[$i];
			$savepourcentage[$i]=$temppourcentage;
			$savematiere[$i]=$tempmatiere;
		}
	}
	
	//On rajoute les additifs. 
	for($i=0;$i<count($saveAddi);$i++){
		array_push($savetype,$saveAddi[$i]);
		array_push($savematiere,$saveMatiereAddi[$i]);
		array_push($savepourcentage,$savePourcentageAddi[$i]);	
	}
	
	array_push($finalArray, $savetype);
	array_push($finalArray, $savematiere);
	array_push($finalArray, $saveAllArray[2]);
	array_push($finalArray, $savepourcentage);
	return $finalArray;
}
function filltouillescourantes($bdd,$idref,$quantite,$numcommande){
		$listetouille=get_liste_touilles($quantite);
		$nbtouille=count($listetouille);
		$saveAllArray=array();
		array_push($saveAllArray,get_type_matiere($bdd,$idref));
		array_push($saveAllArray,get_liste_matiere($bdd,$idref));
		array_push($saveAllArray,get_liste_densite($bdd,$idref,$saveAllArray[0],$saveAllArray[1]));
		array_push($saveAllArray,get_liste_pourcentage($bdd,$idref));
		$cleanArray=giveTheOrder($bdd, $saveAllArray);
		$liste_type_matiere=$cleanArray[0];
		$liste_matiere=$cleanArray[1];
		$liste_densite=$cleanArray[2];
		$liste_pourcentage=$cleanArray[3];
		$req=$bdd->prepare('SELECT * FROM productionencours WHERE numcommande=?');
		$req->execute(array($numcommande));
		$donnes=$req->fetch();
		
		$godet=$donnes['Taillegodet'];
		$refVrac=$donnes['Referencevrac'];
		if(count($liste_densite)==count($liste_matiere) && count($liste_densite)==count($liste_pourcentage)){
			for($i=0; $i<$nbtouille;$i++){
				for($j=0; $j<count($liste_matiere);$j++){
					$numetape=$i+1;
					$etapetouille=$j+1; 
					if(strcmp($liste_type_matiere[$j],"matierepremiere")==0){
						$poids=get_poids($liste_densite[$j],$listetouille[$i],$liste_pourcentage[$j]); 
						$nb_godet=get_nb_godet($liste_pourcentage[$j],$listetouille[$i],$godet);
						$req = $bdd->prepare('INSERT INTO touillescourantes(Numcommande, Refvrac, Matierecourante, Pourcentage, Kg, Nbgodet, Validation,Volumetotal,Etape,Densite,Typematiere) VALUES(:numcom, :refvrac, :matierecourante, :pourcentage, :kg, :nbgodet, :validation,:volumetotal,:etape,:densite,:type)');
						$req->execute(array(
						'numcom' => $numcommande,
						'refvrac' => $refVrac,
						'matierecourante' => $liste_matiere[$j],
						'pourcentage' => $liste_pourcentage[$j],
						'kg'=>$poids,
						'nbgodet'=>$nb_godet,
						'validation'=>false,
						'volumetotal'=>$listetouille[$i],
						'etape'=>$numetape.'-'.$etapetouille,
						'densite'=>$liste_densite[$j],
						'type'=>$liste_type_matiere[$j]
						));	
					}
					else{
						$poids=get_poids_additif($liste_pourcentage[$j],$listetouille[$i]);
						$req = $bdd->prepare('INSERT INTO touillescourantes(Numcommande, Refvrac, Matierecourante, Pourcentage, Kg, Nbgodet, Validation,Volumetotal,Etape,Densite,Typematiere) VALUES(:numcom, :refvrac, :matierecourante, :pourcentage, :kg, :nbgodet, :validation,:volumetotal,:etape,:densite,:type)');
						$req->execute(array(
						'numcom' => $numcommande,
						'refvrac' => $refVrac,
						'matierecourante' => $liste_matiere[$j],
						'pourcentage' => $liste_pourcentage[$j],
						'kg'=>$poids,
						'nbgodet'=>0,
						'validation'=>false,
						'volumetotal'=>$listetouille[$i],
						'etape'=>$numetape.'-'.$etapetouille,
						'densite'=>$liste_densite[$j],
						'type'=>$liste_type_matiere[$j]
						));	
					
					}
				}
			}
		}
		else{
			echo("Une erreur est survenue lors de la lecture de la table de la reference vrac: ".$refVrac.". Veuillez verifier les informations rentrées dans la base de données de cette référence.");
		}
}

function get_list_of($numcom){
	$listof=array();
	$savecurrentword="";
	for($i=0;$i<strlen($numcom);$i++){
		if($numcom[$i]=='o'){
			array_push($listof,$savecurrentword);
			$savecurrentword="";
		}
		else{
			$savecurrentword=$savecurrentword."".$numcom[$i];
		}
	}
	if(strlen($savecurrentword)==8){
		array_push($listof,$savecurrentword);
	}
	return $listof;
}
function supresstouille($bdd,$numcom){
	$reponse=$bdd->prepare('DELETE FROM touillescourantes WHERE numcommande = ?');
	$reponse->execute(array($numcom));
	$reponse->closeCursor();
}

function supresscurrentprod($bdd){
	$reponse=$bdd->prepare('DELETE FROM productionencours WHERE numcommande = ?');
	$reponse->execute(array($_GET['numcom']));
	$reponse->closeCursor();
}

function updating($bdd){
	//On recupere les données: client ainsi que la référence.
	$numcommande=$_GET['numcom'];
	//On cree la date et on met a jour la table touillecourante
	$date=date("y-m-d"); 
	$req = $bdd->prepare('UPDATE touillescourantes SET Validation=:valid, Date=:date WHERE Numcommande=:numcom AND Etape=:step');
	$req->execute(array('valid'=>'1','date'=>$date, 'numcom'=>$_GET['numcom'],'step'=>$_GET['step'])); //, $_GET['numcom'],$_GET['step']
	$req->closeCursor();
	/*
	$req = $bdd->prepare('UPDATE touillescourantes SET Date=:date WHERE Numcommande=:numcom AND Etape=:step');
	$req->execute(array('date'=>$date, 'numcom'=>$_GET['numcom'],'step'=>$_GET['step'])); //, $_GET['numcom'],$_GET['step']
	$req->closeCursor();*/
	
	//On met à jour la table production en cours.
	$step=currentstep($bdd);
	$reponse=$bdd->prepare('UPDATE productionencours SET Etape=:etape WHERE numcommande =:numcom');
	$reponse->execute(array('etape'=>$step, 'numcom'=>$_GET['numcom']));
	$reponse->closeCursor(); 
}

function summaryStep($bdd,$numcom,$refVrac){
	$reponse=$bdd->prepare('SELECT * FROM touillescourantes WHERE Numcommande = ?');
	$reponse->execute(array($numcom));
	$i=0;
	$sumanddate=array();
	$sum="";
	$matiere="";
	while($donnes =$reponse->fetch()){
		if($i==0 || $i!=substr($donnes['Etape'],0,1)){
			$sum=$sum."<br/>Volume ".$donnes['Volumetotal']." m3 ";
			$i=substr($donnes['Etape'],0,1);
		}
		$valid="";
		if($donnes['Validation']==1){
			$valid="Validé";
		}
		else{
			$valide="Non validé"; 
		}
		if(strcmp($donnes['Typematiere'],"additifs")==0){
			$sum=$sum."<br/> ".$donnes['Matierecourante']." : ".$donnes['Pourcentage']." kg/m3 ".$donnes['Kg']."kg ".$valid."<br/>";
		}
		else{
			$sum=$sum."<br/> ".$donnes['Matierecourante']." (".$donnes['Densite']."): ".$donnes['Pourcentage']."% ".$donnes['Kg']."kg ".$donnes['Nbgodet']." godets: ".$valid."<br/>";
		}
	}
	
	$reponse->closeCursor();
	array_push($sumanddate,$sum);
	$reponse=$bdd->prepare('SELECT COUNT(*) FROM corpsrecette WHERE Idref=?');
	$reponse->execute(array($refVrac));
	$donnes=$reponse->fetch();
	$nbetaperecette=$donnes[0];
	
	$laststep=$i."-".$nbetaperecette; 
	array_push($sumanddate,$laststep);
	return $sumanddate;
}

function recupdatevrac($datedeb){
	$date=substr($datedeb,2,9);
	$deb=substr($date,0,2);
	$mid=substr($date,2,3); 
	$midbis=substr($mid,1,2);
	$end=substr($date,6,9);
	$d=$end."".$midbis."".$deb;
	return $d;
}
function get_poids_additif($quantite,$volume){
	return $quantite*$volume;
}

function get_nb_godet($pourcentage,$volumeprod,$volumegodet){
	$godet=$volumegodet*100;
	$res=floatval($pourcentage*$volumeprod/$godet);
	return ($res);
}

function get_poids($densite,$volume,$pourcentage){
	return ($densite*$volume*$pourcentage/100); 
}

function get_type_matiere($bdd,$refVrac){
	$liste=array(); 
	$reponse=$bdd->prepare('SELECT * FROM corpsrecette WHERE Idref=?');
	$reponse->execute(array($refVrac));
	while($donnes=$reponse->fetch()){
		array_push($liste, $donnes['Type']);
	}
	$reponse->closeCursor();
	return $liste; 
}

function get_liste_matiere($bdd,$refVrac){
	$liste=array(); 
	$reponse=$bdd->prepare('SELECT * FROM corpsrecette WHERE Idref=?');
	$reponse->execute(array($refVrac));
	while($donnes=$reponse->fetch()){
		array_push($liste, $donnes['Matiere']);
	}
	$reponse->closeCursor();
	return $liste; 
}

function get_liste_densite($bdd,$refVrac,$listetypemat,$listemat){
	$listedensite=array();
	for($i=0;$i<count($listemat);$i++){
		if(strcmp($listetypemat[$i],"matierepremiere")==0){
			$reponse=$bdd->prepare('SELECT * FROM matierepremiere WHERE Nom=?');
			$reponse->execute(array($listemat[$i]));
			$donnes=$reponse->fetch();
			array_push($listedensite, $donnes['Densite']);
		}
		else{
			array_push($listedensite, 0);	
		}
	}
	return $listedensite;
}

function get_liste_pourcentage($bdd,$refVrac){
	$liste=array(); 
	$reponse=$bdd->prepare('SELECT * FROM corpsrecette WHERE Idref=?');
	$reponse->execute(array($refVrac));
	while($donnes=$reponse->fetch()){
		array_push($liste, $donnes['Pourcentage']);
	}
	$reponse->closeCursor();
	return $liste; 
}
function get_ref_vrac($ref,$bdd){
	$reponse=$bdd->prepare('SELECT * FROM article WHERE Reference= ?');
	$reponse->execute(array($ref));
	//$reponse->execute(array($ref));
	$donnes =$reponse->fetch();
	return ($donnes['Referencevrac']);
}

function delete_command($numcom,$bdd, $volume){
	$req=$bdd->prepare('SELECT * FROM client WHERE numcommande=?');
	$req->execute(array($_GET['numcom']));
	$donnes=$req->fetch();
	$quantiteAProduire=$donnes['quantite'];
	$req->closeCursor();
	
	if($volume<$quantiteAProduire){
		$difference=$quantiteAProduire-$volume;
		$reponse = $bdd->prepare('UPDATE client SET quantite=:quantite WHERE numcommande=:numcom');
		$reponse->execute(array(
			'quantite'=>$difference, 
			'numcom'=> $numcom
		)); 
		$reponse->closeCursor();
	}
	else{
		$reponse=$bdd->prepare('DELETE FROM client WHERE numcommande = ?');
		$reponse->execute(array($numcom));
		$reponse->closeCursor();
		$donnes=$reponse->fetch();
	}
}

function build_frame($bdd){
	if($_GET['numcom']!=-1){
	$reponse=$bdd->prepare('SELECT * FROM touillescourantes  WHERE Numcommande = ?');
	$reponse->execute(array($_GET['numcom']));
	$fullstep=currentstep($bdd);
	while($donnes =$reponse->fetch()){
		if(strcmp($donnes['Etape'],$fullstep)==0){
			break; 
		}
	}
	$reponse->closeCursor();
	if(strcmp($donnes['Typematiere'],"matierepremiere")==0){
		?>	
		<table id="pricetable">
			<thead>
				<tr>
					<th class="choiceA">Produit</th>
					<th class="choiceB">Pourcentage</th>
					<th class="choiceC on">Poids (kg)</th>
					<th class="choiceD">Nombre de Godet</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="side"><?php echo($donnes['Matierecourante']) ?></td>
					<td class="choiceA"><?php echo($donnes['Pourcentage']) ?></td>
					<td class="choiceB"><?php echo($donnes['Kg']) ?></td>
					<td class="choiceC on"><?php echo($donnes['Nbgodet']) ?></td>
				</tr>
			</tbody>
		</table><br/><p>
		<input type="button" name="Valider" value="Valider" 
		onclick="self.location.href='Recipe_View.php?numcom=<?php echo $donnes['Numcommande'];?>&step=<?php echo ($fullstep)?>'" style="background-color:#BDBDBD" tyle="color:white; font-weight:bold"onclick> 
		<br/> </p>
		<a href="planningprod.php"> Retour planning </a>
		<?php
		}
	else{
		?>	
		<table id="pricetable">
			<thead>
				<tr>
					<th class="choiceA">Produit</th>
					<th class="choiceC on">Poids (kg)</th>
					<th class="choiceD">Quantité (kg/m3)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="side"><?php echo($donnes['Matierecourante']) ?></td>
					<td class="choiceB"><?php echo($donnes['Kg']) ?></td>
					<td class="choiceA"><?php echo($donnes['Pourcentage']) ?></td>
				</tr>
			</tbody>
		</table><br/><p>
		<input type="button" name="Valider" value="Valider" 
		onclick="self.location.href='Recipe_View.php?numcom=<?php echo $donnes['Numcommande'];?>&step=<?php echo $donnes['Etape']?>'" style="background-color:#BDBDBD" tyle="color:white; font-weight:bold"onclick> 
		<br/> </p>
		<a href="planningprod.php"> Retour planning </a>
		<?php
	
		}
	}
}

function itsdone($bdd){
	$step=(int)substr($_GET['step'],0,1); 
	$touille=(int)substr($_GET['step'],2,2); 
	$reponse=$bdd->prepare('SELECT * FROM productionencours  WHERE Numcommande = ?');
	$reponse->execute(array($_GET['numcom']));
	$donnes=$reponse->fetch();
	
	$idref=$donnes['Idref'];
	$reponse->closeCursor();
	$nbtouillemax=$donnes['Nbtouille'];
	$reponse=$bdd->prepare('SELECT COUNT(*) FROM corpsrecette WHERE Idref=?');
	$reponse->execute(array($idref));
	$donnes=$reponse->fetch(); 
	$nbligne=$donnes[0];
	$reponse->closeCursor();

	if($touille>=$nbligne && $step>=$nbtouillemax){
		return true;
	}
	return false; 
}
function currentstep($bdd){
	$fullstep=""; 
	$step=(int)substr($_GET['step'],0,1); 
	$touille=(int)substr($_GET['step'],2,2); 
	
	$reponse=$bdd->prepare('SELECT * FROM productionencours  WHERE Numcommande = ?');
	$reponse->execute(array($_GET['numcom']));
	$donnes=$reponse->fetch();
	$idref=$donnes['Idref'];
	//$refVrac=get_ref_vrac($donnes['Reference'],$bdd);
	$nbtouillemax=$donnes['Nbtouille'];
	
	$reponse=$bdd->prepare('SELECT COUNT(*) FROM corpsrecette WHERE Idref=?');
	$reponse->execute(array($idref));
	$nbligne=$reponse->fetch();
	$reponse->closeCursor(); 
	if(strcmp($_GET['step'],"0-0")==0){
		return "1-1";
	}
	else if($touille<$nbligne[0]){
		$touille=$touille+1;
	}
	else if($step<$nbtouillemax){
		$step=$step+1; 
		$touille=1; 
	}
	$fullstep=$step."-".$touille; 
	
	return $fullstep;
}

function get_liste_touilles($volume){
	$res=array();
	if($volume%35==0){
		for($pos=0;$pos<($volume/35);$pos++){
			array_push($res,35);
		}
	}
	else{
		if(($volume/35)>1){
			for($pos=0;$pos<(round($volume/35));$pos++){
				array_push($res,35);
			}
		}
		array_push($res,$volume%35);
	}	
	return $res;
}

?>