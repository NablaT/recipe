<?php
include('config/config.php');
$string="Kiwii";
$id=getId($bdd,1,$string);
echo($id);

function getId($bdd, $cpt, $str){
	$id=substr($str,0,3).$cpt;
	//echo("id: ".$id." ");
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