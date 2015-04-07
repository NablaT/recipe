
<?php 
//On d�marre la session 
session_start();
$isconnected=true;
// On r�cup�re nos variables de session
if (isset($_SESSION['login'])) {
		//On v�rifie bien que la personne connect�e est un admin.
		if(strcmp($_SESSION['type'],'admin')!=0 && strcmp($_SESSION['type'],'user')!=0){
			//print_r($_SESSION);
			// Le visiteur n'a pas �t� reconnu comme �tant un admin de notre site. On utilise alors un petit javascript lui signalant ce fait
			echo '<body onLoad="alert(\'Vous ne pouvez acc�der � cette page par manque de droits\')">';
			// puis on le redirige vers la page d'accueil
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
			$isconnected=false;
		}
		
		session_cache_limiter('private_no_expire, must-revalidate');
		// On teste pour voir si nos variables ont bien �t� enregistr�es
}
else {
		echo '<body onLoad="alert(\'Veuillez vous connecter pour acc�der � cette page\')">';
			// puis on le redirige vers la page d'accueil
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
		$isconnected=false;
}

?>