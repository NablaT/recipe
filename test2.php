<?php
include('config/config.php');
/*$savename=array();
$savedescription=array();
$saveid=array();
$req=$bdd->query('SELECT * FROM ingredient');
while($reponse=$req->fetch()){
	array_push($savename,$reponse['Name']);
	array_push($savedescription,$reponse['Description']);
	array_push($saveid,$reponse['Idingredient']);
}
$reponse=$bdd->prepare('DELETE FROM ingredient WHERE Idingredient=?');
$reponse->execute(array($saveid[0]));
$reponse->closeCursor();
$newname=trim($savename[0], " ");
$newname=trim($newname, "\n");
$req = $bdd->prepare('INSERT INTO ingredient(Name, Description, Idingredient) VALUES(:name, :description, :idingredient)');
$req->execute(array(
	'name' => $newname,
	'description' => $savedescription[0],
	'idingredient' => $saveid[0]
));
$req->closeCursor();
*/
$req=$bdd->prepare('SELECT * FROM ingredient WHERE Name=?');
$req->execute(array("test"));
$reponse=$req->fetch();
print_r($reponse);
$req->closeCursor();
/*
$req=$bdd->query('SELECT * FROM test WHERE Name=\' Kiwi\'');
$reponse=$req->fetch();
print_r($reponse);
$req->closeCursor();
/*
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
	
}*/
?>