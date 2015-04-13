<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title>Mis à jour densité</title>
	<link rel="stylesheet" type="text/css" href="analyse.css">

</head>

<?php 
include 'isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
?>
<body>
<h2> Edition d'une formulation</h2>
<form method="post" action="modify_formu.php">
    <p>
        <label>Nom de la formulation </label> : <br/><input type="text" name="nom" id="nom"/>
		<br/>
    </p>
	<input type="submit" value="Continuer" />
</form>
<a href="index.php"> Retour menu </a>
<?php
}
?>
</body>
</html>