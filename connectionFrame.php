<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
<title>Connexion</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>


<?php 
//We start the session
session_start();
$isconnected=true;
// We get back our session variables
if (isset($_SESSION['login'])) {
		//We verify user types
		if(strcmp($_SESSION['type'],'admin')!=0 && strcmp($_SESSION['type'],'user')!=0){
			print_page();
		}
		else if(strcmp($_SESSION['type'],'admin')==0){
			header('location:menu.php');
		}
		else if(strcmp($_SESSION['type'],'user')==0){
			header('location:menu.php');
		}
}
else {
		print_page();
}



function print_page(){
	?>
		<div class="container">
		  <div class="login">
			<h1>Connexion</h1>
			<form action="config/login.php" method="post" class="label-top">
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
