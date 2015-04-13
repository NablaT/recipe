<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title>Suppression formulations</title>
	<link rel="stylesheet" type="text/css" href="analyse.css">

</head>
<body>

<?php 
include 'isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
?>
<h2> Suppression d'une formulation </h2>
<form method="post" action="verify_delete.php">
    <p>
        <label>Nom de la formulation</label> : <br/><input type="text" name="nom" id="nom"/>
		<br/>
    </p>
	<input type="submit" value="Supprimer" />
</form>

<a href="menu_admin.php"> Retour menu </a>
<?php
}
?>
</body>
</html>