<?php

include("chien.inc");
include('config.php');

$login = $_POST['login'];
$pwd = $_POST['pwd'];
?>

<?php
	
	$num=0;
    @mysql_connect($serveurBD,
                 $nomUtilisateur,
                 $motDePasse) 
      or die("Impossible de se connecter au serveur de bases de données.");
    @mysql_select_db($baseDeDonnees)
      or die("Cette base de donnees n'existe pas");

	//$sql='SELECT count(*) FROM contact WHERE login="'.mysql_escape_string($_POST['login']).'"AND password='.mysql_escape_string($_POST['pwd']);
	$sql="SELECT * FROM contact WHERE login='$login' AND password='$pwd'";

	//$sql='SELECT count(*) FROM contact WHERE login"'.
	$retour = mysql_query($sql);
    if ($retour === FALSE) {
        echo "La requête SELECT a échoué.";
    }else {

       $num = mysql_num_rows($retour);
}


mysql_close();

// We are testing if or variables are defined
if (isset($_POST['login']) && isset($_POST['pwd'])) {
		// We verify form informations: login/password correct.
		if ($num > 0 ){
				// In that case, everything is okay, we can start session
				
				// We start it
				session_start ();
				// We save users paramters as session variables ($login et $pwd) 
				$_SESSION['pwd']=$_POST['pwd'];
				$_SESSION['login']=$_POST['login'];
				$req=$bdd->prepare('SELECT * FROM contact WHERE login=? AND password=?');
				$req->execute(array($_POST['login'],$_POST['pwd']));
				$donnes=$req->fetch();
				$req->closeCursor();
				$_SESSION['type']=$donnes['type'];
				print_r($_SESSION);
			if (strcmp($_SESSION['type'],"admin")==0) {
			header ('location:menu_admin.php');
			}else{
			header ('location:menu_user.php');
			}


		}
		else {
			
			// User hasn't been recognized as member
			echo '<body onLoad="alert(\'Membre non reconnu, veuillez vérifier votre login et password\')">';
			// Then we redirect him to login page.
			echo '<meta http-equiv="refresh" content="0;URL=../connectionFrame.php">';

		}
}
else {
		echo 'Vous devez saisir votre login et votre mot de passe';
}
?>