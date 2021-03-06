<?php

include ('../config/isconnected.php');
include('../config/config.php');
print_page($bdd);

/**
* This function display the page.
**/
function print_page($bdd){
	include('../text/menufindme_text.php');
	$step=0;
	if(count($_GET)!=0){
		$step=$_GET['step']+1;
		savepreviousresults($bdd);
	}
	else{
		cleanCurrentChoices($bdd);
	}
	$choices=getNewChoice($bdd);
	
	if(count($choices)==0){
		$codeRecipe=getCodeRecipe($bdd);
		cleanCurrentChoices($bdd);
		?>
		<html>
			<head>
			<title>Redirection</title>
				<meta http-equiv="refresh" content="0.00000005; URL=recipelist.php?code=<?php echo($codeRecipe);?>">
			</head>
			<body>
		</body>
		</html> 
		<?php
	}
	else{
		$code="";
		if(count($_GET)!=0){
			$code=getCodeRecipe($bdd);
		}
		
		?>
		<html lang="en">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
				<title> <?php echo($title);?></title>
				<link rel="stylesheet" type="text/css" href="../css/findmerecipe/button.css">

			</head>
			<body>
			
		<div class="radio">
			<form method="post" action="index.php?step=<?php echo($step);?>">
			<input type="radio" name="rdo" id="yes" value="<?php echo($choices[0]);?>" checked />
			<input type="radio" name="rdo" id="no" value="<?php echo($choices[1]);?>" />
			<div class="switch">
				<label for="yes"><h1><?php echo($choices[0]);?></h1></label>
				<label for="no"><h1><?php echo($choices[1]);?></h1></label>
				<span></span>
			</div>
			<input type="submit" name="validate" value="<?php echo($validate);?>" />
		</form>
		</div>
		<br/>
			<a class="recipelist" id="recipelist" href="recipelist.php?code=<?php echo($code);?>"><?php echo($recipeList);?></a><br/>
			<a class="previouspage" id="previouspage" href="../menu.php"><?php echo($previousPage);?></a>
		</body>
		<?php
	}
}

/**
* Function currentChoices clean the table currentchoices in the database. 
**/
function cleanCurrentChoices($bdd){
	$reponse=$bdd->query('DELETE FROM currentchoices');
	$reponse->closeCursor(); 
}
/**
* The function returns the code corresponding to all choices made by user.
**/
function getCodeRecipe($bdd){
	$req = $bdd->query('SELECT * FROM currentchoices');
	$code="";
	$i=0;
	while($donnes=$req->fetch()){
		if($i==0) $code=$donnes['Name'];
		else $code=$code."-".$donnes['Name'];
		$i++;
	}
	return $code;
}

/**
* This function returns two new choices for users. 
**/
function getNewChoice($bdd){
	$step=0;
	$father="";
	$choices=array();
	if(count($_GET)!=0){
		if(lastStep($bdd)){
			return $choices; 
		}
		$step=$_GET['step']+1;
		$father=$_POST['rdo'];
		$idfather=getIdFather($bdd,$father);
		$req = $bdd->prepare('SELECT * FROM categorymenu WHERE Father=?');
		$req->execute(array($idfather));
		while($donnes=$req->fetch()){
			array_push($choices, $donnes['Name']);
		}
		$req->closeCursor(); 
		return $choices;
	}
	$req = $bdd->prepare('SELECT * FROM categorymenu WHERE Step=?');
	$req->execute(array($step));
	while($donnes=$req->fetch()){
		array_push($choices, $donnes['Name']);
	}
	$req->closeCursor(); 
	
	return $choices;
}

/**
* Function lastStep verifies if the previous step was the last one and return a boolean. 
**/
function lastStep($bdd){
	$step=$_GET['step']+1;
	$father=$_POST['rdo'];
	$idfather=getIdFather($bdd,$father);
	$req = $bdd->prepare('SELECT COUNT(*) FROM categorymenu WHERE Father=?');
	$req->execute(array($idfather));
	$donnes=$req->fetch();
	if($donnes[0]==0) return true;
	return false; 
}

/**
*
**/

function getIdFather($bdd, $father){
	$req= $bdd->prepare('SELECT * FROM categorymenu WHERE Step=? AND Name=?');
	$req->execute(array($_GET['step'],$father));
	$donnes=$req->fetch();
	return $donnes['Id'];
}
/**
* This function save choices  made by users in the FindMeRecipe functionality in the database.
**/
function savepreviousresults($bdd){
	$date=getdate();
	$day=$date["mday"];
	$month=$date["mon"];
	$year=$date["year"];
	$finaldate=$day."/".$month."/".$year;
	$req = $bdd->prepare('INSERT INTO history(Name, Step,Date) VALUES(:name, :step,:date)');
	$req->execute(array(
		'name' => $_POST['rdo'],
		'step' => $_GET['step'], 
		'date'=>$finaldate
	));
	$req->closeCursor();
	$req = $bdd->prepare('INSERT INTO currentchoices(Name, Step) VALUES(:name, :step)');
	$req->execute(array(
		'name' => $_POST['rdo'],
		'step' => $_GET['step'], 
	));
	$req->closeCursor();
}

?>