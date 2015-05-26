<?php
include('config/config.php');

$savedescription=array();
array_push($savedescription,"test");
array_push($savedescription,"test2");
array_push($savedescription,"test4");

$b=in_array("test",$savedescription);
$categories=array();
array_push($categories,"Salety-Plate-Meat-Pork");
array_push($categories,"Salety-Plate-Meat-Beef");
array_push($categories,"Salety-Plate-Vegetable");
array_push($categories,"Salety-Entry-Other");
array_push($categories,"Salety-Entry-Salad-Starch");
array_push($categories,"Salety-Entry-Salad-Vegetable");+
array_push($categories,"Sugary-Fruits");
array_push($categories,"Sugary-Other-Others");
array_push($categories,"Sugary-Other-Chocolate");
/*$reponse=$bdd->query('DELETE FROM category');
$reponse->closeCursor();*/

for($i=0;$i<count($categories);$i++){
	$req = $bdd->prepare('INSERT INTO category(Name) VALUES(:name)');
	$req->execute(array(
		'name' => $categories[$i]
	));
	$req->closeCursor();
}

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