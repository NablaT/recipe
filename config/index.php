<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
<title>Connexion</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>


<?php 
//On d�marre la session 
session_start();
$isconnected=true;
// On r�cup�re nos variables de session
if (isset($_SESSION['login'])) {
		//On v�rifie bien que la personne connect�e est un admin.
		if(strcmp($_SESSION['type'],'admin')!=0 && strcmp($_SESSION['type'],'user')!=0){
			print_page();
		}
		else if(strcmp($_SESSION['type'],'admin')==0){
			header('location:../menu.php');
		}
		else if(strcmp($_SESSION['type'],'user')==0){
			header('location:../menu.php');
		}
		// On teste pour voir si nos variables ont bien �t� enregistr�es
}
else {
		print_page();
}



function print_page(){
	?>
		<div class="container">
		  <div class="login">
			<h1>Connexion</h1>
			<form action="login.php" method="post" class="label-top">
			  <p><input type="text" name="login" value="" placeholder="Identifiant"></p>
			  <p><input type="password" name="pwd" value="" placeholder="Mot de passe"></p>
			  <p class="submit"><input type="submit" name="commit" value="Se connecter"></p>
			</form>
		  </div>
		</div>
	<?php 
}
?>
</body>
</html>
