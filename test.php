<?php
include('config/config.php');

$array=array();

array_push($array, "Sugary");
array_push($array, "Salety");
// array_push($array, "Salad");
// array_push($array, "Other");
// array_push($array, "Vegetable");
// array_push($array, "Meat");
$father=array(); 
array_push($father, "Other");
array_push($father, "Other");
array_push($father, "Entry");
array_push($father, "Entry");
array_push($father, "Plate");
array_push($father, "Plate");
$reponse=$bdd->query('DELETE FROM currentchoices');
$reponse->closeCursor(); 

/*array_push($array, "Beef");
array_push($array, "Pork");
/*array_push($array, "Fruits");
array_push($array, "Chocolate");
$reponse=$bdd->query('DELETE FROM category');
$reponse->closeCursor(); 
$step=0;
for($i=0;$i<count($array);$i++){
	$req = $bdd->prepare('UPDATE category SET Step=:step WHERE Name=:name ');
		$req->execute(array(
			'step' => $step,
			'name' => $array[$i]
		));
		$req->closeCursor();
	/*$req = $bdd->prepare('INSERT INTO category(Name, Step,Father) VALUES(:name, :step,:father)');
	$req->execute(array(
		'name' => $array[$i],
		'step' => $step, 
		'father'=>$father[$i]
	));
	$req->closeCursor();
}


/*$xmlstr = '<?xml version="1.0" encoding="utf-8" ?'.'>'.
'<ingredients>
    <ingredients>
         <id name="Ban1">
            <english> banana </english>
            <french> banane </french>
         </id>
         <id name="Kiw1">
            <english> kiwi </english>
            <french> kiwi </french>
        </id>
         <id name="App1">
            <english> apple </english>
            <french> pomme </french>
        </id>
    </ingredients>
</ingredients>';
 
 
$ingredients= new SimpleXMLElement($xmlstr);
 
$ingredientlist=explode(' ','Debut SuiteDebut Milieu SuiteMilieu Fin');
for($i=0;$i<count($ingredientlist); $i++){
echo 'i: '.$i.'<br>';
    foreach($ingredients->ingredients->id as $curIngredient){ //ici je ne rentre pas
        echo $curIngredient['name'].'<br>';
    }
}

/*
include('config/config.php'); 
$cpt=array();
$word="";
$true=strripos("Kiwi fruit",$word);
echo($true);


$reponse=$bdd->prepare('SELECT * FROM ingredient WHERE Idingredient=?');
$reponse->execute(array($word));
$donnes=$reponse->fetch();
print_r($donnes);

/*if($cpt[0]==0){
	echo("oui");
	//array_push($savebadingredients,$saveingredients[$i]);
}
$reponse->closeCursor();
/*
$file='D:\xampp\htdocs\recipe\text/spicies.txt';
$banane="Banane"; 

$listid=array();
$listingredient=array();
$reponse = $bdd->query('SELECT * FROM ingredient');
// $donnes=$reponse->fetch();
// print_r($donnes)
while($donnes=$reponse->fetch()){
	array_push($listid, $donnes['Idingredient']);
	array_push($listingredient, $donnes['Name']);
}
$reponse->closeCursor();

$sameid=array(); 
$names=array();
for($i=0; $i<count($listid);$i++){
	for($j=0;$j<count($listid);$j++){
		if($j!=$i){
			if(strcmp($listid[$i],$listid[$j])==0){
				array_push($sameid,$listid[$j]); 
				array_push($names,$listingredient[$j]); 	
			}
		}
	}
}
print_r($names);?> </br> <?php
print_r($sameid);
$currentId=$sameid[0];
$cpt=1;
for($i=0;$i<count($names);$i++){
	if(strcmp($currentId,$sameid[$i])==0){
		$cpt++;
		$sameid[$i]=substr($sameid[$i],0,3)."".$cpt;
	}
	else{
		$currentId=$sameid[$i];
		$cpt=2;
		$sameid[$i]=substr($sameid[$i],0,3)."".$cpt;
	}
}
?>
</br>
<?php
print_r($sameid);

for($i=0;$i<count($names);$i++){
	$reponse = $bdd->prepare('UPDATE ingredient SET Idingredient=:idingredient WHERE Name=:name');
	$reponse->execute(array(
		'idingredient' => $sameid[$i],
		'name' => $names[$i]
	)); 
	$reponse->closeCursor();
}
/*
if(is_file($file)){
		if($tablines=file($file)){
			for($i=1;$i<count($tablines);$i++){		
				$reponse = $bdd->prepare('UPDATE ingredient SET Description=:description WHERE Name=:name');
				$reponse->execute(array(
						'description' => "spicy",
						'name' => $tablines[$i]
					)); 
				$reponse->closeCursor();
				
				/*$req = $bdd->prepare('INSERT INTO ingredient(Name, Description, Idingredient) VALUES(:name, :description, :idingredient)');
				$req->execute(array(
					'name' => $tablines[$i],
					'description' => "spicy",
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