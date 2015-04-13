<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> Menu des anciennes formulations</title>
	<link rel="stylesheet" type="text/css" href="formu.css">

</head>
<body>
<?php 
include 'isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
?>

<h2> Menu des anciennes formulations</h2>

<div id="wrapper">
 
    <ul class="menu">
        <li class="item1"><a href="add_old_formu.php">Ajouter une formulation</a></li>
        <li class="item2"><a href="edit_old_formu.php">Editer une formulation </a></li>
        <li class="item3"><a href="delete_old_formu.php">Supprimer une formulation</a></li>
		<li class="item3"><a href="choice_list_oldformu.php">Liste des anciennes formulations</a></li>
		<li class="item3"><a href="linknewold.php">Relier une nouvelle formulation à une ancienne</a></li>
		<li class="item4"><a href="menu_admin.php"> Retour menu</a></li>

	</ul>
 
</div>
<?php
}
?>
</body>
</html>