<?php 
include('config/config.php'); 


$file='D:\xampp\htdocs\recipe\text/fruitslist.txt';
$banane="Banane"; 
if(is_file($file)){
		if($tablines=file($file)){
			echo(count($tablines));
			print_r($tablines);
			for($i=1;$i<count($tablines);$i++){						
				$req = $bdd->prepare('INSERT INTO ingredient(Name, Description, Idingredient) VALUES(:name, :description, :idingredient)');
				$req->execute(array(
					'name' => $tablines[$i],
					'description' => "fruit",
					'idingredient' => substr($tablines[$i],0,3)."1"
				));
				$req->closeCursor();
			}
		}
		else{
			echo("pouet");
		}
}
else{
	echo("repouet");
}


/*
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
$req->closeCursor();*/


?>