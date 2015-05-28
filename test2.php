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


$recipes=lookForRecipesWrongCode($bdd, "Salety");
print_r($recipes);

function lookForRecipesWrongCode($bdd, $codeRecipe){
	$recipes=array();
	$saveCodes=array();
	//First we select all categories which contains our code
	$req=$bdd->query('SELECT * FROM category');
	while($donnes =$req->fetch()){
		if(strpos($donnes,$codeRecipe)==0){
			array_push($saveCodes,$donnes['Name']);
		}
	}
	$req->closeCursor();
	//Then we save all recipes which have previous codes. 
	for($i=0;$i<count($saveCodes);$i++){
		$req=$bdd->prepare('SELECT * FROM recipe WHERE Code=?');
		$req->execute(array($saveCodes[$i]));
		while($donnes=$req->fetch()){
			array_push($recipes, $donnes['Name']);
		}
		$req->closeCursor();
	}
	return $recipes;
}
/*
$string="test-est-ttes";
$str2="test-estt-ttes-eeeeeazaze-rre";
$res=strstr($str2, $string);
echo(strpos($str2,$string));




/*
$reponse=$bdd->prepare('DELETE FROM category WHERE Id=?');
$reponse->execute(array("Sug0"));
$reponse->closeCursor();


$reponse=$bdd->prepare('DELETE FROM category WHERE Id=?');
$reponse->execute(array("Sal0"));
$reponse->closeCursor();

/*
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