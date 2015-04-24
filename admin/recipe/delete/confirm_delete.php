 

<?php 
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include ('../../../config/config.php');
	if($_GET['confirm']){	
		deleterecipe($bdd);
		include('../../../text/recipe/managerecipe_text.php');
		?>
		<!DOCTYPE>
		<html lang="en">
		<head>
			<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
			<title><?php echo($deleterecipe);?></title>
			<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

		</head>
		<body>
		<h2> <?php echo($errorrecipe1." ".$_GET['name']." ".$successdelete);?></h2>
		<a href="delete_recipe.php"><?php echo($previouspage);?></a>
		<a href="../../manageRecipe.php"><?php echo($home);?></a>
		<?php
	}
	else{
		
	}
}

function deleterecipe($bdd){
	$reponse=$bdd->prepare('DELETE FROM recipe WHERE Name=?');
	$reponse->execute(array($_GET['name']));
	$reponse->closeCursor();
	
	$reponse=$bdd->prepare('DELETE FROM recipestep WHERE Name=?');
	$reponse->execute(array($_GET['name']));
	$reponse->closeCursor();
}
?>
</body>
</html>