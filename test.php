<?php 
include('config/config.php'); 
$req = $bdd->prepare('SELECT * FROM contact WHERE login=?');
$req->execute(array("user"));
$donnes=$req->fetch(); 
$req->closeCursor(); 
print_r($donnes);

$req = $bdd->prepare('INSERT INTO contact(login, password, firstname,lastname,type) VALUES(:login, :password, :firstname,:lastname,:type)');
$req->execute(array(
	'login' => "admin",
	'password' => "admin",
	'firstname' => "Rémi",
	'lastname' =>"Pourtier",
	'type'=>"admin"
));
$req->closeCursor();
?>