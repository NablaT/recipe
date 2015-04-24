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

?>