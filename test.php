<?php 
include('config/config.php'); 
$req = $bdd->prepare('SELECT * FROM contact WHERE login=? AND password=?');
$req->execute(array("admin", "admin"));
$donnes=$req->fetch(); 
$req->closeCursor(); 
print_r($donnes);

$req = $bdd->prepare('INSERT INTO recipe(Name, Idingredient, Quantity,Action,Step,Idrecipe) VALUES(:name, :idingredient, :quantity,:action,:idrecipe)');
$req->execute(array(
	'login' => "admin",
	'password' => "admin",
	'firstname' => "Rémi",
	'lastname' =>"Pourtier",
	'type'=>"admin"
));
$req->closeCursor();
?>